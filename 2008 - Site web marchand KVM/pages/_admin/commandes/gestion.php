<?php
securite_admin('commandes');

	/* Page non appelée directement */
	
	$id=(int)$_GET['id'];
	$table=PREFIX."commandes";
	
	if (empty($id)) header('location: ?admin-commandes-attentes');

switch(@$_GET['action']) {
	
case "payer":

	$sql=mysql_query("UPDATE $table SET statut='paye', paiement_date=NOW() WHERE id_commande=$id");
	header('location: ?admin-commandes-payees');

break;

case "preparer":

	$sql=mysql_query("UPDATE $table SET statut='preparation' WHERE id_commande=$id");
	header('location: ?admin-commandes-payees');
	
break;

case "expedier":

	$sql=mysql_query("UPDATE $table SET statut='expedie', envoie_date=NOW() WHERE id_commande=$id");
	header('location: ?admin-commandes-historique');
	
break;

case "annulerPaiement":

	$sql=mysql_query("UPDATE $table SET statut='en_attente', paiement_date='' WHERE id_commande=$id");
	header('location: ?admin-commandes-attentes');
	
break;

case "annulerExpedition":

	$sql=mysql_query("UPDATE $table SET statut='paye', envoie_date='' WHERE id_commande=$id");
	header('location: ?admin-commandes-payees');
	
break;
	
}

?>