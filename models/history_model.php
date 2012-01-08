<?php class History_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_history_account($account)
    {
		$this->db->order_by('ORIGINALDATE', 'DESC');
    	$query = $this->db->get_where('HISTORY', array('ACCOUNTID' => $account));
		return $query->result();
    }
	
	function get_history_count_byAccount ($account)
	{
		$this->db->select('COUNT(*) myCount');
    	$query = $this->db->get_where('HISTORY', array('ACCOUNTID' => $account));
		return $query->result();
	}

	function get_history_count_byAccount_search ($account, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			$s .= " AND ".$field ." LIKE '%".$data."%'";
		}
    	$query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.HISTORY WHERE ACCOUNTID = '".$account."' ".$s);
		return $query->result();
	}

	function get_history_byAccount_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.HISTORY WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_history_byAccount_paginate($account, $filters, $idx, $ord, $page, $limit)
	{
		
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			if ($field == 'ORIGINALDATE'){
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
		

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.HISTORY WHERE ACCOUNTID = '".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	 function get_all_history_contact($contact)
    {
		$this->db->order_by('ORIGINALDATE', 'DESC');
    	$query = $this->db->get_where('HISTORY', array('CONTACTID' => $contact));
		return $query->result();
    }

	function get_all_history_contact_paginate($contact,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.HISTORY WHERE CONTACTID = '".$contact."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_history_contact_paginate($contact, $filters, $idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.HISTORY WHERE CONTACTID = '".$contact."' AND ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	



	function get_history($historyID)
	{
		$query = $this->db->get_where('HISTORY', array('HISTORYID' => $historyID));
		return $query->result();
	}
	
	

}
?>