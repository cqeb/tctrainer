                          <b><?php __('Recommendation'); ?></b><br />
                          <a href="http://www.google.com/adsense" target="_blank">GoogleAds</a>

                          <br /><br />
                          <?php __('Switch language to'); ?>
                          <br />
                          [<?php echo $html->link(__('English', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "eng")); ?>]
                          <br />
                          [<?php echo $html->link(__('Deutsch', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "deu")); ?>]
                          <br />
                          <br />
                          <?php __('Current language'); ?>:
                          <?php echo $locale; ?>
                          
                          
                          <br /><br />
                          <div class="messagebox">
                          <?php __('You MUST have a heart rate monitor like ') . '<a href="http://www.amazon.de/gp/product/B001NGOYMU?ie=UTF8&tag=trico-21&linkCode=as2&camp=1638&creative=6742&creativeASIN=B001NGOYMU" target="_blank">POLAR</a> ' . __('for your training as we offer heart rate oriented trainingplans only.') ?>
                          <br /><br />
                          <center>
                          <a href="http://www.amazon.de/gp/product/B001NGOYMU?ie=UTF8&tag=trico-21&linkCode=as2&camp=1638&creative=6742&creativeASIN=B001NGOYMU" target="_blank"><img border="0" src="https://images-na.ssl-images-amazon.com/images/I/41WA91iWQBL._SL110_.jpg" alt="Heart rate monitor" /></a><img src="http://www.assoc-amazon.de/e/ir?t=trico-21&l=as2&o=3&a=B001NGOYMU" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
                          </center>
                          </div>  
                          
<h2>Debugging</h2>
<ul>
        <li><a href="<?php echo Configure::read('App.serverUrl'); ?>/app/webroot/flash.php">(<?php __('Graphs'); ?>)</a></li>
        <li><a href="/phpmyadmin/">(<?php __('PHPMyAdmin'); ?>)</a></li>
        <li><a href="/trainer/starts/fill_my_database">(<?php __('Fill my database'); ?>)</a></li>
</ul>

