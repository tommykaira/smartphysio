<div class="webAdmins view">
<h2><?php  echo __('Web Admin'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Staus'); ?></dt>
		<dd>
			<?php echo h($webAdmin['WebAdmin']['staus']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Web Admin'), array('action' => 'edit', $webAdmin['WebAdmin']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Web Admin'), array('action' => 'delete', $webAdmin['WebAdmin']['id']), null, __('Are you sure you want to delete # %s?', $webAdmin['WebAdmin']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Web Admins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Web Admin'), array('action' => 'add')); ?> </li>
	</ul>
</div>
