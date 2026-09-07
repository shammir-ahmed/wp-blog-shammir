// Toggle control
wp.customize.controlConstructor[ 'blogshammir-toggle' ] = wp.customize.Control.extend({
	ready: function() {
		"use strict";

		var control = this;

		// Change the value
		control.container.on( 'click', '.blogshammir-toggle-switch', function() {
			control.setting.set( ! control.setting.get() );
		});
	}
});
