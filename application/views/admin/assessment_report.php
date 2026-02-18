<style>
.small{
	height:50px;
}
.small p{
	font-size:10px;
	
}
</style>
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
	<div class="panel panel-default card-view panel-refresh">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">Assessing Positions</h6>
			</div>
			
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="row">
		
		
		<?php 
		foreach($position_details as $position){
			$pos_dec=strip_tags($position['position_desc']);
			?>
			<div class="col-md-3">
				<div class="panel panel-inverse card-view">
					<div class="">
						<div class="text-center">
							<h6 style="height:50px"><?php echo $position['position_name']; ?></h6>
							<!--<div class="small" style='font-size:10px'><?php echo substr($pos_dec,0,90); ?>...</div>-->
						
						<button class="btn btn-success btn-xs" onclick="getassessmentjd(<?php echo $position['position_id']; ?>,'',<?php echo $compdetails['assessment_id']; ?>)" style="padding: 4px 17px;">JD</button>
						<button class="btn btn-warning btn-xs" onclick="getassessmentprofiling(<?php echo $position['position_id']; ?>,'',<?php echo $compdetails['assessment_id']; ?>)" style="padding: 4px 17px;">Profiling</button>
						<button class="btn btn-info btn-xs" onclick="getemployees(<?php echo $position['position_id']; ?>,<?php echo $compdetails['assessment_id']; ?>)" style="padding: 4px 17px;">Employees</button>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div>
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
