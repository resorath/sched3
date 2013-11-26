<div class="schedule">
	<?php if($schedule != NULL): ?>

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
				<td class="schedule-main-table-normal-cell" id="cell-<?=$columntime ?>-<?=$rowdate ?>">
					<?php if(isset($schedule[$columntime][$rowdate])) 
						   {
						   		foreach($schedule[$columntime][$rowdate] as $cell) { ?>
									<div class="cell"><span class="cell-name cell-userid-<?= $cell->userid ?>"><?= $cell->realname ?></span></div>
								<?php } // end members of a timeslot "for" loop ?>
					<?php } // end if ?>
				</td>


				<?php } // end of rows "for" loop ?>

		</tr>
		<?php } // end of columns "for" loop ?>

	</table>
	<?php else: ?>
	<div class="container">
		There doesn't seem to be anything here...
		<br/>
		<br/>
		yet
	</div>
	<?php endif ?>


</div>

<script>
	$(document).ready(function(){
		$(".cell-userid-0").parent().parent().addClass("invalid-hour");

	});


</script>