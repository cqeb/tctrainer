
                   <h1><?php __('Registration - Step 1/2'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <div class="messagebox">
                   <?php __('Get your trainingplans FREE for 1 month. Then invest less than 3 cups of coffee worth per month for your
                   electronic trainingscoach. NO RISK, as we offer a 30-days money back garantuee.'); ?>
                   </div>

                   <br />
                   <?php echo $form->create('User', array('action' => 'add_step1')); ?>
                   <fieldset>
                   <legend><?php __('Fill in your personal information'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div>
                   <br />
                   <?php } ?>

                   <!--<h2><?php __('Personal info');?></h2>-->
<?php

echo $form->input('firstname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
//     'class' => 'required',
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('<b>My firstname</b>', true)
//     'default' => __('Enter Firstname here', true)
));

//echo $form->label('firstname');
echo $form->input('lastname',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('<b>My lastname</b>', true)
//     'default' => __('Enter Lastname here', true)
));

echo $form->input('gender',
     array(
     'before' => __('<label for="gender"><b>Gender</b></label>', true),
     'after' => '',
     'between' => '',
     'legend' => false,
     'default' => 'm',
     'type' => 'radio',
     'multiple' => true,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'options' => array('m' => __('male', true), 'f' => __('female', true))
));

echo $form->input('email',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'label' => __('<b>My E-Mail</b>', true),
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
//     'default' => __('Enter E-Mail here', true)
));

echo $form->hidden('emailcheck');
if ($form->isFieldError('emailcheck')){
   //echo "<span style=\"color:red\">Your passwords do not match! Please re-enter!</span>";
   echo $form->error('emailcheck');
}
?>

<span id="usernameLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="usernameResult"></span>

<?php
/**
echo $form->input('emailapprove',
     array(
     'before' => '<p>',
     'after' => '</p>',
     'between' => '',
     'maxLength' => 255,
     'label' => __('Enter your Email again please', true),
     'default' => __('Enter E-Mail again', true)
));
**/
?>
<br /><br />
<?php __('We need your birthday for heart rate calculations! And we want to send you birthday wishes :).'); ?>
<br />
<?php

echo $form->input('birthday',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'minYear' => '1930',
     'maxYear' => '1995',
     'label' => __('<b>Birthday</b>', true),
     'error' => array('wrap' => 'div', 'style' => 'color:red')
));

echo $form->input('newsletter',
                               array(
                               'before' => __('Do you want to receive our newsletter?', true),
                               'after' => '',
                               'between' => '',
                               'legend' => false,
                               'type' => 'radio',
                               'multiple' => false,
                               'default' => '1',
                               'error' => array('wrap' => 'div', 'style' => 'color:red'),
                               'options' => array(
                                         '1' => 'Yes',
                                         '0' => 'No',
                               )
));

echo $form->input('youknowus',
                  array(
                  'legend' => false,
                  'label' => __('Where do you know us from?', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'error' => array('wrap' => 'div', 'style' => 'color:red'),
                  'options' => array(
                                'None' => __('Choose one option', true),
                                'Google' => __('Search engine (i.e. Google)', true),
                                'Friends' => __('Friends (Word by mouth)', true),
                                'Competition' => __('Competition (Ads)', true),
                                'Magazine' => __('Magazine, newspaper', true),
                                'Ads' => __('Online Ads (Banner)', true),
                                'Newsletter' => __('Newsletter', true),
                                'Other' => __('Other', true)
                  )));

?>
<hr>

<?php __('Passwort-Strength') ?> <div id="passwordStrengthDiv" class="is0"></div>
<br />
<?php

echo $form->input('password',
     array(
     'type' => 'password',
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'legend' => false,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('<b>My Password</b>', true)
));

echo $form->password('passwordapprove',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     //'size' => 65,
     'legend' => false,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('<label><b>Enter your Password again please</b></label>')
));

echo $form->hidden('passwordcheck');
if ($form->isFieldError('passwordcheck')){
   /**echo "<span style=\"color:red\">Your passwords do not match! Please re-enter!</span>";**/
   echo $form->error('passwordcheck');
}

?>

<div class="error-message" id="PWNotMatch"><?php __('Password does not match!') ?></div><br />

<hr>

<?php
/** not finished **/

echo $form->hidden('id');

echo $form->submit('Submit registration - Step 1');

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>



<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

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

  \$('#UserEmail').blur(function(){
                   if ( \$('#UserEmail').val() != '' ) {
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

        // corners
        //\$('#legend').corners();

        // facebox box
        \$('a[rel*=facebox]').facebox();

/**
        // create tabs logic for content
        var TabsArray = new Array('tab-1','tab-2','tab-3','tab-4');

        for (var i = 1; i < TabsArray.length; i++) {
            \$('#'+TabsArray[i]).hide();
        }

        // $('#tabscontent div').hide(); // hides all divs - unfortunately also good ones
        // $('#tabscontent div:first').show(); // Show the first div
        \$('#tabs ul li a').click(
                  function() //When any link is clicked
                  {
                             \$('#tabs ul li').removeClass('active'); // Remove active class from all links
                             \$(this).parent().addClass('active'); // Set clicked link class to active
                             var currentTab = \$(this).attr('href'); // Set variable currentTab to value of href attribute of clicked link
                             //var currentnewTab = currentTab.replace(/\?/g, "#");
                             //currentTab = currentnewTab.replace(/=true/g, "");
                             //$('#tabscontent div').hide(); // Hide all divs
                             for (i = 0; i < TabsArray.length; i++) {
                                 if ( currentTab != '#'+TabsArray[i] ) {
                                    \$('#'+TabsArray[i]).hide();

                                 } else {
                                   \$(currentTab).show();
                                 }
                             }
                             return false;
                    }
        );
**/

});

</script>

<style>
.is0{background:url(
EOF;

      $this->js_addon .= Configure::read('App.serverUrl');

      $this->js_addon .= <<<EOG
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

EOG;

?>