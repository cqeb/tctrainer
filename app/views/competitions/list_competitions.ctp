      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Races'); ?></h1></div>
        
        <div class="panel-body">

        <?php echo $this->element('js_error'); ?>

        <fieldset>
        <legend><?php __('Manage your races!'); ?></legend>

        <?php if ($session->read('flash')) { ?>
        <div class="<?php echo $statusbox; ?>">
        <?php echo $session->read('flash'); $session->delete('flash'); ?>
        </div><br />
        <?php } ?>
        <button class="btn btn-primary" onClick="javascript:top.location.href='/trainer/competitions/edit_competition/'" value="<?php __('Add competition'); ?>"><?php __('Add competition'); ?></button>
        <br /><br />

        <table class="table table-striped table-bordered table-condensed">
        <tr>
             <th><?php echo $paginator->sort(__('Prio',true), 'important'); ?></th>
             <th><?php echo $paginator->sort(__('Date',true), 'competitiondate'); ?></th>
             <th><?php echo $paginator->sort(__('Sport',true), 'sportstype'); ?></th>
             <th><?php echo $paginator->sort(__('Name',true), 'name'); ?></th>
             <th></th>
        </tr>
<?php 
if ( count( $competitions ) < 1 ) {
?>
<tr>
   <td />
   <td colspan="4"><br /><?php __('No races defined.'); ?></td>
</tr>
<?php 
}
                   
if ( isset( $checkcompetition[0]['competitions']['id'] ) ) {
	$next_comp_id = $checkcompetition[0]['competitions']['id'];
} else {
	$next_comp_id = '';
}
                   
foreach ($competitions as $competition) { 

	$this_comp_id = $competition['Competition']['id'];
	if ( $this_comp_id == $next_comp_id) {
?>
<tr>
   <td />
   <td colspan="4"><b><?php __('Your next race ...'); ?></b></td>
</tr>
<?php
	}
?> 
<tr id="comp-<?php echo $this_comp_id; ?>">
     <td style="text-align:center;"><?php if ( $competition['Competition']['important'] ) { echo '<img src="/trainer/img/star.gif" alt="'; __('Important',true); echo '" />'; } ?></td>
     <td><?php echo $html->link($unitcalc->check_date($competition['Competition']['competitiondate']), '/edit_competition' . '/' . $competition['Competition']['id'] . '/', null); $cday = date('D', strtotime($competition['Competition']['competitiondate'])); echo ", " . __($cday, true); ?></td>
     <td><?php echo $html->link(__($competition['Competition']['sportstype'], true), '/edit_competition' . '/' . $competition['Competition']['id'] . '/', null) ?></td>
     <td><?php echo $html->link($competition['Competition']['name'], '/edit_competition' . '/' . $competition['Competition']['id'] . '/', null) ?></td>
     <td><a href="/trainer/competitions/delete/<?php echo $competition['Competition']['id']; ?>/" onClick="return confirm('<?php __('Are you sure?'); ?>');"><img class="rmCompetition" alt="<?php __('Delete this competition'); ?>" title="<?php __('Delete this competition'); ?>" width="20" src="/trainer/img/icon_delete.png" /></a></td>
</tr>
<?php
}
?>
</table>

<?php echo $paginator->numbers( array( 'seperator' => '|' ) ); ?>

</fieldset>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
        $('.rmCompetition').tipTip({ defaultPosition : 'top' });
});
</script>