<?php

	// Maybe a better way to do this?
	// @todo get this out of the view code!!
	function pickValue($databaseValue, $formValue)
	{

		if(!empty($databaseValue) && empty($formValue))
			return $databaseValue;

		if(empty($databaseValue) && !empty($formValue))
			return $formValue;

		if(empty($databaseValue) && empty($formValue))
			return "";

		if(!empty($databaseValue) && !empty($formValue))
			return $formValue;

	}

?>

<div class="standard container" id="editsession">
	<h1 style="padding-bottom: 30px;">Editing <?=$session->title ?></h1>


	<?php if(validation_errors() != ""): ?>
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Please Correct the Following:</h4>
    <br/>
    <?=validation_errors() ?>
    </div>
	<?php endif ?>

	<div class="pull-left">

		<?=form_open('managesessions/editpost', array('class' => 'form-horizontal', 'id'=>'editpostform')) ?>

		<div class="pull-right">
			<button class="btn btn-primary" type="submit" id="save">Save</button>
			<button class="btn" type="reset" id="save" onClick="javascript: return confirm('Really Reset?');">Reset</button>
		</div>

		<div class="control-group">
		  <label class="control-label">Session Name</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="Session Title" class="input-xlarge" type="text"  title="The title this session identifies itself as." value="<?=pickValue($session->title, set_value('title')) ?>">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Group</label>
		  <div class="controls">
		    <input id="groupId" name="groupId" placeholder="Group" class="input-xlarge" type="text" value="<?=$session->groupId ?>" disabled="disabled" style="width: 150px;" title="Group can only be set when a session is created.">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Session Type</label>
		  <div class="controls">
		    <label class="radio">
		      <input name="scheduletype" value="r" <?php if($session->scheduleType == "r") { echo "checked=\"checked\""; } ?> type="radio">
		      Schedule repeats weekly until completion
		    </label>
		    <label class="radio">
		      <input name="scheduletype" value="s" <?php if($session->scheduleType == "s") { echo "checked=\"checked\""; } ?> type="radio">
		      Each day has unique hours, weeks don't matter
		    </label>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">First Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="startdate" data-date="<?=date("d-m-Y", $session->startDate) ?>" data-date-format="dd-mm-yyyy">
		    <input title="The first day of the session. (Use the date picker to the right)" class="span2" name="startdate" size="16" type="text" value="<?=date("d-m-Y", $session->startDate) ?>">
		    <span class="add-on"><i title="The first day of the session." rel="tooltip" class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Last Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="enddate" data-date="<?=date("d-m-Y", $session->endDate) ?>" data-date-format="dd-mm-yyyy">
		    <input title="The last day of the session. (Use the date picker to the right)"  class="span2" name="enddate" size="16" type="text" value="<?=date("d-m-Y", $session->endDate) ?>">
		    <span class="add-on"><i title="The last day of the session." rel="tooltip" class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Start Time of First Shift</label>
		  <div class="controls">
		    <input id="starttime" title="Format: HHMM" name="starttime" placeholder="HHMM" class="input-xlarge" type="text" value="<?=$session->startTime ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">End Time of Last Shift</label>
		  <div class="controls">
		    <input id="endtime" title="Format: HHMM" name="endtime" placeholder="HHMM" class="input-xlarge" type="text" value="<?=$session->endTime ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Hours Per Shift</label>
		  <div class="controls">
		    <input id="hourspershift" title="E.g. 1, 0.5, 2 (hours)" name="timeincrementamount" placeholder="E.g. 1, 0.5, 2" class="input-xlarge" type="text" value="<?=$session->timeIncrementAmount ?>" style="width: 50px;">
		  </div>
		</div>

		<h4 class="form-text-alignment pad-top">Actions</h4>
		<p class="form-text-alignment pad-bottom">These actions affect the session immediately</p>

		<div class="control-group">
		  <label class="control-label" for="isactive">Session Visibility</label>
		  <div class="controls">
		    <button type="button" id="isactive" name="isactive" class="btn">Loading State...</button>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label" for="isprimary">Session Default</label>
		  <div class="controls">
		    <button type="button" id="isprimary" name="isprimary" class="btn">Loading State...</button>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label" for="islocked">Session Lock</label>
		  <div class="controls">
		    <button type="button" id="islocked" name="islocked" class="btn">Loading State...</button>
		  </div>
		</div>

		<p class="pad-bottom"></p>

		<div class="control-group">
		  <label class="control-label" for="makeschedule">Build Schedule</label>
		  <div class="controls">
		    <button type="button" id="makeschedule" name="makeschedule" class="btn">Create the Schedule of Hours</button>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label" for="invalidatehours">Invalidate Hours</label>
		  <div class="controls">
		    <button type="button" id="invalidatehours" name="invalidatehours" class="btn">Define Exceptions to Hours of Operation</button>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label" for="holidayhours">Holiday Hours</label>
		  <div class="controls">
		    <button type="button" id="holidayhours" name="holidayhours" class="btn" <?php if($session->scheduleType != "r") { echo "disabled=\"disabled\""; } ?>>Define Daily Exception to Repeating Weekly Schedule</button>
		  </div>
		</div>

		<p class="pad-bottom"></p>

		<div class="control-group">
		  <label class="control-label" for="islocked">Delete Session</label>
		  <div class="controls">
		    <button type="button" id="deletesession" name="deletesession" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete Session</button>
		  </div>
		</div>
		
		<div class="spacer-div" style="width: 800px;"></div>

	</div>

