<script type="text/javascript" src="/trainer/js/zoneguide.js"></script>


      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Settings'); ?></h1></div>
        
        <div class="panel-body">

        <?php echo $this->element('js_error'); ?>

        <?php 
        echo $form->create('User', array('action' => 'edit_traininginfo', 'type' => 'file', 'class' => 'form-horizontal'));
        ?>

        <fieldset>
        <legend><?php __('Fill in your training information'); ?></legend>

        <?php if ($session->read('flash')) { ?>
        <div class="<?php echo $statusbox; ?>">
        <?php echo $session->read('flash'); $session->delete('flash'); ?>
        </div><br />
        <?php } ?>

<div class="form-group">
<?php
echo $form->hidden('id');
echo $form->hidden('birthday');

$sporttype_array = $sports;

echo $form->input('typeofsport',
                  array(
                  'legend' => false,
                  'class' => 'required form-control',
                  'label' => __('Sport', true),
                  'before' => '',
                  'after' => '',
                  'between' => '',
                  'options' => $sporttype_array
));

?>
</div>

<div class="form-group">
<?php

echo $form->input('weeklyhours',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'default' => '10',
     'class' => 'required form-control',
     'error' => array( 
          'numeric' => __('Enter your weekly training hours', true),
          'greater' => __('Must be at least 0 hours',true),
          'lower' => __('Must be lower than 60 hours',true),
          'notempty' => __('Enter your weekly training hours',true) 
     ),
     'label' => __('Weekly hours', true)
));

?>

<div class="alert" id="weeklyhours"></div>

</div>

<div class="form-group">

<a name="zones"></a><h3><?php __('Zones'); ?></h3>

<div class="alert alert-danger" id="errorlth"></div>

<?php

if ( $language == 'deu' ) $language = 'de';
else $language = 'en';
 
$help_lth = ' <a class="help badge" title="' .
__('How to define your lactate threshold?', true) .
'<br />' . 
__('1. Do your test-workouts to define your lactate threshold.', true) .
'<br />' . 
__('2. Do a lactate threshold test with your doctor.', true) . 
'<br />' . 
__('Read more in our blog.', true) . 
'" href="/blog/' . $language . '/how-do-i-find-out-my-lactate-thresholds/">?</a>';

echo $form->input('lactatethreshold',
                   array(
                   'before' => '',
                   'after' => $help_lth,
                   'between' => '',
                   'class' => 'required form-control',
                   'maxLength' => 255,
                   'error' => array( 
                      'numeric' => __('Enter your current run lactate threshold',true),
                      'greater' => __('Must be at least 120',true),
                      'lower' => __('Must be lower than 220',true),
                      'notempty' => __('Enter your current run lactate threshold',true)
                   ),
                   //'error' => array('wrap' => 'div', 'style' => 'color:red'),
                   'label' => __('Run lactate threshold', true)
));
?>
<div class="alert alert-danger" id="errorblth"></div>

<?php

echo $form->input('bikelactatethreshold',
                   array(
                   'before' => '',
                   'after' => $help_lth,
                   'between' => '',
                   'class' => 'required form-control',
                   'maxLength' => 255,
                   'error' => array( 
                      'numeric' => __('Enter your current bike lactate threshold',true),
                      'greater' => __('Must be at least 120',true),
                      'lower' => __('Must be lower than 220',true),
                      'notempty' => __('Enter your current bike lactate threshold',true)
                   ),
                   'label' => __('Bike lactate threshold', true)
));
?>
<br />

<div id="zones"></div>

</div>

<div class="form-group">
<?php

$help_rookie = '&nbsp;&nbsp;&nbsp;&nbsp;<span class="help badge" title="' .
__("You're doing training for competitions and doing regular sports for the first time?", true) .
'">?</span>';

