<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 *
	 */
	public function index()
	{
	
		$userdata = array(
				'userID'	=> '',
				'username'  => '',
				'usernameFull' =>  '',
				'isManager' =>  FALSE,
				'email' => '',
				'currentUser' =>  '',
				'currentManager' =>  FALSE,
				'logged_in' => FALSE

	   );
	
			$this->session->set_userdata($userdata);		

		//$this->load->view('logout_view');
		redirect("/login");
	}
}
	

