<?php
echo "
<div style='border:1px solid #DDDDDD; height: 300px;overflow: auto;'>
<div class='table-responsive'>
	<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th></th>
				<th>Rating</th>";
				if($ins_id==2 || $ins_id==5){echo "<th></th>";}
		echo "</tr>
		</thead>
		<tbody>";
		$rate=array();
		foreach($ratings as $rating){
			$i=$rating['id'];
			$rate[$i]=$rating['name'];
		}
		foreach($results as $result){
			$text=$result['text'];
			if($ins_id==5){
				$text=$rate[$text];
			}
			echo "<tr>
				<th>".$result['ins_subpara_text']."</th>
				<th>".$text."</th>";
				if($ins_id==2 || $ins_id==5){echo "<th>".$result['ins_subpara_text_ext']."</th>";}
			echo "</tr>";
		}
		echo "</tbody>
	</table>
</div>
</div>
<div class='panel panel-default card-view'>
	<div class='panel-heading'>
		<div class='pull-left'>
			<h6 class='panel-title txt-dark'>Results</h6>
		</div>
		<div class='clearfix'></div>
	</div>
	<div class='panel-wrapper collapse in'>
		<div class='panel-body'>";
		$comment="";
if($ins_id==1){
	$val=array();
	
	$sum=0;
	foreach($results as $result){
		$sum=$sum+$result['text'];
	}
	if($sum>=91 && $sum<=100){
		$comment="Sum of Elements are $sum and you are High Level of Accountability";
	}
	if($sum>=70 && $sum<=90){
		$comment="Sum of Elements are $sum and you are Fairly Good of Accountability";
	}
	if($sum>=50 && $sum<=69){
		$comment="Sum of Elements are $sum and you are Medium Level of Accountability";
	}
	if($sum>=1 && $sum<=49){
		$comment="Sum of Elements are $sum and you are Low Level of Accountability";
	}
	echo "<blockquote>".$comment."</blockquote>";
	
}
elseif($ins_id==2){
	$val=array();
	foreach($results as $result){
		$vid=$result['ins_subpara_code'];
		$val[$vid]=$result['text'];
	}
	$c="";
	extract($val);
	$comment.="IE is ".$IE=30-$I2Q3-$I2Q7-$I2Q11+$I2Q15-$I2Q19+$I2Q23+$I2Q27-$I2Q31;
	$comment.=" and you are ";
	$comment.=($IE>24)?"Extroverted(E)<br><br>":"Introverted(I)<br><br>";
	$c.=$IE>24?"E":"I";
	
	$comment.="SN is ".$SN=12+$I2Q4+$I2Q8+$I2Q12+$I2Q16+$I2Q20-$I2Q24-$I2Q28+$I2Q32;
	$comment.=" and you are ";
	$comment.=($SN>24)?"Intuitive(N)<br><br>":"Sensing(S)<br><br>";
	$c.=$SN>24?"N":"S";
	
	$comment.="FT is ".$FT=30-$I2Q2+$I2Q6+$I2Q10-$I2Q14-$I2Q18+$I2Q22-$I2Q26-$I2Q30;
	$comment.=" and you are ";
	$comment.=($FT>24)?"Thinking(T)<br><br>":"Feeling(F)<br><br>";
	$c.=$FT>24?"T":"F";
	
	$comment.="JP is ".$JP=18+$I2Q1+$I2Q5-$I2Q9+$I2Q13-$I2Q17+$I2Q21-$I2Q25+$I2Q29;
	$comment.=" and you are ";
	$comment.=($JP>24)?"Perceiving(P)<br><br>":"Judging(J)<br><br>";
	$c.=$JP>24?"P":"J";
	
	$comment.="Combine the four letters to get your personality type ".$c;
	echo "<blockquote>".$comment."</blockquote>";
	
}
if($ins_id==3){
	$val=array();
	$sum=0;
	foreach($results as $result){
		$sum=$sum+$result['text'];
	}
	if($sum>=125 && $sum<=145){
		$comment="You have scored ".$sum.". You've got seriously bendable abilities!";
	}
	if($sum>=100 && $sum<=124){
		$comment="You have scored ".$sum.". You'll do OK in Yoga, but need to work on yourself";
	}
	if($sum>=75 && $sum<=99){
		$comment="You have scored ".$sum.". So, touching your toes is also hard? Start increasing your range of motion today!";
	}
	if($sum>=1 && $sum<=74){
		$comment="You have scored ".$sum.". So, touching your toes is also hard? Start increasing your range of motion today!";
	}
	echo "<blockquote>".$comment."</blockquote>";
}

