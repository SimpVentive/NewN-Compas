<?php
global $con;
 /////////////////////////////////////////////////////
//  Notification : Reminder Notification	    // 
/////////////////////////////////////////////////////
include_once("dbconnect.php");
	$query="select parent_org_id from uls_notification where status='A' and event_type='KNOWLEDGE_REMINDER_MAIL'";
    $execute=mysqli_query($con,$query);
    $csv_var="";
    while($row = mysqli_fetch_array($execute))
	{
		if($csv_var=="")  {
			$csv_var=$row['parent_org_id'];
		}
		else{
			$csv_var=$csv_var.",".$row['parent_org_id'];
		}
	}
	// echo  $csv_var ;
	
	$notify="SELECT em.`employee_id`,em.`full_name`,em.`email`,em.`employee_number`,em.pos_conf_date,a.`assessment_id`,a.`assessment_name`,a.`skill_type`,a.`skill_days`,a.`fail_skill_days`,s.full_name as sup_full_name,s.email as semail,ep.`position_name`,ep.`org_name`,ep.`location_name`,j.parent_org_id,s.employee_number as sup_employee_number,s.employee_id as sup_employee_id FROM `uls_assessment_employee_journey` j 
	left join(SELECT `assessment_id`,`position_id`,`employee_id` FROM `uls_assessment_employees`) e on e.assessment_id=j.assessment_id and e.position_id=j.position_id and e.employee_id=j.employee_id
	left join(SELECT `assessment_id`,`assessment_name`,`skill_type`,`skill_days`,`fail_skill_days` FROM `uls_assessment_definition`) a on a.assessment_id=j.assessment_id
	left join(SELECT `employee_id`,`full_name`,`email`,`employee_number`,`pos_conf`,`pos_conf_date` FROM `uls_employee_master`) em on em.employee_id=j.employee_id
	left join(SELECT `employee_id`,`employee_number`,`full_name`,`supervisor_id`,`position_name`,`org_name`,`location_name` FROM `employee_data`) ep on ep.employee_id=em.employee_id
	left join(SELECT `employee_id`,`employee_number`,`full_name`,`supervisor_id`,`email` FROM `employee_data`) s on s.employee_id=ep.supervisor_id
	where j.status is NULL and em.pos_conf=1 and j.parent_org_id IN ( $csv_var )";
    $empdetails=mysqli_query($con,$notify);
	while($notifications=mysqli_fetch_array($empdetails)){
		$date_raw=date("Y-m-d");
		$assDate = date('Y-m-d',strtotime($notifications['pos_conf_date']. ' + '.$notifications['skill_days'].' days'));
		$ass_next_date=date("Y-m-d", strtotime('-1 day', strtotime($assDate)));
		if($ass_next_date==$date_raw){
            $que="select * from uls_notification where status='A' and event_type='KNOWLEDGE_REMINDER_MAIL' and parent_org_id=".$notifications['parent_org_id'];
            $result=mysqli_query($con,$que);
            $notificationid="";
            while($fetchquery=mysqli_fetch_array($result)){ 
                $notificationid=$fetchquery['notification_id'];
			    $mailcontent=$fetchquery['comments'];
            }
            echo $empid=$notifications['employee_id'];
            $supname=$notifications['sup_full_name'];
			$empname=$notifications['full_name'];
			$posname=$notifications['position_name'];
			$depname=$notifications['org_name'];
			$ass_test=$notifications['assessment_name'];
			$mail=$notifications['semail'];
			$poid=$notifications['parent_org_id'];
			$sup_emp_code=$notifications['sup_employee_number'];
			$sup_emp_id=$notifications['sup_employee_id'];
			$emailBody =$mailcontent;
			$emailBody = str_replace("#NAME#",ucwords($supname),$emailBody);
		    $emailBody = str_replace("#EMPNAME#",ucwords($empname),$emailBody);
		    $emailBody = str_replace("#POSNAME#",($posname),$emailBody);
		    $emailBody = str_replace("#DEPARTMENT#",($depname),$emailBody);
		    $emailBody = str_replace("#ASSTEST#",$ass_test,$emailBody);
		    $emailBody = str_replace("#NEXTDATE#",$assDate,$emailBody);
			$mailsubject=$emailBody;
			$mailbody=mysqli_real_escape_string($con,$mailsubject);
		    $sub="Knowledge Assessment Reminder Mail";
            $timpestamp=date('Y-m-d H:i:s');
			$inserts="INSERT INTO uls_notification_history(notification_id,employee_id,event_id,timestamp,mail_status, mail_delivey_time,`to`,cc,subject,attachment,attachment_flag,mail_content,mail_type,parent_org_id,created_by,created_date,modified_by,modified_date,last_modified_id)VALUES('$notificationid','$empid',NULL,'$timpestamp','',NULL,'$mail',NULL,'$sub',NULL,NULL,'$mailbody',NULL,'$poid','$sup_emp_code','$date_raw','$sup_emp_code','$date_raw','$sup_emp_id') ";
			$retval = mysqli_query($con,$inserts) or die("invalid query"); 
        }
	}
    
   
         
   ?>