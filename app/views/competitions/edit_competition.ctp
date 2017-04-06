<?php

            $GMAPS_API = 'ABQIAAAAilf2rpNqnwxzswbTSxpTKhR0vcTud5tngwSMB1bBY6nA3aJGXhRefbgF7FG4R1KtdAaVJ3x60UlI4Q';
            $this->addScript('gmaps_google', $javascript->link('http://maps.google.com/maps?file=api&amp;v=2&amp;key='.$GMAPS_API));
            $this->addScript('gmaps_jquery', $javascript->link('jquery.gmap-1.1.0'));

?>
      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Competitions'); ?></h1></div>
        
        <div class="panel-body">

           <?php echo $form->create('Competition', array('action' => 'edit_competition','class' => 'form-horizontal')); ?>
           <fieldset>
           <legend><?php __('Manage goals for your training.'); ?></legend>

           <?php if ($session->read('flash')) { ?>
           <div class="<?php echo $statusbox; ?>">
           <?php echo $session->read('flash'); $session->delete('flash');  ?>
           </div><br />
           <?php } ?>

           <a href="http://www.trimapper.com" target="_blank">&raquo; <?php __('Where are triathlons worldwide?'); ?></a>
           <br /><br />

<div class="form-group">
<?php

echo $form->input('competitiondate',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'minYear' => date('Y',time()),
     'maxYear' => date('Y',time())+5,
     'class' => 'required form-control',
     'error' => array( 
        'competitiondate' => __('Enter a valid date', true) 
      ),
     'label' => __('Date', true)
));
?>
</div>

<div class="form-group">
<?php

$sporttype_array = $sports;

echo $form->input('sportstype',
      array(
      'legend' => false,
      'before' => '',
      'after' => '',
      'between' => '',
      'options' => $sporttype_array,
      'class' => 'required form-control',
      'label' => __('Sport', true)
      ));
?>
</div>

<div class="form-group">
<?php

echo $form->input('name',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'maxLength' => 255,
     'class' => 'required form-control',
     'error' => array( 
        'notempty' => __('Enter a name for the competition', true) 
     ),
     'label' => __('Name of competition', true)
     ));

?>
</div>

<div class="alert alert-info">

<?php __('You should only define 3 important competitions per year!'); ?>
</div>

<div class="form-group">
  <div class="checkbox">

<?php
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
?>
  </div>
</div>

<div class="form-group">
<?php
echo $form->input('location',
     array(
     'before' => '',
     'after' => '',
     'between' => '',
     'class' => 'form-control',
     'maxLength' => 255,
     //'default' => __('City, Country', true),
     'label' => __('Location', true)
     ));

?>

              <div id="gmap"></div>

</div>

<?php

echo $form->hidden('id');

echo $form->submit(__('Save',true), array('class'=>'btn btn-primary'));

?>
                 </fieldset>

<?php
      echo $form->end();
?>

  </div>
</div>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$(document).ready(function() 
{
        // facebox box
        //\$('a[rel*=facebox]').facebox();

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