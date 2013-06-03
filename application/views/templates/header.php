<!DOCTYPE html>
<html>
	<head>
		<title><?=$title ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
		<link href="<?php echo(base_url()); ?>assets/css/base.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/bootstrap-overrides.css" rel="stylesheet" media="screen">



	</head>
	<body>

		<div class="alert alert-block alert-info modal_message" id="loading_box">
		    <img src="<?=base_url() ?>assets/img/ajax-loader.gif">
		</div>

		<div class="logo">
			<img src="<?php echo(base_url()); ?>assets/img/uofc-verticalcrest.png">
		</div>

		<?php if(user_has_role("CANLOGIN")): ?>
		<div class="container" id="navcontainer">
	        <div class="navbar">
	          <div class="navbar-inner">
	            <div class="container">
	              <ul class="nav">
	                <?php if(user_has_role("HASSCHEDULE")): ?><li><a href="#">My Dashboard</a></li><?php endif ?>
	                <?php if(user_has_role("CANLOGIN")): ?><li class="active"><a href="#">Schedule</a></li><?php endif ?>
	                <?php if(user_has_role("CANLOGIN")): ?><li><a href="#">Available Shifts</a></li><?php endif ?>
	                <?php if(user_has_role("HASSCHEDULE")): ?><li><a href="#">My Shifts</a></li><?php endif ?>
	                <?php if(user_has_role("HASSCHEDULE")): ?><li><a href="#">My Metrics</a></li><?php endif ?>
	              
	              </ul>
	            </div>
	          </div>
		    </div>
		</div>
		<?php endif ?>

		<?php if(user_has_role("CANLOGIN")): ?>
	    <div class="usercontrol">
	    	<span class="muted">Hello </span> <?=$userfullname ?>  
	    	<div class="btn-group">
			    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#" id="settings-cog-button"><i class="icon-cog" id="settings-cog"></i></a>
			    <ul class="dropdown-menu pull-right">
			    <li><a href="#"><i class="icon-pencil"></i> Change My Availability</a></li>
			    <li><a href="#"><i class="icon-cogs"></i> Manage my Settings</a></li>
			    <li class="divider"></li>
			    <li><a href="<?=base_url("authenticate/logout") ?>"><i class="icon-signout"></i> Log Out</a></li>
			    </ul>
			</div>
			<?php endif ?>
	   	</div>

	    	<!-- End of header -->