$(function () {
    //Checks checkboxes for dependencies
    $("input[name='permission_user[]']").change(function () {
        checkDependencies($(this));
        uncheckDependencies($(this));
    });

    //Recursively check dependencies
    function checkDependencies(item) {
        var dependencies = item.data('dependencies');
        var count = 0;

        if (dependencies.length) {
            for (var i = 0; i < dependencies.length; i++) {
                if (item.is(":checked")) {
                    var permission = $("#permission-" + dependencies[i]);

                    if (!permission.is(":checked"))
                        permission.prop("checked", true);

                    count++;

                    if (count == 1)
                        checkDependencies(permission);
                }
            }
        }
    }

    //Recursively uncheck dependencies if the depending dependency is unchecked.
    function uncheckDependencies(item) {
        var dependencies = item.data('backdependencies');
        var count = 0;
        if (dependencies.length) {
            for (var i = 0; i < dependencies.length; i++) {
                if (item.is(':not(:checked)')) {
                    var permission = $("#permission-" + dependencies[i]);
                    if (permission.is(":checked"))
                        permission.prop("checked", false);
                    count++;
                }
            }

        }
    }

    $(".search-select").select2({});

});