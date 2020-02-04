




<?php //echo anchor('controller/add','Add User and Candidate');?>
<a href="<?=base_url();?>controller/search">Search</a>
<a href="<?=base_url();?>controller/add">Add user and candidate</a>
<a href="<?=base_url();?>controller/update">Publish List</a>
<center><table><tr><th>User Id</th><th>Fullname</th><th>Username</th><th>Password</th>
	<th>Email Id</th><th>Phone</th><th>User type</th><th>Code</th><th>Image</th><th></th><th></th><th></th></tr>
<tr><?php 
foreach ($lists as  $value)
 {
 	?>
 	<td><?php echo $value['userid'];?></td>
	<td><?php echo $value['fullname'];?></td>
<td><?php echo $value['username'];?></td>
<td><?php echo $value['password'];?></td>
<td><?php echo $value['emailid'];?></td>
<td><?php echo $value['phone'];?></td>
<td><?php echo $value['user_type'];?></td>
<td><?php echo $value['id'];?></td>
<td>

	<?php
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
?>
 </td>
<td><a href="<?=base_url();?>controller/edit?id=<?php echo $value['userid'];?>">Edit</a></td>
<td><a href="<?=base_url();?>controller/delete?id=<?php echo $value['userid'];?>">Delete</a></td>
<td><a href="https://gmail.com">Mail</a></td></tr>
<?php
}
?>
</table></center>