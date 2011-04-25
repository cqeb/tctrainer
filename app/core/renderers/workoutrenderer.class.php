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
	public static function render($workouts, $athlete) {
		$html = "<table class=\"workouts\">";
		// overall training length
		$length = 0;
		$trimps = 0;
		foreach ($workouts as $k => $w) {
			if ($w->isLsd()) {
				$star = '<img src="/trainer/img/star.gif" class="lsd" title="'
					. __('This is a special workout for an upcoming long-distance event. These trainings are most important - you should not skip them.', true) 
					. '"/> ';
			} else {
				$star = false;
			}
			$durationHr = self::formatTime($w->getDuration());
			$html .= "
<tr>
	<td class=\"sport\">" . __($w->getSport(), true) . "</td>
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
		}
		
		$html .= "<tr><td class=\"nobg\"></td><td class=\"nobg\"></td>
	<td class=\"duration sum\">" . self::formatTime($length) . "<small>h</small></td>
	<td class=\"trimp sum\">" . $trimps . "<small>TRIMPs</small></td>
</tr>";
		
		$html .= "\n</table>";
		return $html;
	}

	/**
	 * render the mark as done button
	 * @param Workout $w
	 */
	public static function renderCheckButton($w, $athlete, $duration) {
		return '<button title="' . __('Mark training as done', true) .
			'" ' . 
			'data-sportstype="' . $w->getSport() . '" ' .
			'data-duration="' . $duration . ':00" ' .
			'data-workouttype="' . $w->getType() . '" ' .
			'data-avghr="' . $w->getAVGHR($athlete) . '" ' .
			'>&#10003;</button>';
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