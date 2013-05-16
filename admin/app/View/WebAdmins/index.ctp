<div class="webAdmins index">
	<h2><?php echo __('Web Admins'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('password'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('staus'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($webAdmins as $webAdmin): ?>
	<tr>
		<td><?php echo h($webAdmin['WebAdmin']['id']); ?>&nbsp;</td>
		<td><?php echo h($webAdmin['WebAdmin']['username']); ?>&nbsp;</td>
		<td><?php echo h($webAdmin['WebAdmin']['password']); ?>&nbsp;</td>
		<td><?php echo h($webAdmin['WebAdmin']['name']); ?>&nbsp;</td>
		<td><?php echo h($webAdmin['WebAdmin']['created']); ?>&nbsp;</td>
		<td><?php echo h($webAdmin['WebAdmin']['staus']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $webAdmin['WebAdmin']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $webAdmin['WebAdmin']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $webAdmin['WebAdmin']['id']), null, __('Are you sure you want to delete # %s?', $webAdmin['WebAdmin']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Web Admin'), array('action' => 'add')); ?></li>
	</ul>
</div>
