<style>
.hpanel .panel-body {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #eaeaea;
    border-radius: 2px;
    max-height: 145px;
    padding: 20px;
    position: relative;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default card-view">
			
			<div class="panel-heading">
				<div class="pull-left">
					<h6>Position: <?php echo $position['position_name']; ?></h6>
				</div>
				<button class="btn btn-danger  btn-xs pull-right mr-15"  onclick="create_link_ass('assessor_assessment_details?assessment_id=<?php echo $_REQUEST['assessment_id']; ?>')">Back</button>
				<button class="btn btn-primary btn-xs pull-right mr-15" data-toggle='modal' data-target='#profile_details_view<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>' onclick="getassessmentprofiling(<?php echo $position['position_id']; ?>,<?php echo $_REQUEST['assessor_id']; ?>,<?php echo $_REQUEST['assessment_id']; ?>)">Profile</button>
				<button class="btn btn-primary btn-xs pull-right mr-15" data-toggle='modal' data-target='#jd_details_view<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>' onclick="getassessmentjd(<?php echo $position['position_id']; ?>,<?php echo $_REQUEST['assessor_id']; ?>,<?php echo $_REQUEST['assessment_id']; ?>)">JD</button>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="row panel panel-default card-view">
			<div  class="pills-struct vertical-pills">
				<ul role="tablist" class="nav nav-pills ver-nav-pills" id="myTabs_10">
					<?php 
					
					$j=0;$k=0;
					foreach($employees as $key=>$employee){
						$photo=!empty($employee['photo'])?BASE_URL."/public/uploads/profile_pic/".$employee['employee_id'].'/'.$employee['photo']:BASE_URL."/public/images/male_user.jpg";
						/* if(isset($_REQUEST['position_id'])){
							$class="";
						}
						else{ */
							$class=($j==0)?"active":""; 
						/* } */
						$j++;
						if(!empty($assessor['emp_display'])){
							if($assessor['emp_display']=='N'){
								$emp_name="Employee ".($key+1);
							}
							else{
								$emp_name=$employee['full_name'];
							}
						}
						$empname=str_replace(array(" ","."),array("_","@"),trim($emp_name));
								
					?>
						<li class="<?php echo $class; ?>">
							<a data-toggle="tab" href="#tab-<?php echo $_REQUEST['position_id']; ?>" onclick="getemployeeassessment(<?php echo $position_id; ?>,<?php echo $employee['employee_id']; ?>,<?php echo $assessment_id; ?>,'<?php  echo $empname;?>')"> 
								<span class="pull-left inline-block capitalize-font">
									<?php echo $emp_name;  ?>
								</span>
								
								<div class="clearfix"></div>
								
							</a>
						</li>
					<?php 
					} ?>
				</ul>
				<div class="tab-content" id="myTabContent_10">
					<div class="row">
						<div id='employeedetails'>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id='profile_details_view<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>'  class='modal fade bs-example-modal-lg in' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='color-line'></div>
			
				<div id='profile_details_views<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>' class='modal-body no-padding'>
				
				</div>
			
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<div id='jd_details_view<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>'  class='modal fade bs-example-modal-lg in' tabindex='-1' role='dialog'  aria-hidden='true' data-backdrop="static">
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
			<div class='color-line'></div>
			
				<div id='jd_details_views<?php echo $position['position_id']; ?>_<?php echo $_REQUEST['assessor_id']; ?>_<?php echo $_REQUEST['assessment_id']; ?>' class='modal-body no-padding'>
				
				</div>
			
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
