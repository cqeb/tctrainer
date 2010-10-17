
     <h1><?php __('TRAININGSPLANS DASHBOARD'); ?></h1>

     <?php if ($session->check('Message.flash')) { ?>
     <div class="<?php echo $statusbox; ?>">
     <?php $session->flash(); ?>
     </div><br />
     <?php } ?>

     <div class="clear"></div>

     <div id="messagebox">
     <h3>Magazine</h3>
     <ul>
     <li>News</li>
     <li>News</li>
     <li>Features</li>
     </ul>
     </div>

     <br />

     <div id="messagebox">
     <h3><?php __('Referrals'); ?></h3>
     <img src="http://t3.gstatic.com/images?q=tbn:wDvvTFCkekkEmM:http://www.life-donau-ybbs.at/Downloads/20_juni_2007/Fotos/Redner%202007%2006%2020/Bild5_LFMStv_Schremser.JPG" alt="" />
     SUPA Triathlontrainer - so hab ich meinen ersten Ironman geschafft!
     <div class="clear"></div>
     </div>

<?php
      $this->js_addon = "";
?>