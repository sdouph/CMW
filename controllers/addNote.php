<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddNote extends CI_Controller {

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
			$this->load->model('MasterNote_model', 'masterNotes');
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Visit_model', 'visits');
			$this->load->model('Complaint_model', 'complaints');
			$data['visits'] = $this->visits->get_visit_cats();
			$data['complaints'] = $this->complaints->get_complaint_cats();
			//$account = $this->accounts->get_account($id);
			//$data['account'] = $account[0]->ACCOUNT;
			$this->load->view('addNote_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	
	public function byAccount($id)
	{
		if ($this->session->userdata('logged_in')){
			$account = $this->input->post('accountid');
			if ($account){
				$this->load->model('MasterNote_model', 'masterNotes');
				$this->load->model('Visit_model', 'visits');
				
				$noteID = $this->masterNotes->addNote($account, $this->input->post('date'), $this->input->post('note'), $this->session->userdata['userID']);
				
				foreach($this->input->post() AS $key => $value):
					$type = explode("-", $key);
					if ($type[0] == "visit" && $value == true){
						$this->visits->addVisit($noteID, $type[1], $account);
					}
				endforeach;
				redirect(prep_url(site_url('visit/byAccount/'.$id)));
			}else{
				$this->load->model('Accounts_model', 'accounts');
				$this->load->model('Visit_model', 'visits');
				$this->load->model('MasterNote_model', 'masterNotes');
				$data['visits'] = $this->visits->get_visit_cats();
				$data['complaints'] = $this->visits->get_complaint_cats();
				$account = $this->accounts->get_account($id);
				$data['account'] = $account[0];

				$myDate = $this->masterNotes->get_note_byDate(mdate("%Y-%m-%d"), $data['account']->ACCOUNTID);
				//Check to see if date already exists with data
				if(sizeof($myDate)==0){
					$this->load->view('addNote_view', $data);
				}else{
					redirect(prep_url(site_url('addNote/edit/'.$myDate[0]->MASTERNOTEID)));
				}
			}
			
			
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function getExisting(){
		$this->load->model('MasterNote_model', 'masterNotes');
		$myDate = $this->masterNotes->get_note_byDate($this->input->post('date'), $this->input->post('accountid'));

		if (isset($myDate[0]->MASTERNOTEID)){
			//redirect(prep_url(site_url('addNote/edit/'.$myDate[0]->MASTERNOTEID)));
			echo $myDate[0]->MASTERNOTEID;
		}
	}
	
	public function byContact($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Visit_model', 'visits');
			$this->load->model('Complaint_model', 'complaints');
			$data['visits'] = $this->visits->get_visit_cats();
			$data['complaints'] = $this->complaints->get_complaint_cats();
			$account = $this->accounts->get_account($id);
			$data['account'] = $account[0]->ACCOUNT;
			$this->load->view('addNote_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function edit($id)
	{
		if ($this->session->userdata('logged_in')){
			$account = $this->input->post('accountid');
			if ($account){
				$this->load->model('MasterNote_model', 'masterNotes');
				$this->load->model('Visit_model', 'visits');
				
				$this->masterNotes->updateNote($id, $this->input->post('note'));
				$this->visits->deleteByMaster($id);
				//$this->complaints->deleteByMaster($id);
				
				foreach($this->input->post() AS $key => $value):
					$type = explode("-", $key);
					if ($type[0] == "visit" && $value == true){
						$this->visits->addVisit($id, $type[1], $account);
					}
				endforeach;
				redirect(prep_url(site_url('visit/byAccount/'.$account)));
				
			}else{
				$this->load->model('Accounts_model', 'accounts');
				$this->load->model('MasterNote_model', 'masterNote');
				$this->load->model('Visit_model', 'visits');
				$masters = $this->masterNote->get_note($id);
				$data['masterNote'] = $masters[0];
				$data['visits'] = $this->visits->get_visits_byMaster($id);
//				$data['complaints'] = $this->visits->get_complaints_byMaster($id);
				$data['allVisits'] = $this->visits->get_visit_cats();
				$data['allComplaints'] = $this->visits->get_complaint_cats();
				$account = $this->accounts->get_account($data['masterNote']->ACCOUNTID);
				$data['account'] = $account[0];
				$this->load->view('editNote_view', $data);
			}
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function delete ($id, $account)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('MasterNote_model', 'masterNotes');
			$this->load->model('Visit_model', 'visits');
			$this->masterNotes->deleteNote($id);
			$this->visits->deleteByMaster($id);
			redirect(prep_url(site_url('visit/byAccount/'.$account)));
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
}

/* End of file welcome.php */
																																																																																			/* Location: ./applicati	on/controllers/welcome.php */