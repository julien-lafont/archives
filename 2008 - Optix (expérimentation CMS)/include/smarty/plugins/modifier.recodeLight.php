<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_recodeLight($string)
{

	
   return recode($string, true, true);

}


?>