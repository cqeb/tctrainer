
                   <h1><?php __('Password forgotten'); ?></h1>

                   <?php echo $this->element('js_error'); ?>

                   <br />
                   <fieldset>
                   <legend><?php __('I know it is somewhere in my brain :)'); ?></legend>

                   <?php if ($session->check('Message.flash')) { ?>
                   <div class="<?php echo $statusbox; ?>">
                   <?php $session->flash(); ?>
                   </div><br />
                   <?php } ?>

                   <?php __('You received an e-mail with your new password.'); ?>

                   </fieldset>

<?php $this->js_addon = ''; ?>
