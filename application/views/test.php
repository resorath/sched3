<!DOCTYPE html>
<html>
	<head>
		<title>Sched Test</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
		<link href="<?php echo(base_url()); ?>assets/css/base.css" rel="stylesheet" media="screen">
		<link href="<?php echo(base_url()); ?>assets/css/bootstrap-overrides.css" rel="stylesheet" media="screen">



	</head>
	<body>

		<div class="logo">
			<img src="<?php echo(base_url()); ?>assets/img/uofc-verticalcrest.png">
		</div>
		<div class="container" id="navcontainer">
	        <div class="navbar">
	          <div class="navbar-inner">
	            <div class="container">
	              <ul class="nav">
	                <li class="active"><a href="#">My Dashboard</a></li>
	                <li><a href="#">Schedule</a></li>
	                <li><a href="#">Available Shifts</a></li>
	                <li><a href="#">My Shifts</a></li>
	                <li><a href="#">My Metrics</a></li>
	              
	              </ul>
	            </div>
	          </div>
		    </div>
		</div>

	    <div class="usercontrol">
	    	<span class="muted">Hello </span> Sean Feil  
	    	<div class="btn-group">
			    <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#" id="settings-cog-button"><i class="icon-cog" id="settings-cog"></i></a>
			    <ul class="dropdown-menu pull-right">
			    <li><a href="#"><i class="icon-pencil"></i> Change My Availability</a></li>
			    <li><a href="#"><i class="icon-cogs"></i> Manage my Settings</a></li>
			    <li class="divider"></li>
			    <li><a href="#"><i class="icon-signout"></i> Log Out</a></li>
			    </ul>
			    </div>
	    	</div>

	    <div class="container" id="maincontent">
	    	<div class="headeradjuster">
		    	<div class="header">
		    		<h3>Summer 2013 Schedule</h3>
			    	<div class="schedulecontrolicons-options">
		    		    <div class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-list icon-large options-blacken"></i></a>
						    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						    	<li><a href="#"><i class="icon-fixed-width icon-map-marker"></i> Jump to Today</a></li>
						    	<li><a href="#"><i class="icon-fixed-width icon-screenshot"></i> Jump to...</a></li>
						    	<li><a href="#"><i class="icon-fixed-width icon-calendar"></i> View a Different Calendar</a></li>
						    </ul>
						</div>
					</div>
					<div class="schedulecontrolicons-highlights">
						<div class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-lightbulb icon-large bulb-yellow"></i></i></a>
						    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						    	<li><a href="#"><i class="icon-fixed-width icon-user"></i> Highlight my Hours</a></li>
						    	<li><a href="#"><i class="icon-shopping-cart icon-user"></i> Highlight Available Hours</a></li>
						    	<li class="divider"></li>
						    	<li><a href="#"><i class="icon-fixed-width icon-ban-circle"></i> Turn off Highlighting</a></li>
						    </ul>
						</div>
			    	</div>
			    </div>
			</div>

			<div class="schedule-previous">
				<i class="icon-chevron-left icon-2x"></i>
			</div>

			<div class="schedule-next">
				<i class="icon-chevron-right icon-2x"></i>
			</div>

			<div class="schedule">
				<table class="schedule-main-table">
					<tr class="schedule-main-table-top-row">
						<td class="schedule-main-table-corner"></td>
						<td><div class="date-aligner"><span class="large-date">7</span> <span class="small-day">Sunday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">8</span> <span class="small-day">Monday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">9</span> <span class="small-day">Tuesday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">10</span> <span class="small-day">Wednesday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">11</span> <span class="small-day">Thursday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">12</span> <span class="small-day">Friday</span></div></td>
						<td><div class="date-aligner"><span class="large-date">13</span> <span class="small-day">Saturday</span></div></td>
					</tr>
					<!-- 8:00 -->
					<tr>
						<td class="schedule-main-table-first-column">8:00</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-old-time-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
					</tr>
					<!-- 9:00 -->
					<tr>
						<td class="schedule-main-table-first-column">9:00</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-old-time-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
					</tr>
					<!-- 10:00 -->
					<tr>
						<td class="schedule-main-table-first-column">10:00</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-current-time-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
					</tr>
					<!-- 11:00 -->
					<tr>
						<td class="schedule-main-table-first-column">11:00</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
					</tr>
					<!-- 12:00 -->
					<tr>
						<td class="schedule-main-table-first-column">12:00</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
					</tr>
					<!-- 1:00 -->
					<tr>
						<td class="schedule-main-table-first-column">1:00</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
					</tr>
					<!-- 2:00 -->
					<tr>
						<td class="schedule-main-table-first-column">2:00</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
					</tr>
					<!-- 3:00 -->
					<tr>
						<td class="schedule-main-table-first-column">3:00</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
					</tr>
					<!-- 4:00 -->
					<tr>
						<td class="schedule-main-table-first-column">4:00</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-normal-cell">
							Sean F<br/>
							Abraham L<br/>
							Gerald F<br/>
							George B<br/>
							George W<br/>
						</td>
						<td class="schedule-main-table-invalid-cell">
						</td>
					</tr>
				</table>
			</div>

			<div class="footer">IT Scheduler</div>

	    </div>
		<!-- Footer Scripts -->
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo(base_url()); ?>assets/js/com.tophatandmonocle.jquery.interface.js"></script>
	</body>
</html>