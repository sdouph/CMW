<?php include('inc/header.php'); ?>
<h2>Customer Report</h2>
<div id="myDates">
	<div id="icons"> 	<?=anchor('dashboard/productSalesXLS/', 'Download', 'title="Save as Excel File" id="reportSave"')?>
	<?=anchor('dashboard/productSalesXLS/', 'Print', 'title="Print Report" id="reportPrint"')?>
</div>
   <label>Start Date</label><input id="startDate" name="startDate" value="<?=mdate('%Y-%m-%d', mktime(0,0,0, 1, 1, date("Y")))?>" />
    <label>End Date</label><input id="endDate" name="endDate" value="<?=mdate('%Y-%m-%d')?>" />
 <label style="margin-left: 175px">Select Report</label><select id="reportType" name="reportType">
  <option value="productSales">Product Sales Report</option>
  <option value="customer" selected="selected">Customer Report</option>
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
			url:'<?=site_url('dashboard/customerGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
				
				colNames:['Account','Total Sales'],       //Grid column headings
				colModel:[
				{name:'Account',index:'ACCOUNT', width:800, search:true},
				{name:'Total',index:'NET_INVOICE', width:200, align:"right", search:false}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#dashboardPager', 
			sortname: 'NET_INVOICE',
			sortorder: 'DESC',
			subGrid : true,
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
</script>
<?php include('inc/footer.php'); ?>