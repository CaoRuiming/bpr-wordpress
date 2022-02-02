/**
 * Redirect to the specific url on section and setting change
 * 
 * @package News Block
 * @since 1.0.0
 */

 (function ( api ) {
    api.section( 'static_front_page', function( section ) {
        news_block_redirect_preview_url( section, api.settings.url.home )
    });

    api.section( 'innerpages_error_page_section', function( section ) {
        news_block_redirect_preview_url( section, api.settings.url.home + '404pagenotfound' )
    });

    api.section( 'innerpages_search_page_section', function( section ) {
        news_block_redirect_preview_url( section, api.settings.url.home + '?s=a' )
    });

    function news_block_redirect_preview_url( section, url ) {
        var previousUrl, clearPreviousUrl, previewUrlValue;
        previewUrlValue = api.previewer.previewUrl;
        clearPreviousUrl = function() {
            previousUrl = null;
        };

        section.expanded.bind( function( isExpanded ) {
            if ( isExpanded ) {
                previousUrl = previewUrlValue.get();
                previewUrlValue.set( url );
                previewUrlValue.bind( clearPreviousUrl );
            } else {
                previewUrlValue.unbind( clearPreviousUrl );
                if ( previousUrl ) {
                    previewUrlValue.set( previousUrl );
                }
            }
        });
    }

    // change preview url to search page on settings change
    // wp.customize( 'search_posts_layout',  function(setting) {
    //     setting.bind(function(value) {
    //         api.previewer.previewUrl.set( api.settings.url.home + '?s=search' );
    //     })
    // });
} ( wp.customize ) );