<div id="maincontent" class="container">
	<?php 
		if(isset($error)) {
	?>
	<div class="alert alert-error">
	    <button type="button" class="close" data-dismiss="alert">&times;</button>
	    <?=$error ?>
    </div>
	<?php } ?>
	<div class="headeradjuster">
		<div class="header">
			<h3>Scheduler Login</h3>
	    </div>
	</div>

	<span>Security through obscurity since 2008</span>
	<br/>
	<br/>
	<?=form_open('authenticate/backdoor_verify'); ?>

		<img src="<?=base_url() ?>assets/img/login_sailboat.jpg" alt="Login Sailboat">
		<br/><br/>
		<input type="text" name="itusername" placeholder="IT Username">	
		<br/>
		<button type="submit" class="btn">Log in</button>
	</form>
</div>