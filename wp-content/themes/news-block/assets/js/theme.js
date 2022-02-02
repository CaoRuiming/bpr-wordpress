/**
 * Theme Main sript handler file
 * 
 */
jQuery(document).ready(function($) { // on document ready
    var stickey_header_one;
    stickey_header_one  = newsBlockThemeObject.stickeyHeader_one;

    $( window ).on( 'load', function() {
        $( "#news-block-preloader" ).fadeOut( 700, function() {
            // remove preloader item
            $( "#news-block-preloader .news-block-preloader-item" ).hide();
        });
    })

    //trigger the effect on scroll
    if( stickey_header_one ) {
        $('.site-header').waypoint(function(direction) {  
            $('.main-navigation-section-wrap').toggleClass('fixed_header');
        }, { offset: - 0 });
    }
    
    if ($(window).width() > 900){
        jQuery('.the_stickey_class')
          .theiaStickySidebar({
            additionalMarginTop: 90
        });
    }
    
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 800 ) {
            $('#news-block-scroll-to-top').addClass('show');
        } else {
            $('#news-block-scroll-to-top').removeClass('show');
        }
    });

    /**
     * Post carousel block
     * 
     */
     $( ".bmm-post-carousel-wrapper" ).each(function() {
        var parentID = $( this ).parents( ".blaze-mag-modules-post-carousel-block" ).attr( "id" );
        var newID = $( "#" + parentID + " .bmm-post-carousel-wrapper" );
        var blockpostCarouselloop = newID.data( "loop" );
        var blockpostCarouselcontrol = newID.data( "control" );
        var blockpostCarouseltype = newID.data( "type" );
        newID.slick({
            dots: false,
            arrows: ( blockpostCarouselcontrol == '1' ),
            infinite: ( blockpostCarouselloop == '1' ),
            autoplay: false,
            fade: ( blockpostCarouseltype == '1' ),
            slidesToShow: 4,
            responsive: [
                {
                    breakpoint:991,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1
                    }
                  },
                {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1
                    }
                  }
            ],
            prevArrow: '<span class="slickArrow prev-icon"><i class="fas fa-chevron-left"></i></span>',
            nextArrow: '<span class="slickArrow next-icon"><i class="fas fa-chevron-right"></i></span>',
        });
    });

    /**
     * Block Most Viewed tab filter handler
     * 
     */
     $(document).on( 'click', '.tab-title-wrapper li', function() {
        var _this = $(this), parentId, toShowElementClass;
        parentId  =  _this.parents('.bmm-block').attr('id');
        toShowElementClass = _this.data( "id" );
        _this.addClass( "isActive" ).siblings().removeClass( "isActive" );
        $( '#' + parentId + ' .bmm-post-wrapper' ).find( '.' + toShowElementClass ).show().siblings().hide();
      });
});