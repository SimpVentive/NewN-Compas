
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default card-view">
                <div class="panel-body">					
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>							
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Question Bank Name</th>
								<th><?php echo isset($questionbanks['name'])? $questionbanks['name'] :"";?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Question Bank Type</th>
								<th><?php echo	isset($questionbanks['types'])?$questionbanks['types']:"";?> &nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Competency</th>
								<th><?php echo	isset($questionbanks['comp_def_name'])?$questionbanks['comp_def_name']:"";?> &nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Published Status</th>
								<th><?php echo	isset($questionbanks['comp_def_status'])?$questionbanks['comp_def_status']:"";?>&nbsp;</th>
							</tr>							
						</thead>
					</table>
					<hr class="light-grey-hr">
					<div class="form-group">
						<div class="col-sm-offset-0">
							<button class="btn btn-success btn-sm" type="button" onClick="create_link('questionbank_creation?id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Update</button>
							<button class="btn btn-primary btn-sm" type="button" onClick="create_link('questionbank_creation')">Create</button>
							<button class="btn btn-info btn-sm" type="button"  onClick="create_link('questions?type=<?php echo $questionbanks['type'];?>&id=<?php echo $_REQUEST['id']."&hash=".md5(SECRET.$_REQUEST['id']);?>')">Add Questions</button>
							<button class="btn btn-danger btn-sm" type="button" onClick="create_link('questionbank_search')">Cancel</button>
						</div>
					</div>
					<hr class="light-grey-hr">
					<h5 class="lighter block green">Questions</h5>
					<?php  if(count($questionss)>0){ ?> <h6 style="color:green;">Green color values are Correct answers </h6><?php } ?>
					<div style="overflow-y:auto; height:500px; padding-left: 20px; font:10px; border: 1px solid #DDDDDD;">
						<table>
					   <?php 
					   if(count($questionss)>0){  $nums=0; $single_quest=array();
						   foreach ($questionss as  $key=>$question){ 
							   $chk=$question['correct_flag']=='Y'? 'checked="checked"'  : '';
							   $col=$question['correct_flag']=='Y'? 'style="color:green;"':'';
								$key1=$key+1;
							  ?> 
						<?php if($question['question_type']=='F'){ $nums=$nums+1;?>
					   <tr><td><?php echo $nums;  ?>).<?php echo trim($question['question_name']); ?><br />
							   Ans: <input type='text' name='quest' id='quest' value="<?php echo $question['text']; ?> " readonly="readonly" /> </td>
					  </tr>
					   <?php }
					   else if($question['question_type']=='B'){ $nums=$nums+1;?>
					   <tr><td><?php echo $nums;  ?>).<?php echo trim($question['question_name']); ?> <br />
						 Ans: <input type='text' name='fbn' id='fbn' value="<?php echo $question['text'];; ?> " readonly="readonly" />
						   </td>
					  </tr>
					   <?php }
					   else if($question['question_type']=='T'){
						  
							  if(!in_array($question['id'],$single_quest)){
								   $single_quest[]=$question['id'];  $nums=$nums+1;
								   ?>
									   <tr><td><?php echo $nums;  ?>).<?php echo trim($question['question_name']); ?> </td> </tr>
									   <?php } ?>
								 <tr><td>&emsp;<input type="radio" disabled="disabled"  name="truefalse<?php echo $key1 ; ?>" id="truefalse" <?php echo $chk ; ?> /> <label <?php echo $col ; ?> for="truefalse"><?php echo $question['text'];; ?></label> </td></tr>  
						 <?php   } 
								   
					else if($question['question_type']=='S'){ 
							 
							   if(!in_array($question['id'],$single_quest)){
								   $single_quest[]=$question['id'];  $nums=$nums+1;  ?>
								<tr><td><label class="mb-10 text-left"><?php echo $nums;  ?>).<?php echo trim($question['question_name']); ?></label></td> </tr>
						   <?php }?>
								<tr>
									<td>&emsp;
										<div>
											<input type="radio" disabled="disabled"  name="truefalse<?php echo $key1 ; ?>" id="truefalse" <?php echo $chk ; ?> />
											<label  <?php echo $col ; ?> for="truefalse"><?php echo trim($question['text']); ?></label> 
										</div>
									</td>
								</tr>  
						   <?php }
					   
				   else if($question['question_type']=='M'){
						 if(!in_array($question['id'],$single_quest)){
								   $single_quest[]=$question['id']; $nums++;
								   ?>
								  <tr><td><?php echo $nums;  ?>).<?php echo $question['question_name']; ?> </td></tr>
						 <?php } ?>
							<tr><td>&emsp;<input type="checkbox" disabled="disabled" name="truefalse" id="truefalse" <?php echo $chk ; ?> />
								   <label  <?php echo $col ; ?> for="truefalse"><?php echo $question['text']; ?></label> </td>
							</tr> 
						<?php } 
				  else if($question['question_type']=='FT'){  $nums++;?>
					   <tr ><td valign="top"><label><?php echo $nums;  ?>).<?php echo trim($question['question_name']); ?></label>
							   <textarea id="form-field-11" class="autosize-transition form-control" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 69px; name="ft" id="ft"><?php echo $question['text']; ?></textarea> </td>
				   <?php }
					   } // For loop Ends
					   } // Count Condition Ends
					   else { ?>
					   <tr><td colspan="2"> No Questions are available for this Questions Bank.</td></tr>
					   <?php } ?>
				   </table>
				  </div>
				</div>
            </div>
        </div>
    </div>
</div>
