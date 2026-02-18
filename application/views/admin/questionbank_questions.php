<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Question Bank Name</th>
								<th><?php echo isset($questionbank['name'])? $questionbank['name'] :"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Published Status </th>
								<th><?php echo ($questionbank['active_flag']=='P')? "Published" : " Not Published";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Question Bank Type </th>
								<th><?php 	$quest_bank_type=(isset($questionbank->type))?$questionbank->type:'';
								foreach($assesment as $assesments){
									echo ($quest_bank_type==$assesments['code'])?$assesments['name'] :"";
								} ?> &nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Description </th>
								<th><?php echo $questionbank['description'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="wizard-actions">
						<div class="col-sm-offset-0">
							<input type="button" name="edit" class="btn btn-primary btn-sm" id="edit" onClick="create_link('question_creation?step1&type=<?php echo $quest_bank_type;?>&id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')" value="Add Question">
							<input type="button" name="clear" class="btn btn-danger btn-sm" id="clear" value="Cancel"  onClick="create_link('questionbank_search')">
						</div>
					</div>
					<hr class="light-grey-hr">
					<h3 class="lighter block green">Questions</h3>
					<div class="table-responsive">
						<table class="table table-hover table-bordered mb-0" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
								<tr>
									<th style="width:10px;">S.No</th>
									<th  style="width:400px;">Question Name </th>
									<th style="width:200px;">Question Type</th>
									<th style="width:130px;">Level</th>
									<th style="width:60px;">Status</th>
									<th style="width:130px;">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(!empty($allquests)){
								$sno=0;
								foreach($allquests as $key=>$questionbanks){
								$key1=$key+1; $sno++;
								if(!empty($questionbanks['active_flag'])){
									$status=Doctrine_Core::getTable('UlsAdminValues')->findOneByValue_codeAndMaster_code($questionbanks['active_flag'],'PUBLISH_STATUS');
									$sta=$status['value_name'];
								}
								else{
									$sta="Un Publish";
								}
								$startdate=date('d-m-Y',strtotime($questionbanks['stdate']));
								$enddate=(($questionbanks['endate']==Null))?"" : date('d-m-Y',strtotime($questionbanks['endate']));
								$qid=$questionbanks['qid'];
								$hash=md5(SECRET.$qid);
								$hash2=md5(SECRET.$_REQUEST['id']); ?>
								<tr id="row_<?php echo $qid; ?>">
									<td><?php echo $sno ?></td>
									<td><?php echo strip_tags($questionbanks['qname']); ?></td>
									<td><?php echo $questionbanks['qtype'] ?></td>
									<td><?php echo $questionbanks['scale_name'] ?></td>
									<td><?php echo @$sta ?></td>
									<td class="tooltip-demo">
										<?php if(isset($_REQUEST['type'])){
											$href=($_REQUEST['type']=='PROG_EVAL')?BASE_URL."/admin/question_creation?type=".$_REQUEST['type']."&id=".$_REQUEST['id']."&hash=".$hash2:BASE_URL."/admin/question_creation?step1&type=".$_REQUEST['type']."&qid=".$qid."&id=".$_REQUEST['id']."&hash=".$hash2;
										}?>
										<?php $type=$_REQUEST['type'];?>
										<a class="mr-10" data-toggle="tooltip" data-placement="top" title="View" href="<?php echo BASE_URL."/admin/question_view?type=".$type."&id=". $qid."&hash=".$hash;?>"><i class="fa fa-eye text-success"></i></a>
										<a class="mr-10" data-toggle="tooltip" data-placement="top" title="Update" href="<?php echo $href;?>"><i class="fa fa-pencil text-primary"></i> </a>
										<a class="mr-10" data-toggle="tooltip" data-placement="top" title="Delete" id="<?php echo @$qid; ?>" name="deletequestion" rel="row_<?php echo @$qid; ?>" onclick="deletefunction(this)"><i class="fa fa-trash-o text-danger"></i></a>
									</td>
								</tr>
								<?php }} else { ?>
								<tr>
									<td colspan="5" align="Center">No data found.</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="hr-line-dashed"></div>
				</div>
            </div>
        </div>
    </div>
</div>
