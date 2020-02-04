<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Auto Complete Input box</title>


    
    <link rel="stylesheet" href="<?=base_url();?>css/jquery.ui.all.css">
    <script src="<?=base_url();?>js/jquery-1.8.3.js"></script>
    <script src="<?=base_url();?>js/ui/jquery.ui.core.js"></script>
    <script src="<?=base_url();?>js/ui/jquery.ui.widget.js"></script>
    <script src="<?=base_url();?>js/ui/jquery.ui.position.js"></script>
    <script src="<?=base_url();?>js/ui/jquery.ui.menu.js"></script>
    <script src="<?=base_url();?>js/ui/jquery.ui.autocomplete.js"></script>    
    
    
<script>
$(document).ready(function(){
    autocompletefn();
   // $(".person").autocomplete( "search", "" );
    
//    $('.person').click(function() {
//        $('#autocomplete').trigger("focus"); //or "click", at least one should work
//    });
    
    $('.addbtn').live("click",function() {
        $(this).remove();
        
        $("#persons").append('<div><label>Person:</label><input name="tag1" type="text"  class="person" size="20"/><button class="removebtn">-</button> <button class="addbtn">+</button></div>');
        autocompletefn();
    });    
    
    $(".removebtn").live("click",function() {
        $( this ).parent().remove();
        
        if($('.addbtn').length==0){
            $("#persons div").last().append('<button class="addbtn">+</button>');
        }        
    });    
});
    
function autocompletefn(){
     var availableTags = [
        "MongoDB",
        "ExpressJS",
        "Angular",
        "NodeJS",
        "JavaScript",                
        "jQuery",
        "jQuery UI",
        "PHP",
        "Zend Framework",
        "JSON",
        "MySQL",
        "PostgreSQL",
        "SQL Server",
        "Oracle",
        "Informix",
        "Java",
        "Visual basic",
        "Yii",
        "Technology",
        "WilzonMB.com"
    ];
   $( ".person" ).autocomplete({
                source: availableTags ,
                minLength: 0
            }).focus(function(){ 
                $(this).data("autocomplete").search($(this).val());
            });
    
}    
</script>
</head>
<body>
    <div id="persons">
         <div> 
          <label>Person:</label>
          <input name="tag" type="text" id="tag1" class='person' size="20"/> 
             <button class="addbtn">+</button>  
         </div>
        
    </div>
    
</body>
</html>