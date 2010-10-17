<ul>
	<li>
		<?php echo $html->link(__('Prices & Register',true),array('controller' => 'users', 'action' => 'add_step1'), array('class' => 'active'))?>
	</li>
	<li>
		<?php echo $html->link(__('Login',true),array('controller' => 'users', 'action' => 'login'), array('class' => 'main'))?>
	</li>
	<li>
		<a href="#"><?php __('Features'); ?></a>
	</li>
  <li>
    <a href="#"><?php __('Magazine'); ?></a>
  </li>
	
</ul>