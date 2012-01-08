<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
			$this->load->model('Orders_model', 'orders');
			//$data['items'] = $this->orders->get_all_byDate('2011-07-01', '2011-07-31');
			$this->load->view('dashboard_view');
			//$this->load->view('temp_view');
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function productSales()
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Orders_model', 'orders');
			//$data['items'] = $this->orders->get_all_byDate('2011-07-01', '2011-07-31');
			$this->load->view('dashboard_Product_view');
			//$this->load->view('temp_view');
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function productSalesGrid()//$sidx, $sord, $page, $limit
	{
			$id = $this->session->userdata['userID'];
			$this->load->model('Invoice_history_model', 'invoices');

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'ITEM_ID'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'ASC'; // get the direction
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';
		
		$begin =isset($_POST['start'])?$_POST['start']:mdate('%Y-%m-%d', mktime(0,0,0, 1, 1, date("Y")));
		$end =isset($_POST['end'])?$_POST['end']:mdate('%Y-%m-%d'); 
		 

		if(!$sidx) $sidx =1;
	 
	 	if ($search == 'true'){
			$result =  $this->invoices->search_report_items_byUser_paginate($id, $filters->rules, $sidx, $sord, $page, $limit, $begin, $end);
			$resultCount = $this->invoices->get_report_items_byUser_paginate($id, $sidx, $sord, 1, 100000000,$begin, $end);
		}else{
			$result =  $this->invoices->get_report_items_byUser_paginate($id, $sidx, $sord, $page, $limit,$begin, $end);
			$resultCount = $this->invoices->get_report_items_byUser_paginate($id, $sidx, $sord, 1, 100000000,$begin, $end);
		}
	 
	 
		if( count($resultCount) > 0 ) {
			$total_pages = ceil(count($resultCount)/$limit);    //calculating total number of pages
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
		echo "<records>".count($resultCount)."</records>";
		// be sure to put text data in CDATA
		foreach($result as $row) {
			echo "<row id='".$row['ITEM_ID']."'>";
			echo "<cell><![CDATA[".$row['ITEM_ID']."]]></cell>";
			echo "<cell><![CDATA[".$row['ITEM_DESC1']."]]></cell>";
			echo "<cell><![CDATA[".$row['QTY_ORDERED']."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['AVG_UNIT_PRICE'])."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['TOTAL_EXTENDED_PRICE'])."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";


	//	echo json_encode($data);

	}
	public function productSalesPrint()//$sidx, $sord, $page, $limit
	{
		if ($this->session->userdata('logged_in')){
			$id = $this->session->userdata['userID'];
			$this->load->model('Invoice_history_model', 'invoices');
	
			$page = isset($_REQUEST['page'])?$_REQUEST['page']:1; // get the requested page
			$limit = isset($_REQUEST['rows'])?$_REQUEST['rows']:100000; // get how many rows we want to have into the grid
			$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'ITEM_ID'; // get index row - i.e. user click to sort
			$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC'; // get the direction
			$search = isset($_REQUEST['_search'])?$_REQUEST['_search']:'false';
			$filters = isset($_REQUEST['filters'])?json_decode($_REQUEST['filters']):'';
			
			$begin =isset($_REQUEST['start'])?$_REQUEST['start']:mdate('%Y-%m-%d', mktime(0,0,0, date("m")-1, date("d"), date("Y")));
			$end =isset($_REQUEST['end'])?$_REQUEST['end']:mdate('%Y-%m-%d'); 
			
			if ($search == 'true'){
				$result =  $this->invoices->search_report_items_byUser_paginate($id, $filters->rules, $sidx, $sord, $page, $limit, $begin, $end);
			}else{
				$result =  $this->invoices->get_report_items_byUser_paginate($id, $sidx, $sord, $page, $limit,$begin, $end);
			}
			
			$data['start'] = $begin;
			$data['end'] = $end;
			$data['result'] = $result;
			
			
			$this->load->view('dashboard_product_print', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}

	}
	
	
	
	public function productSalesXLS()//$sidx, $sord, $page, $limit
	{
		if ($this->session->userdata('logged_in')){
			$id = $this->session->userdata['userID'];
			$this->load->model('Invoice_history_model', 'invoices');
	
			$page = isset($_REQUEST['page'])?$_REQUEST['page']:1; // get the requested page
			$limit = isset($_REQUEST['rows'])?$_REQUEST['rows']:100000; // get how many rows we want to have into the grid
			$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'ITEM_ID'; // get index row - i.e. user click to sort
			$sord = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC'; // get the direction
			$search = isset($_REQUEST['_search'])?$_REQUEST['_search']:'false';
			$filters = isset($_REQUEST['filters'])?json_decode($_REQUEST['filters']):'';
			
			$begin =isset($_REQUEST['start'])?$_REQUEST['start']:mdate('%Y-%m-%d', mktime(0,0,0, date("m")-1, date("d"), date("Y")));
			$end =isset($_REQUEST['end'])?$_REQUEST['end']:mdate('%Y-%m-%d'); 
			
			if ($search == 'true'){
				$result =  $this->invoices->search_report_items_byUser_paginate($id, $filters->rules, $sidx, $sord, $page, $limit, $begin, $end);
			}else{
				$result =  $this->invoices->get_report_items_byUser_paginate($id, $sidx, $sord, $page, $limit,$begin, $end);
			}
			
			$data['start'] = $begin;
			$data['end'] = $end;
			$data['result'] = $result;
			
			
			$this->load->view('dashboard_product_xls', $data);
		}else{
			redirect(prep_url(site_url('login')));
		}

	}
	
	
	
	public function productSalesGrid_byItem(){
		$item = $_POST['id'];
		$id = $this->session->userdata['userID'];
		$this->load->model('Orders_model', 'orders');
		
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		//foreach($result as $row) {
			echo "<row id='123'>";
			echo "<cell><![CDATA['".$item."']]></cell>";
			echo "<cell><![CDATA['2011-06-30']]></cell>";
			echo "<cell><![CDATA['1']]></cell>";
			echo "<cell><![CDATA['1.99']]></cell>";
			echo "<cell><![CDATA['5.99']]></cell>";
			echo "</row>";

			
			echo "<row id='125'>";
			echo "<cell><![CDATA['".$item."']]></cell>";
			echo "<cell><![CDATA['2011-06-30']]></cell>";
			echo "<cell><![CDATA['1']]></cell>";
			echo "<cell><![CDATA['1.99']]></cell>";
			echo "<cell><![CDATA['5.99']]></cell>";
			echo "</row>";
			
					//}
		echo "</rows>";
				
	}
	
	
	
	public function customer()
	{
		if ($this->session->userdata('logged_in')){
			$this->load->model('Orders_model', 'orders');
			//$data['items'] = $this->orders->get_all_byDate('2011-07-01', '2011-07-31');
			$this->load->view('dashboard_Customer_view');
			//$this->load->view('temp_view');
		}else{
			redirect(prep_url(site_url('login')));
		}
	}
	
	public function customerGrid()//$sidx, $sord, $page, $limit
	{
			$id = $this->session->userdata['userID'];
			$user = $this->session->userdata['username'];
			$this->load->model('Invoice_history_model', 'invoices');

		$page = isset($_POST['page'])?$_POST['page']:1; // get the requested page
		$limit = isset($_POST['rows'])?$_POST['rows']:10; // get how many rows we want to have into the grid
		$sidx = isset($_POST['sidx'])?$_POST['sidx']:'NET_INVOICE'; // get index row - i.e. user click to sort
		$sord = isset($_POST['sord'])?$_POST['sord']:'DESC'; // get the direction
		$search = isset($_POST['_search'])?$_POST['_search']:'false';
		$filters = isset($_POST['filters'])?json_decode($_POST['filters']):'';
		
		$begin =isset($_POST['start'])?$_POST['start']:mdate('%Y-%m-%d', mktime(0,0,0, 1, 1, date("Y")));
		$end =isset($_POST['end'])?$_POST['end']:mdate('%Y-%m-%d'); 
		 

		if(!$sidx) $sidx =1;

	 
	 	if ($search == 'true'){
			$result =  $this->invoices->search_report_invoices_byUser_paginate($user, $filters->rules, $sidx, $sord, $page, $limit, $begin, $end);
			$resultCount = $this->invoices->get_report_invoice_count_byUser_search($user, $filters->rules, $begin, $end);
		}else{
			$result =  $this->invoices->get_report_invoices_byUser_paginate($user, $sidx, $sord, $page, $limit, $begin, $end);
			$resultCount = $this->invoices->get_report_invoices_count_byUser($user, $begin, $end);
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
			echo "<row id='".$row['ACCOUNTID']."'>";
			echo "<cell><![CDATA[".$row['ACCOUNT']."]]></cell>";
			echo "<cell><![CDATA[".dollar_format($row['NET_INVOICE'])."]]></cell>";
			echo "</row>";
		}
		echo "</rows>";


	//	echo json_encode($data);

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */