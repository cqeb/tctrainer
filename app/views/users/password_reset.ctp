      <div class="panel panel-default" id="forms">
        <div class="panel-heading"><h1><?php __('Password forgotten'); ?></h1></div>
        
        <div class="panel-body">

            <?php echo $this->element('js_error'); ?>

            <br />
            <fieldset>
            <legend><?php __('No problem, we have you covered. :)'); ?></legend>

            <div class="form-group">

            <?php if ($session->read('flash')) { ?>
            <div class="<?php echo $statusbox; ?>">
            <?php echo $session->read('flash'); $session->delete('flash'); ?>
            </div><br />
            <?php } ?>

            <?php __('You received an email with your new password.'); ?>
            </div>

            </fieldset>

        </div>
      </div>

<?php $this->js_addon = ''; ?>
