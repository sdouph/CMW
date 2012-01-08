<?php include('inc/header.php'); ?>
<?=anchor('addNote/byAccount/'.$accountid, 'VISIT / COMPLAINT', 'class="addNote"')?>
<h2><?=anchor('/accounts/detail/'.$accountid, $account->ACCOUNT, $account->ACCOUNT);?> - Visit History</h2>
<br />
<div id="noteField"><h3>Notes:</h3></div>
<table id="visitList"></table> <!--Grid table-->
<div id="visitPager"></div>  <!--pagination div-->
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.datepick.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.datepick.ext.min.js"></script>
<script>
$(document).ready(function() 
    { 
		$( ".addNote" ).button({icons: {primary: "ui-icon-plusthick"}});

		var myHeight = $(window).height() - $("#visitList").position().top - 100;
		
		$("#visitList").jqGrid({
			url:'<?=site_url('visit/ajaxGrid/'.$accountid)?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['','Date','Type','Category','NoteID','Notes'],       //Grid column headings
			colModel:[
			{name: 'myac', width:80, fixed:true, sortable:false, search:false, resize:false, formatter:'actions',
						formatoptions:{onEdit:function(id){window.location.href = "<?=site_url('/addNote/edit/');?>/"+$("#visitList").getRowData(id).NoteID}, delbutton:false}},	
				{name:'Date',index:'MASTERNOTEDATE', search:true, width:50, align:'center'	},
				<?php    
						$myOptions = '';
						foreach ($visitCats as $v){
							
							$myOptions .=  ";". $v->VISITCATNAME . ":" . $v->VISITCATNAME;
						
						}
					
						foreach ($complaintCats as $v){
							
							$myOptions .=  ";". $v->VISITCATNAME . ":" . $v->VISITCATNAME;
						
						}
					
					
				?>
				{name:'Type', index:'VISITTYPE', width:75, align:'center', stype:"select", searchoptions:{value:":All;Visit:Visit;Complaint:Complaint"}},
				{name:'Category',index:'VISITCATNAME', stype:'select', searchoptions:{dataUrl:'http://alt.dzignmatrix.com/coronacrm/index.php/visit/visitCats_html'}},
	
			{name:'NoteID',index:'MASTERNOTEID', hidden:true},
			{name:'Notes',index:'MASTERNOTE', hidden:true, editable:true},
			],
			rowNum:100,
			width: 600,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#visitPager', 
			sortname: 'MASTERNOTEDATE',
			sortorder: 'desc',
			viewrecords: true,
			editurl: 'fuck',
			
/*			gridComplete: function(){
				var ids = $("#visitList").jqGrid('getDataIDs');
				for(var i=0;i < ids.length;i++){
					var cl = ids[i];
					be = "<input style='height:22px;width:20px;' type='button' value='E'  />"; 
					se = "<input style='height:22px;width:20px;' type='button' value='S'  />"; 
					ce = "<input style='height:22px;width:20px;' type='button' value='C'  />"; 
					$("#visitList").jqGrid('setRowData',ids[i],{act:'fuck off'});
				}	
			},
*/			 onSelectRow: function(id){
			 	$('#noteField').html('<h3>Notes:</h3>' + $("#visitList").getRowData(id).Notes);
			 },
			 ondblClickRow: function(id){
			 	window.location.href = "<?=site_url('/addNote/edit/');?>/"+$("#visitList").getRowData(id).NoteID;
			 }
		}).navGrid('#visitPager',{edit:false,add:false,del:false,search:false});
			$("#visitList").jqGrid('navButtonAdd',"#visitPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#visitList")[0].clearToolbar();
					$("#gs_Date").val('');
					$("#gs_Category").val('');
				} 
			});
			$("#visitList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
			
		
		$(window).resize(function() {
		 	$("#visitList").setGridHeight($(this).height() - 260,true);
		});



		$('#gs_Date').datepicker({
			numberOfMonths: 1,
			dateFormat: 'yy-mm-dd',
			onClose: function(dateText, inst){
				$("#visitList")[0].triggerToolbar();	
			}
		});	
		
});


</script>

<?php include('inc/footer.php'); ?>