<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('practice_name');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('number');
		echo $this->Form->input('website');
		echo $this->Form->input('street');
		echo $this->Form->input('suburb');
		echo $this->Form->input('state');
		echo $this->Form->input('postcode');
		echo $this->Form->input('country');
		echo $this->Form->input('services');
		
		$expiry_date = date('d/m/Y',strtotime($this->request->data['ExpiryDate']['expiry']));
		echo $this->Form->hidden('ExpiryDate.user_id');
		echo $this->Form->hidden('ExpiryDate.id');
		echo $this->Form->input('ExpiryDate.expiry',array('id'=>'dp1','value'=>$expiry_date));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
