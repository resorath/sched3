<!DOCTYPE html>
<html>
	<head>
		<title><?=$title ?></title>
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
		<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">-->
		<link href="<?php echo(base_url()); ?>assets/css/normalize.css" rel="stylesheet" media="screen">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<link href="<?php echo(base_url()); ?>assets/css/bootstrap-combined.no-icons.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/jquery.dataTables.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/jquery.dataTables_themeroller.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/datepicker.css" rel="stylesheet" media="screen">
		<!--<link href="<?php echo(base_url()); ?>assets/css/font-awesome.css" rel="stylesheet" media="screen">-->
		<link href="<?php echo(base_url()); ?>assets/css/bootstrap-overrides.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/base.css" rel="stylesheet" media="screen">
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<!-- header scripts -->
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/bootstrap-datepicker.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/bootstrap-notify.js"></script>

		
		<script src="<?php echo(base_url()); ?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/jquery.color.js"></script>

		<script src="<?php echo(base_url()); ?>assets/js/com.tophatandmonocle.jquery.interface.js"></script>
		<script>
		var config = {
		     base: "<?php echo base_url(); ?>"
		 };
		 </script>

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
	              	<?php // @todo this should be moved out of the view code ?>
	                <?php if(user_has_role("HASSCHEDULE")): ?><li<?php if(strtolower($this->router->fetch_class()) == "dashboard"): ?> class="active"<?php endif ?>><a href="<?=base_url("dashboard") ?>">My Dashboard</a></li><?php endif ?>
	                <?php if(user_has_role("CANLOGIN")): ?><li<?php if(strtolower($this->router->fetch_class()) == "schedule"): ?> class="active"<?php endif ?>><a href="<?=base_url("schedule") ?>">Schedule</a></li><?php endif ?>
	                <?php if(user_has_role("CANLOGIN")): ?><li<?php if(strtolower($this->router->fetch_class()) == "availableshifts"): ?> class="active"<?php endif ?>><a href="<?=base_url("availableshifts") ?>">Available Shifts</a></li><?php endif ?>
	                <?php if(user_has_role("HASSCHEDULE")): ?><li<?php if(strtolower($this->router->fetch_class()) == "myshifts"): ?> class="active"<?php endif ?>><a href="<?=base_url("myshifts") ?>">My Shifts</a></li><?php endif ?>
	                <?php if(user_has_role("HASSCHEDULE")): ?><li<?php if(strtolower($this->router->fetch_class()) == "mymetrics"): ?> class="active"<?php endif ?>><a href="<?=base_url("mymetrics") ?>">My Metrics</a></li><?php endif ?>
	              
	              </ul>
	            </div>
	          </div>
		    </div>
		</div>
		<?php endif ?> 

		<?php if(isset($headermessage)): ?>
		<div class="container container-nav-adjust">
			<div class="alert alert-<?=$headermessagetype ?>">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    <?=$headermessage ?>
		    </div>
		</div>
		<?php endif ?>

		<?php if(user_has_role("CANLOGIN")): ?>
	    <div class="usercontrol">
	    	<span class="muted">Hello </span> <?=$userfullname ?>  
	    	<div class="btn-group">
			    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#" id="settings-cog-button"><i class="icon-cog" id="settings-cog"></i></a>
			    <ul class="dropdown-menu pull-right">
			    <li><a href="<?=base_url("changeavailability") ?>"><i class="icon-pencil"></i> Change My Availability</a></li>
			    <li><a href="#"><i class="icon-cogs"></i> Manage my Settings</a></li>
			    <li class="divider"></li>
			    <li><a href="<?=base_url("authenticate/logout") ?>"><i class="icon-signout"></i> Log Out</a></li>
			    </ul>
			</div>

			<div class="btn-group">
			    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#" id="settings-wrench-button"><i class="icon-wrench" id="settings-wrench"></i></a>
			    <ul class="dropdown-menu pull-right">
			    <li><a href="<?=base_url("managesessions") ?>"><i class="icon-calendar-empty"></i> Manage Sessions</a></li>
			    <li><a href="<?=base_url("manageusers") ?>"><i class="icon-female"></i> Manage Users</a></li>
			    <li><a href="<?=base_url("managegroups") ?>"><i class="icon-group"></i> Manage Groups</a></li>
			    <li class="divider"></li>
			    <li><a href="<?=base_url("applicationsettings") ?>"><i class="icon-puzzle-piece"></i> Application Settings</a></li>
			    </ul>
			</div>
	   	</div>
		<?php endif ?>

		<div class='notifications top-center notify'></div>

		<?php if(isset($notify_message)): ?>
		<script>
		$('.notify').notify({
	    	message: { text: '<?=$notify_message ?>' }
	    	<?php if(isset($notify_type)): ?>,type: "<?=$notify_type ?>" <?php endif ?>
	  	}).show();
		</script>
		<?php endif ?>
	    	<!-- End of header -->