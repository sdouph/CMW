<?php class Orders_model extends CI_Model {
		var $sql_1a = "SELECT ITEM_ID, ITEM_DESC1, SUM(QTY_ORDERED) as QTY_ORDERED, ROUND(AVG(UNIT_PRICE),2) as AVG_UNIT_PRICE, SUM(EXTENDED_PRICE) as TOTAL_EXTENDED_PRICE
	FROM sysdba.DL_ORDER_DET as d
	JOIN sysdba.DL_ORDER_HEAD as h ON h.DL_ORDER_HEADID = d.DL_ORDER_HEADID 
	JOIN sysdba.ACCOUNT as a ON a.ACCOUNTID = h.ACCOUNTID
	WHERE ITEM_ID <>'C' AND ORDER_DATE >= '";
		var $sql_1b = "' AND ORDER_DATE <= '";
		var $sql_1c = "  GROUP BY ITEM_ID, ITEM_DESC1"; 
		
		var $sql_2a = "SELECT COUNT(DISTINCT(d.ITEM_ID)) as myCount
	FROM sysdba.DL_ORDER_DET as d
	JOIN sysdba.DL_ORDER_HEAD as h ON h.DL_ORDER_HEADID = d.DL_ORDER_HEADID 
	JOIN sysdba.ACCOUNT as a ON a.ACCOUNTID = h.ACCOUNTID
	WHERE ITEM_ID <>'C' AND ORDER_DATE >= '";

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_orders_byDate($b, $e)
    {
    	$query = $this->db->query($this->sql_1a . $b .$this->sql_1b . $e . "'" . $this->sql_1c);
		return $query->result();
    }
	
	function get_all_orders_count ($b, $e, $user)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query($this->sql_2a . $b .$this->sql_1b . $e . "'");
		}else{
		    $query = $this->db->query($this->sql_2a . $b .$this->sql_1b . $e . "'  AND a.ACCOUNTMANAGERID = '".$user."'");
		}
		
		return $query->result();
	}
	
	function get_all_orders_paginate($b, $e, $user, $idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(".$this->sql_1a . $b .$this->sql_1b . $e . "'" . $this->sql_1c.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(".$this->sql_1a . $b .$this->sql_1b . $e . "'  AND a.ACCOUNTMANAGERID = '".$user."'" . $this->sql_1c.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
	
	function search_orders_count($b, $e, $user, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			
				$s .= " AND ".$field ." LIKE '%".$data."%'";
		}
			
		if ($user == "ADMIN       "){
		    $query = $this->db->query($this->sql_2a . $b .$this->sql_1b . $e . "'" . $s);
		}else{
		    $query = $this->db->query($this->sql_2a . $b .$this->sql_1b . $e . "'  AND a.ACCOUNTMANAGERID = '".$user."'". $s);
		}
		
		return $query->result();
	}	
	
	function search_orders_paginate($b, $e, $user, $filters, $idx, $ord, $page, $limit)
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																									{
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																										
		//$a = array();
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			
				$s .= " AND ".$field ." LIKE '%".$data."%'";
		}

		if ($page == 1){
			$start = 1;
		}else{
		   $start = ($page -1) * $limit + 1;
		}
	   $end = $start + $limit; 

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(".$this->sql_1a . $b .$this->sql_1b . $e . "'" . $s . $this->sql_1c.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(".$this->sql_1a . $b .$this->sql_1b . $e . "'" . $s . $this->sql_1c."  AND a.ACCOUNTMANAGERID = '".$user."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
}
?>