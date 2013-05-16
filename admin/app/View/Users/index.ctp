<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">List of all Members</h3>
		
		<div id="dt_gal_wrapper" class="dataTables_wrapper form-inline" role="grid">
			
			<table class="table table-bordered table-striped table_vam dataTable" id="dt_gal" aria-describedby="dt_gal_info">
				<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('practice_name'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th><?php echo $this->Paginator->sort('first_name'); ?></th>
						<th><?php echo $this->Paginator->sort('last_name'); ?></th>
						<th><?php echo $this->Paginator->sort('number'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['practice_name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['number']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="icon-eye-open"></i>', array('action' => 'view', $user['User']['id']), array('escape' => FALSE,'title' => 'View')); ?>
							<?php echo $this->Html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $user['User']['id']), array('escape' => FALSE, 'title' => 'Edit')); ?>
							<?php echo $this->Form->postLink('<i class="icon-trash"></i>', array('action' => 'delete', $user['User']['id']), array('escape' => FALSE, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
			<div class="row">
				<div class="span6">
					 <div class="dataTables_info" id="dt_gal_info">
						<?php
						echo $this->Paginator->counter(array(
						'format' => __('Showing {:page} to {:pages} pages, of {:count} members')
						));
						?>
						
					</div>
				</div>
				<div class="span6">
					<!--<div class="dataTables_paginate paging_bootstrap pagination"> -->
					    <div class="dataTables_paginate paging_bootstrap paging">
					    
					    	<?php echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?>
					    	<?php echo $this->Paginator->numbers(array('separator' => ''));?>
					    	<?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?>
					    	
						<!--<ul>					
							<li class="prev disabled">
							<?php echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?>
							</li>
							<li class="active">
								<?php echo $this->Paginator->numbers(array('separator' => ''));?>
							</li>
							<li class="next disabled">
							<?php //echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?>
							</li>
							
							
						</ul>-->
					</div>
				</div>
	
			</div>
			
		</div>

	</div>
</div>