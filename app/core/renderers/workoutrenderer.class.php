<?php
/**
 * workout renderer
 * is capable of rendering workouts
 * @author clemens
 */
class WorkoutRenderer {
	/**
	 * render a list of workouts
	 * @param array $workouts array of workouts to be rendered
	 * @param Athlete $athlete
	 */
	public static function render($workouts, $athlete, $notSun) {

		$todaysWeekday = date('l', time());

		$html = "<table class=\"workouts\">";
		// overall training length
		$length = 0;
		$trimps = 0;
		$count_workouts = 0;

		foreach ($workouts as $k => $w) {
			$dayofweek = date('l', $w->getWeekdaydateTS);
			$durationHr = self::formatTime($w->getDuration());

			if ( !isset( $notSun ) || ( $todaysWeekday == $dayofweek ) ) {
				if ($w->isLsd()) {
					$star = '<img src="' . Configure::read('App.hostUrl') . Configure::read('App.serverUrl') . '/img/star.gif" class="lsd" title="'
						. __('This is a special workout for an upcoming long-distance event. These trainings are most important - you should not skip them.', true) 
						. '"/> ';
				} else {
					$star = false;
				}

				$html .= "
				<tr>
					<td class=\"sport\">" . __($w->getSport(), true) . "<br>(" . __($dayofweek, true) . ")</td>
					<td class=\"type " . $w->getShortCategory() . "\">
						$star" . __($w->getTypeLabel(), true) . "<br />
						<span class=\"category br\" title=\"" .
							$w->getCategoryDescription() .		 
							"\">" . __($w->getCategory(), true) . "</span>
							" . self::renderCheckButton($w, $athlete, $durationHr) . "
					<td class=\"duration\">" . $durationHr . "<small>h</small></td>
					<td class=\"trimp\">" . $w->getTRIMP() . "<small>TRIMPs</small></td>
				</tr>
				<tr>
					<td class=\"description " . strtolower($w->getSport()) . "\" colspan=\"4\">
						<div>
							" . $w->getDescription() . "

						</div>
					</td>
				</tr>";
				$length += $w->getDuration();
				$trimps += $w->getTRIMP();
				$count_workouts++;
			}
		}
		
		$html .= "
		<tr><td class=\"nobg\"></td><td class=\"nobg\"></td>
			<td class=\"duration sum\">" . self::formatTime($length) . "<small>h</small></td>
			<td class=\"trimp sum\">" . $trimps . "<small>TRIMPs</small></td>
		</tr>";
		
		$html .= "\n</table>";

		if ( isset( $notSun ) && $count_workouts == 0 ) {
				$html = "<table class=\"workouts\">";
				$html .= "
				<tr><td class=\"nobg\"></td><td class=\"nobg\"></td>
					<td class=\"duration sum\">" . __('Today there are no workouts to plan. Rest, rest, rest.', true) . "</td>
				</tr>";
				$html .= "</table>";			
		}
		return $html;
	}

	/**
	 * save weekdays in database
	 * @param 
	 */
	public function inject_weekdays($workouts, $athlete, $time, $phase, $genWeek, $exportpure = false) {

		$j = 1;
		$weekdays = array();
		$weekdays2 = array();

		// get start of training week
		//$startDayTS = $startdate_ts - ( ( gmdate("w", $startdate_ts) - 1 ) * 86400 );
		$startDayTS = $genWeek->format('U');

		// if there are more than 7 workouts, only 1 day recovery, otherwise 2 days per week
		if ( count( $workouts ) > 7 ) $recovery_days = 1;
		else $recovery_days = 2;

		// TODO IMPROVEMENT - do not inject the same sportstype on the same day
		// TODO IMPROVEMENT - do not inject at the same time!
		
		foreach ($workouts as $k => $w) {

			if ( $recovery_days == 1 ) {
				// start with Sunday
				switch ($j) {
					case 1:
						$dayInt = 7; break;
					case 2:
						$dayInt = 6; break;
					case 3:
						$dayInt = 5; break;
					case 4:
						$dayInt = 1; break;
					case 5:				
						$dayInt = 2; break;
					case 6:
						$dayInt = 4; $j = 0; break;
				}

			} else {
				// start with Sunday
				switch ($j) {
					case 1:
						$dayInt = 7; break;
					case 2:
						$dayInt = 6; break;
					case 3:
						$dayInt = 5; break;
					case 4:
						$dayInt = 2; break;
					case 5:
						$dayInt = 3; $j = 0; break;
				}

			}

			// get date of training day
			$w->getWeekdaydate = gmdate('Ymd', $startDayTS + ( ( ( $dayInt - 1 ) * 86400 ) ) );
			$w->getWeekdaydateTS = $startDayTS + ( ( ( $dayInt - 1 ) * 86400 ) );

			$w->phase = $phase['phase'];

			if ( isset($weekdays[$dayInt]) ) {
				$weekdays[$dayInt] .= WorkoutRenderer::renderIcal($w);
				//echo $dayInt . "<br>\n";
			} else {
				$weekdays[$dayInt] = WorkoutRenderer::renderIcal($w);
				//echo $dayInt . " existiert noch nicht<br>\n";				
			}
				
			// for pure export
			$weekdays2[$dayInt][] = $w;

			$j++;
		}

		ksort($weekdays);		
		ksort($weekdays2);
		
		for ( $m = 1; $m <= 7; $m++ ) {
				for ( $z = 0; $z < count( $weekdays2[$m] ); $z++ ) {
					$weekdays3[] = $weekdays2[$m][$z];
				}
		}

		$weekdays2 = $weekdays3;

		if ( $exportpure == true ) return $weekdays2;
		else return $weekdays;

	}

