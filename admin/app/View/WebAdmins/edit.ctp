<div class="webAdmins form">
<?php echo $this->Form->create('WebAdmin'); ?>
	<fieldset>
		<legend><?php echo __('Edit Web Admin'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('WebAdmin.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('WebAdmin.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Web Admins'), array('action' => 'index')); ?></li>
	</ul>
</div>
