

$(".date_shortcut").click(function(){
    var element_id = this.id;
    var date_shortcut_id = element_id.substr(13);
    getDateRangeShortcut(date_shortcut_id);
});

$("#date_shortcut_select").click(function(){
    var value = element_id_value('date_shortcut_select');
    var date_shortcut_id = value;
    getDateRangeShortcut(date_shortcut_id);


});
/*Get date range shortcut*/
function getDateRangeShortcut(date_shortcut_id)
{
    posting = $.post( base_url + "/report/date_range_shortcut" , {
        // client_id: client_id,
        date_shortcut_id: date_shortcut_id,
        from_date: element_id_value('from_date'),
        _method : "GET" } );
    posting.done(function( data ) {
        //Action/Response
        $('#from_date').val(data.from_date).change();
        $('#to_date').val(data.to_date).change();

        /*Class*/
        $(".date_shortcut_badge").removeClass("tag square-tag tag-success");
        $(".date_shortcut_badge").addClass("tag square-tag tag-default");



        switch(date_shortcut_id)
        {
            /*date shortcut on select*/
            case '6':
            case '7':
            case '8':
            case '9':
            case '10':
            case '12':
                $("#date_shortcut_select").removeClass("tag square-tag tag-default");
                $("#date_shortcut_select").addClass("tag square-tag tag-success");
                break;

            default:
                /*default*/
                $(".date_shortcut").removeClass("tag square-tag tag-success");
                $(".date_shortcut").addClass("tag square-tag tag-default");
                $("#date_shortcut"+date_shortcut_id).removeClass("tag square-tag tag-default");
                $("#date_shortcut"+date_shortcut_id).addClass("tag square-tag tag-success");
                break;

        }

    });
}