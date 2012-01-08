<?php 

    $export_file = "monsoon_product_report.xls"; 
    ob_end_clean(); 
    ini_set('zlib.output_compression','Off'); 
    
    header('Content-Type: application/vnd.ms-excel;');                 // This should work for IE & Opera 
    header("Content-type: application/x-msexcel");                    // This should work for the rest 
    header('Content-Disposition: attachment; filename="'.basename($export_file).'"'); 

?>
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
