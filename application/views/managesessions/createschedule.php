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
					   		foreach($schedule[$columntime][$rowdate] as $cell) 
					   			{ ?>
					   			
								<div class="cell cell-narrow">
									<span class="cell-name cell-userid-<?= $cell->userid ?>">
										<label class="tiny-name"><?php if($cell->userid > 0): ?>
											<input type="checkbox" data-time="<?=$columntime ?>" data-date="<?=$rowdate ?>" data-userid="<?= $cell->userid ?>" class="cell-checkbox cell-checkbox-corrid-<?= $cell->userid ?>" <?php if($cell->celltype == models\Cell::$CELLTYPEPERSON) { echo("checked"); } ?>><?php endif ?> <?= $cell->realname ?>
										</label>
									</span>
								</div>
									
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

		var colored = new Array();
		var coloredcb = new Array();
		$(".cell-name").hover(function(){
			var similar = $(this).attr('class').split(' ');
			var i = 0;
			$('.' + similar[1]).each(function(i, obj) {
			    $(obj).parent().parent().css('backgroundColor', 'lightGreen');
			    colored[i++] = obj;

			    if($(obj).find('input').is(':checked'))
			    {
			    	$(obj).parent().parent().css('backgroundColor', 'orangered');
			    }
			});
		},
		function(){
			for(i = 0; i < colored.length; i++)
			{
				$(colored[i]).parent().parent().css('backgroundColor', 'white');
			}
			colored = new Array();

		});

		$('.cell-checkbox').click(function(){
			if($(this).is(':checked'))
			{
				$.ajax({
					type: "GET",
					url: config.base + "/formscapture/sessionBuildHour/<?=$sessiondata->id ?>/"+$(this).data("userid")+"/" + $(this).data("time") + "/" + $(this).data("date"),
					dataType: "text"
				});

			}
			else
			{
				$.ajax({
					type: "GET",
					url: config.base + "/formscapture/sessionUnbuildHour/<?=$sessiondata->id ?>/"+$(this).data("userid")+"/" + $(this).data("time") + "/" + $(this).data("date"),
					dataType: "text"
				});
			}

		});

	});


</script>