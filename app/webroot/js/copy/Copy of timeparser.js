/**
 * the TimeParser will allow for parsing arbitrarily entered time values
 */
TimeParser = {
	/**
	 * contains the parsed time in minutes
	 */
	mins : -1,
	secs : 0,
	
	/**
	 * parse a provided time string
	 * into minutes
	 * @param string str string to be parsed
	 * @return int minutes
	 */
	parse : function (str) {
		if (str.trim) {
			str = str.trim();
		}
		if (str === '') {
			this.mins = 0;
			this.secs = 0;
			return this.mins;
		}
		
		this.mins = -1;
		this.secs = 0;
		str = str.replace(/[^,^.^:^0-9]/, "");
		var secs;
		// check if there are seconds at the end of the string
		if (secs = str.match(/\d+[\.,:]\d+[\.,:](\d+)/)) {
			// seconds do not count for our calculations
			// so they will be stripped if found
			str = str.replace(/[\.,:](\d+)$/, '');
			this.secs = parseInt(secs[1], 10);
		}
		
		if (str.indexOf(":") != -1) {
			// clock notation 8:30
			var res = str.match(/^(\d+):(\d+).*/);
			this.mins = (parseInt(res[1], 10) * 60) + parseInt(res[2], 10);
		} else if (str.indexOf(".") != -1 || str.indexOf(",") != -1) {
			str = str.replace(",", ".");
			// float notation 8.5 or 8,5
			this.mins = parseInt(parseFloat(str)* 60, 10);
		} else {
			// we'll just parse for integer
			var num = parseInt(str, 10);
			// if < 10 we'll treat the value as hours ...
			if (num < 10) {
				this.mins = num * 60;
			} else {
				// otherwise it's minutes
				this.mins = num;
			}
		}
		
		return this.mins;
	},

	/**
	 * render a beautiful representation of internal minute setting
	 * 130 eg. will become 2:10h
	 * @param int mins minutes to be rendered. optional parameter, this.mins is fallback
	 * @param secs if set to true, time will be formatted with seconds
	 * @return formatted time string 
	 */
	format : function (mins, secs) {
		if (mins == null) {
			mins = this.mins;
		}
		
		if (typeof secs == 'number') {
			this.secs = secs;
		}
		
		mins = parseInt(mins, 10);
		
		var h = parseInt(mins / 60, 10);
		var m = mins - (h * 60);
		if (m < 10) {
			m = "0" + m;
		}
		
		if (secs) {
			if (this.secs < 10) {
				this.secs = '0' + this.secs;
			}
			return h + ":" + m + ":" + this.secs;
		} else {
			return h + ":" + m;
		}
	}
};