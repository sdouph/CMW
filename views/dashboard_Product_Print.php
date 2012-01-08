<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>monsoonCRM - Product Report</title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
		<link type="text/css" href="<?=base_url()?>assets/css/main.css" rel="stylesheet" />	
      <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/ui.jqgrid.css" />
		<link type="text/css" href="<?=base_url()?>assets/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
        <link type="text/css" href="<?=base_url()?>assets/css/print.css" rel="stylesheet" media="print">
	<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
    <script>
	
	</script>
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style></head>
<body onload="print()">
<div id="logo"></div>
<div id="userInfo"></div>
<h2>Product Sales Report</h2>
<label>FROM</label> <?=$start?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label> TO</label> <?=$end?><br /><br />
<table width="100%" >
<thead><tr bgcolor="#CCCCCC"><th>Item ID</th><th>Description</th><th>QTY</th><th>AVG Unit Price</th><th>Total Extended Price</th></tr></thead>
<tbody>
<?php
 foreach ($result as $r):?>
	<tr><td align="center"><?=$r['ITEM_ID']?></td><td><?=$r['ITEM_DESC1']?></td><td align="center"><?=$r['QTY_ORDERED']?></td><td align="center"><?=dollar_format($r['AVG_UNIT_PRICE'])?></td><td align="center"><?=dollar_format($r['TOTAL_EXTENDED_PRICE'])?></td>	</tr>
<?php endforeach; ?>
</tbody>
</table>
