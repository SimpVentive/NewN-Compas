<div class='modal-header'>
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	<h4 class='modal-title'>Job Description of <?php echo $posdetails['position_name']; ?> </h4>
</div>
<div class='modal-body'>
	<div class="row">
		
		<div class="panel-body">		
			<div class="row">
			<div class="col-lg-12">
				<div class="pull-right">
				<?php $hash=SECRET.$posdetails['position_id']; ?>
				<a class="btn btn-primary " href="<?php echo BASE_URL."/admin/positionpdf?posid=".$posdetails['position_id']."&hash=".md5(@$hash);?>" target="_blank"><i class="fa fa-upload"></i> <span class="bold">Position JD PDF</span></a>
			</div>
				<h6>Role Profile</h6>
				<p>
					<strong>Reports to</strong>:<?php echo @$posdetails['reportsto']; ?>
				</p>
				<p>
					<strong>Reportees</strong>:<?php echo @$posdetails['reportees_name']; ?>
				</p>
				<p>
					<strong>Function</strong>:<?php echo @$posdetails['position_org_name']; ?>
				</p>
				<p>
					<strong>Location</strong>:<?php echo @$posdetails['location_name']; ?>
				</p>
			</div>
			
			<div class="col-lg-12">
				<h6>Purpose</h6>
				<p>
					<?php echo @$posdetails['position_desc']; ?>
				</p>
			</div>
			
			<div class="col-lg-12">
				<h6>Accountabilities</h6>
				<?php echo @$posdetails['accountablities']; ?>
			</div>


			
			<div class="col-lg-12">
				<h6>Position Requirements</h6>
				<p>
					<strong>Education Background</strong>:<?php echo @$posdetails['education']; ?>
				</p>
				<p>
					<strong>Experience</strong>:<?php echo @$posdetails['experience']; ?>
				</p>
				<p>
					<strong>Industry Specific Experience</strong>:<?php echo @$posdetails['specific_experience']; ?>
				</p>
			</div>
			<?php if(!empty($posdetails['other_requirement'])){ ?>
			
			<div class="col-lg-12">
				<h6>Other Requirements</h6>
				<p>
					<?php echo @$posdetails['other_requirement']; ?>
				</p>
			</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>