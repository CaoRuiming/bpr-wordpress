/**
 * Theme Info
 * 
 * @package News Block
 * @since 1.4.0
 */

/**
 * Plugin install and activate
 * 
 */
jQuery(document).ready(function($) {
    var ajaxUrl = articleThememInfoObject.ajaxUrl, _wpnonce = articleThememInfoObject._wpnonce
    /**
     * On click
     * 
     */
    $(document).on( "click", ".news-block-importer-action-trigger", function() {
        var _this = $(this);
        plugin_action = _this.data( "action" );
        plugin_process_message = _this.data( "process" );
        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                "action": "news_block_importer_plugin_action",
                "_wpnonce": _wpnonce,
                "plugin_action": plugin_action
            },
            beforeSend: function () {
                if ( plugin_process_message ) {
                    _this.addClass("updating-message");
                    _this.attr( 'disabled', true );
                    _this.hide().html('').fadeIn().html(plugin_process_message);
                }
            },
            success: function(res) {
                console.log(res)
                var info = JSON.parse(res);
                if( info.message ) {
                    _this.hide().html('').fadeIn().html(info.message);   
                }
            },
            complete: function() {
                location.reload();
            }
        })
    })
})