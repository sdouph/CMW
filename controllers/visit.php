<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visit extends CI_Controller {

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
	public function index($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Visit_model', 'visits');
			$data['visits'] = $this->visits->get_all_visits($id);
			$data['visitCats'] = $this->visits->get_visit_cats();
			$account = $this->accounts->get_account($id);
			$data['account'] = $account[0]->ACCOUNT;
			$this->load->view('visit_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function byAccount($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Visit_model', 'visits');
			$data['visits'] = $this->visits->get_all_visits($id);
			$data['visitCats'] = $this->visits->get_visit_cats();
			$data['complaintCats'] = $this->visits->get_complaint_cats();
			$account = $this->accounts->get_account($id);
			$data['accountid'] = $id;
			$data['account'] = $account[0];
			$this->load->view('visit_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	
	public function ajaxGrid($account)//$sidx, $sord, $page, $limit
	{
			$this->load->model('Visit_model', 'visits');

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'MASTERNOTEDATE'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'DESC'; // get the direction
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';

		if(!$sidx) $sidx =1;

	 
	 	if ($search == 'true'){
			$result =  $this->visits->search_visits_byAccount_paginate($account, $filters->rules, $sidx, $sord, $page, $limit);
			$resultCount = $this->visits->get_visits_count_byAccount_search($account, $filters->rules);
		}else{
			$result =  $this->visits->get_visits_byAccount_paginate($account, $sidx, $sord, $page, $limit);
			$resultCount = $this->visits->get_visits_count_byAccount($account);
		}
	 
	 
		if(  $resultCount[0]->myCount > 0 ) {
			$total_pages = ceil( $resultCount[0]->myCount/$limit);    //calculating total number of pages
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
		$et = ">";
	 
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>".$page."</page>";
		echo "<total>".$total_pages."</total>";
		echo "<records>". $resultCount[0]->myCount."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['VISITID']."'>";
			echo "<cell><![CDATA[".$row['VISITID']."]]></cell>";
			echo "<cell><![CDATA[".$row['MASTERNOTEDATE']."]]></cell>";
			echo "<cell><![CDATA[".$row['VISITTYPE']."]]></cell>";
			echo "<cell><![CDATA[".$row['VISITCATNAME']."]]></cell>";
			echo "<cell><![CDATA[".$row['MASTERNOTEID']."]]></cell>";
			echo "<cell><![CDATA[".$row['MASTERNOTE']."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";


	//	echo json_encode($data);

	}

	public function visitCats_html()
	{
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Visit_model', 'visits');
			$visitCats = $this->visits->get_visit_cats();
			$complaintCats = $this->visits->get_complaint_cats();
			
			echo ('<select>');
			echo('<option value="">All</option>');		
			echo ('<optgroup label="Visits">');
			foreach($visitCats as $v){
				echo('<option value="'.$v->VISITCATNAME.'">'.$v->VISITCATNAME.'</option>');			
			}
			echo ('</optgroup>');
			echo ('<optgroup label="Complaints">');
			foreach($complaintCats as $c){
				echo('<option value="'.$c->VISITCATNAME.'">'.$c->VISITCATNAME.'</option>');			
			}
			echo ('</optgroup>');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */