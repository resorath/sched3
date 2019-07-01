<div class="standard container" id="holidayhours">
	<h1 style="padding-bottom: 30px;">Holiday Hours for <?=$sessiondata->title ?></h1>

<?=form_open('managesessions/holidayhoursedit', array('class' => 'form-horizontal', 'id'=>'holidayhoursform')) ?>

	<div class="input-append date datepicker" id="holidaydate" data-date="" data-date-format="dd-mm-yyyy">
	    <input title="Holiday Date" class="span2" name="holidaydate" size="16" id="holidaydateinput" type="text" value="">
	    <span class="add-on"><i title="The first day of the session." rel="tooltip" class="icon-calendar"></i></span>
	 </div>
	<button class="btn btn-primary" type="button" id="new">New Exception Day</button>


	<div class="pull-left">
		<div style="height: 20px;"></div>
		<table class="table table-bordered table-hover table-responsive middlealign">
			<tr><th></th><th>Exception Day</th><th>Exception Hours</th></tr>

		<?php foreach($exceptions as $exceptionday => $exception): ?>
			<tr>
				<td>
					<a href="#" id="<?=$exceptionday ?>" class="dayremoval"><i class="icon-remove icon-2x hoverred"></i></a>
				</td>
				<td class="exceptiondayexisting">
					<?=date("d-m-Y", $exceptionday) ?>
				</td>
				<td>
					<ul class="datelump">
				<?php foreach($exception as $exceptionhour): ?>
						<li<?php if($exceptionhour['type'] == "invalid"): ?> class="datelump-dark"<?php endif ?>>
							<a href="#" class="timeremoval" id="<?=$exceptionday ?>-<?=$exceptionhour['timecode'] ?>">x <?=date("H:i", $exceptionhour['timecode']) ?></a>
						</li> 
				<?php endforeach ?>
						<!--<li class="datelump-green">
							<a href="#" class>+</a>
						</li>-->
					</ul>

				</td>

			</tr>
		<?php endforeach ?>
		<?php if(sizeof($exceptions) == 0): ?>
			<td colspan="3" style="width: 800px">No Exceptions... Yet</td>
		<?php endif ?>
		</table>

	</div>

	<div class="clearfix"></div>

</form>

<!-- Modal -->

<div id="addexceptionhourmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Exception Hours</h4>
      </div>
      <div class="modal-body">
	  <?=form_open('managesessions/createExceptionHour', array('id'=>'createexceptionhourform')) ?>
		<input type="hidden" name="exceptiondate" id="exceptiondate" value="">
		<input type="hidden" name="sessionid" id="sessionid" value="<?=$sessiondata->id ?>">
		<?php
			$i=realTime(now(), $sessiondata->startTime);
			do
			{
				?>
				<table width="100%"><tr>
					<td><b><?=date("H:i", $i) ?></b></td>
					<td><label><input type="radio" name="<?=date("H:i", $i) ?>" value="invalid" checked> Not Available</label></td>
					<td><label><input type="radio" name="<?=date("H:i", $i) ?>" value="available"> Available</label></td>
					<td><label><input type="radio" name="<?=date("H:i", $i) ?>" value="ignore"> Ignore</label></td>
				</tr></table>


				<?php
				$i = $i + (3600 * $sessiondata->timeIncrementAmount);
			}while($i < realTime(now(), $sessiondata->endTime));
		?>
      </div>
      <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button type="submit" class="btn btn-primary" id="createexceptionhours">Create</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
$(document).ready(function() {

	$('.datepicker').datepicker(); 

	$('#new').click(function() {
		if($('#holidaydateinput').val() == '')
			bgBlinkForTime('#holidaydateinput', 2200, '#ff0000');
		else
		{
			var alreadyexists = false;
			$('.exceptiondayexisting').each(function(i, obj) {
				if($.trim($(this).html()) == $('#holidaydateinput').val())
				{
					alreadyexists = true;
					bgBlinkForTime($(this), 2200, '#ff0000');
				}
			});

			if(!alreadyexists)
			{
				$('#exceptiondate').val($('#holidaydateinput').val());
				$('#addexceptionhourmodal').modal('show')
			}
		}

	});

	$('.dayremoval').click(function() {
		_this = $(this);
		$.ajax({
			type: "GET",
			url: config.base + "/managesessions/deleteFullDayException/" + <?=$sessiondata->id ?> + "/" + _this.attr("id"),
			dataType: "text",
			success: function(data) {
				deleteDay(_this);
			}
		});
	});	

	$('.timeremoval').click(function() {
		_this = $(this);
		$.ajax({
			type: "GET",
			url: config.base + "/managesessions/deleteSpecificTimeException/" + <?=$sessiondata->id ?> + "/" + _this.attr("id"),
			dataType: "text",
			success: function(data) {
				deleteTime(_this);
			}
		});
	});

});

function deleteDay(elem)
{
	elem.parent().parent().fadeOut();

}

function deleteTime(elem)
{
	elem.hide();

}

</script>