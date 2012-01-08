<?php class Web_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //Get the status which is array
        $login_status = $this->check_login();
		
		if (!$login_status->loggedIn){
			redirect(/login);
		}else{
	
			//Send it to the views, it will be available everywhere
	
			//The "load" refers to the CI_Loader library and vars is the method from that library.
			//This means that $login_status which you previously set will be available in your views as $loginstatus since the array key below is called loginstatus.
			$this->load->vars(array('loginstatus' => $login_status));
		}
    }

    protected function check_login()
    {
          $session = $this->session->userdata('login_state'); 

            $default = "Log In";

            if ($session == 1) 
            {
                $url = site_url('index.php/users/logout'); 
                $status = "Log Out";



            } 
            else 
            {
                $url = site_url('index.php/users/login'); 
                $status = $default;
            }

        $loginstatus = array(
                        "url" => $url,
                        "status" => $status 
                        );

        return $loginstatus;
    }
}

?>