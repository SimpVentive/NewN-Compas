<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-body">
					<table class="table table-bordered table-striped" cellspacing="1" cellpadding="1">
						<thead>
						<?php $questionbanks=$questionbankdetails;
							$qbid=$questionbanks->question_bank_id;?>
							<tr>
								<th style=" background-color: #edf3f4;width:20%">Question Bank Name</th>
								<th><?php echo $questionbanks->name ; ?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Published Status </th>
								<th><?php echo   ($questionbanks->active_flag=='P')? "Published" : " Not Published" ;?>&nbsp;</th>
							</tr>
							<tr>
								<th style=" background-color: #edf3f4;width:20%"> Description </th>
								<th><?php echo $questionbanks->description ; ?>&nbsp;</th>
							</tr>
							<?php ?>
						</thead>
					</table>
					<div class="hpanel">
						<div class="panel-heading hbuilt">
							Question Information.
						</div>
						<div class="alert alert-success">
							<i class="fa fa-bolt"></i> Green coloured Answers are Correct Option for the question
						</div>
						<div class="panel-body">
							<div class="panel-heading hbuilt">
								<?php foreach($questionbank as $question){?>
								1).<?php echo stripslashes($question['qname']); ?>
								<?php  $id=$question['id']; $type=$question['type']; } ?>
							</div>
							<div class="panel-body no-padding">
								<ul class="list-group">	
									<?php  
									foreach($questionvalues as $questionvalue){
										$answer=stripslashes($questionvalue['options']);
										$ss=$questionvalue['flag']=='Y'? "checked='checked'" : ''; 
										$col=$questionvalue['flag']=='Y'?"style='color:green;'":'';
										if($type=='F'){ 
										?>
										<li class="list-group-item">
											Answer :<label style='color:green;'><?php echo ($answer); ?></label>
										</li>
										<?php 
										}
										if($type=='B'){ 
										?>
										<li class="list-group-item">
											Answer :<label style='color:green;'><?php echo ($answer); ?></label>
										</li>
										<?php 
										}
										if($type=='T'){  
										?>
										<li class="list-group-item">
											<input type="radio" disabled="disabled" name="radio1" <?php echo $ss ;?>  id=""  /><label <?php echo $col; ?> ><?php echo ($answer); ?></label>
										</li>
										<?php 
										}
										if($type=='S'){  
										?>
										<li class="list-group-item">
											<div class="radio"><label <?php echo $col; ?>><input type="radio" disabled="disabled" name="radio1" <?php echo $ss ;?>  id=""  /><?php echo ($answer); ?></label></div>
										</li>
										<?php 
										}
										if($type=='M'){  
										?>
										<li class="list-group-item">
											<div class="checkbox"><label <?php echo $col; ?>><input type="checkbox" disabled="disabled" name="radio1" <?php echo $ss ;?>  id=""  /><?php echo ($answer); ?></label></div>
										</li>
										<?php 
										}
										if($type=='P'){  
										?>
										<li class="list-group-item">
											<div class="checkbox"><label <?php echo $col; ?>><input type="checkbox" disabled="disabled" name="radio1" <?php echo $ss ;?>  id=""  /><?php echo ($answer); ?></label>
										</li>
										<?php
										}
										if($type=='FT'){  
										?>
										<li class="list-group-item">
											<textarea class="mediumtexta" style=' resize: none;' readonly="readonly"><?php echo ($answer); ?></textarea>
										</li>
										<?php 
										}
									}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="wizard-actions">
						<div class="col-sm-6 col-sm-offset-8">
							<input type="button" name="edit" class="btn btn-primary btn-sm" id="edit" onClick="create_link('question_creation?step1&type=<?php echo $_REQUEST['type'];?>&qid=<?php echo $_REQUEST['id'];?>&id=<?php echo  $qbid."&hash=".md5(SECRET. $qbid);?>')" value="Update">
							<input type="button" name="new" class="btn btn-primary btn-sm" id="new" onClick="create_link('question_creation?step1&type=<?php echo $_REQUEST['type'];?>&id=<?php echo  $qbid."&hash=".md5(SECRET. $qbid);?>')" value="AddQuestion">
							<input type="button" name="clear" class="btn btn-primary btn-sm" id="clear" value="Cancel"  onclick="create_link('questions?type=<?php echo $_REQUEST['type'];?>&id=<?php echo  $qbid."&hash=".md5(SECRET. $qbid);?>')" >
						</div>
					</div>
					
					<div class="hr-line-dashed"></div>
				</div>
            </div>
        </div>
    </div>
</div>
