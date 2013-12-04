<div class="headeradjuster">
	<div class="header">
		<h3><?=$sessiondata->title ?></h3>
    	<div class="schedulecontrolicons-options">
		    <div class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-list icon-large options-blacken"></i></a>
			    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			    	<li class="dropdown-submenu">
			    		<a href="#" tabindex="-1"><i class="icon-fixed-width icon-calendar"></i> View a Different Calendar</a>
			    		<ul class="dropdown-menu">
			    			<?php
			    			$i = 0;
			    			foreach($availablesessions as $sessiongroupname => $sessiongroup) {
			    				?><li class="disabled"><a href="#"><?=$sessiongroupname ?></a></li><?php
			    				foreach($sessiongroup as $sesgroupindex => $session)
			    				{
			    					?><li><a href="<?=base_url("changeavailability/changesession/" . $session['sessionId']) ?>"><?=$session['title'] ?></a></li><?php
			    				}
			    				if(++$i !== count($availablesessions))
			    				{
			    					?><li class="divider"></li><?php
			    				}
			    			}
			    			?>



			    		</ul>
			   		</li>
			   		<li><a href="#"><i class="icon-fixed-width icon-th"></i> Show Compiled Availability</a></li>
			    </ul>
			</div>
		</div>
    </div>
</div>
<div class="container well">
	<p>Please list your availability for this session. You can change your availability until a couple days before the start of the session.</p>
	<?php if($sessiondata->scheduleType == "r"): ?>
		<p>This session runs from <?=date("M dS, Y", $sessiondata->startDate) ?> to <?=date("M dS, Y", $sessiondata->endDate) ?></p>

	<?php endif ?>
</div>

<div class="schedule">
	<table class="schedule-main-table">
		<!-- Top Date/Days -->
		<tr class="schedule-main-table-top-row">
			<td class="schedule-main-table-corner"></td>
			<?php for($i = 0; $i<sizeof($toprow['days']); $i++) { ?>
			<td><div class="date-aligner date-aligner-large"><span class="small-day"><?php if($sessiondata->scheduleType == "r") { echo($toprow['days'][$i]); } else { echo(date("Md",$toprow['unixdate'][$i]) . " " . date("D", $toprow['unixdate'][$i])); } ?></span></div></td>
			<?php } ?>
		</tr>
		<!-- END Top Date/Days -->
		<!-- Time/Schedule Rows -->
		<?php foreach($firstcolumn as $columntime) { ?>
				
		<tr>
			<td class="schedule-main-table-first-column"><?=strrev(substr_replace(strrev($columntime), ":", 2, 0)); ?></td>
				<?php if($sessiondata->scheduleType == "r") { $index = "dayindex"; } else  { $index = "unixdate"; } ?>
				<?php foreach($toprow[$index] as $rowdate) { ?>
				<td class="schedule-main-table-normal-cell cell-unavailable-clickable" id="<?=$schedule[$columntime][$rowdate][0]->celldate ?>">
					<?php if(isset($schedule[$columntime][$rowdate]) && $schedule[$columntime][$rowdate][0]->userid === 0): ?>
						<div class="cell"><span class="cell-name cell-userid-0"></span></div>
					<?php elseif(isset($schedule[$columntime][$rowdate]) && $schedule[$columntime][$rowdate][0]->userid === $_SESSION['userid']): ?>
						<div class="cell"><span class="cell-name cell-activeuser"></span></div>
					<?php elseif(isset($schedule[$columntime][$rowdate])): ?>
						<div class="cell"><span class="cell-name"></span></div>
					<?php endif ?>
				</td>


				<?php } // end of rows "for" loop ?>

		</tr>
		<?php } // end of columns "for" loop ?>

	</table>

</div>

<?php if(@count($exceptions) > 0): ?>
<div class="exceptionscontainer">
	<h2>Special Holiday Hours</h2>
	<p>These hours are an exception to the above schedule. Please select if you can work these hours.
	<?php foreach($exceptions as $exception): ?>
		<div class="cell">
			<span id="e<?=$exception['date'] ?>" class="btn exceptioncell <?=($exception['scheduled']?"available-hour":"") ?> cell-name cell-<?=($exception['scheduled']?"":"un"); ?>available-clickable">
				<?=date("l, F jS Y h:i A", $exception['date']) ?>
			</span>
		</div>
	
	<?php endforeach ?>
</div>

<?php endif ?>

<script>
	$(document).ready(function(){

		redraw();

		$("body").on("click", ".cell-unavailable-clickable", function(e){
			$(this).removeClass("cell-unavailable-clickable");
			$(this).addClass("available-hour cell-available-clickable");
			$.ajax({
				type: "GET",
				url: config.base + "/formscapture/userAddAvailability/<?=$sessiondata->id ?>/<?=$_SESSION['userid'] ?>/" + $(this).attr("id"),
				dataType: "text"
			});
		});

		$("body").on("click", ".cell-available-clickable", function(){
			$(this).removeClass("available-hour cell-available-clickable");	
			$(this).addClass("cell-unavailable-clickable");
			var _this = $(this);
			$.get(config.base + "/formscapture/userRemoveAvailability/<?=$sessiondata->id ?>/<?=$_SESSION['userid'] ?>/" + $(this).attr("id"), function(data){
				if(data == "scheduled")
				{
					_this.removeClass("cell-unavailable-clickable");
					_this.addClass("available-hour cell-available-clickable");	

					notify("Sorry, you can not remove availability for hours you are scheduled for.", "error");
				}

			});
			/*$.ajax({
				type: "GET",
				url: config.base + "/formscapture/userRemoveAvailability/<?=$sessiondata->id ?>/<?=$_SESSION['userid'] ?>/" + $(this).attr("id"),
				dataType: "text"
			});*/

		});

		function redraw()
		{
			$(".cell-userid-0").parent().parent().addClass("invalid-hour");
			$(".cell-userid-0").parent().parent().removeClass("cell-unavailable-clickable");

			$(".cell-activeuser").parent().parent().addClass("available-hour cell-available-clickable");
			$(".cell-activeuser").parent().parent().removeClass("cell-unavailable-clickable");
		}

	});






</script>