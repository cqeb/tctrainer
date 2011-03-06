<?php

$yesno[1] = __('Yes', true);
$yesno[0] = __('No', true);

?>
                   <h1><?php __('List users'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <fieldset> 
                   <legend><?php __('Administrate our users!'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

<?php echo $paginator->numbers(); ?>

<table>
<tr>
    <th><?php echo $paginator->sort(__('ID',true), 'id'); ?></th>
    <th><?php echo $paginator->sort(__('Name',true), 'lastname'); ?></th>
    <th style="width: 15%"><?php echo $paginator->sort(__('Pay-Date',true), 'paid_to'); ?></th>
    <th style="width: 15%"><?php echo $paginator->sort(__('Activation',true), 'deactivated'); ?></th>
    <th style="width: 15%"><?php __('Beta/Admin'); ?></th>
    <th><?php __('Action'); ?></th>
</tr>

<?php 

if ( !isset( $users ) || count( $users ) < 1 )
{
  
    echo '<td colspan="6">' . __('No users available.', true) . '</td>';  
}
 
?>

<?php foreach ($users as $userentry): ?>
<?php $user = $userentry['User']; ?>

<?php //pr($user); ?>

<tr>
    <td><?php echo $html->link($user['id'], array('action' => 'edit_user', 'id' => $user['id']), null); ?></td>
    <td><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></td>
    <td><?php echo $user['paid_from'] . ' - ' . $user['paid_to']; ?></td>
    <td><?php echo 'Activ. <b>' . $yesno[$user['activated']] . '</b><br />' . 'Deact. <b>' . $yesno[$user['deactivated']]; ?></b></td>
    <td><?php echo 'Beta <b>' . $yesno[$user['advanced_features']] . '</b><br />' . 'Admin <b>' . $yesno[$user['admin']]; ?></b></td>
    <td style="text-align:right;">
    <?php echo $html->link(__('Edit', true), array('action' => 'edit_user', 'id' => $user['id']), null); ?>
    <br />
    <?php echo $html->link(__('Become user', true), array('action' => 'edit_user', 'id' => $user['id'], 'setuser' => 'true'), null); ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php echo $paginator->numbers(); ?>

                 </fieldset>
<?php

      echo $form->end();

?>

<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

\$(document).ready(function() {

        // facebox box
        /*\$('a[rel*=facebox]').facebox();*/

});

</script>
EOE;

?>
