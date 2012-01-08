<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* Class dateOperations
* Created in July 07, 2009, by Vicente Russo Neto <vicente@vrusso.com.br>
* 
* @param    integer $date - the date to be processed
* @param    string  $what - what piece of date to process, day, month or year
* @param    integer $value - how much will be increased or decreased
* @param    string  $return_format - 'mysql' format or 'timestamp' format 
* @author   Vicente Russo Neto <vicente@vrusso.com.br>
* @return   string|boolean
* @version  0.1
* 
* Description: This class can add or subtract days, months or years and return the result. Created for
* PHP Framework CodeIgniter (www.codeigniter.com). Tested on 1.7.1.
*
* Usage:
* $this->load->library('dateoperations');
* echo $this->dateoperations->subtract('2009-07-01','day',1); // Prints: 2009-06-30
* echo $this->dateoperations->sum('2009-07-01','year',1); // Prints: 2010-07-01 
* echo $this->dateoperations->subtract('2009-07-01','day',15); // Prints: 2009-06-16
*/

class dateOperations {
    
    function sum($date,$what=FALSE,$value,$return_format='mysql') {
        
        list($year, $month, $day) = explode("-", $date);
              
        if ($what!='day' && $what!='month' && $what!='year') return false;
        
        if ($what=='day')   $day    = $day + intval($value); 
        if ($what=='month')     $month  = $month + intval($value);
        if ($what=='year')  $year   = $year + intval($value);
        
        $date_tmp = mktime(0, 0, 0, $month, $day, $year);    
            
        if ($return_format=='mysql') {
            $date_tmp = date('Y-m-d', $date_tmp);
        } elseif (!$return_format=='timestamp') {
            return false;   
        }
                       
        return $date_tmp;
        
    }
    
    
    function subtract($date,$what=FALSE,$value,$return_format='mysql') {
        
        list($year, $month, $day) = explode("-", $date);
           
        if ($what!='day' && $what!='month' && $what!='year') return false;    
        
        if ($what=='day')   $day    = $day - intval($value); 
        if ($what=='month')     $month  = $month - intval($value);
        if ($what=='year')  $year   = $year - intval($value);
        
        $date_tmp = mktime(0, 0, 0, $month, $day, $year);    
        
        if ($return_format=='mysql') {
            $date_tmp = date('Y-m-d', $date_tmp);
        } elseif (!$return_format=='timestamp') {
            return false;   
        }
                       
        return $date_tmp;
        
    }

    
}

?>