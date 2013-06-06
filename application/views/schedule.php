<?php print_r($availablesessions); ?><div id="maincontent">
<div class="headeradjuster">
	<div class="header">
		<h3><?=$sessiondata->title ?></h3>
    	<div class="schedulecontrolicons-options">
		    <div class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-list icon-large options-blacken"></i></a>
			    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			    	<li><a href="#"><i class="icon-fixed-width icon-map-marker"></i> Jump to Today</a></li>
			    	<li><a href="#"><i class="icon-fixed-width icon-screenshot"></i> Jump to...</a></li>
			    	<li class="dropdown-submenu">
			    		<a href="#" tabindex="-1"><i class="icon-fixed-width icon-calendar"></i> View a Different Calendar</a>
			    		<ul class="dropdown-menu">
			    			<li class="disabled"><a href="#">IT Support Centre</a></li>
			    			<li><a href="#">Summer 2000</a></li>
			    			<li class="divider"></li>
			    			<li class="disabled"><a href="#">Reznet</a></li>
			    			<li><a href="#">Summer 2000!</a></li>


			    		</ul>
			   		</li>
			    </ul>
			</div>
		</div>
		<div class="schedulecontrolicons-highlights">
			<div class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-lightbulb icon-large bulb-yellow"></i></i></a>
			    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			    	<li><a href="#"><i class="icon-fixed-width icon-user"></i> Highlight my Hours</a></li>
			    	<li><a href="#"><i class="icon-shopping-cart icon-user"></i> Highlight Available Hours</a></li>
			    	<li class="divider"></li>
			    	<li><a href="#"><i class="icon-fixed-width icon-ban-circle"></i> Turn off Highlighting</a></li>
			    </ul>
			</div>
    	</div>
    </div>
</div>

<div class="schedule-previous">
	<i class="icon-chevron-left icon-2x"></i>
</div>

<div class="schedule-next">
	<i class="icon-chevron-right icon-2x"></i>
</div>

<div class="schedule">
	<table class="schedule-main-table">
		<!-- Top Date/Days -->
		<tr class="schedule-main-table-top-row">
			<td class="schedule-main-table-corner"></td>
			<?php for($i = 0; $i<sizeof($toprow['days']); $i++) { ?>
			<td><div class="date-aligner"><span class="large-date"><?=$toprow['date'][$i] ?></span> <span class="small-day"><?=$toprow['days'][$i] ?></span></div></td>
			<?php } ?>
		</tr>
		<!-- END Top Date/Days -->

		<!-- Time/Schedule Rows -->
		<?php foreach($firstcolumn as $columntime) { ?>
				
		<tr>
			<td class="schedule-main-table-first-column"><?=strrev(substr_replace(strrev($columntime), ":", 2, 0)); ?></td>

				<?php foreach($toprow['dayindex'] as $rowdate) { ?>
				<td class="schedule-main-table-normal-cell" id="cell-<?=$columntime ?>-<?=$rowdate ?>">
					<?php foreach($schedule[$columntime][$rowdate] as $cell) { ?>
						<div class="cell"><span class="cell-name cell-userid-<?= $cell->userid ?>"><?= $cell->realname ?></span></div>
					<?php } // end members of a timeslot "for" loop ?>
				</td>


				<?php } // end of rows "for" loop ?>

		</tr>
		<?php } // end of columns "for" loop ?>



		<!-- 8:00 
		<tr>
			<td class="schedule-main-table-first-column">8:00</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-old-time-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
		</tr>
		 9:00 
		<tr>
			<td class="schedule-main-table-first-column">9:00</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-old-time-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
		</tr>
		10:00
		<tr>
			<td class="schedule-main-table-first-column">10:00</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-current-time-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
		</tr>
		11:00
		<tr>
			<td class="schedule-main-table-first-column">11:00</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
		</tr>
		12:00
		<tr>
			<td class="schedule-main-table-first-column">12:00</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
		</tr>
		1:00
		<tr>
			<td class="schedule-main-table-first-column">1:00</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
		</tr>
		2:00
		<tr>
			<td class="schedule-main-table-first-column">2:00</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
		</tr>
		3:00
		<tr>
			<td class="schedule-main-table-first-column">3:00</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
		</tr>
		4:00
		<tr>
			<td class="schedule-main-table-first-column">4:00</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-normal-cell">
				Sean F<br/>
				Abraham L<br/>
				Gerald F<br/>
				George B<br/>
				George W<br/>
			</td>
			<td class="schedule-main-table-invalid-cell">
			</td>
		</tr>
		-->
	</table>
</div>