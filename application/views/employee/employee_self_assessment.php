<div class="body-section">
	<div class="assessment-scroll-block custom-scroll">
		<div class="assessment-section">

			<div class="assessment-head">
				<div class="d-flex align-items-center justify-content-between">
					<div class="assessment-head-title"><?php echo $ass_details['assessment_name']; ?></div>
				</div>
				<ul class="assessment-info-list">
					<li class="assessment-item">
						<i class="icon material-icons">assignment_turned_in</i>
						<span class="align-middle"><?php echo $ass_type=$_REQUEST['ass_type']=='FS'?'IDP Process':'';?></span>
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
				<p class="assessment-content"><?php echo $ass_details['assessment_desc']; ?></p>

				<div class="space-20"></div>

				<div class="row">
					<div class="col-6">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">list_alt</i>
							</div>
							<div class="info">
								<div class="name">IDP Rules</div>
								<p class="content">The Individual Development Plan is to enable you reach your full potential.  ... <a href="javascript:;" data-toggle="modal" data-target="#ass-rules-modal">Read more</a></p>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="assessment-info">
							<div class="icon">
								<i class="icon material-icons">assignment</i>
							</div>
							<div class="info">
								<div class="name">IDP Report</div>
								<p class="content">At the end of the self-assessment process, you will generate a comprehensive ... <a href="javascript:;" data-toggle="modal" data-target="#ass-report-modal">Read more</a></p>
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
										<div class="name"><?php echo $ass_details['assessment_name']; ?></div>
										<p class="content">Total Tasks: 4</p>
									</div>
									<?php 
									if($jour_details['status']=='C'){
									?>
									<a href="#" class="btn btn-primary">Completed</a>
									<?php
									}
									else{
									?>
									<a href="<?php echo BASE_URL; ?>/employee/self_ass_summary_details?id=1&status=self&jid=<?php echo $_REQUEST['jid'];?>&ass_type=<?php echo $_REQUEST['ass_type'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&emp_id=<?php echo $_REQUEST['emp_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>" class="btn btn-primary">Start</a>
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
				<h5 class="modal-title flex">IDP Rules</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
					<p>The Individual Development Plan is to enable you reach your full potential.  The self-assessment on the competencies, will help identify the areas where you want to focus with regards your development and those which you want to leverage for your growth.</p>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade case-modal" id="ass-report-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">IDP Report</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			<div class="modal-body" >
				
					<p>At the end of the self-assessment process, you will generate a comprehensive IDP Report, which will help you to plan, monitor and review your growth in terms of the competencies and other identified areas  </p>
				
			</div>
		</div>
	</div>
</div>