<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">				
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Assessment Name</th>
								<th><?php  echo $compdetails['assessment_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><?php  echo date('d-m-Y',strtotime($compdetails['start_date']));?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">End Date</th>
								<th><?php  echo date('d-m-Y',strtotime($compdetails['end_date']));?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					
				</div>
            </div>
		</div>
	</div>
	<div class="row">
		<div class="font-bold m-b-sm">
				Assessing Positions
		</div>
		<?php 
		foreach($position_details as $position){ ?>
			<div class="col-md-3">
				<div class="panel panel-inverse card-view">
					<div class="panel-body">
						<div class="text-center">
							<h2 class="m-b-xs" style='font-size:16px'><?php echo $position['position_name']; ?></h2>
							<p class="small"><?php echo substr($position['position_desc'],0,100); ?>...</p>
							<button class="btn btn-success btn-sm" onclick="getassessmentjd(<?php echo $position['position_id']; ?>,'',<?php echo $compdetails['assessment_id']; ?>)">JD</button>
							<button class="btn btn-warning btn-sm" onclick="getassessmentprofiling(<?php echo $position['position_id']; ?>,'',<?php echo $compdetails['assessment_id']; ?>)">Profiling</button>
							<button class="btn btn-info btn-sm" onclick="getselfemployees(<?php echo $position['position_id']; ?>,<?php echo $compdetails['assessment_id']; ?>)" >Employees</button>
						</div>
					</div>
				</div>
			</div>
		<?php 
		} 
		?>
	</div>
	<div class="row">
		<div class="col-md-12" id="assessmentdetails">
			
		</div>
	</div>
</div>
