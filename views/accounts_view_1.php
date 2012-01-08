<?php include('inc/header.php'); ?>
<table id="contentTable" class="tablesorter">
<thead><tr><th>Account</th><th>Type</th><th>Main Phone</th><th>Fax</th><th>Email</th></tr></thead>
<tbody>
<?php
 foreach ($accounts as $a):?>
	<tr><td><?=anchor('accounts/detail/'.$a->ACCOUNTID, $a->ACCOUNT)?></td><td><?=$a->TYPE?></td><td><?=phone_format($a->MAINPHONE)?></td><td><?=phone_format($a->FAX)?></td><td><?=mailto($a->EMAIL)?></td>	</tr>
<?php endforeach; ?>
</tbody>
</table>


<?php include('inc/footer.php'); ?>