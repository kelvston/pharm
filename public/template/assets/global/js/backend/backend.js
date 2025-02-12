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
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='POST' name='confirm_item' style='display:none'>\n   <input type='hidden' name='_method' value='post'>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function addPostForms() {
    $("[data-method='post']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='" + $(this).attr("href") + "' method='POST' name='post_item' style='display:none'>\n   <input type='hidden' name='_method' value='post'>\n   <input type='hidden' name='_token' value='" + $('meta[name="_token"]').attr("content") + "'>\n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function addCaseModal() {
    $("[data-method='case_modal']").append(function () {
        return !$(this).find("form").length > 0 ? "\n<form action='#' method='get' name='load_modal' style='display:none'>\n \n</form>\n" : "";
    }).removeAttr("href").attr("style", "cursor:pointer;").attr("onclick", '$(this).find("form").submit();');
}

function confirmDelete(title, text, cancel, confirm, callback) {
    swal({
        title: title,
        text: text,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: cancel,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: confirm,
        closeOnConfirm: true
    }, function (confirmed) {
        if (confirmed) {
            return callback(true);
        } else {
            return callback(false);
        }
    });
}

function sweetAlert(text) {
    swal(text);
}

function showFileCaseModal(link) {
    var file_name = link.attr('data-file-name');
    var file_id = link.attr('data-file-id');

    var create_case_url = link.attr('data-create-case-url');
    $('#add_case_url').attr('href', create_case_url);
    $("#file_case_form").attr('action', link.attr('data-href'));
    $("#file_case_form").attr('method', 'post');
    $('#file_name').html(file_name);
    $('#method').val('post');

    $("#file_case_select").html("").prepend("<option value=''></option>").select2();
    $.get(url + "/file/process/" + file_id + "/cases", function (data) {
        $("#file_case_select").select2({data: data});
    }, "json");
    $('#pick_reason').modal('show');
}
/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {

    $('body').on('submit', 'form[name=post_item]', function ($e) {
        $e.preventDefault();
        var $form = this;
        $form.submit();
    });

    /**
     * Generic confirm form delete using Sweet Alert
     */
    $('body').on('submit', 'form[name=load_modal]', function (e) {
        e.preventDefault();
        var form = this;
        var link = $(e.target).closest("a");
        var choice = (link.attr('data-choice')) ? link.attr('data-choice') : "0";
        switch (choice) {
            case "2":
                /* choosing file case before picking a file*/
                showFileCaseModal(link);
                break;
        }

    });

    $('body').on('submit', 'form[name=confirm_item]', function (e) {
        e.preventDefault();
        var form = this;
        var link = $(e.target).closest("a");
        var cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : "Cancel";
        var confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : "Yes, delete";
        var title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "Warning";
        var text = (link.attr('data-trans-text')) ? link.attr('data-trans-text') : "Are you sure?";
        var choice = (link.attr('data-choice')) ? link.attr('data-choice') : "0";

        swal({
            title: title,
            text: text,
            type: "warning",
            showCancelButton: true,
            cancelButtonText: cancel,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirm,
            closeOnConfirm: true
        }, function (confirmed) {
            if (confirmed) {
                switch (choice) {
                    case "1":
                        /*group confirmation*/
                        var checkedValues = $('input[name="group_choice[]"]:checked').map(function () {
                            return this.value;
                        }).get();
                        if (checkedValues != "") {
                            var input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'group_choice';
                            input.value = checkedValues;
                            form.appendChild(input);
                            form.submit();
                        }
                        break;
                    case "2":
                        /*choosing file case before picking (open a modal after swal)*/
                        /* choosing file case before picking a file*/
                        showFileCaseModal(link);
                        break;
                    default:
                        form.submit();

                }
            }
        });
    });
});
$(document).ajaxComplete(function () {
    /**
     * Add the data-method="delete" forms to all delete links
     */
    addDeleteForms();
    addConfirmForms();
    addCaseModal();
    addPostForms();
});
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content")
    }
});