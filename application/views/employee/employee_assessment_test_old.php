<style>
    .skin-option {
        position: fixed;
        text-align: center;
        right: -1px;
        padding: 10px;
        top: 80px;
        width: 150px;
        height: 133px;
        text-transform: uppercase;
        background-color: #ffffff;
        box-shadow: 0 1px 10px 0px rgba(0, 0, 0, 0.05), 10px 12px 7px 3px rgba(0, 0, 0, .1);
        border-radius: 4px 0 0 4px;
        z-index: 100;
    }
	.modal-lg {
		width: 1290px;
	}
	.chat-users, .chat-statistic {
		margin-left: -10px;
	}
	.modal-dialog {
		margin-top: 14px;
	}
	.modal-header {
		
		padding: 1px 10px;
	}
	.chat-users, .chat-discussion {
		height: 400px;
		overflow-y: auto;
	}
	.chat-discussion {
		padding: 16px 19px;
	}
	h4 {
		font-size: 20px;
		line-height: 30px;
		text-transform: capitalize;
	}
	.col-md-2 {
		width: 19%;
	}
	.countdownHolder{
		width:450px;
		margin:0 auto;
		font: 15px/1.5 'Open Sans Condensed',sans-serif;
		text-align:right;
		letter-spacing:-3px;
	}
	.position{
	display: inline-block;
	height: 1.6em;
	overflow: hidden;
	position: relative;
	width: 1.05em;
}

.digit{
	position:absolute;
	display:block;
	width:1em;
	background-color:#444;
	border-radius:0.2em;
	text-align:center;
	color:#fff;
	letter-spacing:-1px;
}

.digit.static{
	box-shadow:1px 1px 1px rgba(4, 4, 4, 0.35);
	
	background-image: linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
	background-image: -o-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
	background-image: -moz-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
	background-image: -webkit-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
	background-image: -ms-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
	
	background-image: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0.5, #3A3A3A),
		color-stop(0.5, #444444)
	);
}

/**
 * You can use these classes to hide parts
 * of the countdown that you don't need.
 */

.countDays{ /* display:none !important;*/ }
.countDiv0{ /* display:none !important;*/ }
.countHours{}
.countDiv1{}
.countMinutes{}
.countDiv2{}
.countSeconds{}


.countDiv{
	display:inline-block;
	width:16px;
	height:1.6em;
	position:relative;
}

.countDiv:before,
.countDiv:after{
	position:absolute;
	width:5px;
	height:5px;
	background-color:#444;
	border-radius:50%;
	left:50%;
	margin-left:-3px;
	top:0.5em;
	box-shadow:1px 1px 1px rgba(4, 4, 4, 0.5);
	content:'';
}

