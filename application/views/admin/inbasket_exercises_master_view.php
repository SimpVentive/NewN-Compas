<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
<style>
	.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
	.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.ui-state-default{border:0px;background: #fff;}
	.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
	.column { list-style-type: none; margin: 0; padding: 0; width: 95%;}
	.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
	.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
	.portlet-content {padding: 0.4em;}
	.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}</style>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">	
                <div class="panel-body">
					<h3><?php echo @$compdetails['inbasket_name']; ?></h3>
					<div class="col-lg-12">
						<p>Position: <?php echo @$compdetails['position_name']; ?></p>
						<p>Instructions: <?php echo @$compdetails['inbasket_instructions']; ?></p>
						<p>Narration: <?php echo @$compdetails['inbasket_narration']; ?></p>
						<p>Time Intervel: <?php echo @$compdetails['inbasket_time_period']; ?></p>
						<p>Inbasket Actions: <?php echo @$compdetails['inbasketaction']; ?></p>
						<p>Expected Scorting order: <?php echo @$compdetails['inbasketscortingorder']; ?></p>
						<?php 
						if(!empty($compdetails['inbasket_upload'])){
							$downlaod_page=BASE_URL.'/includes/download_solution.php';
							$paths= __SITE_PATH .DS.'public'.DS.'uploads'.DS.'inbasket'.DS.$compdetails['inbasket_id'].DS.$compdetails['inbasket_upload'];
							$link_m=$downlaod_page."?id=".$paths;?>
							<p>PDF: <a href='<?php echo $link_m;?>' style='color:blue; text-decoration: underline;' ><?php echo @$compdetails['inbasket_upload'];?></a></p>
						<?php 
						} ?>
						<p>Status: <?php echo @$compdetails['inbasketstatus']; ?></p>
                        <p><?php echo @$compdetails['inbasket_description']; ?></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#tab-keyind"> View Intray $ Sort</a></li>
					
				</ul>
				<div class="tab-content ">
					<div id="tab-keyind" class="tab-pane active">
						<div class="panel-body">
							<div class="row">
							<?php
							$question_view=UlsQuestionValues::get_allquestion_values_competency($compdetails['question_id']);
							?>
							<ul class="column">
								<?php 
								foreach($question_view as $key=>$question_views){
									if(!empty($question_views['inbasket_mode'])){
									$parsed_json = json_decode($question_views['inbasket_mode'], true);
									}
								?>
								<li class="ui-state-default" id="intraydelete_<?php echo $question_views['value_id'];?>">
									<div class="portlet">
										
										<div class="portlet-header">
											<span class='ui-icon ui-icon-arrowthick-2-n-s'></span> Intray <?php echo $key+1; ?>
											
											</div>
										<div class="portlet-content">
										
										<p class="text-muted" style="font-weight:bold; float:right;"><b><?php echo $question_views['comp_def_name']; ?> (<code><?php echo $question_views['scale_name']; ?></code>)</b></p>
										<?php
										if(!empty($parsed_json)){
											foreach($parsed_json as $key => $value)
											{
												$yes_stat="IN_MODE";
												$val_code=UlsAdminMaster::get_value_name_statuss($yes_stat,$value['mode']);
											?>
											   <p><code>Mode:</code><?php echo $val_code['name'];?></p>
											   <p><code>Time:</code><?php echo $value['period'];?></p>
											   <p><code>From:</code><?php echo $value['from'];?></p>
											<?php
											}
										}
										?>
										<p class="text-muted"><?php echo nl2br($question_views['text']); ?></p></div>
									</div>
								</li>
								<?php } ?>
								
							</ul>

						</div>
					</div>
					
				</div>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-offset-4">
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('inbasket_exercises_master?id=<?php echo $compdetails['inbasket_id']."&hash=".md5(SECRET.$compdetails['inbasket_id']);?>')">Update</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('inbasket_exercises_master')">Create</button>
				<button class="btn btn-primary btn-sm" type="button" onClick="create_link('inbasket_exercises_master_search')">Cancel</button>
			</div>
		</div>
	</div>
</div>