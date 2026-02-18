<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Grade Name</th>
								<th><?php  echo $gradedetails['grade_name'];?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Status</th>
								<th><?php echo $gradedetails['val_status'];?>&nbsp;</th>
							</tr>
						</thead>
					</table>
					<div class="space-2"></div>
			<div id="accordion" class="accordion-style1 panel-group">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h6 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;Sub Grade Details
							</a>
						</h6>
					</div>
					<div class="panel-collapse" id="collapseTwo">
						<div class="panel-body">
							<input type="hidden" id="sub_grade_id" name="sub_grade_id" value="">
							<table id="sub_grade_table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Sub Grade Name</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$gradid=(isset($_REQUEST['grade_id']))?$_REQUEST['grade_id']:'';
									$subgrd=UlsSubGrades::subGrades($gradid);
									if(count($subgrd)>0){
										foreach($subgrd as $kei=>$subgd){?>
											<tr id='subgrd<?php echo $kei;?>'>
												<td>
													<label>
												<?php 	foreach($subgrades as $subgrade){
															echo ($subgd['sub_grade_name']==$subgrade['subgrade_id'])?$subgrade['subgrade_name']:'';
														} ?>
													</label>
												</td>
												<td>
													<label>
												<?php 	foreach($posstatusss as $pocstatus){
															echo ($subgd['grade_status']==$pocstatus['code'])?$pocstatus['name']:'';
														} ?>
													</label>
												</td>
											</tr>
								<?php 	}
									}?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="accordion" class="accordion-style1 panel-group">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h6 class="panel-title">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
								<i class="ace-icon fa fa-angle-down bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
								&nbsp;Training Days Details
							</a>
						</h6>
					</div>
					<div class="panel-collapse" id="collapseOne">
						<div class="panel-body">
							<input type="hidden" id="grade_year_id" name="grade_year_id" value="">
							<table id="training_table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Training Year (from)</th>
										<th>Training Year (to)</th>
										<th>Category</th>
										<th>Training Days</th>
									</tr>
								</thead>
								<tbody>
									<?php $gradeyeardetails=UlsGradeYear::grade_details($_REQUEST['grade_id']);
									$rowcount=0;
									foreach($gradeyeardetails as $key=>$gradedetailss){
										if($key<>0){
											$k=$key;
											$rowcount=$rowcount.",".$k;
										}
									?>									
									<tr>
										<td>
											<label><?php echo "01-".$gradedetailss->from_month."-".$gradedetailss->from_year."";?></label>
										</td>
										<td>
											<label><?php echo "01-".$gradedetailss->to_month."-".$gradedetailss->to_year."";?></label>
										</td>
										<td>
											<label>
												<?php echo $gradedetailss->UlsCategory['name'];?>
											</label>
										</td>
										<td>
											<label><?php echo $gradedetailss->training_days;?></label>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						
						<div class="col-sm-offset-4">
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('grade_update?grade_id=<?php echo $gradedetails['grade_id']."&hash=".md5(SECRET.$gradedetails['grade_id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('grades')">Create</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('grade_search')">Cancel</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
