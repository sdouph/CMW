<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Users_model', 'users');
			$data['users'] = $this->users->get_all_users();
			$data['userCount'] = $this->users->user_count();
		
			$this->load->view('users', $data);
		}else{
			$this->session->set_flashdata('location', current_url());
			redirect(prep_url(site_url('login')));
		}

	}
	
}

