<div class="landing_centre">
  <h3>Qui suis-je ?</h3>
  <p class="biglines">
    Bienvenue sur mon e-portefolio. Je m'appelle <strong>Julien Lafont</strong>, j'ai 22 ans et je suis en cinquième année d'école d'ingénieur <strong>EPSI</strong>. 
    Sur ce site, vous pourrez obtenir plus d'informations sur mon parcours et mes compétences en consultant mon <a href="<?php echo url_for('@cv')?>" title="Lire mon cv pour le titre d'Ingénieur Etude et Développement">CV</a> et mes <a href="<?php echo url_for('@folio')?>" title="Portfolio de Julien Lafont">réalisations</a>. 
    Si mon profil vous intéresse et que vous souhaitez obtenir de plus amples informations, n'hésitez pas à me <a href="<?php echo url_for('@contact')?>" title="Contactons nous !">contacter</a>. 
  </p>
   <h4>Où me rencontrer ?</h4	>
   <p class="biglines">Vous pourrez me croiser régulièrement aux <strong>Apéros web</Strong> et <strong><accronym title='Java User Group'>JUG</accronym></strong> à Montpellier.
    <br />J'ai aussi prévu de participer au 
    		au <a href="http://www.devoxx.fr/display/FR12/Accueil" target="blank" class="tip" title="Conférence anglophone [strong]Java[/strong] européenne avec conférences et ateliers sur 3 jours">Devoxx France</a> (Paris, avril 2012)
    		et évidemment à <a href="http://sudweb.fr/" class="tip" target="blank" title="Savoir faire et faire savoir dans le [strong]Sud[/strong] de la France">SudWeb</a> (Toulouse, mai 2012).
    <br />Vous avez déjà pu m'apercevoir à l'<strong>Agile Tour Montpellier</strong> ou aux <strong>Startup Weekend</strong> de Marseille et Montpellier</p>
 
</div>

<aside class="landing_droite">
  <div class="blog"><a href="http://www.studio-dev.fr/blog"></a></div>
  <div class="cv"><a href="<?php echo url_for('cv')?>"></a></div>
  <div class="folio"><a href="<?php echo url_for('folio')?>"></a></div>
</aside>

<br class="clear" />


<div class="landing_centre annexes" style="width:857px; background-color:#F2F2F2; border:1px solid #DADADA; border-radius: 10px; margin-top: 20px">
  <div class="col40">
    <h4 class="center">En direct du Blog</h4>
    <ul class="puce bullet-blue">
      <?php include_component('blog', 'listeDerniersArticles', array('nb'=>5));?>
    </ul>
  </div>
  
  <div class="col30">
    <h4 class="center">Dernières créations</h4>
    <ul class="landing_creations">
      <?php include_component('folio', 'dernieresMiniatures')?>
    </ul>
  </div>
  
  <div class="col30">
    <h4 class="center">Dernière lecture</h4>
   	<div class="book">
   		<div>
	   		<a href="<?php echo url_for('competences')?>" class="tip" title="Un livre permettant de prendre conscience des responsabilités et des devoirs d'un développeur [strong]professionel[/strong], d'un [strong]craftsman[/strong].[br]Je conseille vivement sa lecture !">
	   			<img src="/images/books/the-clean-coder.jpg" alt="Clean coders" style="b" />
	   		</a>
	   		
   		</div>
   	</div>
  </div>
</div> 

  
<style>
	accronym {
		border-bottom: 1px dotted #AAA;
		cursor: help
	}
</style>

