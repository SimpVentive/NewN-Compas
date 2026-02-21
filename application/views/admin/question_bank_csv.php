<?php
	foreach($answers as $answer){
		$id=$answer['question_id'];
		$count=isset($ans[$id])?count($ans[$id]['text']):0;
		$ans[$id]['text'][$count]=$answer['text'];
		$ans[$id]['correct_flag'][$count]=$answer['correct_flag'];
	}
?>
<table>
	<tr>
		<td>Question Type</td>
		<td>Question Type</td>
		<td>Question Name</td>
		<td>level</td>
		<td>Sequence</td>
		<td>Publish Status</td>
		<td>Correct Option</td>
		<td>Options1</td>
		<td>Option2</td>
		<td>Option3</td>
		<td>Option4</td>
	</tr>
	<?php

	if(count($questionss)>0){
		$nums=0; $single_quest=array();
		
		
		foreach ($questionss as  $key=>$question){ $id=$question['id']; ?>
		<tr>
			<td><?php echo $question['type_name']; ?></td>
			<td><?php echo $question['question_type']; ?></td>
			<td><?php echo htmlentities($question['question_name']); ?></td>
			<td><?php echo @$question['scale_name']; ?></td>
			<td><?php echo @$question['sequence']; ?></td>
			<td><?php echo @$question['active_flag']; ?></td>
			<td><?php echo $key = @array_search('Y', $ans[$id]['correct_flag'])+1;?></td>
			<?php if(isset($ans[$id]['text'])){foreach($ans[$id]['text'] as $k=>$answer){ $col=(@$ans[$id]['correct_flag'][$k]=="Y")?'style="color:green;':'style="color:black'; ?>
				<td><label <?php echo $col ; ?> for="truefalse"><?php echo $answer; ?></td>
			<?php }} ?>
		</tr>
	
	<?php } } ?>
</table>
