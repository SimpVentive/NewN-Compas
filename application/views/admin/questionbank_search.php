<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Create Question Bank</h6>
					</div>
					<div class="pull-right">
						<a href="<?php echo BASE_URL;?>/admin/questionbank_creation" class="btn btn-primary btn-xs pull-left mr-15">&nbsp <i class="fa fa-plus-circle"></i> Create Question Bank &nbsp </a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-body">
					<form action="" id="loginForm" class="searchForm" method="get">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Question Bank Type</label>
									<select name="assesment" class="validate[required] form-control m-b">
										<option value="">Select</option>
										<?php
										foreach($assesments as $asses){
											if($asses['code']=='COMP_TEST' || $asses['code']=='COMP_INTERVIEW'){
											$type_sel=(isset($assesment))?($assesment==$asses['code'])?"selected='selected'":'':''?>
											<option value="<?php echo $asses['code']; ?>" <?php echo $type_sel;?>><?php echo $asses['name']; ?></option>
										<?php }
										}										
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">								
								<div class="form-group col-lg-12">
									<label class="control-label mb-10 text-left">Question Bank Name</label>
									<input value="<?php echo @$ques_name; ?>" id="ques_name" class="form-control" name="ques_name" type="text">
								</div>
							</div>
							<div class="form-group col-md-1">
								<div class="text-left">
									<label class="control-label mb-10 text-left">&nbsp;</label>
									<button class="btn btn-primary btn-sm">Search</button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="hpanel">
					<div class="panel-body">
						<div class="table-wrap">
							<div class="table-responsive">
								<div id="edit_datable_2_wrapper" class="dataTables_wrapper">
									<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
										<thead>
											<tr>
												<th class="col-sm-5">Question Bank Name</th>
												<th class="col-sm-1">Status</th>
												<th class="col-sm-1">Type</th>
												<th class="col-sm-1">No of Questions</th>
												<th class="col-sm-1">PDF</th>
												<th class="col-sm-1">CSV</th>
												<th class="col-sm-3">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($searchresults as $val){
											$qid=$val['question_bank_id'];
											$qtype=$val['type'];
											$hash=md5(SECRET.$qid); ?>
											<tr id="qbank_<?php echo $val['question_bank_id']; ?>">
												<td><?php echo $val['name']; ?></td>
												<td><?php echo $val['publish_status']; ?></td>
												<td><?php echo $val['ass_type']; ?></td>
												<td><a class="mr-10" data-target="#workinfoviewadd<?php echo $val['question_bank_id']; ?>" data-toggle='modal' href='#workinfoviewadd<?php echo $val['question_bank_id']; ?>' onclick="open_question_count(<?php echo $val['question_bank_id']; ?>);">&nbsp;<?php echo $val['questioncount']==null?0:$val['questioncount']; ?>&nbsp;</a></td>
												<td><a class="mr-10" target='_blank' href="<?php echo BASE_URL;?>/admin/questionbankpdf?type=<?php echo $qtype; ?>&id=<?php echo @$val['question_bank_id'];?>&hash=<?php echo md5(SECRET.$val['question_bank_id']);?>"><i class="fa fa-upload"></i></a></td>
												<td><a class="mr-10" target='_blank' href="<?php echo BASE_URL;?>/admin/questionbankcsv?type=<?php echo $qtype; ?>&id=<?php echo @$val['question_bank_id'];?>&hash=<?php echo md5(SECRET.$val['question_bank_id']);?>"><i class="fa fa-upload"></i></a></td>
												<td class="tooltip-demo">
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="Manage" href="<?php echo BASE_URL ; ?>/admin/questions?type=<?php echo $qtype; ?>&id=<?php echo $qid; ?>&hash=<?php echo $hash; ?>"><i class="fa fa-book text-info"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="View" href="<?php echo BASE_URL;?>/admin/questionbank_view?type=<?php echo $qtype; ?>&id=<?php echo @$val['question_bank_id'];?>&hash=<?php echo md5(SECRET.$val['question_bank_id']);?>"><i class="fa fa-eye text-success"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="Update" href="<?php echo BASE_URL;?>/admin/questionbank_creation?id=<?php echo @$val['question_bank_id'];?>&hash=<?php echo md5(SECRET.$val['question_bank_id']);?>"><i class="fa fa-pencil text-primary"></i> </a>
													<a class="mr-10" data-toggle="tooltip" data-placement="top" title="Delete" id="<?php echo $val['question_bank_id']; ?>" name="deletequestionbank" rel="qbank_<?php echo $val['question_bank_id']; ?>" onclick="deletefunction(this)"><i class="fa fa-trash text-danger"></i> </a>
												</td>
												<div id="workinfoviewadd<?php echo $val['question_bank_id']; ?>"  class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="color-line"></div>
															<div class="modal-header">
																<h6 class="modal-title">Questions Level Count</h6>
															</div>
															<div class="modal-body">
																<div id="questionbank_count<?php echo $val['question_bank_id']; ?>" class="modal-body no-padding">
																
																</div>
															</div>
															
														</div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												</div>
											</tr>						
											<?php } ?>
										</tbody>
									</table>
									<?php echo $pagination; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function open_question_count(id){
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('questionbank_count'+id).innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/question_count_level?q_id="+id,true);
    xmlhttp.send();
}
</script>