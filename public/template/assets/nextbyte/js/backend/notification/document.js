var tree = $('#document-tree');

/**
 * Initiate the tree and open all items
 * When a node is changed, loop through all of its dependencies
 * and search through the tree to check/uncheck them
 */
var check_dependencies = false;
tree.jstree({
    "checkbox": {
        "keep_selected_style": true
    },
    "plugins": ["checkbox"],
}).on('ready.jstree', function () {
    tree.jstree('open_all');
    tree.jstree('hide_icons');
}).on('ready.jstree', function () {
    check_dependencies = true;
}).on('changed.jstree', function (event, object) {

});

/**
 * Get list of the checked items and send them to the serer
 */
$("#edit_documents").submit(function () {
    var checked_ids = tree.jstree("get_checked", false);
    $("input[name='documents']").val(checked_ids);
});