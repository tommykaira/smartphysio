<a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r"
	title="Hide Sidebar">Sidebar switch</a>
<div class="sidebar">

	<div class="antiScroll">
		<div class="antiscroll-inner">
			<div class="antiscroll-content">

				<div class="sidebar_inner">
				<?php
					echo $this->FilterForm->create(null,array("class" => "form form-inline"));
					echo $this->FilterForm->input('filter1',array("class" => "input-medium", "placeholder" => "Search...", "required" => "required"));
				?>
					<button type="submit" class="btn">
						<i class="icon-search"></i>
					</button>
				<?php
					echo $this->FilterForm->end();
				?>
					<div id="side_accordion" class="accordion">
						<!--<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseOne" data-parent="#side_accordion"
									data-toggle="collapse" class="accordion-toggle"> <i
									class="icon-folder-close"></i> Content </a>
							</div>
							<div class="accordion-body collapse" id="collapseOne">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li><a href="javascript:void(0)">Articles</a></li>
										<li><a href="javascript:void(0)">News</a></li>
										<li><a href="javascript:void(0)">Newsletters</a></li>
										<li><a href="javascript:void(0)">Comments</a></li>
									</ul>
								</div>
							</div>
						</div>

 
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseTwo" data-parent="#side_accordion"
									data-toggle="collapse" class="accordion-toggle"> <i
									class="icon-th"></i> Modules </a>
							</div>
							<div class="accordion-body collapse" id="collapseTwo">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li><a href="javascript:void(0)">Content blocks</a></li>
										<li><a href="javascript:void(0)">Tags</a></li>
										<li><a href="javascript:void(0)">Blog</a></li>
										<li><a href="javascript:void(0)">FAQ</a></li>
										<li><a href="javascript:void(0)">Formbuilder</a></li>
										<li><a href="javascript:void(0)">Location</a></li>
										<li><a href="javascript:void(0)">Profiles</a></li>
									</ul>
								</div>
							</div>
						</div>-->

						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseThree" data-parent="#side_accordion"
									data-toggle="collapse" class="accordion-toggle"> <i
									class="icon-user"></i> Member manager </a>
							</div>
							<div class="accordion-body collapse <?php echo(strtolower($this->params['controller']) == 'users') ? 'in' : '';?>" id="collapseThree">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li class="<?php echo (strtolower($this->params['controller']) == 'users' && strtolower($this->params['action']) == 'index') ? 'active' : '';?>">
											<?php echo $this->Html->link(__('List of Members'), array('controller' => 'Users', 'action' => 'index'));?>
										</li>
										<li class="<?php echo (strtolower($this->params['controller']) == 'users' && strtolower($this->params['action']) == 'add') ? 'active' : '';?>">
											<?php echo $this->Html->link(__('Add Member'), array('controller' => 'Users', 'action' => 'add'));?>
										</li>										
									</ul>

								</div>
							</div>
						</div>
<!-- 
						<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseFour" data-parent="#side_accordion"
									data-toggle="collapse" class="accordion-toggle"> <i
									class="icon-cog"></i> Configuration </a>
							</div>
							<div class="accordion-body collapse" id="collapseFour">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li class="nav-header">People</li>
										<li><a href="javascript:void(0)">Account Settings</a></li>
										<li><a href="javascript:void(0)">IP Adress Blocking</a></li>
										<li class="nav-header">System</li>
										<li><a href="javascript:void(0)">Site information</a></li>
										<li><a href="javascript:void(0)">Actions</a></li>
										<li><a href="javascript:void(0)">Cron</a></li>
										<li class="divider"></li>
										<li><a href="javascript:void(0)">Help</a></li>
									</ul>
								</div>
							</div>
						</div>
-->
						<!--<div class="accordion-group">
							<div class="accordion-heading">
								<a href="#collapseLong" data-parent="#side_accordion"
									data-toggle="collapse" class="accordion-toggle"> <i
									class="icon-leaf"></i> Long content (scrollbar) </a>
							</div>
							<div class="accordion-body collapse" id="collapseLong">
								<div class="accordion-inner">
									Some text to show sidebar scroll bar<br> Lorem ipsum dolor sit
									amet, consectetur adipiscing elit. Phasellus rhoncus, orci ac
									fermentum imperdiet, purus sapien pharetra diam, at varius nibh
									tellus tristique sem. Nulla congue odio ut augue volutpat
									congue. Nullam id nisl ut augue posuere ullamcorper vitae eget
									nunc. Quisque justo turpis, tristique non fermentum ac, feugiat
									quis lorem. Ut pellentesque, turpis quis auctor laoreet, nibh
									erat volutpat est, id mattis mi elit non massa. Suspendisse
									diam dui, fringilla id pretium non, dapibus eget enim. Duis
									fermentum quam a leo luctus tincidunt euismod sit amet arcu.
									Duis bibendum ultricies libero sed feugiat. Duis ut sapien
									risus. Morbi non nulla sit amet eros fringilla blandit id vel
									augue. Nam placerat ligula lacinia tellus molestie molestie
									vestibulum leo tincidunt. Duis auctor varius risus vitae
									commodo. Fusce nec odio massa, ut dapibus justo. Lorem ipsum
									dolor sit amet, consectetur adipiscing elit. Curabitur dapibus,
									mauris sit amet feugiat tempor, nulla diam gravida magna, in
									facilisis sapien tellus non ligula. Mauris sapien turpis,
									sodales ac lacinia sit amet, porttitor in lacus. Pellentesque
									tincidunt malesuada magna, in egestas augue sodales vel.
									Praesent iaculis sapien at ante sodales facilisis.
								</div>
							</div>
						</div> -->
					</div>

					<div class="push"></div>
				</div>

				<!--<div class="sidebar_info">
					<ul class="unstyled">
						<li><span class="act act-warning">65</span> <strong>New comments</strong>
						</li>
						<li><span class="act act-success">10</span> <strong>New articles</strong>
						</li>
						<li><span class="act act-danger">85</span> <strong>New
								registrations</strong>
						</li>
					</ul>
				</div> -->

			</div>
		</div>
	</div>
</div>