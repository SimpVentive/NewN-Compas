<style>
	.ui-widget.ui-widget-content {border: 1px solid #c5c5c5;border-bottom-right-radius: 3px;}
	.ui-widget-header {border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.ui-state-default{border:0px;background: #fff;}
	.ui-widget-content {border: 1px solid #dddddd;background: #ffffff;color: #333333;}
	.column { list-style-type: none; margin: 0; padding: 0; width: 60%;}
	.portlet{margin: 0 1em 1em 0;padding: 0.3em;}
	.portlet-header {padding: 0.2em 0.3em;margin-bottom: 0.5em;position: relative;border: 1px solid #dddddd;background: #e9e9e9;color: #333333;font-weight: bold;}
	.portlet-toggle {position: absolute;top: 50%;right: 0;margin-top: -8px;}
	.portlet-content {padding: 0.4em;}
	.portlet-placeholder {border: 1px dotted black;margin: 0 1em 1em 0;height: 50px;}</style>
  <div class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-inverse card-view">
				<div class="panel-heading">
					<h5>Self Assessing Positions</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="row">		
		<?php foreach($positions as $position){ ?>
		<div class="col-lg-4">
			<div class="panel panel-inverse card-view">
				<div class="panel-body">
					<div class="text-center">
						<h2 class="m-b-xs" style='font-size:16px'><?php echo $position['position_name']; ?></h2>
						<p class="small"><?php echo substr($position['position_desc'],0,100); ?>...</p>
						<button class="btn btn-primary btn-sm" onclick="getassessmentjd(<?php echo $position['position_id']; ?>,<?php echo $assessment_id; ?>)">JD</button>
						<button class="btn btn-primary btn-sm" onclick="getassessmentprofiling(<?php echo $position['position_id']; ?>,<?php echo $assessment_id; ?>)">Profiling</button>
						<button class="btn btn-primary btn-sm" onclick="open_summary_sheet(<?php echo $assessment_id; ?>,<?php echo $_SESSION['emp_id']; ?>,<?php echo $position['position_id']; ?>)" >Self assessment</button>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="panel panel-default card-view">
		<div class="panel-wrapper collapse in">
			<div class="row">
				<div class="col-lg-12" id="assessmentdetails">
					
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="false">
	<div class="modal-dialog modal-lg"  style="width:900px">
		<div class="modal-content">
			<div class="color-line"></div>
			<div id="testdiv">
				<div class="modal-header" style="padding: 10px 10px;">
					<h4 class="modal-title">Test</h4>
				</div>
				<div class="modal-body">
					

				</div>
			</div>
			
		</div>
	</div>
</div>


