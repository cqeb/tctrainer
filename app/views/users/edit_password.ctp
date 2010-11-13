
                   <h1><?php __('Change profile'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_password', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Secure your training service!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<!--
<?php __('Passwort-Strength') ?> <div id="passwordStrengthDiv" class="is0"></div>
<br /><br />
-->

<?php

echo $form->input('password',
     array(
     'type' => 'password',
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'legend' => false,
     'class' => 'required',
     'label' => __('Password', true),
     'error' => array( 
        'notempty' => __('Enter a password', true)
     )
));

echo $form->input('passwordapprove',
     array(
     'type' => 'password',
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'legend' => false,
     'class' => 'required',
     'label' => __('Repeat password',true),
     'error' => array( 
        'notempty' => __('Repeat your password', true)
     )
));

/** not finished **/

echo $form->hidden('id');

/**
echo $form->hidden('passwordcheck');
if ($form->isFieldError('passwordcheck')){
    echo $form->error('passwordcheck');
}
**/

?>
<div class="error-message" id="PWNotMatch"><?php if ( isset( $errormessage ) ) { echo $errormessage; } ?></div>

<br />
<?php

echo $form->submit(__('Save',true));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$.fn.passwordStrength = function( options ){
	return this.each(function(){
		var that = this;that.opts = {};
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

/** initiate JQuery **/

\$(document).ready(function() {

EOE;

      $this->js_addon .= '
        var pwokmessage = \'' . __('Passwords match!', true) . '\';
        var pwerrormessage = \'' . __('Passwords do not match!', true) . '\';
        ';

      $this->js_addon .= <<<EOE

      // check password strength
	    \$('input[name="data[User][password]"]').passwordStrength();
EOE;

if ( !isset( $errormessage ) ) 
      $this->js_addon .= "
      // check password match
      // hide layer for error message
      \$('#PWNotMatch').hide();
";

      $this->js_addon .= <<<EOE
      // if user leaves field with mouse (blur)
      \$('#UserPasswordapprove').blur(function(){

                val1 = \$('#UserPasswordapprove').val();
                val2 = \$('#UserPassword').val();

                // show layer for errormessage
                if ( val1 ) \$('#PWNotMatch').show();

                if ( val1 == val2 ) {
                   \$('#PWNotMatch').html(pwokmessage);
                   \$('#PWNotMatch').removeClass("error-message");
                   \$('#PWNotMatch').addClass("ok-message");
                   \$('#UserPasswordcheck').val("1");
                   return true;
                } else {
                   \$('#PWNotMatch').html(pwerrormessage);
                   \$('#PWNotMatch').removeClass("ok-message");
                   \$('#PWNotMatch').addClass("error-message");
                   \$('#UserPasswordcheck').val("0");
    	           return false;
                }
	});

        // facebox box
        $('a[rel*=facebox]').facebox();

});

</script>

<style>
.is0{background:url(
EOE;

$this->js_addon .= Configure::read('App.serverUrl');

$this->js_addon .= <<<EOF
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

EOF;

?>