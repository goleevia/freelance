<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewmanager {

	private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->library('authentication');

    }
    /** Clear the old cache (usage optional) **/ 

	public function loadView($page_view , $data , $extra = NULL) 
	{
		/*echo "<pre>"; print_r($page_view); print_r($data);

		$base_url = $this->CI->config->item('base_url');

		print_r($base_url);

		 exit(); */

		 $base_url = $this->CI->config->item('base_url');

		 $this->CI->session->breadCrumList  = array('Dashboard' => 'dashboard');

		$data['base_url'] = $base_url ; 
		$data['base_url_main'] = $base_url."../" ;

		$data['userDetails'] = $this->CI->authentication->getUserDetails();
		
		$data['page_title'] = 'Dashboard' ;

		$data['breadCrumList'] = $this->getBreadCrums() ;
		

		$this->CI->load->view('include/header',$data);
		$this->CI->load->view('include/slidingbar',$data);
		$this->CI->load->view('include/topbar',$data);
		$this->CI->load->view('include/pageslideleft',$data);
		$this->CI->load->view('include/pageslideright',$data);
		$this->CI->load->view('include/maincontainer',$data);

		$this->CI->load->view($page_view, $data);
		
		if($extra){
			$this->CI->load->view($extra, $data);
		}

		$this->CI->load->view('include/footer',$data);

	}


	public function getBreadCrums()
	{
		foreach ($this->CI->session->breadCrumList as $breadCrumItem => $value) {

			$breadCrums[$breadCrumItem] = $value; 
		}
		return $breadCrums;
	}
}

/* End of file Someclass.php */