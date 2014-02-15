<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage actindo_plugins
 */

/**
 * Include the {@link shared.make_timestamp.php} plugin
 */
require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
/**
 * Smarty date_format_pretty modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     date_format_pretty<br>
 * Purpose:  pretty-print file modification times<br>
 * Input:<br>
 *         - string: input date string
 *         - lang: Locale to use (de_DE,en_US, etc. null for default)
 *         - default_date: default date if $string is empty
 * @author Patrick Prasse <pprasse@actindo.de>
 * @version $Revision: 1.3 $
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
function smarty_modifier_date_format_pretty($string, $timestamp=false)
{
  if ($timestamp===true) 
  	$date = $string;	
  elseif( $string != '' && $string != '0000-00-00' )
    $date = smarty_make_timestamp( $string );
  elseif( isset($default_date) && $default_date != '' )
    $date = smarty_make_timestamp( $default_date );
  else
    return;

	$lang="fr";
    setlocale( LC_TIME, $lang );
    $l = $lang;

  $langs = array(
    'de' => array( 'Gestern', 'Vorgestern' ),
    'en' => array( 'yesterday', '' ),
    'C' => array( 'yesterday', '' ),
	'fr' => array('hier', 'avant-hier')
  );
  $l = split( '_', $l );

  if( $date > strtotime('today 00:00:00') )
    $d = "aujourd'hui";
  elseif( $date > strtotime('yesterday 00:00:00') )
    $d = $langs[$l[0]][0];
  elseif( $date > strtotime('-2 days 00:00:00') )  
    $d = $langs[$l[0]][1];
  elseif( $date > strtotime('-1 week 00:00:00') )
    $d = 'le '.strftime( '%A %d %B', $date);
  else
    $d = 'le '.strftime( '%d %B %Y', $date);

  if( isset($lang) )
    setlocale( LC_TIME, $save_lang );

  return $d;
}
?>