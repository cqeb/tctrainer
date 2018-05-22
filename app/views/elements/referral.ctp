<?php

if ( isset( $recommendations ) && count( $recommendations ) > 0 && $recommendations[0] )
{
	foreach ( $recommendations as $key => $val )
	{
		$referral_text[] = $val['users']['myrecommendation'];
		$referral_name[] = $val['users']['firstname']; // . ' ' . $val['users']['lastname'];
		$referral_email[] = $val['users']['email'];
	}
}

$referral_text[] = __('TriCoreTraining sped up my Half-Ironman time from 06:30 to 05:30 hours. It is awesome. Thanks.', true);
$referral_name[] = 'Klaus-M.';
$referral_email[] = 'km.schremser@gentics.com';

$referral_text[] = __('10:45 for Ironman in Carinthia was the goal and TriCoreTraining helped me to achieve it. Thank you.', true);
$referral_name[] = 'Clemens';
$referral_email[] = 'c.prerovsky@gmail.com';

$count_referrals = count( $referral_text ) - 1;
$rand_number = rand( 0, $count_referrals );
?>

<!--
<div style="float:left; margin: 10px;"><img width="69" height="69" alt="<?php echo $referral_name[$rand_number]; ?>" src="http://0.gravatar.com/avatar/<?php echo md5( $referral_email[$rand_number] ); ?>?s=69&d=identicon" /></div>
-->
<div><i>"<?php echo $referral_text[$rand_number]; ?>"</i> (<?php echo $referral_name[$rand_number]; ?>)</div>
