<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>monsoonCRM</title>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
		<link type="text/css" href="<?=base_url()?>assets/css/main.css" rel="stylesheet" />	
      <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/css/ui.jqgrid.css" />
		<link type="text/css" href="<?=base_url()?>assets/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
        <link type="text/css" href="<?=base_url()?>assets/css/print.css" rel="stylesheet" media="print">
<!--	<link type="text/css" href="<?=base_url()?>assets/css/Aristo/jquery-ui-1.8.7.custom.css" rel="stylesheet" />	
		<link type="text/css" href="<?=base_url()?>assets/css/tablesorter.css" rel="stylesheet" />	
-->      
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.8.13/jquery-ui.min.js"></script>
<!-- 		<script src="<?=base_url()?>assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
-->
		<script src="<?=base_url()?>assets/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        
        <script src="<?=base_url()?>assets/js/jquery.jqGrid.min.js" type="text/javascript"></script>


        <script>
$(document).ready(function() 
    { 
				tableToGrid('#myTable');
	});		
	
    		</script>
<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
</head>

<body bgcolor="#FFFFFF">
<div id="logo"></div>
<div id="userInfo"><?=$this->session->userdata['usernameFull']?><?php

if ($isManager){
	echo '<ul>';
	
	
	echo '</ul>';
}
?><img src="<?=base_url()?>assets/images/divider.gif" class="navItems"/><img src="<?=base_url()?>assets/images/settings_grey_32.png" width="16px" height="16px" class="navItems" /><img src="<?=base_url()?>assets/images/divider.gif" class="navItems" /><?=anchor('logout', 'Logout', 'title="Logout of CRM"')?></div>
<div id="search"><form method="post" action="<?=site_url('custom')?>"><!--<input id="search_field" type="text"  width="300"/><input id="search_btn" type="submit" value="Search" />--></form></div>
<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<li class="ui-state-default ui-corner-top <?= (uri_string() == 'accounts' || uri_string() == '' ? ' ui-tabs-selected ui-state-active':'') ?>"><?=anchor('accounts', 'Accounts', 'title="Accounts"')?></li>
		<li class="ui-state-default ui-corner-top <?= (uri_string() == 'contacts' ? ' ui-tabs-selected ui-state-active':'') ?>"><?=anchor('contacts', 'Contacts', 'title="Contacts"')?></li>
		<li class="ui-state-default ui-corner-top <?= (uri_string() == 'invoiceOpen' ? ' ui-tabs-selected ui-state-active':'') ?>"><?=anchor('invoiceOpen', 'All Open Invoices', 'title="All Open Invoices"')?></li>
		<li class="ui-state-default ui-corner-top <?= (uri_string() == 'orderOpen' ? ' ui-tabs-selected ui-state-active':'') ?>"><?=anchor('orderOpen', 'All Open Orders', 'title="All Open Orders"')?></li>
		<li class="ui-state-default ui-corner-top <?= (uri_string() == 'dashboard' ? ' ui-tabs-selected ui-state-active':'') ?>"><?=anchor('dashboard/productSales', 'Reports', 'title="Reports"')?></li>
	</ul>
</div>

<div id="content">