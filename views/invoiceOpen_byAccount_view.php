<?php include('inc/header.php'); ?>

<h2><?=anchor('/accounts/detail/'.$accountid, $account, $account);?> - Open Invoices</h2><br />
<table id="openInvoiceList"></table> <!--Grid table-->
<div id="openInvoicePager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 259;
		
		
		$("#openInvoiceList").jqGrid({
			url:'<?=site_url('invoiceOpen/ajaxGridByAccount/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Number', 'Invoiced', 'PO Number', 'Due Date', 'Amount', 'Balance', 'Comment'],       //Grid column headings
			colModel:[
				{name:'Number',index:'INVOICE_NUMBER', width:'100'},
				{name:'Invoiced',index:'INVOICE_DATE', width:'90', align:'center', search:true},
				{name:'PO',index:'PO_NUMBER', width:'150'},
				{name:'Due',index:'DUE_DATE', width:'90', align:'center', search:true},
				{name:'Amount',index:'INVOICE_AMT', width:'90', align:'center', search:false},
				{name:'Balance',index:'INVOICE_BAL', width:'90', align:'center', search:false},
				{name:'Comment',index:'INV_COMMENT', search:false}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#openInvoicePager', 
			sortname: 'INVOICE_DATE',
			sortorder: 'desc',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('invoiceHistory/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#openInvoicePager',{edit:false,add:false,del:false,search:false});
			$("#openInvoiceList").jqGrid('navButtonAdd',"#openInvoicePager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#openInvoiceList")[0].clearToolbar();
					$("#gs_Number").val('');
					$("#gs_PO").val('');
					$("#gs_Invoiced").val('');
					$("#gs_Due").val('');

				} 
			});
			$("#openInvoiceList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		$(window).resize(function() {
		 	$("#openInvoiceList").setGridHeight($(this).height()-260,true);
		});
		$('#gs_Invoiced').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#openInvoiceList")[0].triggerToolbar();
			}
		});	
		

		$('#gs_Due').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#openInvoiceList")[0].triggerToolbar();	
			}
		});	
		
});
</script>
<?php include('inc/footer.php'); ?>