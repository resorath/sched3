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

<div id="schedule" class="container-fluid p-4">
	<?php if($schedule != NULL): ?>
	
	<!-- Top Date/Days -->
	<div class="row">
		<div id="schedule-main-table-corner" class="col"></div>
		<?php for($i = 0; $i<sizeof($toprow['days']); $i++) { ?>
			<div class="col schedule-main-top-row schedule-cell"><div class="date-aligner"><span class="large-date"><?=$toprow['date'][$i] ?></span> <span class="small-day"><?=$toprow['days'][$i] ?></span></div></div>
		<?php } ?>
	</div>
	<!-- END Top Date/Days -->

	<!-- Time/Schedule Rows -->
	<?php foreach($firstcolumn as $columntime) { ?>
	<div class="row">
		<div class="col schedule-main-table-first-column schedule-cell"><?=strrev(substr_replace(strrev($columntime), ":", 2, 0)); ?></div>
			<?php foreach($toprow['dayindex'] as $rowdate) { ?>
			<div class="col schedule-main-table-normal-cell schedule-cell <?php if(isInvalidCell($schedule[$columntime][$rowdate])) { ?>invalid-hour<?php } ?>" id="cell-<?=$columntime ?>-<?=$rowdate ?>">
				<?php if(isset($schedule[$columntime][$rowdate])) 
						{
						foreach($schedule[$columntime][$rowdate] as $cell) { ?>
							<div class="cell"><span class="cell-name cell-userid-<?= $cell->userid ?>"><?= $cell->realname ?></span></div>
						<?php } // end members of a timeslot "for" loop ?>
				<?php } // end if ?>
			</div>
			<?php } // end of rows "for" loop ?>
	</div>
	<?php } // end of columns "for" loop ?>

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