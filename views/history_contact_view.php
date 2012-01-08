<?php include('inc/header.php'); ?>

<h1><?=$contact->FIRSTNAME?> <?=$contact->LASTNAME?> - History</h1><br />
<table border="1" cellpadding="10">
<thead><td>Date</td><td>Contact</td><td>Description</td><td>Notes</td><td>User</td></thead>
<?php foreach ($history as $h):?>
<tr>
	<td><?=mssql_date_fix($h->ORIGINALDATE) ?></td>
	<td><?=isset($h->CONTACTNAME)?anchor('contacts/detail/'.$h->CONTACTID, $h->CONTACTNAME):''?></td>
	<td><?=$h->DESCRIPTION ?></td>
	<td><?=$h->LONGNOTES ?></td>
	<td><?=$h->USERNAME ?></td>
</tr>
<?php endforeach; ?> 
</table>


<?php include('inc/footer.php'); ?>