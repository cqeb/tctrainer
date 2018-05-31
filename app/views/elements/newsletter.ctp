<div class="container">
	<div class="row">
		<div class="col-12 col-lg-12 text-center">
			<div class="panel panel-default" id="forms">							
				<div class="panel-body">
					<h2><?php __('Get Triathlon training hints?'); ?></h2>

					<?php echo $this->element('js_error'); ?>
					<?php echo $form->create('Starts', array('action' => 'index/newsletter:true/#newsletter', 'class' => 'form-horizontal'));?>
					<fieldset>
						<legend>
							<h3><?php __('You\'ll receive regular tips and hints on a perfect training plan.'); ?></h3>
						</legend>

					<?php if ($session->read('flash')) { ?>
						<center>
						<div style="width:50%;" class="<?php echo $statusbox; ?>">
							<?php echo $session->read('flash'); $session->delete('flash'); ?>
						</div>
						</center><br />
					<?php } ?>

					<div class="form-group">   
<?php

      	echo $form->input('email',
           array(
           'before' => '',
           'after' => '',
           'between' => '',
		   'maxLength' => 255,   
		   'style' => 'width: 50%',   
		   'required' => true,    
           'class' => 'required form-control',
           'label' => array( 'class' => 'control-label', 'text' =>  __('Email', true) . ' *' ),
           'error' => array( 
              'notempty' => __('You have to enter an email', true),
              'wrap' => 'span', 
              'class' => 'text-danger'
           )
		  ));
?>
					</div>
					<div class="form-group">
<?php
	  	echo $form->input('firstname',
			array(
			'before' => '',
			'after' => '',
			'between' => '',
			'maxLength' => 255,  
			'style' => 'width: 50%',           
			'class' => 'form-control',
			'label' => array( 'class' => 'control-label', 'text' => __('Firstname', true) )
		));
?>
					</div>
					<div class="form-group">
<?php

		echo $form->input('lastname',
			array(
			'before' => '',
			'after' => '',
			'between' => '',
			'maxLength' => 255,   
			'style' => 'width: 50%',          
			'class' => 'form-control',
			'label' => array( 'class' => 'control-label', 'text' => __('Lastname', true) ),
		));		
?>
					</div>
					<?php echo $this->Form->submit(__('Subscribe', true), array('class'=>'btn btn-primary')); ?>
						
					</fieldset>
					<?php echo $form->end();?>

					<?php $this->js_addon = ''; ?>

					<br /><br />
					<i><span class="asterisk">*</span> <?php __('indicates required'); ?></i>

					<p><i>
						<?php __('With your subscription you agree that we are allowed to send you newsletters and mailings on a regular base. Thanks a lot!'); ?>
					</i></p>

					</div>
				</div>
			</div>
    </div>
</div>
