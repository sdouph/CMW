<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends CI_Controller {

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
	 * map to /index.php/welcome/					<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ($this->session->userdata('logged_in')){
			//$this->load->model('Accounts_model', 'accounts');
			$user = $this->session->userdata['currentUser'];
			$isManager = $this->session->userdata['currentManager'];
			//$data['accounts'] = $this->accounts->get_all_accounts($user, $isManager);
			$data['user'] = $user;
			$data['isManager'] = $isManager;

			$this->load->view('accounts_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function detail($id)
	{
		if ($this->session->userdata('logged_in')){
		
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Address_model', 'addresses');
			$this->load->model('Contacts_model', 'contacts');
			$detail = $this->accounts->get_account($id);
			$address = $this->addresses->get_address($detail[0]->ADDRESSID);
			$shipping = $this->addresses->get_address($detail[0]->SHIPPINGID);
			$data['accountid'] = $id;
			$data['account'] = $detail[0];
			$data['address'] = isset($address[0])?$address[0]:'';
			$data['shipping'] = isset($shipping[0])?$shipping[0]:'';
			$data['contacts'] = $this->contacts->get_contacts_byAccountID($id);
			$data['user'] = $this->session->userdata['currentUser'];			
			$this->load->view('account_detail_view', $data);
			
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	
	public function ajaxGrid()//$sidx, $sord, $page, $limit
	{
			$this->load->model('Accounts_model', 'accounts');
			$user = $this->session->userdata['currentUser'];
			$isManager = $this->session->userdata['currentManager'];

			$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
			$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
			$sidx = isset($_POST['sidx'])?$_POST['sidx']:'ACCOUNT'; // get index row - i.e. user click to sort
			$sord = isset($_POST['sord'])?$_POST['sord']:''; // get the direction
			$search = isset($_POST['_search'])?$_POST['_search']:'false';
			$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';

		if(!$sidx) $sidx =1;

	 
	 	if ($search == 'true'){
			$result =  $this->accounts->search_accounts_paginate($user,$isManager, $filters->rules, $sidx, $sord, $page, $limit);
			$resultCount = $this->accounts->get_accounts_count_byUser_search($user, $isManager, $filters->rules);
		}else{
			$result =  $this->accounts->get_all_accounts_paginate($user, $isManager, $sidx, $sord, $page, $limit);
			$resultCount = $this->accounts->get_accounts_count_byUser($user, $isManager);
		}

		if( $resultCount[0]->myCount  > 0 ) {
			$total_pages = ceil($resultCount[0]->myCount /$limit);    //calculating total number of pages
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
	 
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		$start = ($start<0)?0:$start;  // make sure that $start is not a negative value
	 
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}
			
	 
	 
		echo "<?xml version='1.0' encoding='utf-8'?>\n";
		echo "<rows>";
		echo "<page>".$page."</page>";
		echo "<total>".$total_pages."</total>";
		echo "<records>".$resultCount[0]->myCount ."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['ACCOUNTID']."'>";
			echo "<cell><![CDATA[".$row['ACCOUNT']."]]></cell>";
			echo "<cell><![CDATA[".$row['TYPE']."]]></cell>";
			echo "<cell><![CDATA[".phone_format($row['MAINPHONE'])."]]></cell>";
			echo "<cell><![CDATA[".mailto($row['EMAIL'])."]]></cell>";
			echo "<cell><![CDATA[".$row['SECCODEDESC']."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";

	//	echo json_encode($data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */