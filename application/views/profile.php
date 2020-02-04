
<center>	<table>
		<?php foreach($lists as $value)
		{
			?>
	
		
		<tr>


<tr><td></td><td><?php
	//print_r($value['image']);

	$str=$value['image'];
	($data['img']=(explode(',',$str)));
			 foreach($data as $va){
	// for($i=0;$i>=0;$i++){
$a= count($va);
	

		for($i=0;$i<$a;$i++)
{
  $st = $va[$i];
 
?>
<img src="<?php echo base_url("/uploads/".$st);?>" width="50" height="50"/>

<?php
}
}

?></td></tr>
	<td>Fullname</td><td><?php echo $value['fullname'];?></td></tr>
	<tr><td>Username:</td><td><?php echo  $value['username'];?></td></tr>
	<tr><td>Password:</td><td><?php echo  $value['password'];?></td></tr>
		<tr><td>Email Id:</td><td><?php echo  $value['emailid'];?></td></tr>
			<tr><td>Phone:</td><td><?php echo  $value['phone'];?></td></tr>
			<tr><td>Uset type:</td><td><?php echo $value['user_type'];?></td></tr>
			<tr><td>Id:</td><td><?php echo $value['id'];?></td></tr>
            
<?php
}
?>

	
</table>

</center>