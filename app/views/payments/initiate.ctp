      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php echo $timeinterval . ' '; __('month PREMIUM membership'); ?></h1></div>
        
        <div class="panel-body">

           <fieldset>
           <legend><?php __('Initiate Payment'); ?></legend>

           <?php if ($session->read('flash')) { ?>
           <div class="alert">
           <?php echo $session->read('flash'); $session->delete('flash'); ?>
           </div><br />
           <?php } ?>

<?php

__('Your current membership is valid from');
echo ' <b>' . $paid_from . ' ';
__('to');
echo ' ' . $paid_to . '</b>.<br /><br />';
__('After your subscription is successful, your TriCoreTraining plans will be generated from');
echo ' <b>' . $paid_from_now . ' ';
__('to');
echo ' ' . $paid_new_to . '</b> ';
__('(including your already paid or free training interval). You can cancel your subscription at any time and your payments will end after this period.');
echo '<br /><br /><h3>';
__('Your investment');
echo ': ' . $price . ' ' . $currency_code . '</h3>';

__('By clicking the SUBSCRIBE button you also accept these terms and conditions - please read them carefully.'); 
echo ' ';

?>
            <a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>terms-of-service-2/" target="_blank"><?php __('Read our terms and conditions.'); ?></a>

            <br /><br />
<?php 

if ( $error == 'address' )
{
?>

            <hr />

            <?php echo $form->create('User', array('action' => 'edit_address','class' => 'form-horizontal')); ?>
            <fieldset>
            <legend><?php __('Fill in your personal information'); ?></legend>

            <?php if ($session->read('flash')) { ?>
            <div class="<?php echo $statusbox; ?>">
            <?php echo $session->read('flash'); $session->delete('flash'); ?>
            </div><br />
            <?php } ?>

            <div class="alert alert-danger">
            <?php 

            __('Sorry, but we miss your address which we need for your invoice. Please be kind and add it now.');

            ?>
            </div>

            <br /><br />

<div class="form-group">

<?php

echo $form->hidden('id');

echo $form->input('address',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'maxLength' => 255,
     'label' => __('Address', true)
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('zip',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'maxLength' => 255,
     'label' => __('ZIP', true)
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('city',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'maxLength' => 255,
     'label' => __('City', true)
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('country',
     array(
     'legend' => false,
     'label' => __('Country', true),
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'options' => $countries
));
?>
</div>
<div class="form-group">
<?php
echo $form->input('phonemobile',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required form-control',     
     'maxLength' => 255,
     'label' => __('Phone', true)
));

echo $form->hidden('id');
echo $form->hidden('emailcheck');

?>
</div>
<br /><br />

<?php

echo $form->submit(__('Save', true),array('class' => 'btn btn-primary'));

?>
                 <br />

                 <!--</fieldset>-->

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
EOE;

} elseif ( $error == 'trial' )
{
?>

            <div class="alert alert-danger">
            <?php __('You can only re-new your subscription if your previous subscription period is less than 90 days. Sorry.'); ?>
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

            <!-- billing cycle subscription -->
            <!-- regular price of subscription -->
            <input type="hidden" name="a3" value="<?php echo $price; ?>" />

            <!-- regular amount time  -->
            <input type="hidden" name="p3" value="<?php echo $timeinterval; ?>" />

<?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) { ?>
            <!-- regular subscription day -->
            <input type="hidden" name="t3" value="D" />
<?php } else { ?>
            <!-- regular subscription month -->
            <input type="hidden" name="t3" value="M" />
<?php }
if ( $days_to_end > 0 ) { ?>
              <!-- price of trial period -->
              <input type="hidden" name="a1" value="0" />
              <!-- amount of days trial -->
              <input type="hidden" name="p1" value="<?php echo round($days_to_end); ?>" />
              <!-- days / months / years of trial period -->
              <input type="hidden" name="t1" value="D" />
<?php } ?>
			<!-- no note for subscriber in dialog -->
            <input type="hidden" name="no_note" value="1" />
            
<?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST ) { ?>
            <input type="hidden" name="notify_url" value="https://tricoretraining.com/log/paypal.php" />
<?php } else { ?>
            <input type="hidden" name="notify_url" value="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/payments/notify/lang:<?php echo $locale; ?>/" />
<?php } ?>
            <input type="hidden" name="return" value="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:s/lang:<?php echo $locale; ?>/" />
            <input type="hidden" name="cancel_return" value="<?php echo Configure::read('App.hostUrl'); echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:c/lang:<?php echo $locale; ?>/">
            
            <input type="hidden" name="business" value="<?php echo Configure::read('App.paymentemail'); ?>" />
            
            <!-- recurring payment / 0 = not recurring -->
            <input type="hidden" name="src" value="1" />
            
            <!-- recurring times -->
            <!--input type="hidden" name="srt" value="" /-->
            <!-- recurring attempt -->
            <input type="hidden" name="sra" value="1" />

			<!-- transaction-id -->
            <input type="hidden" name="custom" value="<?php echo $tid; ?>" />

            <input type="image" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit" alt="">
            <img alt="" border="0" src="https://www.<?php echo $testing; ?>paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
			<?php } // end admin ?>
			
