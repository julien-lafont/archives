<?php 
$module = $sf_context->getModuleName();
$action = $sf_context->getActionName();

switch($module): 
?>
<?php case "accueil": ?>

    <hgroup class="bigTitlePages icon_home">
        <h2>Welcome @ Studio-dev.fr</h2>
        <h3>CV , Portfolio et Blog de veille technologique</h3>
    </hgroup>
    
<?php break;
		case "blog":
?>

    <hgroup class="bigTitlePages icon_blog">
        <h2>Blog</h2>
        <h3>Expérimentations et retours d'expérience</h3>
    </hgroup>

<?php break;
    case "cv":
	
	if ($action == 'index') {
	
?>

    <hgroup class="bigTitlePages icon_cv">
        <h2>Curriculum Vitae</h2>
        <h3>Expériences, compétences et projet professionel</h3>
    </hgroup>
	
<?php
	} 
	else if ($action == 'references') 
	{
?>

    <hgroup class="bigTitlePages icon_cv">
        <h2>Recommandations</h2>
        <h3>Que pensez-vous de mon travail ?</h3>
    </hgroup>
	
<?php
	}
?>
	

<?php break;
    case "folio":
?>

    <hgroup class="bigTitlePages icon_folio">
        <h2>Portfolio</h2>
        <h3>Parcourez mes réalisations web & software</h3>
    </hgroup>
       
<?php break;
    case "contact":
?>

    <hgroup class="bigTitlePages icon_contact">
        <h2>Contact</h2>
        <h3>You talkin' to me?</h3>
    </hgroup>
      
<?php break;
	  default:
?>

    <hgroup class="bigTitlePages icon_home">
        <h2>Welcome @ Studio-dev.fr</h2>
        <h3>CV , Portfolio et Blog de veille technologique</h3>
    </hgroup>
    
<?php endswitch; ?>