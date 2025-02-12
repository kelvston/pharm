/**
 * @author Erick Chrysostom <e.chrysostom@nextbyte.co.tz>
 * Check the progress of uploading the contribution data imported.
 */

$(function () {
    setInterval(function(){
        loadLink();
    }, 3000);
});

function loadLink() {
    $('.upload_percent').each(function() {
        /* receipt_code_ (string length is 13) */
        var id_string = this.id;
        var id = id_string.substr(13);
        var percent = $(this).text();
        if (percent !== '100%') {
            /* $("#" + id_string).load( base_url + "/finance/upload_progress/" + id); */
            /*
            $.post( base_url + "/finance/upload_progress/" + id, function( data ) {
                $( "#" + id_string ).html( data );
            }, "text");
            */
        }
    });
}
