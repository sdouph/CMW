<?php include('inc/header.php'); ?>

<h2><?= $contact->FIRSTNAME?> <?= $contact->LASTNAME?> - <?=anchor('accounts/detail/'.$contact->ACCOUNTID, $contact->ACCOUNT)?></h2>
<?=$contact->TITLE ?><br />

<table border="0" cellpadding="30">
<tr valign="top">
<td>
<label>Work Phone:</label><?= phone_format($contact->WORKPHONE) ?><br />
<label>Home Phone:</label><?= phone_format($contact->HOMEPHONE) ?><br />
<label>Fax Phone:</label><?= phone_format($contact->FAX) ?><br />
<label>Mobile Phone:</label><?= phone_format($contact->MOBILE) ?><br />
<label>Email:</label><?= mailto($contact->EMAIL) ?> <?= mailto($contact->SECONDARYEMAIL) ?><br />
<label>Website:</label><?= auto_link($contact->WEBADDRESS) ?><br />
<label>Description:</label><?= $contact->DESCRIPTION ?><br />
</td>
<td>
        	<strong>BILLING</strong><br />
			<?= $contact->ACCOUNT ?><br />
            <?= $address->ADDRESS1 ?><br />
            <?= isset($address->ADDRESS2)?$address->ADDRESS2.'<br />':'' ?>
            <?= $address->CITY ?>, <?= $address->STATE ?> <?= $address->POSTALCODE ?>
</td>
<td>
        	<strong>SHIPPING</strong><br />
			<?= $contact->ACCOUNT ?><br />
            <?= $shipping->ADDRESS1 ?><br />
            <?= isset($shipping->ADDRESS2)?$shipping->ADDRESS2.'<br />':'' ?>
            <?= $shipping->CITY ?>, <?= $shipping->STATE ?> <?= $shipping->POSTALCODE ?>
</td>
</tr>
</table>
<br />
<br />
<table border="1" cellpadding="10" id="myTable">
<tr><th>Date</th><th>Contact</th><th>Description</th><th>Notes</th><th>User</th></tr>
<tbody>
<?php foreach ($history as $h):?>
<tr>
	<td><?=mssql_date_fix($h->ORIGINALDATE) ?></td>
	<td><?=($h->CONTACTNAME!='')?anchor('contacts/detail/'.$h->CONTACTID, $h->CONTACTNAME):''?></td>
	<td><?=$h->DESCRIPTION ?></td>
	<td><?=$h->LONGNOTES ?></td>
	<td><?=$h->USERNAME ?></td>
</tr>
<?php endforeach; ?>
</tbody> 
</table>

<?php include('inc/footer.php'); ?>
