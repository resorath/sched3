<script>
$(document).ready(function() { 
	$("#sessionTable").dataTable( {
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "aaSorting": [[ 0, "desc" ]]
    } );

});
</script>
<div class="container" style="padding-top:50px;">
	<table class="table table-striped table-condensed table-hover table-bordered display" id="sessionTable">
	<thead>
		<tr>
			<th style="width: 90px;">Session ID</th><th>Session Title</th><th>Effective</th><th style="width: 60px;">Active</th><th style="width: 60px;">Locked</th><th style="width: 70px;">Default</th><th style="width: 20px;"></th>
		</tr>
	</thead>
	<tbody>
		
		<tr>
			<td>3</td><td>Hello</td><td>World</td><td><i class="icon-check"></i></td><td><i class="icon-lock"></td><td><i class="icon-flag"></td><td><i class="icon-pencil"></i></td>	
		</tr>
		<tr>
			<td>2</td><td>Hello</td><td>World</td><td><i class="icon-check"></i></td><td><i class="icon-lock"></td><td></td><td><i class="icon-pencil"></i></td>	
		</tr>
		<tr>
			<td>5</td><td>Hello</td><td>World</td><td><i class="icon-check"></i></td><td><i class="icon-unlock"></td><td></td><td><i class="icon-pencil"></i></td>	
		</tr>
	</tbody>
	</table>
</div>

