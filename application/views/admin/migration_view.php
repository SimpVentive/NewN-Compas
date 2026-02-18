<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">			
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Migration Type</th>
								<th><?php  echo $migmaster['migrationtype'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Type</th>
								<th><?php  echo $migmaster['type'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Migration Name</th>
								<th><?php  echo $migmaster['program_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Migration Objective</th>
								<th><?php  echo $migmaster['program_objective'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Migration URl</th>
								<th><?php  echo $migmaster['program_link'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $migmaster['status_val'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>					
					<div class="hr-line-dashed"></div>
					<h3 class="lighter block green">Comptency Details</h3>
					<div class="table-responsive">
						<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1" id="thetable">
							<thead>
							<tr>
								<th>Competency Name</th>
								<th>Scale Name</th>
								<th>Status</th>
							</tr>
							</thead>
							<tbody>
								<?php 
									if(count($migcompetencies)>0){
										foreach($migcompetencies as $kei=>$migcompetencie){?>
											<tr id='subgrd<?php echo $kei;?>'>
												<td>
													<label><?php echo $migcompetencie['comp_def_name']; ?></label>
												</td>
												<td>
													<label><?php echo $migcompetencie['scale_name']; ?></label>
												</td>
												<td>
													<label><?php echo $migcompetencie['status_val']; ?></label>
												</td>
											</tr>
								<?php 	}
									}?>
							</tbody>
						</table>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('migration_master?course_id=<?php echo $migmaster['course_id']."&hash=".md5(SECRET.$migmaster['course_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('migration_master')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('migration_master_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
