
     <h1><?php __('TriCoreTraining Dashboard'); ?></h1>

     <?php if ($session->check('Message.flash')) { ?>
     <div class="<?php echo $statusbox; ?>">
     <?php $session->flash(); ?>
     </div><br />
     <?php } ?>

     <div class="errorbox">
     You haven't defined your sport goals. Do this first!
     <br /><br />
     <button name="button" type="button" value="Define goals">Define goals</button>
     </div><br /> 
     
     <div class="clear"></div>

     <h2><?php __('Next steps to use TriCoreTraining'); ?></h2>
     <ol>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/competitions/list_competitions"><?php __('Add your goals'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/trainingplans/view"><?php __('Study and fulfill your training schedule'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl') . Configure::read('App.serverUrl'); ?>/trainingstatistics/list_trainings"><?php __('Track your workouts'); ?></a></li>
       <li><a href="<?php echo Configure::read('App.hostUrl'); ?>/blog/<?php if ( $locale == 'eng' || $locale == '' ) { ?>en<?php } else { ?>de<?php } ?>/"><?php __('Read our FAQs and our blog'); ?></a></li>
     </ol>

     <h2><?php __('Referral'); ?></h2>
<?php
$referral_text[] = __('TriCoreTraining sped up my Half-Ironman time from 06:30 to 05:30 hours. It is awesome. Thanks.', true);
$referral_name[] = 'Klaus-M. Schremser, 35 ys';
$referral_email[] = 'km.schremser@gentics.com';

$referral_text[] = __('10:45 for Ironman in Carinthia was the goal and TriCoreTraining helped me to achieve it. Thank you.', true);
$referral_name[] = 'Clemens Prerovsky, 30 ys';
$referral_email[] = 'c.prerovsky@gmail.com';

$count_referrals = count( $referral_text ) - 1;
$rand_number = rand( 0, $count_referrals );

echo '<span style="width:50px;"><i>"' . 
    $referral_text[$rand_number] . '"</i></span><br /><br />';
echo '<span style="width:50px;"><img border="0" alt="' . $referral_name[$rand_number] . '" src="http://0.gravatar.com/avatar/' . 
    md5( $referral_email[$rand_number] ) . '?s=69&d=identicon" /></span>';
     

?>
     <div class="clear"></div>

<?php
      $this->js_addon = "";
?>