
		<div class="panel-heading">
			<h5>Self Assessement</h5>
		</div>
		<div class="panel-body">
			<div class="">
				<div class='table-responsive'>
					<form action='' method='post' name="summary_sumbit" id="summary_sumbit">
					<input type="hidden" name="parent_org_id" value="<?php echo $_SESSION['parent_org_id'];?>" >
					<input type="hidden" name="assessment_id" value="<?php echo $id;?>" >
					<input type="hidden" name="position_id" value="<?php echo $pos_id;?>" >
					<input type="hidden" name="employee_id" value="<?php echo $emp_id;?>" >
					<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width="100%">
						<thead>
							<tr>
								<th style="width:20%">Competency name</th>
								<th  style="width:10%">Required Level</th>
								<th  style="width:10%">Self Assessed Level</th>
							</tr>
							
						</thead>
						<tbody>
							<?php
							foreach($competency as $competencys){
							?>
							<tr>
							<td scope='row'>
							<input type="hidden" name="self_report_id[]" value="<?php echo !empty($competencys['self_report_id'])?$competencys['self_report_id']:"";?>">
							<input type="hidden" name="competency[]" value="<?php echo $competencys['comp_def_id'];?>" >
							<a data-target="#workinfoviewadd<?php echo $competencys['comp_def_id']; ?>" data-toggle='modal' href='#workinfoviewadd<?php echo $competencys['comp_def_id']; ?>' onclick="open_comp_indicator(<?php echo $competencys['comp_def_id']; ?>,<?php echo $competencys['scale_id'];?>);"><?php echo $competencys['comp_def_name'];?></a></td>
							<td><input type="hidden" name="requiredlevel_<?php echo $competencys['comp_def_id'];?>" value="<?php echo $competencys['scale_id'];?>" >
							<a data-target="#workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>" data-toggle='modal' href='#workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>' onclick="open_comp_level(<?php echo $competencys['comp_def_id']; ?>);"><?php echo $competencys['scale_name'];?></a></td>
							
								<td>
								<?php $data="";
								$data="
								<select name='OVERALL_".$competencys['comp_def_id']."' id='OVERALL_".$competencys['comp_def_id']."' class='validate[required] form-control m-b' style='width:200px;'>
								<option value=''>Select</option>";
								$level_id=UlsCompetencyDefinition::viewcompetency($competencys['comp_def_id']);
								$scale_overall=UlsLevelMasterScale::levelscale($level_id['comp_def_level']);
								foreach($scale_overall as $scales){
									$final_scale=!empty($competencys['assessed_scale_id'])?$competencys['assessed_scale_id']==$scales['scale_id']?"selected='selected'":"":"";
									$data.="<option value='".$scales['scale_id']."' ".$final_scale.">".$scales['scale_name']."</option>";
								}
								$data.="</select>";
								echo $data; ?>
								</td>
								
							</tr>
							<div id="workinfoviewadd<?php echo $competencys['comp_def_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="color-line"></div>
										<div class="modal-header">
											<h6 class="modal-title">Competency Indicator</h6>
										</div>
										<div class="modal-body">
											<div id="indicator_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
											
											</div>
										</div>
										
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div>
							<div id="workinfoviewadd_level<?php echo $competencys['comp_def_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="color-line"></div>
										<div class="modal-header">
											<h6 class="modal-title">Level Details</h6>
										</div>
										<div class="modal-body">
											<div id="level_comp<?php echo $competencys['comp_def_id']; ?>" class="modal-body no-padding">
											
											</div>
										</div>
										
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div>
							<?php } ?>
						</tbody>
					</table>
					
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">Development Plan</h6>
						</div>
						<div class="clearfix"></div>
					</div>
					<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Knowledge</h6>
					<hr class="light-grey-hr">
					<div class="form-group">
						<input type="hidden" name="self_dev_report_id" value="<?php echo !empty($competency_dev['self_dev_report_id'])?$competency_dev['self_dev_report_id']:"";?>">
						<textarea rows="4" name="knowledge_dev" id="knowledge_dev" placeholder="Knowledge" class="validate[required] form-control"><?php echo !empty($competency_dev['knowledge_dev'])?$competency_dev['knowledge_dev']:"";?></textarea>
					</div>
					<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Skill</h6>
					<hr class="light-grey-hr">
					<div class="form-group">
						<textarea rows="4" name="skill_dev" id="skill_dev" placeholder="Skill"  class="validate[required] form-control"><?php echo !empty($competency_dev['skill_dev'])?$competency_dev['skill_dev']:"";?></textarea>
					</div>
					<?php if(count($competency)>0){ ?>
					<div class="text-left m-t-xs">
					   <button class="btn btn-primary " type="button" name="summary_info_submit" id="summary_info_submit"><i class="fa fa-check"></i> Submit</button>
					</div>
					<?php } ?>
					</form>
					<div class="seprator-block"></div>
				</div>
			</div>
		</div>
