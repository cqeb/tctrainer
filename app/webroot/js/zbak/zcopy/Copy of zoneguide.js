/**
 * Generates a table of Zones, which then can be highlighted
 */
ZoneGuide = {
		/**
		 * basic zone factors
		 */
		runZones : [0.66, 0.84, 0.91, 0.96, 1],
		bikeZones : [0.66, 0.80, 0.89, 0.93, 1],
		
		/**
		 * lactate threshold values
		 */
		rlth : 0, // run
		blth : 0, // bike
		
		/**
		 * generate the zone table
		 * @param rlth run lactate threshold
		 * @param blth bike lactate threshold
		 * @param i18n object like
		 * 	{
		 * 		type : "Type",
		 * 		zone : "Zone",
		 * 		run : "Run",
		 * 		bike : "Bike"
		 *  }
		 * @param guideStyle enable guide style for use in trainingplan
		 * @return html table
		 */
		getTable : function(rlth, blth, i18n, guideStyle) {
			this.rlth = rlth;
			this.blth = blth;
			
			var html = '<div id="zoneguide">';
			if (guideStyle) {
				html += '<img class="pointer" src="/trainer/img/zones/pointer.png">';
			}
			html += '<table>' +
				// header
				'<tr>' +
					'<th>' + i18n.sport + '</th>' +
					'<th>' + i18n.zone + ' 1</th>' +
					'<th>' + i18n.zone + ' 2</th>' +
					'<th>' + i18n.zone + ' 3</th>' +
					'<th>' + i18n.zone + ' 4</th>' +
					'<th>' + i18n.zone + ' 5</th>' +
				'</tr>' +
				// run zones
				'<tr class="run">' +
					'<td>' + i18n.run + '</td>';
			for (var zone=1; zone<=5;zone++) {
				html += this.getZoneTD('run', zone);
			}
			html += '</tr>';

			// bike zones
			html += '<tr class="bike">' +
				'<td>' + i18n.bike + '</td>';
			for (var zone=1; zone<=5;zone++) {
				html += this.getZoneTD('bike', zone);
			}
			html += '</tr></table></div>';
			return html;
		},
		
		/**
		 * retrieve zone definition for a given sport
		 * @param sport type of sport. may be "run" or "bike"
		 * @param zone number
		 * @return zone definition like "105-126"
		 */
		getZoneTD : function(sport, zone) {
			var min, max;
			if (sport == "run") {
				min = parseInt((this.runZones[zone - 1] * this.rlth) + 1);
				if (zone < 5) {
					max = parseInt(this.runZones[zone] * this.rlth);
				} else {
					max = "max";
				}
			} else if (sport == "bike") {
				min = parseInt((this.bikeZones[zone - 1] * this.blth) + 1);
				if (zone < 5) {
					max = parseInt(this.bikeZones[zone] * this.blth);
				} else {
					max = "max";
				}
			}
			return '<td class="zone' + zone + '">' + min + '-' + max + '</td>';
		},
		
		/**
		 * attaches the zone guide to zone definition spans
		 */
		attach : function() {
			var zg = jQuery('#zoneguide');
			jQuery('span.zone').mouseover(function (e) {
				var o = jQuery(this);
				// highlight zone
				var zone = o.text().substr(o.text().search(/\d/), 1);
				// remove all other highlights first
				zg.find('.highlight').removeClass('highlight');
				if (o.parent().parent().hasClass("run")) {
					zg.find('.run td.zone' + zone).addClass('highlight');
				} else if (o.parent().parent().hasClass("bike")) {
					zg.find('.bike td.zone' + zone).addClass('highlight');
				}
				// reposition
				var pos = o.offset();
				pos.left += 66;
				pos.top += 24;
				zg.css('top', pos.top)
					.css('left', pos.left)
					.fadeIn();
			}).mouseleave(function () {
				zg.fadeOut('fast');
			});
		}
}