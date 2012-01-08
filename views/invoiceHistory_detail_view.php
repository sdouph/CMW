<?php include('inc/header.php'); ?>

<h1><?=anchor('/accounts/detail/'.$accountid, $account);?> - <?=$invoiceHeader->INVOICE_TYPE?> <?=$invoiceHeader->INVOICE_NUMBER?></h1><br />
<div id="invoiceDetail">

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><label>PO NUMBER</label>
      <?=$invoiceHeader->PO_NUMBER?></td>
    <td>&nbsp;</td>
    <td><label>Order Number</label> <?=$invoiceHeader->ORDER_NUMBER?></td>
  </tr>
  <tr>
    <td><label>ORDER DATE</label>
      <?=mssql_date_fix($invoiceHeader->ORDER_DATE)?></td>
    <td>&nbsp;</td>
    <td><label>DUE DATE</label> <?=mssql_date_fix($invoiceHeader->DUE_DATE)?></td>
  </tr>
  <tr>
    <td><label>Confirm To</label>
      <?=$invoiceHeader->CONFIRM_TO?></td>
    <td>&nbsp;</td>
    <td><label>Comments</label>
      <?=$invoiceHeader->INVOICE_COMMENT?></td>
  </tr>
  <tr>
    <td colspan="3"><hr/></td>
  </tr>
  <tr>
    <td><label>Billing Info</label>
      <?=$invoiceHeader->BILL_TO_NAME ?>
      <br />
      <?=(isset($invoiceHeader->BILL_TO_ADDR1) ? $invoiceHeader->BILL_TO_ADDR1.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->BILL_TO_ADDR2) ? $invoiceHeader->BILL_TO_ADDR2.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->BILL_TO_ADDR3) ? $invoiceHeader->BILL_TO_ADDR3.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->BILL_TO_ADDR4) ? $invoiceHeader->BILL_TO_ADDR4.'<br />' :  false) ?>
      <?=trim($invoiceHeader->BILL_TO_CITY) ?>
      ,
      <?=$invoiceHeader->BILL_TO_STATE ?>
      <?=$invoiceHeader->BILL_TO_ZIP ?>
      <br />
      <?=$invoiceHeader->BILL_TO_COUNTRY ?></td>
    <td>&nbsp;</td>
    <td><label>Shipping Info</label>
      <?=$invoiceHeader->SHIP_TO_NAME ?>
      <br />
      <?=(isset($invoiceHeader->SHIP_TO_ADDR1) ? $invoiceHeader->SHIP_TO_ADDR1.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->SHIP_TO_ADDR2) ? $invoiceHeader->SHIP_TO_ADDR2.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->SHIP_TO_ADDR3) ? $invoiceHeader->SHIP_TO_ADDR3.'<br />' :  false) ?>
      <?=(isset($invoiceHeader->SHIP_TO_ADDR4) ? $invoiceHeader->SHIP_TO_ADDR4.'<br />' :  false) ?>
      <?=trim($invoiceHeader->SHIP_TO_CITY) ?>
      ,
      <?=$invoiceHeader->SHIP_TO_STATE ?>
      <?=$invoiceHeader->SHIP_TO_ZIP ?>
      <br />
      <?=$invoiceHeader->SHIP_TO_COUNTRY ?></td>
  </tr>
  <tr>
    <td colspan="3"><hr/></td>
  </tr>
  <tr>
    <td colspan="3"><table border="1" cellpadding="10" id="myTable" name="myTable">
      <tr>
        <th></th>
        <th>ItemID</th>
        <th>Description 1</th>
        <th>Description 2</th>
        <th>QTY</th>
        <th>QTY Shipped</th>
        <th>Unit Price</th>
        <th>Extended Price</th>
      </tr>
      <?php foreach ($invoiceDetail as $i):?>
      <tr>
        <td><?=$i->LINE_NUMBER?></td>
        <td><?=$i->ITEM_ID?></td>
        <td><?=$i->ITEM_DESC1?></td>
        <td><?=$i->ITEM_DESC2?></td>
        <td><?=$i->QTY_ORDERED?></td>
        <td><?=$i->QTY_SHIPPED?></td>
        <td><?=dollar_format($i->UNIT_PRICE)?></td>
        <td><?=dollar_format($i->EXTENDED_PRICE)?></td>
      </tr>
      <?php endforeach; ?>
    </table></td>
    </tr>
  <tr>
</table>
<table width="250px" border="0" align="right" style="margin-right:60px">
	<tr>
        <td align="right"><label>Discount</label></td>
        <td align="right"><?=dollar_format($invoiceHeader->DISCOUNT_AMT)?></td>
  </tr>
	<tr>
        <td align="right"><label>Freight</label></td>
        <td align="right"><?=dollar_format($invoiceHeader->FREIGHT_AMT)?></td>
  </tr>
	<tr>
        <td align="right"><label>Sales Tax</label></td>
        <td align="right"><?=dollar_format($invoiceHeader->SALES_TAX)?></td>
  </tr>
	<tr>
        <td align="right"><label>Net</label></td>
        <td align="right" style="font-weight:bold"><?=dollar_format($invoiceHeader->NET_INVOICE)?></td>
  </tr>
  </table>
<br /><br /><br />
</div>
<?php include('inc/footer.php'); ?>