
                   <h1><?php __('Settings'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <?php echo $form->create('User', array('action' => 'edit_images', 'type' => 'file')); ?>
                   <fieldset>
                   <legend><?php __('Show us your beauty!'); ?></legend>

                   <?php if ($session->read('flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php echo $session->read('flash'); $session->delete('flash'); ?>
                   </div><br />
                   <?php } ?>
                   
                   <!--<h2><?php __('Images'); ?></h2>-->

<?php

__('Profile image (max. of 200 kilobytes)');

echo "<br />";

echo $form->file('myimage_upload');

if ( $myimage_show && $myimage_show != 'image' )
{
?>
                  <br /><br />
                  <div id="profileimage">
                  <img alt="<?php __('My profile image', true); ?>" width="200" src="<?php echo $myimage_show; ?>" />
                  </div>
                  <?php 
                  echo $html->link(__('Delete profile image?',true),array('action' => 'delete_image', 'field' => 'myimage'), null, __('Are you sure?',true) );
                  ?>
<?php
}

echo "<br /><br />";

//echo $form->input('myimage2', array( 'type' => 'file' ));

__('Bike image (max. of 200 kilobytes)');

echo "<br />";

echo $form->file('mybike_upload');

if ( $mybike_show ) {
?>
                  <br /><br />
                  <div id="profileimage">
                  <img alt="<?php __('My bike image', true); ?>" width="200" src="<?php echo $mybike_show; ?>" />
                  </div>
                  <?php 
                  echo $html->link(__('Delete bike image?',true),array('action' => 'delete_image', 'field' => 'mybike'), null, __('Are you sure?',true) );
                  ?>
<?php
}
?>

<br /><br />
<?php echo __('Trainingsphilosophy'); ?>
<br />

<?php
echo $form->textarea('mytrainingsphilosophy',
     array(
           'rows' => '10',
           'cols' => '45'
           ));
?>
<br /><br />
<?php echo __('What I think about TriCoreTraining?'); ?>
<br />
<?php 
echo $form->textarea('myrecommendation',
     array(
           'rows' => '10',
           'cols' => '45'
           ));

/** not finished **/

echo $form->hidden('id');
echo $form->hidden('mybike');
echo $form->hidden('myimage');

?>

<br /><br />

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

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        //\$('a[rel*=facebox]').facebox();

});

</script>

EOE;

// not the most beautiful method to replace serverurls - but efficient :)
//$serverurl = Configure::read('App.serverUrl');
//$this->js_addon = str_replace( '###serverurl###', $serverurl, $this->js_addon );

?>