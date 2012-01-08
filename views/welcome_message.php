<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

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

<p>Here is a proof of concept connecting PHP with the SalesLogix database on MSSQL</p>


Total Record Count: <?= $myCount?>

<br/>
<p><br />Page rendered in {elapsed_time} seconds</p>

<h1>All Records</h1><br />
<table border="1" cellspacing="0" cellpadding="5">
<thead><td>Account</td><td>Main Phone</td><td>Fax</td><td>Email</td></thead>
<?php foreach ($accounts as $a): ?>
	<tr><td><?=$a->ACCOUNT?></td><td><?=$a->MAINPHONE?></td><td><?=$a->FAX?></td><td><?=$a->EMAIL?></td>	</tr>
<?php endforeach; ?>
</table>
</body>
</html>