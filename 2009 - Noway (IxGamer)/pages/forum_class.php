<?php

/**
 * Class FORUM
 * Toutes les fonctions nécessaires au fonctionnement du forum
 *
 */

class Forum
{
	
	/*function forum()
	{	

	}*/
	
	
	
	
	//____/  Affiche les différentes catégories de forum - Page d'accueil  /____//
	function recuperer_liste_categories()
	{
		$sql_liste=mysql_query("SELECT * FROM ".PREFIX."forum_cat ORDER BY ordre");
			$nb=mysql_num_rows($sql_liste);
			
		if ($nb==0) { return miseEnForme('message', 'Aucune catégorie'); }
		
		$c='<ul id="forum_liste_cat">';
		while ($cat=mysql_fetch_object($sql_liste)) {
			
			//---  Deniers messages
			$sql_last="	SELECT fm.id as idMess, fm.titre, m.pseudo 
						FROM ".PREFIX."forum_mess fm
						LEFT JOIN ".PREFIX."membres m
						ON m.id=fm.id_membre
						WHERE fm.id_cat=".$cat->id." 
						ORDER BY fm.id DESC 
						LIMIT 0,5";		
				$query_last=mysql_query($sql_last);
				
				// Génération de la liste des 5 derniers messages pour afficher en hover
				$liste_last="<div style=\'color:#FFF; text-align:left; font-size:9px\'>";
				while($last=mysql_fetch_object($query_last)) {
					$liste_last.=" &bull; ".tronquerChaine(recupBdd($last->titre),50).'<br />';
					
				}	
				$liste_last.="</div>";	
				
				// On reset pour sélectionner le dernier message
				$query_last=mysql_query($sql_last);
				$last=mysql_fetch_object($query_last);
			
			//---  Nombres de messages par catégorie
			$sql_nb=mysql_query("SELECT COUNT(id) as nb FROM ".PREFIX."forum_mess WHERE id_cat=".$cat->id);
				$nbb=mysql_fetch_object($sql_nb);
				$nb=$nbb->nb; /* ^^ */
			
			//--- Mise en forme du résultat
			$c.='<li>
					<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false">
						<img src="'.$cat->image.'" alt="" onmouseover="tooltip.show(this, \'<u>'.$cat->nom.'</u><br /><br />'.htmlspecialchars($liste_last).'\',\'big\');" onmouseout="tooltip.hide(this)"/>
					</a>
					<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).'"><strong>'.recupBdd($cat->nom).'</strong></a> <span>('.$nb.')</span><br />
					'.recupBdd($cat->description).'<br />
					<span>Last: <a href="forum/_'.$last->idMess.'/'.recode(recupBdd($cat->nom)).'/'.recode(recupBdd($last->titre)).'.htm" onclick="naviguer_forum(\'message\', '.$last->idMess.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).' - '.recupBdd($last->titre).'">'.tronquerChaine($last->titre,16).'</a> <!--par '.ucfirst($last->pseudo).'--></span>
				 </li>';
		}
		$c.="</ul>";
		
		return $c;
			
	}


