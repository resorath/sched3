<div id="maincontent">


<?php if($schedule != NULL): ?>
<div id="schedule-header">
	<span id="schedule-name">
		<?=$sessiondata->title ?>
	</span>
	<span id="date-select">
		<div id="date-select-previous" class="date-select-control"><a href="<?=base_url("schedule/recedeWeek"); ?>">P</a></div>
		<div id="date-select-current">
			<?=$daterange[0] ?> to <?=$daterange[1] ?>
		</div>
		<div id="date-select-now"" class="date-select-control"><a href="<?=base_url("schedule/today"); ?>">T</a></div>
		<div id="date-select-next"" class="date-select-control"><a href="<?=base_url("schedule/advanceWeek"); ?>">N</a></div>
	</span>
	<span id="change-schedule" class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-calendar icon-large options-blacken"></i></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<?php
			$i = 0;
			foreach($availablesessions as $sessiongroupname => $sessiongroup) {
				?><li class="dropdown-disabled"><?=$sessiongroupname ?></li><?php
				foreach($sessiongroup as $sesgroupindex => $session)
				{
					?><li><a class="dropdown-item" href="<?=base_url("schedule/changesession/" . $session['sessionId']) ?>"><?=$session['title'] ?></a></li><?php
				}
				if(++$i !== count($availablesessions))
				{
					?><li class="dropdown-divider"></li><?php
				}
			}
			?>
		</ul>
	</span>
	<span id="highlight-mode" class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-lightbulb icon-large bulb-yellow"></i></i></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li class="dropdown-item"><a href="#" onClick="highlightHours('cell-userid-<?=$_SESSION['userid']?>')"><i class="icon-fixed-width icon-user"></i> Highlight my Hours</a></li>
			<li class="dropdown-item"><a href="#" onClick="highlightAvailableShifts()"><i class="icon-shopping-cart icon-user"></i> Highlight Available Hours</a></li>
			<li class="dropdown-divider"></li>
			<li class="dropdown-item"><a href="#" onClick="stophighlightHours('cell-userid-<?=$_SESSION['userid']?>')"><i class="icon-fixed-width icon-ban-circle"></i> Turn off Highlighting</a></li>
		</ul>
	</span>


</div>
<?php endif ?>

<div class="schedule">

	<?php if($schedule != NULL): ?>

	<table class="schedule-main-table">
		<!-- Top Date/Days -->
		<tr class="schedule-main-table-top-row">
			<td class="schedule-main-table-corner"></td>
			<?php for($i = 0; $i<sizeof($toprow['days']); $i++) { ?>
			<td><div class="date-aligner"><span class="large-date"><?=$toprow['date'][$i] ?></span> <span class="small-day"><?=$toprow['days'][$i] ?></span></div></td>
			<?php } ?>
		</tr>
		<!-- END Top Date/Days -->

		<!-- Time/Schedule Rows -->
		<?php foreach($firstcolumn as $columntime) { ?>
		<tr>
			<td class="schedule-main-table-first-column"><?=strrev(substr_replace(strrev($columntime), ":", 2, 0)); ?></td>
				<?php foreach($toprow['dayindex'] as $rowdate) { ?>
				<td class="schedule-main-table-normal-cell <?php if(isInvalidCell($schedule[$columntime][$rowdate])) { ?>invalid-hour<?php } ?>" id="cell-<?=$columntime ?>-<?=$rowdate ?>">
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



<!-- extra script calls -->
<?php if(isset($flash_left_arrow)): ?>
	<script>
		blinkForTime('#schedule-previous > a', 1400, '#ff0000');
	</script>
<?php endif ?>

<?php if(isset($flash_right_arrow)): ?>
	<script>
		$(document).ready(function() { blinkForTime('#schedule-next > a', 1400, '#ff0000'); });
	</script>
<?php endif ?>

<?php if(isset($_SESSION['highlighthours']) && $_SESSION['highlighthours'] == TRUE): ?>
	<script>
		highlightHours('cell-userid-<?=$_SESSION['userid']?>');
	</script>
<?php endif ?>

<!-- END extra script calls -->

<?php
	function isInvalidCell($celldata)
	{
		if(!isset($celldata))
			return false;

		if(count($celldata) != 1)
			return false;

		if($celldata[0]->userid == 0)
			return true;
		return false;

	}

?>