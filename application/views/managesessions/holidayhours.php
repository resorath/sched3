<div class="standard container" id="holidayhours">
	<h1 style="padding-bottom: 30px;">Holiday Hours for <?=$sessiondata->title ?></h1>

<?=form_open('managesessions/holidayhoursedit', array('class' => 'form-horizontal', 'id'=>'holidayhoursform')) ?>

	<div class="pull-right">
		<button class="btn btn-primary" type="button" id="new">New</button>
	</div>
	<div class="pull-left">
		<div style="height: 20px;"></div>
		<table class="table table-bordered table-hover table-responsive middlealign">
			<tr><th></th><th>Exception Day</th><th>Exception Hours</th></tr>

		<?php foreach($exceptions as $exceptionday => $exception): ?>
			<tr>
				<td>
					<a href="#" id="<?=$exceptionday ?>" class="dayremoval"><i class="icon-remove icon-2x hoverred"></i></a>
				</td>
				<td>
					<?=date("Y-m-d", $exceptionday) ?>
				</td>
				<td>
					<ul class="datetag">
				<?php foreach($exception as $exceptionhour): ?>
						<li<?php if($exceptionhour['type'] == "invalid"): ?> class="datetag-dark"<?php endif ?>><a href="#" class="timeremoval" id="<?=$exceptionday ?>-<?=$exceptionhour['timecode'] ?>"><?=date("H:i", $exceptionhour['timecode']) ?></a></li> 
				<?php endforeach ?>
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

<script>
$(document).ready(function() {
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