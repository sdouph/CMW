<?php class MasterNote_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_notes($account)
    {
    	$query = $this->db->get_where('CRM_VISIT', array('ACCOUNTID' => $account));
		return $query->result();
    }
	

	function get_all_notes_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.CRM_MASTERNOTE WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_notes_paginate($account, $filters, $idx, $ord, $page, $limit)
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
			$count++;
		}
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.CRM_MASTERNOTE WHERE ACCOUNTID = '".$account."' AND ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	
	function get_note($id)
	{
		$query = $this->db->get_where('CRM_MASTERNOTE', array('MASTERNOTEID' => $id));
		return $query->result();
	}
	
	
	function get_note_byDate($date, $account)
	{
		$query = $this->db->get_where('CRM_MASTERNOTE', array('MASTERNOTEDATE' => $date, 'ACCOUNTID' => $account,));
		return $query->result();
	}
	
	function addNote($accountid, $date, $note, $user)
	{
		$data = array(
		   'ACCOUNTID' => $accountid,
		   'MASTERNOTEDATE' => $date,
		   'MASTERNOTE' => $note,
		   'ACCOUNTMANAGERID' => $user
		);
		
		$this->db->insert('CRM_MASTERNOTE', $data); 
	
		return $this->db->insert_id();
	
	}
	
	function updateNote ($id, $note)
	{
		$data = array(
					   
					   'MASTERNOTE' => $note
					);
		
		$this->db->where('MASTERNOTEID', $id);
		$this->db->update('CRM_MASTERNOTE', $data); 
	}
	
	function deleteNote ($id)
	{
		$this->db->where('MASTERNOTEID', $id);
		$this->db->delete('CRM_MASTERNOTE');
	}
	
}
?>