if($ins_id==5){
	$val=array();
	foreach($results as $result){
		$vid=$result['ins_subpara_code'];
		$val[$vid]=$result['text'];
	}
	$c="";
	extract($val);
	$competing=0;
	$collaborating=0;
	$compromising=0;
	$avoiding=0;
	$accommodating=0;
	if($I5Q1==1){$avoiding++;}else{$accommodating++;}
	if($I5Q2==1){$competing++;}else{$accommodating++;}
	if($I5Q3==1){$collaborating++;}else{$avoiding++;}	
	if($I5Q4==1){$compromising++;}else{$accommodating++;}
	if($I5Q5==1){$collaborating++;}else{$avoiding++;}	
	if($I5Q6==1){$avoiding++;}else{$competing++;}
	if($I5Q7==1){$avoiding++;}else{$compromising++;}	
	if($I5Q8==1){$competing++;}else{$collaborating++;}	
	if($I5Q9==1){$avoiding++;}else{$competing++;}	
	if($I5Q10==1){$competing++;}else{$compromising++;}
	if($I5Q11==1){$collaborating++;}else{$accommodating++;}
	if($I5Q12==1){$avoiding++;}else{$compromising++;}
	if($I5Q13==1){$compromising++;}else{$competing++;}
	if($I5Q14==1){$collaborating++;}else{$competing++;}
	if($I5Q15==1){$accommodating++;}else{$avoiding++;}
	if($I5Q16==1){$accommodating++;}else{$competing++;}	
	if($I5Q17==1){$competing++;}else{$avoiding++;}
	if($I5Q18==1){$accommodating++;}else{$compromising++;}
	if($I5Q19==1){$collaborating++;}else{$avoiding++;}
	if($I5Q20==1){$collaborating++;}else{$compromising++;}
	if($I5Q21==1){$accommodating++;}else{$collaborating++;}
	if($I5Q22==1){$compromising++;}else{$competing++;}
	if($I5Q23==1){$collaborating++;}else{$avoiding++;}
	if($I5Q24==1){$accommodating++;}else{$compromising++;}
	if($I5Q25==1){$competing++;}else{$accommodating++;}
	if($I5Q26==1){$compromising++;}else{$collaborating++;}
	if($I5Q27==1){$avoiding++;}else{$accommodating++;}
	if($I5Q28==1){$competing++;}else{$collaborating++;}
	if($I5Q29==1){$compromising++;}else{$avoiding++;}
	if($I5Q30==1){$accommodating++;}else{$collaborating++;}
	
	echo "Your Competing total is ".$competing;
	echo "<br>Your Collaborating total is ".$collaborating;
	echo "<br>Your Compromising total is ".$compromising;
	echo "<br>Your Avoiding total is ".$avoiding;
	echo "<br>Your Accommodating total is ".$accommodating;
}

echo "</div>
	</div>
</div>";
?>
<div class='panel panel-default card-view'>
<form id='bei_master' action="<?php echo BASE_URL;?>/admin/bei_assessment_insert" method="post" enctype="multipart/form-data" class="form-horizontal">
	<input type="hidden" name="attempt_id" id="attempt_id" value="<?php echo isset($attempt_id)?$attempt_id:''?>">
	<input type="hidden" name="assessment_id" id="assessment_id" value="<?php echo isset($ass_id)?$ass_id:''?>">
	<div class='pull-left'>
		<h6 class='panel-title txt-dark'>Comments</h6>
	</div>
	<input type="hidden" name="admin_bei_result" id="admin_bei_result" value="<?php echo $comment; ?>">
	<div class="form-group">
		
		<textarea class="form-control m-b validate[required]" name="assessment_desc" id="assessment_desc" ><?php echo isset($attempt_details['admin_bei_comment'])?$attempt_details['admin_bei_comment']:''?></textarea>
		
	</div>
	<hr class="light-grey-hr">
	<div class="form-group">
		<div class="col-sm-offset-0">
		   <button class="btn btn-primary btn-sm" type="submit" name="submit" id="submit"><i class="fa fa-check"></i> Submit</button>
		</div>
	</div>
</form>

</div>
		
