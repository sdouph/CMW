<?php include('inc/header.php'); ?>

<form id="noteForm" method="post">
<input type="hidden" name="accountid" value="<?=$account->ACCOUNTID?>" />
<h2>Edit Note for <?=anchor('/visit/byAccount/'.$account->ACCOUNTID, $account->ACCOUNT);?></h2>
<h4></h4>
<input type="text" name="date" id="datepicker" class="calendar" disabled="disabled" style="float:left; margin:8px 0 0 0;" >
<h3>Visit Types</h3>
<div id="visitCats">
        <?php foreach ($allVisits as $v):?>
        	 <label class="label_check" for="visit-<?=$v->VISITCATID?>"><input name="visit-<?=$v->VISITCATID?>" id="visit-<?=$v->VISITCATID?>" value="1" type="checkbox" 
             
             	<?php	foreach ($visits as $myV):
					if ($myV->VISITCATID == $v->VISITCATID){
						echo ' checked="checked" ';
					}
		 		endforeach;
			 ?>
              /> <?=$v->VISITCATNAME ?></label>
        <?php endforeach; ?>
</div>


<h3>Complaint Types</h3>

<div id="complaintCats">
        <?php foreach ($allComplaints as $c):?>
        	 <label class="label_check" for="visit-<?=$c->VISITCATID?>"><input name="visit-<?=$c->VISITCATID?>" id="visit-<?=$c->VISITCATID?>" value="1" type="checkbox"             
             	<?php	foreach ($visits as $myC):
					if ($myC->VISITCATID == $c->VISITCATID){
						echo ' checked="checked" ';
					}
		 		endforeach;
			 ?>
 /> <?=$c->VISITCATNAME ?></label>
        <?php endforeach; ?>
</div>
<h3>Notes</h3>
<textarea name="note" id="note" ><?=$masterNote->MASTERNOTE?></textarea>

<div style="clear:both"></div>
<input type="submit" value="SAVE" id="submit" style="margin: 10px  20px 25px 0;" />
<input type="delete" value="DELETE" id="delVisit" style="margin: 10px  20px 25px 0;" />

</form>
<div style="clear:both"></div>
<script> 
    function setupLabel() {
        if ($('.label_check input').length) {
            $('.label_check').each(function(){ 
                $(this).removeClass('c_on');
            });
            $('.label_check input:checked').each(function(){ 
                $(this).parent('label').addClass('c_on');
            });                
        };
        if ($('.label_radio input').length) {
            $('.label_radio').each(function(){ 
                $(this).removeClass('r_on');
            });
            $('.label_radio input:checked').each(function(){ 
                $(this).parent('label').addClass('r_on');
            }); 
        };
    };
    $(document).ready(function(){
        $('body').addClass('has-js');
        $('.label_check, .label_radio').click(function(){
            setupLabel();
        });
        setupLabel(); 
	
		var myDate = new Date('<?=$masterNote->MASTERNOTEDATE?>');
		var now = new Date();
	
		$( "#datepicker" ).datepicker({
				minDate:'-2W',
				maxDate:'0D',

				dateFormat: 'MM d, yy'
			});
		$( "#datepicker" ).datepicker( "setDate" , myDate);
		
		$( ".addNote" ).button();
		$(".calendar").button();
		$("#submit").button();
		$("#delVisit").button();
		$("#delVisit").click(function(){
			var myDel = confirm("Do you really want to delete the entire visit?");
			if (myDel){
					window.location.href = "<?=site_url('/addNote/delete/'.$masterNote->MASTERNOTEID.'/'.$account->ACCOUNTID);?>";
			}
		});
		
		if ((now - myDate)/86400000 > 14){ //Lock edit if greater than 14 days old
			
			$("input").each(function(i) {
					$(this).attr('disabled', 'disabled');
			});		
			
			$("#submit").val('Record is Locked');
			$("#delVisit").hide();
		}
		
		$("#noteForm").submit(function(){			
			if($("input:checked").length > 0) {
				return true;
			}else{
				alert("Select Visit or Complaint information before saving");
				return false;
			}
			
		});
		
	});
</script> 
<?php include('inc/footer.php'); ?>