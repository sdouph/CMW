<?php include('inc/header.php'); ?>

<h2><?=anchor('/accounts/detail/'.$accountid, $account, $account);?> - Payment & Reciepts</h2><br />
<table id="paymentList"></table> <!--Grid table-->
<div id="paymentPager"></div>  <!--pagination div-->


<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 259;
		
		
		
		$("#paymentList").jqGrid({
			url:'<?=site_url('payment/ajaxGridByAccount/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Number', 'Check Number','Check Date', 'Check Amount'],       //Grid column headings
			colModel:[
				{name:'Number',index:'INVOICE_NUMBER', width:'100'},
				{name:'CheckNumber',index:'CHECK_NUMBER', width:'90', align:'center'},
				{name:'CheckDate',index:'CHECK_DATE', width:'90', align:'center'},
				{name:'Amount',index:'CHECK_AMOUNT', width:'90', align:'center'}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#paymentPager', 
			sortname: 'CHECK_DATE',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('orderOpen/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#paymentPager',{edit:false,add:false,del:false,search:false});
			$("#paymentList").jqGrid('navButtonAdd',"#paymentPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#paymentList")[0].clearToolbar();
					$("#gs_CheckDate").val('');
					$("#gs_Number").val('');
					$("#gs_CheckNumber").val('');
					$("#gs_Amount").val('');
				} 
			});
			$("#paymentList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		
		$(window).resize(function() {
		 	$("#paymentList").setGridHeight($(this).height()-260,true);
		});

		$('#gs_CheckDate').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#paymentList")[0].triggerToolbar();	
			}
		});	
		
});
</script>
<?php include('inc/footer.php'); ?>