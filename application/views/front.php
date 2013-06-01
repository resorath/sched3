<div class="bodymodule" id="frontbody">
    <div class="rotator">
	<img src="<?php echo(base_url()); ?>assets/img/banner/leader.png">
	
	<a href="philosophy"><img src="<?php echo(base_url()); ?>assets/img/banner/philosophies.png"></a>
	<a href="recruitment"><img src="<?php echo(base_url()); ?>assets/img/banner/recruiting.png"></a>
	<a href="forums"><img src="<?php echo(base_url()); ?>assets/img/banner/forums.png"></a>
    </div>
</div>

<div class="highlights">
    <div class="highlight_box" id="hlb1">
	<p class="hlb_title">Recruitment</p>
	<p class="hlb_body">Our application process is different. Learn more.<p>
			<img src="<?php echo(base_url()); ?>assets/img/hlb/recruitment.png" width="88" height="88" class="hlb_img">
    </div>
    
    <div class="highlight_box" id="hlb2">
	<p class="hlb_title">Progress</p>
	<p class="hlb_body">Our ranking on wowprogress.com<p>
	<img src="<?php echo(base_url()); ?>assets/img/hlb/guildbanner.png" width="83" height="94" class="hlb_img">

    </div>

    <div class="highlight_box" id="hlb3">
	<p class="hlb_title">Roster</p>
	<p class="hlb_body">Meet our team, find someone to talk to about us.<p>
	<img src="<?php echo(base_url()); ?>assets/img/hlb/portrait.png" width="88" height="88" class="hlb_img">
    </div>

</div>

<div class="news">
<?php
foreach($newsdata as $entry)
{ ?>
    <div class="newsarticle">
	<span class="news_headline"><?=$entry->title ?></span>
	<span class="news_postedby">Posted By <?=$entry->author ?> on <b><?php echo(date('F j, Y', $entry->datestamp)); ?></b></span>
	<hr class="news_hr" align="left">
	<div class="news_body">
	    <?=$entry->body ?>
	</div>
    </div>
<?php } ?>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('.rotator')
    .before('<div id="nav">')
    .cycle({
		fx: 'fade',
		delay: -2000,
	    
    });
    
    $('.highlight_box').click(function(){
	if($(this).attr("id") == "hlb1")
		window.location = "recruitment";
	if($(this).attr("id") == "hlb2")
		window.location = "http://www.wowprogress.com/guild/us/doomhammer/Uprising"
	if($(this).attr("id") == "hlb3")
		window.location = "roster";
	
    });
});
</script>