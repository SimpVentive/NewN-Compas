<div class="body-section">
	<div class="assessment-scroll-block custom-scroll">
		<div class="assessment-section">

			<div class="assessment-head">
				<div class="d-flex align-items-center justify-content-between">
					<div class="assessment-head-title"><?php echo $ass_details['position_validation_name']; ?></div>
					<a href="javascript:;" class="assessment-profile-btn" data-toggle="modal" data-target="#competency-profile-modal-<?php echo $_REQUEST['position_id']; ?>" onclick="open_comp_details(<?php echo $_REQUEST['position_id']; ?>);">View Profile</a>
				</div>
				<div class="modal fade case-modal" id="competency-profile-modal-<?php echo $_REQUEST['position_id']; ?>" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document" style="max-width:1300px">
						<div class="modal-content" style="width:1300px">
							<div class="modal-header">
								<h5 class="modal-title flex">Complete JD for this Assessment</h5>
								<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
									<i class="material-icons">close</i> Close
								</a>
							</div>
							<div class="case-info">
								
							</div>
							
							<div class="modal-body" >
								<div class='custom-scroll'>
									<div id="comp_details_<?php echo $_REQUEST['position_id']; ?>"></div>
								
								</div>
							</div>
						</div>
					</div>
				</div>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons">assignment_turned_in</i>
						<span class="align-middle">Position Validation</span>
						<i class="info-icon material-icons">info</i>
					</li>
					<li class="assessment-item">
						<span>Received: <?php echo date('dS F Y',strtotime($jour_details['created_date']));?></span>
						<a href="javascript:;" class="add-new">Initiated</a>
					</li>
				</ul>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons bg-none">business_center</i>
						<span>Position: <?php echo $posdetails['position_name']; ?></span>
					</li>
					<li class="assessment-item">
						<i class="icon material-icons bg-none">date_range</i>
						<span>Start Date: <?php echo date('dS F Y',strtotime($ass_details['start_date']));?></span>
					</li>
					<li class="assessment-item">
						<i class="icon material-icons bg-none">date_range</i>
						<span>End Date: <?php echo date('dS F Y',strtotime($ass_details['end_date']));?></span>
					</li>
				</ul>
			</div>

			<div class="assessment-body">
				<div class="space-40"></div>
				<div class="assessment-text">Description</div>
				<p class="assessment-content"><?php echo $ass_details['position_validation_desc']; ?></p>

				<div class="space-20"></div>

				<div class="row">
					<div class="col-6">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">list_alt</i>
							</div>
							<div class="info">
								<div class="name">Validation Rules</div>
								<p class="content">You would have to provide inputs on your job based on what you do currently ... <a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">assignment</i>
							</div>
							<div class="info">
								<div class="name">Validation Reports</div>
								<p class="content">The system will aggregate the requirements across multiple incumbents ... <a href="javascript:;" data-toggle="modal" data-target="#ass-report-modal">Read more</a></p>
							</div>
						</div>
					</div>
				</div>

				<div class="space-60"></div>

				<div class="row">
					<div class="col-12">
						<div class="assessment-info assessment-box">
							<div class="icon">
								<i class="icon material-icons">supervised_user_circle</i>
							</div>
							<div class="info">
								<div class="d-flex align-items-center justify-content-between">
									<div>
										<div class="name"><?php echo $ass_details['position_validation_name']; ?></div>
										<p class="content">Total Tasks: 3</p>
									</div>
									<?php 
									if($jour_details['status']=='C'){
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
									else{
									?>
									<a href="<?php echo BASE_URL; ?>/employee/employee_validation_details?id=1&status=profile&jid=<?php echo $_REQUEST['jid']; ?>&val_id=<?php echo $_REQUEST['val_id']; ?>&position_id=<?php echo $_REQUEST['position_id']; ?>&val_pos_id=<?php echo $_REQUEST['val_pos_id']; ?>" class="btn btn-primary">Start</a>
									<?php } ?>
								</div>
							</div>
							<div class="progress-bar">
								<span class="progress" style="width: 70%;"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade case-modal" id="ass-rules-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Validation Rules</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
					<p>You would have to provide inputs on your job based on what you do currently do, how it is being measured, and what are the competencies required for doing the job  </p>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-report-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Validation Reports</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
					<p>The system will aggregate the requirements across multiple incumbents (in a given position) and will help the organization (HR) define your role, the KRAs and the competencies required.  </p>
				
			</div>
		</div>
	</div>
</div>
