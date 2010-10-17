/**
 * the TimeParser will allow for parsing arbitrarily entered time values
 */
TimeParser = {
	/**
	 * contains the parsed time in minutes
	 */
	mins : -1,
	
	/**
	 * parse a provided time string
	 * into minutes
	 * @param string str string to be parsed
	 * @return int minutes
	 */
	parse : function (str) {
		this.mins = -1;
		str = str.replace(/[^,^.^:^0-9]/, "");
		if (str.indexOf(":") != -1) {
			// clock notation 8:30
			var res = str.match(/^(\d+):(\d+).*/);
			this.mins = (parseInt(res[1]) * 60) + parseInt(res[2]);
		} else if (str.indexOf(".") != -1 || str.indexOf(",") != -1) {
			str = str.replace(",", ".");
			// float notation 8.5 or 8,5
			this.mins = parseInt(parseFloat(str) * 60);
		} else {
			// we'll just parse for integer
			this.mins = parseInt(str) * 60;
		}
		
		return this.mins;
	},

	/**
	 * render a beautiful representation of internal minute setting
	 * 130 eg. will become 2:10h
	 * @param int mins minutes to be rendered. optional parameter, this.mins is fallback
	 * @return formatted time string 
	 */
	format : function (mins) {
		if (mins == null) {
			mins = this.mins;
		}
		var h = parseInt(mins / 60);
		var m = mins - (h * 60);
		if (m < 10) {
			m = "0" + m;
		}
		return h + ":" + m + "h";
	}
};