######################################################################################################################################
######################################################################################################################################


	//____/  Affiche les différents sujets  /____//
	function recuperer_listes_sujets($id_cat, $page=1) {
	
		//--- Vérifications
		$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".(int)$id_cat);
		$cat=mysql_fetch_object($sql_cat);
			$nb=mysql_num_rows($sql_cat);
			
			// Aucun message
			if ($nb==0) { return miseEnForme('message', 'Aucun sujet dans ce forum'); }
		
			// Niveau insuffisant
			if ($cat->niveau!=0 && ( isset($_SESSION['sess_level']) && $_SESSION['sess_level']<$cat->niveau) ) {
				return miseEnForme('message', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum");
			}
		
		//--- Pagination 
		$sql_pre=mysql_query("SELECT count(id) as nb FROM ".PREFIX."forum_mess WHERE id_cat=$id_cat");
		$pre=mysql_fetch_object($sql_pre);
			$nbG=$pre->nb;
	
		$first=($page*NB_SUJETS)-(NB_SUJETS);
			if ($first<0) $first=0;
		if ($first==null) $limit="LIMIT 0,".NB_SUJETS; 
		else $limit="LIMIT $first,".NB_SUJETS;
		
		$nbpages=ceil($nbG/NB_SUJETS); $current=(round($first/NB_SUJETS))+1;
		if ($nbpages>1) {
			$pagination="<center><div id='pagination'>";
				for ($i=1; $i<=$nbpages; $i++) {
					if ($i!=1) $pagination.=" . ";
					if ($i==$current) $pagination.= "<b>$i</b>";
					else {  if ($i==1) $newpage="";  else $newpage="-".$i;
							$pagination.= "<a href='forum/".$cat->id.$newpage."/".recode(recupBdd($cat->nom))."/' onclick='naviguer_forum(\"categorie\", ".$cat->id.", ".$i."); return false'>$i</a>";
					}
				}	
			$pagination.= '</div></center>';
		}

		//--- Sélection des derniers sujets
		$sql_sujets=mysql_query("	SELECT *, fm.id as idMess
									FROM ".PREFIX."forum_mess fm
									LEFT JOIN ".PREFIX."membres	m
									ON m.id=fm.id_membre
									LEFT JOIN ".PREFIX."membres_detail md
									ON md.id_membre=m.id
									WHERE fm.id_cat=$id_cat
									and fm.etat!=9
									ORDER BY fm.etat DESC, fm.date DESC 
									".$limit) or die(mysql_error());
			$nbSujets=mysql_num_rows($sql_sujets);
		
		//--- Chemin 
		$c='<div id="chemin"><h2>
				<b><a href="forum/" title="Forum '.NOM.'" onclick="naviguer_forum(\'accueil\',0,0); return false">Forum '.NOM.'</a></b> <img src="images/mini_fleche_droite.png" /> 
				<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).'">'.recupBdd($cat->nom).'</a></h2></div>';
		
		//--- Mise en page des sujets
		$c.='<table id="liste_sujets" cellpadding="1" cellspacing="1">
				<tr>
					<td class="titre" style="width:500px">Sujets'.@$admin.'</td>
					<td class="titre" style="width:100px; text-align:center">Membre</td>
					<td class="titre" style="width:70px; text-align:center">Date</td>
				</tr>';
		
			// Aucun message ?
			if ($nbSujets==0) $c.="<tr><td colspan='3' style='text-align:center'>Aucun message sur cette page</td></tr>";
			
		$i=0;
		while ($d=mysql_fetch_object($sql_sujets)) {
			
			// Image online/Hors-ligne et Homme/Femme
			$imgS=imgOnline($d->gen_sexe, $d->last_activity);
			
			// On gère le changement de style
			if ($i%2==0)  	$style="class='alt'";
			else			$style="";
			$i++;
			
			// Nombre de messages par sujets 
			$sql_nbRep=mysql_query("SELECT count(id) as nbM FROM ".PREFIX."forum_mess WHERE id_mess=".$d->idMess);
				$nbRepp=mysql_fetch_object($sql_nbRep) or die(mysql_error());
				$nbRep=round($nbRepp->nbM);
			
			// Postit ?
			if ($d->etat==2) { $img="images/boutons/services.png"; $postit="<b>POST-IT : </b>"; }
			else 			 { $img="images/boutons/bouton_noway.png"; $postit=""; }
			
			$c.='<tr>
					<td '.$style.' id="td_sujet">
						<img src="'.$img.'" onmouseover="tooltip.show(this, \'<u>'.tronquerChaine($d->titre,27).'</u><br /><br /><p>'.htmlspecialchars(tronquerChaine(json(strip_tags($d->message)),150)).'</p>\',\'big\');" onmouseout="tooltip.hide(this)"> 
						'.$postit.'<a href="forum/_'.$d->idMess.'/'.recode(recupBdd($cat->nom)).'/'.recode($d->titre).'.htm" onclick="naviguer_forum(\'message\', '.$d->idMess.', 1); return false" title="" ><div class="editme1" style="display:inline" id="idSujet_'.$d->idMess.'">'.recupBdd($d->titre).'</div></a> <b style="font-family:arial">&nbsp;('.$nbRep.')</b>
					</td>
					<td '.$style.' id="td_membre"><img src="images/'.$imgS.'" alt="sexe" /> &nbsp;<a href="profil/'.$d->pseudo.'/">'.ucfirst($d->pseudo).'</a></td>
					<td '.$style.' id="td_date">'.inverser_date($d->date,5).'</td>
				</tr>';	
			
		}
		
		// On prépare les liens pour les boutons :
		if (is_log()) $new_post="naviguer_forum('nouveau', ".$cat->id.", 0);";
		else 		  $new_post='naviguer_forum(\'invite\', 0, 0); rediriger0=\'nouveau\'; rediriger1=\''.$cat->id.'\';';
		
		$c.='</table><br /><br />'.$pagination.'
		
		<div id="boutons">
			<a href="#" onclick="'. $new_post.' return false"><img src="images/forum/nouveau_sujet.png" onmouseover="this.src=\'images/forum/nouveau_sujet_hover.png\'" onmouseout="this.src=\'images/forum/nouveau_sujet.png\'"></a>
		</div>';
		
		
		// Actions administrateurs :
		if (securite_groupes('4+', true, true)) {
	
			$c.='<div id="raccourci_admin"  style="filter:alpha(opacity=50);-moz-opacity:.5;opacity:.5;" onmouseover="$(this).css({opacity:1})" onmouseout="$(this).css({opacity:0.5})">
				
				<div class="titre_admin" style="-moz-border-radius-topLeft:15px;-moz-border-radius-topRight:15px;">modération</div>
				
				<div class="menu_admin_case" id="editSujet" onmouseover="tooltip.show(this, \'<u>Edition live</u><br /><br /><p >Une fois cette action activée, cliquez sur les différents sujets pour les éditer directement.</p>\',\'big\',\'centre\');" onmouseout="tooltip.hide(this)">
					<a href="#" onclick="editInPlaceSujets(\'categorie\', '.$id_cat.', '.$page.'); return false">
						<img src="images/boutons/playlistB.png" style="position:absolute; top:3px; left:3px" />
					</a>
					<p style="position:absolute; top:3px; left:37px; width:110px;">
						<a href="#" onclick="editInPlaceSujets(\'categorie\', '.$id_cat.', '.$page.'); return false">
							Activer l\'édition des sujets \'live\'
						</a>
					</p>
				</div>
				<div class="menu_admin_case" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
					<img src="images/boutons/document2.png" style="position:absolute; top:3px; left:3px" /> 
					<p style="position:absolute; top:3px; left:37px; width:110px;">Activer l\'édition des messages</p>
				</div>
	
				<div class="menu_admin_minicase" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
					<img src="images/boutons/cancel.png" style="position:absolute; top:5px; left:12px" /> 
					<p style="position:absolute; top:5px; left:37px; width:110px;">Supprimer sujet</p>
				</div>
				
				<div class="menu_admin_minicase" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
					<img src="images/boutons/services.png" style="position:absolute; top:5px; left:12px" /> 
					<p style="position:absolute; top:5px; left:37px; width:110px;">Mettre en Postit</p>
				</div>
				
				<div class="titre_admin" style="margin-top:7px">Administration</div>
				';
				
				  if (is_admin()) {
					$c.='<div class="menu_admin_minicase" style="height:22px">
							<a href="?admin-accueil"><img src="images/boutons/aim_protocol.png" style="position:absolute; top:7px; left:12px" /> 
							<p style="position:absolute; top:7px; left:37px; width:110px"><a href="?admin-accueil">Accéder à l\'admin</a></p>
						 </div>';
				  }
				  else
				  {
					$c.='<div class="menu_admin_minicase" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
							<img src="images/boutons/aim_protocol.png" style="position:absolute; top:5px; left:12px" /></a>
							<p style="position:absolute; top:5px; left:37px; width:110px">Accéder à l\'admin</p>
						 </div>';
				  }
			
		  $c.='</div>';
		}
		
		return $c;

	}
		
	
	
######################################################################################################################################
######################################################################################################################################


	
	//____/  Afficher un message et ces réponses  /____//
	function afficher_message($id_mess, $page=1) {
		
		//--- Vérifications
		$sql_verif=mysql_query("SELECT id_cat, titre, etat FROM ".PREFIX."forum_mess WHERE id=".(int)$id_mess);
		$verif=mysql_fetch_object($sql_verif);
			$nb=mysql_num_rows($sql_verif);
			
			// Sélection de la catégorie
			$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".$verif->id_cat);
			$cat=mysql_fetch_object($sql_cat);
			
			// Aucun message
			if ($nb==0) { return miseEnForme('message', "Ce sujet n'existe pas"); }
		
			// Niveau insuffisant
			if ($cat->niveau!=0 && ( !isset($_SESSION['sess_level']) || $_SESSION['sess_level']<$cat->niveau) ) {
				return miseEnForme('erreur', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum ");
			}
					
		//--- Chemin 
		$c='<div id="chemin"><h2>
				<b><a href="forum/" onclick="naviguer_forum(\'accueil\',0,0); return false" title="Forum '.NOM.'">Forum '.NOM.'</a></b> <img src="images/mini_fleche_droite.png" /> 
				<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).'"><b>'.recupBdd($cat->nom).'</b></a> <img src="images/mini_fleche_droite.png" />  
				<a href="forum/_'.$id_mess.'/'.recode(recupBdd($cat->nom)).'/'.recode(recupBdd($verif->titre)).'.htm" onclick="naviguer_forum(\'message\', '.$id_mess.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).' - '.recupBdd($verif->titre).'">'.recupBdd($verif->titre).'</a></h2>
			</div>';
		
		//--- Pagination
		
			// Nbres de messages en tout
		$sql_pre=mysql_query("SELECT count(id) as nb FROM ".PREFIX."forum_mess WHERE id_mess=$id_mess OR id=$id_mess");
		$pre=mysql_fetch_object($sql_pre);
		$nbG=$pre->nb;
	
			// Première page ? Quelle page afficher ?
		$first=($page*NB_MESSAGES)-(NB_MESSAGES);
			if ($first<0) $first=0;
		if ($first==null) $limit="LIMIT 0,".NB_MESSAGES; 
		else $limit="LIMIT $first,".NB_MESSAGES;
		
			// Génération de la liste des pages
		$nbpages=ceil($nbG/NB_MESSAGES); $current=(round($first/NB_MESSAGES))+1;
		if ($nbpages>1) {
			$pagination="<center><div id='pagination'>";
				for ($i=1; $i<=$nbpages; $i++) {
					if ($i!=1) $pagination.=" . ";
					if ($i==$current) $pagination.= "<b>$i</b>";
					else { if ($i==1) $newpage="";  else $newpage="-".$i;
						   $pagination.= "<a href='forum/_".$id_mess.$newpage."/'.recode(recupBdd($cat->nom)).'/".recode(recupBdd($verif->titre)).".htm' onclick='naviguer_forum(\"message\", ".$id_mess.", ".$i."); return false'>$i</a>"; 
					}
				}	
			$pagination.= '</div></center>';
		}


		//--- Sélection des derniers Messages
		$sql_mess=mysql_query("	SELECT *, fm.id as idMess
									FROM ".PREFIX."forum_mess fm
									LEFT JOIN ".PREFIX."membres	m
									ON m.id=fm.id_membre
									LEFT JOIN ".PREFIX."membres_detail md
									ON md.id_membre=m.id
									WHERE fm.id_mess=$id_mess OR fm.id=$id_mess
									ORDER BY fm.date ASC
									".$limit) or die(mysql_error());
			$nbMess=mysql_num_rows($sql_mess);

		//--- Mise en forme des derniers messages
		$i=$first+1;
		while ($d=mysql_fetch_object($sql_mess))
		{
			
			// Sélection de l'image en fonction de l'icone
			$img=imgOnline($d->gen_sexe, $d->last_activity);
		
			// Modification de la date
			$date1 = inverser_date(substr($d->date,0,10));
			$date2 = substr($d->date,11,2);
			$date3 = substr($d->date,14,2);
			$date = $date1." ".$date2.":".$date3;
			
			if ($d->id_membre==$_SESSION['sess_id']) 
				$edit='<a href="#" onclick="naviguer_forum(\'editer\', '.$d->idMess.', 0); return false"><img src="images/boutons/edit.png" class="float" style="margin-right:15px; padding-top:3px"/></a>';
				
			$titre='#'.$i.' &nbsp;<img src=images/'.$img.' /> <a href="profil/'.recode($d->pseudo).'/" title="Afficher le profil de '.$d->pseudo.'"><b>'.ucfirst($d->pseudo).'</b></a>
					<span style="font-size:9px">@ '.$date.'</span>
					
					'.$edit.'';
			
			// [NOWAY]
			/*
					<a href="Galerie-photo/yotsumi/'.$d->pseudo.'/"><img src="theme/images/titre_galery.png" class="float" style="margin-right:250px"/></a> 
					<a href="Guestbook/'.$d->pseudo.'/"><img src="theme/images/titre_guestbook.png" class="float" /></a>
					<a href="Profil/'.$d->pseudo.'/"><img src="theme/images/titre_profil.png" class="float" /></a>
			*/
			
			$c.='<h3 class="barre">'.$titre.'</h3>
			<p class="contenu_forum" id="idMess_'.$d->idMess.'">'.nl2br(recupBdd($d->message)).'</p>';

			$i++;
		}
		
		// Ajout pagination
		$c.='<br />'.$pagination;
		
		// On prépare les liens des actions
		if (is_log()) {
			$new_post='naviguer_forum(\'nouveau\', '.$cat->id.', 0);';
			$reply='naviguer_forum(\'repondre\', '.$id_mess.', 0);';
		}
		else {  // -> Affiche la page d'erreur + Redirection automatique si connexion directe
			$new_post='naviguer_forum(\'invite\', 0, 0); rediriger0=\'nouveau\'; rediriger1=\''.$cat->id.'\'; '; 
			$reply='naviguer_forum(\'invite\', 0, 0); rediriger0=\'repondre\'; rediriger1=\''.$id_mess.'\'; ';  
		}
		
		// Ajout actions :
		$c.='<br /><div id="boutons">
				<a href="#" onclick="'.$new_post.' return false"><img src="images/forum/nouveau_sujet.png" onmouseover="this.src=\'images/forum/nouveau_sujet_hover.png\'" onmouseout="this.src=\'images/forum/nouveau_sujet.png\'"></a> &nbsp; 
				<a href="#" onclick="'.$reply.' return false"><img src="images/forum/repondre.png" onmouseover="this.src=\'images/forum/repondre_hover.png\'" onmouseout="this.src=\'images/forum/repondre.png\'"></a>
			</div>';

		// Actions administrateurs :
		if (securite_groupes('4+', true, true)) { 
	
			$c.='<div id="raccourci_admin"  style="filter:alpha(opacity=50);-moz-opacity:.5;opacity:.5;" onmouseover="$(this).css({opacity:1})" onmouseout="$(this).css({opacity:0.5})">
				
				<div class="titre_admin" style="-moz-border-radius-topLeft:15px;-moz-border-radius-topRight:15px;">modération</div>
				
				<div class="menu_admin_case" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
					<img src="images/boutons/playlistB.png" style="position:absolute; top:3px; left:3px" />
					<p style="position:absolute; top:3px; left:37px; width:110px;">Activer l\'édition des sujets \'live\'</p>
				</div>
				<div class="menu_admin_case" id="editMessage">
					<a href="#" onclick="editInPlaceMessage(\'message\', '.$id_mess.', '.$page.'); return false">
						<img src="images/boutons/document2.png" style="position:absolute; top:3px; left:3px" /> 
					</a>
					<p style="position:absolute; top:3px; left:37px; width:110px;">
						<a href="#" onclick="editInPlaceMessage(\'message\', '.$id_mess.', '.$page.'); return false">
							Activer l\'édition des messages
						</a>
					</p>
				</div>
	
				<div class="menu_admin_minicase">
					<a href="#" onclick="if(confirm(\'Confirmer la suppression ?\')) { supprMessAdmin('.$id_mess.'); return false; } else return false;">
						<img src="images/boutons/cancel.png" style="position:absolute; top:5px; left:12px" />
					</a>
					<p style="position:absolute; top:5px; left:37px; width:110px;">
						<a href="#" onclick="if(confirm(\'Confirmer la suppression ?\')) { supprMessAdmin('.$id_mess.'); return false; } else return false;">
							Supprimer sujet
						</a>
					</p>
				</div>
				
				<div class="menu_admin_minicase" id="adminPostit">';
					
					// Actuellement post-it ?
					if ($verif->etat==1) 
					  $c.='<a href="#" onclick="if(confirm(\'Confirmer la mise en Post-It du Post ?\')) { postitAdmin('.$id_mess.',2); return false; } else return false;">
					  			<img src="images/boutons/services.png" style="position:absolute; top:5px; left:12px" /> 
							</a>
							<p style="position:absolute; top:5px; left:37px; width:110px;">
								<a href="#" onclick="if(confirm(\'Confirmer la mise en Post-It du Post ?\')) { postitAdmin('.$id_mess.',2); return false; } else return false;">
									Mettre en Postit
								</a>
							</p>';
					else 
					  $c.='<a href="#" onclick="if(confirm(\'Confirmer la suppression de l état Post-it ?\')) { postitAdmin('.$id_mess.',1); return false; } else return false;">
					  			<img src="images/boutons/services.png" style="position:absolute; top:5px; left:12px" />
							</a>
							 <p style="position:absolute; top:5px; left:37px; width:110px;">
							 	<a href="#" onclick="if(confirm(\'Confirmer la suppression de l état Post-it ?\')) { postitAdmin('.$id_mess.',1); return false; } else return false;">
									Annuler le Postit</p></a>
								</a>
							</p>';
					
			$c.='</div>
				
				<div class="titre_admin" style="margin-top:7px">Administration</div>
				';
				
				  if (is_admin()) {
					$c.='<div class="menu_admin_minicase" style="height:22px">
							<a href="?admin-accueil"><img src="images/boutons/aim_protocol.png" style="position:absolute; top:7px; left:12px" /> 
							<p style="position:absolute; top:7px; left:37px; width:110px"><a href="?admin-accueil">Accéder à l\'admin</a></p>
						 </div>';
				  }
				  else
				  {
					$c.='<div class="menu_admin_minicase" style="filter:alpha(opacity=70);-moz-opacity:.7;opacity:.7">
							<img src="images/boutons/aim_protocol.png" style="position:absolute; top:5px; left:12px" /></a>
							<p style="position:absolute; top:5px; left:37px; width:110px">Accéder à l\'admin</p>
						 </div>';
				  }
			
		  $c.='</div>';
		}
		
		return $c;
	}

	function recuperer_meta($id) {
	
		//--- Vérifications
		$sql_verif=mysql_query("SELECT id_cat, titre, etat FROM ".PREFIX."forum_mess WHERE id=".(int)$id);
		$verif=mysql_fetch_object($sql_verif);

		//--- Sélection des derniers Messages
		$sql_mess=mysql_query("	SELECT *, fm.id as idMess
								FROM ".PREFIX."forum_mess fm
								WHERE fm.id_mess=$id OR fm.id=$id
								ORDER BY fm.date ASC") or die(mysql_error());
		
		$meta="";
		//--- Récupération des derniers messages, mots clés
		while ($d=mysql_fetch_object($sql_mess))
		{
			if (!isset($first)) $first=recupBdd($d->message);
			$meta.=recupBdd($d->message)." ";
		}
		
		$key=extraire_keywords($meta);
		
		return array($first, $key);
	
	}


######################################################################################################################################
######################################################################################################################################

	
	//____/  Formulaire pour rédiger un nouveau message ou répondre à un précédant  /____//
	function nouveau_message($id_cat=NULL, $id_mess=NULL) {
		
		//--- Vérifications
		
			//- Si nouveau message dans une catégorie :
			if (isset($id_cat)) {
				$id_cat=(int)$id_cat;
				$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".$id_cat);
				$cat=mysql_fetch_object($sql_cat);
					$nb=mysql_num_rows($sql_cat);
					
					// Aucun message
					if ($nb==0) { return miseEnForme('message', 'Cette catégorie n\'existe pas'); }
				
					// Niveau insuffisant
					if ($cat->niveau!=0 && ( isset($_SESSION['sess_level']) && $_SESSION['sess_level']<$cat->niveau) ) {
						return miseEnForme('message', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum");
					}
					$typepage="cat";
			}
			else 
			//- Si réponse à un message
			{
				$sql_verif=mysql_query("SELECT id_cat, titre FROM ".PREFIX."forum_mess WHERE id=".(int)$id_mess);
				$verif=mysql_fetch_object($sql_verif);
					$nb=mysql_num_rows($sql_verif);
					
					// Sélection de la catégorie
					$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".$verif->id_cat);
					$cat=mysql_fetch_object($sql_cat);
					
					// Aucun message
					if ($nb==0) { return miseEnForme('message', "Ce sujet n'existe pas"); }
				
					// Niveau insuffisant
					
					$typepage="mess";

			}

		//--- Chemin 
		$c='<div id="chemin"><h2>
				<b><a href="forum/" onclick="naviguer_forum(\'accueil\',0,0); return false" title="Forum '.NOM.'">Forum '.NOM.'</a></b> <img src="images/mini_fleche_droite.png" /> 
				<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).'"><b>'.recupBdd($cat->nom).'</b></a> <img src="images/mini_fleche_droite.png" /> ';
		if ($id_mess) $c.='<a href="forum/_'.$id_mess.'/'.recode(recupBdd($cat->nom)).'/'.recode(recupBdd($verif->titre)).'.htm" onclick="naviguer_forum(\'message\', '.$id_mess.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).' - '.recupBdd($verif->titre).'"><b>'.recupBdd($verif->titre).'</b></a> <img src="images/mini_fleche_droite.png" /> 
				<a href="#" onclick="naviguer_forum(\'repondre\', '.$id_mess.', 0); return false">Nouvelle réponse</a></h2></div>';
		else $c.='<a href="#" onclick="naviguer_forum(\'nouveau\', '.$id_cat.', 0); return false">Nouveau sujet</a></h2></div>';
		
		
		$c.='<h3 class="barre" style="font-size:11px; font-family:Arial">Rédiger un nouveau message :</h3>
			
				<form name="post" method="POST" action="#" onsubmit="verif_nouveau_message(\''.$typepage.'\'); return false">
				<fieldset id="form">
					
					
					<table style="border:0; width:90%;" align="center">';
					
		if($id_cat) $c.='<tr>
							<td style="width:125px; text-align:right; padding-right:20px; vertical-align:top"><label for="titre">Titre</label></td>
							<td><input type="text" id="titre" name="titre" style="width:250px" maxlength="255" />
							<br /><div id="retour_titre" class="form_error" style="display:none"></div></td>
						</tr>';
		$c.='			<tr>
							<td style="width:125px; text-align:right; padding-right:20px"><br /><br /><label for="message">Message</label></td>
							<td><br /><br />
							

								<textarea name="messageBG" id="messageBG" class="size150"></textarea>
								<div id="retour_message" class="form_error" style="display:none"></div>';
								
								if (isset($id_cat)) $c.='<input type="hidden" value="'.$id_cat.'" id="id_cat" />';
								else				$c.='<input type="hidden" value="'.$id_mess.'" id="id_mess" />';
								

		$c.='   			</td>
						</tr>
						<tr>
							<td></td>
							<td><br /><br /><input type="submit" value="envoyer" id="send" class="submit" /><br /><br /></td>
						</tr>
					</table>
				
				</fieldset>
				
				</form>';
		return $c;

	
	}
	
	
######################################################################################################################################
######################################################################################################################################

	
	//____/  Ajoute un nouveau message/réponse dans la base de donnée  /____//
	function enregistrer_message($id_cat, $id_mess, $titre, $message) {
	
		//--- Vérifications
			if (empty($id_cat) && empty($id_mess)) return 'error_no_id_no_mess';
				
			if (!empty($id_cat)) {
				
				$sql_cat=mysql_query("SELECT id, niveau FROM ".PREFIX."forum_cat WHERE id=".$id_cat);
				$cat=mysql_fetch_object($sql_cat);
					$nb=mysql_num_rows($sql_cat);

				// Aucune catégorie ne correspond
				if ($nb==0) { return miseEnForme('message', 'La catégorie dans laquelle vous voulez ajouter le message n\'existe pas'); }
			
				$champ[0]="id_cat"; $champ[1]=$id_cat;
			}
			else if (!empty($id_mess)) {
				$sql_verif=mysql_query("SELECT id FROM ".PREFIX."forum_mess WHERE id=".$id_mess);
				$verif=mysql_fetch_object($sql_verif);
					$nb=mysql_num_rows($sql_verif);
		
				// Aucune catégorie ne correspond
				if ($nb==0) { return miseEnForme('message', 'Le message dans lequel vous voulez ajouter la réponse n\'existe pas'); }

				$champ[0]="id_mess"; $champ[1]=$id_mess;

			}
			else return 'Hack attempt !';
		
			// Niveau insuffisant
			if ($cat->niveau!=0 && ( isset($_SESSION['sess_level']) && $_SESSION['sess_level']<$cat->niveau) ) {
				return miseEnForme('message', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum");
			}
			
		//--- Insertion dans la base de donnée 
			$id_membre=$_SESSION['sess_id'];
			
			$ins=mysql_query("INSERT INTO ".PREFIX."forum_mess ( `".$champ[0]."`, `id_membre`, `titre`, `message`, `date`) VALUES ( '".$champ[1]."', '$id_membre', '$titre', '$message', NOW() )") or die(mysql_error());
			
			if ($ins) 	return "ok";
			else		return "error_ins";
			
	
	
	}


######################################################################################################################################
######################################################################################################################################

	
	//____/  Editer un message  /____//
	function editer_message($id_mess) {
		
		//-- Vérifications		
		$sql_mess=mysql_query("SELECT * FROM ".PREFIX."forum_mess WHERE id=".(int)$id_mess);
		$mess=mysql_fetch_object($sql_mess);
			$nb=mysql_num_rows($sql_mess);
			
			// Remonter au sujet parent ?
			if (empty($mess->id_cat)) {
				$sql_parent=mysql_query("SELECT id_cat, titre FROM ".PREFIX."forum_mess WHERE id=".$mess->id_mess);
				$parent=mysql_fetch_object($sql_parent);
				
				$id_cat=$parent->id_cat;
				$titre=recupBdd($parent->titre);
				$typepage="lite"; // sans titre
			} else {
				$id_cat=$mess->id_cat;
				$titre=recupBdd($mess->titre);
				$typepage="normal";
			}

			// Sélection de la catégorie
			$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".$id_cat);
			$cat=mysql_fetch_object($sql_cat);
			
			// Aucun message
			if ($nb==0) { return miseEnForme('message', "Ce sujet n'existe pas"); }
		
			// Niveau insuffisant
			if ($cat->niveau!=0 && ( !isset($_SESSION['sess_level']) || $_SESSION['sess_level']<$cat->niveau) ) {
				return miseEnForme('erreur', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum");
			}
			
			//  Mon message ?
			if ($mess->id_membre!=$_SESSION['sess_id']){
				return miseEnForme('erreur', "Vous ne pouvez éditer que vos messages !");
			}
	
		//-- On récupères les données 
		$message=recupBdd($mess->message);
		if (empty($mess->id_mess)) $titre=recupBdd($mess->titre);

		//--- Chemin 
		$c='<div id="chemin"><h2>
				<b><a href="forum/" onclick="naviguer_forum(\'accueil\',0,0); return false" title="Forum '.NOM.'">Forum '.NOM.'</a></b> <img src="images/mini_fleche_droite.png" /> 
				<a href="forum/'.$cat->id.'/'.recode(recupBdd($cat->nom)).'/" onclick="naviguer_forum(\'categorie\', '.$cat->id.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).'"><b>'.recupBdd($cat->nom).'</b></a> <img src="images/mini_fleche_droite.png" /> 
				<a href="forum/_'.$id_mess.'/'.recode(recupBdd($cat->nom)).'/'.recode(recupBdd($titre)).'.htm" onclick="naviguer_forum(\'message\', '.$id_mess.', 1); return false" title="Forum '.NOM.' : '.recupBdd($cat->nom).' - '.$titre.'"><b>'.$titre.'</b></a> <img src="images/mini_fleche_droite.png" /> 
				<a href="#" onclick="naviguer_forum(\'editer\', '.$id_mess.', 0); return false">Editer mon message</a></h2></div>';
		
		
		$c.='<h3 class="barre" style="font-size:11px; font-family:Arial">Editer mon message :</h3>
			
				<form name="post" method="POST" action="#" onsubmit="verif_editer_message(\''.$typepage.'\'); return false">
				<fieldset id="form">
					
					
					<table style="border:0; width:90%;" align="center">';
					
		if(empty($mess->id_mess)) $c.='<tr>
							<td style="width:125px; text-align:right; padding-right:20px"><label for="titre">Titre</label></td>
							<td><input type="text" id="titre" name="titre" value="'.$titre.'" style="width:250px" maxlength="255" />
							<br /><div id="retour_titre" class="form_error" style="display:none"></div></td>
						</tr>';
		$c.='			<tr>
							<td style="width:125px; text-align:right; padding-right:20px"><br /><br /><label for="message">Message</label></td>
							<td><br /><br />
							

								<textarea name="messageBG" id="messageBG" class="size150">'.$message.'</textarea>
								<div id="retour_message" class="form_error" style="display:none"></div>
								
								<input type="hidden" value="'.$id_mess.'" id="id_mess" />
								
				  			</td>
						</tr>
						<tr>
							<td></td>
							<td><br /><br /><input type="submit" value="Editer" id="send" class="submit" /><br /><br /></td>
						</tr>
					</table>
				
				</fieldset>
				
				</form>';
		return $c;
			
	}


#######################################################################################################################################
######################################################################################################################################

	
	//____/  Modifie la base de donnée aprés l'édition d'un message  /____//
	function modifier_message($id_mess, $titre, $message) {
	
		//--- Vérifications		
		$sql_mess=mysql_query("SELECT * FROM ".PREFIX."forum_mess WHERE id=".$id_mess);
		$mess=mysql_fetch_object($sql_mess);
			$nb=mysql_num_rows($sql_mess);
			
			// Remonter au sujet parent ?
			if (empty($mess->id_cat)) {
				$sql_parent=mysql_query("SELECT id_cat, titre FROM ".PREFIX."forum_mess WHERE id=".$mess->id_mess);
				$parent=mysql_fetch_object($sql_parent);
				
				$id_cat=$parent->id_cat;
				$type="lite";
			} else {
				$id_cat=$mess->id_cat;
				$type="normal";
			}
			
			// Sélection de la catégorie
			$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".$id_cat);
			$cat=mysql_fetch_object($sql_cat);
			
			// Aucun message
			if ($nb==0) { return miseEnForme('message', "Ce sujet n'existe pas"); }
		
			// Niveau insuffisant
			if ($cat->niveau!=0 && ( !isset($_SESSION['sess_level']) || $_SESSION['sess_level']<$cat->niveau) ) {
				return miseEnForme('erreur', "Vous n'avez pas le niveau nécessaire pour accéder à ce forum");
			}
			
			//  Mon message ?
			if ($mess->id_membre!=$_SESSION['sess_id']){
				return miseEnForme('erreur', "Vous ne pouvez éditer que vos messages !");
			}
			
			// Message et titre remplis :
			if (($type=="normal" && strlen($titre)<4) || strlen($message)<7) {
				return miseEnForme('erreur', "Votre titre et/ou votre message est trop court !");
			}
			
		//--- Mise à jour bdd
		$sql=mysql_query("UPDATE ".PREFIX."forum_mess SET titre='$titre', message='$message' WHERE id=$id_mess");
		
		if ($sql) return 'ok|:|'.$id_cat;
		else	  return 'error_sql';

	}
	
	
#####################################################################################################################################
######################################################################################################################################


	function recuperer_infos_categorie($id_cat) {
		
		// Sélection de la catégorie
		$sql_cat=mysql_query("SELECT * FROM ".PREFIX."forum_cat WHERE id=".(int)$id_cat);
		$cat=mysql_fetch_array($sql_cat);
		
		return $cat;

	}

	function recuperer_infos_sujet($id_mess) {
		
		// Sélection de la catégorie
		$sql_mess=mysql_query("SELECT * FROM ".PREFIX."forum_mess WHERE id=".(int)$id_mess);
		$mess=mysql_fetch_array($sql_mess);
		
		return $mess;

	}
	
	function afficher_message_membre_seulement() {
	
		$c="<center><div style='text-align:center; width:50%; margin:0 auto'>
				<br /><br /><img src='images/forum/HEINS_HITOOLBOX_REPLACEMENTS STOP.png' alt='Accés interdit' /><br /><br />
				<b style='font-size:13px'>Vous devez être inscrit sur le site pour pouvoir participer aux discussions de ce forum.</b><br /><br />
				Vous pourrez aussi bénéficier de modules personalisés tel qu'un <span style='color:#0099FF'>guestbook</span>, une <span style='color:#0099FF'>galerie</span>, et accéder aux différents services : <span style='color:#0099FF'>messagerie interne</span>, <span style='color:#0099FF'>liste d'amis</span> ...<br /><br /><br />
				<a href='inscription/'><span style='font-size:16px; font-weight:bold; color:#00A8FF'>Je veux m'inscrire</span></a><br /><br /><br />
			</div></center>";
				
		return $c;
	}
	
}
?>