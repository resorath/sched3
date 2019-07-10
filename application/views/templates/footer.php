<!-- start of footer -->
			<div class="footer">
				<span>IT Scheduler</span>
				<br/>
				<?php // actually calculate this ?><strong>Development mode</strong>
				<br/>
				<a href="<?=base_url("populatetestdata") ?>">Reload database from test data</a>

				<!-- Debugger -->
				<?php if(user_has_role("DEBUGGER") && false): ?>
					<br/>
					<div class="well well-small" id="sessiondebug" style="text-align: left;">
						<p><b>Session</b></p>
						<?php foreach($_SESSION as $skey => $svalue): ?>
							<b><?=$skey ?></b>: <?=print_r($svalue, TRUE) ?><br/>
						<?php endforeach ?>
					</div>
					<?php if(count($_GET) > 0): ?>
						<div class="well well-small" id="getdebug" style="text-align: left;">
							<p><b>Get</b></p>
							<?php foreach($_GET as $skey => $svalue): ?>
								<b><?=$skey ?></b>: <?=print_r($svalue, TRUE) ?><br/>
							<?php endforeach ?>
						</div>
					<?php endif ?>

					<?php if(count($_POST) > 0): ?>
						<div class="well well-small" id="getdebug" style="text-align: left;">
							<p><b>Post</b></p>
							<?php foreach($_POST as $skey => $svalue): ?>
								<b><?=$skey ?></b>: <?=print_r($svalue, TRUE) ?><br/>
							<?php endforeach ?>
						</div>
					<?php endif ?>
				<?php endif ?>
				<!-- /Debugger -->
			</div>

	    </div>
		<!-- Footer Scripts -->
	</body>
</html>