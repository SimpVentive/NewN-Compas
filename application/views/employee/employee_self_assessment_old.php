<div class="content">
	<div class="row projects">
		<?php foreach($assessments as $assessment){ ?>
		<div class="col-lg-6">
			<div class="panel panel-default card-view"  style="height: 230px;">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark"><?php echo $assessment['assessment_name']; ?></h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL; ?>/employee/self_ass_summary_details?status=self&ass_type=<?php echo $assessment['self_ass_type']; ?>&assessment_id=<?php echo $assessment['assessment_id']; ?>&position_id=<?php echo $assessment['position_id']; ?>&emp_id=<?php echo $_SESSION['emp_id']; ?>&assessment_pos_id=<?php echo $assessment['assessment_pos_id']; ?>" class="btn btn-info btn-xs pull-left mr-15"><i class="fa fa-paste"></i> View</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">  
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div>
								<span class="pull-left inline-block capitalize-font txt-dark">
									Position
								</span>
								<span class="label label-warning pull-right"><?php echo $assessment['position_name']; ?></span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10">
								<span class="pull-left inline-block capitalize-font txt-dark">
									Start Date
								</span>
								<span class="label label-primary pull-right"><?php echo date("d-m-Y",strtotime($assessment['start_date'])); ?></span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10">
								<span class="pull-left inline-block capitalize-font txt-dark">
									End Date
								</span>
								<span class="label label-primary pull-right"><?php echo date("d-m-Y",strtotime($assessment['end_date'])); ?></span>

								<div class="clearfix"></div>
							</div>
						</div>	
					</div>
					
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>


