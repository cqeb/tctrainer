
                   <h1><?php __('Change profile'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_weight', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Get rid of your weight and gain speed.'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <!--<h2><?php __('Weight management'); ?></h2>-->

<?php

$min_height = $unitcalc->check_height('100') . ' ' . $unit['height'];
$max_height = $unitcalc->check_height('230') . ' ' . $unit['height'];

echo $form->input('height',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 7,
     'error' => array( 
             'numeric' => __('Enter your height',true),
             'greater' => __('Must be at least',true) . ' ' . $min_height,
             'lower' => __('Must be lower than',true) . ' ' . $max_height,
             'notempty' => __('Enter your height',true)
     ),
     'label' => __('Height', true) . ' (' . $unit['height'] . ')'
     ));

$min_weight = $unitcalc->check_height('40') . ' ' . $unit['weight'];
$max_weight = $unitcalc->check_height('150') . ' ' . $unit['weight'];

echo $form->input('weight',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 7,
     'error' => array( 
             'numeric' => __('Enter your current weight',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight,
             'notempty' => __('Enter your current weight',true)
     ),
     'label' => __('Weight', true) . ' (' . $unit['weight'] . ')'
     ));

echo $form->input('targetweight',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 7,
     'error' => array( 
             'numeric' => __('Enter your target weight',true),
             'greater' => __('Must be at least',true) . ' ' . $min_weight,
             'lower' => __('Must be lower than',true) . ' ' . $max_weight
     ),
     'label' => __('Target weight', true) . ' (' . $unit['weight'] . ')'
     ));


?>
<span id="bmiLoading"><img src="<?php echo Configure::read('App.serverUrl'); ?>/img/indicator.gif" alt="Ajax Indicator" /></span>
<span id="bmiResult"></span>

<?php

$now_year = date( 'Y', time() );
$future_year = date( 'Y', time() ) + 5;

echo $form->input('targetweightdate',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'minYear' => $now_year,
     'maxYear' => $future_year,
     'label' => __('When to reach it?', true)
));

echo $form->hidden('targetweightcheck');

if ($form->isFieldError('targetweightcheck'))
{
   //echo '<span style="color:red">' . $targetweighterror . '</span>';
}
?>

<br />
<?php

echo $form->hidden('id');
echo $form->hidden('birthday');

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

/** initiate JQuery **/

function finishAjax(id, response) {
         \$('#bmiLoading').hide();
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

function check_bmi() {
         if ( \$('#UserWeight').val() != "" && \$('#UserHeight').val() != "" ) {
                   \$('#bmiLoading').show();
                   \$.post("
EOE;
      $this->js_addon .= Configure::read('App.serverUrl');
      $this->js_addon .= <<<EOF
/users/check_bmi", {
                       checkweight: \$('#UserWeight').val(),
                       checkheight: \$('#UserHeight').val(),
                       checkbirthday: \$('#UserBirthday').val(),
                       checkunit: \$('#UserUnit').val()
                   }, function(response){
                       setTimeout("finishAjax('bmiResult', '"+escape(response)+"')", 400);
                   });
    	 }

}

\$(document).ready(function() {

        // facebox box
        \$('a[rel*=facebox]').facebox();

        // check email availability
        \$('#bmiLoading').hide();

        \$('#UserWeight').blur(function() {
                check_bmi();
                return false;
	});

        \$('#UserHeight').blur(function() {
                check_bmi();
                return false;
	});

});

</script>

EOF;

?>