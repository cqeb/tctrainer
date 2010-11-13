
                   <h1><?php __('Competitions'); ?></h1>

                   <?php echo $this->element('js_error'); ?>
                 
                   <fieldset>
                   <legend><?php __('Manage your competitions!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php 
                   
echo $html->link(__('Add competition', true), array('action' => 'edit_competition'), null);  

if ( $create_dummy == 'true' )
{
      echo ' '; 
      __('Don\'t know what to do? ');
      echo $html->link(__('Create dummy competition.',true), array('controller' => 'competitions', 'action' => 'edit_competition', 'id' => 'dummy'),null);
}

?>
                   <br /><br />

                   <table>
                   <tr>
                        <th><?php echo $paginator->sort(__('Prio',true), 'important'); ?></th>
                        <th><?php echo $paginator->sort(__('Date',true), 'competitiondate'); ?></th>
                        <th><?php echo $paginator->sort(__('Sport',true), 'sportstype'); ?></th>
                        <th><?php echo $paginator->sort(__('Name',true), 'name'); ?></th>
                        <th></th>
                   </tr>
                   <?php if ( count( $competitions ) < 1 ) echo '<tr><td /><td colspan="4"><br />' . __('No competitions defined.', true) . '</td></tr>'; ?> 
                   <?php foreach ($competitions as $competition): ?>
                   <tr>
                        <td><?php if ( $competition['Competition']['important'] ) { echo '<img src="../img/star.gif" alt="'; __('Important',true); echo '" />'; } ?></td>
                        <td><?php echo $html->link($unitcalc->check_date($competition['Competition']['competitiondate']), array('action' => 'edit_competition', 'id' => $competition['Competition']['id']),null); echo ", " . date('D', strtotime($competition['Competition']['competitiondate'])); ?></td>
                        <td><?php echo $html->link($competition['Competition']['sportstype'], array('action' => 'edit_competition', 'id' => $competition['Competition']['id']),null) ?></td>
                        <td><?php echo $html->link($competition['Competition']['name'], array('action' => 'edit_competition', 'id' => $competition['Competition']['id']),null) ?></td>
                        <td><?php echo $html->link(__('[X]',true), array('action' => 'delete', 'id' => $competition['Competition']['id']), null, __('Are you sure?',true) )?></td>
                   </tr>
                   <?php endforeach; ?>
                   </table>

<?php 

echo $paginator->numbers( array( 'seperator' => '|' ) );

?>
                   </fieldset>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$(document).ready(function() 
{

        // facebox box
        \$('a[rel*=facebox]').facebox();

});

</script>
EOE;

?>