<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<h5>Professional Profile</h5>
				</div>
				<div class="panel-body">
					<div class="col-lg-2">
					<?php 
					$pic_path=BASE_URL.'/public/images/male_user.jpg';if(isset($assessordetails['assessor_id'])){ $pic_path=(!empty($assessordetails['assessor_photo']))?BASE_URL.'/public/uploads/assessor_pic/'.trim($assessordetails['assessor_id']).'/'.trim($assessordetails['assessor_photo']):$pic_path; } ?>
					<img alt="logo" class="img-square m-b m-t-md" src="<?php echo $pic_path; ?>">
					</div>
					<div class="col-lg-3">
					<h5><?php echo $assessordetails['assessor_name']; ?></h5>
					<p><i class="fa fa-map-marker"></i> Email ID: <?php echo $assessordetails['assessor_email']; ?></p>
					<p><i class="fa fa-phone"></i> Mobile: <?php echo $assessordetails['assessor_mobile']; ?></p>
					<p><i class="fa fa-flag"></i> Status : <?php echo $assessordetails['assessstatus']; ?></p>
					</div>
					<div class="col-lg-3">
						<p><i class="fa fa-calendar"></i> Linkedin Profile: <?php echo @$assessordetails['assessor_linkedin_profile']; ?></p>
						<p><i class="fa fa-user"></i> Experience: <?php echo @$assessordetails['assessor_experience']; ?> Years</p>
					</div>
				</div>
				
				<div class="panel-body">
					<dl>
						<dt>Additional Info</dt>
						<dd><?php echo @$assessordetails['assessor_brief']; ?></dd>
					</dl>
				</div>

			</div>
		</div>
	</div>
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-1">Competencies</a></li>
					<li class=""><a data-toggle="tab" href="#tab-2">Instruments</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active">
						<div class="panel-body">
							<?php
							$tmp="";
							if(count($competencies)>0){
								foreach($competencies as $comp){
									if($tmp!=$comp['competencies_name']){ echo !empty($tmp)?"</ul><strong>".$comp['competencies_name']."</strong><ul>":"<strong>".$comp['competencies_name']."</strong><ul>";  $tmp=$comp['competencies_name']; }
									echo "<li>".$comp['level_name']."</li>";
								}
							}
							else{
							?>
							<div class="list-group ">
								<a class="list-group-item" href="#">
									<h5 class="list-group-item-heading">Alert!</h5>
									<p class="list-group-item-text">No Competencies Information has been added.</p>
								</a>
							</div>
							<?php
							}
							?>
						</div>						
					</div>
					<div id="tab-2" class="tab-pane">
						<div class="panel-body">
							<?php if(count($instruments)>0){ ?>
							<ol>
								<?php
								foreach($instruments as $question){
									echo "<li>".$question['instrumentname']."</li>";
								}
								?>
							</ol>
							<?php }
							else{ ?>
							<div class="list-group">
								<a class="list-group-item" href="#">
								<h5 class="list-group-item-heading">Alert!</h5>
								<p class="list-group-item-text">No Instruments has been added.</p>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>