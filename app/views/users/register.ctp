
    <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __("Sign up for a plan"); ?></h1></div>
        
        <div class="panel-body">

        <?php echo $this->element('js_error'); ?>

        <?php echo $form->create('User', array('action' => 'register', 'class' => 'form-horizontal')); ?>

        <fieldset>
        <legend>
          <?php __('Receive your first trainingplans for free.'); ?>
        </legend>
        

        <?php if ($session->read('flash')) { ?>
        <div class="<?php echo $statusbox; ?>">
        <?php echo $session->read('flash'); $session->delete('flash'); ?>
        </div><br />
        <?php } ?>

        <?php if ( !isset( $session_userid ) ) { ?>
        <a href="/trainer/users/login_facebook/"><img alt="<?php __('Login with your Facebook account!'); ?>" src="/trainer/img/fb-signup.jpg"></a>
        <?php } ?>

        <br /><br /><b><?php __('or'); ?></b><br /><br />

<div class="form-group">
<?php

echo $form->input('firstname',
     array(
     'class' => 'required form-control',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter your firstname',true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     ),
     'label' => array(__('Firstname', true), 'class' => 'control-label')
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('lastname',
     array(
     'class' => 'required form-control',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter your lastname',true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     ),
     'label' => array(__('Lastname', true), 'class' => 'control-label')
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('gender',
     array(
     'class' => 'required checkbox',
     'before' => '<label style="font-weight:bold;" class="gender" for="gender">' . __('Gender', true) . '</label>',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

?>
</div>

<?php

if ( isset( $companyemail ) )
{
	echo "<div class='alert'>";
	__('Please use your company email for registration to receive your company discount!');
	echo ' ';
	__('Your email must end with');
	echo ' ' . $companyemail;
	echo "</div><br />";
}

?>

<div class="form-group">

<?php

echo $form->input('email',
     array(
     'class' => 'required form-control',
     'maxLength' => 255,
     'label' => __('Email', true),
     'error' => array( 
          'notempty' => __('Enter your email', true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     ),
));

echo $form->hidden('emailcheck');

?>
</div>

<span id="usernameLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="usernameResult">

<?php
if ($form->isFieldError('emailcheck'))
{
   echo "<div class=\"text-danger\">";
   __('Your e-mail is already in use!');
   echo "</div><br />";
   //echo $form->error('emailcheck');
}

?>
</span>

<div class="form-group">

<?php

echo $form->input('password',
     array(
     'class' => 'required form-control',
     'type' => 'password',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Minimum 4 characters long',true), 
          'notempty' => __('Enter a password',true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     ),
     'label' => __('Password', true)
));

?>
</div>

<div class="form-group">

<?php

echo $form->input('birthday',
     array(
     'class' => 'required form-control',
     'style' => 'width:75px',
     'minYear' => '1930',
     'maxYear' => date( 'Y', time() )-15,
     'label' => __('Birthday', true),
     'error' => array('wrap' => 'div', 'style' => 'color:red')
));

?>
</div>

<div class="form-group">
<?php 
echo $form->input('typeofsport',
     array(
     'class' => 'required form-control',
     'label' => __('Plans for which type of sport?', true),
     'error' => array( 
          'notempty' => __('Choose your type of sport',true),
          'wrap' => 'div', 
          'class' => 'text-danger'
     ),
     'options' => array_merge(array('' => __('pick yours', true)), $sports)
));

echo $form->hidden('lactatethreshold');
echo $form->hidden('bikelactatethreshold');
echo $form->hidden('weeklyhours');

?>
</div>

<div class="alert alert-info" id="weeklyhours"></div>

<div class="form-group">

<?php

$help_rookie = ' <a class="help badge" title="' . __("You do regular sports for the first time?", true) . '" href="#">?</a>';

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
</div>

<h3><?php __('Security of your personal data'); ?></h3>
<?php __('The security of your personal data especially your health data are important to us. So we have to ask you to read these terms and agree to them. Thank you.'); ?> 
<br /><br />
<div class="form-group">
<b><?php __("You hereby confirm that you've read the TriCoreTraining terms of service and agree."); ?></b>  
<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>terms-of-service-2/" target="_blank"><?php __('Read our terms and conditions.'); ?></a>
</div>

<?php
echo $form->input('tos',
     array(
     'type' => 'checkbox',
     'label' => __('I agree', true),
     'error' => array( 
          'notempty' => __("You HAVE TO agree to our terms and conditions! That's the way you protect our rights :).", true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     )
));
?>

<div class="form-group">
<b><?php __("You also confirm that you have no medical inability to do sports and that we can store personal health data."); ?></b> 
<a href="/blog/<?php if ( $locale == 'deu' ) echo 'de/'; else echo 'en/'; ?>data-privacy-agreement/" target="_blank"><?php __("See chapter 26 in the data privacy agreement."); ?></a>
</div>

<?php
echo $form->input('healthtos',
     array(
     'type' => 'checkbox',
     'label' => __('I agree', true),
     'error' => array( 
          'notempty' => __("You HAVE TO agree to our health agreement!", true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     )
));
?>

<div class="form-group">
<b><?php __("You confirm that we are allowed to send you direct mails including newsletters on a regular base."); ?></b>
</div>

<?php
echo $form->input('mailingtos',
     array(
     'type' => 'checkbox',
     'label' => __('I agree', true),
     'error' => array( 
          'notempty' => __("You HAVE TO agree to our mailing agreement!", true),
          'wrap' => 'div', 
          'class' => 'text-danger'          
     )
));
?>
<br />

<?php

// calculate FREE training period
$paid_from = date( "Y-m-d", time() );
$paid_to = date( "Y-m-d", time() + (TRIAL_PERIOD * 24 * 60 * 60) );
//currently - free registration
//$paid_to = '2012-12-31';

echo $form->input( 'paid_from', array('type' => 'hidden', 'value' => $paid_from));
echo $form->input( 'paid_to', array('type' => 'hidden', 'value' => $paid_to));

echo $form->hidden('id');
echo $form->hidden('inviter');
// for facebook login
echo $form->hidden('activated');

echo $form->submit(__('Sign up',true), array('class'=>'btn btn-primary'));

echo $form->end();

?>

  </div>
</div>

<?php
      $this->js_addon = <<<EOE

<script type="text/javascript">

function finishAjax(id, response) {
         \$('#usernameLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

function setwhrs(whrs) {
      \$('#weeklyhours').show();
      if ( whrs != '' ) {
EOE;
$this->js_addon .= '
          var whrsmsg = "' . __('Weekly training load varies between', true) . '"+" "+Math.round(whrs*0.7)+" "+"' .
            __('and', true) . '"+" "+Math.round(whrs*1.5)+" ' . __('hours',true).'."';
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
  \$('#weeklyhours').hide();
});
</script>
EOF;

?>
