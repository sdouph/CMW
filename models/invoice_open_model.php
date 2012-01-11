<?php class Invoice_open_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	
	
	 function get_all_invoices($account)
    {
			$this->db->order_by('INVOICE_NUMBER', 'DESC');

    	$query = $this->db->get_where('DL_OPEN_INVOICES', array('ACCOUNTID' => $account));
		return $query->result();
    }
	

	function get_invoices_byAccount_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_OPEN_INVOICES WHERE ACCOUNTID = '".$account."' AND INVOICE_BAL <> 0 ) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	}
	
	
	function search_invoices_byAccount_paginate($account, $filters, $idx, $ord, $page, $limit)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			if ($count ==0){
				$s .= $field ." LIKE '%".$data."%'";
			}else{
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}
		}
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 
	
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_OPEN_INVOICES WHERE ACCOUNTID = '".$account."' AND INVOICE_BAL <> 0 AND ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();	
	}



	function get_invoices_byAccount($account)
	{
			//$this->db->select ('a.ACCOUNTID, a.ACCOUNT, i.*');
			$this->db->from('DL_OPEN_INVOICES i');
			//$this->db->join('ACCOUNT a', 'a.ACCOUNTID = i.ACCOUNTID');
			//$this->db->order_by('INVOICE_DATE', 'DESC');
			$this->db->where("ACCOUNTID = '".$account."'");
			$this->db->where("i.INVOICE_BAL <>  0");
			
			$query = $this->db->get();
	
		return $query->result();	
		}
		

	function get_invoices_byUser($user)
	{
		if ($user == "ADMIN       "){
			$query = $this->db->get_where('DL_OPEN_INVOICES', 'INVOICE_BAL <> 0');
		}else{
			$this->db->select ('a.ACCOUNTID, a.ACCOUNT, i.*');
			$this->db->from('DL_OPEN_INVOICES i');
			$this->db->join('ACCOUNT a', 'a.ACCOUNTID = i.ACCOUNTID');
			$this->db->order_by('INVOICE_DATE', 'DESC');
			$this->db->where("a.ACCOUNTMANAGERID = '".$user."'");
			$this->db->where("i.INVOICE_BAL <>  0");
			
			$query = $this->db->get();
			
			
		}
	
		return $query->result();	
	}
	
	
	function get_invoice_count_byUser($user)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE i.INVOICE_BAL <> 0");
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' AND  i.INVOICE_BAL <> 0");
		} 
		
		return $query->result();

	}
	
	function get_invoice_count_byUser_search($user, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'INVOICE_DATE'){
				$s .= " AND ".$field ." >= '".$data."' AND ".$field ." < '".$this->dateoperations->sum($data,'day',2)."'";
			}else{
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}

		}

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE i.INVOICE_BAL <> 0 ".$s);
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' AND i.INVOICE_BAL <> 0 ".$s);
		}
		return $query->result();
	
	}
	
	
	function get_invoices_byUser_paginate($user,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE i.INVOICE_BAL <> 0) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' AND i.INVOICE_BAL <> 0) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		} 

		return $query->result_array();
	}
	
	
	function search_invoices_byUser_paginate($user, $filters, $idx, $ord, $page, $limit)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'INVOICE_DATE'){
				$s .= " AND ".$field ." >= '".$data."' AND ".$field ." < '".$this->dateoperations->sum($data,'day',2)."'";
			}else{
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}

		}
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 
		
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE i.INVOICE_BAL <> 0 ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_OPEN_INVOICES i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' AND i.INVOICE_BAL <> 0 ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}

	
		return $query->result_array();	
	}
	
	
	
	
	
	
	
	
	function get_invoice_detail($invoice_id)
	{
    	$query = $this->db->get_where('DL_OPEN_INVOICES', array('DL_OPEN_INVOICESID' => $invoice_id));
		return $query->result();
	}
	
}
?>