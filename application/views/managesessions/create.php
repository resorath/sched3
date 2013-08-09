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
	<h1 style="padding-bottom: 30px;">Create New Session</h1>


	<?php if(validation_errors() != ""): ?>
    <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Please Correct the Following:</h4>
    <br/>
    <?=validation_errors() ?>
    </div>
	<?php endif ?>

	<div class="pull-left">

		<?=form_open('managesessions/createpost', array('class' => 'form-horizontal', 'id'=>'createpostform')) ?>

		<div class="pull-right">
			<button class="btn btn-primary" type="submit" id="save">Save</button>
			<button class="btn" type="reset" id="save" onClick="javascript: return confirm('Really Reset?');">Reset</button>
		</div>


		<div class="control-group">
		  <label class="control-label">Session Name</label>
		  <div class="controls">
		    <input id="title" name="title" placeholder="Session Title" class="input-xlarge" type="text"  title="The title this session identifies itself as." value="<?=set_value('title') ?>">
		  </div>
		</div>
		<div class="control-group">
		  <label class="control-label">Group</label>
		  <div class="controls">
	  	    <select id="groupid" name="groupid" class="input-xlarge">
	  	    	<?php foreach($groups as $group): ?>
	  	    	<option value="<?=$group['groupId'] ?>" <?=set_select('groupid', $group['groupId']) ?>><?=$group['name'] ?></option>
	  	   		<?php endforeach ?>
		    </select>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Session Type</label>
		  <div class="controls">
		    <label class="radio">
		      <input name="scheduletype" value="r" type="radio" <?=set_radio('scheduletype', 'r', true) ?>>
		      Schedule repeats weekly until completion
		    </label>
		    <label class="radio">
		      <input name="scheduletype" value="s" type="radio" <?=set_radio('scheduletype', 's', true) ?>>
		      Each day has unique hours, weeks don't matter
		    </label>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">First Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="startdate" data-date="<?=set_value('startdate') ?>" data-date-format="dd-mm-yyyy">
		    <input title="The first day of the session. (Use the date picker to the right)" class="span2" name="startdate" size="16" type="text" value="<?=set_value('startdate') ?>">
		    <span class="add-on"><i title="The first day of the session." rel="tooltip" class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Last Day</label>
		  <div class="controls">
		    <div class="input-append date datepicker" id="enddate" data-date="<?=set_value('enddate') ?>" data-date-format="dd-mm-yyyy">
		    <input title="The last day of the session. (Use the date picker to the right)"  class="span2" name="enddate" size="16" type="text" value="<?=set_value('enddate') ?>">
		    <span class="add-on"><i title="The last day of the session." rel="tooltip" class="icon-calendar"></i></span>
		    </div>
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Start Time of First Shift</label>
		  <div class="controls">
		    <input id="starttime" title="Format: HHMM" name="starttime" placeholder="HHMM" class="input-xlarge" type="text" value="<?=set_value('starttime') ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">End Time of Last Shift</label>
		  <div class="controls">
		    <input id="endtime" title="Format: HHMM" name="endtime" placeholder="HHMM" class="input-xlarge" type="text" value="<?=set_value('endtime') ?>" style="width: 50px;">
		  </div>
		</div>

		<div class="control-group">
		  <label class="control-label">Hours Per Shift</label>
		  <div class="controls">
		    <input id="hourspershift" title="E.g. 1, 0.5, 2 (hours)" name="timeincrementamount" placeholder="E.g. 1, 0.5, 2" class="input-xlarge" type="text" value="<?=set_value('timeincrementamount') ?>" style="width: 90px;">
		  </div>
		</div>

		<p class="muted">The remaining session options will appear once you have saved</p>

		<p class="pad-bottom"></p>

		<div class="spacer-div" style="width: 800px;"></div>

	</div>

</div>


<script>
$(document).ready(function(){ 

	$('.datepicker').datepicker(); 
});
</script>