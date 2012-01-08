<?php include('inc/header.php'); ?>
<table id="contactList"></table> <!--Grid table-->
<div id="contactPager"></div>  <!--pagination div-->

<script>
$(document).ready(function() 
    { 
		var myHeight = $(window).height() - 219;
		
		
		$("#contactList").jqGrid({
			url:'<?=site_url('contacts/ajaxGrid/')?>',      //another controller function for generating XML data
			mtype : "post",             //Ajax request type. It also could be GET
			datatype: "xml",            //supported formats XML, JSON or Arrray
			colNames:['Last', 'First','Type', 'contact', 'Work', 'Home', 'Fax', 'Mobile', 'Email', 'Web'<?=($user == "ADMIN       ") ? ", 'Owner'" : ""?>],       //Grid column headings
			colModel:[
				{name:'Last',index:'LASTNAME'},
				{name:'First',index:'FIRSTNAME'},
				{name:'Type',index:'TYPE', width:'90', align:'center',  stype:'select', searchoptions:{"value":":All;Customer:Customer;Prospect:Prospect"}},
				{name:'Account',index:'contact', width:'150'},
				{name:'Work',index:'WORKPHONE', width:'90', align:'center', search:false},
				{name:'Home',index:'HOMEPHONE', width:'90', align:'center', search:false},
				{name:'Fax',index: 'FAX', width:'90', align:'center', search:false},
				{name:'Mobile',index: 'MOBILE', width:'90', align:'center', search:false},
				{name:'Email',index:'EMAIL'},
				{name:'Web',index:'WEBADDRESS'}
				<?=($user == "ADMIN       ") ? ", {name:'Owner',index:'SECCODEDESC'}" : ""?>
			],
			rowNum:100,
			width: 2000,
			height: myHeight,
			rowList:[100,250,500],
			pager: '#contactPager', 
			sortname: 'LASTNAME',
			onSelectRow: function(id){ 
			  window.location = "<?=site_url('contacts/detail/') ?>/" + id;
		   },
		   
			viewrecords: true
		}).navGrid('#contactPager',{edit:false,add:false,del:false,search:false});
			$("#contactList").jqGrid('navButtonAdd',"#contactPager",{caption:"",title:"Clear Search",buttonicon :'ui-icon-cancel',
				onClickButton:function(){
					$("#contactList")[0].clearToolbar();
					$("#gs_Last").val('');
					$("#gs_First").val('');
					$("#gs_Account").val('');
					$("#gs_Email").val('');
					$("#gs_Web").val('');
				} 
			});
		$("#contactList").jqGrid('filterToolbar',{"stringResult":true, "searchOnEnter":false});
			
					
		$(window).resize(function() {
		 	$("#contactList").setGridHeight($(this).height()-210,true);
		});
});
</script>

<?php include('inc/footer.php'); ?>