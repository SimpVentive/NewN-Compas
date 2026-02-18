<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
							<?php foreach($testd as $testds){
							 $startdate=($testds['start_date_active']==NULL)?"" : date('d-m-Y',strtotime($testds['start_date_active']));
							 $enddate=($testds['end_date_active']==NULL)?"" : date('d-m-Y',strtotime($testds['end_date_active']));
							 ?>
							<tr>
							
								<th style=" background-color: #edf3f4;width:20%">Test Name</th>
								<th><?php echo $testds->test_name; ?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Pass Percentage</th>
								<th><?php echo $testds->total_score; ?> &nbsp;</th>
							</tr>
							<?php } ?>
						</thead>
					</table>
					<div class="hr-line-dashed"></div>
					<div class="form-group">
						<div class="col-sm-offset-4">
							<button class="btn btn-success" type="button" onClick="create_link('test_edit?id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Update</button>
							<button class="btn btn-info" type="button"  onClick="create_link('test_creation')">Create</button>
							<button class="btn btn-danger" type="button" onClick="window.history.back()">Cancel</button>
						</div>
					</div>
					<div class="hr-line-dashed"></div>
					<h3 class="lighter block green">Test Questions</h3>
					
					<div style="overflow-y:auto; height:200px; padding-left: 20px; border: 1px solid #DDDDDD;">
						<div class="panel-body">
							<table class="table">
								<?php
								if(count($testdetails)>0){
									foreach($testdetails as $key=>$testdetail){  
										$key1=$key+1; 
										$type=$testdetail['question_type'];
										?>
										<thead>
										<tr>
											<td>
												<?php echo $key1; ?> ).<?php echo $testdetail['question_name']; ?>
											</td>
										</tr>
										</thead>
										<tbody>
										<?php 
										$ss=Doctrine_Query::create()->select('text,correct_flag')->from('UlsQuestionValues')->where('question_id='.$testdetail['question_id'])->execute();
										foreach($ss as $sss){ 
											$chk=$sss['correct_flag']==='Y'? ' checked="checked"' : '';
											$sty=$sss['correct_flag']==='Y'? ' style="color:green;"' : '';
											if($type=='F'){
											?>
												<tr>
													<td>
														Ans:<label <?php echo   $sty; ?> for="fil"><?php echo $sss['text']; ?></label>
													</td>
												</tr>
											<?php }
											else if($type=='B'){?>
												<tr><td>&emsp;Ans: <label  <?php echo   $sty; ?> for="fil"><?php echo $sss['text']; ?></label> </td></tr>  
											<?php 
											}
											else if($type=='T'){?>
												<tr><td>&emsp;<input type="radio" disabled="disabled"  name="truefalse<?php echo $key1 ; ?>" id="truefalse" <?php echo $chk ; ?> /> <label  <?php echo   $sty; ?> for="truefalse"><?php echo $sss['text']; ?></label> </td></tr>  
											<?php 
											}
											else if($type=='S'){?>
												<tr><td>&emsp;<input type="radio"  disabled="disabled" name="truefalsesinle<?php echo $key1 ; ?>" id="truefalse" <?php echo $chk ; ?> /> <label  <?php echo   $sty; ?> for="truefalse"><?php echo $sss['text']; ?></label> </td></tr>  
											<?php 
											}
											else if($type=='M'){?>
												<tr><td>&emsp;<input type="checkbox" disabled="disabled" name="truefalse" id="truefalse" <?php echo $chk ; ?> />
												<label  <?php echo   $sty; ?> for="truefalse"><?php echo $sss['text']; ?></label> </td></tr>  
											<?php 
											}
											else if($type=='FT'){?>
												<tr><td>&emsp;<textarea class="mediumtexta"  <?php echo   $sty; ?> disabled="disabled"> <?php echo $sss['text']; ?></textarea> </td></tr>  
												<?php 
											} 
										}
										?>
										</tbody>
									<?php 
									}
								}
								else {?> <tr><td colspan="8"> No Questions available for this Test. Please Add Questions for this Test.</td></tr>
								<?php } ?>
							</table>
						</div>	
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
