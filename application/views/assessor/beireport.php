<?php
echo "
<div style='border:1px solid #DDDDDD; height: 300px;overflow: auto;'>
<!--<div class='table-responsive'>
	<table cellpadding='1' cellspacing='1' class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th></th>
				<th>Rating</th>";
				if($ins_id==3 || $ins_id==5){echo "<th></th>";}
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
				if($ins_id==3 || $ins_id==5){echo "<th>".$result['ins_subpara_text_ext']."</th>";}
			echo "</tr>";
		}
		echo "</tbody>
	</table>
</div>
</div>-->
<div class='panel panel-default card-view'>
	<div class='panel-heading'>
		<div class='pull-left'>
			<h6 class='panel-title txt-dark'>Results</h6>
		</div>
		<div class='clearfix'></div>
	</div>
	<div class='panel-wrapper collapse in'>
		<div class='panel-body'>";
if($ins_id==1){
	$val=array();
	$sum=0;
	foreach($results as $result){
		$sum=$sum+$result['text'];
	}
	if($sum>=91 && $sum<=100){
		echo "<blockquote>Sum of Elements are $sum and you are High Level of Accountability</blockquote>";
	}
	if($sum>=70 && $sum<=90){
		echo "<blockquote>Sum of Elements are $sum and you are Fairly Good of Accountability</blockquote>";
	}
	if($sum>=50 && $sum<=69){
		echo "<blockquote>Sum of Elements are $sum and you are Medium Level of Accountability</blockquote>";
	}
	if($sum>=1 && $sum<=49){
		echo "<blockquote>Sum of Elements are $sum and you are Low Level of Accountability</blockquote>";
	}
	
	
}
elseif($ins_id==3){
	$jung="";
	$inst_array=array();
	echo "<blockquote>";
	foreach($results as $inst_detail){
			$id=$inst_detail['name'];
			$inst_array[$id]=$inst_detail['val'];
		}
		if(isset($inst_array['E']) && isset($inst_array['I'])){
			if($inst_array['E']>=4){
				$jung.="E";
			}
			else{
				$jung.="I";
			}
		}
		elseif(!isset($inst_array['E']) && isset($inst_array['I'])){
			$jung.="I";
		}
		elseif(isset($inst_array['E']) && !isset($inst_array['I'])){
			$jung.="E";
		}
		
		//$jung.=isset($inst_array['E'])?($inst_array['E']>=4)?"E":isset($inst_array['I'])?($inst_array['I']>=4)?"I":"E";
		$jung.=($inst_array['S']>=4)?"S":"N";
		$jung.=($inst_array['F']>=4)?"F":"T";
		$jung.=($inst_array['J']>=4)?"J":"P"; 
	
	echo "Combine the four letters to get your personality type ".$jung;
	echo "</blockquote>";
	
}
/* if($ins_id==3){
	$val=array();
	$sum=0;
	foreach($results as $result){
		$sum=$sum+$result['text'];
	}
	if($sum>=125 && $sum<=145){
		echo "<blockquote>You have scored ".$sum.". You've got seriously bendable abilities!</blockquote>";
	}
	if($sum>=100 && $sum<=124){
		echo "<blockquote>You have scored ".$sum.". You'll do OK in Yoga, but need to work on yourself</blockquote>";
	}
	if($sum>=75 && $sum<=99){
		echo "<blockquote>You have scored ".$sum.". So, touching your toes is also hard? Start increasing your range of motion today!</blockquote>";
	}
	if($sum>=1 && $sum<=74){
		echo "<blockquote>You have scored ".$sum.". So, touching your toes is also hard? Start increasing your range of motion today!</blockquote>";
	}
} */
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