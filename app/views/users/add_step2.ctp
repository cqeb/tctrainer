
                   <h1><?php __('Registration - Step 2/2'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <div class="messagebox">
                   <?php __('Get your trainingplans FREE for 1 month. Then invest less than 3 cups of coffee worth per month for your
                   electronic trainingscoach. NO RISK, as we offer a 30-days money back garantuee.'); ?>
                   </div><br />

                   <?php echo $form->create('User', array('action' => 'add_step2')); ?>

                   <fieldset>
                   <legend><?php __('Fill in your training preferences'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div>
                   <?php } ?>
                   <br />

                   <h2><?php __('Sport preferences'); ?></h2>

<a href="#"><?php __('TODO Details about Distances (Kilometers/Miles)'); ?></a><br />

<?php

$sporttype_array = $sports;

echo $form->input('typeofsport',
     array(
     'legend' => false,
     'class' => 'required',
     'label' => __('Your sport passion?', true),
     'before' => '',
     'after' => '',
     'between' => '',
     'options' => $sporttype_array
     ));

?>

<?php

echo $form->input('rookie',
     array(
     'before' => __('Are you a rookie in triathlon, running and biking? So, you want to start from the beginning?', true),
     'class' => 'required',
     'after' => '',
     'between' => '',
     'legend' => false,
     'type' => 'radio',
     'default' => '0',
     'multiple' => false,
     'options' => array(
        '1' => __('Yes',true),
        '0' => __('No',true)
     )
));

echo $form->input('medicallimitations',
     array(
     'before' => '<b>' . __('Do you have any medical impacts preventing you from doing sports or
     did your doctor told you not to do any sports? Please talk to your doctor BEFORE starting your training!', true) . '</b>',
     'after' => '',
     'between' => '',
     'legend' => false,
     'type' => 'radio',
     'class' => 'required',
     'multiple' => false,
     'default' => '0',
     'options' => array(
        '1' => __('Yes',true),
        '0' => __('No',true)
     )
));

?>

<div class="messagebox">

<?php echo $html->link(__('Training hours calculator',true), array('action' => 'traininghours_calc'),array('rel' => 'facebox[.bolder]'),null); ?>

<?php

echo $form->input('weeklyhours',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'default' => '10',
     'error' => array( 
          'numeric' => __('Please supply the your weekly training hours.', true),
          'greater' => __('Must be at least 0 hours',true),
          'lower' => __('Must be at lower than 60 hours',true),
          'notempty' => __('Enter your weekly available training hours, please',true) 
     ),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Weekly hours', true)
));

/**
echo $form->input('dayofheaviesttraining',
     array(
     'legend' => false,
     'label' => __('Day of heaviest training', true),
     'before' => '',
     'class' => 'required',
     'after' => '',
     'between' => '',
     'default' => 'FRI',
     'options' => array(
               'MON' => __('Monday', true),
               'TUE' => __('Tuesday', true),
               'WED' => __('Wednesday', true),
               'THU' => __('Thursday', true),
               'FRI' => __('Friday', true),
               'SAT' => __('Saturday', true),
               'SUN' => __('Sunday', true)
     )));
**/

?>

<?php __('For calculating your season'); ?>
<br />
<?php
echo $form->input('coldestmonth', array(
     'before' => '',
     'after' => '',
     'between' => '',
     'label' => __('Coldest month', true),
     'class' => 'required',
     'options' => array(
               '1' => __('January',true),
               '2' => __('February',true),
               '3' => __('March',true),
               '4' => __('April',true),
               '5' => __('May',true),
               '6' => __('June',true),
               '7' => __('July',true),
               '8' => __('August',true),
               '9' => __('September',true),
               '10' => __('October',true),
               '11' => __('November',true),
               '12' => __('December',true)
     )));
?>

<a href="#"><?php __('Hint how to measure?', true); ?></a>

<?php

echo $form->input('maximumheartrate',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'maxLength' => 255,
     'default' => (220-$age),
     'error' => array( 
        'numeric' => __('Please supply your maximum heart rate (for approx. 220 minus your age).',true),
        'greater' => __('Must be at least 120',true),
        'lower' => __('Must be at lower than 220',true),
        'notempty' => __('Enter a maximum heart rate, please',true)
     ),
     //'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Your maximum heart rate', true)
));

?>
                   <br />
                   <div class="messagebox">
                   <?php __('<b>Your Lactate Threshold Heart Rate (estimated)</b>'); ?>
                   <br />
                   <?php echo round((220-$age)*0.85); ?>
                   </div>
<br />
                   <h2><?php __('Metric preferences'); ?></h2>

<?php

echo $form->input('unit', array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'label' => __('Unit', true),
     'options' => array(
               'metric' => __('Metric (Kilometres, Kilograms, Centimeters)', true),
               'imperial' => __('Imperial (Miles, Pounds, Feet)', true)
     )));

