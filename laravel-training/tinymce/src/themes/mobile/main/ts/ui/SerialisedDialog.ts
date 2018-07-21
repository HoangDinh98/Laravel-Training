import { AddEventsBehaviour } from '@ephox/alloy';
import { Behaviour } from '@ephox/alloy';
import { Disabling } from '@ephox/alloy';
import { Highlighting } from '@ephox/alloy';
import { Keying } from '@ephox/alloy';
import { Representing } from '@ephox/alloy';
import { Memento } from '@ephox/alloy';
import { AlloyEvents } from '@ephox/alloy';
import { AlloyTriggers } from '@ephox/alloy';
import { NativeEvents } from '@ephox/alloy';
import { Button } from '@ephox/alloy';
import { Container } from '@ephox/alloy';
import { Form } from '@ephox/alloy';
import { FieldSchema } from '@ephox/boulder';
import { ValueSchema } from '@ephox/boulder';
import { Arr } from '@ephox/katamari';
import { Cell } from '@ephox/katamari';
import { Option } from '@ephox/katamari';
import { Singleton } from '@ephox/katamari';
import { Css } from '@ephox/sugar';
import { SelectorFilter } from '@ephox/sugar';
import { SelectorFind } from '@ephox/sugar';
import { Width } from '@ephox/sugar';
import Receivers from '../channels/Receivers';
import SwipingModel from '../model/SwipingModel';
import Styles from '../style/Styles';
import UiDomFactory from '../util/UiDomFactory';

