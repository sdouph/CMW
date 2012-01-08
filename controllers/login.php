<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 *
	 */
	 
	public function index()
	{
	 	 $myPass = "cmw";
		$this->load->model('Users_model', 'users');
		$user = $this->input->post('username');
		if ($user &&  $this->input->post('password') == $myPass){
			$userinfo = $this->users->get_user($user);
			$myinfo = $userinfo[0];
			$userdata = array(
						'userID'	=> $userinfo[0]->USERID,
					   'username'  => $user,
					   'usernameFull' =>  $userinfo[0]->USERNAME,
					   'isManager' =>  $this->users->isManager($user),
					   'email' =>  $userinfo[0]->EMAIL,
					   'currentUser' =>  $user,
					   'currentManager' =>  $this->users->isManager($user),
					   'logged_in' => TRUE
				   );
	
			$this->session->set_userdata($userdata);
			
		//	if ($this->input->post('location')){
		//		redirect(prep_url($this->input->post('location')));
		//	}else{
				redirect(prep_url(site_url()));
		//	}
		}else if ($user &&  $this->input->post('password') != $myPass){
			$this->load->model('Users_model', 'users');
			$data['users'] = $this->users->get_all_users();
			$data['userCount'] = $this->users->user_count();
			$data['location'] = $this->session->flashdata('location');
			$data['pass'] = false;
			$this->load->view('login_view', $data);
		}else{
			$this->load->model('Users_model', 'users');
			$data['users'] = $this->users->get_all_users();
			$data['userCount'] = $this->users->user_count();
			$data['location'] = $this->session->flashdata('location');
			$data['pass'] = true;
			$this->load->view('login_view', $data);
		}
	}
	

}

