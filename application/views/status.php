<?php //echo anchor('controller/login','Back');?>
<!--<a href="<?=base_url();?>controller/login">Back</a>-->
<center><h1>Current Status</h1>
		<table border="0" cellpaddig="5" cellspacing="5">
	<tr><th>Candidate name</th><th></th><th>votes</th><th>Rate</th></tr>
	<tr>
<?php 
//print_r($query);
//print_r($lists);?>
	
<?php foreach($query as $value){
?>
<td><?php echo $value->candidate_name;?>
</td>
<td></td	>
<td><?php echo $value->id;?>
</td>
<td><?php echo $value->rate;?>
</td>
</tr>
<?php
}
?>
</table>
</center>