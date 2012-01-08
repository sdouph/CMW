<?php 
$myAccounts = array();

	foreach ($accounts as $a): 

		$myObj['title'] = $a->ACCOUNT;
	array_push($myAccounts, $myObj);
	
	
	
 endforeach; 
 
echo json_encode($myAccounts); 
 ?>
