<?php

// Configuration d'origine //
$from="2-4-5-6-8-7";
$new="3-5-9-8-7";

$idFrom=1;
$idNew=16;

// Actions //

	if (!empty($from)) $tabloF=explode('-', $from);
	else $tabloF=array();
	
	# on vérifie que le membre n'a pas déjà cet ami
	if (!in_array($idNew, $tabloF))
	{
		$tempTab=array_reverse($tabloF);
		array_push($tempTab, $idNew);
		$newTab=array_reverse($tempTab);
		$newListF=implode("-", $newTab);	
	}
?>