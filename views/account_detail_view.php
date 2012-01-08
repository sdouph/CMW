<?php include('inc/header.php'); ?>

<?=anchor('addNote/byAccount/'.$accountid, 'VISIT / COMPLAINT', 'class="addNote"')?>
<h2><?= $account->ACCOUNT ?></h2>
<?= $account->TYPE ?><br /><br />

<label>Main Phone:</label> <?= phone_format($account->MAINPHONE) ?><br />
<label>Fax:</label> <?= phone_format($account->FAX) ?><br />
<label>Email:</label> <?= mailto($account->EMAIL) ?><br />
<label>Website:</label> <?= auto_link($account->WEBADDRESS) ?><br /><br />


<?=anchor('history/byAccount/'.$accountid, 'Notes')?>  |  <?=anchor('visit/byAccount/'.$accountid, 'Visit History')?><!--  |  <?=anchor('complaint/byAccount/'.$accountid, 'Complaints')?>-->  |  <?=anchor('invoiceHistory/byAccount/'.$accountid, 'Invoice History')?> | <?=anchor('invoiceOpen/byAccount/'.$accountid, 'Open Invoices')?> | <?=anchor('orderOpen/byAccount/'.$accountid, 'Open Orders')?> | <?=anchor('payment/byAccount/'.$accountid, 'Payment &amp; Receipts')?>
<br />
<br />
<div id="accordion">
	<h3><a href="#">Account Status</a></h3>
	<div>
        <label>Tax Schedule:</label><?=$account->TAX_SCHEDULE ?><br />
       <label> Credit Hold:</label> <?=$account->CREDIT_HOLD ?><br/>
       <label> Credit Limit:</label> <?=dollar_format($account->CREDIT_LIMIT)?><br />
       <label> Last Payment:</label> <?=dollar_format($account->LAST_PAY_AMOUNT) ?> <br />
       <label> Highest Balance:</label> <?=dollar_format($account->HIGH_BALANCE) ?> <br />
        <label>Sales YTD:</label> <?=dollar_format($account->SALES_YTD) ?> <br />
        <label>Sales PTD:</label> <?=dollar_format($account->SALES_PTD) ?> <br />
        <label>Sales LY:</label> <?=dollar_format($account->SALES_LY) ?> <br />
        <label>Current Balance:</label> <?=dollar_format($account->CURRENT_BALANCE) ?> <br />

    </div>
	<h3><a href="#">Addresses</a></h3>
	<div>
    	<table border="0" cellpadding="10">
        <tr><td>
        	<strong>BILLING</strong><br />
			<?= $account->ACCOUNT ?><br />
            <?= $address->ADDRESS1 ?><br />
            <?= isset($address->ADDRESS2)?$address->ADDRESS2.'<br />':'' ?>
            <?= $address->CITY ?>, <?= $address->STATE ?> <?= $address->POSTALCODE ?>
        </td><td>
        	<strong>SHIPPING</strong><br />
			<?= $account->ACCOUNT ?><br />
            <?= $shipping->ADDRESS1 ?><br />
            <?= isset($shipping->ADDRESS2)?$shipping->ADDRESS2.'<br />':'' ?>
            <?= $shipping->CITY ?>, <?= $shipping->STATE ?> <?= $shipping->POSTALCODE ?>
        </td>
        </tr>
        </table>
    
    </div>
	<h3><a href="#">Contacts</a></h3>
    <div style="padding:0; margin:0;" class="ui-jqgrid ui-widget ui-widget-content ui-corner-all">
        <table class="ui-jqgrid-htable" width="100%">
        <tr class="ui-jqgrid-labels"><th class="ui-state-default ui-th-column ui-th-ltr">Name</th><th class="ui-state-default ui-th-column ui-th-ltr">Title</th><th class="ui-state-default ui-th-column ui-th-ltr">Work Phone</th><th class="ui-state-default ui-th-column ui-th-ltr">Home Phone</th><th class="ui-state-default ui-th-column ui-th-ltr">Mobile Phone</th><th class="ui-state-default ui-th-column ui-th-ltr">Email</th></tr>
        <tbody class="ui-jqgrid-btable">
        <?php foreach ($contacts as $c):?>
        <tr class="ui-widget-content jqgrow ui-row-ltr">
            <td><?=anchor('contacts/detail/'.$c->CONTACTID, $c->LASTNAME.' '.$c->FIRSTNAME) ?></td>
            <td><?=$c->TITLE ?></td>
            <td><?=phone_format($c->WORKPHONE) ?></td>
            <td><?=phone_format($c->HOMEPHONE) ?></td>
            <td><?=phone_format($c->MOBILE) ?></td>
            <td><?=mailto($c->EMAIL)?></td></tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</div>

<script>
		$( "#accordion" ).accordion();
		$( ".addNote" ).button({icons: {primary: "ui-icon-plusthick"}});

</script>

<?php include('inc/footer.php'); ?>