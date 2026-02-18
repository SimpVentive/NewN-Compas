<script>
<?php
foreach($_REQUEST as $key=>$val){
	if($key=="status"){
		echo "var ".$key."='".$val."';";
	}
}
if(isset($_SESSION['inbasket_time'])){
	if(!empty($_SESSION['inbasket_time'])){
		$time=explode(":",$_SESSION['inbasket_time']);
		echo "var time_spend=".(($time[0]*60*1000)+($time[1]*1000)).";";
	}
	else{
	echo "var time_spend=0;";
	}
}

else{
	echo "var time_spend=0;";
}
echo "var time=".$ass_details['time_details'].";"; 
?>
</script>
<style>
ul.droptrue{
	min-height:100px;
}
.div2 {
    width: 400px;
    height: 0px;
    padding: 18px;
    border: 1px solid red;
    padding-bottom: 110px;
    float: left;
    margin-top: 110px;
}
.case-section.list-group li {
    width: 25%;
    float: left;
    position: relative;
    min-height: 90px;
    min-width: 300px;
	padding: 0 4px;
	padding-bottom: -7px;
}
.case-section1.list-group1 {
    display: inline-block;
    position: relative;
    list-style-type: none;
    width: 100%;
    min-height: 325px;
	padding-left: 0px;
}
.case-section1.list-group1 li {
    width: 25%;
    float: left;
    position: relative;
    min-width: 260px;
    padding-bottom: -7px;
}
.case-section1 .case-item {
    background-color: #FFF;
    box-shadow: 0 1px 2px 0 rgba(204,204,204,0.5);
    border: 1px solid #ECECEC;
    padding: 15px 20px;
    margin-bottom: 10px;
}
.case-section1 .case-item .case-name .move-icon {
    float: right;
    color: #404040;
    font-size: 24px;
    height: 24px;
    width: 24px;
    cursor: move;
}
.case-section .case-item .case-name {
    display: block;
    position: relative;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 0px;
}
.col-21 {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 20%;
    flex: 0 0 20%;
    max-width: 20%;
}
</style>
<section class="main-section">
	<div class="container">
		<div class="row">
			<!-- TEST SECTION :BEGIN -->
			
			<div class="test-section">
				<!-- TEST HEAD SECTION :BEGIN -->
				<div class="test-head-section">
					<div class="d-flex align-items-center justify-content-between">
						<div class="test-head">
							<div class="icon material-icons">desktop_mac</div>
							<div class="test-info">
								<div class="test-name">Fishbone</div>
								<p class="test-content red-text">**The list of probable causes card are in random order. Please set your prioritization with the action.</p>
								<p class="test-content red-text"><a href="javascript:;" class="assessment-profile-btn  red-text" data-toggle="modal" data-target="#competency-profile-modal">View Video</a></p>
							</div>
							<div class="modal fade case-modal" id="competency-profile-modal" tabindex="-1" role="dialog" data-backdrop="static" >
								<div class="modal-dialog" role="document" >
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title flex">Video</h5>
											<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
												<i class="material-icons">close</i> Close
											</a>
										</div>
										<div class="case-info">
											
										</div>
										
										<div class="modal-body" >
											<video width="750" height="450" controls>
											  <source src="<?php echo BASE_URL;?>/public/ScreenCapture.mp4" type="video/mp4">
											</video>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="time-head">
							<div class="time-icon material-icons">timer</div>
							<div class="time-info">
								<?php
								if(($_REQUEST['status']=='career') || ($_REQUEST['status']=='strength') || ($_REQUEST['status']=='development')){
									if(!empty($_SESSION['inbasket_time'])){
										$time_spent=explode(":",$_SESSION['inbasket_time']);
									?>
									<p class="time">
									<span class="minute" id="minute">
									<?php echo $time_spent[0]; ?>
									</span>
									<sub>min</sub> : 
									<span class="minute" id="second"><?php echo $time_spent[1]; ?></span><sub>Sec</sub></p>
									<span class="text">Time taken</span>
									<?php	
									}
									else{
									?>
									<p class="time">
									<span class="minute" id="minute">
									<?php echo $ass_details['time_details']; ?>
									</span>
									<sub>min</sub> : 
									<span class="minute" id="second">00</span><sub>Sec</sub></p>
									<span class="text">Time taken</span>
									<?php									
									}
								?>
									
								<?php
								}
								else{
								?>
								<p class="time">
								<span class="minute">
								<?php echo $ass_details['time_details']; ?>
								</span>
								<sub>min</sub> : 
								<span class="minute" >00</span><sub>Sec</sub></p>
								<span class="text">Time Period</span>
								<?php
								}
								?>
							</div>
						</div>
						
					</div>
				</div>
				<!-- TEST HEAD SECTION :END -->

				<div class="space-40"></div>

				<ul class="test-nav-panel d-flex align-items-center">
					<?php
					if(isset($_REQUEST['assess_test_id'])){
					?>
					<li class="flex active" data-tab-id="read-complete-instruction" id='instruction_li'>
						<span class="num">1</span>
						<span class="txt">Intro & Instructions</span>
					</li>
					<li class="flex" data-tab-id="pritorize-the-intrays" id='strengths_li'>
						<span class="num">2</span>
						<span class="txt">Root Cause Analysis</span>
					</li>
					<li class="flex" data-tab-id="actionize-intrays" id='development_li'>
						<span class="num">3</span>
						<span class="txt">Final</span>
					</li>
					<?php }
					else{
					?>
					<li class="flex active" data-tab-id="read-complete-instruction" id='instruction_li'>
						<span class="num">1</span>
						<span class="txt">Intro & Instructions</span>
					</li>
					
					<li class="flex">
						<span class="num">2</span>
						<span class="txt">Root Cause Analysis</span>
					</li>
					<li class="flex">
						<span class="num">3</span>
						<span class="txt">Final</span>
					</li>
					<?php
					}
					?>
				</ul>

				<!-- TEST BODY :BEGIN -->
					<div id="read-complete-instruction" class="tast-tab-nav">
						<form action="<?php echo BASE_URL;?>/employee/fishbone_int_submit" method="post"  id="tab_summary_sumbit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="assess_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="fish_id" value="<?php echo $_REQUEST['fish_id'];?>" >
						<input type="hidden" name="test_id" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<div class="test-nav-scoll">
						
							<div class="test-body">
								
								<div class="question-title">Introduction:</div>
								<div class="question-content">
								<?php echo $fish_details['fishbone_description']; ?>
								</div>
								
								<div class="question-content">
								Fish Bone diagram or what is known as the Ishakawa Diagram is a tool that is used in the Problem Solving process.  This diagram helps in identifying the causes associated with a problem or an issue.  Visually, the problem or the issue that is being analysed is put as the head of the fish bone, with the various causes being the bones.  By identifying the various causes that are responsible for the issue, the problem analysis and solution development is enabled.  
								</div>
								<div class="space-40"></div>
								<div class="question-title">Instructions for Root Cause Analysis:</div>
								<div class="question-content">
								An operational problem or issue, related to your area of work is given in the next tab.  Different causes which could be responsible for this issue are given in the boxes below the Figure (main fish bone).  The causes for this issue are classified into Men, Material, Methods, Methods and Misc.  YOU WILL HAVE TO IDENTIFY THE ISSUES THAT CORRESPOND TO EACH OF THESE CATEGORIES AND DRAG them into the respective boxes.   PLEASE NOTE NOT ALL CAUSES ARE RELEVANT TO THE ISSUE, SOME UNRELATED CAUSES HAVE INTENTIONALLY BEEN INCLUDED IN THE LIST.  
								<b style="font-size:16px;text-decoration: underline;color:red;">Once you have bucketed the causes in each of the categories (5 M) , you would have to then identify THE TOP CAUSE IN THAT CATEGORY.  YOU can do so by dragging and placing the same at the top of the list. </b>
								Please watch the video, given on the right hand top to get a better understanding.  
								</div>
								<div class="question-content">
									YOU HAVE A TOTAL OF <b><?php echo $ass_details['time_details']; ?></b> MINUTES TO COMPLETE THIS EXCERCIZE. 
									<br>
									Please NOTE that if you don’t complete this within the allocated time, the system will automatically close.  So, plan your time accordingly.
								</div>
								<div class="space-40"></div>
								
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_int" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="pritorize-the-intrays" class="tast-tab-nav display-none">
						
						<form action="<?php echo BASE_URL;?>/employee/fishbone_three_submit" method="post"  id="fishbone_three_submit">
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type="hidden" name="ass_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="fish_id" value="<?php echo $_REQUEST['fish_id'];?>" >
						<input type="hidden" name="testid" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type='hidden' name='ttype' id='ttype' value="FISHBONE" />
						<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
						<?php $data_time=date('Y-m-d, H:i:s'); ?>
						<input type='hidden' name='start_period' id='start_period' value='<?php echo isset($_SESSION['inbasket_starttime'])?$_SESSION['inbasket_starttime']:$data_time; ?>' />
						<input type='hidden' name='question' id='question' value="<?php echo $fish_question['q_id']; ?>" />
						<div class="test-body">
							<div class="row">
								
								<div class="col-12">
									<img src="<?php echo BASE_URL; ?>/public/new_layout/images/fishbone_image.png" style="float: left;padding-left: 100px;">
									<div class="div2"><?php echo $fish_question['question_name']; ?></div>
								</div>
							</div>
						</div>
						<div class="">
							<div class="test-body">
								<div class="row">
									<div class="col-12">
										<div class="question-title">List of probable causes :</div>
										<p class="test-content red-text" style="color:red;font-size:11px;">**Drag the tray to move it to the Bucket[Machine/Men/Material/Methods] you want it in.</p>
										<ul id="sortable1" class="case-section list-group droptrue">
											<?php 
											if(count($testdetails)>0){
												$j=1;
												foreach($testdetails as $keys=>$testdetail){
												?>
												<li data-case="<?php echo $j; ?>" data-value="<?php echo $testdetail['fishbone_list_id']; ?>">
													
													<div class="case-item">
														<div class="case-name">Cause <?php echo $j; ?> <span class="move-icon material-icons">drag_indicator</span></div>
														<input type="hidden" name="fishbone_list_id" id="fishbone_list_id" value="<?php echo $testdetail['fishbone_list_id']; ?>">
														<div class="case-txt" style="font-size:14px;">
															
															<?php echo $testdetail['probable_causes']; ?>
														</div>
														
													</div>
												</li>
												<?php
												$j++;
												}
											}
											?>
										</ul>

										<!--<div class="question-title">Intrays :</div>-->
										
									</div>
								</div>
								<div class="row">
									
										<div class="col-21">
											<div class="question-title">MACHINE :</div>
											<input type='hidden' value='MA' name="headlist[]">
											<input type='hidden' id='sortable2_text' value='' name="group[]">
											<ul id="sortable2" class="case-section1 list-group1 droptrue">
											
											</ul> 
											
										</div>
										<div class="col-21">
											<div class="question-title">MEN :</div>
											<input type='hidden' value='ME' name="headlist[]">
											<input type='hidden' id='sortable3_text' value='' name="group[]">
											<ul id="sortable3" class="case-section1 list-group1 droptrue">
											
											</ul> 
										</div>
										<div class="col-21">
											<div class="question-title">MATERIAL :</div>
											<input type='hidden' value='MAT' name="headlist[]">
											<input type='hidden' id='sortable5_text' value='' name="group[]">
											<ul id="sortable5" class="case-section1 list-group1 droptrue">
											</ul> 
										</div>
										<div class="col-21">
											<div class="question-title">METHODS :</div>
											<input type='hidden' value='MT' name="headlist[]">
											<input type='hidden' id='sortable6_text' value='' name="group[]">
											<ul id="sortable6" class="case-section1 list-group1 droptrue">
											</ul> 
										</div>
										<div class="col-21">
											<div class="question-title">MISC :</div>
											<input type='hidden' value='MI' name="headlist[]">
											<input type='hidden' id='sortable4_text' value='' name="group[]">
											<ul id="sortable4" class="case-section1 list-group1 droptrue">
											</ul> 
										</div>
									
								</div>
							</div>
						</div>
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							<button type="submit" name="submit_three" class="btn btn-primary">Next</button>
						</div>
						</form>
					</div>
					<div id="actionize-intrays" class="tast-tab-nav display-none">
						
						<form action="<?php echo BASE_URL;?>/employee/fishbone_four_submit" method="post"  id="tab_four_sumbit">
						<input type="hidden" name="ass_test_id" value="<?php echo $_REQUEST['assess_test_id'];?>" >
						<input type="hidden" name="fish_id" value="<?php echo $_REQUEST['fish_id'];?>" >
						<input type="hidden" name="testid" value="<?php echo $_REQUEST['test_id'];?>" >
						<input type="hidden" name="jid" value="<?php echo $_REQUEST['jid'];?>" >
						<input type='hidden' name='assid' id='assid' value="<?php echo $ass_id;?>" />
						<input type='hidden' name='ttype' id='ttype' value="FISHBONE" />
						<input type='hidden' name='attempt_id' id='attempt_id' value="<?php echo !empty($_REQUEST['attempt_id'])?$_REQUEST['attempt_id']:""; ?>" />
						<input type='hidden' class="timespent" name='time_period' id='time' value='<?php echo !empty($_SESSION['inbasket_time'])?$_SESSION['inbasket_time']:""; ?>' />
						<input type='hidden' name='start_period' id='start_period' value='<?php echo isset($_SESSION['inbasket_starttime'])?$_SESSION['inbasket_starttime']:""; ?>' />
						
						<b><span style="font-size:14px;font-family:italic;color:red;">NOTE: In case the text is overlapping, you may please drag the text using the mouse for a clear view.</span></b>
						<div class="test-nav-scoll">
						<b>Output:&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:20px;font-family:italic;color:red;"><?php echo $fish_question['question_name'];?></span></b>
							<div id="fishbonediv" class="test-body">
								
								<style>
						
						.label-0{ font-size: 2em; }
						.label-1{ font-size: 1.5em; fill: #111; }
						.label-2{ font-size: 0.8em; fill: #444; }
						.label-3{ font-size: .9em; fill: #888; }
						.label-4{ font-size: .8em; fill: #aaa; }

						.link-0{ stroke: #000; stroke-width: 2px}
						.link-1{ stroke: #333; stroke-width: 1px}
						.link-2, .link-3, .link-4{ stroke: #666; stroke-width: .5px; }
						</style>
						<?php 
						//echo $responce_value['text'];
						//echo $fish_question['question_name'];
						$parsed_json2 = json_decode($responce_value['text'], true);
						//$status['name']=$fish_question['question_name'];
						$data=array();
						$data['name']="output";
						/* $data['children'][0]['name']="Men";
						$data['children'][1]['name']="Material";
						$data['children'][2]['name']="Machine";
						$data['children'][3]['name']="Method";
						$data['children'][4]['name']="Misc"; */
						$tmp="";
						foreach($parsed_json2 as $k=>$value){
							$head_name=UlsAdminMaster::get_value_name_statuss('FISH_LIST',$value['head']);
							if($k==0){
								$j=0;$p=0;
								$tmp=$value['head'];
								$data['children'][$j]['name']=$head_name['name'];
							}
							if($tmp!=$value['head']){
								$p=0;
								$j++;
								$tmp=$value['head'];
								$data['children'][$j]['name']=$head_name['name'];
							}
							$list_name=UlsFishboneListProbable::get_fishbone_cause($value['id']);
							$data['children'][$j]['children'][$p]['name']=$list_name['probable_causes'];
							//$status['children'][$k]=$value['id'];
							$p++;
						}
						/* echo "<pre>";
						print_r($status); */
						?>
								<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.1/d3.min.js" charset="utf-8"></script>
								<script type="text/javascript" src="<?php echo BASE_URL; ?>/public/new_layout/js/d3.fishbone.js"></script>
								<script>
								  // create the configurable selection modifier
								  var fishbone = d3.fishbone();
								  
								  // load the data
								  //d3.json("./data.json", function(data){
								  //d3.json(<?php echo json_encode($data); ?>, function(data){
									// the most reliable way to get the screen size
									var size = (function(){
										return {width:this.clientWidth,height: this.clientHeight};
									  }).bind(window.document.documentElement),
									
									svg = d3.select("#fishbonediv")
									  .append("svg")
									  // firefox needs a real size
									  .attr(size())
									  // set the data so the reusable chart can find it
									  .datum(<?php echo json_encode($data); ?>)
									  // set up the default arrowhead
									  .call(fishbone.defaultArrow)
									  // call the selection modifier
									  .call(fishbone);
									  
									// this is the actual `force`: just start it
									fishbone.force().start();
									
									// handle resizing the window
									d3.select(window).on("resize", function(){
									  fishbone.force()
										.size([size().width, size().height])
										.start();
									  svg.attr(size())
									});
									
								  //});
								  
								</script>
							</div>
						</div>
						
						<div class="test-footer d-flex align-items-center justify-content-between">
							<a href="javascript:;" class="btn btn-light nav-back-btn">Back</a>
							
							<button type="submit" name="submit_two" class="btn btn-primary">Next</button>
							
						</div>
						</form>
				
					</div>
			
			<!-- TEST SECTION :END -->
			</div>
		</div>
	</div>
</section>


<div class="modal fade case-modal" id="competency-profile-modal-<?php echo $ass_id; ?>-<?php echo $pos_id; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title flex">Competency Profile for this Assessment</h5>
				<a href="javascript:;" class="close-modal" data-dismiss="modal" aria-label="Close">
					<i class="material-icons">close</i> Close
				</a>
			</div>
			<div class="case-info">
				
			</div>
			
			<div class="modal-body" >
				<div id="comp_details_<?php echo $ass_id; ?>_<?php echo $pos_id; ?>"></div>
			</div>
		</div>
	</div>
</div>