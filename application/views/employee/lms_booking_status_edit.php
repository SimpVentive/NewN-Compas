<script>
    <?php 
// To send status to .js file
$stat='';
foreach($status as $status1){
    if($stat==''){
    $stat=$status1->code."*".$status1->name;
    }
    else{
    $stat=$stat.",".$status1->code."*".$status1->name;   
    }   
}
echo "var statusss='".$stat."';";

// To send active to .js file
$act='';
foreach($active as $active1){
    if($act==''){
    $act=$active1->code."*".$active1->name;
    }
    else{
    $act=$act.",".$active1->code."*".$active1->name;   
    }   
}
echo "var activess='".$act."';";
?>  
</script>
<div class="content">
<div class="row">
	   
    <div class="col-lg-12">
        <div class="panel panel-inverse card-view">
            
			
			<div class="hpanel">
				<form name="booking_status" id="booking_status" method="post" action="<?php echo BASE_URL;?>/admin/lms_booking_status">
				<div class="panel-body">
					<div class="table-responsive">
						<table cellpadding="1" cellspacing="1" class="table table-bordered table-striped" id="booking_status1">
							<thead>
								<tr>
									<th style="width:73px;">Select</th>
									<th style="width:241px;">User Status<sup><font color="#FF0000">*</font></sup></th>
									<th style="width:128px;">System Status<sup><font color="#FF0000">*</font></sup></th>
									<th style="width:180px;">Start Date<sup><font color="#FF0000">*</font></sup></th>
									<th style="width:180px;">End Date</th>
									<th>Status<sup><font color="#FF0000">*</font></sup></th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if(count($status_view)>0){ 
								$hide_val=array();
								foreach($status_view as $key1=>$view){
								$hide_val[]=$key1;?>
								<tr>
								<td><input type="hidden" name="b_id[]" id="b_id_<?php echo $key1;?>" value="<?php echo $view->booking_status_id;?>"><input type="checkbox" value="<?php echo $key1;?>" name="chkbox" id="chkbox_<?php echo $key1;?>" style="width:50px;"> </td>
								<td><input type="text" value="<?php echo $view->user_status; ?>" name="user_status[]" id="user_status_<?php echo $key1;?>" class="validate[required,custom[alphanumeric]] form-control"></td>
								<td>
									<select name="system_status[]" id="system_status_<?php echo $key1;?>" class="validate[required,custom[alphanumeric]] form-control" style="width:190px;">
										<option value="">Select</option>
									   <?php foreach($status as $status1){ 
										   if($status1->code==$view->system_status){?>
										<option value="<?php echo $status1->code;?>" selected="selected"><?php echo $status1->name;?></option>
									   <?php }else{?>
										 <option value="<?php echo $status1->code;?>"><?php echo $status1->name;?></option>
									   <?php } }?>
									</select>
								</td>
								<td>
									<div class="input-group date" id="datepicker">
										<input type="text" id="start_date_<?php echo $key1;?>" name="start_date[]" class="validate[custom[date2]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" style="width:100px;" value="<?php echo date('d-m-Y',strtotime($view->start_date));?>"/>
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>	
									</div>
								</td>
								<td>
									<div class="input-group date" id="datepicker">
										<input type="text" placeholder="dd-mm-yyy" id="end_date_<?php echo $key1;?>" name="end_date[]" class="validate[custom[date2],future[#start_date_<?php echo $key1;?>]] form-control" data-date-format="dd-mm-yyyy" style="width:100px;" value="<?php echo ($view->end_date!=Null)?date('d-m-Y',strtotime($view->end_date)):'';?>">
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>	
									</div>
								</td>
								<td>
									<select name="status[]" id="status_<?php echo $key1;?>" class="validate[required] form-control">
										<option value="">Select</option>
									   <?php foreach($active as $active1){ 
										   if($active1->code==$view->status){?>
										<option value="<?php echo $active1->code;?>" selected="selected"><?php echo $active1->name;?></option>
									   <?php }else{?>
										<option value="<?php echo $active1->code;?>"><?php echo $active1->name;?></option>
									   <?php } }?>
									</select>
								</td>
							</tr>
							<script>
							$(function() {
								var dates = $( "#start_date_<?php echo $key1;?>, #end_date_<?php echo $key1;?>" ).datepicker({dateFormat:"dd-mm-yy",
								defaultDate: "+1w",
								changeMonth: true,
								changeYear: true,
								numberOfMonths: 1,
								minDate:"<?php //echo date('d-m-Y');?>",
								/*maxDate:"<?php //echo $futureDate;?>",*/
								//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
								//buttonImageOnly: true,
								onSelect: function( selectedDate ) { 
									var option = this.id == "start_date_<?php echo $key1;?>" ? "minDate" : "maxDate",
									instance = $( this ).data( "datepicker" ),
									date = $.datepicker.parseDate(
									instance.settings.dateFormat ||
									$.datepicker._defaults.dateFormat,
									selectedDate, instance.settings );
									dates.not( this ).datepicker( "option", option, date );
								}
								});
							});
							</script>
						<?php
						}$hidden=@implode(',',$hide_val);
					}
					else{$hidden=0;?>
					<tr>
						<td><input type="hidden" name="b_id[]" id="b_id_0" value=""><input type="checkbox" value="0" name="chkbox" id="chkbox_0" style="width:50px;"></td>
						<td><input type="text" value="" name="user_status[]" id="user_status_0" class="validate[required,custom[alphanumeric]] form-control"></td>
						<td>
							<select name="system_status[]" id="system_status_0" class="validate[required] form-control" style="width:190px;">
								<option value="">Select</option>
								<?php 
								foreach($status as $status1){ ?>
								<option value="<?php echo $status1->code;?>"><?php echo $status1->name;?></option>
								<?php 
								} ?>
							</select>
						</td>
						<td>
							<div class="input-group date" id="datepicker">
								<input type="text" value="" name="start_date[]" id="start_date_0" class="validate[required,custom[date2]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>	
							</div>
						</td>
						<td>
							<div class="input-group date" id="datepicker">
								<input type="text" value="" name="end_date[]" id="end_date_0" class="validate[custom[date2],future[#start_date_0]] form-control" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>	
							</div>
						</td>
						<td>
							<select name="status[]" id="status_0" class="validate[required] form-control">
								<option value="">Select</option>
							   <?php foreach($active as $active1){ ?>
								<option value="<?php echo $active1->code;?>"><?php echo $active1->name;?></option>
							   <?php } ?>
							</select>
						</td>
					<?php 
					} 
					?>
					</tbody>
					<input type="hidden" name="addusers" id="addusers" value="<?php echo $hidden;?>">
                </table>
				 
                </div>
				<div class="pull-left">
					<a class="btn btn-success" href="#" name="addrow" id="addrow" onclick="add_row()">Add Row</a>
					<a class="btn btn-danger" href="#" name="delete" id="delete" value="Delete" onclick="add_delete()">Delete</a>
				</div>
				<div class="pull-right">
					<input type="submit" name="save" id="save" value="Save" class="btn btn-success" onclick="return validation()">
				</div>
				</div>
				
				</form>
			</div>
            
        </div>
    </div>
</div>

</div>
<div id="dialog-confirm" class="hide">
	<div class="alert alert-info bigger-110">
		Do you want to Delete this Organization ?
	</div>

	<div class="space-6"></div>

	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		Are you sure?
	</p>
</div>

<div id="dialog-confirm-delete" class="hide">
	<div class="alert alert-info bigger-110">
		Selected Organization cannot be deleted. Ensure you delete all the usages of the Organization before you delete it.
	</div>

	<div class="space-6"></div>
	
</div>