echo $form->input('unitdate', array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'label' => __('Dateformat', true),
     'options' => array(
               'ddmmyyyy' => __('DD.MM.YYYY', true),
               'mmddyyyy' => __('MM.DD.YYYY', true),
               'yyyymmdd' => __('YYYY-MM-DD', true)
     )));

/**
echo $form->input('yourlanguage', array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'required',
     'label' => __('Your language', true),
     'options' => array (
               'ger' => __('German',true),
               'eng' => __('English',true)
     )));
**/
if ( !$locale ) $locale = 'eng';
echo $form->input( 'yourlanguage', array('type' => 'hidden', 'value' => $locale ));

$payed_from = date( "Y-m-d", time() );
$payed_to = date( "Y-m-d", time() + (30*24*60*60) );

echo $form->input( 'payed_from', array('type' => 'hidden', 'value' => $payed_from));
echo $form->input( 'payed_to', array('type' => 'hidden', 'value' => $payed_to));

echo $form->hidden('id');

?>
                   <br />
                   <div class="messagebox">
                   <?php __('You MUST have a heart rate monitor like <a href="http://www.amazon.de/gp/product/B001NGOYMU?ie=UTF8&tag=trico-21&linkCode=as2&camp=1638&creative=6742&creativeASIN=B001NGOYMU" target="_blank">POLAR</a> for your training as we offer heart rate oriented trainingplans.') ?>
                   <br /><br />
                   <center>
                   <a href="http://www.amazon.de/gp/product/B001NGOYMU?ie=UTF8&tag=trico-21&linkCode=as2&camp=1638&creative=6742&creativeASIN=B001NGOYMU" target="_blank"><img border="0" src="https://images-na.ssl-images-amazon.com/images/I/41WA91iWQBL._SL110_.jpg" alt="Heart rate monitor" /></a><img src="http://www.assoc-amazon.de/e/ir?t=trico-21&l=as2&o=3&a=B001NGOYMU" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
                   </center>

                   <br />
                   </div>

                   <br />

                   <div class="messagebox" style="overflow:auto; width: 420px; height: 200px;">
                   <?php echo $this->element('tos'); ?><br />
                   </div>

                   <br /><br />

<?php
/** not finished **/

echo $form->hidden('id');
echo $form->hidden('birthday');

echo $form->submit('Finish');

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

\$(document).ready(function() {

        // facebox box
        $('a[rel*=facebox]').facebox();

});

function initDropdownManipulator()
{
                 \$('#UserTypeofsport').change(function(){
                        /**
                         * TODO
                         Triathlon:
                          Sprint: 4h
                          Olympisch: 5h
                          Halbironman: 8h
                          Ironman: 12h
                          
                         Laufen:
                          5k: 2,5h
                          10k: 3,5h
                          Halbmarathon: 4,5h
                          Marathon: 6h
                        */
                        if ( \$('#UserTypeofsport').val() == 'DUATHLON SHORT' ) \$('#UserWeeklyhours').val("6");
                        else \$('#UserWeeklyhours').val("12");
                        return false;
                 });
                 \$('#UserTypeofsport').blur(function(){
                        //alert( \$('#UserTypeofsport').val() );
                        return false;
                 });
                 return false;
}
        
initDropdownManipulator();
        
</script>

EOE;

?>