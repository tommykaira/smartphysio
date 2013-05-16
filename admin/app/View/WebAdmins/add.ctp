<div class="webAdmins form">
<?php echo $this->Form->create('WebAdmin'); ?>
	<fieldset>
		<legend><?php echo __('Add Web Admin'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('name');
		echo $this->Form->input('staus');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Web Admins'), array('action' => 'index')); ?></li>
	</ul>
</div>
