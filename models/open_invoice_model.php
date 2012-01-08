<?php class Open_invoice_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_invoices($account)
    {
    	$query = $this->db->get_where('DL_OPEN_INVOICES', array('ACCOUNTID' => $account));
		return $query->result();
    }
	
	function get_invoice_detail($invoice_id)
	{
    	$query = $this->db->get_where('DL_OPEN_INVOICES', array('DL_OPEN_INVOICESID' => $invoice_id));
		return $query->result();
	}
	
}
?>