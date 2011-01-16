<h1><?php __("Create your account"); ?></h1>

<?php echo $this->element('js_error'); ?>

<div class="messagebox">
<?php __('Get your trainingplans FREE for 1 month. Then invest less than 3 cups of coffee worth per month for your interactive coach.'); ?>
</div>

<br />
<?php echo $form->create('User', array('action' => 'register')); ?>

<fieldset>
<!--<legend><?php __('Fill in your personal information'); ?></legend>-->

<?php if ($session->check('Message.flash')) { ?>
<div class="<?php echo $statusbox; ?>">
<?php $session->flash(); ?>
</div>
<br />
<?php } ?>

<?php

echo $form->input('firstname',
     array(
     'class' => 'required',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter your firstname',true)
     ),
     'label' => __('Firstname', true)
));

echo $form->input('lastname',
     array(
     'class' => 'required',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter your lastname',true)
     ),
     'label' => __('Lastname', true)
));

echo $form->input('gender',
     array(
     'class' => 'required',
     'before' => '<label for="gender">' . __('Gender', true) . '</label>',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

echo $form->input('email',
     array(
     'class' => 'required',
     'maxLength' => 255,
     'label' => __('E-mail', true),
     'error' => array( 
          'notempty' => __('Enter your e-mail', true)
     ),
));


echo $form->hidden('emailcheck');
?>
<span id="usernameLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="usernameResult">

<?php
if ($form->isFieldError('emailcheck'))
{
   echo "<div class=\"error-message\">";
   __('Your e-mail is already in use!');
   echo "</div>";
   //echo $form->error('emailcheck');
}

?>
</span>

<?php

echo $form->input('password',
     array(
     'class' => 'required',
     'type' => 'password',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 4 characters long',true), 
          'notempty' => __('Enter a password',true)
     ),
     'label' => __('Password', true)
));

echo $form->input('birthday',
     array(
     'class' => 'required',
     'minYear' => '1930',
     'maxYear' => date( 'Y', time() )-15,
     'label' => __('Birthday', true),
     'error' => array('wrap' => 'div', 'style' => 'color:red')
));

?>
<br /><br />
<?php 
echo $form->input('typeofsport',
     array(
     'class' => 'required',
     'label' => __('Main sport', true),
     'error' => array( 
          'notempty' => __('Choose your type of sport',true) 
     ),
     'options' => array_merge(array('' => __('pick yours', true)), $sports)
));


echo $form->hidden('lactatethreshold');
echo $form->hidden('bikelactatethreshold');
echo $form->hidden('weeklyhours');

/*
echo $form->input('lactatethreshold',
     array(
     'class' => 'medium',
     'error' => array( 
        'numeric' => __('Enter your lactate threshold heart rate',true),
        'greater' => __('Must be at least',true) . ' 120',
        'lower' => __('Must be lower than',true) . ' 220',
        'notempty' => __('Enter your lactate threshold heart rate',true)
     ),
     'label' => __('Lactate threshold', true)
));
echo $form->input('bikelactatethreshold',
     array(
     'class' => 'medium',
     'error' => array( 
        'numeric' => __('Enter your bike lactate threshold heart rate',true),
        'greater' => __('Must be at least',true) . ' 120',
        'lower' => __('Must be lower than',true) . ' 220',
        'notempty' => __('Enter your bike lactate threshold heart rate',true)
     ),
     'label' => __('Bike lactate threshold', true)
));
?>
<!--<a target="_blank" href="/blog/en/url....">TODO [?]</a>-->
<?php
echo $form->input('weeklyhours',
     array(
     'class' => 'short',
     'maxLength' => 255,
     'error' => array( 
          'numeric' => __('Enter your weekly available training hours', true),
          'greater' => __('Must be at least',true) . ' 0 ' . __('hours', true),
          'lower' => __('Must be lower than', true) . ' 60 ' . __('hours', true),
          'notempty' => __('Enter your weekly available training hours',true) 
     ),
     'label' => __('Weekly hours', true)
));

*/

?>
<span id="weeklyhours"></span>

<?php

$help_rookie = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="help" title="' .
__("You're training for competitions and do regular sports for the first time?", true) .
'" href="#">?</a>';

echo $form->input('rookie',
                  array(
                  'before' => __('Beginner in structured training?', true),
                  'after' => $help_rookie,
                  'between' => '',
                  'class' => 'required',
                  'label' => '',
                  'legend' => false,
                  'type' => 'checkbox',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
<br />

<b><?php __("You hereby confirm that you've read the TriCoreTraining terms of service and agree. You also confirm that you have no medical inability to do sports!"); ?></b>  
<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>terms-of-service-2/" target="_blank"><?php __('Read our terms and conditions.'); ?></a>
<br /><br />

<?php

echo $form->input('tos',
     array(
     'type' => 'checkbox',
     'label' => __('I agree', true),
     'error' => array( 
          'notempty' => __("You HAVE TO agree to our terms and conditions! That's the way you protect our rights :).", true)
     )
));

// calculate FREE training period
$paid_from = date( "Y-m-d", time() );
$paid_to = date( "Y-m-d", time() + (30*24*60*60) );

echo $form->input( 'paid_from', array('type' => 'hidden', 'value' => $paid_from));
echo $form->input( 'paid_to', array('type' => 'hidden', 'value' => $paid_to));

echo $form->hidden('id');

echo $form->submit(__('Register',true));

echo $form->end();

      $this->js_addon = <<<EOE

<script type="text/javascript">

function finishAjax(id, response) {
         \$('#usernameLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

function setwhrs(whrs) {
      //\$('#UserWeeklyhours')//var whrs = \$('#UserWeeklyhours').val();
  
      if ( whrs != '' ) {
EOE;
$this->js_addon .= '
          var whrsmsg = "<br />' . __('Weekly training load varies between', true) . '"+" "+Math.round(whrs*0.7)+" "+"' .
            __('and', true) . '"+" "+Math.round(whrs*1.5)+" ' . __('hours',true).'.<br /><br />"';
$this->js_addon .= <<<EOE
                      
          //alert(whrsmsg);
          \$('#weeklyhours').html(whrsmsg);
      }
      return false;
}

\$(document).ready(function () {

  /**
	 * provide a basic number of weekly hours after
	 * the user has selected a sport
	 */
	\$('#UserTypeofsport').change(function () {
		var val;
		switch (this.value) {
			case 'TRIATHLON IRONMAN':
			case 'RUN ULTRA':
			case 'BIKE ULTRA':
				val = 12;
				break;
			case 'TRIATHLON HALFIRONMAN':
			case 'RUN MARATHON':
			case 'DUATHLON MIDDLE':
			case 'BIKE LONG':
				val = 8;
				break;
			case 'TRIATHLON OLYMPIC':
			case 'RUN HALFMARATHON':
			case 'DUATHLON SHORT':
			case 'BIKE MIDDLE':
				val = 6;
				break;
			case 'TRIATHLON SPRINT':
			case 'RUN 10K':
			case 'BIKE SHORT':
				val = 5;
				break;
			default:
				val = 4;
				break;
		}

		setwhrs(val);
	});

	/**
	 * check email address for availability
	 */

        // check email availability
        \$('#usernameLoading').hide();

        \$('#UserEmail').blur(function(){
            if ( \$('#UserEmail').val() != '' ) {
                \$('#usernameLoading').show();
                \$.post("
EOE;
      $this->js_addon .= Configure::read('App.serverUrl');
      
      $this->js_addon .= <<<EOF
/users/check_email", 
					{
                       checkuseremail: \$('#UserEmail').val(),
                       checkuserid: \$('#UserId').val()
                   	}, function(response){
                       //\$('#usernameResult').fadeOut();
                       setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 400);
                   	});
              }
              return false;
  		});

	/**
	 * validation of simple text fields
	 */
	\$('#UserFirstname, #UserLastname, #UserPassword').blur(function () {
		var field = $(this);
		if (field.val().length >= 2) {
			field.addClass('form-ok');
			field.removeClass('form-error');
		} else {
			field.addClass('form-error');
			field.removeClass('form-ok');
		}
	});
  
	\$('.help').tipTip();
});
</script>
EOF;

?>