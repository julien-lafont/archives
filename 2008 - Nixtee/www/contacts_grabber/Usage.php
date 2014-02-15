


<?php
	// Ferdjaoui Sahid <sahid@funraill.org>
	// Contacts classe
	// Usage


require ('Contacts.php');

@header ('Content-Type: text/html; charset=utf-8');

try 
{
	if (!function_exists ('curl_version'))
		throw new Exception ("Curl n'est pas install");


	$user = 'yotsumi@gmail.com';
	$pass = '';
	$type = 'MSN'; // Gmail, Yahoo, Lycos, MSN, AOL
	
	$o = Contacts::factory ($user, $pass, $type);
	print_r ($o->getContacts ());

} 
catch (Exception $e)
{
	echo $e->getMessage ();
}


?>