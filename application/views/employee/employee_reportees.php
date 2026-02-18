<div class="body-section">

	<div class="top-nav-section">
		<ul class="nav align-items-center">
			<li class="nav-year-item">
				
				<a href="javascript:;" class="item"><span style="color: #404040;display: block;font-size: 16px;font-weight: bold;margin-bottom: 1px;position: relative;">Your Reportees&nbsp;&nbsp;</span></a>
				
			</li>
		</ul>
	</div>
	<div class="year-tab-section" id="position-tab">
		

		<div class="section-view">
			
			<div  class="tab-content no-scrollbar">
				<div  class="tab-pane">
					<div class="">
						<div class="tab-panel">
							
							
							<div class="tab-body">
							<?php 
							if(count($reportees_data)>0){
								foreach($reportees_data as $key=>$reportees_info){?>
								<div class="tab-areas-card">
									<div class="tab-areas-header">
										<span class="icon"><?php echo $key+1; ?></span>
										<span><a href="#" data-toggle="modal" data-target="#ass-rules-modal<?php echo $reportees_info['employee_number'];?>"><?php echo $reportees_info['employee_number']."-".$reportees_info['full_name'];?></a></span>
									</div>
								</div>
								<div class="modal fade case-modal" id="ass-rules-modal<?php echo $reportees_info['employee_number'];?>" tabindex="-1" role="dialog">
									<div class="modal-dialog" role="document" >
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title flex">Employee Development Report</h5>
												<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
													<i class="material-icons">close</i> Close
												</a>
											</div>
											<div class="case-info">
												
											</div>
											<div class="modal-body" >
												<div id="level_comp">
													<p><?php echo $reportees_info['employee_number']."-".$reportees_info['full_name'];?></p>
													<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped' width='100%'>
														<thead>
															<tr>
																<th>Competency Name</th>
																<th>Indicators</th>
															</tr>
														</thead>
														<tbody>
														<?php
														$ind=UlsAssessmentEmployeeDevRating::get_emp_rating_details($reportees_info['employee_id']);
														$temp="";
														foreach($ind as $inds){
														?>
														<tr>
															<td><?php
															if($temp!=$inds['comp_def_name']){
																echo $inds['comp_def_name'];
																$temp=$inds['comp_def_name'];
															}?></td>
															<td><?php echo $inds['comp_def_level_ind_name'];?></td>
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
								</div>
							<?php 
								}
							}?>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- TOP YEAR SECTION :END -->
</div>

