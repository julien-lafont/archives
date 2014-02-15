<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
 
 
/**
 * Smarty utf8_encode modifier plugin
 *
 * Type:     modifier<br>
 * Name:     utf8_encode<br>
 * Purpose:  convert string utf-8
 * @author   Eric POMMEREAU
 * @param string
 * @return string
 */
function smarty_modifier_utf8($string)
{
    return utf8_encode($string);
}
 
?>