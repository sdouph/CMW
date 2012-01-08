<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>monsoonCRM</title>

<style type="text/css">

body {
 background-color: #fff;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
 text-align:center;
 margin: 50px 0 0 0;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}
label {
color:#666666;
font-size:10px;
margin: 0 10px 0 0;
}

#loginBox{
width: 325px;
height: 175px;
margin:0 auto;
text-align:center;
position:relative;
top:-50px;
}

#logo{
background-image:url(../assets/images/logo_orange_full.png);
margin:0 auto;
padding:0;
width: 300px;
height:80px;
position:relative;
z-index:10000;
}

select{
margin:70px 0 10px 0;
width: 175px;
}

#info{
width:255px; 
margin: 0 0 0 35px;
text-align:left
padding: 0 0 0 10px;
float:left;
}

#error{
font-size:14px;
font-weight:bold;
color:#CC0000;
margin: 20px 0 0 0;




}1

</style>
		<link type="text/css" href="<?=base_url()?>assets/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.8.13/jquery-ui.min.js"></script>
        <script>
$(document).ready(function() 
    { 
				$("#loginButton").button();
				<?php if ($pass==true)
					echo '$("#error").hide();';
				?>
	});		
	
    		</script>
</head>
<body>
<div id="logo"></div>
<div id="loginBox" class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
<form method="post" action="<?=site_url('/login') ?>" >
<input type="hidden" name="location" value="<?= $location ?>">
<div id="info"><label>Username</label><select name="username">
	<?php foreach ($users as $u): ?>
        <option value="<?=$u->USERID?>"><?=$u->USERCODE?></option>
	<?php endforeach; ?>
</select></div>
<div id="info"><label>Password</label><input type="password" name="password" style="width:165px; margin: 0 0 20px 0" /></div>
<input type="submit" value="Login"  id="loginButton">

</form>
<div id="error">Incorrect Password</div>
</div>
</body>
</html>