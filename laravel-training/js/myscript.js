$(document).ready(function () {
    $('#notify').delay(10000).fadeOut();
});

$(".delete-fnt").click(function () {
    var type = $(this).attr("data-type");
    var id = $(this).attr("data-id");
    var item_name = $("#name_" + id).text();

    $.Notifier("Warning",
            "Do you want to delete this " + type + "?" + "<br><b>\"" + item_name + "\"</b>",
            "warning",
            {
                vertical_align: "center",
                rtl: false,
                btns: [
                    {
                        label: "OK",
                        type: "success",
                        onClick: function () {
                            event.preventDefault();
                            document.getElementById(type + '_' + id).submit();
                            return true;
                        }
                    },
                    {
                        label: "Cancel",
                        type: "default",
                        onClick: function () {
                        }
                    }
                ],
                callback: function () { }
            });
});


//  Hàm xác nhận trước khi xóa, tuy nhiên không đảm bảo tính bảo mật. Vì sử dụng
// onclick và tham số truyền vào
function confirmBeforeDelete(id, notifition_type) {
    var title = $("#post_title_" + id).text();
    $.Notifier("Warning",
            "Do you want to delete this " + notifition_type + "?" + "<br><b>\"" + title + "\"</b>",
            "warning",
            {
                vertical_align: "center",
                rtl: false,
                btns: [
                    {
                        label: "OK",
                        type: "success",
                        onClick: function () {
                            event.preventDefault();
                            document.getElementById(notifition_type + '_' + id).submit();
                            return true;
                        }
                    },
                    {
                        label: "Cancel",
                        type: "default",
                        onClick: function () {
                        }
                    }
                ],
                callback: function () { }
            });

}

function confirmBeforeDelete2(id, notifition_type) {
    $.Notifier("Warning",
            "Do you want to delete this " + notifition_type + "?" + "<br> ABC",
            "warning",
            {
                vertical_align: "center",
                rtl: false,
                btns: [
                    {
                        label: "OK",
                        type: "success",
                        onClick: function () {
                            event.preventDefault();
                            document.getElementById(notifition_type + '_' + id).submit();
                            return true;
                        }
                    },
                    {
                        label: "Cancel",
                        type: "default",
                        onClick: function () {
                        }
                    }
                ],
                callback: function () { }
            });

}