<div class="standard container">
	<h1 style="padding-bottom: 30px;">Editing <?=$session->title ?></h1>

	<div class="pull-left">

		<?=form_open('managesessions/editpost', array('class' => 'form-horizontal')) ?>

		<div class="control-group">
		  <label class="control-label">Session Name</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="Session Title" class="input-xlarge" type="text" value="<?=$session->title ?>">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Session Type</label>
		  <div class="controls">
		    <label class="radio">
		      <input name="sessiontype" value="r" checked="checked" type="radio">
		      Schedule repeats weekly until completion
		    </label>
		    <label class="radio">
		      <input name="sessiontype" value="s" type="radio">
		      Each day has unique hours, weeks don't matter
		    </label>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">First Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="startdate" data-date="<?=date("d-m-Y", $session->startDate) ?>" data-date-format="dd-mm-yyyy">
		    <input class="span2" name="startdate" size="16" type="text" value="<?=date("d-m-Y", $session->startDate) ?>">
		    <span class="add-on"><i class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Last Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="enddate" data-date="<?=date("d-m-Y", $session->endDate) ?>" data-date-format="dd-mm-yyyy">
		    <input class="span2" name="enddate" size="16" type="text" value="<?=date("d-m-Y", $session->endDate) ?>">
		    <span class="add-on"><i class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Start Time of First Shift</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="Format: HHMM, e.g. 8000" class="input-xlarge" type="text" value="<?=$session->startTime ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">End Time of Last Shift</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="Format: HHMM, e.g. 8000" class="input-xlarge" type="text" value="<?=$session->endTime ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Hours Per Shift</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="E.g. 1, 0.5, 2" class="input-xlarge" type="text" value="<?=$session->timeIncrementAmount ?>" style="width: 50px;">
		  </div>
		</div>

		

	</div>

</div>

<?php if(validation_errors() != ""): ?>
<script>notify(<?=validation_errors() ?>, "error");</script>
<?php endif ?>

<script>
$(document).ready(function(){ $('.datepicker').datepicker(); });
</script>
