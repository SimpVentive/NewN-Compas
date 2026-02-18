<?php  
	$typeid=$_REQUEST['typeid'];
	$fromdate=$_REQUEST['fromdate'];
    $todate=$_REQUEST['todate'];
    $username=UlsReports::getusername();
	$prog=$_REQUEST['param1'];
    $pro_id=$_REQUEST['param2'];
	$enrol=$_REQUEST['param3'];
	$location=$_REQUEST['param4'];
	$orgname=$_REQUEST['param5'];
	$enumber=$_REQUEST['param6'];
	$type=$_REQUEST['typeid'];
		$reportname=Doctrine_Query::Create()->from('UlsReportDefaultReportTypes')->where("default_repot_id=".$type)->fetchOne();
    $getemployee=UlsReports::assessmentreport($prog,$pro_id,$fromdate,$todate);
            // echo "<div class='popup_header bar' style='width:98%;'>Report Details</div>";
         echo "<div id='idexceltable' >
				    <br />
					<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
					<div align='center'> <span><b>".$reportname['default_report_name']."</b> </span></div><br/>
					<span style='padding-left:30px;'>User Name : <b>".ucwords($username['full_name'])."</b> </span><span style='float:right; padding-right:30px;'>Date & Time : <b>".date('d-m-Y h:i:s')."</b></span>
					</div><br />
					   
                        <table id='employeesTable' style='widtd:100%' align='center' class='table table-striped table-bordered table-hover'>
                            <tr>
							   <td nowrap>S.No</td>
							   <td nowrap>Employee Number</td>
							   <td nowrap>Employee Name</td>
							   <td nowrap>Department</td>
							   <td nowrap>Position</td>
							   <td nowrap>Assessment Name </td>
							   <td nowrap>Location</td>
							   <td nowrap>Status</td>
							   <td nowrap>Score</td>
							   <td nowrap>Total</td>
							   </tr>
                     ";
                            if(count($getemployee)>0){ $serno=1;
                                foreach($getemployee as $key=>$getemployees){ 
								//chaged to event start date and event end date from empeventstartdate and empeventendadate
				                    //$stdate= ($getemployees['event_start_date']!=null)? date('d-M-Y',strtotime($getemployees['event_start_date'])) : '';
				                    //$endd= ($getemployees['event_end_date']!=null || $getemployees['event_end_date']!='') ? date('d-M-Y',strtotime($getemployees['event_end_date'])) : "";
					                $location=$getemployees['location_name']==''? '':$getemployees['location_name'];
                       echo "<tr>
				                <td nowrap>".$serno."</td><td nowrap>".$getemployees['employee_number']."</td>
						        <td nowrap>".ucwords($getemployees['full_name'])."</td>
								<td nowrap>".ucwords($getemployees['org_name'])."</td>";
								echo"<td nowrap>".$getemployees['position_name']."</td>";
                                echo "<td nowrap>".ucwords($getemployees['assessment_name'])."</td>
								<td>".ucwords($location)."</td>";
								echo "<td>";
								echo !empty($getemployees['preattempts'])?"Taken":"Not Taken";
								echo "</td>
								<td>".($getemployees['prescore'])."</td>
								<td>";
								echo !empty($getemployees['preattempts'])?($getemployees['precorr'] + $getemployees['prewrong']):"";
								echo "</td>
								</tr>";
                                $serno++;
					            }
                            }
                            else { echo "<tr><td style='height:20px;' colspan='12'>No Data Found </td></tr>";
                      
                            }
                            echo "</table></div><br /><br />";
				            if(count($getemployee)>0 && !isset($_REQUEST['ExportType'])){ ?>
				                <div align='right' style='padding:10px;'>
					                <input type='button' onclick="htmltopdf('idexceltable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')" name='btnpdfExport' class='btn btn-sm btn-success'  id='btnpdfExport' value='Generate Pdf' >					
					                <!--<input type='button' name='btnExport' class='btn btn-sm btn-success' id='btnExport' value='Export to excel' onclick="downloadexcel('employeesTable','<?php echo (isset($_REQUEST['report_name']))?$_REQUEST['report_name']:''?>')">-->
									<a class='btn btn-sm btn-success' href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ExportType=export-to-excel"; ?>">Export To Excel</a>
									</div>
					<?php }?>