<div class="schedule buffer">
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
				<td class="schedule-main-table-normal-cell cell-valid-clickable" id="<?=$schedule[$columntime][$rowdate][0]->celldate ?>">
					<?php if(isset($schedule[$columntime][$rowdate]) && $schedule[$columntime][$rowdate][0]->userid === 0): ?>
						<div class="cell"><span class="cell-name cell-userid-0"></span></div>
					<?php elseif(isset($schedule[$columntime][$rowdate])): ?>
						<div class="cell"><span class="cell-name"></span></div>
					<?php endif ?>
				</td>


				<?php } // end of rows "for" loop ?>

		</tr>
		<?php } // end of columns "for" loop ?>

	</table>

</div>

<script>
	$(document).ready(function(){

		redraw();

		$("body").on("click", ".cell-valid-clickable", function(e){
			$(this).removeClass("cell-valid-clickable");
			$(this).addClass("invalid-hour cell-invalid-clickable");
			$.ajax({
				type: "GET",
				url: config.base + "/formscapture/sessionInvalidateHour/<?=$sessiondata->id ?>/" + $(this).attr("id"),
				dataType: "text"
			});
		});

		$("body").on("click", ".cell-invalid-clickable", function(){
			$(this).removeClass("invalid-hour cell-invalid-clickable");	
			$(this).addClass("cell-valid-clickable");
			$.ajax({
				type: "GET",
				url: config.base + "/formscapture/sessionValidateHour/<?=$sessiondata->id ?>/" + $(this).attr("id"),
				dataType: "text"
			});

		});

		function redraw()
		{
			$(".cell-userid-0").parent().parent().addClass("invalid-hour cell-invalid-clickable");
			$(".cell-userid-0").parent().parent().removeClass("cell-valid-clickable");
		}

	});






</script>