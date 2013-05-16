<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">Member Profile</h3>
		<div class="row-fluid">
			<div class="span8">
				<?php echo $this->Form->create(NULL, array('class' => 'form-horizontal form_validation_ttip', 'novalidate' =>'novalidate'));?>
				
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label">Practice Name <span class="f_req">*</span></label>
							<div class="controls">
								<?php echo $this->Form->input('practice_name', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Email Address</label>
							<div class="controls">
								<?php echo $this->Form->input('email', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">First Name</label>
							<div class="controls">
								<?php echo $this->Form->input('first_name', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Last Name</label>
							<div class="controls">
								<?php echo $this->Form->input('last_name', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Phone Number</label>
							<div class="controls">
								<?php echo $this->Form->input('number', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Website</label>
							<div class="controls">
								<?php echo $this->Form->input('website', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Street</label>
							<div class="controls">
								<?php echo $this->Form->input('street', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Suburb</label>
							<div class="controls">
								<?php echo $this->Form->input('suburb', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">State</label>
							<div class="controls">
								<?php echo $this->Form->input('state', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Postcode</label>
							<div class="controls">
								<?php echo $this->Form->input('postcode', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Country</label>
							<div class="controls">
								<?php echo $this->Form->input('country', array('label'=>FALSE, 'class' => 'input-xlarge'));?>
							</div>
						</div>
						<div class="control-group formSep">
							<label class="control-label">Services</label>
							<div class="controls">
								<?php echo $this->Form->input('services', array('label'=>FALSE, 'class' => 'input-xlarge','type' => 'textarea'));?>
								<em>List of all services, separate with coma.</em>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-gebo" type="submit">Save changes</button>
								
								<button class="btn">Cancel</button>
							</div>
						</div>
					</fieldset>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
