<?php class Payment_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_payments($account)
    {
    	$query = $this->db->get_where('DL_PAY_REC', array('ACCOUNTID' => $account));
		return $query->result();
    }
	
	function get_order_detail($payment_id)
	{
    	$query = $this->db->get_where('DL_PAY_REC', array('DL_PAY_RECID' => $payment_id));
		return $query->result();
	}


	
	function get_payments_count_byAccount($account)
	{
		$query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_PAY_REC WHERE ACCOUNTID = '".$account."'");
		return $query->result();

	}
	
	function get_payments_count_byAccount_search($account, $filters)
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


	    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.DL_PAY_REC WHERE ACCOUNTID = '".$account."' ".$s);

		return $query->result();
	
	
	}
	
	
	function get_payments_byAccount_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_PAY_REC WHERE ACCOUNTID='".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	}
	
	
	function search_payments_byAccount_paginate($account, $filters, $idx, $ord, $page, $limit)
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
		

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_PAY_REC WHERE ACCOUNTID='".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

	
		return $query->result_array();	
	}
	

}
?>