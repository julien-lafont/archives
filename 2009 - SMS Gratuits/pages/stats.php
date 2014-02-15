<?php
//security(); /* en double mais bon */
//if ($_SESSION['sess_level']!=5) exit("Accés interdit");

setlocale (LC_ALL, "fr_FR");

$list=array();
$sql=mysql_query("SELECT date FROM historique"); // stats par jour 

$sql2=mysql_query("SELECT total FROM stats") or die (mysql_error()); // nb total
$f=mysql_fetch_object($sql2);

$sql3=mysql_query("SELECT id, total FROM membres ORDER BY total DESC") or die (mysql_error()); // nb membres 
$nbMembre=mysql_num_rows($sql3);
$h=mysql_fetch_object($sql3); // MAX SMS pour 1 membre

$sql4=mysql_query("SELECT sum(click) as nbclic, sum(fraude) as nbfraude FROM membres"); // nb Fraude + nb click
$e=mysql_fetch_object($sql4);

$sql5=mysql_query("SELECT pseudo, total, click FROM membres ORDER BY total DESC Limit 0,5"); // Top 5 SMSeurs

while ($d=mysql_fetch_object($sql)) {
	$list[]=date('d m y',$d->date);
}
	
$i=-1; $old=0;
while($i++<=count($list)) {
	if ($list[$i]==$old && $old!=0) {
		if (!$stats[$list[$i]]) $stats[$list[$i]]+=2;
		else $stats[$list[$i]]+=1;
	}
	$old=$list[$i];
}

$design['contenu']="<h2>Statistiques du site </h2> <br /><br /><br />

SMS envoyés au total : <b>$f->total</b><br />
Membres : <b>$nbMembre</b><br />
Clicks : <b>$e->nbclic</b><br />
Fraude : <b>$e->nbfraude</b><br />
<br /><br />";

// Stats SMS / jour
$design['contenu'].='<div style="width:90%; text-align:left; margin-left:50px"><b>Nombres de SMS envoyés par jour</b><br /><br />';
	
	
	foreach($stats as $key => $value) {
	
			$exp=explode(" ",$key);
			$dateFr=strftime("%a ".$exp[0]." %B", mktime( "0","0" ,"0" ,$exp[1], $exp[0], $exp[2] ) );
			$longueur=round((500*$value)/max($stats));
	
		$design['contenu'] .="<div style='float:left; width:100px; height:18px; background-color:#FFF; color:#333; text-align:center; border:1'>$dateFr</div>
							<div style='float:left; width:500px; height:16px;border:1px dashed #7F7F7F;'></div>
							<div style='position:absolute; margin-left:100px; height:18px; width:".$longueur."px; background-color:#09F; text-align:right;'>".$value."&nbsp;&nbsp;</div>
							<div style='clear:both; height:5px'></div>";
	}
$design['contenu'].="</div>";

// Stats Top 3 SMSeurs
$design['contenu'].='<br /><br /><div style="width:90%; text-align:left; margin-left:50px"><b>Les 5 membres les + actifs</b><br /><br />';
	
	while($g=mysql_fetch_object($sql5)) {	
	
		$longueur=round(($g->total*500)/($h->total));
		$design['contenu'] .="<div style='float:left; width:100px; height:18px; background-color:#FFF; color:#333; text-align:center; border:1'>".ucfirst($g->pseudo)."</div>
							<div style='float:left; width:500px; height:16px;border:1px dashed #7F7F7F;'></div>
							<div style='position:absolute; margin-left:100px; height:18px; width:".$longueur."px; background-color:#09F; text-align:right;'><b>".$g->total."</b> - ".$g->click."&nbsp;&nbsp;</div>
							<div style='clear:both; height:5px'></div>";
	
	}
$design['contenu'].="</div><br /><br />";

?>