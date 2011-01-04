
                   <fieldset>
                   <legend><?php __('Initiate Payment'); ?></legend>

                   <h2><?php echo $timeinterval; __('-month PREMIUM membership'); ?></h2>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="messagebox">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php

__('Your membership is valid from');
echo ' <b>' . $payed_from . ' ';
__('to');
echo ' ' . $payed_to . '</b>.<br /><br />';
__('After successful subscription your TriCoreTraining-Plans will be generated from');
echo ' <b>' . $payed_from_now . ' ';
__('to');
echo ' ' . $payed_new_to . '</b> ';
__('(including your already payed or free training-interval). You can cancel your subscription at any time and your payments will end after this period.');
echo '<br /><br /><h3>';
__('Your investment');
echo ': ' . $price . ' ' . $currency_code . '</h3>';

/**
if ( $level == 'freemember' )
{
   __('Advertising will be removed. Thanks for becoming a PREMIUM member of TriCoreTraining.com.');
}
**/

__('By clicking the SUBSCRIBE button you also accept these terms and conditions - please read them carefully.'); 

?>
<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>terms-of-service-2/" target="_blank"><?php __('Read our terms and conditions.'); ?></a>

<br /><br />
<?php 

/**
echo '<br /><br />';

?>
                   <div class="messagebox" style="overflow:auto; width: 420px; height: 200px;">
                   <?php echo $this->element('tos'); ?>
                   <br />
                   </div>


<?php

**/
if ( $error == 'address' )
{
?>

<br /><br />
<div class="errorbox">
<?php 

__('Sorry, but we miss your address which we need for your invoice. Please be kind and add it now.');
echo " "; 

echo $html->link(__('Add address',true),array('controller' => 'users', 'action' => 'edit_userinfo', 'id' => $session_userid));

?>
</div>

<?php
} elseif ( $error == 'trial' )
{
?>

            <div class="errorbox">
            <?php __('You can just buy a new subscription if your subscription-period is less than 90 days. Sorry.'); ?>
            </div>

<?php
} else
{
?>
            <form target="paypal" action="https://www.<?php echo $testing; ?>paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick-subscriptions" />

            <!-- product name -->
            <input type="hidden" name="item_name" value="TriCoreTrainingsplan-<?php echo $timeinterval; ?>m" />
            <input type="hidden" name="item_number" value="tctplan-<?php echo $timeinterval; ?>m" />

            <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>" />

            <!-- price of subscription -->
            <input type="hidden" name="a3" value="<?php echo $price; ?>" />
            <!-- billing cycle subscription -->
            <input type="hidden" name="p3" value="<?php echo $timeinterval; ?>" />
            <input type="hidden" name="t3" value="M" />
<?php
if ( $days_to_end > 0 )
{
?>
              <!-- price of trial -->
              <input type="hidden" name="a1" value="0" />
              <!-- amount of days trial -->
              <input type="hidden" name="p1" value="<?php echo $days_to_end; ?>" />
              <!-- days / months / years -->
              <input type="hidden" name="t1" value="D" />
<?php
}
?>
            <input type="hidden" name="no_note" value="1" />
            <?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
              <input type="hidden" name="notify_url" value="http://www.schremser.com/test/paypal.php" />
            <?php } else { ?>              
              <input type="hidden" name="notify_url" value="<?php echo Configure::read('App.serverUrl'); ?>/payments/success/i:n/tid:<?php echo $tid; ?>" />
            <?php } ?>
            <input type="hidden" name="return" value="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:s" />
            <input type="hidden" name="cancel_return" value="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:c">
            <input type="hidden" name="business" value="payment@tricoretraining.com" />
            <!-- recurring payment -->
            <input type="hidden" name="src" value="1" />
            <!-- recurring times -->
            <input type="hidden" name="srt" value="" />
            <input type="hidden" name="sra" value="1" />

            <input type="hidden" name="custom" value="<?php echo $tid; ?>" />
