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
function just_clean($string)
{
	// Replace other special chars
/*	$specialCharacters = array(
	'#' => ",
	'$' => ",
	'%' => ",
	'&' => ",
	'@' => ",
	'.' => ",
	'€' => ",
	'+' => ",
	'=' => ",
	'§' => ",
	'\\' => ",
	'/' => ",
	);
	
	while (list($character, $replacement) = each($specialCharacters)) {
	$string = str_replace($character, '-' . $replacement . '-', $string);
	}
	
	$string = strtr($string,
	"ÀÁÂÃÄÅ? áâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
	"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"
	);
*/	
	// Remove all remaining other unknown characters
	$string = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $string);
	$string = preg_replace('/^[\-]+/', '', $string);
	$string = preg_replace('/[\-]+$/', '', $string);
	$string = preg_replace('/[\-]{2,}/', ' ', $string);
	
	return $string;
}