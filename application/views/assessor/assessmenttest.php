<style>
.col-md-2 {
    width: 24.667%;
}
</style>
<div class="col-lg-12">		
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php $empname=str_replace(array("_","@"),array(" ","."),trim($emp_name)); ?>
			<h6>Employee: <?php echo $empname; ?></h6>
			<?php
			$inb=$case=$test=$int=0;
			if(!empty($ass_rating)){
				foreach($ass_rating as $ass_ratings){
					if(($ass_ratings['assessment_type']=='INBASKET')){
						//echo $comp_inbasket['total_count'];
						if(!empty($ass_ratings['scale_id']) && !empty($ass_ratings['comments']) && $comp_inbasket['total_count']!=0){
							$inb=1;
						}
						
					}
					if(($ass_ratings['assessment_type']=='CASE_STUDY')){
						if(!empty($ass_ratings['scale_id']) && !empty($ass_ratings['comments'])){
							$case=1;
						}
						
					}
					if(($ass_ratings['assessment_type']=='TEST')){
						if(!empty($ass_ratings['scale_id'])){
							$test=1;
						}
					}
					if(($ass_ratings['assessment_type']=='INTERVIEW')){
						if(!empty($ass_ratings['scale_id'])){
							$int=1;
						}
					}
				}
			}
			if(($inb==1) && ($case==1) && ($test==1) && ($int==1) ){
				?>
				<p>You have completed assessing <?php echo $empname; ?>.</p>
				<?php
				/* if(isset($rating_ass_final['final_id'])){
				?>
				<p>You have completed assessing <?php echo $empname; ?>.</p>
				<?php
				}
				else{
				?>
				<p>Assessing is <code>Inprocess</code> for <?php echo $empname; ?>.</p>
				<?php
				} */
			}
			elseif(($test==1) && ($int==1)){
				?>
				<p>You have <b style="color:green;font-size:18px;">completed</b> assessing <?php echo $empname; ?>.</p>
				<?php
			}
			else{
				?>
				<p>Assessor Evaluation <code>Pending </code> for <?php echo $empname; ?>.</p>
			<?php
			}
			?>
		</div>
		<div class="panel-body">
			<div class="row col-lg-12">
				<?php		
				//if(isset($rating_ass_final['final_id'])){
				?>
				<!--<div class="panel-body">
					<div class="alert alert-success alert-dismissable">
						<i class="zmdi zmdi-check pr-15 pull-left"></i><p class="pull-left">You have completed assessing <?php echo $empname; ?>.</p>
						<div class="clearfix"></div>
					</div>
				</div>-->
				<?php
				/* }
				else{ */
				foreach($ass_test as $ass_tests){
					//if(($ass_tests['assessment_type']!='FEEDBACK') && ($ass_tests['assessment_type']!='BEHAVORIAL_INSTRUMENT')){
					$test=($ass_tests['assessment_type']=='TEST')?"science":"";
					$case=($ass_tests['assessment_type']=='CASE_STUDY')?"global":"";
					$inbasket=($ass_tests['assessment_type']=='INBASKET')?"airplay":"";
					$interview=($ass_tests['assessment_type']=='INTERVIEW')?"note2":"";
					$feedback=($ass_tests['assessment_type']=='FEEDBACK')?"science":"";
					$be_inst=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"airplay":"";
					$test_button=($ass_tests['assessment_type']=='TEST')?"danger2":"";
					$case_button=($ass_tests['assessment_type']=='CASE_STUDY')?"warning":"";
					$inbasket_button=($ass_tests['assessment_type']=='INBASKET')?"danger":"";
					$interview_button=($ass_tests['assessment_type']=='INTERVIEW')?"warning2":"";
					
					if($ass_tests['assessment_type']=='TEST'){
						$ass_name="MCQ";
					}
					elseif($ass_tests['assessment_type']=='INBASKET'){
						$ass_name="In-basket";
					}
					elseif($ass_tests['assessment_type']=='CASE_STUDY'){
						$ass_name="Casestudy";
					}
					elseif($ass_tests['assessment_type']=='INTERVIEW'){
						$ass_name="Interview";
					}
					elseif($ass_tests['assessment_type']=='FEEDBACK'){
						$ass_name="360&deg; Feedback";
					}
					elseif($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT'){
						$ass_name="Behavioural Instrument";
					}
				?>
				<div class="col-md-2">
					<div class="hpanel">
						<div class="panel-body">
							
							<div class="text-center">
								<h4 class="m-b-xs"><?php echo $ass_name;?></h4>
								<div class="m">
									<i class="pe-7s-<?php echo $test; ?><?php echo $case; ?><?php echo $inbasket; ?><?php echo $interview; ?><?php echo $feedback; ?><?php echo $be_inst; ?> fa-5x"></i>
								</div>
								<a onclick="open_ass_test(<?php echo $ass_tests['assess_test_id'];?>,<?php echo $employee_id; ?>,<?php echo $position_id; ?>);" class="btn btn-primary <?php echo $case_button; ?><?php echo $inbasket_button; ?><?php echo $interview_button; ?> btn-sm">View</a>
							</div>
							<div class="clearfix mt-10"></div>
						</div>
					</div>
				</div>
				<?php
					//} 
				}
				?>
				<div class="col-md-2">
					<div class="hpanel">
						<div class="panel-body">
							<div class="text-center">
								
								<h4 class="m-b-xs">Final Summary</h4>
								<div class="m">
									<i class="pe-7s-study fa-5x"></i>
								</div>
								<?php
								//echo count($rating_ass);
								$button=((count($rating_ass)>=3) && $comp_inbasket['total_count']!=0)?'btn-primary':'btn-default';
								?>
								<a id="finalbtn" onclick="open_summary_sheet(<?php echo $_REQUEST['assessment_id'] ?>,<?php echo $employee_id; ?>,<?php echo $position_id; ?>,<?php echo $_SESSION['asr_id']; ?>);" class="btn btn-sm <?php echo $button; ?>">Prepare</a>
							</div>
							<div class="clearfix mt-10"></div>
						</div>
					</div>
				</div>
				<?php //} ?>
			</div>
			<br><br>
			<div class="row">
				<div class="col-md-12" id="open_assessment">
				
				</div>
				<div class="col-md-12" id="open_summary_info<?php echo $position_id; ?>"></div>
			</div>
		</div>
	</div>
</div>