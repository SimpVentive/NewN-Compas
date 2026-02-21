<style>
.table-fixed{
	font-size:14px;
  width: 100%;
  background-color: #f3f3f3;

}
 .table-fixed > thead, .table-fixed > thead > tr{
    width: 100%;
    }
 .table-fixed > tbody{
    height:200px;
    overflow-y:auto;
    width: 100%;
    }
  .table-fixed > thead, .table-fixed >tbody, .table-fixed >tr, .table-fixed >td, .table-fixed >th{
    display:block;
  }
   .table-fixed >td{
      float:left;
    }
   .table-fixed >th{
        float:left;
       background-color: #f39c12;
       border-color:#e67e22;
      }
</style>
<div class="content">
	<div class="row">	   
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					<font color="#FF0000">* Indicated are Mandatory <br></font>
				</div>
				<div class="panel-body">
					<form class='form-horizontal' name="migrate_data" id="migrate_data" action="" method="post">
						<div class="form-group">
							<label class="control-label col-xs-12 col-sm-3 no-padding-right">Parent Organization<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-xs-12 col-sm-9">
								<div class="clearfix" style='width: 31%;'>
									<select name='parent_org' id='parent_org' class='validate[required] chosen-select form-control' onchange='getQuestionbanks()'>
										<option value=''>Select</option>
									<?php foreach($po_orgs as $query_data){
											echo "<option value=".$query_data->orgid.">".$query_data->orgname."</option>";
										}
									?>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-12 col-sm-3 no-padding-right">Question Bank<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-xs-12 col-sm-9">
								<div class="clearfix" style='width: 32%;'>
									<select name='questionbank' id='questionbank' class='validate[required] col-xs-12 col-sm-12 form-control' onchange='getCompetencyElements()'>
										<option value=''>Select</option>
									</select>
								</div>
							</div>
						</div>
						<div id="competency-elements">
						
						</div>
						<div class="space-2"></div>
						<div class="form-group">
							<label class="control-label col-xs-12 col-sm-3 no-padding-right">Choose File<sup><font color="#FF0000">*</font></sup>:</label>
							<div class="col-xs-12 col-sm-3">
								<div class="clearfix">
									<input type="file" name="test" id="test"  class='validate[required,custom[uploadfiles]]'>
								</div>
								<a style="color:blue;cursor:pointer;text-decoration: underline;" href="<?php echo BASE_URL;?>/public/uploads/sample_csv/question_upload/sample.xlsx">Sample File</a>
							</div>
						</div>
						<div class="space-2"></div>
						<div class="form-group">
							<label class="control-label col-xs-12 col-sm-3 no-padding-right"></label>
							<div class="col-xs-12 col-sm-9">
								<div class="clearfix">
									<input type="button" name="migrate" id="migrate" value="Upload" class="btn btn-sm btn-success">
								</div>
							</div>
						</div>
						<div class="space-2"></div>

						<div id="emppersonal_migrate_data" style="overflow-x:auto;"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>