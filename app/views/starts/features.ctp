<?php

$currency = 'EUR';
$userobject = null;
$price_array = $unitcalc->get_prices( null, $currency, $userobject );
$price_array_split = $price_array[$currency]['total'];
$price_month_array_split = $price_array[$currency]['month'];

?>
      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Memberships subscriptions'); ?></h1></h1></div>
        
        <div class="panel-body">

           <?php echo $this->element('js_error'); ?>

           <fieldset>
           <legend><?php __('Reach Your Goal With a Plan!'); ?>!</legend>

           <?php if ($session->read('flash')) { ?>
           <div class="<?php echo $statusbox; ?>">
           <?php echo $session->read('flash'); $session->delete('flash'); ?>
           </div><br />
           <?php } ?>


<table summary="<?php __('All possible subscriptions'); ?>" class="table table-striped table-bordered table-condensed">
<caption><?php __('SUBSCRIPTIONS'); ?></caption>
<colgroup>
          <col class="colA">
          <col class="colB">
          <col class="colC">
</colgroup>
<thead>
<tr>
    <th><?php __('Features'); ?></th>
    <th style="width:25%"><?php __('PREMIUM'); ?></th>
    <th style="width:25%"><?php __('FREE'); ?></th>
</tr>
</thead>
<tbody>
<tr class="odd">
    <td><?php __('Personal Settings'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Training logbook'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><?php __('Define competitions'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr>
    <td><?php __('Workout Statistics'); ?></td>
    <td style="text-align:center">X</td>
    <td style="text-align:center">X</td>
</tr>
<tr class="odd">
    <td><b><?php __('Interactive trainingplan'); ?></b></td>
    <td style="text-align:center"><b>X</b></td>
    <td style="text-align:center"><b><?php __('No'); ?></b></td>
</tr>
<tr>
    <td colspan="3">&nbsp;</td>
</tr>
<tr class="odd">
    <td><?php __('MONTHLY'); ?></td>
    <td style="">    
    <!--a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:1"-->
    <b>1 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b> 
    <?php __('for ONLY'); ?> <?php echo $price_array_split[0]; echo ' ' . $currency; ?>   
    </a>
    </td>
    <td style="text-align:center"></td>
</tr>
<tr class="odd">
    <td><?php __('YEARLY'); ?></td>
    <td style="">    
    <!--a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:12"-->
    <b>12 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b> 
    <?php __('for ONLY'); ?> <?php echo $price_array_split[3]; echo ' ' . $currency; ?>  
    </a>
    </td>
    <td style="text-align:center"></td>
</tr>

<!--//
<tr>
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:1">
    <b>1 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[0]; echo ' ' . $currency; ?>   
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:3">
    <b>3 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[1]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
<tr>
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:6">
    <b>6 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[2]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
<tr class="odd">
    <td colspan="3">
    <!a rel="facebox[.bolder]" href="<?php echo Configure::read('App.serverUrl'); ?>/payments/initiate/t:12">
    <b>12 <?php __('month(s)'); echo 'TriCoreTraining '; __('plans'); ?></b><br />
    <?php __('for ONLY'); ?> <?php echo $price_array_split[3]; echo ' ' . $currency; ?>  
    </a>
    </td>
</tr>
//-->
</tbody>
</table>

<a href="/trainer/users/register/"><button class="btn btn-primary btn-success" onClick="javascript:top.location.href='/trainer/users/register/' value="<?php __('Sign up, it\'s free'); ?>"><?php __('Sign up, it\'s free'); ?></button></a>
&laquo; &laquo; &laquo; &laquo; -- <?php __('Click here and start shaping your body!'); ?> :)
<br /><br /><br />
<div class="alert" style="color:white">
<?php

__('Sign up and receive weekly training plans for triathlon, biking and running.');
echo ' <br /><br />';
echo '<b>';
__('Try them for FREE for 15 days.');
echo '</b>';
echo ' <br /><br />';
__('Get your coach in a box by upgrading to a PREMIUM membership for a price less than the price of 2 coffees a month!');
echo ' <br /><br />';
__('20% VAT included!');

?>
</div>
<br /><br />

                </fieldset>

        </div>
    </div>


<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">

/** initiate JQuery **/

\$(document).ready(function() {

        // facebox box
        //$('a[rel*=facebox]').facebox();

});

</script>

EOE;

?>