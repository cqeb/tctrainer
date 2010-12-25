<?php
class DateTimeHelper {
	/**
	 * get difference in weeks
	 * assuming that dateB is in the future, whilst dateA is now (or earlier thant B)
	 * @param DateTime $dateA is the first date
	 * @param DateTime $dateB is the future date
	 * @return ceiled number of weeks
	 */
	public static function diffWeeks(DateTime $dateA, DateTime $dateB) {
		// never use getTimestamp, as it will reduce the date value by one day
		$seconds = $dateB->format("U") - $dateA->format("U");
		return ceil($seconds / 604800); // 60 * 60 * 24 * 7
	}
	
	/**
	 * retrieve the weeks start day for this date (which should be monday for europe
	 * @param DateTime $date the date to calc the week start day for
	 * @return DateTime the according week start date
	 */
	public static function getWeekStartDay(DateTime $date) {
		// 0 is sunday, 6 is saturday
		$day = $date->format("w");
		if ($day < 1) {
			return $date->sub(new DateInterval("P6D"));
		} else if ($day > 1) {
			$offset = $day - 1;
			return $date->sub(new DateInterval("P" . $offset . "D"));
		}
		return $date;
	}
}

?>