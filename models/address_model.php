<?php class Address_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	function get_address($id)
	{
		$query = $this->db->get_where('ADDRESS', array('ADDRESSID' => $id));
		return $query->result(); 
	}
	
}
?>