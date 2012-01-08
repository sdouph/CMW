<?php include('inc/header.php'); ?>

<h1><?=$account ?> - Open Order[<?=$orderHeader->ORDER_TYPE?>] <?=$orderHeader->ORDER_NUMBER?></h1><br />
PO NUMBER: <?=$orderHeader->PO_NUMBER?><br />
CONFIRM_TO: <?=$orderHeader->CONFIRM_TO?><br />
Comments: <?=$orderHeader->ORDER_COMMENT?><br />
Tax Schedule: <?=$orderHeader->TAX_SCHEDULE?><br />
Tax EXEMPT: <?=$orderHeader->TAX_EXEMPT?><br />
<br />
<br />
Order Date: <?=$orderHeader->ORDER_DATE?><br />
Order Number: <?=$orderHeader->ORDER_NUMBER?><br />
<br />
<br />
Discount Rate: <?=$orderHeader->DISCOUNT_RATE?><br />
Discount Amount: <?=$orderHeader->DISCOUNT_AMT?><br />
Tax: <?=$orderHeader->TAXABLE_AMT?><br />
Non Tax: <?=$orderHeader->NONTAX_AMT?><br />
Sales Tax: <?=$orderHeader->SALES_TAX?><br />
Freight: <?=$orderHeader->FREIGHT_AMT?><br />
Deposit: <?=$orderHeader->DEPOSIT_AMT?> [Check Number: <?=$orderHeader->DEP_CHK_NUMBER?>]<br />
Net: <?=$orderHeader->NET_ORDER?><br />
Total: <?=$orderHeader->ORDER_TOTAL?><br />
Balance: <?=$orderHeader->ORDER_BALANCE?><br />
<br />
<br />
<strong>Billing Info</strong><br />
<?=$orderHeader->BILL_TO_NAME ?><br />
<?=(isset($orderHeader->BILL_TO_ADDR1) ? $orderHeader->BILL_TO_ADDR1.'<br />' :  false) ?>
<?=(isset($orderHeader->BILL_TO_ADDR2) ? $orderHeader->BILL_TO_ADDR2.'<br />' :  false) ?>
<?=(isset($orderHeader->BILL_TO_ADDR3) ? $orderHeader->BILL_TO_ADDR3.'<br />' :  false) ?>
<?=(isset($orderHeader->BILL_TO_ADDR4) ? $orderHeader->BILL_TO_ADDR4.'<br />' :  false) ?>
<?=trim($orderHeader->BILL_TO_CITY) ?>, <?=$orderHeader->BILL_TO_STATE ?> <?=$orderHeader->BILL_TO_ZIP ?><br />
<?=$orderHeader->BILL_TO_COUNTRY ?><br />
<br /><br />
<strong>Shipping Info</strong><br />
<?=$orderHeader->SHIP_TO_NAME ?><br />
<?=(isset($orderHeader->SHIP_TO_ADDR1) ? $orderHeader->SHIP_TO_ADDR1.'<br />' :  false) ?>
<?=(isset($orderHeader->SHIP_TO_ADDR2) ? $orderHeader->SHIP_TO_ADDR2.'<br />' :  false) ?>
<?=(isset($orderHeader->SHIP_TO_ADDR3) ? $orderHeader->SHIP_TO_ADDR3.'<br />' :  false) ?>
<?=(isset($orderHeader->SHIP_TO_ADDR4) ? $orderHeader->SHIP_TO_ADDR4.'<br />' :  false) ?>
<?=trim($orderHeader->SHIP_TO_CITY) ?>, <?=$orderHeader->SHIP_TO_STATE ?> <?=$orderHeader->SHIP_TO_ZIP ?><br />
<?=$orderHeader->SHIP_TO_COUNTRY ?><br /> 
<br /><br />
<table border="1" cellpadding="10">
<thead><td></td><td>ItemID</td><td>Description 1</td><td>Description 2</td><td>QTY</td><td>QTY Shipped</td><td>Unit Price</td><td>Extended Price</td></thead>
<?php foreach ($orderDetail as $i):?>
<tr>
	<td><?=$i->LINE_NUMBER?></td>
	<td><?=$i->ITEM_ID?></td>
	<td><?=$i->ITEM_DESC1?></td>
	<td><?=$i->ITEM_DESC2?></td>
	<td><?=$i->QTY_ORDERED?></td>
	<td><?=$i->QTY_SHIPPED?></td>
	<td><?=$i->UNIT_PRICE?></td>
	<td><?=$i->EXTENDED_PRICE?></td>
</tr>
<?php endforeach; ?> 
</table>


<?php include('inc/footer.php'); ?>