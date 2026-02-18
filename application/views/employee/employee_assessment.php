<div class="content">
	<div class="row projects">
		<?php foreach($assessments as $assessment){ ?>
		<div class="col-lg-4">
			<div class="panel panel-default card-view"  style="height: 300px;">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark"><?php echo $assessment['assessment_name']; ?></h6>
					</div>
					<div class="pull-right">
						<?php 
						$date=date("Y-m-d");
						if($assessment['end_date']<$date){
						?>
						<a class="btn btn-danger btn-xs pull-left mr-15">Closed</a>
						<?php
						}
						else{
						?>
						<a href="<?php echo BASE_URL; ?>/employee/employee_assessment_details?assessment_id=<?php echo $assessment['assessment_id']; ?>&position_id=<?php echo $assessment['position_id']; ?>&assessment_pos_id=<?php echo $assessment['assessment_pos_id']; ?>" class="btn btn-info btn-xs pull-left mr-15"><i class="fa fa-paste"></i> View</a>
						<?php
						}
						?>
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
									Assessor 
									<?php 
									if(!empty($assessment['ass_coun'])){
									?>
									<span class="label label-danger">
										<?php echo $assessment['ass_coun']; ?>
									</span>
									<?php } ?>
								</span>
								<span class="pull-right">
									<div class="project-people">
										<?php
										$assessors=UlsAssessmentPositionAssessor::getassessors_details($assessment['assessment_id'],$assessment['position_id']);
										foreach($assessors as $assessor){
										$pic_path=BASE_URL.'/public/images/male_user.jpg';
										if(isset($assessor['assessor_photo'])){ $pic_path=(!empty($assessor['assessor_photo']))?BASE_URL.'/public/uploads/assessor_pic/'.trim($assessor['assessor_photo']):(($assessor['gender']=='M')?BASE_URL.'/public/images/male_user.jpg':BASE_URL.'/public/images/female_img.jpg'); } ?>
										<img alt="logo" class="img-circle" src="<?php echo $pic_path;?>" style="width:20px;">
										<?php
										}?>
									</div>
									
								</span>
								
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


