<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">	
                <div class="panel-body">
					<h6 class="txt-dark capitalize-font">Creation Questionnaire</h6>
					<p>Process Name: <?php echo @$compdetails['ques_name']; ?></p>
					<p>Short Description: <?php echo @$compdetails['ques_description']; ?></p>
					<p>Start Date: <?php echo date('d-m-Y',strtotime($compdetails['start_date'])); ?></p>
					<p>End Date: <?php echo date('d-m-Y',strtotime($compdetails['end_date'])); ?></p>
					<p>Position Name: <?php echo @$compdetails['position_name']; ?></p>
					<p>Rating Scale: <?php echo @$compdetails['rating_name']; ?></p>
					<p>No of Elements Limit: <?php echo @$compdetails['no_elements']; ?></p>
					<p>Status: <?php echo @$compdetails['questatus']; ?></p>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<h6 class="txt-dark capitalize-font">Competencies</h6>
					<div class="table-responsive">
						<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
							<thead>
								<tr>
									<th style="width:5%;">S.No</th>
									<th style="width:35%;">Competency Name</th>
									<th style="width:20%;">Competency Scale</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach($positiondetails as $key=>$positiondetail){
							?>
							<tr>
								<td><?php echo ($key+1); ?></td>
								<td><?php echo $positiondetail['comp_def_name']; ?></td>
								<td><?php echo $positiondetail['scale_name']; ?></td>
							</tr>
							<?php
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<h6 class="txt-dark capitalize-font">Selection of Elements</h6>
					<div class="table-responsive">
						<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
							<thead>
								<tr>
									<th style="width:5%;">Select</th>
									<th style="width:60;">Elements</th>
									<th style="width:20%;">Competency Name</th>
									<th style="width:15%;">Competency Scale</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach($edit_elements as $key=>$edit_element){
							?>
							<tr>
								<td><?php echo ($key+1); ?></td>
								<td><?php echo $edit_element['element_name']; ?></td>
								<td><?php echo $edit_element['comp_def_name']; ?></td>
								<td><?php echo $edit_element['scale_name']; ?></td>
							</tr>
							<?php
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<h6 class="txt-dark capitalize-font">Final Questionnaire</h6>
					<div class="table-responsive">
						<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="competencyposTab" name="competencyposTab">
							<thead>
								<tr>
									<th style="width:5%;">S.No</th>
									<th style="width:95%;">Elements</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach($edit_elements as $key=>$edit_element){
							?>
							<tr>
								<td><?php echo ($key+1); ?></td>
								<td><?php echo $edit_element['element_id_edit']; ?></td>
							</tr>
							<?php
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('questionnaire_exercises_master?id=<?php echo $compdetails['ques_id']."&hash=".md5(SECRET.$compdetails['ques_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('questionnaire_exercises_master')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('questionnaire_exercises_master_search')">Cancel</button>
			</div>
		</div>
	</div>
</div>