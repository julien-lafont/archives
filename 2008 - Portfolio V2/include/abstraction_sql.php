<?php
/*
 * REMPLACER CES PSEUDO-FONCTIONS PAR UNE CLASSE MYSQL COMPLETE
 *
*/


//:: Connexion Mysql :://
$db = mysql_connect(HOTE, LOGIN, PASS) or die ("<b>Erreur de connexion</b>");
mysql_select_db(BASE, $db) or die ("<b>Erreur de connexion base</b>");


function _mysql_error($q) {
    echo  'Une erreur MYSQL est survenue : <br />
			<b>Requête</b> : '.$q.'<br />
			<b>Erreur</b> : '.mysql_error();  
    exit;      
}

function mysql_q($query) {
	//echo $query.'<br /><br />----';
    if(($res = mysql_query($query)) === FALSE) {
        _mysql_error($query);
    }
	return $res;
}

// Fonction retournant un résultat spécialement formaté pour Smarty
function mysql_tab($query, $crop=true) {
	$sortie=array();
	$res=mysql_q($query);

    if(is_array($sortie) === FALSE) {
        $sortie = @mysql_fetch_assoc($res);
        foreach($sortie as $k => $_r) $sortie[$k] = $_r;
        @mysql_free_result($res);
        return 0;
    }
    while($r = @mysql_fetch_assoc($res)) {
        foreach($r as $k => $_r) $r[$k] = $_r;
        array_push($sortie, $r);
    }
    @mysql_free_result($res);
	
	if ($crop and count($sortie)==1) $sortie=$sortie[0];
	
    return $sortie;
}

function mysql_nb($query, $exec=false) {
	if ($exec==false) $sql=mysql_q($query);
	else 		  $sql=$query;
	
	$nb=mysql_num_rows($sql);
	///@mysql_free_result($sql);
	return round($nb);
}

?>