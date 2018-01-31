<?php

namespace App\Http\Composers;

use App\Category;
use Illuminate\Contracts\View\View;

/**
 * Description of CategoryWidgetComposer
 *
 * @author hoang.dinh
 */
class CategoryWidgetComposer {
    //put your code here
    
    public function compose (View $view) {
        $categories = Category::get();
        
        $view->with('Categories', $categories);
    }
}
