<?php class Users_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_all_users()
    {
		$this->db->select('i.USERID, i.USERNAME, i.EMAIL, s.MANAGERID, s.DEFAULTSECCODEID, s.USERCODE, s.USERPW');
		$this->db->from('USERINFO i');
		$this->db->join('USERSECURITY s', 'i.USERID = s.USERID');
		$this->db->order_by('i.USERNAME', 'asc');
		$this->db->where("s.ENABLED = 'T'");
		$query = $this->db->get();
/*$query = $this->db->query('select i.USERID, i.USERNAME, i.EMAIL, s.MANAGERID, s.DEFAULTSECCODEID, s.USERCODE, s.USERPW from sysdba.USERINFO i join sysdba.USERSECURITY s on i.USERID = s.USERID');
*/		        return $query->result();
    }
	
	function user_count()
	{
			return $this->db->count_all('USERINFO');

	}
	
	function get_user($id)
	{
	
		$this->db->select('i.USERID, i.USERNAME, i.EMAIL, s.ISMANAGER, s.DEFAULTSECCODEID, s.USERCODE, s.USERPW');
		$this->db->from('USERINFO i');
		$this->db->join('USERSECURITY s', 'i.USERID = s.USERID');
		$this->db->where("s.ENABLED = 'T' AND i.USERID = '".$id."'");
		$query = $this->db->get();
		return $query->result();
	}
	
	function isManager($id)
	{
		$this->db->select('s.ISMANAGER');
		$this->db->from('USERINFO i');
		$this->db->join('USERSECURITY s', 'i.USERID = s.USERID');
		$this->db->where("i.USERID = '".$id."'");
		$query = $this->db->get();
		$result =  $query->result();

		if (count($result) > 0){
			if ($result[0]->ISMANAGER == 'T'){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
	}
}
?>