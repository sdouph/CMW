<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Formats phone numbers
 * If phone number is longer than 10 digits
 * The rest are considered an extension
 *
 * @param varchar $str The unformated phone number
 * @param boolean $extension TRUE/FALSE to use the extension
 * @return Formated Phone number
 */
function phone_format($str,$extension = FALSE)
{
    if ($str){
		// Keep only be digits
		//$str = str_replace('.', '',$str);
		$strPhone = preg_replace("/[^0-9]/",'', $str);
	
		$strArea = substr($strPhone, 0, 3);
		$strPrefix = substr($strPhone, 3, 3);
		$strNumber = substr($strPhone, 6, 4);
		$strExtens = substr($strPhone,10);
	
		$strPhone = '(' . $strArea . ') ' . $strPrefix . '-' . $strNumber;
	
		if ($strExtens && $extension)
		{
			$strPhone .= ' ext.'.$strExtens;
		}
	
		return $strPhone;
	}
} 

function dollar_format($str){

	$isNeg = substr($str, 0, 1);
	
	if ($isNeg == '-'){
		$conv = "-$";
		$conv .= number_format(substr($str,1), 2, '.', ',');
	
	}else{
		$conv = "$";
		$conv .= number_format($str, 2, '.', ',');
	
	}
	

	return $conv;

}

function mssql_date_fix($str){
	return substr ($str, 0, 10);

}