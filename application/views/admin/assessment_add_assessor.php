<div class="small-header">
    <div class="panel panel-inverse card-view">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                     <li>
                        <span>Assessment Manage</span>
                    </li>
                    <li class="active">
                        <span>Assessment Manage Creation</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Assessment Manage Creation
            </h2>
            <small>Enter all the details related to Assessment Manage.</small>
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
								<div class="dd-handle">Assessment Definition</div>
								<ol class="dd-list">
									<li class="dd-item" data-id="2">
										<div class="dd-handle"><a href="assessment_creation.html"> Definition</a></div>
										<ol class="dd-list">
											<li class="dd-item" data-id="2">
												<div class="h-bg-blue dd-handle"><a href="assessment_position_creation.html"> Position</a></div>
												<ol class="dd-list">
													<li class="dd-item" data-id="4">
														<div class="dd-handle"><a href="assessment_positions.html">Position 1</a></div>
														<ol class="dd-list">
															<li class="dd-item" data-id="5">
																<div class="dd-handle"><a href="assessment_add_employees.html">Add Employees</a></div>
															</li>
															<li class="dd-item" data-id="6">
																<div class="h-bg-green dd-handle"><a href="assessment_add_assessor.html">Add Assessors</a></div>
															</li>
															<li class="dd-item" data-id="6">
																<div class="dd-handle">Methods</div>
																<ol class="dd-list">
																	<li class="dd-item" data-id="5">
																		<div class="dd-handle"><a href="assessment_test.html">Tests</a></div>
																	</li>
																	<li class="dd-item" data-id="6">
																		<div class="dd-handle"><a href="assessment_case_study.html">Case Study</a></div>
																	</li>
																	<li class="dd-item" data-id="6">
																		<div class="dd-handle"><a href="assessment_interview.html">Interview</a></div>
																		
																	</li>
																	<li class="dd-item" data-id="6">
																		<div class="dd-handle"><a href="assessment_inbasket.html">In basket Excercies</a></div>
																		
																	</li>
																</ol>
															</li>
														</ol>
													</li>
													<li class="dd-item" data-id="7">
														<div class="dd-handle">Position 2</div>
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
														<div class="dd-handle">Position 3</div>
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
														<div class="dd-handle">Position 4</div>
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
							</li>
							
						</ol>
					</div>
					
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-inverse card-view">
				
				<div class="panel-body">
					<h5 class="m-t-none m-b-sm">Position Name: Position 1</h5>
					<div class="hr-line-dashed"></div>
					<form method="get" class="form-horizontal">
						<div class="panel-heading hbuilt">
							Add Assessors
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
									<th>Assessor Name</th>
									<th>Level Name</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td><label><input type="checkbox" value=""></label></td>
									<td>
										<select class="form-control m-b" name="account">
											<option>Assessor Name</option>
											<option>option 1</option>
											<option>option 2</option>
											<option>option 3</option>
											<option>option 4</option>
										</select>
									</td>
									<td>
										<label class="checkbox-inline"> 
											<input type="checkbox" value="option1" id="inlineCheckbox1" checked>Test
										</label> 
										<label class="checkbox-inline">
											<input type="checkbox" value="option2" id="inlineCheckbox2" checked>Case study 
										</label> 
										<label class="checkbox-inline">
											<input type="checkbox" value="option3" id="inlineCheckbox3" checked>Interview 
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" value="option4" id="inlineCheckbox3" checked>In Basket
										</label>
									</td>
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
					<div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="color-line"></div>
                                <div class="modal-header">
                                    <h6 class="modal-title">Employee Details</h6>
                                </div>
                                <div class="modal-body">
									<div class="table-responsive">
										<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
											<thead>
											<tr>
												<th>Select</th>
												<th>Employee Code</th>
												<th>Employee name</th>
												<th>Department</th>
												<th>Position</th>
											</tr>
											</thead>
											<tbody>
												<tr>
													<td>
													<input type="checkbox" value="option1" id="inlineCheckbox1" >
													</td>
													<td>11844</td>
													<td>Ajay Ram Pandey</td>
													<td>Quality - Dep</td>
													<td>Position 1</td>
												</tr>
												<tr>
													<td>
													<input type="checkbox" value="option1" id="inlineCheckbox1" >
													</td>
													<td>11645</td>
													<td>Arup Kumar Sarkar</td>
													<td>Quality - Dep</td>
													<td>Position 1</td>
												</tr>
												<tr>
													<td>
													<input type="checkbox" value="option1" id="inlineCheckbox1" >
													</td>
													<td>11255</td>
													<td>Bimal Chandra Mohapatra</td>
													<td>Quality - Dep</td>
													<td>Position 1</td>
												</tr>
												<tr>
													<td>
													<input type="checkbox" value="option1" id="inlineCheckbox1" >
													</td>
													<td>12245</td>
													<td>Deepak Shah</td>
													<td>Quality - Dep</td>
													<td>Position 1</td>
												</tr>
											
											</tbody>
										</table>
									</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
