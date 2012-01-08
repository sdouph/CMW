<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CMW - <?= $account->ACCOUNT ?></title>

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


<h1><?=$account ?> - Invoices</h1><br />
<table border="1" cellpadding="10">
<thead><td>Number</td><td>Invoice Date</td><td>Type</td><td>PO Number</td><td>Due Date</td><td>Discount Date</td><td>Order Date</td><td>Net Invoice</td></thead>
<?php foreach ($invoices as $i):?>
<tr><td><?=$i->INVOICE_NUMBER ?></td><td><?=$i->INVOICE_DATE ?></td><td><?=$i->INVOICE_TYPE ?></td><td><?=$i->PO_NUMBER ?></td><td><?=$i->DUE_DATE ?></td><td><?=$i->DISCOUNT_DATE ?></td><td><?=$i->ORDER_DATE ?></td><td><?=$i->NET_INVOICE?></td></tr>
<?php endforeach; ?> 
</table>

</body>
</html>