<?php

class Design
{
	// Variables globales
	var $template;
	var $zones=array();
	var $blocs=array();
	var $design;
	
	// Variables de configuration
	var $chemin='theme/';
	
	// Constructeur, démarrage du moteur
	function design()
	{	
		if (file_exists($this->chemin.TEMPLATE_DEFAULT.'.tpl.php'))
			$this->template=TEMPLATE_DEFAULT;
		else
			die('Fichier de template introuvable <br />Fichier: '.__FILE__.'<br />Ligne n° '.__LINE__.'');
	}
	
	// Assigne une variable à une zone
	function zone($zone, $contenu)
	{
		$this->zones[$zone]=$contenu;	
	}
	
	// Définis un bloc qui sera répétée
	function bloc($bloc, $contenu)
	{
		$this->blocs[$bloc]['zone']=$contenu;
	}

	// Insère des occurences pr un bloc
	function blocOccurence($array)
	{
		// Nom du bloc : --- pas super ---
		foreach($this->blocs as $noms=>$ar) {
			$nom=$noms;
		}
		$this->blocs[$nom][]=$array;	
	}
		
	// Définis un autre template que celui par défaut
	function template($newTemplate)
	{
		if (file_exists($this->chemin.$newTemplate.'.tpl.php'))
			$this->template=$newTemplate;
		else
			die("Erreur lors du changement de template vers $newTemplate .");
	}
	
	// Parse et affiche le design final
	function afficher()
	{
		
		if (!empty($this->zones) || !empty($this->blocs) )
		{
			//:: On configure les zones obligatoires
				$this->zone( 'baseUrl', URL );
				if (is_admin()) $this->zone('jvs-admin', '<script type="text/javascript" src="include/js/-admin.js"></script>');
				
				if (isset($_COOKIE['theme'])) 	$urlTheme=recupBdd($_COOKIE['theme']);
				else							$urlTheme="theme/images/bg9.jpg";
				$this->zone( 'urlTheme', $urlTheme );
				
				$this->zone( 'siret', SIRET );
				
				if (empty($this->zones['meta_description'])) $this->zone('meta_description', "Studio-dev.fr par Julien LAFONT : Développement de sites web 2.0. Accéder à mon cv et mes dernières créations");
				
				/*// Nouveaux messages 
				$newMessTemplate='';
				if ($_SESSION['nouveau_message']>0) {
					$newMessTemplate='<script>fenetreNouveauMessage('.$_SESSION['nouveau_message'].');</script>';
					$_SESSION['old_message']=$_SESSION['nouveau_message'];
					$debug=$_SESSION['nouveau_message'];
					$_SESSION['nouveau_message']=false;
					
				}			
				$this->zone( 'NEW_MESS',$newMessTemplate );*/
				

				
			// Ouverture du template //
			$fichier=$this->chemin.$this->template.'.tpl.php';
			$source = fopen($fichier, 'r');
			$this->design = fread($source, filesize ($fichier));
			fclose($source);
			
			// Parsage du template
			foreach ($this->zones as $zone => $contenu)
			{
				$this->design = preg_replace ('/{::'.$zone.'::}/', $contenu, $this->design);
			}
			
			// Suppresion des {::xxxx::} inutilisées
			$this->design = preg_replace ('/{::[-_\w]+::}/', '', $this->design);

			// On remplace les blocs par leurs contenus //
			foreach($this->blocs as $nomBloc => $occurences)
			{
				preg_match( '#{--'.$nomBloc.'--}(.*){--/'.$nomBloc.'/--}#ms', $this->design, $contenuBloc );
				$contenuBloc=$contenuBloc[1];
				
				$idNewTab=0; unset($nomZones);
				foreach($occurences as $occurence => $zones)
				{
					if (!isset($nomZones))
					{
						$nomZones=$zones;
					}
					else
					{
						$i=0;
						$newBloc[$idNewTab]=$contenuBloc;
						foreach($zones as $remplacement)
						{
							$newBloc[$idNewTab]=preg_replace ('/{:'.$nomZones[$i].':}/', $remplacement, $newBloc[$idNewTab]);
							$i++;
						}
					}
					$idNewTab++;
				}
			
				$newContenuBloc=implode("", $newBloc);
				$this->design = preg_replace ('#{--'.$nomBloc.'--}(.*){--/'.$nomBloc.'/--}#ms', $newContenuBloc, $this->design);
				
			}
			
			
			// Affichage du résultat final
			//$this->design=str_replace(CHR(10),"",$this->design); 
			//$this->design=str_replace(CHR(13),"",$this->design);
			//$this->design=str_replace(CHR(9),"",$this->design);
			//$txt = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $txt);
			
			echo $this->design;
		}
	}

}
?>