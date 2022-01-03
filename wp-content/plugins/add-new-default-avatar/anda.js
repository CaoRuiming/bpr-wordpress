jQuery(document).ready( function($) {
    var $row = $( document.getElementById('add_new_default_avatar') ).html();
    $( document.getElementById('add_new_default_avatar_add') ).on('click', function (event) {
        event.preventDefault();

        var $row2 = '<p>' + $row + '</p>',
            //get original unique id
            regex = new RegExp( ANDA.uniqid, "g"),
            //replace with time-generated one
            newDate = new Date,
            key = newDate.getTime();

        $row2 = $row2.replace( regex, key );
        $(this).before( $row2 );

    });
});