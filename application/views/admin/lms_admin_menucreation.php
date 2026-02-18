
<style>
a.remove {
    color: #ff0000;
    cursor: pointer;
    float: right;
}
</style>
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse card-view">
				<div class="panel-heading hbuilt">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
				<div id="error_div" class="message">
					<?php 
					$message=$this->session->flashdata('message');
					if(!empty($message)){ echo $this->session->flashdata('message'); $this->session->unset_userdata('message'); } ?>
				</div>
                <div class="panel-body">
					<form name="menucreationform" id="menucreationform" action="<?php echo BASE_URL;?>/admin/create_menu" method="post" class="form-horizontal">
						<input type="hidden" name="default_menu" value="<?php echo isset($menutype->default_menu)? $menutype->default_menu:0; ?>">
						<input type="hidden" id="menu_creation_id" name="menu_creation_id" value="<?php echo isset($menutype->menu_creation_id)? $menutype->menu_creation_id:""; ?>">
						<?php if(isset($menutype->menu_creation_id)){?><input type="hidden" name="menu_type" value="<?php echo isset($menutype->system_menu_type)? $menutype->system_menu_type:""; ?>"> <?php } ?>
						<div class="form-group"><label class="col-sm-3 control-label">System Menu Type<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5">
								<select class="validate[required] form-control m-b" <?php if(isset($menutype->menu_creation_id)){ echo "disabled"; }?> name="menu_type" id="menu_type" onChange="actortype()">
									<option selected="selected" value="">Select</option>
									<?php 
									foreach($actor_type as $actor_types){ if(isset($menutype->system_menu_type)){$sel=$actor_types->type===$menutype->system_menu_type ? "selected='selected'":"";} else{ $sel="";} ?>
									<option <?php echo $sel; ?> value="<?php echo $actor_types->type; ?>"><?php echo $actor_types->name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Menu Name<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-sm-5"><input type="text" value="<?php echo isset($menutype->menu_name)? $menutype->menu_name:""; ?>" name="menu_name" class="validate[required,minSize[3],maxSize[50],ajax[ajaxMenuName]] form-control" id="menu_name"></div>
						</div>
						<div class="hr-line-dashed"></div>
						<menu id="nestable-menu">
							<div class="pull-left">
								<input type="button" class="btn btn-success btn-sm" value="Add Menu" id="addrow" />
								<button type="button" class="btn btn-info btn-sm" data-action="expand-all">Collapse All</button>
							</div>
							<div class="pull-right">
								<div class="form-group">
									<div class="">
										<button class="btn btn-default btn-sm" type="button" id="clear"  onClick="create_link('menucreation')">Cancel</button>
										<button class="btn btn-primary btn-sm" type="submit" id="submit_m" name="submit_m">Save changes</button>
									</div>
								</div>
							</div>           
						</menu>
						<div class="hr-line-dashed"></div>
						<div style='clear:both; '>
						<input  type="text" readonly="readonly" style="height:0px; border:0px;background:none repeat scroll 0 0 #FFFFFF !important;" name="output2" value="" class="validate[required]" id="nestable-output2"  data-prompt-position="topRight:-100" >
						<?php
						echo "<div class='cf nestable-lists '><select class='dd col-lg-5 ' style='float:right;height:270px;' id='optselect' multiple='multiple'>";
						if(isset($selectboxes)){ echo $selectboxes; }
						echo "</select><div class='dd col-lg-7' id='nestable' style='min-height:270px;border:1px solid #e8e8e8;'><ol id='parenttree' class='dd-list'>";
						if(isset($menutype->system_menu_type)){
							$parentid=isset($parentid)?$parentid:false;
							echo UlsMenu::displays(0, 0,$_REQUEST['id'],$menutype->system_menu_type,$parentid);
						}
						
						echo "</ol><input type='hidden' name='sel_menu_id' id='sel_menu_id' value=''>";
						//display_children(0,1,1,1);
						echo "</div><br style='clear:both;'>";
						echo "</div><br style='clear:both;'>";
						?>
						</div>
						<input  type="hidden" name="nestable" id="nestable-output">
        
					</form>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="msg_box33" class="lightbox pre_register"></div>