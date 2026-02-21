<style>
.modal-lg {
	width: 1200px;
}
</style>
<div class=''>
	<div class='panel panel-default card-view'>
		<div class='' style="max-height: none;">
			<div class='table-responsive'>
				<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
					<thead>
						<tr>
							<th style="width:20%">Method name</th>
							<th style="width:30%">Rating Value</th>
							<th style="width:50%">Comments</th>
						</tr>
						<?php foreach($rating_values as $rating_value){ ?>
						<tr>
							<td><?php echo $rating_value['assessment_type']; ?></td>
							<td><?php echo $rating_value['rating_name_scale']; ?></td>
							<td><?php echo $rating_value['comments']; ?></td>
						</tr>
						<?php
						}?>
					</thead>
				</table>
			</div>
			<div class='table-responsive'>
				<form action='' method='post' name="summary_sumbit" id="summary_sumbit">
				
				<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
					<thead>
						<tr>
							<th rowspan='2' style="width:20%">Competency name</th>
							<th rowspan='2' style="width:10%">Required Level</th>
							<th colspan='6' scope='colgroup' align='center' style="width:70%">Assessed Level</th>
						</tr>
						<tr>
							<?php 
							$ass_type=array();
							foreach($ass_test as $ass_tests){ 
								$ass_type[]=$ass_tests['assessment_type'];
								if($ass_tests['assessment_type']=='CASE_STUDY'){
									foreach($test_casestudy as $key=>$test_casestudys){
										$casestudy=$test_casestudys['assessment_type']."-".($key+1);
									?>
										<th>
											<sup><font color="#FF0000">*</font></sup>
												<?php echo $casestudy;?>
										</th>
									<?php
									}
								}
								elseif($ass_tests['assessment_type']=='INBASKET'){
									foreach($test_inbasket as $key=>$test_inbaskets){
										$inbasket=$test_inbaskets['assessment_type']."-".($key+1);
									?>
										<th>
											<sup><font color="#FF0000">*</font></sup>
												<?php echo $inbasket;?>
										</th>
									<?php
									}
								}
								else{
									?>
									<th scope='col'><?php echo $ass_tests['assessment_type']; ?></th>
								<?php 
								}
							}								
							?>
							<th> Over All</th>
							<th>Development </th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($competency as $competencys){
						?>
						<tr>
						<th scope='row'>
						<input type="hidden" name="report_id[]" value="<?php echo !empty($competencys['report_id'])?$competencys['report_id']:"";?>">
						<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" ><?php echo $competencys['comp_def_name'];?></th>
						<td><input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['req_scale_id'];?>" ><?php echo $competencys['req_scale_name'];?></td>
						<?php
						
						foreach($ass_test as $ass_tests){
							if($ass_tests['assessment_type']=='CASE_STUDY'){
								foreach($test_casestudy as $key=>$test_casestudys){
									$report_comp=UlsAssessmentReportBytype::summary_details_count($competencys['report_id'],$ass_tests['assessment_type'],$competencys['comp_def_id'],$test_casestudys['case_assess_test_id']);
									$flag1=0;
									foreach($report_comp as $report_compss){
										
										if($report_compss['competency_id']==$competencys['comp_def_id']){
											//echo "Reached";
										$flag1=1;
										$scale=UlsLevelMasterScale::levelscale_detail($report_compss['assessed_scale_id']);
										?>
										<td><?php echo $scale['scale_name'];?></td>
										<?php
										}
										else{
											echo "<td></td>";
										}
									}
								
									if($flag1==0){
									//foreach($test_casestudy as $key=>$test_casestudys){
										
										echo "<td></td>";
										//}
									}
								}	
							}
							elseif($ass_tests['assessment_type']=='INBASKET'){
								foreach($test_inbasket as $key=>$test_inbaskets){
									$report_comp=UlsAssessmentReportBytype::summary_details_inbasket_count($competencys['report_id'],$ass_tests['assessment_type'],$competencys['comp_def_id'],$test_inbaskets['inb_assess_test_id']);
									$flag2=0;
									foreach($report_comp as $report_compss){
										
										if($report_compss['competency_id']==$competencys['comp_def_id']){
											//echo "Reached";
										$flag2=1;
										$scale=UlsLevelMasterScale::levelscale_detail($report_compss['assessed_scale_id']);
										?>
										<td><?php echo $scale['scale_name'];?></td>
										<?php
										}
										else{
											echo "<td></td>";
										}
									}
								
									if($flag2==0){
									//foreach($test_casestudy as $key=>$test_casestudys){
										
										echo "<td></td>";
										//}
									}
								}	
							}
							else{
								$report_comp=UlsAssessmentReportBytype::summary_detail_info($competencys['report_id'],$competencys['comp_def_id']);
								$flag=0;
								//echo count($report_comp);
								foreach($report_comp as $report_comps){
									if($report_comps['assessment_type']==$ass_tests['assessment_type']){
										//echo $report_comps['assessed_scale_id'];
										$flag=1;
										$scale=UlsLevelMasterScale::levelscale_detail($report_comps['assessed_scale_id']);
									?>
									<td><?php echo $scale['scale_name'];?></td>
									
									<?php 
									}
									?>
									
								<?php 
								}
								if($flag==0){
									echo "<td></td>";
								}
							}
						}							
							 ?>
							<td><?php echo $competencys['as_scale_name'] ?></td>
							<td><?php echo !empty($competencys['development_area'])?$competencys['development_area']:""; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				
				</form>
			</div>
		</div>
	</div>
</div>