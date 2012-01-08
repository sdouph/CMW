<?php class Invoice_history_model extends CI_Model {

    function __construct()
    {
        parent::__construct(); 
    }
	 function get_invoices($account)
    {
		$this->db->order_by('INVOICE_NUMBER', 'DESC');
    	$query = $this->db->get_where('DL_INV_HIST_HEAD', array('ACCOUNTID' => $account));
		return $query->result();
    }
	

	function get_invoices_paginate($account,$idx, $ord, $page, $limit)
	{
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_INV_HIST_HEAD WHERE ACCOUNTID = '".$account."') temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	function search_invoices_paginate($account, $filters, $idx, $ord, $page, $limit)
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

		    $query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT * FROM sysdba.DL_INV_HIST_HEAD WHERE ACCOUNTID = '".$account."' AND ".$s.") temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);

		return $query->result_array();
	
	}
	
	
	
	function get_invoice($invoice_num)
	{
		$query = $this->db->get_where('DL_INV_HIST_HEAD', array('INVOICE_NUMBER' => $invoice_num));
		return $query->result();
	}
	
	function get_invoice_detail($invoice_num)
	{
		$this->db->order_by('LINE_NUMBER', 'ASC');
    	$query = $this->db->get_where('DL_INV_HIST_DET', array('INVOICE_NUMBER' => $invoice_num));
		return $query->result();
	}
	
		
	function get_report_invoices_count_byUser($user, $start, $end)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
WHERE i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		}else{
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		} 
		
		return $query->result();

	}

	
	function get_report_invoices_byUser_paginate($user,$idx, $ord, $page, $limit, $s, $e){
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

			if ($user == "ADMIN       "){
				$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT SUM(i.NET_INVOICE) as NET_INVOICE, i.ACCOUNTID, a.ACCOUNT
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE i.ITEM_ID <> '/C' AND i.INVOICE_DATE >= '".$s."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY i.ACCOUNTID, a.ACCOUNT
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
			}else{
				$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT SUM(i.NET_INVOICE) as NET_INVOICE, i.ACCOUNTID, a.ACCOUNT
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$s."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY i.ACCOUNTID, a.ACCOUNT
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
			}

		return $query->result_array();
	
	}

	
	function search_report_invoices_byUser_paginate($user, $filters, $sidx, $sord, $page, $limit, $s, $e){
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
			$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT SUM(i.NET_INVOICE) as NET_INVOICE, i.ACCOUNTID, a.ACCOUNT
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE i.INVOICE_DATE >= '".$s."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY i.ACCOUNTID, a.ACCOUNT
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
			$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT SUM(i.NET_INVOICE) as NET_INVOICE, i.ACCOUNTID, a.ACCOUNT
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$s."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY i.ACCOUNTID, a.ACCOUNT
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}

	return $query->result_array();

	}

	
			
	function get_report_items_count_byUser($user, $start, $end)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
WHERE i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		}else{
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		} 
		
		return $query->result();

	}

			
	function search_report_items_count_byUser($user, $start, $end)
	{
		if ($user == "ADMIN       "){
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
WHERE i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		}else{
		    $query = $this->db->query("SELECT COUNT(DISTINCT i.ACCOUNTID) myCount
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID

WHERE a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$start."' AND i.INVOICE_DATE <= '".$end."'
");
		} 
		
		return $query->result();

	}

	
	
	function get_report_items_byUser_paginate($user,$idx, $ord, $page, $limit, $b, $e){
			if ($page == 1){
				$start = 1;
			}else{
			   $start = ($page -1) * $limit + 1;
			}
		   $end = $start + $limit; 

			if ($user == "ADMIN       "){
				$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT ITEM_ID, ITEM_DESC1, SUM(QTY_ORDERED) as QTY_ORDERED, ROUND(AVG(UNIT_PRICE),2) as AVG_UNIT_PRICE, SUM(EXTENDED_PRICE) as TOTAL_EXTENDED_PRICE
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.DL_INV_HIST_DET d ON i.INVOICE_NUMBER = d.INVOICE_NUMBER
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID
WHERE   d.ITEM_ID NOT LIKE '%/C%' AND i.INVOICE_DATE >= '".b."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY ITEM_ID, ITEM_DESC1 
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
			}else{
				$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT ITEM_ID, ITEM_DESC1, SUM(QTY_ORDERED) as QTY_ORDERED, ROUND(AVG(UNIT_PRICE),2) as AVG_UNIT_PRICE, SUM(EXTENDED_PRICE) as TOTAL_EXTENDED_PRICE
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.DL_INV_HIST_DET d ON i.INVOICE_NUMBER = d.INVOICE_NUMBER
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID
WHERE   d.ITEM_ID NOT LIKE '%/C%' AND a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$b."' AND i.INVOICE_DATE <= '".$e."'

GROUP BY ITEM_ID, ITEM_DESC1 
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
			}

		return $query->result_array();
	
	}

	
	function search_report_items_byUser_paginate($user, $filters, $idx, $ord, $page, $limit, $b, $e){
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

		if ($user == "ADMIN       "){
			$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT ITEM_ID, ITEM_DESC1, SUM(QTY_ORDERED) as QTY_ORDERED, ROUND(AVG(UNIT_PRICE),2) as AVG_UNIT_PRICE, SUM(EXTENDED_PRICE) as TOTAL_EXTENDED_PRICE
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.DL_INV_HIST_DET d ON i.INVOICE_NUMBER = d.INVOICE_NUMBER
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID
WHERE   d.ITEM_ID NOT LIKE '%/C%' AND i.INVOICE_DATE >= '".b."' AND i.INVOICE_DATE <= '".$e."'".$s."

GROUP BY ITEM_ID, ITEM_DESC1 
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}else{
			$query = $this->db->query("SELECT temp2.* FROM (SELECT ROW_NUMBER() OVER(ORDER BY ".$idx." ".$ord.") AS 'ROWNUM', temp1.* FROM(SELECT ITEM_ID, ITEM_DESC1, SUM(QTY_ORDERED) as QTY_ORDERED, ROUND(AVG(UNIT_PRICE),2) as AVG_UNIT_PRICE, SUM(EXTENDED_PRICE) as TOTAL_EXTENDED_PRICE
FROM sysdba.DL_INV_HIST_HEAD i
	JOIN sysdba.DL_INV_HIST_DET d ON i.INVOICE_NUMBER = d.INVOICE_NUMBER
	JOIN sysdba.ACCOUNT a ON a.ACCOUNTID = i.ACCOUNTID
WHERE  d.ITEM_ID NOT LIKE '%/C%' AND a.ACCOUNTMANAGERID ='".$user."' AND i.INVOICE_DATE >= '".$b."' AND i.INVOICE_DATE <= '".$e."'".$s."

GROUP BY ITEM_ID, ITEM_DESC1 
) temp1) temp2 WHERE temp2.ROWNUM BETWEEN ".$start." AND ".$end);
		}

	return $query->result_array();

	}



}
?>