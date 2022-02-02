/**
 * Elementor live preview handler
 * 
 */
 jQuery(document).ready(function() {
    if( window.elementorFrontend ) {
        if( typeof( elementorFrontend.hooks ) != 'undefined' ) {
            /**
             * Slider elementor preview
             * 
             */
            elementorFrontend.hooks.addAction( 'frontend/element_ready/post-carousel.default', function( $scope, $ ) {
                var newID = $scope.find( ".bmm-post-carousel-wrapper" );
                var blockSliderloop = newID.data( "loop" );
                var blockSlidercontrol = newID.data( "control" );
                var blockSlidertype = newID.data( "type" );
                newID.slick({
                    dots: false,
                    arrows: ( blockSlidercontrol == '1' ),
                    infinite: ( blockSliderloop == '1' ),
                    autoplay: false,
                    fade: ( blockSlidertype == '1' ),
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
                    prevArrow: '<span class="prev-icon"><i class="fas fa-chevron-left"></i></span>',
                    nextArrow: '<span class="next-icon"><i class="fas fa-chevron-right"></i></span>',
                });
            });
        }
    }
})