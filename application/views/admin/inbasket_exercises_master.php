<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
<style>
	.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
	.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.ui-state-default{border:0px;background: #fff;}
	.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
	.column { list-style-type: none; margin: 0; padding: 0; width: 95%;}
	.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
	.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
	.portlet-content {padding: 0.4em;}
	.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}</style>
<script>
<?php
// To pass the Requested Status to empcreation.js File
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
/* $competency_details='';
foreach($competency as $competencys){
    if($competency_details==''){
        $competency_details=$competencys['comp_def_id']."*".$competencys['comp_def_name'];
    }
    else{
        $competency_details=$competency_details.",".$competencys['comp_def_id']."*".$competencys['comp_def_name'];
    }
}
echo "var comp_details='".$competency_details."';";
$competency_test='';
foreach($inbas_test as $inbas_tests){
    if($competency_test==''){
        $competency_test=$inbas_tests['question_bank_id']."*".$inbas_tests['name'];
    }
    else{
        $competency_test=$competency_test.",@_".$inbas_tests['question_bank_id']."*".$inbas_tests['name'];
    }
}
echo "var test_details='".$competency_test."';"; */
?>
</script>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">
					<?php
					$inbaskets=$this->session->flashdata('inbasket');
					if(!empty($inbaskets)){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$this->session->flashdata('inbasket')."</p></div>"; $this->session->unset_userdata('inbasket');} ?>
					<ul class="nav nav-pills">
						<?php
						if(isset($_REQUEST['id'])){
						?>
							<li id='information_li'><a data-toggle="tab" href="#infomation-info">Step 1 - Inbasket Details</a></li>
							<li id='competency_li'><a data-toggle="tab" href="#competency-info">Step 2 - Create Questions</a></li>
							<li id='questions_li'><a data-toggle="tab" href="#questions-info">Step 3 - View Question & Sort</a></li>
						<?php }
						else{
						?>
							<li id='information_li' class="active"><a data-toggle="tab" href="#infomation-info">Step 1 - Inbasket Details</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#competency-info">Step 2 - Create Questions</a></li>
							<li class="disabled" style="pointer-events:none;"><a data-toggle="tab" href="#questions-info">Step 3 - View Question & Sort</a></li>
						<?php
						}
						?>
					<br/><br/><br/>
					</ul>
					<div class="tab-content">
						<div id="infomation-info" class="p-m tab-pane active">
							<form id="inbasket_master" action="<?php echo BASE_URL;?>/admin/inbasket_insert" method="post" enctype="multipart/form-data">
							
							<input type="hidden" name="inbasket_id" id="inbasket_id" value="<?php echo (isset($inbasket['inbasket_id']))?$inbasket['inbasket_id']:''?>">
							<input type="hidden" name="questionbank_id" id="questionbank_id" value="<?php echo (isset($inbasket['question_bank_id']))?$inbasket['question_bank_id']:''?>">
							<input type="hidden" name="question_id" id="question_id" value="<?php echo (isset($inbasket['question_id']))?$inbasket['question_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="row">
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Inbasket Name<sup><font color="#FF0000">*</font></sup>:</label>
											<input type="text" class="validate[required] form-control" name="inbasket_name" id="inbasket_name"  value="<?php echo (isset($inbasket['inbasket_name']))?$inbasket['inbasket_name']:''?>">
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Position Name<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="position_id" id="position_id" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php
												foreach($positions as $position){
													$sel_sat=(isset($inbasket['position_id']))?($inbasket['position_id']==$position['position_id'])?"selected='selected'":'':''?>
													<option value="<?php echo $position['position_id']?>" <?php echo $sel_sat?>><?php echo $position['position_name']?></option>
												<?php
												}?>
											</select>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Inbasket Naration<sup><font color="#FF0000">*</font></sup>:</label>
											
											<textarea rows="5" class="form-control" name="inbasket_narration" id="inbasket_narration"><?php echo (isset($inbasket['inbasket_narration']))?$inbasket['inbasket_narration']:''?></textarea>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Inbasket Naration Multilingual:</label>
											
											<textarea rows="5" class="form-control" name="inbasket_narration_lang" id="inbasket_narration_lang"><?php echo (isset($inbasket['inbasket_narration_lang']))?$inbasket['inbasket_narration_lang']:''?></textarea>
										</div>
										<!--,ajax[ajaxQuestion_QuestionExist]-->
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Inbasket Instructions<sup><font color="#FF0000">*</font></sup>:</label>
											<textarea rows="5" class="form-control validate[required}" name="inbasket_instructions" id="inbasket_instructions"><?php echo (isset($inbasket['inbasket_instructions']))?$inbasket['inbasket_instructions']:''?></textarea>
										</div>
										
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Time Intervel(Mins)<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="inbasket_time_period" id="inbasket_time_period" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php 
												for($i=5; $i<=300; $i+=5){
												$sel_time=(isset($inbasket['inbasket_time_period']))?($inbasket['inbasket_time_period']==$i)?"selected='selected'":'':''?>
												<option value='<?php echo $i;?>' <?php echo $sel_time; ?>><?php echo $i;?></option>
												<?php
												}
												?>
											
											</select>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left" data-placement="top" data-toggle="tooltip"  data-original-title="Do you want the Participant to Classify the Action he/she takes on each inbasket item">Inbasket Actions<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="inbasket_action" id="inbasket_action" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php
												foreach($yesstat as $yesstats){
													$sel_sat=(isset($inbasket['inbasket_action']))?($inbasket['inbasket_action']==$yesstats['code'])?"selected='selected'":(($yesstats['code']=='Y')?"selected='selected'":''):(($yesstats['code']=='Y')?"selected='selected'":'');?>
													<option value="<?php echo $yesstats['code']?>" <?php echo $sel_sat?>><?php echo $yesstats['name']?></option>
												<?php
												}?>
											</select>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left" data-placement="top" data-toggle="tooltip"  data-original-title="You may as a assessor or administrator have identified a pre determined Sorting order for this inbasket">Expected Scorting order<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="inbasket_scorting_order" id="inbasket_scorting_order" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php
												foreach($yesstat as $yesstatss){
													$sel_sats=(isset($inbasket['inbasket_scorting_order']))?($inbasket['inbasket_scorting_order']==$yesstatss['code'])?"selected='selected'":'':(($yesstatss['code']=='N')?"selected='selected'":'')?>
													<option value="<?php echo $yesstatss['code']?>" <?php echo $sel_sats?>><?php echo $yesstatss['name']?></option>
												<?php
												}?>
											</select>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Upload</label>
											<input type="file" id="inbasket_upload" name="inbasket_upload" >
											<label>
											<?php $link_m='';
											$downlaod_page=BASE_URL.'/includes/download_solution.php';
											if(!empty($inbasket['inbasket_upload'])){
												$paths= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'inbasket'.DS.$inbasket['inbasket_id'].DS.$inbasket['inbasket_upload'];
												$link_m=$downlaod_page."?id=".$paths;
												}?>
												<a href='<?php echo $link_m;?>'   style='color:blue; text-decoration: underline;' ><?php echo @$inbasket['inbasket_upload'];?></a>
											</label>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Intray Name<sup><font color="#FF0000">*</font></sup>:</label>
											<input type="text" class="validate[required] form-control" name="inbasket_tray_name" id="inbasket_tray_name"  value="<?php echo (isset($inbasket['inbasket_tray_name']))?$inbasket['inbasket_tray_name']:''?>">
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Inbasket Reason:</label>
											<select class="form-control m-b" name="inbasket_reason" id="inbasket_reason" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php
												foreach($yesstat as $yesstats){
													$sel_sat=(isset($inbasket['inbasket_reason']))?($inbasket['inbasket_reason']==$yesstats['code'])?"selected='selected'":(($yesstats['code']=='Y')?"selected='selected'":''):'';?>
													<option value="<?php echo $yesstats['code']?>" <?php echo $sel_sat?>><?php echo $yesstats['name']?></option>
												<?php
												}?>
											</select>
										</div>
										<div class="form-group col-lg-6">
											<label class="control-label mb-10 text-left">Status<sup><font color="#FF0000">*</font></sup>:</label>
											<select class="form-control m-b validate[required]" name="inbasket_status" id="inbasket_status" data-prompt-position="topLeft:200">
												<option value="">Select</option>
												<?php
												foreach($orgstat as $orgstatus){
													$sel_sat=(isset($inbasket['inbasket_status']))?($inbasket['inbasket_status']==$orgstatus['code'])?"selected='selected'":'':''?>
													<option value="<?php echo $orgstatus['code']?>" <?php echo $sel_sat?>><?php echo $orgstatus['name']?></option>
												<?php
												}?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
								   <button class="btn btn-danger btn-sm" type="button" onclick="create_link('inbasket_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
								   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
						<div id="competency-info" class="p-m tab-pane">
							<form id="comp_master" action="<?php echo BASE_URL;?>/admin/inbasket_competency_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="inbasket_id" id="inbasket_id" value="<?php echo (isset($inbasket['inbasket_id']))?$inbasket['inbasket_id']:''?>">
							<input type="hidden" name="questionbank_id" id="questionbank_id" value="<?php echo (isset($inbasket['question_bank_id']))?$inbasket['question_bank_id']:''?>">
							<input type="hidden" name="question_id" id="question_id" value="<?php echo (isset($inbasket['question_id']))?$inbasket['question_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<div class="">
										<div class="panel-heading hbuilt">
											
											<div class="pull-left">
												<h6 class="panel-title txt-dark">Inbasket Create Questions</h6>
											</div>
											
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2">Competency Selection<sup><font color="#FF0000">*</font></sup>:</label>
											<div class="col-sm-5">
												<select style="width: 100%" name="competency_id" id="competency_id" class=" form-control m-b validate[required]" onchange="open_competency();" >
													<option value="">Select</option>
													<?php 
													foreach($inbasket_comp as $inbasket_comps){
													?>
														<option value="<?php echo $inbasket_comps['comp_def_id']."-".$inbasket_comps['scale_id']; ?>"><?php echo $inbasket_comps['comp_def_name']."-".$inbasket_comps['scale_name']; ?></option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
										
										<div class="row mt-40">
											<div class="col-sm-12" id="data_competency">
												
												
											</div>
										</div>
									
									</div>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-9">
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('inbasket_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onClick="return addsource_details_inbasket_val();"><i class="fa fa-check"></i> Add <?php echo (isset($inbasket['inbasket_tray_name']))?$inbasket['inbasket_tray_name']:''?></button>
								</div>
							</div>
							</form>
						</div>
						<div id="questions-info" class="p-m tab-pane">
							<form id="case_master" action="<?php echo BASE_URL;?>/admin/inbasket_test_insert" method="post" enctype="multipart/form-data">
							<input type="hidden" name="inbasket_id" id="inbasket_id" value="<?php echo (isset($inbasket['inbasket_id']))?$inbasket['inbasket_id']:''?>">
							<div class="row">
								<div class="col-lg-12">
									<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
										<thead>							
											<tr>
												<th style=" background-color: #edf3f4;width:20%">Inbasket Name</th>
												<th><?php echo (isset($inbasket['inbasket_name']))?$inbasket['inbasket_name']:''?>&nbsp;</th>
											</tr>
											<tr>
												<th style=" background-color: #edf3f4;width:20%">Inbasket Narration</th>
												<th><?php echo (isset($inbasket['inbasket_narration']))?nl2br($inbasket['inbasket_narration']):''?> &nbsp;<br>
												<?php echo (isset($inbasket['inbasket_narration_lang']))?$inbasket['inbasket_narration_lang']:''?>
												</th>                                                                                             &nbsp;
											</tr>
											<tr>
												<th style=" background-color: #edf3f4;width:20%">Question Name</th>
												<th><?php echo (isset($inbasket['question_name']))?($inbasket['question_name']):''?> &nbsp;</th>
											</tr>
																	
										</thead>
									</table>
									<?php 
									if(!empty($inbasket['question_id'])){
									$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
									$scorting=($inbasket['inbasket_scorting_order']=='Y')?"sortable":"";
									
									$scorting_arrow=($inbasket['inbasket_scorting_order']=='Y')?"<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>":"";
									?>
									<ul class="column" id="<?php echo $scorting; ?>">
										<?php 
										foreach($question_view as $key=>$question_views){
											if(!empty($question_views['inbasket_mode'])){
											$parsed_json = json_decode($question_views['inbasket_mode'], true);
											}
											
										?>
										<li class="ui-state-default" id="intraydelete_<?php echo $question_views['value_id'];?>">
											<div class="portlet">
												<input type="hidden" name="value_id[]" id="value_id[]" value="<?php echo $question_views['value_id'];?>">
												<div class="portlet-header">
													<?php echo $scorting_arrow; ?> <?php echo (isset($inbasket['inbasket_tray_name']))?$inbasket['inbasket_tray_name']:''?> <?php echo $key+1; ?>
													<a class="mr-10 pull-right" style="padding-right:10px;" data-target="#workinfoviewadd<?php echo $question_views['value_id'];?>" data-toggle='modal' href='#workinfoviewadd<?php echo $question_views['value_id'];?>' onclick="open_question_count(<?php echo $question_views['value_id'];?>,<?php echo (isset($inbasket['inbasket_id']))?$inbasket['inbasket_id']:''?>);"><i class="fa fa-pencil text-primary"></i><span class="bold"></span></a>
													<a class="mr-10 pull-right" style="padding-right:5px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" id="<?php echo $question_views['value_id'];?>" name="delete_inbasket_intray" rel="intraydelete_<?php echo $question_views['value_id'];?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> <span class="bold"></span></a>
													</div>
												<div class="portlet-content">
												
												<p class="text-muted" style="font-weight:bold; float:right;"><b><?php echo $question_views['comp_def_name']; ?> (<code><?php echo $question_views['scale_name']; ?></code>)</b></p>
												<?php
												if(!empty($parsed_json)){
													foreach($parsed_json as $key => $value)
													{
														$yes_stat="IN_MODE";
														$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
													?>
														
													   <p><code>Mode:</code><?php echo $val_code['name'];?></p>
													   <p><code>Time:</code><?php echo $value['period'];?></p>
													   <p><code>From:</code><?php echo $value['from'];?></p>
													   <p><code>Subject:</code><?php echo !empty($value['subject'])?$value['subject']:"";?></p>
													<?php
													}
												} 
												if(!empty($question_views['priority_inbasket'])){
												?>
												<p><code>Priority:</code><?php echo $question_views['priority_inbasket']; ?></p>
												
												<?php 
												}
												?>
												<p class="text-muted"><?php echo nl2br($question_views['text']); ?></p>
												<?php 
												if(!empty($question_views['suggestion_inbasket'])){
												?>
												<p class="text-muted"><code>Suggestions:</code><?php echo nl2br($question_views['suggestion_inbasket']); ?></p>
												
												<?php }
												if(!empty($question_views['reason_inbasket'])){
												?>
												<p class="text-muted"><code>Reason:</code><?php echo nl2br($question_views['reason_inbasket']); ?></p>
												<?php } ?>
												</div>
											</div>
											
										</li>
										<?php } ?>
										
									</ul>
									<?php } ?>
								</div>
							</div>
							<hr class="light-grey-hr">
							<div class="form-group">
								<div class="col-sm-offset-0">
									<?php if(isset($inbasket['inbasket_id'])){ ?>
									<a href="<?php echo BASE_URL;?>/admin/inbasketpdf?id=<?php echo $inbasket['inbasket_id'];?>" target="_blank" class="btn btn-primary btn-xs pull-left mr-15">Generate Pdf</a>
									<?php } ?>
									<button class="btn btn-danger btn-sm" type="button" onclick="create_link('inbasket_exercises_master_search')"><i class="fa fa-reply"></i> <span class="bold">Cancel</span></button>
									<button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit" onClick="return addsource_details_inbasket_validation(3);"><i class="fa fa-check"></i> Submit</button>
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Intray ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected Intray cannot be deleted. Ensure you delete all the usages of the Intray before you delete it.
	</div>

	<div class="space-6"></div>
	
</div>
<?php
if(!empty($inbasket['question_id'])){
	$question_view=UlsQuestionValues::get_allquestion_values_competency($inbasket['question_id']);
	foreach($question_view as $key=>$question_views){
	?>
	<div id="workinfoviewadd<?php echo $question_views['value_id'];?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="color-line"></div>
				<div class="modal-header">
					<h6 class="modal-title">Edit Intray</h6>
				</div>
				<div class="modal-body">
					<div id="questionbank_count<?php echo $question_views['value_id'];?>" class="modal-body no-padding">
					
					</div>
				</div>
				
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<?php 
	}
}?>