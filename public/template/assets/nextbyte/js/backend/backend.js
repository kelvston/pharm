/**
 * Allows you to add data-method="METHOD to links to automatically inject a form
 * with the method on click
 *
 * Injects a form with that's fired on click of the link with a DELETE request.
 * Good because you don't have to dirty your HTML with delete forms everywhere.
 */
function addDeleteForms() {
    $("[data-method='delete']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='POST' name='confirm_item' style='display:none'>\n   <input type='hidden' name='_method' value='" + $(this).attr("data-method") + "'>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function addConfirmForms() {
    $("[data-method='confirm']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='get' name='confirm_item' style='display:none'>\n   <input type='hidden' name='_method' value=''>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function addConfirmPostForms() {
    $("[data-method='confirm_post']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='post' name='confirm_item' style='display:none'>\n   <input type='hidden' name='_method' value='post'>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function addPostForms() {
    $("[data-method='post']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='post' name='post_item' style='display:none'>\n   <input type='hidden' name='_method' value='post'>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}
/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {
    /**
     * Generic confirm form delete using Sweet Alert
     */
    $('body').on('submit', 'form[name=confirm_item]', function (e) {
        e.preventDefault();
        var form = this;
        var link = $(e.target).closest("a");
        var cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : "Cancel";
        var confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : "Yes, delete";
        var title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "Warning";
        var text = (link.attr('data-trans-text')) ? link.attr('data-trans-text') : "Are you sure?";
        var choice = (link.attr('data-choice')) ? link.attr('data-choice') : "0";
        var type = (link.attr('data-type')) ? link.attr('data-type') : "warning";
        var confirm_button_color = (link.attr('confirm-button-color')) ? link.attr('confirm-button-color') : "#DD6B55";

        swal({
            title: title,
            text: text,
            type: type,
            showCancelButton: true,
            cancelButtonText: cancel,
            confirmButtonColor: confirm_button_color,
            confirmButtonText: confirm,
            closeOnConfirm: true
        }, function (confirmed) {
            if (confirmed) {
                switch (choice) {
                    case "1":
                        /* Additional implementation to be added here */

                        break;
                    case "2":
                        /* Additional implementation to be added here ... */

                        form.submit();
                        break;
                    default:
                        form.submit();

                }
            }
        });
    });
});
/*
$(document).ajaxComplete(function () {
    addDeleteForms();
    addConfirmForms();
});
*/
$(function () {
    addDeleteForms();
    addConfirmForms();
    addPostForms();
    addConfirmPostForms();
});
