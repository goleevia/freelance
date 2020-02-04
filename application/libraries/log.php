
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log {

	private $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
		$this->CI->load->library('session');
    }

    public function no_cache()
	{
		                  header('Cache-Control: no-store, no-cache, must-revalidate');
		                  header('Cache-Control: post-check=0, pre-check=0',false);
		                  header('Pragma: no-cache'); 
	}





}
   