.countDiv:after{
	top:0.9em;
}
</style>
    <div class="content">
		<div class="row">
			<?php
			
			if(isset($_SESSION['test_msg'])){
			?>
			<div class="alert alert-success alert-dismissable">
				<i class="zmdi zmdi-check pr-15 pull-left"></i>
				<p class="pull-left"><?php echo $_SESSION['test_msg']; ?></p> 
				<div class="clearfix"></div>
			</div>
			<?php
			unset($_SESSION['test_msg']);
			} ?>
			<div class="col-lg-12">
			
			<div class="panel panel-default card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-details<?php echo $posdetails['position_id']; ?>"> Assessment Details</a></li>
					<li class=""><a data-toggle="tab" href="#tab-compentencies<?php echo $posdetails['position_id']; ?>"> Competency Profile</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-compentencies<?php echo $posdetails['position_id']; ?>" class="tab-pane">
						<div class="panel-body"><ol>
							<div class="table-responsive">
								<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
									<thead>
									<tr>
										<th>Competencies</th>
										<th>Scale</th>
										<th>Criticality</th>
									</tr>
									</thead>
									<tbody>
									<?php 
									foreach($competencies as $competency){														
										if($competency['position_id']==$posdetails['position_id']){
											echo "<td>".$competency['comp_def_name']." (".$competency['scale_name'].")</td><td>".$competency['scale_name']."</td><td>".$competency['comp_cri_name']."</td></tr>";
										}
									} ?>
									</tbody>
								</table>
							</div> </ol>
						</div>
					</div>
					
					<div id="tab-details<?php echo $posdetails['position_id']; ?>" class="tab-pane active">
						<div class="panel-body">
							<!--<div class="col-md-2">
								<div class="panel panel-inverse card-view">
									<div class="panel-body ">
										<a href="#" onclick="open_self_summary_sheet(<?php echo $_REQUEST['assessment_id']; ?>,<?php echo $_SESSION['emp_id']; ?>,<?php echo $_REQUEST['position_id']; ?>)" >
										<div class="text-center">
											<h4 class="m-b-xs">Self Assessment</h4>
											<div class="m">
												<i class="pe-7s-target fa-5x"></i>
											</div>
											
										</div>
										</a>
									</div>
								</div>
							</div>-->
						<div class="row"> 
						<?php
						foreach($ass_test as $ass_tests){
							if($ass_tests['assessment_type']!='INTERVIEW'){
							$test=($ass_tests['assessment_type']=='TEST')?"science":"";
							$case=($ass_tests['assessment_type']=='CASE_STUDY')?"global":"";
							$test_name=($ass_tests['assessment_type']=='TEST')?"Test":"";
							$case_name=($ass_tests['assessment_type']=='CASE_STUDY')?"Case Study":"";
							$inbasket_name=($ass_tests['assessment_type']=='INBASKET')?"Inbasket":"";
							$beh_name=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"Instruments":"";
							$inbasket=($ass_tests['assessment_type']=='INBASKET')?"airplay":"";
							$beh=($ass_tests['assessment_type']=='BEHAVORIAL_INSTRUMENT')?"medal":"";
							$test_button=($ass_tests['assessment_type']=='TEST')?"success":"";
							$case_button=($ass_tests['assessment_type']=='CASE_STUDY')?"success":"";
							$inbasket_button=($ass_tests['assessment_type']=='INBASKET')?"success":"";
						?>
							<div class="col-md-2">
								<div class="panel panel-inverse card-view">
									<div class="panel-body ">
										<a href="#" onclick="open_ass_test(<?php echo $ass_tests['assess_test_id'];?>);" >
										<div class="text-center">
											<h4 class="m-b-xs"><?php echo $test_name;?><?php echo $case_name;?><?php echo $inbasket_name;?><?php echo $beh_name;?></h4>
											<div class="m">
												<i class="pe-7s-<?php echo $test; ?><?php echo $case; ?><?php echo $inbasket; ?><?php echo $beh; ?> fa-5x"></i>
											</div>
											
										</div>
										</a>
									</div>
								</div>
							</div>
							<?php 
							} 
						}
						?>
						</div>
						
						
						
							<div id="open_assessment"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

    </div>
	
	
	
	
	
	
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="false"  data-keyboard="false" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="color-line"></div>
			<div id="testdiv">
			<!--<div class="modal-header">
				<h6 class="modal-title">Test</h6>
			</div>
			<div class="modal-body">
				

			</div>-->
			</div>
			
		</div>
	</div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Instructions for doing Inbasket</h4>
			</div>
			<div class="modal-body">
				<p>
				<ol>
					<li class="mb-10">Read the Inbasket/Intrays on the Left hand side of your screen.  </li>
					<li class="mb-10">The Intrays have been arranged in a Random order</li> 
					<li class="mb-10">Once you have gone through all the Intrays, you will decide on a priority in which the Intrays have to be addressed.</li>
					<li class="mb-10">Once you have decided on the priority, on the Right Hand side, move the Intrays, in the order in which you want them, by moving them Up and/or Down (by clicking on the intray and moving it). Say, your first priority is actually Intray 3, then click on Intray 3, and move it to the topmost (# 1) position</li>
					<li class="mb-10">After you have finalized the order, fill in the action the action you would like to take on this, by clicking on Select.  You may want to either directly take an action on this, or you may want to delegate this intray or just hold on to it, for the time being.</li>  
					<li class="mb-10">Once you have choosen, please fill the details of the action in the Description Box.  Examples include, details of a mail that you want to write, a call that you want to make or instruction to a subordinate.  </li>
					<li class="mb-10">Once you have completed all the Intrays, click on Submit. </li>
					<li class="mb-10">The total time taken by you will be calculated based on the time you click Submit</li>
				</ol>

				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="close_window">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo BASE_URL; ?>/public/js/employee/jquery.countdownTimer.min.js"></script>	