<h1><?php __("Create your account"); ?></h1>
<?php
echo $form->create('User', array('action' => 'register'));

echo $form->input('firstname',
     array(
     'maxLength' => 255,
     'error' => array(
          'length' => __('Mimimum 2 characters long',true), 
          'notempty' => __('Enter your first name',true)
     ),
     'label' => __('Firstname', true)
));

echo $form->input('lastname',
     array(
     'maxLength' => 255,
     'error' => array(
          'length' => __('Mimimum 2 characters long',true), 
          'notempty' => __('Enter a firstname',true)
     ),
     'label' => __('Lastname', true)
));

echo $form->input('gender',
     array(
     'before' => __('<label for="gender">Gender</label>', true),
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

echo $form->input('email',
     array(
     'maxLength' => 255,
     'label' => __('E-Mail', true),
     'error' => array( 'message' => __('Enter your E-Mail, please', true)),
));

echo $form->input('password',
     array(
     'type' => 'password',
     'maxLength' => 255,
     'error' => array(
          'length' => __('Mimimum 4 characters long',true), 
          'notempty' => __('Enter a password',true)
     ),
     'label' => __('Password', true)
));

echo $form->input('birthday',
     array(
     'minYear' => '1930',
     'maxYear' => date( 'Y', time() ),
     'label' => __('Birthday', true),
     'error' => array('wrap' => 'div', 'style' => 'color:red')
));

echo $form->input('lactatethreshold',
     array(
	 'class' => 'medium',
     'error' => array( 
        'numeric' => __('Please supply your lactate threshold heart rate',true),
        'greater' => __('Must be at least 120',true),
        'lower' => __('Must be at lower than 220',true),
        'notempty' => __('Enter a maximum heart rate, please',true)
     ),
     'label' => __('Lactate threshold', true)
));

echo $form->input('sport',
     array(
     'class' => 'required',
     'label' => __('Main sport', true),
     'options' => array_merge(array('PICK' => __('pick yours', true)), $sports)
));

echo $form->input('weeklyhours',
     array(
     'class' => 'short',
     'maxLength' => 255,
     'error' => array( 
          'numeric' => __('Please supply the your weekly training hours.', true),
          'greater' => __('Must be at least 0 hours',true),
          'lower' => __('Must be at lower than 60 hours',true),
          'notempty' => __('Enter your weekly available training hours, please',true) 
     ),
     'label' => __('Weekly hours', true)
));

echo $form->input('rookie',
     array(
     'type' => 'checkbox',
     'label' => __('Rookie', true)
));

echo $form->input('tos',
     array(
     'type' => 'checkbox',
     'label' => __('Terms of service', true)
));

echo $form->hidden('id');
echo $form->submit(__('Register',true));

echo $form->end();
?>
<script type="text/javascript">
$(document).ready(function () {
	/**
	 * calculate default lactate treshold value when
	 * the user changes the his year of birth
	 */
	$('#UserBirthdayYear').change(function () {
		var year = this.value;
		var d = new Date();
		var lt = parseInt((220 - (d.getFullYear() - year)) * 0.85);
		$('#UserLactatethreshold').attr('value', lt).effect("highlight", {}, 3000);
	});

	/**
	 * provide a basic number of weekly hours after
	 * the user has selected a sport
	 */
	$('#UserSport').change(function () {
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
		$('#UserWeeklyhours').attr('value', val).effect("highlight", {}, 3000);
	});

	/**
	 * check email address for availability
	 */
	$('#UserEmail').blur(function() {
		var email = $('#UserEmail');
		var loader = jQuery('<img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" class="loader" />');

		if (email.val() != '') {
			email.parent().append(loader);
	        jQuery.post("<?php echo Configure::read('App.serverUrl'); ?>/users/check_email_available",
				{
	            	email: email.val()
	            }, function(response) {
					loader.fadeOut("slow", function () {
						loader.remove();
					});
					if (response == "ok") {
						email.addClass('form-ok');
						email.removeClass('form-error');
					} else {
						email.addClass('form-error');
						email.removeClass('form-ok');
					}
	            });
		}
	});

	/**
	 * validation of simple text fields
	 */
	$('#UserFirstname, #UserLastname, #UserPassword').blur(function () {
		var field = $(this);
		if (field.val().length >= 2) {
			field.addClass('form-ok');
			field.removeClass('form-error');
		} else {
			field.addClass('form-error');
			field.removeClass('form-ok');
		}
	});

	/**
	 * validation of numeric fields
	 */
	$('#UserLactatethreshold').blur(function () {
		var field = $(this);
		var val = parseInt(field.val());
		if (val > 120 && val < 220) {
			field.addClass('form-ok');
			field.removeClass('form-error');
		} else {
			field.addClass('form-error');
			field.removeClass('form-ok');
		}
	});

	/**
	 * validation of numeric fields
	 */
	$('#UserWeeklyhours').blur(function () {
		var field = $(this);
		var val = parseInt(field.val());
		if (val > 0 && val < 50) {
			field.addClass('form-ok');
			field.removeClass('form-error');
		} else {
			field.addClass('form-error');
			field.removeClass('form-ok');
		}
	});
});
</script>