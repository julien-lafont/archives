<?php

// inclusions Ajax
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';
	
	include_once('../pages/forum_class.php');
	$forum = new Forum();
	
switch(@$_GET['act']) {
case "accueil":

	$c=$forum->recuperer_liste_categories();
	$titre="Forums et discussions";
	$url='#accueil';

	echo2($titre.'|:|'.$url.'|:|'.$c);
	
break;

case "liste_sujets":

		$id=(int)$_GET['id'];
		$page=$_GET['page'];
			if (is_numeric($page) && $page!=1) $newPage="-".$page; else $newPage="";
		
	$c=$forum->recuperer_listes_sujets($id, $page);
	$cat=$forum->recuperer_infos_categorie($id);
	
	
	$url='#'.$id.$newPage.'/Categorie-'.recode($cat['nom']).'/';
	
	echo2($titre.'|:|'.$url.'|:|'.$c);
	
break;

case "afficher_message":

		$id=(int)$_GET['id'];
		$page=$_GET['page'];
			if (is_numeric($page) && $page!=1) $newPage="-".$page; else $newPage="";

	$c=$forum->afficher_message($id, $page);
	$mess=$forum->recuperer_infos_sujet($id);
	
	$titre=recode($mess['titre']);
	$url='#'.$id.$newPage.'/Message-'.recode($mess['titre']).'/';
	
	echo2($titre.'|:|'.$url.'|:|'.$c);
	
break;

case "nouveau":

	$id_cat=(int)$_GET['id'];
	$c=$forum->nouveau_message($id_cat);
	$cat=$forum->recuperer_infos_categorie($id_cat);

	$titre="Nouveau message";
	$url='#'.$id_cat.'/Nouveau_Sujet-'.recode($cat['nom']).'/';
	
	echo2($titre.'|:|'.$url.'|:|'.$c);
	
break;

case "repondre":

	$id_mess=(int)$_GET['id'];
	$c=$forum->nouveau_message(NULL, $id_mess);
	$mess=$forum->recuperer_infos_sujet($id_mess);

	$titre="Discussion : répondre";
	$url='#'.$id_mess.'/Repondre-'.recode($mess['titre']).'/';
	
	echo2($titre.'|:|'.$url.'|:|'.$c);
	
break;

case "poster_nouveau_message":

	$id_cat=(int)$_POST['id'];
	$titre=addBdd($_POST['titre']);
	$message=addBdd($_POST['message']);
	$r=$forum->enregistrer_message($id_cat, /* pas une réponse */ NULL, $titre, $message);
	
	echo2($r."|:|".$id_cat);

break;

case "poster_nouvelle_reponse":

	$id_mess=(int)$_POST['id'];
	$message=addBdd($_POST['message']);
	$r=$forum->enregistrer_message(NULL /* pas un new message */, $id_mess, '', $message);
	
	echo2($r."|:|".$id_mess);

break;

case "editer":

	$id_mess=(int)$_GET['id'];
	$c=$forum->editer_message($id_mess);
	$mess=$forum->recuperer_infos_sujet($id_mess);

	$titre="Discussion : répondre";
	$url='#'.$id_mess.'/Editer_message-'.recode($mess['titre']).'/';
	
	echo2($titre.'|:|'.$url.'|:|'.$c);

break;

case "editer_message":

	$id_mess=(int)$_POST['id'];
	$titre=addBdd($_POST['titre']);
	$message=addBdd($_POST['message']);
	$r=$forum->modifier_message($id_mess, $titre, $message);
	
	echo2($r /* statut + id_cat */);

break;






case "invite":

	$r=$forum->afficher_message_membre_seulement();
	
	$titre="Discussion : Inscription nécessaire pour accéder à cette fonctionnalité";
	$url='#invite';
	echo2($titre.'|:|'.$url.'|:|'.$r);

break;



/* ------ ADMIN -------- */

case "admin_edit_sujet":
	securite_admin(true);
	
	$elem=$_POST['element_id'];
		$id=(int)str_replace('idSujet_','',$elem);
	$newSujet=$_POST['update_value'];
	
	$sql=mysql_query("UPDATE ".PREFIX."forum_mess SET titre='".addBdd($newSujet)."' WHERE id=$id");
	
	echo $newSujet;
	
break;

case "admin_edit_message":
	securite_admin(true);
	
	$elem=$_POST['element_id'];
		$id=(int)str_replace('idMess_','',$elem);
	$newMess=$_POST['update_value'];
	
	$sql=mysql_query("UPDATE ".PREFIX."forum_mess SET message='".addBdd($newMess)."' WHERE id=$id");
	
	echo $newMess;
	
break;

case "admin_suppr":
	securite_admin(true);
	
	$id=(int)$_GET['id'];
	
	// Récupère la catégorie :
	$sql=mysql_query("SELECT id_cat FROM ".PREFIX."forum_mess WHERE id=$id") or die(mysql_error());
	$d=mysql_fetch_object($sql);
	
	// Supprime le sujet :
	$sql2=mysql_query("DELETE FROM ".PREFIX."forum_mess WHERE id=$id") or die(mysql_error());
	
	// Redirige vers la catégorie
	header('location: ?act=liste_sujets&id='.$d->id_cat.'&page=1');
	
break;

case "admin_postit":
	securite_admin(true);
	
	$id=(int)$_GET['id'];
	$act=(int)$_GET['action'];
	
	$sql=mysql_query("UPDATE ".PREFIX."forum_mess SET etat=$act WHERE id=$id");
	
	if ($sql) echo "ok";
	else	  echo "bad";
		
break;

}

?>