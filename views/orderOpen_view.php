<?php include('inc/header.php'); ?>

<table id="openOrderList"></table> <!--Grid table-->
<div id="openOrderPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 209;
		
		
		$("#openOrderList").jqGrid({
			url:'<?=site_url('orderOpen/ajaxGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Number', 'Date','Account','Type', 'Confirm To', 'Comment', 'Total', 'Balance'],       //Grid column headings
			colModel:[
				{name:'Number',index:'ORDER_NUMBER', width:'75'},
				{name:'Date',index:'ORDER_DATE', width:'90', align:'center'},
				{name:'Account',index:'ACCOUNT', search:true},
				{name:'Type',index:'ORDER_TYPE', width:'100',  stype:'select', searchoptions:{"value":":All;Standard:Standard;Quote:Quote;Back Order:Back Order"}},
				{name:'Confirm',index:'CONFIRM_TO', width:'90', align:'center', search:true},
				{name:'Comment',index:'ORDER_COMMENT', search:true},
				{name:'Amount',index:'ORDER_TOTAL', width:'90', align:'center', search:false},
				{name:'Balance',index:'ORDER_BALANCE', width:'90', align:'center', search:false}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#openOrderPager', 
			sortname: 'ORDER_DATE',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('orderOpen/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#openOrderPager',{edit:false,add:false,del:false,search:false});
			$("#openOrderList").jqGrid('navButtonAdd',"#openOrderPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#openOrderList")[0].clearToolbar();
					$("#gs_Date").val('');
					$("#gs_Number").val('');
					$("#gs_Account").val('');
					$("#gs_Type").val('');
					$("#gs_Confirm").val('');
					$("#gs_TComment").val('');
				} 
			});
			$("#openOrderList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		
		$(window).resize(function() {
		 	$("#openOrderList").setGridHeight($(this).height()-210,true);
		});

		$('#gs_Date').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#openOrderList")[0].triggerToolbar();	
			}
		});	
		

});
</script>
<?php include('inc/footer.php'); ?>