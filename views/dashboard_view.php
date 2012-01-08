<?php include('inc/header.php'); ?>
<div id="myDates">
	
    <label>Start Date</label><input id="startDate" name="startDate" value="<?=mdate('%Y-%m-%d', mktime(0,0,0, date("m")-1, date("d"), date("Y")))?>" />
    <label>End Date</label><input id="endDate" name="endDate" value="<?=mdate('%Y-%m-%d')?>" />
<select id="reportType" name="reportType"><option>Product Sales Report</option><option>Customer Report</option><option>Visit History Report</option><option>Complaint Report</option></select></div>
<h2>Product Sales Report</h2>
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
				
				colNames:['Item ID','Description', 'Quantity', 'AVG Unit Price', 'Total Extended Price'],       //Grid column headings
				colModel:[
				{name:'Item ID',index:'ITEM_ID', width:50, align:"center"},
				{name:'Description',index:'ITEM_DESC1', width:400},
				{name:'Quantity',index:'QTY_ORDERED', width:50, align:"center", search:false},
				{name:'AVG Unit Price',index:'AVG_UNIT_PRICE', width:100, align:"center", search:false},
				{name:'Total Extended Price',index:'TOTAL_EXTENDED_PRICE', width:125, align:"center", search:false}
			],
			rowNum:100,
			width: 1000,
			height: 600,
			rowList:[100,250,500],
			pager: '#dashboardPager', 
			sortname: 'ITEM_ID',
			subGrid : true,
			subGridUrl: '<?=site_url('dashboard/productSalesGrid_byItem/')?>',
		    subGridModel: [{ name  : ['Invoice Number','Invoiced','Quantity', 'Unit Price', 'Extended Price'], 
		                    width : [200,200,200,200,200] } 
		    ],
			viewrecords: true
		}).navGrid('#dashboardPager',{edit:false,add:false,del:false,search:false});
			$("#dashboardList").jqGrid('filterToolbar',{"stringResult":true});
		
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

	

});
</script>
<?php include('inc/footer.php'); ?>