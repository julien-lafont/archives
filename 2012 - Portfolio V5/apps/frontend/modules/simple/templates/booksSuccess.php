<div class="bibliotheque" > 
	
	<h4>Domaines de compétences</h4>
	
	<p class="biglines">La <strong>formation continue</strong> est selon moi indispensable pour un ingénieur en informatique. A ce titre, 
		je participe dés que l'occasion se présente à des formations ou des conférences (dernière en date: l'Agile Tour Montpellier).
		Je suis également un lecteur assidu de blogs et de livres, sur des sujets aussi nombreux que diversifiés.</p>
		
	<p class="biglines">Cette page vous présente 3 des sujets qui me tiennent le plus à coeur, qui représentant également mes principaux domaines de compétences.</p>
		
	<?php foreach($sf_data->getRaw('livres') as $categorie): ?>
	
		<h5><?= $categorie['titre']?></h5>
		<blockquote><?= $categorie['description']?></blockquote>
		<ul class="rayon">
			<?php foreach ($categorie['references'] as $i => $livre): ?>
			<li class="<?= ($i%4==0) ? 'first' : ''?>">
				<a href="<?= $livre['url'] ?>" target="blank" class="tip" title="[strong]<?= $livre['titre']?>[/strong][p]<?=$livre['description']?>[/p]">
					<img src="/images/books/<?= $livre['src']?>" alt="<?= $livre['titre']?>" />
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach ?>
	
	<i>Bien évidemment, mes lectures ne se résument pas seulement à l'informatique ;-) J'ai souhaité me focaliser
		sur ces quatre domaines qui représentent le coeur de mes compétences.</i>
	
</div>

<?php slot('menu_gauche')?>

  <?php include_partial('design/blocCv')?>
  <?php include_partial('contact/reseauxSociaux')?>
  <?php include_component('folio', 'blocDerniersAjouts', array('nb'=>5, 'message'=>'Portfolio'))?>
  
<?php end_slot() ?>