echo $form->input('rookie',
                  array(
                  'before' => __('Beginner in structured training?', true),
                  'after' => $help_rookie,
                  'between' => '',
                  'class' => 'required',
                  'label' => false,
                  'legend' => false,
                  'type' => 'checkbox',
                  //'multiple' => false,
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

$tos_link = '<a href="/blog/';
if ( $language == 'deu' ) 
    $tos_link .= 'de/'; else $tos_link .= 'en/';
$tos_link .= 'terms-of-service-2/" target="_blank">' .
	__('Read our terms and conditions.',true) . '</a>';

echo $form->input('tos',
                  array(
                  'before' => __("You agree to our terms and conditions and confirm that you're healthy enough for your training? If not, you HAVE TO talk to your doctor before starting your training!", true) . '<br /><br />' . $tos_link,
                  'after' => '',
                  'between' => '',
                  'legend' => false,
                  'error' => array( 'wrap' => 'div', 'class' => 'alert alert-danger', 'notempty' => __('You must agree to use this service', true)),
                  'label' => '',
                  'type' => 'checkbox',
                  'class' => 'required',
                  'default' => '0',
                  'options' => array(
                            '1' => __('Yes',true),
                            '0' => __('No',true)
                  )
));

?>
</div>

<?php

echo $form->submit(__('Save',true), array('class'=>'btn btn-primary'));

?>
                 <br />

                 </fieldset>

<?php
      echo $form->end();
?>
        </div>
      </div>
<?php

$this->js_addon = <<<EOE

<script type="text/javascript">

function finishAjax(id, response) 
{
         \$('#'+id).html(unescape(response));
         \$('#'+id).fadeIn();
}

EOE;

$this->js_addon .= "
// global i18n object for the ZoneGuide
zgi18n = {
	sport : '" . __('Sport',true) . "',
	zone : '" . __('Zone',true) . "',
	run : '" . __('Run',true) . "',
	bike : '" . __('Bike',true) . "'
};";

$this->js_addon .= <<<EOG
/**
 * will check lactate threshold and bike lactate threshold values
 */
function check_lth() {
	var lth = parseInt( \$('#UserLactatethreshold').val() );
    var blth = parseInt( \$('#UserBikelactatethreshold').val() );

    if ( isNaN(lth) || lth > 220 || lth < 120 ) {
    	\$('#errorlth').show();
        \$('#errorlth').html("
EOG;
$this->js_addon .= __('Your lactate threshold is not valid! Should be between 220 and 120.',true);
$this->js_addon .= <<<EOH
");
    } else {
    	\$('#errorlth').hide();
    }

	// check bike lactate threshold
    if ( isNaN(blth) || blth > 220 || blth < 120 ) {
    	\$('#errorblth').show();
        \$('#errorblth').html("
EOH;
$this->js_addon .= __('Your bike lactate threshold is not valid! Should be between 220 and 120.',true);
$this->js_addon .= <<<EOH
");
	} else {
    	\$('#errorblth').hide();
    }

	jQuery('#zones').html(ZoneGuide.getTable(
		jQuery('#UserLactatethreshold').val(),
		jQuery('#UserBikelactatethreshold').val(),
		zgi18n));
	return false;
}

function setwhrs(val) 
{

	  if ( val ) \$('#UserWeeklyhours').val(val);
      
      if ( \$('#UserWeeklyhours').val() != '' )
      {
          \$('#weeklyhours').show();
          var whrs = \$('#UserWeeklyhours').val();
EOH;

$this->js_addon .= '
          var whrsmsg = "' . __('Weekly training load varies between', true) . '"+" "+Math.round(whrs*0.7)+" "+"' .
            __('and', true) . '"+" "+Math.round(whrs*1.5)+" ' . __('hours',true).'."';

$this->js_addon .= <<<EOH
                      
                    \$('#weeklyhours').html(whrsmsg);
      }
      return false;
}

\$(document).ready(function() {
        var lth = parseInt( \$('#UserLactatethreshold').val() );
        \$('#errorlth, #errorblth').hide();

        var zonestable = '';

        // display zones-table
        if ( lth != '' )
        {
          jQuery('#zones').html(ZoneGuide.getTable(
					jQuery('#UserLactatethreshold').val(),
					jQuery('#UserBikelactatethreshold').val(),
					zgi18n));
        }

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

        \$('#UserWeeklyhours').blur(setwhrs());
        
        setwhrs();
        jQuery('#UserLactatethreshold, #UserBikelactatethreshold')
        .blur(function() {
				if (jQuery(this).val() != '') {
    	        	check_lth();
        	    }
            	return false;
  		});

        // facebox box
        //\$('a[rel*=facebox]').facebox();
		
		\$('.help').tipTip();
    \$('#weeklyhours').hide();

});

</script>

EOH;

?>