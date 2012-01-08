<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CMW - <?= $contact->ACCOUNT ?></title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>Corona CRM</h1>

<p><br />Page rendered in {elapsed_time} seconds</p>

<h1><?= $contact->FIRSTNAME?> <?= $contact->LASTNAME?></h1><br />
<?=$contact->TITLE ?><br />
<a href="http://<?=site_url('history/index/contact/'.$contact->CONTACTID) ?>">Notes</a>
<hr>
<?= phone_format($contact->WORKPHONE) ?><br />
<?= phone_format($contact->HOMEPHONE) ?><br />
<?= phone_format($contact->FAX) ?><br />
<?= phone_format($contact->MOBILE) ?><br />
<?= safe_mailto($contact->EMAIL) ?><br />
<?= mailto($contact->SECONDARYEMAIL) ?><br />
<?= auto_link($contact->WEBADDRESS) ?><br />
<?= $contact->DESCRIPTION ?><br />
<hr>
<?= $address->ADDRESS1 ?><br />
<?= $address->ADDRESS2 ?><br />
<?= $address->CITY ?><br />
<?= $address->STATE ?><br />
<?= $address->POSTALCODE ?><br />
<hr>
<?= $shipping->ADDRESS1 ?><br />
<?= $shipping->ADDRESS2 ?><br />
<?= $shipping->CITY ?><br />
<?= $shipping->STATE ?><br />
<?= $shipping->POSTALCODE ?><br />
</body>
</html>