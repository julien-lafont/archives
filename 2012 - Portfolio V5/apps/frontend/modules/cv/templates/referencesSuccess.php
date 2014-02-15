<p class="biglines">
 Vous pouvez consulter sur cette page les recommandations professionnelles qui m'ont été laissées par mes différents responsables ainsi que par mes clients.
</p>

<h5>IOcean (2009 à 2012)</h5>
<div class="reference">
	<div class="ref_texte">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nisl purus, consectetur ut interdum non, ultrices quis ligula. Quisque mauris urna, imperdiet malesuada molestie sit amet, volutpat id justo. Donec nisi tortor, rutrum vel luctus laoreet, tempus quis sem. Praesent vel mi eros. Suspendisse vel metus dignissim metus placerat volutpat eget nec neque.</p>
	</div>
	<p class="ref_by">
		Référence rédigée par Adeline Dibling<br /> 
		<strong>Chef de projet, IOcean</strong><br />
		Consultez la recommandation originale sur <a href="http://www.viadeo.com/fr/profile/julien.lafont5#position_5032025">mon profil Viadeo</a>
	</p>
</div>


<h5>Kaliop (2009)</h5>

<div class="reference">
	<div class="ref_texte">
		<p>Julien a collaboré durant 4 mois au projets de Kaliop (stage), et à fait preuve de grandes capacités d'adaptations et d'auto apprentissages aux technologies de l'entreprise.</p>
		<p>Je recommande donc toutes les collaborations envisagées avec Julien, notamment autour du développement Web, un sujet qu'il maîtrise parfaitement et qui le passionne.</p>
	</div>
	<p class="ref_by">
		Référence rédigée par Gilles Guirand<br /> 
		<strong>Directeur technique, Kaliop</strong><br />
		Consultez la recommandation originale sur <a href="http://www.viadeo.com/fr/profile/julien.lafont5#position_5032025">mon profil Viadeo</a>
	</p>
</div>

<div class="reference">
	<div class="ref_texte">
		<p>J'ai eu le plaisir de travailler avec Julien sur différents projets. Pendant la durée de son stage il a su :<br />
		- s'adapter aux situations pas toujours simple qui se sont présentées<br />
		- mener à bien les différentes tâches qui lui ont été confiées<br />
		- faire remonter rapidement les alertes lorsqu'il rencontrait des problèmes<br />
		- être force de proposition pour régler des problèmes et trouver des solutions techniques.</p>
		<p>J'ai particulièrement apprécié son professionalisme, son dynamisme et sa bonne humeur qui ont rendu ces quelques mois de collaboration particulièrement agréables.</p>
	</div>
	<p class="ref_by">
		xRéférence rédigée par Olivier Clavel<br /> 
		<strong>Responsable Pôle Support et Maintenance, Kaliop</strong><br />
		Consultez la recommandation originale sur <a href="http://www.viadeo.com/fr/profile/julien.lafont5#position_5032025">mon profil Viadeo</a>
		
	</p>
</div>

<style type="text/css">
.reference { 
	margin: 5px;
	padding: 5px;
	border: 1px solid #ddd;
	
	background-image: linear-gradient(bottom, rgb(255,255,255) 100%, rgb(243,243,243) 0%);
	background-image: -o-linear-gradient(bottom, rgb(255,255,255) 100%, rgb(243,243,243) 0%);
	background-image: -moz-linear-gradient(bottom, rgb(255,255,255) 100%, rgb(243,243,243) 0%);
	background-image: -webkit-linear-gradient(bottom, rgb(255,255,255) 100%, rgb(243,243,243) 0%);
	background-image: -ms-linear-gradient(bottom, rgb(255,255,255) 100%, rgb(243,243,243) 0%);
	background-image: -webkit-gradient(linear, left bottom, left top, color-stop(1, rgb(255,255,255)), color-stop(0, rgb(243,243,243)));
	
	-webkit-border-bottom-left-radius: 20px;
	-moz-border-radius-bottomleft: 20px;
	border-bottom-left-radius: 20px;
	
	-webkit-box-shadow: 2px 2px 5px #DBDBDB;
	-moz-box-shadow: 2px 2px 5px #DBDBDB;
	box-shadow: 2px 2px 5px #DBDBDB;
	
	margin-bottom: 15px
}

.ref_texte {
	font-family: 'lucida grande', tahoma, verdana, Arial, Verdana, sans-serif;
	font-size: 11px;
	margin: 5px;
}

.ref_texte p {
	margin-bottom: 5px;
	line-height: 19px
}

.ref_by {
	text-align:right;
	font-family: 'lucida grande', tahoma, verdana, Arial, Verdana, sans-serif;
	font-size: 11px;
	line-height:20px
}

.ref_by a {
	color: #4C9AB2;
}
.ref_by a:hover {
	font-weight: bold;
}
</style>

<?php slot('menu_gauche')?>

  <?php include_partial('design/blocCv')?>
  <?php include_partial('contact/reseauxSociaux')?>
  <?php include_component('folio', 'blocDerniersAjouts', array('nb'=>5, 'message'=>'Portfolio'))?>
  
<?php end_slot() ?>