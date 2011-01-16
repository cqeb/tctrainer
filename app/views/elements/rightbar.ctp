<div class="box">
<b><?php __('Hot News'); ?></b>
<br /><br />
<?php if ( $session_userid ) { ?>
<a href="/trainer/payments/subscribe_triplans"><b>&raquo; <?php __('Become PREMIUM'); ?></b></a>
<br />
<?php } ?>
<a href="/blog/<?php if ( $locale != 'eng' || $locale == '' ) { ?>de/<?php } else { ?>en/<?php } ?>" target="_blank">&raquo; <?php __('TriCoreTraining Blog'); ?></a>
</div>

<div class="box<?php if ( $_SERVER['HTTP_HOST'] != 'localhost') { ?> last<?php } ?>">
<b><?php __('Recommendation'); ?></b>
<br /><br />

<script type="text/javascript"><!--
/* Sidebar - rechts 2 */
google_ad_client = "ca-pub-1221279145141294";
google_ad_slot = "5636489260";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<!--
<br /><br />
<div class="messagebox">
<center>
<a href="http://www.amazon.de/gp/product/B001NGOYMU?ie=UTF8&tag=trico-21&linkCode=as2&camp=1638&creative=6742&creativeASIN=B001NGOYMU" target="_blank"><img border="0" src="https://images-na.ssl-images-amazon.com/images/I/41WA91iWQBL._SL110_.jpg" alt="Heart rate monitor" /></a><img src="http://www.assoc-amazon.de/e/ir?t=trico-21&l=as2&o=3&a=B001NGOYMU" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
</center>
<?php __('Still no heart rate monitor?'); ?>
</div>  
-->
   
<?php if ( $_SERVER['HTTP_HOST'] == 'localhost' ) { ?>
</div>
<div class="box last">
<b>Debugging (only localhost)</b>
<br /><br />
<ul>
        <li><a target="_blank" href="<?php echo Configure::read('App.serverUrl'); ?>/app/webroot/flash.php"><?php __('Graphs'); ?></a></li>
        <li><a target="_blank" href="/phpmyadmin/"><?php __('PHPMyAdmin'); ?></a></li>
        <li><a target="_blank" href="/trainer/starts/fill_my_database"><?php __('Fill my database'); ?></a></li>
        <li><a target="_blank" href="/trainer/trainingplans/get?debug=1">DEBUG Trainingplan</a></li>
</ul>
<?php } ?>

</div>