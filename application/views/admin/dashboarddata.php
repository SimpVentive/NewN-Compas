<div class="row">
	<?php
	$tests=$questionbanks['mcq'];
	if(empty($tests)){
		$color="style='color:#ccc !important;'";
		$width="style='width: 0%'";
	}
	else{
		$color="";
		$width="style='width: 100%'";
	}
	?>
	<div class="col-md-3">
		<div class="panel panel-default card-view hbggreen">
			<div class="panel-body">
				<div class="text-center">
					<h3 <?php echo $color; ?>>Test</h3>
					<div class="progress progress-xs mb-0 ">
						<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
					</div>
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questions['mcq']; ?></span></span></span>
					<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of Question bank are 
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>>
						<?php echo empty($questionbanks['mcq'])?0:$questionbanks['mcq']; ?></span></span>
					</span>
					
				</div>
			</div>
		</div>
	</div>
	<?php
	$cases=$questionbanks['cases'];
	if(empty($cases)){
		$color="style='color:#ccc !important;'";
		$width="style='width: 0%'";
	}
	else{
		$color="";
		$width="style='width: 100%'";
	}
	?>
	<div class="col-md-3">
		<div class="panel panel-default card-view hbggreen">
			<div class="panel-body">
				<div class="text-center">
					<h3 <?php echo $color; ?>>Case studies</h3>
					<div class="progress progress-xs mb-0 ">
						<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
					</div>
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questions['cases']; ?></span></span></span>
					<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of question bank are
						<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo empty($questionbanks['cases'])?0:$questionbanks['cases']; ?></span></span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php
	$inbaskets=$questionbanks_inbasket['q_bank'];
	if(empty($inbaskets)){
		$color="style='color:#ccc !important;'";
		$width="style='width: 0%'";
	}
	else{
		$color="";
		$width="style='width: 100%'";
	}
	?>
	<div class="col-md-3">
		<div class="panel panel-default card-view hbggreen">
			<div class="panel-body">
				<div class="text-center">
					<h3 <?php echo $color; ?>>In-Baskets</h3>
					<div class="progress progress-xs mb-0 ">
						<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
					</div>
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $question_inbasket['ques']; ?></span></span></span>
					<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of question bank are
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo empty($questionbanks_inbasket['q_bank'])?0:$questionbanks_inbasket['q_bank']; ?></span></span></span>
					
				</div>
			</div>
		</div>
	</div>
	<?php
	$interviews=$questionbanks['interview'];
	if(empty($interviews)){
		$color="style='color:#ccc !important;'";
		$width="style='width: 0%'";
	}
	else{
		$color="";
		$width="style='width: 100%'";
	}
	?>
	<div class="col-md-3">
		<div class="panel panel-default card-view hbggreen">
			<div class="panel-body">
				<div class="text-center">
					<h3 <?php echo $color; ?>>Interviews</h3>
					<div class="progress progress-xs mb-0 ">
						<div <?php echo $width; ?> class="progress-bar progress-bar-primary"></div>
					</div>
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo $questions['interview']; ?></span></span></span>	
					<span class="font-12 head-font txt-dark" <?php echo $color; ?>>Total no of  question bank are
					<span class="font-20 block counter txt-dark"><span class="counter-anim" <?php echo $color; ?>><?php echo empty($questionbanks['interview'])?0:$questionbanks['interview']; ?></span></span></span>
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-inverse card-view">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Level Name</th>
							<th>Count</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$scale_count=array();
						if(!empty($questionbanks['test_question_bank_id'])){
						$q_count_test=UlsQuestionbank::get_questions_level_count($questionbanks['test_question_bank_id']);
						foreach($q_count_test as $q_counts){
							$scale_count2=UlsQuestionbank::get_questions_data_level_comp($q_counts['question_bank_id'],$q_counts['scale_id'],$q_counts['comp_def_id']);
								$id=$q_counts['scale_id'];
								$scale_count[$id]['name']=isset($scale_count[$id]['name'])?$scale_count[$id]['name']:$q_counts['scale_name'];
								$scale_count[$id]['count']=isset($scale_count[$id]['count'])?$scale_count[$id]['count']+count($scale_count2):count($scale_count2);
							}
						}
						foreach($scale_count as $q_counts){
						?>
						<tr>
							<td>
								<?php echo $q_counts['name']; ?>
							</td>
							<td><?php echo $q_counts['count']; ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-inverse card-view">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Level Name</th>
							<th>Count</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$scale_count_case=array();
						if(!empty($questionbanks['case_question_bank_id'])){
						$q_count_case=UlsQuestionbank::get_questions_level_count($questionbanks['case_question_bank_id']);
						
						foreach($q_count_case as $q_counts){
							$scale_count2=UlsQuestionbank::get_questions_data_level_comp($q_counts['question_bank_id'],$q_counts['scale_id'],$q_counts['comp_def_id']);
								$id=$q_counts['scale_id'];
								$scale_count_case[$id]['name']=isset($scale_count_case[$id]['name'])?$scale_count_case[$id]['name']:$q_counts['scale_name'];
								$scale_count_case[$id]['count']=isset($scale_count_case[$id]['count'])?$scale_count_case[$id]['count']+count($scale_count2):count($scale_count2);
							}
						}
						foreach($scale_count_case as $q_counts){
						?>
						<tr>
							<td>
								<?php echo $q_counts['name']; ?>
							</td>
							<td><?php echo $q_counts['count']; ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-inverse card-view">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Level Name</th>
							<th>Count</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$scale_count_in=array();
						if(!empty($questionbanks_inbasket['comp_def_id'])){
						$q_count_in=UlsQuestionbank::get_questions_inbasket_level_count($questionbanks_inbasket['comp_def_id']);
						/* foreach($q_count_in as $q_counts){
							$scale_count_in2=UlsQuestionbank::get_questions_inbasket_data_level_comp($q_counts['question_id'],$q_counts['scale_id'],$q_counts['comp_def_id']);
							$id=$q_counts['scale_id'];
							$scale_count_in[$id]['name']=isset($scale_count_in[$id]['name'])?$scale_count_in[$id]['name']:$q_counts['scale_name'];
							$scale_count_in[$id]['count']=isset($scale_count_in[$id]['count'])?$scale_count_in[$id]['count']+count($scale_count_in2):count($scale_count_in2);
							}
						} */
						foreach($q_count_in as $q_counts){
						?>
						<tr>
							<td>
								<?php echo $q_counts['scale_name']; ?>
							</td>
							<td><?php echo !empty($q_counts['q_id'])?$q_counts['q_id']:0; ?></td>
						</tr>
						<?php }
						}
						?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-inverse card-view">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Level Name</th>
							<th>Count</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$scale_count_int=array();
						if(!empty($questionbanks['int_question_bank_id'])){
						$q_count_int=UlsQuestionbank::get_questions_level_count($questionbanks['int_question_bank_id']);
						foreach($q_count_int as $q_counts){
							$scale_count_int2=UlsQuestionbank::get_questions_data_level_comp($q_counts['question_bank_id'],$q_counts['scale_id'],$q_counts['comp_def_id']);
							$id=$q_counts['scale_id'];
							$scale_count_int[$id]['name']=isset($scale_count_int[$id]['name'])?$scale_count_int[$id]['name']:$q_counts['scale_name'];
							$scale_count_int[$id]['count']=isset($scale_count_int[$id]['count'])?$scale_count_int[$id]['count']+count($scale_count_int2):count($scale_count_int2);
							}
						}
						foreach($scale_count_int as $q_counts){
						?>
						<tr>
							<td>
								<?php echo $q_counts['name']; ?>
							</td>
							<td><?php echo $q_counts['count']; ?></td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>