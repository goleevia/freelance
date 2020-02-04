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

}
public function index()
{
                   $this->load->view('header');	
                   $this->load->view('login');
                   $this->load->view('layout');
}
 public function logout()
 {

 	                //$this->session->unset_userdata($newdata);
 	                $this->session->sess_destroy();
				    redirect('controller/login');
 }

public function no_cache()
	{
		           header('Cache-Control: no-store, no-cache, must-revalidate');
		           header('Cache-Control: post-check=0, pre-check=0',false);
		           header('Pragma: no-cache'); 
	}

 public function checkUser(){
 	                $a = $this->no_cache();
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

                          $data['data']=$this->model->link();
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
	                       //$upload=$this->do_upload();
     
	                        $r = $this->checkUser();
                            $this->load->library('form_validation');
                            $this->form_validation->set_rules('fullname', 'fullname','required' );
		                    $this->form_validation->set_rules('username', 'username', 'required');
		                    $this->form_validation->set_rules('password', 'password','required' );
		                    $this->form_validation->set_rules('emailid', 'emailid', 'required');
		                    $this->form_validation->set_rules('phone', 'phone', 'required');
		                    $this->form_validation->set_rules('user_type', 'user_type', 'required');
		                   if (empty($_FILES['image']['name'])) {
                           $this->form_validation->set_rules('image', 'Document', 'required');
                            }
		 		          if($this->form_validation->run()== FALSE)
		                  {

                          //$data['content']=
                           $this->load->view('header');		  	
                           $this->load->view('useradd');
                           $this->load->view('layout');
                         }
                         else{
	                          $upload=$this->do_upload();
                              print_r($upload);
			               	  $entry_data = array(
					                          'fullname' => addslashes($_POST['fullname']),
	                                	      'username' => addslashes($_POST['username']),
	               	                          'password' =>addslashes($_POST['password']),
					                          'emailid' =>addslashes($_POST['emailid']),
					                          'phone' =>addslashes($_POST['phone']),
					                          'user_type' =>addslashes($_POST['user_type']),
                                              'image'=>addslashes($upload)
				                               // 'image'=>addslashes($image)
					                        );
	                                       $this->model->insertEntry("user",$entry_data);
	                                        // print_r($entry_data);
	        
				                           $this->load->view('header');
				                           redirect('controller/view');
				                           $this->load->view('layout');
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
	                                       //$upload=$this->do_upload();

                                           $r = $this->checkUser();//print_r($_POST);exit;
                                           /*//$this->load->library('form_validation');
                                           //$this->form_validation->set_rules('fullname', 'fullname','required' );
		                                   $this->form_validation->set_rules('username', 'username', 'required');
		                                   $this->form_validation->set_rules('password', 'password','required' );
		                                   $this->form_validation->set_rules('emailid', 'emailid', 'required');
		                                   $this->form_validation->set_rules('phone', 'phone', 'required');
		                                   $this->form_validation->set_rules('user_type', 'user_type', 'required');
		                                   $this->form_validation->set_rules('image', 'document', 'required');
		                                   
		                                   if($this->form_validation->run()== FALSE)
		                                   {
                                           $id=$_GET['id'];
	
                                            $table='user';
                                            $fields = NULL;
                                            $condition = array('userid'=>$id);

                                            $data['lists'] = $this->model->fetchRows($table,$fields,$condition);
                                            $this->load->view('header');	
                                            $this->load->view('edit',$data);
                                            $this->load->view('layout');
                                          }
                                          else
                                            {*/
 $this->load->library('form_validation');
                            $this->form_validation->set_rules('fullname', 'fullname','required' );
		                    $this->form_validation->set_rules('username', 'username', 'required');
		                    $this->form_validation->set_rules('password', 'password','required' );
		                    $this->form_validation->set_rules('emailid', 'emailid', 'required');
		                    $this->form_validation->set_rules('phone', 'phone', 'required');
		                    $this->form_validation->set_rules('user_type', 'user_type', 'required');
		                   if (empty($_FILES['image']['name'])) {
                           $this->form_validation->set_rules('image', 'Document', 'required');
                            }
		 		          if($this->form_validation->run()== FALSE)
		                  {

                          //$data['content']=
                           $this->load->view('header');		  	
                           redirect('controller/edit');
                           $this->load->view('layout');
                         }
                         else{





                                              $id=$_GET['id'];
                                              //echo $id;exit;print_r($_POST);exit;
                                              $cond = array('userid'=>$id);
                                              $upload=$this->do_upload();
                                             // print_r($upload);
	                                          $entry_data = array(
		                                      'fullname' => addslashes($_POST['fullname']),
	               	                          'username' => addslashes($_POST['username']),
	                    	                  'password' =>addslashes($_POST['password']),
					                          'emailid' =>addslashes($_POST['emailid']),
					                          'phone' =>addslashes($_POST['phone']),
					                          'user_type' =>addslashes($_POST['user_type']),
					                          'image' =>addslashes($upload)
		                                     	);
	                                         // echo '<pre>';
	                                          //print_r($entry_data);exit;
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
public function do_upload()
{
		                    
		                              if (!empty($_FILES['image']['name'])) {
                                          $config['upload_path'] = './uploads/';
                                          $config['allowed_types'] = 'gif|jpg|png';
                                          $config['max_size'] = '1000';
                                          $config['max_width'] = '10240';
                                          $config['max_height'] = '7680';
                                          $this->load->library('upload', $config);//print_r($_FILES);exit;

                                     if (!$this->upload->do_upload('image')) {
                                         $error = array('error' => $this->upload->display_errors());
                                         $this->form_validation->set_message('image', $this->upload->display_errors());
                                         $this->load->view('header');		  	
                                         $this->load->view('useradd');
                                         $this->load->view('layout');      
                                        } 
                                              else {
                                                     $upload_data = $this->upload->data();
                                                     $image =$upload_data['file_name'];
                                                     return $image;
                                                     //print_r($image);

    		//_p$userid=$this->session->userData('userid');
 //echo "<pre>";
//print_r($_POST);
//exit();
				/*$entry_data = array(
					'image' => addslashes($upload_data['file_name']),
														 );
	            $this->model->insertEntry("user",$entry_data);*/
                                               }
                                  	}
	   
                         }
}
?>


<!--$userData = $this->session->all_userdata();

$userData['user_type'] = 'user'

$this->session->set_userdata($userData);-->