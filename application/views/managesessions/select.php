<script>
$(document).ready(function() { 
	$("#sessionTable").dataTable( {
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ 6 ] }
       ]
    } );

});
</script>
<div class="container" style="padding-top:50px;">
	<table class="table table-striped table-condensed table-hover table-bordered display" id="sessionTable">
	<thead>
		<tr>
			<th style="width: 90px;">Session ID</th><th>Session Title</th><th>Effective</th><th style="width: 60px;">Active</th><th style="width: 70px;">Locked</th><th style="width: 70px;">Default</th><th style="width: 20px;"></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($sessions as $session): ?>
		<tr>
			<td><?=$session['id'] ?></td>
			<td><?=$session['title'] ?></td>
			<td><span style="display: none"><?=$session['startDate'] ?></span><?=date("M d, Y", $session['startDate']) ?></td>
			<td style="text-align: center;"><span style="display: none"><?=$session['isActive'] ?></span><?php if($session['isActive']): ?><i class="icon-check"></i><?php endif ?></td>
			<td style="text-align: center;"><span style="display: none"><?=$session['isLocked'] ?></span><?php if($session['isLocked']): ?><i class="icon-lock"></i><?php else: ?><i class="icon-unlock"></i><?php endif ?></td>
			<td style="text-align: center;"><span style="display: none"><?=$session['isPrimary'] ?></span><?php if($session['isPrimary']): ?><i class="icon-flag"></i><?php endif ?></td>
			<td style="text-align: center;"><a href="<?=base_url("/managesessions/edit/" . $session['id']) ?>"><i class="icon-pencil"></i></a></td>	
		</tr>
		<?php endforeach ?>
	</tbody>
	</table>
</div>