</div>


<!-- Modal delete dialog -->
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="deleteModalLabel">Delete <?=$session->title ?></h3>
		</div>
	<div class="modal-body" style="text-align: left">
		<p><b>Warning!</b></p>
		<p>Deleting this session will also delete all hours associated with this session, including; </p>
		<ul>
			<li>Hours submitted by the employees</li>
			<li>Schedule of hours</li>
			<li>Session customized hours (such as hours of operation)</li>
		</ul>
		<p>This is an <b>unrecoverable action</b>.</p>
		<p>You can instead make the session invisible to hide the session from employees.</p>

		<p>Do you really want to delete this session?</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button type="button" id="deleteSessionConfirm" class="btn btn-danger">Delete Session</button>
	</div>
</div>
<!-- END modal delete dialog -->

<script>
$(document).ready(function(){ 

	$('.datepicker').datepicker(); 

	// Set the state of the flag buttons

	function setButtonIsPrimary(state)
	{
		if(state == "1")
			$('#isprimary').attr("class", "btn btn-success").html("Session is the Default Session for the Group (Make another session default to change)").prop('disabled', 'disabled');
		else
			$('#isprimary').attr("class", "btn btn-warning").html("Session is NOT the Default Session for the Group (click to make default)");

	}

	function setButtonIsLocked(state)
	{
		if(state == "1")
			$('#islocked').attr("class", "btn btn-success").html("Session is Accepting Availability (click to lock)");
		else
			$('#islocked').attr("class", "btn btn-warning").html("Session is Locked and not Accepting Availability (click to unlock)");

	}

	function setButtonIsActive(state)
	{
		if(state == "1")
			$('#isactive').attr("class", "btn btn-success").html("Session is Visible (click to make invisibile)");
		else
			$('#isactive').attr("class", "btn btn-warning").html("Session is Invisible (click to make visible)");
	}


	// can't delete the primary session
	function checkIsPrimary(force)
	{
		if("<?=$session->isPrimary ?>" == "1" || force == true)
		{
			$('#deletesession').html("Can't Delete Default Session!").prop('disabled', 'disabled');
		}

	}

	setButtonIsPrimary("<?=$session->isPrimary ?>");
	setButtonIsActive("<?=$session->isActive ?>");
	setButtonIsLocked("<?=$session->isLocked ?>");
	checkIsPrimary(false);

	$('#deleteSessionConfirm').click(function() {
		$.ajax({
			type: "GET",
			url: config.base + "/formscapture/sessionDelete/<?=$session->id ?>",
			dataType: "text",
			success: function(data) {
				if(data == "1")
				{
					$('#deleteModal').modal('hide');
					$('#editsession').html('<div class="dust">dust</span>');
					window.setInterval(function() {window.location =  config.base + "/managesessions"}, 1500);
				}
				else
				{
					alert("Didn't delete, something went wrong! (" + data + ")");
				}
			},
			error: function(request, status, error) {
				alert("Didn't delete, something went wrong! (AJAX Error: " + error + ")");
			} 
		});

	});

	$('#isactive').click(function() {
		$.ajax({
			type: "GET",
			url: config.base + "/formscapture/sessionToggleFlag/<?=$session->id ?>/isActive",
			dataType: "text",
			success: function(data) {
				setButtonIsActive(data);

			}
		});
	});

	$('#islocked').click(function() {
		$.ajax({
			type: "GET",
			url: config.base + "/formscapture/sessionToggleFlag/<?=$session->id ?>/isLocked",
			dataType: "text",
			success: function(data) {
				setButtonIsLocked(data);

			}
		});
	});

	$('#isprimary').click(function() {
		$.ajax({
			type: "GET",
			url: config.base + "/formscapture/sessionMakePrimary/<?=$session->id ?>",
			dataType: "text",
			success: function(data) {
				setButtonIsPrimary(data);

			}
		});

		checkIsPrimary(true);
	});

	$('#isprimary').click(function() {
		$.ajax({
			type: "GET",
			url: config.base + "/formscapture/sessionMakePrimary/<?=$session->id ?>",
			dataType: "text",
			success: function(data) {
				setButtonIsPrimary(data);

			}
		});
	});

	$('#invalidatehours').click(function() {
		window.location = config.base + "managesessions/invalidatehours/<?=$session->id ?>";
	});

	$('#holidayhours').click(function() {
		window.location = config.base + "managesessions/holidayhours/<?=$session->id ?>";
	});

	$('#makeschedule').click(function() {
		window.location = config.base + "managesessions/createschedule/<?=$session->id ?>";
	});

	// alert for changed data
	dirty=false;

	$('#starttime').on("input", function() { dirty = true; });
	$('#endtime').on("input", function() { dirty = true; });
	$('#startdate').on("input", function() { dirty = true; });
	$('#enddate').on("input", function() { dirty = true; });
	$('#timeincrementamount').on("input", function() { dirty = true; });
	$('.icon-calendar').on("click", function() { dirty = true; });


	$('#editpostform').bind("reset", function() { dirty = false; });

	$('#editpostform').submit(function() {
		if(dirty)
			return confirm('Warning\n\nChanging the date, time or shift length may cause existing submitted hours to be out of range.\n\nDo you want to continue?');
	});
	// end alert



});



</script>
