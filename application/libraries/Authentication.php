<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication {

	private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->CI->load->library('session');
    }
    /** Clear the old cache (usage optional) **/ 
	public function no_cache()
	{
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache'); 
	}
	//function no_cache ends here

	public function check_login($user_type = NULL)
	{
		
		if( 
			($this->CI->session->userdata('username')  && 
			($this->CI->session->userdata('role')=='admin')) || 
			($this->CI->session->userdata('role')=='user')
		)	
		{ }
		else
		{
			redirect('login/logout');
			exit();
    	}	 
	}

	public function getUserDetails()
	{
		foreach ($this->CI->session->userdata as $user_data => $value) {

			$user[$user_data] = $value; 
		}
		return $user;
	}
	
}

/* End of file Someclass.php */