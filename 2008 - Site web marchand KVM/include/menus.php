<?php

/* 
 * KVM E-commerce : menus.php
 *
 * Met en forme les différents menus ( ou blocs ) 
 * Exception : le menu membre est quand à lui situé dans le fichier fonctions.php
 */
 
 
//#### Menu administrateur ####//
$m = '
	<ul id="nav">
		<li class="first"><a href="?accueil">Accueil site</a></li>
		<li'; if ($page=="admin-accueil") $m.=' class="active"'; $m.='><a href="?admin-accueil">Accueil admin</a></li>';
		
		if ($_SESSION['admin_droits']['editorial']) {
			
		$m.='<li'; if (strpos($page, 'produits')!==false) $m.=' class="active"'; $m.='><a href="#">Produits</a>
				<ul>
				<li class="first'; if ($page=="admin-produits-gerer") $m.=' active'; $m.='"><a href="?admin-produits-gerer">G&eacute;rer produits</a></li>
				<li'; if ($page=="admin-produits-ajouter") $m.=' class="active"'; $m.='><a href="?admin-produits-ajouter">Ajouter produit</a></li>
				<li'; if ($page=="admin-produits-rechercher") $m.=' class="active"'; $m.='><a href="?admin-produits-rechercher">Rechercher produit</a></li>
				<li'; if ($page=="admin-produits-categories") $m.=' class="active"'; $m.='><a href="?admin-produits-categories">Cat&eacute;gories</a></li>
				<li'; if ($page=="admin-produits-marques") $m.=' class="active"'; $m.='><a href="?admin-produits-marques">Marques</a></li>
				<li class="last'; if ($page=="#") $m.=' active'; $m.='"><a href="?admin-produits-pageAccueil">Produits pages d\'accueil</a></li>
				</ul>
			</li>';
		
		}
		
		if ($_SESSION['admin_droits']['commandes']) {
			
		$m.='<li'; if (strpos($page, 'commandes')!==false) $m.=' class="active"'; $m.='><a href="#">Commandes</a>
				<ul>
				<li class="first'; if ($page=="admin-commandes-attentes") $m.=' active'; $m.='"><a href="?admin-commandes-attentes">En attente de paiement</a></li>
				<li'; if ($page=="admin-commandes-payees") $m.=' class="active"'; $m.='><a href="?admin-commandes-payees">Commandes payées</a></li>
				<li'; if ($page=="admin-commandes-historique") $m.=' class="active"'; $m.='><a href="?admin-commandes-historique">Historiques des commandes</a></li>
				<li class="last'; if ($page=="admin-commandes-rechercher") $m.=' active'; $m.='"><a href="?admin-commandes-rechercher">Rechercher une commande</a></li>
				</ul>
			</li>';
			
		}
		
		if ($_SESSION['admin_droits']['membres']) {
			
		$m.='<li'; if (strpos($page, 'membres')!==false) $m.=' class="active"'; $m.='><a href="#">Clients et Admins</a>
				<ul>
				<li class="first'; if ($page=="admin-membres-rechercher") $m.=' active'; $m.='"><a href="?admin-membres-rechercher">Rechercher un client</a></li>
				<li'; if ($page=="admin-membres-gererAdmin") $m.=' class="active"'; $m.='><a href="?admin-membres-gererAdmin">Gérer les admins</a></li>
				<li class="last'; if ($page=="admin-membres-ajouterAdmin") $m.=' active'; $m.='"><a href="?admin-membres-ajouterAdmin">Ajouter les admins</a></li>
				</ul>
			</li>';
			
		}
		
		if ($_SESSION['admin_droits']['config']) {
			
		$m.='<li class="last'; if (strpos($page, 'config')!==false) $m.=' active'; $m.='"><a href="#">Panneau d\'admin</a>
				<ul>
				<li class="first'; if ($page=="admin-config-general") $m.=' active'; $m.='"><a href="?admin-config-general">Configuration</a></li>
				<li'; if ($page=="admin-config-fdp") $m.=' class="active"'; $m.='><a href="?admin-config-fdp">Gestion frais de port</a></li>
				<li class="last'; if ($page=="admin-config-devises") $m.=' active'; $m.='"><a href="?admin-config-devises">Gérer les devises</a></li>
				</ul>
			</li>';
			
		}
		$m.='<li><a href="deconnexion.htm">Déconnexion</a></li>
		</ul>';
	

$design->zone('menu_admin', $m);



//#### Menu listant les catégories d'articles ####//

	$menu_cat="<h5>Catégories</h5>
				<a href='categories.htm'><strong>Toutes les catégories</strong></a><br /><br />
				
				<ul>";
	$sqlCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=0");
	while($cat=mysql_fetch_object($sqlCat)) {
		
		// On ajoute la catégorie à la liste:
		$menu_cat.="<li><a href='categorie-".$cat->id_cat."-".recode(recupBdd($cat->nom)).".htm'>".recupBdd($cat->nom)."</a>";
		
		// Y-a-t-il des sous catégories ?
	 	$sqlSousCat=mysql_query("SELECT * FROM ".PREFIX."categories WHERE id_cat_parent=".$cat->id_cat);	 	
	 		if (mysql_affected_rows()==0) $menu_cat.="</li>"; 
	 		else $menu_cat.="<ul>";
	 	
	 	while($scat=mysql_fetch_object($sqlSousCat)) {
			$menu_cat.="<li><a href='categorie-".$scat->id_cat."-".recode(recupBdd($scat->nom)).".htm'>".recupBdd($scat->nom)."</a></li>";
		}
		
		if (mysql_affected_rows()!=0) $menu_cat.="</ul>
												</li>"; 
		
	}
	
	$menu_cat.="</ul>";
	
	$design->zone('menu_categories', $menu_cat);

	
	
//#### Menu Panier : affiche le panier ####//

	$liste_panier=gestion_panier(); /* Initialise et sécurise la gestion des sessions membres/invités pr la gestion des paniers */
	$liste_panier_misenforme=lister_panier($liste_panier);
		
	if ($page!="panier") {

		$menu_panier="<h5>Panier</h5> <!-- Pr les effets --><div id='panierr' style='width:70px; height:70px; display:none'></div>
						<ul id='ulListePanier'>".$liste_panier_misenforme."</ul>";
	
	} else $menu_panier="<h5>Panier</h5> <ul id='ulListePanier'><li>Panier non accessible par ce menu.</li><li>Utilisez le détail de votre panier ci-contre.</li></ul>";
	
	$design->zone('menu_panier', $menu_panier);

?>