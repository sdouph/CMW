<?php class Accounts_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }

	function get_all_accounts($user, $isManager)
    {
		if ($isManager){
			$query = $this->db->get('ACCOUNT');
		}else{
    	    $query = $this->db->get_where('ACCOUNT', array('ACCOUNTMANAGERID' => $user));
		}
		
		return $query->result();
    }
	
	
	function get_accounts_count_byUser($user, $isManager)
	{
		if ($isManager){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.ACCOUNT");
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.ACCOUNT WHERE ACCOUNTMANAGERID = '".$user."'");
		} 
		
		return $query->result();
	}
	
	function get_accounts_count_byUser_search($user, $isManager, $filters)
	{
		$s = '';
		$count = 0;
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;

			$s .= " AND ".$field ." LIKE '%".$data."%'";
		}

		if ($isManager){
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.ACCOUNT WHERE ACCOUNTMANAGERID <> '' ".$s);
		}else{
		    $query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.ACCOUNT WHERE ACCOUNTMANAGERID = '".$user."' ".$s);
		}
		return $query->result();
	}
	
	
	function get_all_accounts_paginate($user, $isManager, $idx, $ord, $page, $limit)
	{
		if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		if ($isManager){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.*, s.SECCODEDESC FROM sysdba.ACCOUNT a JOIN sysdba.SECCODE s ON a.SECCODEID = s.SECCODEID) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.*, s.SECCODEDESC FROM sysdba.ACCOUNT a JOIN sysdba.SECCODE s ON a.SECCODEID = s.SECCODEID WHERE ACCOUNTMANAGERID = '".$user."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
	
	
	function search_accounts_paginate($user,$isManager, $filters, $idx, $ord, $page, $limit)
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

		if ($isManager){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.*, s.SECCODEDESC FROM sysdba.ACCOUNT a JOIN sysdba.SECCODE s ON a.SECCODEID = s.SECCODEID WHERE ACCOUNTMANAGERID <> '' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT a.*, s.SECCODEDESC FROM sysdba.ACCOUNT a JOIN sysdba.SECCODE s ON a.SECCODEID = s.SECCODEID WHERE ACCOUNTMANAGERID = '".$user."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
	
	function get_account($id)
	{
		$this->db->select ('*');
		$this->db->from('ACCOUNT a1');
		$this->db->join('DL_ACCOUNT a2', 'a1.ACCOUNTID = a2.ACCOUNTID', 'left outer');
		$this->db->where("a1.ACCOUNTID = '".$id."'");
		$query = $this->db->get();
//		$query = $this->db->get_where('ACCOUNT a1', array('a1.ACCOUNTID' => $id));
		return $query->result(); 
	}
}
?>