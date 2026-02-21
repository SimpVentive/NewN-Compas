<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<h6>Assessment Cycle: <?php echo $ass_name['assessment_name']; ?></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row">		
		<?php
		if(count($positions)>0){
		foreach($positions as $position){
			$position_desc=strip_tags($position['position_desc']);
			?>
		<div class="col-lg-3">
			<div class="panel panel-default card-view">
				<div class="panel-body">
					<div class="text-center">
						<h2 class="m-b-xs" style='font-size:16px'><?php echo $position['position_name']; ?></h2>
						<!--<p class="small"><?php echo substr($position_desc,0,100); ?>...</p>
						<button class="btn btn-primary btn-sm" onclick="getassessmentjd(<?php echo $position['position_id']; ?>,<?php echo $assessor_id; ?>,<?php echo $assessment_id; ?>)">JD</button>
						<button class="btn btn-primary btn-sm" onclick="getassessmentprofiling(<?php echo $position['position_id']; ?>,<?php echo $assessor_id; ?>,<?php echo $assessment_id; ?>)">Profiling</button>-->
						<a class="btn btn-primary btn-sm" href="<?php echo BASE_URL;?>/assessor/getassessoremployees?assessment_id=<?php echo $assessment_id; ?>&assessor_id=<?php echo $assessor_id; ?>&position_id=<?php echo $position['position_id']; ?>">Employees</a>
						<!--<button class="btn btn-primary btn-sm" onclick="getemployees(<?php echo $position['position_id']; ?>,<?php echo $assessor_id; ?>,<?php echo $assessment_id; ?>)" >Employees</button>-->
					</div>
				</div>
				<div class="clearfix mt-20"></div>
			</div>
		</div>
		<?php }
		}		?>
	</div>
	
	<div class="row">
		<div class="col-lg-12" id="assessmentdetails">
			
		</div>
	</div>
	
</div>



