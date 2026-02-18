<section class="main-section">
	<div class="test-complete">
		<div class="table-cell">
			<div class="icon">
				<img src="<?php echo BASE_URL;?>/public/new_layout/images/document-success.png" alt="">
			</div>
			<div class="title">Thank you for your Feedback </div>
			<div class="title" style="font-size:16px;">Your assessments have been submitted successfully</div>
			<p class="go-back-text"><a href="<?php echo BASE_URL;?>/employee/employee_assessment_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>">Click here to go back to homepage</a></p>
			
			<p class="redirect-text">Automatically redirecting in <span id="count-down">5</span> seconds</p>
		</div>
	</div>
</section>

<script type="text/javascript">
	
	let counter = 5;
	var interval = setInterval(function() {
		counter--;
		document.getElementById('count-down').innerHTML = counter;
		if (counter == 0) {
			clearInterval(interval);
			
			window.location.href ="<?php echo BASE_URL;?>/employee/employee_assessment_details?jid=<?php echo $_REQUEST['jid'];?>&pro=<?php echo $_REQUEST['pro'];?>&asstype=<?php echo $_REQUEST['asstype'];?>&assessment_id=<?php echo $_REQUEST['assessment_id'];?>&position_id=<?php echo $_REQUEST['position_id'];?>&assessment_pos_id=<?php echo $_REQUEST['assessment_pos_id'];?>";
			
		}
	}, 1000);
</script>
