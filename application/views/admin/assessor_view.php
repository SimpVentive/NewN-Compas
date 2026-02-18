<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['assessor_name']; ?> <small>(<?php echo @$compdetails['assesstype']; ?>)</small></h3>
					<div class="col-lg-12">
						<p>Email: <?php echo @$compdetails['assessor_email']; ?></p>
						<p>Mobile: <?php echo @$compdetails['assessor_mobile']; ?></p>
						<p>Experience: <?php echo @$compdetails['assessor_experience']; ?> Yrs</p>
						<?php if(!empty($compdetails['assessor_photo'])){ ?><p>Link: <a href="<?php echo BASE_URL."/public/uploads/assessor/".$compdetails['assessor_id']."/".$compdetails['assessor_photo']; ?>" target="_blank" >Click Here</a></p><?php } ?>
						<p>Status: <?php echo @$compdetails['assessstatus']; ?></p>
                        <p><?php echo @$compdetails['assessor_brief']; ?></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-keyind"> Competencies</a></li>
					<li class=""><a data-toggle="tab" href="#tab-keycov">Instruments</a></li>
				</ul>
				<div class="tab-content ">
					<div id="tab-keyind" class="tab-pane active">
						<div class="panel-body">
							<?php $tmp=""; foreach($competencies as $comp){
								if($tmp!=$comp['competencies_name']){ echo !empty($tmp)?"</ul><strong>".$comp['competencies_name']."</strong><ul>":"<strong>".$comp['competencies_name']."</strong><ul>";  $tmp=$comp['competencies_name']; }
								echo "<li>".$comp['level_name']."</li>";
							} ?>
						</div>
					</div>
					<div id="tab-keycov" class="tab-pane">
						<div class="panel-body">
							<ul>
							<?php foreach($instruments as $question){
								echo "<li>".$question['instrumentname']."</li>";
							} ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessor_master?id=<?php echo $compdetails['assessor_id']."&hash=".md5(SECRET.$compdetails['assessor_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessor_master')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('assessor_search')">Cancel</button>
			</div>
		</div>
	</div>
</div>