<?php

/*  ---------------------------------------------------------------------------------------------------------------
	  Mon système de template perso
    --------------------------------------------------------------------------------------------------------------- */

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
			die("Erreur lors du changement de template vers $newTemplate.tpl.php.");
	}
	
	// Parse et affiche le design final
	function afficher()
	{
		
		if (!empty($this->zones) || !empty($this->blocs) )
		{
			//:: On configure les zones obligatoires
				$this->zone( 'baseUrl', URL );
				
				// Activer Jvs ?
				if ($_SESSION['sess_no_jvs']==1)  {
					$this->zone( 'activ_jvs', 'var activer_jvs=0');
					$this->zone( 'barre_sup', '<div id="barre_sup"><a href="faistonchoix_version_normale.htm" title="Accéder à la version normale du site Faistonchoix.fr">Revenir à la version normale du site</a></div>');
				}
				else $this->zone( 'activ_jvs', 'var activer_jvs=1');				

				
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
			
			if (COMPRESSER_CODE==1) 
				$this->design = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $this->design);
			
			// Affichage du résultat final
			echo $this->design;
		}
	}

}
?>