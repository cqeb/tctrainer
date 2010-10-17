                          <b><?php __('Recommendation'); ?></b><br />
                          <a href="http://www.google.com/adsense" target="_blank">GoogleAds</a>

                          <br /><br />
                          <?php __('Switch language to'); ?>
                          <br />
                          [<?php echo $html->link(__('English', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "eng")); ?>]
                          <br />
                          [<?php echo $html->link(__('Deutsch', true),array('controller' => 'users', 'action' => 'change_language', 'code' => "ger")); ?>]
                          <br />
                          <br />
                          <?php __('Current language'); ?>:
                          <?php echo $locale; ?>
