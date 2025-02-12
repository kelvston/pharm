var tree = $('#workflow-tree');
var users_select = $('select[name="users_select[]"]');
var users_form = $("#users_form");

$(function () {
    tree.jstree({
        "core" : {
            "animation" : 1,
            "check_callback" : true,
            "themes" : { "stripes" : true }
        },
        "plugins" : [
            "state", "wholerow"
        ]
    });

    users_form.submit(function(event) {
        event.preventDefault();
        $(".btn-success").prop("disabled", true);
        var $form = $( this ),
            users = users_select.val(),
            definition = $form.find( "input[name='wf_definition_id']" ).val(),
            posting = $.post( url + "/workflow/update/" + definition, { users: users, _method : "PATCH" } );
        posting.done(function( data ) {
           /* console.log(data); */
                $.amaran({
                    'theme'     :'awesome success',
                    'content'   :{
                        title:'Success!',
                        message:'User(s) added to the selected workflow level!',
                        info:'',
                        icon:'fa fa-check-square-o'
                    },
                    'position'  :'bottom left',
                    'outEffect' :'slideBottom',
                    'inEffect'  :'slideLeft'
                });
            $(".btn-success").prop("disabled", false);
        });
    });

    var dualListBox = users_select.bootstrapDualListbox({
        nonSelectedListLabel: 'Non-selected Users',
        selectedListLabel: 'Selected Users',
        moveOnSelect: false,
        filterPlaceHolder: 'Search User',
        eventMoveAllOverride: true
    });

    tree.on("select_node.jstree", function (e, data) {
        $("#wf_definition_id").val(data.node.id);
        $(".removeall").trigger("click");
        if ($.isNumeric(data.node.id)) {
            $.get(url + "/workflow/get_users/" + data.node.id, function (data) {
                $.each(data, function (index, value) {
                    $('.users_select option[value=' + value + ']').prop('selected', true);
                });
            }).done(function () {
                $(".move").trigger("click");
            });
        }

    });

});
