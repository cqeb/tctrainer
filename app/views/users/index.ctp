
     <h1><?php __('TRAININGSPLANS DASHBOARD'); ?></h1>

     <?php if ($session->check('Message.flash')) { ?>
     <div class="<?php echo $statusbox; ?>">
     <?php $session->flash(); ?>
     </div><br />
     <?php } ?>

     <div class="clear"></div>

     <div id="messagebox">
     <h3><?php __('Magazine'); ?></h3>
     <ul>
       <li>News</li>
       <li>News</li>
       <li>Features</li>
     </ul>
     </div>

     <br />

     <div id="messagebox">
     <h3><?php __('Referrals'); ?></h3>
     SUPA Triathlontrainer - so hab ich meinen ersten Ironman geschafft!
     <img src="" alt="" />
     <div class="clear"></div>
     </div>

<?php
      $this->js_addon = "";
?>