<div class="standard container" id="holidayhours">
	<h1 style="padding-bottom: 30px;">Holiday Hours for <?=$sessiondata->title ?></h1>

<?=form_open('managesessions/holidayhoursedit', array('class' => 'form-horizontal', 'id'=>'holidayhoursform')) ?>

	<div class="pull-right">
		<button class="btn btn-primary" type="button" id="new">New</button>
	</div>
	<div class="pull-left">

		<?php foreach($holidayhours as $holidayhour): ?>
			<?php print_r($holidayhour); ?>

		<?php endforeach ?>


	</div>

</form>

<br><br><br><br><br><br>