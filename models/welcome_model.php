<?php class Welcome_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_accounts()
    {
		$this->db->select('*');
		$this->db->from('ACCOUNT');
		$query = $this->db->get();
		
/*		$query = 'Select * from sysdba.ACCOUNT';
*/		return $query->result();
    }
}
?>