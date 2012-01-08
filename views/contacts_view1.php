<?php include('inc/header.php'); ?>

<table border="1" cellspacing="0" cellpadding="5">
<thead><td></td><td>Last</td><td>First</td><td>Type</td><td>Account</td><td>Work</td><td>Home</td><td>Fax</td><td>Mobile</td><td>Email</td><td>Web Address</td></thead>
<?php
 foreach ($contacts as $c):?>
	<tr>
    	<td><?=anchor('contacts/detail/'.$c->CONTACTID, 'View', 'Click Contact')?></td>
        <td><?=$c->LASTNAME?></td> 
        <td><?=$c->FIRSTNAME?></td> 
        <td><?=$c->TYPE?></td>
        <td><?= anchor('accounts/detail/'.$c->ACCOUNTID, $c->ACCOUNT, 'Click Account')?></td>
        <td><?=phone_format($c->WORKPHONE)?></td>
        <td><?=phone_format($c->HOMEPHONE)?></td>
        <td><?=phone_format($c->FAX)?></td>
        <td><?=phone_format($c->MOBILE)?></td>
        <td><?=mailto($c->EMAIL)?></td>	
        <td><?=auto_link($c->WEBADDRESS)?></td>	
    </tr>
<?php  endforeach; ?>
</table>


<?php include('inc/footer.php'); ?>