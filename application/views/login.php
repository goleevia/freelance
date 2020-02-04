<script type="text/javascript">
function msglgth()
{

var password=document.login.password.value;
var a=document.getElementById('password').innerHTML='minimum 5 charecters : '+password.length;
			if(password.length > 5 && password.length < 50) {

				document.getElementById('password').style.color="blue";
				}
                                    else {
					document.getElementById('password').style.color="red";
					}



}

</script>
<?php //echo anchor('base_url()controller/status','View Status of the Candidates');
foreach($content as $value)
{


	if($value->status==1)
	{	
	?>
<a href="<?=base_url();?>controller/status">View Status of the Candidates</a>
<?php 
}
}
?>

<center><h1>Login</h2>
<?php //echo form_open('controller/login');
//echo validation_errors();?>

<form name="login" method="post" action="<?=base_url();?>controller/login">
<table>
<tr><td>Username:</td><td><?php echo form_input('username');?></td>
<td><?php echo form_error('username');?></td></tr>
<tr><td>Password:</td><td><input type="password" name="password" value="" onkeyup="msglgth()"></td><td><?php
 echo form_error('password');?></td><td><div id="password"></div></td></tr>
<tr><td colspan="2" align="center">

	<?php //echo form_submit('submit','Login');?>
	<input type="submit" name="submit" value="Login" onClick="return submitvalidation()"/>


</td></tr>
</table>
</form>
</center>