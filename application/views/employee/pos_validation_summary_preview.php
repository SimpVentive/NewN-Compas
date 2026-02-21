<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="test-head">
						<div class="icon material-icons">supervised_user_circle</div>
						<div class="test-info">
							<div class="test-name">IDP Process</div>
							<p class="test-content red-text">Technical</p>
						</div>
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<!-- TEST BODY :BEGIN -->
				<div class="idp-process-review custom-scroll">
					
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">JD Validation</div>

							<div class="form-group">
								<label class="label">Accountabilities:</label>
								<p class="value"><?php echo $emp_validation_details['accountabilities']; ?></p>
							</div>

							<div class="form-group">
								<label class="label">Responsibilities:</label>
								<p class="value"><?php echo $emp_validation_details['responsibilities']; ?></p>
							</div>

						</div>
					</div>
					<hr>
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">Competency Profile Validation</div>
							<?php 
							foreach($comp_details as $comp_detail){
							?>
							<h5><?php echo $comp_detail['name']; ?></h5>
							<hr/>
							<div class="row">
							<?php 
							$competency=UlsPositionTemp::get_self_validation_competencies_summary($_REQUEST['val_id'],$_REQUEST['position_id'],$_REQUEST['val_pos_id'],$comp_detail['category_id']);
							foreach($competency as $key=>$competencys){
							?>
								<div class="col-4">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details">
											<div class="d-flex">
												<label class="name"><?php echo $competencys['comp_def_name']; ?></label>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Require :</label>
												<span class="ans"><?php 
												foreach($require as $requires){
													echo $final_req=!empty($competencys['required_process'])?$competencys['required_process']==$requires['code']?$requires['name']:"":"";
												}
												?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Suggested Level :</label>
												<span class="ans">
												<?php
												$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
												$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
												foreach($scale_overall as $scales){
													echo $final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?$scales['scale_name']:"":"";
													
												}
												?></span>
											</div>
											
										</div>
									</div>
								</div>
							<?php } ?>
							</div>
							<?php } ?>
						</div>

					</div>
					<hr>
					<div class="tast-tab-nav">
						<div class="test-body">
							<div class="idp-review-title">KRA's Validation</div>
							
							<div class="row">
							<?php
							foreach($emp_kra_validation_details as $key=>$emp_kra_validation_detail){
							$datas=trim($emp_kra_validation_detail['kra_master_name']);
							if(!empty($datas)){
							?>
								<div class="col-6">
									<div class="case-question-box mb-3">
										<div class="number"><?php echo $key+1; ?></div>
										<div class="case-details">
											<div class="d-flex">
												<label class="name"><?php echo $emp_kra_validation_detail['kra_master_name'];?></label>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">KPI :</label>
												<span class="ans"><?php echo $emp_kra_validation_detail['kra_kri'];?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">UOM :</label>
												<span class="ans"><?php echo $emp_kra_validation_detail['kra_uom'];?></span>
											</div>
											<div class="d-flex mb-1">
												<label class="label min-width">Require :</label>
												<span class="ans">
												<?php
												foreach($require as $requires){
													if($requires['code']!='M'){
														echo $final_req=!empty($emp_kra_validation_detail['required_process'])?$emp_kra_validation_detail['required_process']==$requires['code']?$requires['name']:"":"";
													}
												}
												?></span>
											</div>
											
										</div>
									</div>
								</div>
							<?php }
							}
							?>
							</div>
							
						</div>

					</div>
				</div>
				<!-- TEST BODY :END -->
				<form action="<?php echo BASE_URL;?>/employee/position_assessment_final" method="post"  id="tab_strengths_sumbit">
				<input type="hidden" name="val_id" value="<?php echo $_REQUEST['val_id'];?>" >
				<input type="hidden" name="position_id" value="<?php echo $_REQUEST['position_id'];?>" >
				<input type="hidden" name="val_pos_id" value="<?php echo $_REQUEST['val_pos_id'];?>" >
				<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
				<div class="test-footer d-flex align-items-center justify-content-between">
					<a href="<?php echo BASE_URL;?>/employee/employee_validation_details?id=3&status=strength&jid=<?php echo $_REQUEST['val_id'];?>&val_id=<?php echo $_REQUEST['val_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&val_pos_id=<?php echo $_REQUEST['val_pos_id'];?>" class="btn btn-light">Back</a>
					<button type="submit" name="final_submit" class="btn btn-primary">Submit</button>
				</div>
				</form>
			</div>
			<!-- TEST SECTION :END -->
		</div>
	</div>
</section>