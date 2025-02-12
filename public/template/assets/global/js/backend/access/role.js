var associated_container = $("#available-permissions");
var tree = $('#permission-tree');

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
    //Check all dependency nodes and disable
    if (check_dependencies) {
        if (object.node) {
            if (object.node.data.dependencies) {
                if (object.node.data.dependencies.length) {
                    var checked = tree.jstree('is_checked', object.node);

                    for (var i = 0; i < object.node.data.dependencies.length; i++) {
                        if (checked) {
                            tree.jstree('check_node', object.node.data.dependencies[i]);
                        }
                    }
                }
            }
            if (object.node.data.backdependancies) {
                if (object.node.data.backdependancies.length) {
                    var checked = tree.jstree('is_checked', object.node);
                    for (var i = 0; i < object.node.data.backdependancies.length; i++) {
                        if (!checked) {
                            tree.jstree('uncheck_node', object.node.data.backdependancies[i]);
                        }
                    }
                }
            }
        }
    }
});

/**
 * Get list of the checked items and send them to the serer
 */
$("#create_role, #edit_role").submit(function () {
    var checked_ids = tree.jstree("get_checked", false);
    $("input[name='permissions']").val(checked_ids);
});