<?php class Contacts_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_contacts($user)
    {
		if ($user == "ADMIN       "){
			$this->db->select('*');
			$this->db->from('CONTACT');
/*			$this->db->where('LASTNAME !=', '');
			$this->db->where('FIRSTNAME !=', '');
			$this->db->or_where('WORKPHONE !=', '');
			$this->db->or_where('HOMEPHONE !=', '');
			$this->db->or_where('FAX !=', '');
			$this->db->or_where('MOBILE !=', '');
*/

			$this->db->order_by('LASTNAME', 'ASC');
			$query = $this->db->get();
		}else{
    	    $query = $this->db->get_where('CONTACT', array('ACCOUNTMANAGERID' => $user));
		}
		
		return $query->result();
    }
	
	function get_contact($id)
	{
		$query = $this->db->get_where('CONTACT', array('CONTACTID' => $id));
		return $query->result();
	}
	
	function get_contacts_byAccountID($id)
	{
		$query = $this->db->get_where('CONTACT', array('ACCOUNTID' => $id));
		return $query->result(); 
	}
	
	
	
	function get_all_contacts_paginate($user,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT c.*, s.SECCODEDESC FROM sysdba.CONTACT c JOIN sysdba.SECCODE s ON c.SECCODEID = s.SECCODEID) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT c.*, s.SECCODEDESC FROM sysdba.CONTACT c JOIN sysdba.SECCODE s ON c.SECCODEID = s.SECCODEID WHERE ACCOUNTMANAGERID = '".$user."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
	
	
	function search_contacts_paginate($user, $filters, $idx, $ord, $page, $limit)
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

		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT c.*, s.SECCODEDESC FROM sysdba.CONTACT c JOIN sysdba.SECCODE s ON c.SECCODEID = s.SECCODEID WHERE ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT c.*, s.SECCODEDESC FROM sysdba.CONTACT c JOIN sysdba.SECCODE s ON c.SECCODEID = s.SECCODEID WHERE ACCOUNTMANAGERID = '".$user."' AND ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}
		
		return $query->result_array();
	
	}
	
}
?>