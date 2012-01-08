<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Controller {

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
	public function index($user)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('History_model', 'history');
			if ($type == 'account'){
				$data['history'] = $this->history->get_all_history_account($id);
				$account = $this->accounts->get_account($id);
				$data['account'] = $account[0]->ACCOUNT;
				$this->load->view('history_view', $data);
			}else if ($type == 'contact'){
				$data['history'] = $this->history->get_all_history_contact($id);
				$this->load->view('history_contact_view', $data);
			}
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function byAccount($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('History_model', 'history');
			$data['history'] = $this->history->get_all_history_account($id);
			$account = $this->accounts->get_account($id);
			$data['account'] = $account[0]->ACCOUNT;
			$data['accountid'] = $id;
			$this->load->view('history_account_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function byContact($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Contacts_model', 'contacts');
			$this->load->model('History_model', 'history');
			$contact = $this->contacts->get_contact($id);
			$data['contact'] = $contact[0];
			$data['history'] = $this->history->get_all_history_contact($id);

			$this->load->view('history_contact_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	
	public function ajaxGridByAccount($account)//$sidx, $sord, $page, $limit
	{
			$this->load->model('History_model', 'history');
			$user = $this->session->userdata['username'];

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'ORIGINALDATE'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'DESC'; // get the direction 
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';

		if(!$sidx) $sidx =1;

	 
	 	if ($search == 'true'){
			$result =  $this->history->search_history_byAccount_paginate($account, $filters->rules, $sidx, $sord, $page, $limit);
			$resultCount = $this->history->get_history_count_byAccount_search($account, $filters->rules);
		}else{
			$result =  $this->history->get_history_byAccount_paginate($account, $sidx, $sord, $page, $limit);
			$resultCount = $this->history->get_history_count_byAccount($account);
		}
	 
	 
		if( $resultCount[0]->myCount > 0 ) {
			$total_pages = ceil($resultCount[0]->myCount/$limit);    //calculating total number of pages
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
	 
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}
		$et = ">";
	 
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>".$page."</page>";
		echo "<total>".$total_pages."</total>";
		echo "<records>".$resultCount[0]->myCount."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['HISTORYID']."'>";
			echo "<cell><![CDATA[".mssql_date_fix($row['ORIGINALDATE'])."]]></cell>";
			echo "<cell><![CDATA[".$row['CONTACTNAME']."]]></cell>";
			echo "<cell><![CDATA[".$row['DESCRIPTION']."]]></cell>";
			echo "<cell><![CDATA[".$row['LONGNOTES']."]]></cell>";
			echo "<cell><![CDATA[".$row['USERNAME']."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";


	//	echo json_encode($data);

	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */