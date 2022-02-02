jQuery( document ).ready(function( $ ) {
    /*------------------------------------------------
                        Latest blog  
    ------------------------------------------------*/
    var LBcontainer = $('#latest-posts .wrapper .section-content');
    var masonry_gallery = $('.grid');
    var LBpageNumber = 1;

    function magpaper_load_latest_posts(){
        LBpageNumber++;

        $.ajax({
            type: "POST",
            dataType: "html",
            url: magpaper.ajaxurl,
            data: {
                action: 'magpaper_latest_posts_ajax_handler',
                LBpageNumber: LBpageNumber,
            },
            success: function(data){
                if( data.length > 0 ){
                    var $container = $('#latest-posts .wrapper .section-content.grid').packery({
                      itemSelector: '.grid-item'
                    });
                    $('.grid').imagesLoaded( function() {
                        var $html = $( data );
                        $container.append( $html );
                        $container.imagesLoaded( function() {
                            $container.packery( 'appended', $html ).packery( 'reloadItems' ).packery( 'layout' );
                        });
                    } );

                        // LBcontainer.append(data);
                        $(".latest-posts-loader").addClass("hide");
                        $("#infinite-handle").removeClass("hide");
                } else {
                    $("#infinite-handle").addClass("hide");
                    $(".latest-posts-loader").addClass("hide");
                }
            },
            error : function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }

        });
        return false;
    }


    $("#infinite-handle").click(function(e){ // When btn is pressed.
        $("#infinite-handle").addClass("hide");
        $(".latest-posts-loader").removeClass("hide");
        magpaper_load_latest_posts();
    });

});