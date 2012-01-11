<?php include('inc/header.php'); ?>

<table id="openInvoiceList"></table> <!--Grid table-->
<div id="openInvoicePager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 220;
		
		
		$("#openInvoiceList").jqGrid({
			url:'<?=site_url('invoiceOpen/ajaxGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Number', 'Account', 'PO Number','Invoiced', 'Due', 'Discount', 'Amount', 'Balance'],       //Grid column headings
			colModel:[
				{name:'Number',index:'INVOICE_NUMBER', width:'75'},
				{name:'Account',index:'ACCOUNT', width:'200'},
				{name:'PO',index:'PO_NUMBER', width:'150'},
				{name:'Invoiced',index:'INVOICE_DATE', width:'90', align:'center'},
				{name:'Due',index:'DUE_DATE', width:'90', align:'center'},
				{name:'Discount', width:'90', align:'center', search:false},
				{name:'Amount',index:'INVOICE_AMT', width:'90', align:'center', search:false},
				{name:'Balance',index:'INVOICE_BAL', width:'90', align:'center', search:false},
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#openInvoicePager', 
			sortname: 'INVOICE_DATE',
			sortorder: 'DESC',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('invoiceHistory/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#openInvoicePager',{edit:false,add:false,del:false,search:false});
		
			$("#openInvoiceList").jqGrid('navButtonAdd',"#openInvoicePager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#openInvoiceList")[0].clearToolbar();
					$("#gs_Number").val('');
					$("#gs_Account").val('');
					$("#gs_PO").val('');
					$("#gs_Invoiced").val('');
					$("#gs_Due").val('');

				} 
			});
			$("#openInvoiceList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		$(window).resize(function() {
		 	$("#openInvoiceList").setGridHeight($(this).height()-220,true);
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