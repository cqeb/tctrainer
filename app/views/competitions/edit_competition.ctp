<?php

            $GMAPS_API = 'ABQIAAAAilf2rpNqnwxzswbTSxpTKhR0vcTud5tngwSMB1bBY6nA3aJGXhRefbgF7FG4R1KtdAaVJ3x60UlI4Q';
            $this->addScript('gmaps_google', $javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$GMAPS_API));
            $this->addScript('gmaps_jquery', $javascript->link('jquery.gmap-1.1.0'));

?>
                   <h1><?php __('Competitions'); ?></h1>

                   <?php echo $form->create('Competition', array('action' => 'edit_competition')); ?>
                   <fieldset>
                   <legend><?php __('Manage goals for your training.'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <!--<?php echo $html->link(__('Back to your competitions list',true),array('controller' => 'competitions', 'action' => 'list_competitions')); ?>-->
                   <a href="http://www.trimapper.com" target="_blank">&raquo; <?php __('Where are triathlons worldwide?'); ?></a>
                   <br /><br />

<?php

echo $form->input('competitiondate',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'minYear' => date('Y',time()),
     'maxYear' => date('Y',time())+10,
     'class' => 'required',
     'error' => array( 
        'competitiondate' => __('Enter a valid date', true) 
      ),
     'label' => __('Date', true)
));

/**
echo $form->input('important',
       array(
       'before' => __('Important', true),
       'after' => '',
       'between' => '',
       'legend' => false,
       'type' => 'radio',
       'multiple' => false,
       'default' => '1',
       'options' => array(
                 '1' => __('Yes', true),
                 '0' => __('No', true),
       )
));
**/

$sporttype_array = $sports;

echo $form->input('sportstype',
      array(
      'legend' => false,
      'before' => '',
      'after' => '',
      'between' => '',
      'options' => $sporttype_array,
      'class' => 'required',
      'label' => __('Sport', true)
      ));


echo $form->input('name',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required',
     'error' => array( 
        'notempty' => __('Enter a name for the competition', true) 
     ),
     'label' => __('Name of competition', true)
     ));

echo '<br />';
__('You should only define 3 important competitions per year!');
echo '<br /><br />';

echo $form->input('important',
       array(
       'label' => __('Important', true),
       'after' => '',
       'between' => '',
       'legend' => false,
       'type' => 'checkbox',
       'default' => '1',
       'options' => array(
                 '1' => __('Yes', true),
                 '0' => __('No', true),
       )
));

echo $form->input('location',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     //'default' => __('City, Country', true),
     'label' => __('Location', true)
     ));

?>

              <div id="gmap"></div>


<!--//
<br />

<div id="swim">
<?php
echo $form->input('swim_distance',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Swim distance (' . $length_unit . ')', true)
));

echo $form->input('swim_time',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Time for swim distance (HH:MM:SS)', true)
));
?>
</div>

<div id="run_duathlon">
<?php
echo $form->input('duathlonrun_distance',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Run distance (Duathlon) (' . $length_unit . ')', true)
));

echo $form->input('duathlonrun_time',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Time for run distance (duathlon) (HH:MM:SS)', true)
));
?>
</div>

<div id="bike">
<?php
echo $form->input('bike_distance',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Bike distance (' . $length_unit . ')', true)
));

echo $form->input('bike_time',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Time for bike distance (HH:MM:SS)', true)
));
?>
</div>

<div id="run">
<?php
echo $form->input('run_distance',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Run distance (' . $length_unit . ')', true)
));

echo $form->input('run_time',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'error' => array('wrap' => 'div', 'style' => 'color:red'),
     'label' => __('Time for run distance (HH:MM:SS)', true)
));

?>
</div>
//-->

<?php

/** not finished **/

echo $form->hidden('id');

echo $form->submit(__('Save',true));

?>

                 </fieldset>


<?php
      echo $form->end();
?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$(document).ready(function() 
{
        // facebox box
        \$('a[rel*=facebox]').facebox();

        /** 
         * thanks to http://gmap.nurtext.de/examples.html
        */
        if ( \$("#CompetitionLocation").val() ) 
        {
            \$("#gmap").css("height","250px");
            \$("#gmap").css("margin","20px");
            
            \$("#gmap").gMap({ markers: [
                            { address: \$("#CompetitionLocation").val(),
                              html: "Your event" }],
                  address: \$("#CompetitionLocation").val(),
                  zoom: 10 });
        }
});

/**
        function initDropdownManipulator()
        {
                 checkSportstype( \$('#CompetitionSportstype').val() );

                 \$('#CompetitionSportstype').change(function(){
                        checkSportstype( \$('#CompetitionSportstype').val() );
                        return false;
                 });
                 \$('#CompetitionSportstype').blur(function(){
                        checkSportstype( \$('#CompetitionSportstype').val() );
                        return false;
                 });
                 return false;
        }

        function checkSportstype( sportsType )
        {
                 var result = sportsType.match(/TRIATHLON/g);
                 if (result)
                 {
                    \$('#swim').show();
                    //\$('#CompetitionSwimDistance').val("");
                    //\$('#CompetitionSwimTime').val("");
                    \$('#run_duathlon').hide();
                    \$('#CompetitionDuathlonrunDistance').val("");
                    \$('#CompetitionDuathlonrunTime').val("");
                    \$('#bike').show();
                    \$('#run').show();
                 }
                 result = sportsType.match(/RUN/g);
                 if (result)
                 {
                    \$('#swim').hide();
                    \$('#CompetitionSwimDistance').val("");
                    \$('#CompetitionSwimTime').val("");
                    \$('#run_duathlon').hide();
                    \$('#CompetitionDuathlonrunDistance').val("");
                    \$('#CompetitionDuathlonrunTime').val("");
                    \$('#bike').hide();
                    \$('#CompetitionBikeDistance').val("");
                    \$('#CompetitionBikeTime').val("");
                    \$('#run').show();
                 }
                 result = sportsType.match(/DUATHLON/g);
                 if (result)
                 {
                    \$('#swim').hide();
                    \$('#CompetitionSwimDistance').val("");
                    \$('#CompetitionSwimTime').val("");
                    \$('#run_duathlon').show();
                    \$('#bike').show();
                    \$('#run').show();
                 }
                 result = sportsType.match(/BIKE/g);
                 if (result)
                 {
                    \$('#swim').hide();
                    \$('#CompetitionSwimDistance').val("");
                    \$('#CompetitionSwimTime').val("");
                    \$('#run_duathlon').hide();
                    \$('#CompetitionDuathlonrunDistance').val("");
                    \$('#CompetitionDuathlonrunTime').val("");
                    \$('#bike').show();
                    \$('#run').hide();
                    \$('#CompetitionRunDistance').val("");
                    \$('#CompetitionRunTime').val("");
                 }
                 return true;
        }
**/

</script>

<script language="JavaScript">
<!--
//initDropdownManipulator();
-->
</script>

EOE;

?>