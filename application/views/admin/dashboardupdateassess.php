<table id="datable_2" class="table table-bordered">
	<thead>
	<tr>
		<th class="col-sm-6">Assessment Name</th>
		<th class="col-sm-2">Positions covered</th>
		<th class="col-sm-2">Initiated Date</th>
		<th class="col-sm-2">Employee covered</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($assessments as $assessment){ ?>
	<tr>
		<td><?php echo $assessment['assessment_name']; ?></td>
		<td><a onclick="getasesspos(<?php echo $assessment['assessment_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $assessment['positions']; ?></a></td>
		<td><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></td>
		<td><a onclick="getasessposemp(<?php echo $assessment['assessment_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"><?php echo $assessment['employees']; ?></a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>