<script type="text/javascript">
window.onload = function(){
        
    //Check File API support
    if(window.File && window.FileList && window.FileReader)
    {
        var filesInput = document.getElementById("files");
        
        filesInput.addEventListener("change", function(event){
            
            var files = event.target.files; //FileList object
            var output = document.getElementById("result");
            
            for(var i = 0; i< files.length; i++)
            {
                var file = files[i];
                
                //Only pics
                if(!file.type.match('image'))
                  continue;
                
                var picReader = new FileReader();
                
                picReader.addEventListener("load",function(event){
                    
                    var picFile = event.target;
                    
                    var div = document.createElement("div");
                    
                    div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                            "title='" + picFile.name + "'/>";
                    
                    output.insertBefore(div,null);            
                
                });
                
                 //Read the image
                picReader.readAsDataURL(file);
            }                               
           
        });
    }
    else
    {
        console.log("Your browser does not support File API");
    }
}
    
</script>


<center><h1>Edit User</h1>
	<?php foreach($lists as $value)
		{
			?>
<form name="edit" method="post" action="<?=base_url();?>controller/userupdate?id=<?php echo $value['userid'];?>" enctype="multipart/form-data">
	<table>
		
		<tr>


<tr><td><?php echo validation_errors();?></td></tr>
	<td>Fullname</td><td><input type="text" name="fullname" value="<?php echo $value['fullname'];?>">
</td><td><?php //echo form_error('fullname');?></td></tr>
	<tr><td>Username:</td><td><input type="text" name="username" value="<?php echo  $value['username'];?>"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="password" value="<?php echo  $value['password'];?>"></td></tr>
		<tr><td>Email Id:</td><td><input type="text" name="emailid" value="<?php echo  $value['emailid'];?>"></td></tr>
			<tr><td>Phone:</td><td><input type="text" name="phone" value="<?php echo  $value['phone'];?>"></td></tr>
			<tr><td>Uset type:</td><td><?php 
                $options=array(''=>'select','user'=>'user','candidate'=>'candidate');
                echo form_dropdown('user_type',$options,$value['user_type']);?></td>
             <td><?php   echo form_error('user_type');?></td><tr><td>Image</td>
             <td><input type="file" id="files" name="userfile[]"   value="<?php echo base_url("/uploads/".$value['image']);?>" multiple/>

	<input type="hidden" name="img" value="<?php echo $value['image'];?>">
	<?php
//}

?>
             </td>
             <td>	<?php 
             $str=$value['image'];
	($data['img']=(explode(',',$str)));
			 foreach($data as $va){
	// for($i=0;$i>=0;$i++){
$a= count($va);
	

		for($i=0;$i<$a;$i++)
{
  $st = $va[$i];
 
?>
<img src="<?php echo base_url("/uploads/".$st);?>" width="50" height="50" alt=""/>

<?php
}
}?></td>
             <td></td></tr></tr>
             <tr><td colspan="2" align="center"><input type="submit" value="Update"></td></tr>
             <tr><td><output id="result" /></td></tr>
<?php
}
?>

	
</table>
</form>	
</center>