<!--            <input type="hidden" name="invoice" value="<?php echo $invoice; ?>" />-->

            <input type="image" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="">
            <img alt="" border="0" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>

            <?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
            <br /><br />
            For Debugging (only localhost):<br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/notify/?cmd=_notify-validate&mc_gross=0.10&protection_eligibility=Ineligible&address_status=unconfirmed&payer_id=JA6U2C75C2NV8&address_street=Gonzagagasse+11%2F25%0D%0AGentics+Software+GmbH&payment_date=07%3A19%3A28+May+23%2C+2010+PDT&payment_status=Completed&charset=windows-1252&address_zip=1010&first_name=Klaus&mc_fee=0.10&address_country_code=AT&address_name=Klaus+Schremser&notify_version=2.9&subscr_id=I-FVYX869EU1PR&custom=<?php echo $tid; ?>&payer_status=unverified&business=payment%40tricoretraining.com&address_country=Austria&address_city=Wien&verify_sign=An5ns1Kso7MWUdW4ErQKJJJ4qi4-AYXfIKa-SWz.qrl3zxkPiKa8M3t5&payer_email=km.schremser%40gentics.com&txn_id=4K020743F0083711A&payment_type=instant&last_name=Schremser&address_state=&receiver_email=payment%40tricoretraining.com&payment_fee=&receiver_id=TGHR6X4FUYYZW&txn_type=subscr_payment&item_name=TriCoreTrainingsplan-1m&mc_currency=EUR&item_number=tctplan-1m&residence_country=AT&transaction_subject=&payment_gross=&testing=true">notify (payment completed)</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/notify/?cmd=_notify-validatetxn_type=subscr_signup&subscr_id=I-FVYX869EU1PR&last_name=Schremser&residence_country=AT&mc_currency=EUR&item_name=TriCoreTrainingsplan-1m&business=payment%40tricoretraining.com&recurring=1&address_street=Gonzagagasse+11%2F25%0D%0AGentics+Software+GmbH&verify_sign=AiPC9BjkCyDFQXbSkoZcgqH3hpacAD7Sj3NHPfbwgOXOeeS0LcYP5Tap&payer_status=unverified&payer_email=km.schremser%40gentics.com&address_status=unconfirmed&first_name=Klaus&receiver_email=payment%40tricoretraining.com&address_country_code=AT&payer_id=JA6U2C75C2NV8&address_city=Wien&reattempt=1&item_number=tctplan-1m&address_state=&subscr_date=07%3A19%3A26+May+23%2C+2010+PDT&address_zip=1010&custom=<?php echo $tid; ?>&charset=windows-1252&notify_version=2.9&period3=1+M&address_country=Austria&mc_amount3=0.10&address_name=Klaus+Schremser&testing=true">notify (no payment)</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:s">click to success</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:c">click to cancel</a><br />
            <?php } ?>
<?php 
/**
            <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick-subscriptions" />
            <input type="hidden" name="item_name" value="TriCoreTrainingsplan-test-m" />
            <input type="hidden" name="item_number" value="tctplan-test-m" />
            <input type="hidden" name="currency_code" value="<?php echo $currency_code; ?>" />
            <!-- price of subscription -->
            <input type="hidden" name="a3" value="0.10" />
            <!-- billing cycle subscription -->
            <input type="hidden" name="p3" value="1" />
            <input type="hidden" name="t3" value="D" />
            <input type="hidden" name="no_note" value="1" />
            <input type="hidden" name="notify_url" value="http://www.schremser.com/test/paypal.php" />
            <input type="hidden" name="return" value="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:s" />
            <input type="hidden" name="cancel_return" value="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:c">
            <input type="hidden" name="business" value="payment@tricoretraining.com" />
            <input type="hidden" name="src" value="1" />
            <input type="hidden" name="srt" value="" />
            <input type="hidden" name="sra" value="1" />
            <input type="hidden" name="custom" value="<?php echo $tid; ?>" />
            <input type="image" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="">
            <img alt="" border="0" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
**/
?>
<!--//
<p>
DEBUGGING:<br />
<pre>
item_name TriCoreTrainingsplan-<?php echo $timeinterval; ?>m
item_number tctplan-<?php echo $timeinterval; ?>m
currency_code <?php echo $currency_code; ?>

a3 <?php echo $price; ?>

p3 <?php echo $timeinterval; ?>

t3 M
if ( $days_to_end > 0 ) {
days_to_end <?php echo $days_to_end; ?>

a1 0
amount of days trial
p1 <?php echo $days_to_end; ?>

days / months / years
t1 D
}
no_note 1
notify_url <?php echo Configure::read('App.serverUrl'); ?>/payments/notify/
return <?php echo Configure::read('App.serverUrl'); ?>/payments/success/
cancel_return <?php echo Configure::read('App.serverUrl'); ?>/payments/cancel/
custom transaction_id=<?php echo $tid; ?>

invoice <?php echo $invoice; ?>

business payment@tricoretraining.com
recurring payment
src 1
recurring times
srt
sra 1
</pre>
</p>
//-->

<?php
}
?>

                 </fieldset>
<?php

      $this->js_addon = "";

?>