<?php 
if(! defined('BASEPATH')) exit('No direct access');
class controller extends CI_Controller
{
function __construct()
{
parent::__construct();
$this->load->database();
$this->load->model('model');
$this->load->helper('url');
$this->load->helper('form');
$this->log->no_cache();

}
public function index()
{                  $data['content']=$this->model->link();
                   $this->load->view('header');	
                   $this->load->view('login',$data);
                   $this->load->view('layout');
}
 public function logout()
 {

 	                $this->session->unset_userdata($newdata);
 	                $this->session->sess_destroy();
				          redirect('controller/login');
 }


 public function checkUser(){
 	                   //$a = $this->no_cache();
 	                   $userData = $this->session->all_userdata();

                	   echo "<pre>";
 	               //print_r($userData['loginStatus']) ;
 	                if (!$userData['loginStatus']) {
 		                    redirect('controller/logout');
 		                    return(0);
                      	}
 	                      else{
 		                    return(1);
                      	}
    
 }
 public function admin()
 {
                          if ($userData['user_type']!='admin') {
 		                      redirect('controller/logout');
 		                      return(0);
 		                      }	
 		                      else {
 			                    return(1);
 		                      }
 }
 

public function login()
{
                          $data['content']=$this->model->link();
                          $this->load->library('form_validation');
                          $this->form_validation->set_rules('username', 'username','required' );
		                      $this->form_validation->set_rules('password', 'password','required|min_length[5]|max_length[12]' );
		                     if($this->form_validation->run()== FALSE)
		                      {
                            $this->load->view('header');	
                            $this->load->view('login',$data);
                            $this->load->view('layout');
                          }
                          else
                          {
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                                //$userid=$_POST['userid'];

		                        if(isset($username))
		                           {
			                         $cond=array(
						                      "username"=>addslashes($username),
						                      "password"=>addslashes($password),
						                       //"userid"=>addslashes($userid),
				    	                       //"Login_Password"=>addslashes( md5($_POST['password']) )
				    	                       );
                                   $userData=$this->model->fetchRows("user",NULL,$cond,NULL);
//print_r($userData);

			                           if ($userData!=NULL )
			                    {
			                	        $newdata = array(
									                'username'  =>$userData[0]['username'],
			                            'password'=>$userData[0]['password'],
			                            'loginStatus'=>1,
			                            'user_type'=>$userData[0]['user_type'],
			                            'userid'=>$userData[0]['userid'],
			              	     	       );

				                         $this->session->set_userdata($newdata);
                                 $userData = $this->session->all_userdata();
                                 if ($userData['user_type']=='admin') {
 		                                redirect('controller/view');
 		                               }

                                 else
	                               $username = $_POST['username'];
                                 if(isset($username))
		                             {
			                               $cond=array(
						                         "username"=>addslashes($username),
						
						                       //"userid"=>addslashes($userid),
				    	                       //"Login_Password"=>addslashes( md5($_POST['password']) )
				                          	);
                                     $userData=$this->model->fetchRows("vote",NULL,$cond,NULL);
                                     //print_r($userData);

		                            	    if ($userData!=NULL )
		                             	     {
                                         redirect('controller/viewvote');
                                       }
                                       else
                                          redirect('controller/vote');	
                                 }
                            }
                                  else
                                      {
	                                      redirect('controller/login');
                                      }
                              }
                      }
 }
public function view()
{
                             //$c=$this->admin();
                             $r = $this->checkUser();
	
                             $table='user';
                             $fields = NULL;
                             $condition = NULL;

                             $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                             //print_r
                             $this->load->view('header');	
                             $this->load->view('list',$data);
                             $this->load->view('layout');
}
public function profile()
{
	                         $r = $this->checkUser();
	                         $id=$_GET['id'];
	
                             $table='user';
                             $fields = NULL;
                             $condition = array('userid'=>$id);

                             $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                             $this->load->view('header');	
                             $this->load->view('profile',$data);
                             $this->load->view('layout');
}
public function add()
{                       
                            $r = $this->checkUser();
                           // $this->load->view('header');        
                            $this->load->view('useradd');
                            $this->load->view('layout');
	                       //$upload=$this->do_upload();     
	                      
				                             //$this->load->view('header');
				                             ///redirect('controller/view');
				                             //$this->load->view('layout');
}
public function addsave()
{
  
  $r = $this->checkUser();


  $this->load->library('form_validation');
  $this->form_validation->set_rules('fullname', 'fullname','required' );
  $this->form_validation->set_rules('username', 'username', 'required');
  $this->form_validation->set_rules('password', 'password','required' );
  $this->form_validation->set_rules('emailid', 'emailid', 'required');
  $this->form_validation->set_rules('phone', 'phone', 'required');
  $this->form_validation->set_rules('user_type', 'user_type', 'required');
 //if (empty($_FILES['userfile']['name'])) {
    // $this->form_validation->set_rules('userfile[]', 'Document', 'required');
   //}
  if($this->form_validation->run()== FALSE)

  {

    $this->load->view('header');        
    $this->load->view('useradd');
    $this->load->view('layout');
  }
  else
  {

   $upload=$this->do_upload();

//print_r($upload);
    $condition=array('user_type'=>$_POST['user_type']);
    $table='user';
    $fields='id';
    $extra='id desc';
    $data['lists'] = $this->model-> fetchrows($table,$fields, $condition,$extra);
    // print_r($data); exit;
    //echo  $data[0]['id'];
    // exit;
    // $data['query'] = $this->model->id();
    //$ids = array();
    foreach($data as $value){
      $str = $value[0]['id'];
    }
    $a=substr($str,3,7);
    $b= ltrim($a,0);
    $new=$b+1;

    if($b==0)
    {
      $i=1;
    }
    else{
      $i=$new;
    }
    if($_POST['user_type']=='candidate')
    {
      $str = "CAN";
    }
    else
    {
      $str='USR';
    }

    $id= $str.str_pad($i,4,0,STR_PAD_LEFT);

    $entry_data = array(
    'fullname' => addslashes($_POST['fullname']),
    'username' => addslashes($_POST['username']),
    'password' =>addslashes($_POST['password']),
    'emailid' =>addslashes($_POST['emailid']),
    'phone' =>addslashes($_POST['phone']),
    'user_type' =>addslashes($_POST['user_type']),
   'image'=>addslashes($upload),
    'id'=>addslashes($id)
    );
    //print_r($entry_data);exit;
    $this->model->insertEntry("user",$entry_data);
    // print_r($entry_data);
    echo "success";

  }
}
public function edit()
{
                                        	
                                        	$r = $this->checkUser();
                                        	$id=$_GET['id'];
	
                                            $table='user';
                                            $fields = NULL;
                                            $condition = array('userid'=>$id);

                                            $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                                            $this->load->view('header');	
                                            $this->load->view('edit',$data);
                                            $this->load->view('layout');
}
public function userupdate()
{                
	                                   // $upload=$this->do_upload();
                                     // print_r($upload);
                                  
                                           $r = $this->checkUser();//print_r($_POST);exit;
                                           $this->load->library('form_validation');
                                           $this->form_validation->set_rules('fullname', 'fullname','required' );
                                           $this->form_validation->set_rules('username', 'username', 'required');
                                           $this->form_validation->set_rules('password', 'password','required' );
                                           $this->form_validation->set_rules('emailid', 'emailid', 'required');
                                           $this->form_validation->set_rules('phone', 'phone', 'required');
                                           $this->form_validation->set_rules('user_type', 'user_type', 'required');
                                           $this->form_validation->set_rules('img', 'image', 'required');
		                 //   if (empty($_FILES['image']['name'])) {
                         //  $this->form_validation->set_rules('image', 'Document', 'required');
                         //   }
		                                   if($this->form_validation->run()== FALSE)
		                                   {
                                            $this->load->view('header');
                                            $id=$_GET['id'];
                                            $table='user';
                                            $fields = NULL;
                                            $condition = array('userid'=>$id);

                                            $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                                            $this->load->view('header');	
                                            $this->load->view('edit',$data);
                                            $this->load->view('layout');		  	
                        
                           //$this->load->view('layout');
                                          }
                                           else
                                             {
                                              $upload=$this->do_upload();
                                              $id=$_GET['id'];
                                              //$upload=$this->do_upload();
                                              //echo $id;exit;print_r($_POST);exit;
                                              $cond = array('userid'=>$id);
                                            //$upload=$this->do_upload();
                                              $a=$upload;
                                             // print_r($upload);
                                              
                                                 if($upload==''){
                                                 	$a=$_POST['img'];
                                                 }
                                                 
                                              //print_r($a);
                                            // exit;
	                                          $entry_data = array(
		                                          'fullname' => addslashes($_POST['fullname']),
	               	                            'username' => addslashes($_POST['username']),
	                    	                      'password' =>addslashes($_POST['password']),
					                                    'emailid' =>addslashes($_POST['emailid']),
					                                    'phone' =>addslashes($_POST['phone']),
					                                    'user_type' =>addslashes($_POST['user_type']),
					                                    'image' =>addslashes($a)
		                                         	);
	                                         // echo '<pre>';
	                                        //  print_r($entry_data);exit;
		  				                                $userData=$this->model->updateEntry($entry_data,"user",$cond);
	                                            redirect('controller/view');
		  				                         
                           }                //}
}
public function delete()
{
                          $id=$_GET['id'];
                          $cond=array("userid"=>$id);
                          $this->model->deleteRows("user",$cond);
                          redirect('controller/view');
}
public function vote()
{
	                       $r = $this->checkUser();
	                       $table='user';
                         $fields = NULL;
                         $condition =array('user_type'=>'candidate') ;
                         $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                         $this->load->view('header');	
                         $this->load->view('voteform',$data);
                         $this->load->view('layout');
}
public function addvote()
{
                         $r = $this->checkUser();
                         $this->load->library('form_validation');
                         $this->form_validation->set_rules('vote', 'vote','required' );
                         if(isset($_POST['vote'])){
                         $this->form_validation->set_rules('rate_'.$_POST['vote'], 'Rating', 'required');
                         }

		                     if($this->form_validation->run()== FALSE)
		                       {
		  	                          $table='user';
                                  $fields = NULL;
                                  $condition =array('user_type'=>'candidate') ;
                                  $data['lists'] = $this->model->fetchRows($table,$fields,$condition);

                                  $this->load->view('header');		  	
                                  $this->load->view('voteform',$data);
                                  $this->load->view('layout');
                              }

                               else
	                            {
                               $table='user';
                               $fields = NULL;
                               $condition =array('user_type'=>'candidate') ;
                               $data['lists'] = $this->model->fetchRows($table,$fields,$condition);

		//_p$userid=$this->session->userData('userid');
 //echo "<pre>";
//print_r($_POST);
//exit();
				                                  $entry_data = array(
					                                   'candidateid' => addslashes($_POST['vote']),
					                                   'candidate_name' => addslashes($_POST['text_'.$_POST['vote']]),
	               	                           'username' => addslashes($this->session->userData('username')),
	                                           'userid'=>addslashes($this->session->userData('userid')),
	               	                           'vote' =>addslashes($_POST['vote']),	     
					                                   'rate' =>addslashes($_POST['rate_'.$_POST['vote']]),
					                                   'status'=>0
								        	                    );
	                                          
	                                           $this->model->insertEntry("vote",$entry_data);
				                                     $this->load->view('header');
			                                 //print_r($_POST);
				                                     redirect('controller/viewvote');
				                                     $this->load->view('layout');
			                                     }

}

public function viewvote()
{ 
 	                                      $r = $this->checkUser();
	                                      $userData = $this->session->all_userdata();
                                        $table='vote';
                                        $fields = NULL;
                                        $condition = array('username'=>$this->session->userData('username'));
                                        $data['vote'] = $this->model->fetchRows($table,$fields,$condition);
                                        $this->load->view('header');	
                                        $this->load->view('viewvote',$data);
                                        $this->load->view('layout');
}
public function update()
{
	                                    $cond=NULL;
	                                    $entry_data = array(
		                                 'status' => 1
		                                	);

		  				                        $userData=$this->model->updateEntry($entry_data,"vote",$cond);
	                                    redirect('controller/status');
}
public function status()
{
	                                    //$r = $this->checkUser();
                                        $data['query']=$this->model->status();
                                        //$table='vote';
                                        //$fields = NULL;
                                        //$condition=NULL;
                                        //$data['view'] = $this->model->fetchRows($table,$fields,$condition);
                      	               $this->load->view('header');		  	
                                       $this->load->view('status',$data);
                                       $this->load->view('layout');
}
public function search()
{                                  
                                      // $keyword=$_POST['keyword'];
                                      //  $data['search']= $this->model->search();
                                     //  $this->load->view('search');       
                                      
   
 $this->load->view('search');
                               $table='user';
                               $fields = 'username';
                               
                               $data['lists'] = $this->model->fetchRows($table,$fields);
                               

}
public function searchlist($w =NULL)
{  
   
    // $a = array("PHp","AppleScript","Asp","BASIC","C","Apple");
     $vnames= array();
     //echo json_encode($a);
    //die();
     $table='user';
                               $fields = 'username';
                               
                               $data['lists'] = $this->model->fetchRows($table,$fields);
   

      
     foreach ($data as $value) {
    
      $a=count($value);
      for($i=0;$i<$a;$i++){
            $vnames[] = $value[$i]['username']."\n";
            
    }echo json_encode($vnames);
    
   // echo json_encode($vnames);
}
}


public function do_upload()
 {
                      
 $name_array = array();
 echo '<pre>';

 print_r($_POST);

 //print_r($_FILES); 


$name_array = array();
$count = count($_FILES['userfile']['size']);
foreach($_FILES as $key=>$value)
for($s=0; $s<=$count-1; $s++) {
$_FILES['userfile']['name']=$value['name'][$s];
$_FILES['userfile']['type']    = $value['type'][$s];
$_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
$_FILES['userfile']['error']       = $value['error'][$s];
$_FILES['userfile']['size']    = $value['size'][$s];  
    $config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png';
$config['max_size'] = '100';
$config['max_width']  = '1024';
$config['max_height']  = '768';
$this->load->library('upload', $config);
$this->upload->do_upload();
$data = $this->upload->data();
$name_array[] = $data['file_name'];
}
$image= implode(',', $name_array);

 print_r($image);
return $image;
//echo $image;
//print_r($image) ;


}
}
?>