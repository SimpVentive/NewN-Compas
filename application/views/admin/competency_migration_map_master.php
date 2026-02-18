
<div class="small-header">
    <div class="panel panel-inverse card-view">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li>
                        <span>Competency Masters</span>
                    </li>
                    <li class="active">
                        <span>Category Master</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Category Master 
            </h2>
            <small>Enter all the details related to Category .</small>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
		<div class="col-lg-4">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<div class="dd" id="nestable">
						<ol class="dd-list">
							
							<li class="dd-item" data-id="1">
								<div class="dd-handle">Competency Definition</div>
								<ol class="dd-list">
									<li class="dd-item" data-id="2">
										<div class="dd-handle"><a href="competency_master.html"> Definition</a></div>
										<ol class="dd-list">
											<li class="dd-item" data-id="4">
												<div class="dd-handle"><a href="competency_level_master.html">Level 1</a></div>
												<ol class="dd-list">
													<li class="dd-item" data-id="5">
														<div class="dd-handle"><a href="competency_question_master.html">Questions</a></div>
													</li>
													<li class="dd-item" data-id="6">
														<div class="h-bg-green dd-handle"><a href="competency_migration_map_master.html">Migration Maps</a></div>
													</li>
													<li class="dd-item" data-id="6">
														<div class="dd-handle"><a href="competency_assessment_method_master.html">Assessment Method</a></div>
													</li>
												</ol>
											</li>
											<li class="dd-item" data-id="7">
												<div class="dd-handle">Level 2</div>
												<ol class="dd-list">
													<li class="dd-item" data-id="8">
														<div class="dd-handle">Questions</div>
													</li>
													<li class="dd-item" data-id="9">
														<div class="dd-handle">Migration Maps</div>
													</li>
													<li class="dd-item" data-id="10">
														<div class="dd-handle">Assessment Method</div>
													</li>
												</ol>
											</li>
											<li class="dd-item" data-id="11">
												<div class="dd-handle">Level 3</div>
												<ol class="dd-list">
													<li class="dd-item" data-id="12">
														<div class="dd-handle">Questions</div>
													</li>
													<li class="dd-item" data-id="13">
														<div class="dd-handle">Migration Maps</div>
													</li>
													<li class="dd-item" data-id="14">
														<div class="dd-handle">Assessment Method</div>
													</li>
												</ol>
											</li>
											<li class="dd-item" data-id="15">
												<div class="dd-handle">Level 4</div>
												<ol class="dd-list">
													<li class="dd-item" data-id="16">
														<div class="dd-handle">Questions</div>
													</li>
													<li class="dd-item" data-id="17">
														<div class="dd-handle">Migration Maps</div>
													</li>
													<li class="dd-item" data-id="18">
														<div class="dd-handle">Assessment Method</div>
													</li>
												</ol>
											</li>
										</ol>
									</li>
									
								</ol>
							</li>
							
						</ol>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-inverse card-view">
				
				<div class="panel-body">
					<h5 class="m-t-none m-b-sm">Migration Map - Level 1 to Level 2</h5>
					<div class="hr-line-dashed"></div>
					<form method="get" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-1 control-label"></label>
							<div class="col-sm-10">
							
								<label class="checkbox-inline"> <input value="option1" id="inlineCheckbox1" type="checkbox"> External Training</label> 
								<label class="checkbox-inline">
								<input value="option2" id="inlineCheckbox2" type="checkbox"> OJT </label> 
								<label class="checkbox-inline">
								<input value="option3" id="inlineCheckbox3" type="checkbox"> Projects </label>
								<label class="checkbox-inline">
								<input value="option3" id="inlineCheckbox3" type="checkbox"> Mentoring </label>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<h5 class="m-t-none m-b-sm">Others</h5>
						<div class="hr-line-dashed"></div>
						<div class="panel-heading hbuilt">
							Add Others
							<div class="pull-right">
								<a class="btn btn-xs btn-success">&nbsp <i class="fa fa-plus-circle"></i> Add &nbsp</a>
								<a class="btn btn-danger2 btn-xs">&nbsp <i class="fa fa-trash-o"></i>  Delete &nbsp</a>
							</div>
						</div>
						<div class="table-responsive">
							<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>Select</th>
									<th>Others</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td><label><input type="checkbox" value=""></label></td>
									<td><input type="text" value="" id="" class="form-control" name="" name="country" placeholder="Others"></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-offset-8">
								<button class="btn btn-default" type="submit">Cancel</button>
								<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
