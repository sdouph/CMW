<?php include('inc/header.php'); ?>
<h2>Complaints: <?=anchor('/accounts/detail/'.$accountid, $account->ACCOUNT, $account->ACCOUNT);?></h2>
<br />
<div id="noteField"><h3>Notes:</h3></div>
<table id="complaintList"></table> <!--Grid table-->
<div id="complaintPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 

		$("#complaintList").jqGrid({
			url:'<?=site_url('complaint/ajaxGrid/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Start Date','End Date','Category','NoteID','Notes'],       //Grid column headings
			colModel:[
				{name:'StartDate',index:'startDATE', search:true, width:50},
				{name:'EndDate',index:'endDATE', search:true, width:50},
				{name:'Category',index:'COMPLAINTCATNAME',  stype:'select', searchoptions:{"value":":All<?php    
						
						foreach ($complaintCats as $c){
							
							echo  ";". $c->COMPLAINTCATNAME . ":" . $c->COMPLAINTCATNAME;
						
						}
					
					
				
				?>"}},
				
			{name:'NoteID',index:'MASTERNOTEID', hidden:true},
			{name:'Notes',index:'MASTERNOTE', hidden:true}


			],
			rowNum:100,
			width: 600,
			height: 300,
			rowList:[100,250,500],
			pager: '#complaintPager', 
			sortname: 'MASTERNOTEDATE',
			sortorder: 'desc',
			viewrecords: true,
			 onSelectRow: function(id){
			 	$('#noteField').html('<h3>Notes:</h3>' + $("#complaintList").getRowData(id).Notes);
			 },
			 ondblClickRow: function(id){
			 	window.location.href = "<?=site_url('/addNote/edit/');?>/"+$("#complaintList").getRowData(id).NoteID;
			 }
		}).navGrid('#complaintPager',{edit:false,add:false,del:false,search:false});
			$("#complaintList").jqGrid('filterToolbar',{"stringResult":true});
			
						
		$('#gs_StartDate').datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function (dateText, inst) {
				$('#gs_EndDate').datepicker( "option", "minDate",  $(this).datepicker('getDate'));
				$(this).focus();
				$(this).change();
			}});	

		$('#gs_EndDate').datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function (dateText, inst) {
				$('#gs_StartDate').datepicker( "option", "maxDate",  $(this).datepicker('getDate'));
				$(this).focus();
				$(this).change();
			}});	


});
</script>

<?php include('inc/footer.php'); ?>