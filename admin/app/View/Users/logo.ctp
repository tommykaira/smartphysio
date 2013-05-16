<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">
		<?php echo ucwords($practice['User']['practice_name']);?>
			Logo
		</h3>
		<div class="row-fluid">
			<div class="span8">
			<?php echo $this->Form->create(NULL, array('class' => 'form-horizontal', 'action' => 'logo/'.$practice['User']['id'],'type' => 'file'));?>

				<fieldset>
					<div class="control-group formSep">
						<label for="fileinput" class="control-label">Logo</label>
						<div class="controls">
							<div data-fileupload="image" class="fileupload fileupload-new">
								<input type="hidden" />
								<div style="width: 200px; height: 200px;"
									class="fileupload-new thumbnail">
									&nbsp;
								</div>
								<div style="width: 80px; height: 80px; line-height: 80px;"
									class="fileupload-preview fileupload-exists thumbnail"></div>
								<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
										<input type="file" id="fileinput" name="data[User][fileinput]" /> </span> <a
									data-dismiss="fileupload" class="btn fileupload-exists"
									href="#">Remove</a> 
							</div>
						</div>
					</div>
					<div class="control-group formSep">
						<label class="control-label">Color Scheme</label>
						<div class="controls">
							<?php
								$options = array(); 
								foreach($schemes as $scheme){ 
									$options[$scheme['ColorScheme']['id']] = $scheme['ColorScheme']['name'];
								}?>							
							<?php echo $this->Form->input('color_scheme_id', array('label' => FALSE, 'class' => 'span5','type' =>'select', 'options' => $options));?>
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
