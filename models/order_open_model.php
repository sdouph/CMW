<?php class Order_open_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_orders($account)
    {
		$this->db->order_by('ORDER_NUMBER', 'DESC');
    	$query = $this->db->get_where('DL_ORDER_HEAD', array('ACCOUNTID' => $account));
		return $query->result();
    }
	
	function get_order($id)
	{
		$query = $this->db->get_where('DL_ORDER_HEAD', array('DL_ORDER_HEADID' => $id));
		return $query->result();
	}
	
	function get_order_detail($order_id)
	{
		$this->db->order_by('LINE_NUMBER', 'ASC');
    	$query = $this->db->get_where('DL_ORDER_DET', array('DL_ORDER_HEADID' => $order_id));
		return $query->result();
	}
	
	function get_orders_byUser($user)
	{
		if ($user == "ADMIN       "){
			$query = $this->db->get('DL_ORDER_HEAD');
		}else{
			$this->db->select ('a.ACCOUNTID, a.ACCOUNT, o.*');
			$this->db->from('DL_ORDER_HEAD o');
			$this->db->join('ACCOUNT a', 'a.ACCOUNTID = o.ACCOUNTID');
			$this->db->where("a.ACCOUNTMANAGERID = '".$user."'");
			
			$query = $this->db->get();
			
			
		}
	
		return $query->result();
	}
	
	
	function get_orders_count_byUser($user)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID");
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."'");
		} 
		
		return $query->result();

	}
	
	function get_orders_count_byUser_search($user, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'ORDER_DATE'){
				$s .= " AND ".$field ." >= '".$data."' AND ".$field ." < '".$this->dateoperations->sum($data,'day',2)."'";
			}else{
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}

		}

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID <> '' ".$s);
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' ".$s);
		}
		return $query->result();
	
	
	}
	
	
	function get_orders_byUser_paginate($user,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		} 

		return $query->result_array();
	}
	
	
	function search_orders_byUser_paginate($user, $filters, $idx, $ord, $page, $limit)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'ORDER_DATE'){
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
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID <> '' ".$s." ) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.ACCOUNT, i.* FROM sysdba.DL_ORDER_HEAD i JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID WHERE a.ACCOUNTMANAGERID = '".$user."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		} 

	
		return $query->result_array();	
	}
	

	
	function get_orders_count_byAccount($account)
	{
		$query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD WHERE ACCOUNTID = '".$account."'");
		return $query->result();

	}
	
	function get_orders_count_byAccount_search($account, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'ORDER_DATE'){
				$s .= " AND ".$field ." >= '".$data."' AND ".$field ." < '".$this->dateoperations->sum($data,'day',2)."'";
			}else{
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}

		}


	    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_ORDER_HEAD WHERE ACCOUNTID = '".$account."' ".$s);

		return $query->result();
	
	
	}
	
	
	function get_orders_byAccount_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_ORDER_HEAD WHERE ACCOUNTID='".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	}
	
	
	function search_orders_byAccount_paginate($account, $filters, $idx, $ord, $page, $limit)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'ORDER_DATE'){
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
		

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_ORDER_HEAD WHERE ACCOUNTID='".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

	
		return $query->result_array();	
	}
	
	
}
?>