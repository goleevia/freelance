<?php foreach($vote as $value)
{
	
?>

<a href="<?=base_url();?>controller/profile?id=<?php echo $value['userid'];?>">View profile</a>

<center><table cellpadding="10" cellspacing="10">



<tr><th >Candidate name:</th><td><?php echo $value['candidate_name'];?></td></tr>
<tr><th>Rate:</th><td><?php echo $value['rate'];?></td></tr>
	<?php
}?>

</table></center>