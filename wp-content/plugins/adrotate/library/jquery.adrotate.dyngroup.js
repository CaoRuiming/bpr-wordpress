/*
Dynamic advert rotation for AdRotate
Version: 1.0.1
Original code: Arnan de Gans
With help from: Mathias Joergensen, Fraser Munro
Copyright: (c) 2020 Arnan de Gans
== Settings ==
groupid : PHP Group ID [integer, defaults to 0]
speed : Time each slide is shown [integer: milliseconds, defaults to 3000]
repeat_impressions : Stop counting impressions? [switch, defaults to Y]
*/
(function($) {
	$.fn.gslider = function(settings) {
		var config = {groupid:0,speed:3000};
		if(settings) $.extend(true, config, settings)

		this.each(function(i) {
			var $cont = $(this);
			var gallery = $(this).children();
			var length = gallery.length;
			var timer = 0;
			var counter = 1;

			if(length == 1) {
				// Impression tracker (Single ad)
	            var tracker = $cont.find(".c-1 a").attr("data-track");
				if(typeof tracker !== 'undefined') {
					impressiontracker(tracker);
				}
			}
			
			if(length > 1) {
				$cont.find(".c-1").show();
				for(n = 2; n <= length; n++) {
					$cont.find(".c-" + n).hide();
				}
				
				timer = setInterval(function(){ play(); }, config.speed);
			}

			function transitionTo(gallery, index) {
				if((counter >= length) || (index >= length)) { 
					counter = 1;
				} else { 
					counter++;
				}
				$cont.find(".c-" + counter).show();

				// Impression tracker (Multiple ads)
	            var tracker = $cont.find(".c-" + counter + ' a').attr("data-track");
				if(typeof tracker !== 'undefined') {
					impressiontracker(tracker);
				}
				$cont.find(".c-" + index).hide();
			}
			
			function play() {
				transitionTo(gallery, counter);
			}

			function impressiontracker(tracker) {
	            admeta = atob(tracker).split(',');
				var name = escape('adrotate-'+admeta[0]);
				var now = Math.round(Date.now()/1000);
				var expired = now - admeta[3];
				var session = sessionStorage.getItem(name); // Get session data

				if(session == null) { // New session, no previous data
					session = 0;
				}

				if(session <= expired) { // Count new impression?
					$.post(impression_object.ajax_url, {'action': 'adrotate_impression','track': tracker});
				    sessionStorage.setItem(name, now);
					delete tracker;
				}
			}
		});
		return this;
	};
}(jQuery));