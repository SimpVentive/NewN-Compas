<style>
.small{
	height:50px;
}
.small p{
	font-size:10px;
	
}
</style>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">				
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Assessment Name</th>
								<th><?php  echo $compdetails['assessment_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Start Date</th>
								<th><?php  echo date('d-m-Y',strtotime($compdetails['start_date']));?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">End Date</th>
								<th><?php  echo date('d-m-Y',strtotime($compdetails['end_date']));?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					
				</div>
            </div>
		</div>
	</div>
	<div class="panel panel-default card-view panel-refresh">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-dark">Assessing Positions</h6>
			</div>
			
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
		<form id="assessment_master" action="<?php echo BASE_URL;?>/admin/assessment_questionbank_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
		<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo $_REQUEST['id']; ?>">
			<div class="row">
			<div class="col-md-2">								
				&nbsp;
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label mb-10 col-sm-2">Position Name:</label>
					<div class="col-sm-7">
						<select name="ass_position_id" id="ass_position_id" class=" form-control m-b" onchange="getcompetencytest(<?php echo $_REQUEST['id']; ?>)">
							<option value="">Select</option>
							<?php 
							foreach($position_details as $position){
								$sel_sat=(isset($_REQUEST['pos_id']))?($_REQUEST['pos_id']==$position['position_id'])?"selected='selected'":'':''
								?>
								<option value="<?php echo $position['position_id'];?>" <?php echo $sel_sat;?>><?php echo $position['position_name'];?></option>
							<?php 
							} ?>
						</select>
					</div>
				</div>
				
			</div>
			<div class="col-md-2">								
				&nbsp;
			</div>
			
			</div>
			<div class="row">
				<div id="competencydetails">
				
				</div>
			</div>
			<div class="row">
				<div id="competencybank">
				
				</div>
			</div>
			<div class='seprator-block' style='margin-bottom: 10px;'></div>
			<div class='row'>
				<div class='col-md-offset-9 col-md-9'>
					<button class='btn btn-info btn-icon left-icon  mr-10' type='submit' name="submit"> <i class='zmdi zmdi-edit'></i> <span>Submit</span></button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function(){
	getcompetencytest(<?php echo $_REQUEST['id']; ?>);
});
function get_check_question(id){
	window.open(BASE_URL+"/admin/questions_view_assessment_view?assess_test_id="+id,'_blank')
}
</script>