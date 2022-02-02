/**
 * Handles the events in radio image control.
 */
 "use strict";

 var radioImageControlView = elementor.modules.controls.BaseData.extend({
     onReady: function () {
         this.saveValue();
     },
 
     saveValue: function () {
        var elementContainer = this;
        var Container = this.$el;
        var eachControl = Container.find( '#elementor-radio-image-control-field .bmm-radio-image-control-wrap li' );
        var eachControlPreview = Container.find( '#elementor-radio-image-control-field .bmm-radio-image-control-wrap li .bmm-preview' );
        jQuery( eachControl ).on( 'click', function($) {
            var _this = jQuery( this );
            _this.addClass( "isActive" ).siblings().removeClass( "isActive" );
            var newValue  = _this.data( "value" );
            elementContainer.setValue( newValue );
        });
        jQuery( eachControlPreview ).hover( function($) {
            jQuery(this).next( '.bmm-preview-image-enlarge' ).show();
        }, function() {
            jQuery(this).next( '.bmm-preview-image-enlarge' ).hide();
        });
     }
 });
 
 elementor.addControlView( 'RADIOIMAGE', radioImageControlView );