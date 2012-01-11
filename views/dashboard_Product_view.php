<?php include('inc/header.php'); ?>
<h2>Product Sales Report</h2>
<div id="myDates">
	<div id="icons">
	<a href="javascript:void(0);" onclick="saveReport()" id="reportSave" title="Save Report">Save</a>
	<a href="javascript:void(0);" onclick="printReport()" id="reportPrint" title="Print Report">Print</a>
	
</div>
    <label style="margin-left: 20px">Date Range</label>
    <select id="dateRange" name="dateRange">
        <option value="lastYear" selected="selected">Last Year</option>
        <option value="lastMonth">Last Month</option>
        <option value="custom">Custom</option>
    </select>
   <div id="specificDate" style="display:none">
        <label>Start Date</label><input id="startDate" name="startDate" value="<?=mdate('%Y-%m-%d', mktime(0,0,0,1,1, date("Y")))?>" />
        <label>End Date</label><input id="endDate" name="endDate" value="<?=mdate('%Y-%m-%d')?>" />
   </div>
 <label style="margin-left: 175px">Select Report</label><select id="reportType" name="reportType">
  <option value="productSales" selected="selected">Product Sales Report</option>
  <option value="customer">Customer Report</option>
<!--  <option value="visitHistory">Visit History Report</option>
  <option value="complaints">Complaint Report</option>
--></select></div>
<div style="clear: both"></div>
<table id="dashboardList"></table> <!--Grid table-->
<div id="dashboardPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - $("#dashboardList").position().top - 100;

		$("#dashboardList").jqGrid({
			url:'<?=site_url('dashboard/productSalesGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
				
				colNames:['Item ID','Description', 'QTY', 'AVG Unit Price', 'Total Extended Price'],       //Grid column headings
				colModel:[
				{name:'ItemID',index:'ITEM_ID', width:50, align:"center"},
				{name:'Description',index:'ITEM_DESC1', width:400},
				{name:'Quantity',index:'QTY_ORDERED', width:50, align:"center", search:false},
				{name:'AVG Unit Price',index:'AVG_UNIT_PRICE', width:100, align:"center", search:false},
				{name:'Total Extended Price',index:'TOTAL_EXTENDED_PRICE', width:125, align:"center", search:false}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#dashboardPager', 
			sortname: 'QTY_ORDERED',
			sortorder: 'DESC',
			subGrid : false,
			subGridUrl: '<?=site_url('dashboard/productSalesGrid_byItem/')?>',
		    subGridModel: [{ name  : ['Invoice Number','Invoiced','Quantity', 'Unit Price', 'Extended Price'], 
		                    width : [200,200,200,200,200] } 
		    ],
			viewrecords: true
		}).navGrid('#dashboardPager',{edit:false,add:false,del:false,search:false});
			$("#dashboardList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		$(window).resize(function() {
		 	$("#dashboardList").setGridHeight($(this).height() - 260,true);
		});
		
		$('#startDate').datepicker({
			numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
			onSelect: function (dateText, inst) {
				$('#endDate').datepicker( "option", "minDate",  $(this).datepicker('getDate'));
			},
			onClose: function(dateText, inst){
				$("#dashboardList").jqGrid('setGridParam',{postData:{start:$("#startDate").val(), end:$("#endDate").val()	}}).trigger("reloadGrid");
/*				$(this).focus();
				$(this).change();
*/			
			}
		});	

		
		$('#endDate').datepicker({
			numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
			onSelect: function (dateText, inst) {
				
				$('#startDate').datepicker( "option", "maxDate",  $(this).datepicker('getDate'));
			},
			onClose: function(dateText, inst){
				$("#dashboardList").jqGrid('setGridParam',{postData:{start:$("#startDate").val(), end:$("#endDate").val()	}}).trigger("reloadGrid");
/*				$(this).focus();
				$(this).change();
*/			
			}
		});	

		$("#reportType").change(function(){
			window.location.href = $(this).val();
		});
		

});

function printReport(){
	
	temp = $("#dashboardList").jqGrid('getGridParam', 'postData');
	var t='/?_print=true';
	for (var i in temp){
		t += '&' + i + '=' + temp[i];	
	}
	
	window.open('<?=site_url("dashboard/productSalesPrint")?>'+t, '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=no,screenx=0,screeny=0');
	
}

function saveReport(){
	
	temp = $("#dashboardList").jqGrid('getGridParam', 'postData');
	var t='/?_print=true';
	for (var i in temp){
		t += '&' + i + '=' + temp[i];	
	}
	
	window.open('<?=site_url("dashboard/productSalesXLS")?>'+t, '_top');
	
}
</script>
<?php include('inc/footer.php'); ?>