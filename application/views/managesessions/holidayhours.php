<div class="standard container" id="holidayhours">
	<h1 style="padding-bottom: 30px;">Holiday Hours for <?=$sessiondata->title ?></h1>

<?=form_open('managesessions/holidayhoursedit', array('class' => 'form-horizontal', 'id'=>'holidayhoursform')) ?>

	<div class="pull-right">
		<button class="btn btn-primary" type="button" id="new">New</button>
	</div>
	<div class="pull-left">

		<table class="table table-bordered table-hover table-responsive middlealign">
			<tr><th></th><th>Exception Day</th><th>Exception Hours</th></tr>

		<?php foreach($exceptions as $exceptionday => $exception): ?>
			<tr>
				<td>
					<a href="#"><i class="icon-remove icon-2x hoverred"></i></a>
				</td>
				<td>
					<?=date("Y-m-d", $exceptionday) ?>
				</td>
				<td>
					<ul class="datetag">
				<?php foreach($exception as $exceptionhour): ?>
						<li<?php if($exceptionhour['type'] == "invalid"): ?> class="datetag-dark"<?php endif ?>><a href="#"><?=date("H:i", $exceptionhour['timecode']) ?></a></li> 
				<?php endforeach ?>
					</ul>
				</td>

			</tr>
		<?php endforeach ?>
		</table>

	</div>

</form>
<br><br><br><br><br><br>