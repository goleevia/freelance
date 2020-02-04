<center><h1>Votting</h1>
	<?php echo form_open('controller/addvote');
	echo validation_errors();?>
	<table>
	<tr><th>Name</th><th>Vote</th><th>Rate</th></tr>
	<tr>	<?php 
	$i='0';
foreach ($lists as  $value) {
	//print_r($value);
	//exit();
	
	?>
	<td> <?php echo $value['fullname'] ;?></td>

	<?php echo form_hidden('text_'.$value['userid'],$value['fullname']);?>
<td><?php echo form_radio('vote',$value['userid']);?>
</td>
<td>
	<?php
$options=array(''=>'select','0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5',
	         '6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10');
;

 echo form_dropdown($rate='rate_'.$value['userid'],$options);?>

</td></tr>

	<?php 
	$i++;
}

	?>
	<tr><td colspan="3" align="center"><?php echo form_submit('submit','OK');?></td></tr>

</table>
</form>
</center>