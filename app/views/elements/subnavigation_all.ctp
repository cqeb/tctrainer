<!--<?php echo $language; ?>-->

<?php if ( !is_numeric($session_userid) ) { ?>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">

          <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">TriCoreTraining? <!--<?php __('Training Plans'); ?>--><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/trainer/starts/index/#howitworks"><?php __('What is'); ?> TriCoreTraining?</a></li>
                  <li><a href="/trainer/starts/index/#features"><?php __('Features'); ?></a></li>
                  <li><a href="/trainer/starts/index/#references"><?php __('References'); ?></a></li>
                  <li><a href="/trainer/starts/index/#newsletter">&raquo; <?php __('Get Training Hints'); ?></a></li>                          
                  <li><a href="/trainer/starts/index/#pricing"><?php __('Pricing'); ?></a></li>
                  <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>about/"><?php __('More about'); ?> TriCoreTraining</a></li>
                </ul>
          </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('How to start'); ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><?php echo $html->link(__('Get started',true), '/users/register/'); ?></li>
                  <li><?php echo $html->link(__('Sign in',true), '/users/login/'); ?></li>
                </ul>
          </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('FAQ'); ?> &amp; <?php __('Blog'); ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>"><?php __('Read our blog', false); ?></a></li>
                  <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>category/news/"><?php __('News'); ?></a></li>
                  <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>category/faq/"><?php __('FAQs'); ?></a></li>
                </ul>
          </li>
        </ul>


<form action="#" id="UserLoginFormTop" method="post" accept-charset="utf-8" class="navbar-form navbar-right navbar-small">
  
  <?php __('Change to'); ?>:
  <?php if ( $language != 'eng' || $language == '' ) { ?>
  <?php echo $html->link('English', '/starts/index/code:eng/', array('class' => 'btn btn-success btn-small')); ?>
  <?php } ?>

  <?php if ( $language != 'deu' ) { ?>
  <?php echo $html->link('Deutsch','/starts/index/code:deu/', array('class' => 'btn btn-success btn-small')); ?>
  <?php } ?>

  <?php echo $html->link(__('Sign In',true),'/users/login/', array('class' => 'btn btn-warning btn-small')); ?>
  <?php echo $html->link(__('Facebook Sign In',true),'/users/login_facebook/', array('class' => 'btn btn-warning btn-small')); ?>

</form>

<?php } else { ?>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('Training'); ?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li style="padding-left: 20px;"><b><?php __('Training Plan'); ?></b></li>

                    <li><?php echo $html->link(__('Your Training Plan',true), '/trainingplans/view/')?></li>
                    <li><?php echo $html->link(__('Training Log',true), '/trainingstatistics/list_trainings/')?></li>
                    <li><?php echo $html->link(__('Your Races',true),'/competitions/list_competitions/')?></li>
                  
                    <li style="padding-left: 20px;"><b><?php __('Statistics'); ?></b></li>
                    <li><?php echo $html->link(__('How fit am I?',true),'/trainingstatistics/statistics_trimp/')?></li>
                    <li><?php echo $html->link(__('How fast am I?',true),'/trainingstatistics/statistics_formcurve/')?></li>
                    <li><?php echo $html->link(__('Can I finish my goal?',true),'/trainingstatistics/statistics_competition/')?></li>
                    <li><?php echo $html->link(__('How much have I lost?',true),'/trainingstatistics/statistics_howmuchhaveilost/')?></li>
                    <li><?php echo $html->link(__('What have I achieved?',true),'/trainingstatistics/statistics_whathaveidone/')?></li>

                  </ul>
            </li>
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('Settings'); ?><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><?php echo $html->link(__('Edit training info',true),'/users/edit_traininginfo/')?></li>
                    <li><?php echo $html->link(__('Edit weight goals',true),'/users/edit_weight/')?></li>
                    <li><?php echo $html->link(__('Edit profile',true), '/users/edit_userinfo/')?></li>
                    <li><?php echo $html->link(__('Change password',true), '/users/edit_password/')?></li>
                    <li><?php echo $html->link(__('Change metric',true),'/users/edit_metric/')?></li>
                    <?php if ( isset( $userobject ) && $userobject['advanced_features'] ) { ?>
                    <!--
                    <li>Demo: <?php echo $html->link(__('Edit images',true).' - Beta', '/users/edit_images/')?></li>
                    -->
                    <?php } ?>
                    <li><a href="mailto:support@tricoretraining.com"><?php __('Feedback'); ?></a></li>

                  </ul>
            </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('Premium'); ?><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/trainer/payments/subscribe_triplans/"><b><?php __('Subscribe'); ?></b></a></li>
                    <li><?php echo $html->link(__('Show payments',true), '/payments/show_payments/')?></li>
                    <li><?php echo $html->link(__('Cancel subscription :(',true), '/payments/unsubscribe_triplans/')?></li>
                    <?php if ( isset( $userobject ) && $userobject['admin'] == '1' ) { ?>
                    <br />
                    &nbsp;&nbsp;&nbsp;<b>Admin (only for admin)</b>
                    <li><a href="/trainer/users/list_users/"><?php __('Administrate users'); ?></a></li>      
                    <li><a target="_blank" href="/trainer/users/fill_my_database/"><?php __('Fill my database'); ?></a></li>
                    <li><a target="_blank" href="/trainer/trainingplans/get/?debug=1">DEBUG Trainingplan</a></li>
                    <li><a href="/trainer/starts/index/en/u:TRANSACTIONID/">Redirect workout (u)</a></li> 
                    <li><a href="/trainer/starts/index/en/ur:<?php echo base64_encode("1"); ?>/">Redirect no Money (ur):1</a></li> 
                    <li><a href="/trainer/starts/index/en/urm:<?php echo base64_encode("1"); ?>/">Redirect Money (urm):1</a></li>
                    <li><a href="/trainer/starts/index/en/c:<?php echo base64_encode("@gentics.com"); ?>/">Company:@gentics.com</a></li>
                    <?php if ( isset( $session_userid ) ) { ?>
                    <li><a href="/trainer/starts/index/code:<?php if ( $language == 'deu' ) { ?>deu/<?php } else { ?>eng/<?php } ?>ur:<?php echo base64_encode($userobject['id']); ?>/"><?php __('Invite your friends'); ?></a></li>
                    <?php } ?>                          
                    <?php } ?>
                  </ul>
            </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php __('FAQ'); ?> &amp; <?php __('Blog'); ?><b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>"><?php __('Read our Blog'); ?></a></li>
                    <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>category/news/"><?php __('News'); ?></a></li>
                    <li><a href="/blog/<?php if ( $language == 'deu' ) { ?>de/<?php } else { ?>en/<?php } ?>category/faq/"><?php __('FAQs'); ?></a></li>

                  </ul>
            </li>
          </ul>

<form action="#" id="UserLoginFormTop" method="post" accept-charset="utf-8" class="navbar-form navbar-right navbar-small">
  
  <?php __('Change to'); ?>:
  <?php if ( $language != 'eng' || $language == '' ) { ?>
  <?php echo $html->link('English', '/starts/index/code:eng/', array('class' => 'btn btn-success btn-small')); ?>
  <?php } ?>

  <?php if ( $language != 'deu' ) { ?>
  <?php echo $html->link('Deutsch','/starts/index/code:deu/', array('class' => 'btn btn-success btn-small')); ?>
  <?php } ?>

  <?php if ( isset ( $userobject ) ) { ?>
  <?php echo $html->link(__('Sign out',true), '/users/logout/code:' . $language . '/', array('class' => 'btn btn-success btn-small')); ?>
  <?php } ?>
  
</form>

<?php } ?>