const sketch = function (rawSpec) {
  const navigateEvent = 'navigateEvent';

  const wrapperAdhocEvents = 'serializer-wrapper-events';
  const formAdhocEvents = 'form-events';

  const schema = ValueSchema.objOf([
    FieldSchema.strict('fields'),
    // Used for when datafields are present.
    FieldSchema.defaulted('maxFieldIndex', rawSpec.fields.length - 1),
    FieldSchema.strict('onExecute'),
    FieldSchema.strict('getInitialValue'),
    FieldSchema.state('state', function () {
      return {
        dialogSwipeState: Singleton.value(),
        currentScreen: Cell(0)
      };
    })
  ]);

  const spec = ValueSchema.asRawOrDie('SerialisedDialog', schema, rawSpec);

  const navigationButton = function (direction, directionName, enabled) {
    return Button.sketch({
      dom: UiDomFactory.dom('<span class="${prefix}-icon-' + directionName + ' ${prefix}-icon"></span>'),
      action (button) {
        AlloyTriggers.emitWith(button, navigateEvent, { direction });
      },
      buttonBehaviours: Behaviour.derive([
        Disabling.config({
          disableClass: Styles.resolve('toolbar-navigation-disabled'),
          disabled: !enabled
        })
      ])
    });
  };

  const reposition = function (dialog, message) {
    SelectorFind.descendant(dialog.element(), '.' + Styles.resolve('serialised-dialog-chain')).each(function (parent) {
      Css.set(parent, 'left', (-spec.state.currentScreen.get() * message.width) + 'px');
    });
  };

  const navigate = function (dialog, direction) {
    const screens = SelectorFilter.descendants(dialog.element(), '.' + Styles.resolve('serialised-dialog-screen'));
    SelectorFind.descendant(dialog.element(), '.' + Styles.resolve('serialised-dialog-chain')).each(function (parent) {
      if ((spec.state.currentScreen.get() + direction) >= 0 && (spec.state.currentScreen.get() + direction) < screens.length) {
        Css.getRaw(parent, 'left').each(function (left) {
          const currentLeft = parseInt(left, 10);
          const w = Width.get(screens[0]);
          Css.set(parent, 'left', (currentLeft - (direction * w)) + 'px');
        });
        spec.state.currentScreen.set(spec.state.currentScreen.get() + direction);
      }
    });
  };

  // Unfortunately we need to inspect the DOM to find the input that is currently on screen
  const focusInput = function (dialog) {
    const inputs = SelectorFilter.descendants(dialog.element(), 'input');
    const optInput = Option.from(inputs[spec.state.currentScreen.get()]);
    optInput.each(function (input) {
      dialog.getSystem().getByDom(input).each(function (inputComp) {
        AlloyTriggers.dispatchFocus(dialog, inputComp.element());
      });
    });
    const dotitems = memDots.get(dialog);
    Highlighting.highlightAt(dotitems, spec.state.currentScreen.get());
  };

  const resetState = function () {
    spec.state.currentScreen.set(0);
    spec.state.dialogSwipeState.clear();
  };

  const memForm = Memento.record(
    Form.sketch(function (parts) {
      return {
        dom: UiDomFactory.dom('<div class="${prefix}-serialised-dialog"></div>'),
        components: [
          Container.sketch({
            dom: UiDomFactory.dom('<div class="${prefix}-serialised-dialog-chain" style="left: 0px; position: absolute;"></div>'),
            components: Arr.map(spec.fields, function (field, i) {
              return i <= spec.maxFieldIndex ? Container.sketch({
                dom: UiDomFactory.dom('<div class="${prefix}-serialised-dialog-screen"></div>'),
                components: Arr.flatten([
                  [ navigationButton(-1, 'previous', (i > 0)) ],
                  [ parts.field(field.name, field.spec) ],
                  [ navigationButton(+1, 'next', (i < spec.maxFieldIndex)) ]
                ])
              }) : parts.field(field.name, field.spec);
            })
          })
        ],

        formBehaviours: Behaviour.derive([
          Receivers.orientation(function (dialog, message) {
            reposition(dialog, message);
          }),
          Keying.config({
            mode: 'special',
            focusIn (dialog/*, specialInfo */) {
              focusInput(dialog);
            },
            onTab (dialog/*, specialInfo */) {
              navigate(dialog, +1);
              return Option.some(true);
            },
            onShiftTab (dialog/*, specialInfo */) {
              navigate(dialog, -1);
              return Option.some(true);
            }
          }),

          AddEventsBehaviour.config(formAdhocEvents, [
            AlloyEvents.runOnAttached(function (dialog, simulatedEvent) {
              // Reset state to first screen.
              resetState();
              const dotitems = memDots.get(dialog);
              Highlighting.highlightFirst(dotitems);
              spec.getInitialValue(dialog).each(function (v) {
                Representing.setValue(dialog, v);
              });
            }),

            AlloyEvents.runOnExecute(spec.onExecute),

            AlloyEvents.run(NativeEvents.transitionend(), function (dialog, simulatedEvent) {
              if (simulatedEvent.event().raw().propertyName === 'left') {
                focusInput(dialog);
              }
            }),

            AlloyEvents.run(navigateEvent, function (dialog, simulatedEvent) {
              const direction = simulatedEvent.event().direction();
              navigate(dialog, direction);
            })
          ])
        ])
      };
    })
  );

  const memDots = Memento.record({
    dom: UiDomFactory.dom('<div class="${prefix}-dot-container"></div>'),
    behaviours: Behaviour.derive([
      Highlighting.config({
        highlightClass: Styles.resolve('dot-active'),
        itemClass: Styles.resolve('dot-item')
      })
    ]),
    components: Arr.bind(spec.fields, function (_f, i) {
      return i <= spec.maxFieldIndex ? [
        UiDomFactory.spec('<div class="${prefix}-dot-item ${prefix}-icon-full-dot ${prefix}-icon"></div>')
      ] : [];
    })
  });

  return {
    dom: UiDomFactory.dom('<div class="${prefix}-serializer-wrapper"></div>'),
    components: [
      memForm.asSpec(),
      memDots.asSpec()
    ],

    behaviours: Behaviour.derive([
      Keying.config({
        mode: 'special',
        focusIn (wrapper) {
          const form = memForm.get(wrapper);
          Keying.focusIn(form);
        }
      }),

      AddEventsBehaviour.config(wrapperAdhocEvents, [
        AlloyEvents.run(NativeEvents.touchstart(), function (wrapper, simulatedEvent) {
          spec.state.dialogSwipeState.set(
            SwipingModel.init(simulatedEvent.event().raw().touches[0].clientX)
          );
        }),
        AlloyEvents.run(NativeEvents.touchmove(), function (wrapper, simulatedEvent) {
          spec.state.dialogSwipeState.on(function (state) {
            simulatedEvent.event().prevent();
            spec.state.dialogSwipeState.set(
              SwipingModel.move(state, simulatedEvent.event().raw().touches[0].clientX)
            );
          });
        }),
        AlloyEvents.run(NativeEvents.touchend(), function (wrapper/*, simulatedEvent */) {
          spec.state.dialogSwipeState.on(function (state) {
            const dialog = memForm.get(wrapper);
            // Confusing
            const direction = -1 * SwipingModel.complete(state);
            navigate(dialog, direction);
          });
        })
      ])
    ])
  };
};

export default {
  sketch
};