<?php include('inc/header.php'); ?>

<form id="noteForm" method="post">
<input type="hidden" name="accountid" value="<?= $account->ACCOUNTID?>" />
<div id="base" style="display:block; width:100%; float:left">
<h2>Add Note</h2>
<h4><?=$account->ACCOUNT?></h4>
<input type="text" name="date" id="datepicker" class="calendar"  style="float:left; margin:8px 0 0 0;" value="Choose a Date" />
</div>
<div id="marks" style="float:left; padding-bottom:20px;">
<h3>Visit Types</h3>
<div id="visitCats">
        <?php foreach ($visits as $v):?>
        	 <label class="label_check" for="visit-<?=$v->VISITCATID?>"><input name="visit-<?=$v->VISITCATID?>" id="visit-<?=$v->VISITCATID?>" value="1" type="checkbox" /> <?=$v->VISITCATNAME ?></label>
        <?php endforeach; ?>
</div>


<h3>Complaint Types</h3>

<div id="complaintCats">
        <?php foreach ($complaints as $c):?>
        	 <label class="label_check" for="visit-<?=$c->VISITCATID?>"><input name="visit-<?=$c->VISITCATID?>" id="visit-<?=$c->VISITCATID?>" value="1" type="checkbox" /> <?=$c->VISITCATNAME ?></label>
        <?php endforeach; ?>
</div>
</div>
<div id="notes" style="float:left;">
<h3>Notes</h3>
<textarea name="note" id="note"></textarea>

<div style="clear:both"></div>
<input type="submit" id="submit" value="SUBMIT" style="margin: 10px 0 25px 0"/>
</div>
</form>
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
    var currentDate;
    $(document).ready(function(){
        $('body').addClass('has-js');
        $('.label_check, .label_radio').click(function(){
          	setupLabel();
        });
        setupLabel(); 
	
	
		$( "#datepicker" ).datepicker({
				minDate:'-2W',
				maxDate:'0D',
				dateFormat: 'MM d, yy',
				onSelect:function(dateText, inst){
					if($("input:checked").length > 0) {
						confirmDateChange(); 
					}else{
						if (currentDate == null){
							//currentDate = dateText;
						}
						getExisting();
					}
				} 
		});
		//$( "#datepicker" ).datepicker( "setDate" , '0D');
		
		$("#marks").hide();
		$("#notes").hide();
		
		$("input:checkbox").change(function(){
			if($("input:checked").length > 0) {
				$("#notes").show('slow');
			}else{
				$("#notes").hide('slow');
				$("#note").val('');
			}
		 
		 });

    });
	
	function getExisting(){
		$.ajax({
			url: '<?=site_url()?>/addNote/getExisting/',
			type: "POST",
			data: {date:$( "#datepicker" ).val(), accountid:'<?= $account->ACCOUNTID?>'},
			success: function(data){
				if (data){
					var answer = confirm("There is already visit information for this date, would you like to edit this previous visit?");
					if (answer){
						window.location = '<?=site_url()?>/addNote/edit/' + data;
					}else{
						if (currentDate == undefined){
							$("#datepicker").val("Choose a Date");
							$("#marks").hide();
						}else{
							$("#marks").show('slow');
							$( "#datepicker" ).datepicker('setDate', currentDate);
						}
						
						$( "#datepicker" ).blur();
					}
				}else{
					currentDate = $( "#datepicker" ).val();
					$("#marks").show('slow');
				}
			}
		
		});	
	}
	
	function confirmDateChange(){
		var answer = confirm("All visit information will be lost by changing the date")
			if (answer){
				$("input:checked").attr('checked', false);
				setupLabel(); //change the graphics on custom checkbox images!
				getExisting();

			}else{
				$( "#datepicker" ).datepicker('setDate', currentDate);
					$( "#datepicker" ).blur();
				
			}
	}
	
	$( ".addNote" ).button();
	$(".calendar").button();
	$("#submit").button();
</script> 
<?php include('inc/footer.php'); ?>