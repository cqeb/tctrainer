
                   <h1><?php __('Change profile'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_userinfo')); ?>
                   <fieldset>
                   <legend><?php __('Fill in your personal information'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <!--<h2><?php __('User profile'); ?></h2>-->

<?php

echo $form->hidden('id');

echo $form->input('firstname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your firstname',true)
     ),
     'label' => __('Firstname', true)
));

echo $form->input('lastname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum of two characters',true), 
          'notempty' => __('Enter your lastname',true)
     ),
     'label' => __('Lastname', true)
));

echo $form->input('gender',
     array(
     'before' => __('Gender', true),
     'after' => '',
     'between' => '',
     'class' => 'required',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

echo $form->input('email',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'label' => __('E-Mail', true),
     'error' => array( 
        'notempty' => __('Enter your E-Mail', true)
     )
));

?>

<span id="usernameLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="usernameResult"></span>

<?php

echo $form->input('birthday',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'minYear' => '1930',
     'maxYear' => '1995',
     'label' => __('Birthday', true)
));

/**
we handle that with mailchimp.com

echo $form->input('newsletter',
                  array(
                  'before' => 'Newsletter',
                  'after' => '',
                  'between' => '',
                  'legend' => false,
                  'type' => 'radio',
                  'multiple' => false,
                  'default' => '1',
                  'options' => array(
                  '1' => 'Yes',
                  '0' => 'No'
     )
));

echo $form->input('youknowus',
                  array(
                  'legend' => false,
                  'label' => 'From where do you know us?',
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => array(
                                'Google' => 'Search engine (i.e. Google)',
                                'Friends' => 'Friends (Word by mouth)',
                                'Competition' => 'Competition (Ads)',
                                'Magazine' => 'Magazine, newspaper',
                                'Ads' => 'Online Ads (Banner)',
                                'Newsletter' => 'Newsletter',
                                'Other' => 'Other'
                  )));
**/

?>

<hr />
<h3><?php __('Contact data'); ?></h3>

<?php

echo $form->input('address',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'label' => __('Address', true)
));

echo $form->input('zip',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'label' => __('ZIP', true)
));

echo $form->input('city',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'label' => __('City', true)
));

// TODO (B) put in global array
echo $form->input('country',
     array(
     'legend' => false,
     'label' => __('Country', true),
     'before' => '',
     'after' => '',
     'between' => '',
     'options' => array(
                    'D' => __('Germany', true),
                    'AT' => __('Austria', true),
                    'AU' => __('Australia', true),
                    'CA' => __('Canada', true),
                    'F' => __('France', true),
                    'GB' => __('United Kingdom', true),
                    'US' => __('United States of America', true),
                    '' => '--------------',
                    'AD' => __('Andorry', true),
                    'AR' => __('Argentina', true),
                    'BE' => __('Belgium', true),
                    'BA' => __('Bosnia', true),
                    'BR' => __('Brazil', true),
                    'BG' => __('Bulgaria', true),
                    'CN' => __('China', true),
                    'HR' => __('Croatia', true),
                    'CY' => __('Cyprus', true),
                    'CZ' => __('Czech Republic', true),
                    'DK' => __('Denmark', true),
                    'EE' => __('Estonia', true),
                    'FI' => __('Finland', true),
                    'GR' => __('Greece', true),
                    'GCA' => __('Guatemala', true),
                    'HK' => __('Hong Kong', true),
                    'HU' => __('Hungary', true),
                    'IN' => __('India', true),
                    'IE' => __('Ireland', true),
                    'IL' => __('Israel', true),
                    'IT' => __('Italy', true),
                    'JP' => __('Japan', true),
                    'ADN' => __('Jemen', true),
                    'LV' => __('Latvia', true),
                    'LI' => __('Liechtenstein', true),
                    'LT' => __('Lithuania', true),
                    'LU' => __('Luxembourg', true),
                    'MT' => __('Malta', true),
                    'NL' => __('Netherlands', true),
                    'NZ' => __('New Zealand', true),
                    'NO' => __('Norway', true),
                    'PE' => __('Peru', true),
                    'PL' => __('Poland', true),
                    'PT' => __('Portugal', true),
                    'RU' => __('Russian Federation', true),
                    'RO' => __('Romania', true),
                    'SK' => __('Slovakia', true),
                    'SI' => __('Slovenia', true),
                    'CH' => __('Switzerland', true),
                    'ZA' => __('South Africa', true),
                    'ES' => __('Spain', true),
                    'SE' => __('Sweden', true),
                    'TW' => __('Taiwan', true),
                    'TR' => __('Turkey', true),
                    'UA' => __('Ukraine', true),
                    'OTH' => __('Other', true)
                  )));

echo $form->input('phonemobile',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'label' => __('Phone', true)
));

/** not finished **/

echo $form->hidden('id');
echo $form->hidden('emailcheck');
//echo $form->hidden('passwordcheck');

?>
<br /><br />

<?php

echo $form->submit(__('Save', true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">


function finishAjax(id, response) {
         \$('#usernameLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

/** initiate JQuery **/

\$(document).ready(function() {

        // check email availability
        \$('#usernameLoading').hide();

	\$('#UserEmail').blur(function(){
                   \$('#usernameLoading').show();
                   \$.post("
EOE;
      $this->js_addon .= Configure::read('App.serverUrl');
      $this->js_addon .= <<<EOF
/users/check_email", {
                       checkuseremail: \$('#UserEmail').val(),
                       checkuserid: \$('#UserId').val()
                   }, function(response){
                       //\$('#usernameResult').fadeOut();
                       setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 400);
                   });
                return false;
	});

        // facebox box
        \$('a[rel*=facebox]').facebox();

});

</script>
EOF;

?>