<?php if ( $_SERVER['HTTP_HOST'] == LOCALHOST && isset( $tid ) ) { ?>
            <br /><br />
            For Debugging (only localhost):<br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/notify/lang:<?php echo $locale; ?>/?cmd=_notify-validate&mc_gross=0.10&protection_eligibility=Ineligible&address_status=unconfirmed&payer_id=JA6U2C75C2NV8&address_street=Gonzagagasse+11%2F25%0D%0AGentics+Software+GmbH&payment_date=07%3A19%3A28+May+23%2C+2010+PDT&payment_status=Completed&charset=windows-1252&address_zip=1010&first_name=Klaus&mc_fee=0.10&address_country_code=AT&address_name=Klaus+Schremser&notify_version=2.9&subscr_id=I-FVYX869EU1PR&custom=<?php echo $tid; ?>&payer_status=unverified&business=payment%40tricoretraining.com&address_country=Austria&address_city=Wien&verify_sign=An5ns1Kso7MWUdW4ErQKJJJ4qi4-AYXfIKa-SWz.qrl3zxkPiKa8M3t5&payer_email=km.schremser%40gentics.com&txn_id=4K020743F0083711A&payment_type=instant&last_name=Schremser&address_state=&receiver_email=payment%40tricoretraining.com&payment_fee=&receiver_id=TGHR6X4FUYYZW&txn_type=subscr_payment&item_name=TriCoreTrainingsplan-1m&mc_currency=EUR&item_number=tctplan-1m&residence_country=AT&transaction_subject=&payment_gross=&testing=true">notify (payment completed)</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/notify/lang:<?php echo $locale; ?>/?cmd=_notify-validatetxn_type=subscr_signup&subscr_id=I-FVYX869EU1PR&last_name=Schremser&residence_country=AT&mc_currency=EUR&item_name=TriCoreTrainingsplan-1m&business=payment%40tricoretraining.com&recurring=1&address_street=Gonzagagasse+11%2F25%0D%0AGentics+Software+GmbH&verify_sign=AiPC9BjkCyDFQXbSkoZcgqH3hpacAD7Sj3NHPfbwgOXOeeS0LcYP5Tap&payer_status=unverified&payer_email=km.schremser%40gentics.com&address_status=unconfirmed&first_name=Klaus&receiver_email=payment%40tricoretraining.com&address_country_code=AT&payer_id=JA6U2C75C2NV8&address_city=Wien&reattempt=1&item_number=tctplan-1m&address_state=&subscr_date=07%3A19%3A26+May+23%2C+2010+PDT&address_zip=1010&custom=<?php echo $tid; ?>&charset=windows-1252&notify_version=2.9&period3=1+M&address_country=Austria&mc_amount3=0.10&address_name=Klaus+Schremser&testing=true">notify (no payment)</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:s/lang:<?php echo $locale; ?>/">click to success</a><br />
            TEST <a href="<?php echo Configure::read('App.serverUrl'); ?>/payments/show_payments/i:c/lang:<?php echo $locale; ?>/">click to cancel</a><br />
<?php } ?>

                 </fieldset>


        </div>
      </div>

<?php

      $this->js_addon = "";

?>