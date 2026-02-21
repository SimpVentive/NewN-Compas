<div class="content">
<div class="row">  
    <div class="col-lg-12">
        <div class="panel panel-inverse card-view">
            <div class="panel-heading hbuilt">
				Create Test
				<div class="pull-right">
					<a href="#" onClick="create_link('test_creation')" class="btn btn-sm btn-success">&nbsp <i class="fa fa-plus-circle"></i> Create Test &nbsp </a>
				</div>
			</div>
			<div class="panel-body">
				<form action="" id="loginForm" class="searchForm" method="get">
				<div class="row">
					<div class="col-md-3">
						
						<div class="form-group col-lg-12">
							<label>Test Name</label>
							<input name="test_name" id="test_name" value="<?php echo isset($test_name)? $test_name:""; ?>" class="form-control" type="text">
						</div>
					</div>
					<div class="form-group col-md-1">
						<div class="text-left">
							<label>&nbsp;</label>
							<button class="btn btn-primary btn-sm form-control">Search</button>
						</div>

					</div>
				</div>
				</form>
			</div>
			<div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					Search Results
				</div>
				<div class="panel-body">
				<?php echo $pagination; ?>
				<div class="table-responsive">
					<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>Test Name</th>
							<th>Published Status</th>
							<th>Number of Questions</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if(count($testdetails) >0){
							foreach($testdetails as $key=>$testdetail){
								$pub="";
								$key1=$key+1;
								$tid=$testdetail['test_id'];
								$hash=SECRET.$tid;
								$type=$testdetail['test_type_flag'];
								?>
						<tr id="row<?php echo $key1;?>">
							<td><?php echo $testdetail['test_name'] ;?></td>
							<td><?php echo $testdetail['publish_status'];  ?></td>
							<td><?php echo $testdetail['questioncount']==null?0:$testdetail['questioncount']; ?></td>
							<td>
								<a class="btn btn-warning2 btn-xs" href="<?php echo BASE_URL ; ?>/admin/update_test?test_type=<?php echo $type;?>&id=<?php echo $tid; ?>&hash=<?php echo md5($hash); ?>"><i class="fa fa-book"></i> Manage</a>
								<a class="btn btn-success btn-xs" href="<?php echo BASE_URL."/admin/test_view?id=".$tid."&hash=".md5($hash);?>"><i class="fa fa-upload"></i> View</a>
								<a class="btn btn-info btn-xs" href="<?php echo BASE_URL."/admin/test_edit?id=".$tid."&hash=".md5($hash);?>"><i class="fa fa-paste"></i> Update</a>
								<a class="btn btn-danger btn-xs deleteclass" onclick="deletefunction(this)" id="<?php echo $tid; ?>" name="deletetest" rel="row<?php echo $key1; ?>"  href="#"><i class="fa fa-trash-o"></i> Delete</a>
							</td>
						</tr>
						<?php }
						}
						else {?>
						   <tr>
								<td colspan="8">No data found.</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
                </div>
				<?php echo $pagination; ?>
				<?php
				if(count($quests)>0){
					foreach($quests as $quest){
						$cou=$quest->question_id;
					}
				}
				else{ $cou=''; }
				?> 
				<input type="hidden" name='questions' id='questions' value="<?php echo $cou;  ?>" />
				</div>
			</div>            
        </div>
    </div>
</div>
</div>

<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Test ?.
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		You cannot delete a Test, that have been used in the events . Instead, set an end date to prevent Test being displayed for further use.
	</div>

	<div class="space-6"></div>
	
</div>
