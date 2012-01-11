<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OrderOpen extends CI_Controller {

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
	public function index(){
		if ($this->session->userdata('logged_in')){
			$data['user'] = $this->session->userdata['currentUser'];
			$this->load->view('orderOpen_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	 
	 
	 
	public function byAccount($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Order_open_model', 'orders');
			$data['orders'] = $this->orders->get_all_orders($id);
			$account = $this->accounts->get_account($id);
			$data['account'] = $account[0]->ACCOUNT;
			$data['accountid'] = $id;
			$this->load->view('orderOpen_byAccount_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function detail($id)
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Accounts_model', 'accounts');
			$this->load->model('Order_open_model', 'order');
			
			$head = $this->order->get_order($id);
			$detail = $this->order->get_order_detail($id);
			$data['orderHeader'] = $head[0];
			$data['orderDetail'] = $detail;
			
			$account = $this->accounts->get_account($head[0]->ACCOUNTID);
			$data['account'] = $account[0]->ACCOUNT;
			
			$this->load->view('orderOpen_detail_view', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	
	public function ajaxGrid()//$sidx, $sord, $page, $limit
	{
			$this->load->model('Order_open_model', 'orders');
			$user = $this->session->userdata['username'];

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'ORDER_NUMBER'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'DESC'; // get the direction
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';

		if(!$sidx) $sidx =1;
	 
	 	if ($search == 'true'){
			$result =  $this->orders->search_orders_byUser_paginate($user, $filters->rules, $sidx, $sord, $page, $limit);
			$resultCount = $this->orders->get_orders_count_byUser_search($user, $filters->rules);
		}else{
			$result =  $this->orders->get_orders_byUser_paginate($user, $sidx, $sord, $page, $limit);
			$resultCount = $this->orders->get_orders_count_byUser($user);
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
		echo "<records>".$resultCount[0]->myCount."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['DL_ORDER_HEADID']."'>";
			echo "<cell><![CDATA[".$row['ORDER_NUMBER']."]]></cell>";
			echo "<cell><![CDATA[".mssql_date_fix($row['ORDER_DATE'])."]]></cell>";
			echo "<cell><![CDATA[".$row['ACCOUNT']."]]></cell>";
			echo "<cell><![CDATA[".$row['ORDER_TYPE']."]]></cell>";
			echo "<cell><![CDATA[".just_clean($row['CONFIRM_TO'])."]]></cell>";
			echo "<cell><![CDATA[".just_clean($row['ORDER_COMMENT'])."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['ORDER_TOTAL'])."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['ORDER_BALANCE'])."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";
	}
	
	
	public function ajaxGridByAccount($account)//$sidx, $sord, $page, $limit
	{
			$this->load->model('Order_open_model', 'orders');
			$user = $this->session->userdata['username'];

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'ORDER_NUMBER'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'DESC'; // get the direction
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';

		if(!$sidx) $sidx =1;
	 
	 	if ($search == 'true'){
			$result =  $this->orders->search_orders_byAccount_paginate($account, $filters->rules, $sidx, $sord, $page, $limit);
			$resultCount = $this->orders->get_orders_count_byAccount_search($account, $filters->rules);
		}else{
			$result =  $this->orders->get_orders_byAccount_paginate($account, $sidx, $sord, $page, $limit);
			$resultCount = $this->orders->get_orders_count_byAccount($account);
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
		echo "<records>".$resultCount[0]->myCount."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['DL_ORDER_HEADID']."'>";
			echo "<cell><![CDATA[".$row['ORDER_NUMBER']."]]></cell>";
			echo "<cell><![CDATA[".mssql_date_fix($row['ORDER_DATE'])."]]></cell>";
			echo "<cell><![CDATA[".$row['ORDER_TYPE']."]]></cell>";
			echo "<cell><![CDATA[".just_clean($row['CONFIRM_TO'])."]]></cell>";
			echo "<cell><![CDATA[".just_clean($row['ORDER_COMMENT'])."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['ORDER_TOTAL'])."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['ORDER_BALANCE'])."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */