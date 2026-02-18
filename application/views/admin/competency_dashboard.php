<style>
.col-lg-2 {
    width: 20%;
}
.card-view.panel > .panel-heading {
    border: none;
    color: inherit;
    border-radius: 0;
    margin: -15px -15px 0;
    padding: 10px 15px;
}
.table-fixed tbody {
height: 600px;
overflow-y: auto;
width: 100%;
}
.table-fixed thead,
.table-fixed tbody,
.table-fixed tr,
.table-fixed td,
.table-fixed th {
display: block;
}
.table-fixed tr:after {
content: "";
display: block;
visibility: hidden;
clear: both;
}
.table-fixed tbody td,
.table-fixed thead > tr > th {
float: left;
}
.col-xs-1 {
    width: 9.333333%;
}
.col-xs-4 {
    width: 30%;
}
</style>
<div class="row">
	
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15" ><span class="">Over All Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/assessment_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Assessment Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/hr_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">HR Dashboard</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/assessor_dashboard">
		<div class="panel panel-default card-view pa-0">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15"><span class="">Assessor Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
	<div class="col-lg-2 col-md-6 col-sm-12 col-xs-12">
		<a href="<?php echo BASE_URL; ?>/admin/competency_dashboard">
		
		<div class="panel panel-default card-view pa-0 <?php if(strstr($_SERVER['REQUEST_URI'],'competency_dashboard')){ echo "bg-blue";}?>">
			<div class="panel-wrapper collapse in">
				<div class="panel-body pa-0">
					<div class="sm-data-box">
						<div class="container-fluid">
							<div class="row">
								<div class="col-xs-10 text-center pl-0 pr-0 data-wrap-left">
									<span class="txt-dark block counter font-15 <?php if(strstr($_SERVER['REQUEST_URI'],'competency_dashboard')){ echo "txt-light";}?>"><span class="">Competency Dashbaord</span></span>
								</div>
								<div class="col-xs-2 text-center  pl-0 pr-0 data-wrap-right">
									<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		</a>
	</div>
</div>
	

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-heading">
				<div class="pull-left">
					<h6 class="panel-title txt-dark">Competency Dashboard</h6>
				</div>
				
				<div class="clearfix"></div>
			</div>
			
		</div>	
	
	<div class="panel panel-primary card-view">
		<div class="panel-heading">
			<div class="pull-left">
				<h6 class="panel-title txt-light">Total Competencies</h6>
			</div>
			<div class="pull-right">
				<span class="label label-info capitalize-font inline-block ml-10"><h5 class="txt-light">Count : <?php echo $compcount["comp_count"]; ?></h5></span>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-wrapper collapse in">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-bordered mb-0 table-fixed " style="width:100%">
						<thead>
							<tr>
								<th class="col-xs-4">Competency Name</th>
								<th class="col-xs-2">Level Name</th>
								<th class="col-xs-3">Assessment Mathods </th>
								<th class="col-xs-1">Position Mapping</th>
								<th class="col-xs-1"># of Emp Mapped</th>
								<th class="col-xs-1">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						foreach($comp_details as $comp_detail){
							$poscount=UlsAssessmentCompetencies::get_competencies_count_pos($comp_detail['comp_def_id'],$comp_detail['scale_id']);
							$empcount=UlsAssessmentEmployees::get_count_pos($poscount['pos_ids']);
							$testcount=UlsAssessmentTestQuestions::get_count_test($comp_detail['comp_def_id'],$comp_detail['scale_id'],$poscount['pos_ids']);
							$inbasketcount=UlsAssessmentTest::get_count_inbasket($comp_detail['comp_def_id'],$comp_detail['scale_id'],$poscount['pos_ids']);
							$casecount=UlsAssessmentTest::get_count_casestudy($comp_detail['comp_def_id'],$comp_detail['scale_id'],$poscount['pos_ids']);
						?>
							<tr>
								<td class="col-xs-4"><?php echo $comp_detail['comp_def_name']; ?></td>
								<td class="col-xs-2"><?php echo $comp_detail['scale_name']; ?></td>
								<td class="col-xs-3">
									<span class="label label-info"><a href="#" class="txt-light"><u>Test : <?php echo count($testcount); ?></u></a></span>
									<span class="label label-primary"><a href="#" class="txt-light"><u>Inbasket # of intrays : <?php echo count($inbasketcount); ?></u></a></span>
									<span class="label label-warning"><a href="#" class="txt-light"><u>Case Study : <?php echo count($casecount); ?></u></a></span>
								</td>
								<td class="col-xs-1"><span class="label label-info"><a onclick="getasesspos(<?php echo $comp_detail['comp_def_id']; ?>,<?php echo $comp_detail['scale_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg" class="txt-light"><u><?php echo $poscount['pos_count']; ?></u></a></span></td>
								
								<td class="col-xs-1"><span class="label label-success"><a onclick="getasessemp(<?php echo $comp_detail['comp_def_id']; ?>,<?php echo $comp_detail['scale_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg"  class="txt-light"><u><?php echo $empcount['emp_count']; ?></u></a></span></td>
								<td class="col-xs-1"><span class="label label-danger"><a onclick="getasessanalysis(<?php echo $comp_detail['comp_def_id']; ?>,<?php echo $comp_detail['scale_id']; ?>);" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg" class="txt-light"><u>View</u></a></span></td>
							</tr>
						<?php } ?>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>		
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myLargeModalLabel">Positions Details</h5>
			</div>
			<div class="modal-body">
				<h5 class="mb-15" id="followdes">Following are the Positions</h5>
				<div id="txtHint" style="margin: 15px;">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger text-left" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>



<div id="myModal_comp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5 class="modal-title" id="myModalLabel">Competency Analysis</h5>
			</div>
			<div class="modal-body">
				<h6 class="mb-15">Competency Name</h6>
				<hr class="light-grey-hr row mt-10 mb-10">
				<div>
					<span class="pull-left inline-block capitalize-font txt-dark">
						Average Assessed Value
					</span>
					<span class="label label-warning pull-right">50%</span>
					<div class="clearfix"></div>
					<hr class="light-grey-hr row mt-10 mb-10">
					<span class="pull-left inline-block capitalize-font txt-dark">
						Top Performers
					</span>
					<span class="label label-danger pull-right">10%</span>
					<div class="clearfix"></div>
					<hr class="light-grey-hr row mt-10 mb-10">
					<span class="pull-left inline-block capitalize-font txt-dark">
						MCQ Analysis - Correct
					</span>
					<span class="label label-success pull-right">30%</span>
					<div class="clearfix"></div>
					<hr class="light-grey-hr row mt-10 mb-10">
					<span class="pull-left inline-block capitalize-font txt-dark">
						MCQ Analysis - Wrong
					</span>
					<span class="label label-primary pull-right">10%</span>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>