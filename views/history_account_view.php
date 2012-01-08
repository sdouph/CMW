<?php include('inc/header.php'); ?>

<h2><?=anchor('/accounts/detail/'.$accountid, $account);?> - Notes</h2><br />
<table id="historyList"></table> <!--Grid table-->
<div id="historyPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 259;
		
		
		$("#historyList").jqGrid({
			url:'<?=site_url('history/ajaxGridByAccount/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Date', 'Contact', 'Description', 'Notes', 'User'],       //Grid column headings
			colModel:[
				{name:'Date',index:'ORIGINALDATE', search:true},
				{name:'Contact',index:'CONTACTNAME', search:true},
				{name:'Description',index:'DESCRIPTION', search:true,  stype:'select', searchoptions:{"value":":All;Cold Call:Cold Call;E-mail:E-mail;Follow up:Follow up;General:General;Issue:Issue;Maintence:Maintence;Meeting:Meeting;Opportunity:Opportunity;Phone:Phone Call;Service:Service;Visit:Visit"}},
				{name:'Notes',index:'LONGNOTES', width:700, search:true},
				{name:'User',index:'USERNAME',  search:true}
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#historyPager', 
			sortname: 'ORIGINALDATE',
			sortorder: 'desc',
			viewrecords: true
		}).navGrid('#historyPager',{edit:false,add:false,del:false,search:false});
			
		$("#historyList").jqGrid('navButtonAdd',"#historyPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#historyList")[0].clearToolbar();
					$("#gs_Date").val('');
					$("#gs_Contact").val('');
					$("#gs_Note").val('');
					$("#gs_User").val('');
					$("#gs_Description").val('');
				} 
			});
		$("#historyList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
		
		$(window).resize(function() {
		 	$("#historyList").setGridHeight($(this).height()-260,true);
		});
	
		$('#gs_Date').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#historyList")[0].triggerToolbar();	
			}
		});	
		

});
</script>
<?php include('inc/footer.php'); ?>
