<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
                <div class="panel-body">
					<h3><?php echo @$compdetails['casestudy_name']; ?> <small>(<?php echo @$compdetails['casestudy']; ?>)</small></h3>
					<div class="col-lg-12">
						<p>Author: <?php echo @$compdetails['casestudy_author']; ?></p>
						<?php if(!empty($compdetails['casestudy_source'])){?><p>PDF: <a href="<?php echo BASE_URL."/public/uploads/casestudy/".$compdetails['casestudy_id']."/".$compdetails['casestudy_source']; ?>" target="_blank" >Click Here</a>
						</p><?php } ?>
						<?php if(!empty($compdetails['casestudy_link'])){?><p>Link: <a href="<?php echo @$compdetails['casestudy_link']; ?>" target="_blank" >Click Here</a></p><?php } ?>
						<p>Status: <?php echo @$compdetails['casestatus']; ?></p>
                        <p><?php echo @$compdetails['casestudy_description']; ?></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<!--<li class="active"><a data-toggle="tab" href="#tab-keyind"> Competencies</a></li>-->
					<li class="active"><a data-toggle="tab" href="#tab-keycov">Questions</a></li>
				</ul>
				<div class="tab-content ">
					<!--<div id="tab-keyind" class="tab-pane active">
						
							
							<div class="panel panel-default card-view">
							
								
								<div class="panel-wrapper collapse in">
									<?php 
									$tmp=""; foreach($competencies as $comp){
									?>
									<h6 class="panel-title txt-dark">
									<?php
									if($tmp!=$comp['competencies_name']){ 
									echo !empty($tmp)?"".$comp['competencies_name']."":"".$comp['competencies_name']."";  
									$tmp=$comp['competencies_name']; 
									}
									?>
									</h6>
									
									<div class="panel-body">
										<div>
											<span class="pull-left inline-block capitalize-font txt-dark">
												<?php echo $comp['level_name'];?>
											</span>
											<div class="clearfix"></div>
											<hr class="light-grey-hr row mt-10 mb-10">
											
										</div>
									</div>
									<?php } ?>
								</div>
								
							</div>
						
					</div>-->
					<div id="tab-keycov" class="tab-pane active">
						<div class="panel panel-default border-panel card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Questions</h6>
								</div>
								
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper task-panel collapse in">
								
							<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
							<?php 
							foreach($case_study_questions as $case_study_question){
							?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading_10">
										<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_<?php echo $case_study_question['casestudy_quest_id']; ?>" aria-expanded="true" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div><?php echo $case_study_question['casestudy_quest']; ?></a> 
									</div>
									<div id="collapse_<?php echo $case_study_question['casestudy_quest_id']; ?>" class="panel-collapse collapse" role="tabpanel">
										<div class="panel-body pa-15"> 
											<table cellpadding="1" cellspacing="1" id="edit_datable_2" class="table table-hover table-bordered mb-0">
												<thead>
													<tr>
														<th class="col-sm-8">Competency Name</th>
														<th class="col-sm-4">Level Name</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$comp_details=UlsCaseStudyCompMap::getcasestudycompetencies($case_study_question['casestudy_quest_id']);
												foreach($comp_details as $comp_detail){
												?>
													<tr>
														<td><?php echo $comp_detail['competencies_name']; ?></td>
														<td><?php echo $comp_detail['level_name']; ?></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							<?php 
							} ?>
							</div>
							<hr class="light-grey-hr">
							
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('case_study_master?id=<?php echo $compdetails['casestudy_id']."&hash=".md5(SECRET.$compdetails['casestudy_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('case_study_master')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('case_study_master_search')">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
function open_question_count(id){
	var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById('questionbank_count'+id).innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET",BASE_URL+"/admin/question_details_view?q_id="+id,true);
    xmlhttp.send();
}
</script>