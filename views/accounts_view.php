<?php include('inc/header.php'); ?>
<table id="accountList"></table> <!--Grid table-->
<div id="accountPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 209;
	
		$("#accountList").jqGrid({
			url:'<?=site_url('accounts/ajaxGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Account','Type', 'Main Phone', 'Email', 'City'<?=($isManager) ? ", 'Owner'" : ""?>],       //Grid column headings
			colModel:[
			{name:'Account',index:'ACCOUNT', width:'175'},
			{name:'Type',index:'TYPE', width:'60', align:'center',  stype:'select', searchoptions:{"value":":All;Customer:Customer;Prospect:Prospect"}},
			{name:'MainPhone',index:'MAINPHONE', width:'90', align:'center'},
			{name:'Email',index:'EMAIL'},
			{name:'City',index:'CITY', width:'100'}
			<?=($isManager) ? ", {name:'Owner',index:'SECCODEDESC'}" : ""?>
			],
			rowNum:100,
			width: 1000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#accountPager', 
			sortname: 'ACCOUNT',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('accounts/detail/') ?>/" + id;
		   },
			viewrecords: true
		}).navGrid('#accountPager',{edit:false,add:false,del:false,search:false});
		
			$("#accountList").jqGrid('navButtonAdd',"#accountPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#accountList")[0].clearToolbar();
					$("#gs_Account").val('');
					$("#gs_MainPhone").val('');
					$("#gs_Email").val('');
					$("#gs_City").val('');
					<?=($isManager) ? '$("#gs_Owner").val("");' : ''?>
				} 
			});
		$("#accountList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
			
		
		$(window).resize(function() {
		 	$("#accountList").setGridHeight($(this).height()-210,true);
		});

});
</script>
<?php include('inc/footer.php'); ?>