<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $title_for_layout; ?></title>
    	
    	<?php 
    		echo $this->Html->css(array(
    			'bootstrap/css/bootstrap.min',
    			'bootstrap/css/bootstrap-responsive.min',
    			'blue',
    			'lib/jBreadcrumbs/css/BreadCrumb',
    			'lib/qtip2/jquery.qtip.min',
    			'lib/colorbox/colorbox',
    			'lib/google-code-prettify/prettify',
    			'lib/sticky/sticky',
    			'splashy/splashy',
    			'flags/flags',
    			'lib/fullcalendar/fullcalendar_gebo',
    			'style'
    		));
    	?>
       			
            <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" />
	
        <!-- Favicon -->
            <link rel="shortcut icon" href="favicon.ico" />
		
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="/css/ie.css" />
            <script src="/js/ie/html5.js"></script>
			<script src="/js/ie/respond.min.js"></script>
			<script src="/lib/flot/excanvas.min.js"></script>
        <![endif]-->
		
		<script>
			//* hide all elements & show preloader
			document.getElementsByTagName('html')[0].className = 'js';
		</script>
		<?php
			echo $this->Html->meta('icon');	
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
    </head>
    <body>
		
		<!-- style switcher -->
		<div class="style_switcher">
            <a href="javascript:void(0)" class="blue_theme th_active" title="blue">blue</a>
            <a href="javascript:void(0)" class="dark_theme" title="dark">dark</a>
            <a href="javascript:void(0)" class="green_theme" title="green">green</a>
            <a href="javascript:void(0)" class="brown_theme" title="brown">brown</a>
			<a href="javascript:void(0)" class="eastern_blue_theme" title="eastern_blue">eastern blue</a>
            <a href="javascript:void(0)" class="tamarillo_theme" title="tamarillo">tamarillo</a>
        </div>
		
		<div id="maincontainer" class="clearfix">
			<!-- header -->
            <header>
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container-fluid">
                            <a class="brand" href=""><i class="icon-home icon-white"></i> <?php echo $site_name;?></a>
                            <ul class="nav user_menu pull-right">
                               <!-- <li class="hidden-phone hidden-tablet">
                                    <div class="nb_boxes clearfix">
                                        <a data-toggle="modal" data-backdrop="static" href="#myMail" class="label ttip_b" title="New messages">25 <i class="splashy-mail_light"></i></a>
                                        <a data-toggle="modal" data-backdrop="static" href="#myTasks" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
                                    </div>
                                </li> -->
				<!-- <li class="divider-vertical hidden-phone hidden-tablet"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle nav_condensed" data-toggle="dropdown"><i class="flag-gb"></i> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="javascript:void(0)"><i class="flag-de"></i> Deutsch</a></li>
										<li><a href="javascript:void(0)"><i class="flag-fr"></i> Français</a></li>
										<li><a href="javascript:void(0)"><i class="flag-es"></i> Español</a></li>
										<li><a href="javascript:void(0)"><i class="flag-ru"></i> Pусский</a></li>
                                    </ul>
                                </li> -->
                                <li class="divider-vertical hidden-phone hidden-tablet"></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ucwords($this->Session->read('admin_username'));?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
										<li><a href="javascript:void(0)">My Profile</a></li>
										<li><a href="javascript:void(0)">Another action</a></li>
										<li class="divider"></li>
										<li><?php echo $this->Html->link(__('Log Out'), array('controller' => 'WebAdmins', 'action' => 'logout'));?></li>
                                    </ul>
                                </li>
                            </ul>
							<a data-target=".nav-collapse" data-toggle="collapse" class="btn_menu">
								<span class="icon-align-justify icon-white"></span>
							</a>
                            
                            <!-- upper menu -->
                          
                        </div>
                    </div>
                </div>
  <!--              <div class="modal hide fade" id="myMail">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">×</button>
                        <h3>New messages</h3>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
                        <table class="table table-condensed table-striped" data-rowlink="a">
                            <thead>
                                <tr>
                                    <th>Sender</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Declan Pamphlett</td>
                                    <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
                                    <td>23/05/2012</td>
                                    <td>25KB</td>
                                </tr>
                                <tr>
                                    <td>Erin Church</td>
                                    <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
                                    <td>24/05/2012</td>
                                    <td>15KB</td>
                                </tr>
                                <tr>
                                    <td>Koby Auld</td>
                                    <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
                                    <td>25/05/2012</td>
                                    <td>28KB</td>
                                </tr>
                                <tr>
                                    <td>Anthony Pound</td>
                                    <td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
                                    <td>25/05/2012</td>
                                    <td>33KB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn">Go to mailbox</a>
                    </div>
                </div> -->

                <!--<div class="modal hide fade" id="myTasks">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">×</button>
                        <h3>New Tasks</h3>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
                        <table class="table table-condensed table-striped" data-rowlink="a">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Summary</th>
                                    <th>Updated</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P-23</td>
                                    <td><a href="javascript:void(0)">Admin should not break if URL&hellip;</a></td>
                                    <td>23/05/2012</td>
                                    <td class="tac"><span class="label label-important">High</span></td>
                                    <td>Open</td>
                                </tr>
                                <tr>
                                    <td>P-18</td>
                                    <td><a href="javascript:void(0)">Displaying submenus in custom&hellip;</a></td>
                                    <td>22/05/2012</td>
                                    <td class="tac"><span class="label label-warning">Medium</span></td>
                                    <td>Reopen</td>
                                </tr>
                                <tr>
                                    <td>P-25</td>
                                    <td><a href="javascript:void(0)">Featured image on post types&hellip;</a></td>
                                    <td>22/05/2012</td>
                                    <td class="tac"><span class="label label-success">Low</span></td>
                                    <td>Updated</td>
                                </tr>
                                <tr>
                                    <td>P-10</td>
                                    <td><a href="javascript:void(0)">Multiple feed fixes and&hellip;</a></td>
                                    <td>17/05/2012</td>
                                    <td class="tac"><span class="label label-warning">Medium</span></td>
                                    <td>Open</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0)" class="btn">Go to task manager</a>
                    </div>
                </div> -->
            </header>
            
            <!-- main content -->
            <div id="contentwrapper">
                <div class="main_content">
                    <?php echo $this->Session->flash(); ?>

					<?php echo $this->fetch('content'); ?>
                        
                </div>
            </div>
            
			<!-- sidebar -->
            <?php echo $this->element('sidebar');?>
			
			
            <?php 
            	echo $this->Html->script(array(
            		'jquery.min',
            		'jquery.debouncedresize.min',
            		'jquery.actual.min',
            		'jquery.cookie.min',
            		'bootstrap/js/bootstrap.min',
            		'lib/qtip2/jquery.qtip.min',
            		'lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min',
            		'ios-orientationchange-fix',
            		'lib/antiscroll/antiscroll',
            		'lib/antiscroll/jquery-mousewheel',
            		'gebo_common',
            		'bootstrap.plugins.min',
            		'forms/jquery.autosize.min',
            		'lib/chosen/chosen.jquery.min',
            		'gebo_user_profile'
            	));
            ?>
           
           	<?php echo $this->Html->script('ajaxfileupload');?>
			<?php echo $this->Html->script('physio');?>
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
			</script>
		
		</div>
	</body>
</html>