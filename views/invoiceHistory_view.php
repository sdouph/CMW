<?php include('inc/header.php'); ?>

<h2><?=anchor('/accounts/detail/'.$accountid, $account);?> - Invoices</h2><br />
<table id="invoiceList"></table> <!--Grid table-->
<div id="invoicePager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 259;
		
		
		$("#invoiceList").jqGrid({
			url:'<?=site_url('invoiceHistory/ajaxGridByAccount/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Number', 'Invoiced', 'Type', 'PO Number', 'Due Date', 'Order Date', 'Total'],       //Grid column headings
			colModel:[
				{name:'Number',index:'INVOICE_NUMBER', width:'100'},
				{name:'Invoiced',index:'INVOICE_DATE', width:'90', align:'center', search:true},
				{name:'Type',index:'INVOICE_TYPE', width:'100',  stype:'select', searchoptions:{"value":":All;Invoice:Invoice;Credit Memo:Credit Memo"}},
				{name:'PO',index:'PO_NUMBER', width:'150', search:true},
				{name:'Due',index:'DUE_DATE', width:'90', align:'center', search:true},
				{name:'Order',index:'ORDER_DATE', width:'90', align:'center', search:true},
				{name:'Total',index:'NET_INVOICE', width:'90', align:'center', search:false}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#invoicePager', 
			sortname: 'INVOICE_DATE',
			sortorder: 'desc',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('invoiceHistory/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#invoicePager',{edit:false,add:false,del:false,search:false});
		
				
		$("#invoiceList").jqGrid('navButtonAdd',"#invoicePager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
			onClickButton:function(){
				$("#invoiceList")[0].clearToolbar();
				$("#gs_Number").val('');
				$("#gs_PO").val('');
				$("#gs_Invoiced").val('');
				$("#gs_Due").val('');
				$("#gs_Order").val('');
				$("#gs_Type").val('');
	
			} 
		});
	
		
		$("#invoiceList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		$(window).resize(function() {
		 	$("#invoiceList").setGridHeight($(this).height()-260,true);
		});
		
		
		$('#gs_Invoiced').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#invoiceList")[0].triggerToolbar();	
			}
		});	

		
		$('#gs_Due').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#invoiceList")[0].triggerToolbar();	
			}
		});	

		
		$('#gs_Order').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#invoiceList")[0].triggerToolbar();	
			}
		});	


});
</script>
<?php include('inc/footer.php'); ?>