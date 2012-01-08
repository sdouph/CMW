<?php class Complaint_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_complaints($account)
    {
    	$query = $this->db->query("SELECT m.*, c.COMPLAINTCATNAME FROM sysdba.CRM_COMPLAINT v JOIN sysdba.CRM_COMPLAINTCAT c ON v.COMPLAINTCATID = c.COMPLAINTCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID  WHERE ACCOUNTID = '".$account."'");
		return $query->result();
    }
	

	function get_all_complaints_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($idx == 'startDATE' || $idx == 'endDATE'){
				$idx = 'MASTERNOTEDATE';
			}

			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.COMPLAINTID, c.COMPLAINTCATNAME FROM sysdba.CRM_COMPLAINT v JOIN sysdba.CRM_COMPLAINTCAT c ON v.COMPLAINTCATID = c.COMPLAINTCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_complaints_paginate($account, $filters, $idx, $ord, $page, $limit)
	{
		
		$s = '';
		$count = 0;
		if ($idx == 'startDATE' || $idx == 'endDATE'){
			$idx = 'MASTERNOTEDATE';
		}
		
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			if ($field <> 'startDATE' && $field <> 'endDATE'){
				$s .= " AND ".$field ." LIKE '%".$data."%'";
			}
			
			if ($field == 'startDATE'){
				$s .= " AND MASTERNOTEDATE >= '". $data."'";
			}
			
			if ($field == 'endDATE'){
				$s .= " AND MASTERNOTEDATE <= '". $data."'";
			}
			$count++;
		}
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.COMPLAINTID, c.COMPLAINTCATNAME FROM sysdba.CRM_COMPLAINT v JOIN sysdba.CRM_COMPLAINTCAT c ON v.COMPLAINTCATID = c.COMPLAINTCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID  WHERE ACCOUNTID = '".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	
	function get_complaint($complaint_id)
	{
		$query = $this->db->get_where('CRM_COMPLAINT', array('COMPLAINTID' => $complaint_id));
		return $query->result();
	}
	
	function get_complaints_byMaster($master_id)
	{
		$query = $this->db->get_where('CRM_COMPLAINT', array('MASTERNOTEID' => $master_id));
		return $query->result();
	}
	
	function get_complaint_cats()
	{
		//$this->db->order_by('COMPLAINTCATNAME', 'ASC');
		$query = $this->db->get('CRM_COMPLAINTCAT');
		return $query->result();
	
	}
	
	
	function addComplaint($master, $cat)
	{
		$data = array(
		   'MASTERNOTEID' => $master,
		   'COMPLAINTCATID' => $cat
		);
		
		$this->db->insert('CRM_COMPLAINT', $data); 
	
	
	}
	
	function deletebyMaster($master)
	{
		$this->db->where('MASTERNOTEID', $master);
		$this->db->delete('CRM_COMPLAINT');
 	}
}
?>