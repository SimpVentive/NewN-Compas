<style>
.modal-lg {
    width: 900px;
}
</style>
<div class="content">
<div class="row">  
    <div class="col-lg-12">
        <div class="panel panel-inverse card-view">
			<form action="<?php echo BASE_URL ; ?>/admin/addquestions_test?id=<?php echo $_REQUEST['id'];?>" name="manageTestForm" id="manageTestForm" method="post" class="searchForm">
			<?php if(!empty($this->session->flashdata('msg'))){ echo "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'><i class='ace-icon fa fa-times'></i></button><p>".$this->session->flashdata('msg')."</p></div>"; $this->session->unset_userdata('msg');} ?>
            <div class="panel-heading hbuilt">
				Adding questions to the Test.
				
			</div>
			<div class="panel-body">
				
				<input type="hidden" name="testid" id="testid" value="<?php echo $_REQUEST['id'] ?>" /> 
				<div class="row">

					<div class="col-md-3">
						
						<div class="form-group col-lg-12">
							<label>Question bank Name</label>
							<select class="validate[required] form-control m-b" id="qbank" name="qbank" >
								<option value="">Select</option>
								<?php 
								foreach($questnames as $questname){?>
									<option value="<?php echo $questname->qid; ?>"><?php echo $questname->qname; ?></option>
								<?php 
								} ?>
							</select> 
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="text-left">
							<label>&nbsp;</label>
							<button type="button" class="btn btn-primary btn-sm form-control" id="search_a" onClick="getquestionbank()">Search</button>
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="text-left">
							<label>&nbsp;</label>
							<button type="button" class="btn btn-primary btn-sm form-control" id="cancel" onClick="create_link('test_home')">Cancel</button>
						</div>

					</div>
				</div>
				 <input type='hidden' name='qbank_id_hidden[]' id='qbank_id_1_hidden' />
				
			</div>
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					Added Questions
				</div>
				<div class="panel-body">
					<input type="button" name="delete" value="Delete" onclick="deletefun()" class="btn btn-sm btn-primary" id="delete">
					<div id="serachdata"  style="margin-top:0px;">
						<div class="table-responsive">
							<table id="data_emp" cellpadding="1" cellspacing="1" class="table table-bordered table-striped" width="100%">
								<thead>
								<tr>
									<th>Select</th>
									<th>Competency</th>
									<th>Question Text</th>
									<th>Question Type</th>
									<th>Level</th>
								</tr>
								</thead>
								<tbody id="questiondata">
								<?php  
								$addgpval=''; $gg="";
								if(count($testquestions)>0){
									foreach($testquestions as $key=>$empdatas1){
										$keys=$key+1;
										$gg=empty($addgpval)? ($addgpval=$empdatas1['qid']) : ($addgpval=$addgpval.','.$empdatas1['qid']); 
										?>
										<tr>
											<td>
											   <input type='checkbox' name='check[]' id='check1[<?php echo $keys ?>]'  value="<?php echo $empdatas1['qid']; ?>">
											</td>
											<td>
												<?php echo $empdatas1['comp_def_name'];?>
											</td>
											<td>
												<?php echo $empdatas1['qname'];?>
											</td>
											<td><?php echo $empdatas1['qtype']; ?>
											</td>
											<td><?php echo $empdatas1['scale_name'] ; ?>
											</td>
										</tr>
										<?php  
									}
								} 
								else { ?>
									<tr><td style="height:30px;" colspan="4">&emsp; No data found.</td></tr>
								<?php 
								} ?>
								</tbody>
							</table>
						</div>
						<input id='addgroup' type='hidden' value="<?php echo $gg; ?>" name='addgroup'>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group" id="buttonsdiv" style="display:none;" >
						<div class="col-sm-offset-9">
							<button class="btn btn-primary btn-sm" type="button" onClick="goback()">Cancel</button>
							<button class="btn btn-primary btn-sm" type="submit" onClick="return validation()" name="submit" id="submit">Save changes</button>
						</div>
					</div>
				</div>
			</div> 
			</form>
        </div>
    </div>
</div>
</div>

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Questions ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		You cant delete this Question.This Question was taken by Employees. ?.
	</div>

	<div class="space-6"></div>
	
</div>
<div id="dialog-confirm-delete1" class="hide">
	<div class="alert alert-info bigger-110">
		Please select Question.
	</div>
	<div class="space-6"></div>
</div>
<div id="modalquestionbank" class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div class="modal-header no-padding">
				<div class="modal-header">
					<h6 class="modal-title">Add Questions</h6>
				</div>
				
			</div>
			<div id="test_questions" class="modal-body">
				
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>