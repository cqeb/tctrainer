<h1><?php __('Registration - Step 1/2'); ?></h1>

<?php echo $this->element('js_error'); ?>
<?php echo $form->create('User', array('action' => 'add_step1')); ?>
<fieldset>
<legend><?php __('Personal Information'); ?></legend>

<?php if ($session->check('Message.flash')) { ?>
<div class="<?php echo $statusbox; ?>"> <?php $session->flash(); ?></div>
<?php } ?>
<?php

echo $form->input('firstname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter a firstname',true)
     ),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Firstname', true)
));

echo $form->input('lastname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'error' => array(
          'length' => __('Minimum 2 characters long',true), 
          'notempty' => __('Enter a firstname',true)
     ),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Lastname', true)
));

echo $form->input('gender',
     array(
     'before' => __('<label for="gender">Gender</label>', true),
     'after' => '',
     'between' => '',
     'class' => 'required',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
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
     'error' => array( 'email' => __('Enter your E-Mail, please', true)),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
));

echo $form->hidden('emailcheck');
if ($form->isFieldError('emailcheck')){
   echo $form->error('emailcheck');
}
?> <span id="usernameLoading"><img src="<?php echo
Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="" /></span> <span id="usernameResult"></span> <?php

echo $form->input('birthday',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'minYear' => '1930',
     'maxYear' => date( 'Y', time()-86400*365*15 ),
     'label' => __('Birthday', true)
));

?>
<!--//
<?php __('Passwort-Strength') ?> <div id="passwordStrengthDiv" class="is0"></div><br />
//-->

<?php

echo $form->input('password',
     array(
     'type' => 'password',
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'legend' => false,
     'error' => array(
          'length' => __('Mimimum 4 characters long',true), 
          'notempty' => __('Enter a password',true)
     ),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Password', true)
));
?>

<!--// <div class="error-message" id="PWNotMatch"><?php __('Password does not match!') ?></div> -->

<?php
/** not finished **/

echo $form->hidden('id');

echo $form->submit(__('Continue',true));

?> <br />

</fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

// please do not delete this 
/**

\$.fn.passwordStrength = function( options ) {
	return this.each(function(){
		var that = this;
                that.opts = {};
		that.opts = \$.extend({}, \$.fn.passwordStrength.defaults, options);

		that.div = \$(that.opts.targetDiv);
		that.defaultClass = that.div.attr('class');

		that.percents = (that.opts.classes.length) ? 100 / that.opts.classes.length : 100;

		 v = \$(this)
		.keyup(function(){
			if( typeof el == "undefined" )
				this.el = \$(this);
			var s = getPasswordStrength (this.value);
			var p = this.percents;
			var t = Math.floor( s / p );

			if( 100 <= s )
				t = this.opts.classes.length - 1;

			this.div
				.removeAttr('class')
				.addClass( this.defaultClass )
				.addClass( this.opts.classes[ t ] );

		})
		.after('<!--<a href="#">Generate Password</a>-->')
		.next()
		.click(function(){
			\$(this).prev().val( randomPassword() ).trigger('keyup');
			return false;
		});
	});

	function getPasswordStrength(H){
		var D=(H.length);
		if(D>5){
			D=5
		}
		var F=H.replace(/[0-9]/g,"");
		var G=(H.length-F.length);
		if(G>3){G=3}
		var A=H.replace(/\W/g,"");
		var C=(H.length-A.length);
		if(C>3){C=3}
		var B=H.replace(/[A-Z]/g,"");
		var I=(H.length-B.length);
		if(I>3){I=3}
		var E=((D*10)-20)+(G*10)+(C*15)+(I*10);
		if(E<0){E=0}
		if(E>100){E=100}
		return E
	}

	function randomPassword() {
		var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#\$_+";
		var size = 10;
		var i = 1;
		var ret = ""
		while ( i <= size ) {
			\$max = chars.length-1;
			\$num = Math.floor(Math.random()*\$max);
			\$temp = chars.substr(\$num, 1);
			ret += \$temp;
			i++;
		}
		return ret;
	}

};

\$.fn.passwordStrength.defaults = {
	classes : Array('is10','is20','is30','is40','is50','is60','is70','is80','is90','is100'),
	targetDiv : '#passwordStrengthDiv',
	cache : {}
}
**/

function finishAjax(id, response) {
         \$('#usernameLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

/** initiate JQuery **/

\$(document).ready(function() {

EOE;

      $this->js_addon .= '
        var pwokmessage = \'' . __('Passwords match!', true) . '\';
        var pwerrormessage = \'' . __('Hey, watch your fingers typing :). Passwords do not match!', true) . '\';
        ';

      $this->js_addon .= <<<EOE

        // check email availability
        \$('#usernameLoading').hide();

	      \$('#UserEmail').blur(function()
	      {
                   if ( \$('#UserEmail').val() != '' ) 
                   {
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
              }
              return false;
	      });
EOF;

/**
// deactivated by kms

        // check password strength
	      \$('input[name="data[User][password]"]').passwordStrength();

        // check password match
        // hide layer for error message
        \$('#PWNotMatch').hide();
        // if user leaves field with mouse (blur)
        \$('#UserPasswordapprove').blur(function(){

                val1 = \$('#UserPasswordapprove').val();
                val2 = \$('#UserPassword').val();

                // show layer for errormessage
                if ( val1 ) \$('#PWNotMatch').show();

                if ( val1 != val2 ) {
                   \$('#PWNotMatch').html(pwerrormessage);
                   \$('#PWNotMatch').css("color","red");
                   \$('#UserPasswordcheck').val("1");
                   return true;
                } else {
                   \$('#PWNotMatch').html(pwokmessage);
                   \$('#PWNotMatch').css("color","green");
                   \$('#UserPasswordcheck').val("0");
    	           return false;
                }

   });
 * **/

$this->js_addon .= <<<EOG


        // corners
        //\$('#legend').corners();

        // facebox box
        \$('a[rel*=facebox]').facebox();
});

</script>

<style>
.is0{background:url(
EOG;

      $this->js_addon .= Configure::read('App.serverUrl');

      $this->js_addon .= <<<EOH
/img/progressImg1.png) no-repeat 0 0;width:138px;height:7px;}
.is10{background-position:0 -7px;}
.is20{background-position:0 -14px;}
.is30{background-position:0 -21px;}
.is40{background-position:0 -28px;}
.is50{background-position:0 -35px;}
.is60{background-position:0 -42px;}
.is70{background-position:0 -49px;}
.is80{background-position:0 -56px;}
.is90{background-position:0 -63px;}
.is100{background-position:0 -70px;}
</style>

EOH;

?>