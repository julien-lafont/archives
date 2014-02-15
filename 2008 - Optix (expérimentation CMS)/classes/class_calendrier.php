<?php

	// Nécessite class_hdacalendar.php
	
class calendrier {

	private $calendar;
	private $billets;
	private $html;
	
	
	public function __construct($main, $mois=NULL, $annee=NULL) {
	
		// Mois/Annee en cours
		if (!$mois)  $mois=date('n');
		if (!$annee) $annee=date('Y');
		
		// Mois/Annee suivante
		$suivM=$mois+1; $suivA=$annee;
		if ($suivM==13) { $suivM=1; $suivA++; }
		
		// Mois/Annee précédente
		$precM=$mois-1; $precA=$annee;
		if ($precM==0) { $precM=12; $precA--; }
		
		
		// Initialisation du calendrier
		$this->calendar = new HDAcalendar($mois, $annee);
		$this->calendar -> definir_style("table_calendrier");
		
		// Ajout des liens sur le calendrier
		$this->billets=new billets($main);
		$liens=$this->billets->nb_billets_par_date($mois, $annee);
		foreach($liens as $jour=>$occ) {
			$this->calendar -> link($jour, "calendrier-".$jour."_".$mois."_".$annee.".htm", "Afficher les billets de la journee du ".$jour."/".$mois."/".$annee."  ( ".$occ." )", "naviguer_date", $jour."_".$mois."_".$annee."-1");
		}
			
		// Définition des liens mois suivant / Mois précédent
		$this->calendar->definir_liens(
			'<a href="javascript:void(0)" onclick="calendrier('.$precM.', '.$precA.'); " title="Aller au moins precedent">&lt;</a>',
			'<a href="javascript:void(0)" onclick="calendrier('.$suivM.', '.$suivA.'); " title="Aller au mois suivant">&gt;</a>');
		
		$this->html=$this->calendar->Output();
		
	}
	
	public function afficher() {
		return $this->html;
	}
}
?>