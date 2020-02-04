<style type="text/css">
.req{color:red}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
$('#submit').click(function() {
   // alert('in ajax post');
    $.post('<?=base_url();?>controller/addsave',
    $('#forme').serialize()).done(function(data){
        alert(data);
           });  
        }); 

    
});

 // $.post("<?=base_url();?>controller/addsave",
 // $("#submit").serialize()).done(function(s){  
 // location.reload(true); });

function validation()
{
     var fullname=document.add.fullname.value;
     var username=document.add.username.value;
     var password=document.add.password.value;
     var emailid=document.add.emailid.value;
     var phone=document.add.phone.value;
     var user_type=document.add.user_type.value;
     //var userfile[]=document.add.userfile[].value;
     var flg=0;
    if(fullname=='')
    {
        flg=1;
    document.getElementById('fullname').innerHTML="Please enter fullname";
}
 if(username=='')
    {
        flg=1;
    document.getElementById('username').innerHTML="Please enter username";
}
if(password=='')
    {
        flg=1;
    document.getElementById('password').innerHTML="Please enter password";
}
if(emailid=='')
    {
        flg=1;
    document.getElementById('emailid').innerHTML="Please enter emailid";
}
if(phone=='')
    {
        flg=1;
    document.getElementById('phone').innerHTML="Please enter phone";
}
if(user_type=='')
    {
        flg=1;
    document.getElementById('user_type').innerHTML="Please enter user_type";
}

if(flg==0)
{
return true;
}
else
{

return false;
}

}
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


<?php //echo anchor('controller/view','Back');?>
<a href="<?=base_url();?>controller/view">Back</a>
<center><h1>USER ADD</h1>
   <form action="#" name="add" method="post" id="forme" enctype="multipart/form-data">
<?php //echo form_open_multipart('controller/add');
//echo validation_errors();
?>
<table>
	        <tr><td>Fullname:</td>
		    <td><span class="req"><?php echo form_error('fullname');?><div id="fullname"></span></div>
            <?php echo form_input('fullname');?></td></tr>
	        <tr><td>Username:</td>
		    <td><span class="req"><?php echo form_error('username');?><div id="username"></div></span>
            <?php echo form_input('username');?></td></tr></tr>
            <tr><td>Password:</td>
		    <td><span class="req"><?php echo form_error('password');?><div id="password"></div></span>
            <?php echo form_password('password');?></td></tr>

            <tr><td>Email Id:</td>
			<td><span class="req"><?php echo form_error('emailid');?><div id="emailid"></div></span>
                <?php echo form_input('emailid');?></td></tr>
			 <tr><td>Phone:</td>
			<td><span class="req"><?php echo form_error('phone');?><div id="phone"></div></span>
                <?php echo form_input('phone');?></td>
			</tr>
			<tr><td>User Type:</td>
				<td><span class="req"><?php echo form_error('user_type');?><div id="user_type"></div></span><?php 
                $options=array(''=>'select','user'=>'user','candidate'=>'candidate');
                echo form_dropdown('user_type',$options);?></td>
             </tr>
             </tr> <td>Image:</td> <td><input id="files" type="file" name="userfile[]" multiple/></td><td><?php   //echo form_error('image');?></td></tr>
                <tr><td colspan="2" align="center"><?php //echo form_submit('submit','Add'); ?>
                <input type="button" name="submit" value="Add" id="submit" onClick="return validation()"/ >
            </td><td><output id="result" /></td></tr>
</table>
</form></center>