	/**
	 * render a list of workouts in ical
	 * @param array $workouts array of workouts to be rendered
	 * @param Athlete $athlete
	 */
	public static function render_events($workouts, $athlete, $time, $phase, $genWeek) {
		// overall training length
		$length = 0;
		$trimps = 0;
		$ical_events = "";
		
		$weekdays = WorkoutRenderer::inject_weekdays($workouts, $athlete, $time, $phase, $genWeek);

		foreach ($weekdays as $k => $w) {

			//$length += $w->getDuration();
			//$trimps += $w->getTRIMP();
			$ical_events .= $w;

		}
		
		$icals = 
"BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
" . $ical_events . "
END:VCALENDAR";
	
		//set correct content-type-header
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: inline; filename=tricoretraining.ics');
		
		echo $icals;
		exit;
		//return true;
	}

	/** 
	 * render ical 
	 */
	private function renderIcal(Workout $w) {

			$ical = "";

			$durationHr = self::formatTime($w->getDuration());
			$workout_summary = __($w->getSport(), true) . " " . $durationHr . "h - " . __($w->getTypeLabel(), true);
			$workout_description = "TRIMPs: " . $w->getTRIMP() . " (" . __($w->getCategory(), true) . ") " . 
				$w->getShortCategory() . " - " . $w->getCategoryDescription() . " " . 
				$w->getDescription() . " " . __('Track workouts',true) . " http://www.tricoretraining.com/trainer/trainingstatistics/edit_training";
			if ($w->isLsd()) {
				$workout_description .= "" . __('This is a special workout for an upcoming long-distance event. These trainings are most important - you should not skip them.', true); 
			}

			$yy = gmdate( 'Y', $w->getWeekdaydateTS );
			$mm = gmdate( 'm', $w->getWeekdaydateTS );
			$dd = gmdate( 'd', $w->getWeekdaydateTS );

			$endtime_orig = gmmktime(0, 0, 0, $mm, $dd, $yy);

			//echo self::renderCheckButton($w, $athlete, $durationHr) . "<br />";
			$startdate = $w->getWeekdaydate; // YYYYMMDD
			$starttime = "063000";
			$enddate = $w->getWeekdaydate; // YYYYMMDD
			$endtime = 6.5*3600+($w->getDuration()*60)+$endtime_orig;
			$endtime = gmdate('His', $endtime);

			// DTSTART;TZID=Europe/Vienna:" . $startdate . "T" . $starttime . "Z
			// md5(uniqid(mt_rand(), true))
			$ical = "
BEGIN:VEVENT
UID:" . md5($startdate.$workout_summary) . "@tricoretraining.com
TZID:Europe/Vienna
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:" . $startdate . "T" . $starttime . "Z
DTEND:" . $enddate . "T" . $endtime . "Z
SUMMARY:" . $workout_summary . "
STATUS:CONFIRMED
DESCRIPTION:" . $workout_description . "
END:VEVENT
";
			return $ical;
	}

	/**
	 * render the mark as done button
	 * @param Workout $w
	 */
	public static function renderCheckButton(Workout $w, Athlete $athlete, $duration) {
		$trainingId = $w->getTrainingId();
		if ($trainingId) {
			return '<button title="' . __('See allocated training', true) .
				'" ' . 
				'data-trainingid="' . $trainingId . '"' .
				'>&#10003;</button>';
		} else {
			return '<button title="' . __('Record training as done', true) .
				'" ' . 
				'data-sportstype="' . $w->getSport() . '" ' .
				'data-duration="' . $duration . ':00" ' .
				'data-workouttype="' . $w->getType() . '" ' .
				'data-avghr="' . $w->getAVGHR($athlete) . '"' .
				'>&#10003;</button>';
		}
	}
	
	/**
	 * nicely format a time given in minutes
	 * examples:
	 * 75 will become 1:15
	 * 45 will become 45
	 * 133 will become 2:13
	 * date() can't be used for formatting as different locales (GMT+2 etc...) will vary the output
	 * @param unknown_type $minutes
	 * @return formatted time string
	 */
	public static function formatTime($minutes) {
		// get hours
		$h = intval($minutes / 60);
		// minutes
		$m = $minutes - ($h * 60);
		// zerofill
		if ($m < 10) {
			$m = '0' . $m;
		}
		
		return "$h:$m";
	}
}
?>