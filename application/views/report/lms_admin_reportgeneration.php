<style>
/*.form-actions {
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    display: block;
    margin-top: 20px;
    padding: 10px;
}*/
</style>
<div class="content">
	<div class="row">
		<div class="col-lg-12">
            <div class="panel panel-default card-view">
				<div class="row">
				<form id="reportForm" class="form-horizontal"  name="reportForm" method="post"> 
					<div class="col-sm-5">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Reports</h6>
								</div>
								
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div>
									<?php 
									 //echo $_SESSION['parent_org_id'];
									foreach($reports as $key=>$report){
										$key1=$key+1;
									?>
										<span class="pull-left inline-block capitalize-font txt-dark">
											<span class="percent"><?php echo $key1; ?></span>
											<input type="hidden" name="report_name" id="report_name<?php echo $report['id'] ?>" value="<?php echo ucwords($report['name']); ?>">
										
											<a href="#" onclick="getparameters(<?php echo $report['id'] ?>);">
											<span class="lbl"><?php echo ucwords($report['name']); ?></span></a>
										</span>
										<div class="clearfix"></div>
										<hr class="light-grey-hr row mt-10 mb-10">
									<?php 
									}
									?>	
									</div>
								</div>	
							</div>
						</div>
						
					</div><!-- /.col -->

					<div class="col-sm-7">
						<div class="panel panel-default card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Parameters <label id="report_detail"></label></h6>
									<div class="panel-heading hbuilt">
										<font color="#FF0000">* Indicated are Mandatory <br></font>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							
							<div class="panel-body">
								<input type='hidden' name='reportname' id='reportname' value='' /> 
								<div class="widget-main no-padding" id="div_params">
									
									
								</div><!-- /.widget-main -->
							</div><!-- /.widget-body -->
						</div><!-- /.widget-box -->
					</div><!-- /.col -->
				</form>
				</div>
			</div>
		</div>
	</div><!-- /.row -->
</div>