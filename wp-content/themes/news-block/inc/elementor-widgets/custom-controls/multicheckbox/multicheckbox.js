/**
 * Handles the events in multicheckbox control.
 */
 "use strict";

 var multiCheckboxControlView = elementor.modules.controls.BaseData.extend({
     onReady: function () {
        this.saveValue();
     },

     saveValue: function () {
        var elementContainer = this;
        var Container = this.$el;
        var eachControl = Container.find( '#elementor-multicheckbox-control-field .bmm-multicheckbox-control-wrap .bmm-multicheckbox-item' );
        jQuery( eachControl ).find( "input" ).on( "click", function() {
            var values = [];
            jQuery( this ).parent().toggleClass( "isActive" );
            var eachControlActive = Container.find( '#elementor-multicheckbox-control-field .bmm-multicheckbox-control-wrap .bmm-multicheckbox-item.isActive' );
            jQuery( eachControlActive ).each( function() {
                var _this = jQuery( this );
                var newValue  = _this.find( "input" ).val();
                values.push( newValue )
            })
            elementContainer.setValue( values );
        })
    }
 });
 
 elementor.addControlView( 'MULTICHECKBOX', multiCheckboxControlView );