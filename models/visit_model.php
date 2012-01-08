<?php class Visit_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_visits($account)
    {
    	//$query = $this->db->get_where('CRM_VISIT', array('ACCOUNTID' => $account));
		$query = $this->db->query("SELECT m.*, c.VISITCATNAME FROM sysdba.CRM_VISIT v JOIN sysdba.CRM_VISITCAT c ON v.VISITCATID = c.VISITCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID WHERE ACCOUNTID = '".$account."'");
		return $query->result();
    }
	

	function get_all_visits_paginate($account,$idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.VISITID, c.VISITCATNAME FROM sysdba.CRM_VISIT v JOIN sysdba.CRM_VISITCAT c ON v.VISITCATID = c.VISITCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_visits_paginate($account, $filters, $idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.VISITID, c.VISITCATNAME FROM sysdba.CRM_VISIT v JOIN sysdba.CRM_VISITCAT c ON v.VISITCATID = c.VISITCATID JOIN sysdba.CRM_MASTERNOTE m ON m.MASTERNOTEID = v.MASTERNOTEID WHERE ACCOUNTID = '".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	function get_visits_count_byAccount($account){
		$this->db->select('COUNT(*) myCount');
		$this->db->join('CRM_VISIT', 'CRM_VISIT.MASTERNOTEID = CRM_MASTERNOTE.MASTERNOTEID');
		$this->db->join('CRM_VISITCAT', 'CRM_VISITCAT.VISITCATID = CRM_VISIT.VISITCATID');
		
    	$query = $this->db->get_where('CRM_MASTERNOTE', array('ACCOUNTID' => $account));
		
		return $query->result();
	}
	
	function get_visits_count_byAccount_search($account, $filters){
		$s = '';
		$count = 0;
		$this->db->select('COUNT(*) myCount');		
		foreach($filters as $f) {
			$field = $f->field;
			$data = $f->data;
			$s .= " AND ".$field ." LIKE '%".$data."%'";
			$this->db->like($field, $data);
		}
		$this->db->join('CRM_VISIT', 'CRM_VISIT.MASTERNOTEID = CRM_MASTERNOTE.MASTERNOTEID');
		$this->db->join('CRM_VISITCAT', 'CRM_VISITCAT.VISITCATID = CRM_VISIT.VISITCATID');
		
    	//$query = $this->db->query("SELECT COUNT(*) myCount FROM sysdba.CRM_MASTERNOTE WHERE ACCOUNTID = '".$account."' ".$s);
 	  	$query = $this->db->get_where('CRM_MASTERNOTE', array('ACCOUNTID' => $account));
		return $query->result();
	}
	
	function get_visits_byAccount_paginate($account,$idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.VISITID, c.VISITCATNAME, c.VISITTYPE FROM sysdba.CRM_MASTERNOTE m
JOIN sysdba.CRM_VISIT v ON v.MASTERNOTEID = m.MASTERNOTEID
JOIN sysdba.CRM_VISITCAT c ON c.VISITCATID = v.VISITCATID
 WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_visits_byAccount_paginate($account, $filters, $idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT m.*, v.VISITID, c.VISITCATNAME, c.VISITTYPE FROM sysdba.CRM_MASTERNOTE m
JOIN sysdba.CRM_VISIT v ON v.MASTERNOTEID = m.MASTERNOTEID 
JOIN sysdba.CRM_VISITCAT c ON c.VISITCATID = v.VISITCATID 
WHERE ACCOUNTID = '".$account."' ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}

	
	function get_visit($visit_id)
	{
		 $query = $this->db->query("SELECT m.*, c.VISITCATNAME FROM sysdba.CRM_VISIT v JOIN sysdba.CRM_VISITCAT c ON v.VISITCATID = c.VISITCATID WHERE VISITID = ".$visit_id);
		//$query = $this->db->get_where('CRM_VISIT', array('VISITID' => $visit_id));
		return $query->result();
	}
	
	function get_visits_byMaster($master_id)
	{
		$query = $this->db->get_where('CRM_VISIT', array('MASTERNOTEID' => $master_id));
		return $query->result();
	}
	
	function get_visit_cats()
	{
		$this->db->where('VISITTYPE', 'Visit');
		$this->db->order_by('VISITCATNAME', 'ASC');
		$query = $this->db->get('CRM_VISITCAT');
		return $query->result();
	
	}
	
	function get_complaint_cats()
	{
		$this->db->where('VISITTYPE', 'Complaint');
		$this->db->order_by('VISITCATNAME', 'ASC');
		$query = $this->db->get('CRM_VISITCAT');
		return $query->result();
	
	}
	
		
	function addVisit($master, $cat)
	{
		$data = array(
			'MASTERNOTEID' => $master,
		   'VISITCATID' => $cat
		);
		
		$this->db->insert('CRM_VISIT', $data); 
	
	
	}
	
	function deletebyMaster($master)
	{
		$this->db->where('MASTERNOTEID', $master);
		$this->db->delete('CRM_VISIT');
 	}
	
}
?>