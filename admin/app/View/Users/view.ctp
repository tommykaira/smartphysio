<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">Members Info</h3>
		<div class="row-fluid">
			<div class="span8">
				<form class="form-horizontal">
					<fieldset>
						<div class="control-group formSep">
							<label class="control-label">Practice Name</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['practice_name']); ?></strong>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="u_fname" class="control-label">Practice PIN</label>
							<div class="controls text_line">
								<strong><?php echo h($user['AdminPin']['pin']); ?></strong>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="u_fname" class="control-label">Patient PIN</label>
							<div class="controls text_line">
								<strong><?php echo h($user['ClientPin']['pin']); ?></strong>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="fileinput" class="control-label">Logo</label>
							<div class="controls">
								<div data-fileupload="image" class="fileupload fileupload-new">
									<input type="hidden" />
									<div style="width: 80px; height: 80px;" class="fileupload-new thumbnail">
										<?php echo $this->Html->image('/api/files/uploads/' . $user['PracticeLogo']['logo']); ?>
									</div>									
								</div>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="u_fname" class="control-label">Full Name</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['first_name']); ?> <?php echo h($user['User']['last_name']); ?></strong>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="u_email" class="control-label">Email</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['email']); ?></strong>
							</div>
						</div>
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Phone Number</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['number']); ?></strong>							
							</div>
						</div>					
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Website</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['website']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Street</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['street']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Suburb</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['suburb']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">State</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['state']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Postalcode</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['postcode']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Country</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['country']); ?></strong>							
							</div>
						</div>	
						<div class="control-group formSep">
							<label for="u_number" class="control-label">Services</label>
							<div class="controls text_line">
								<strong><?php echo h($user['User']['services']); ?></strong>							
							</div>
						</div>	
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>