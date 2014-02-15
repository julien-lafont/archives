
var ul_h, ul_w, site_h, site_w;
var set=0;
	
$(document).ready(function(){ 
	$(document).pngFix(); 
	attribuer_regles();
	prettyPhoto.init();
});


function attribuer_regles() {
	
	jQuery("div.codaslide").codaSlider()
	
	$('#siteweb ul li a, #design ul li a, .raccourci_ppp a').tooltip({ 
	    track: true, 
	    delay: 0, 
	    showURL: false, 
	    showBody: "|"
	});
	

	
	$(".nav_competences").click(function() {
		$.scrollTo("#skills", {speed:1000, axis:"y"});
		return false;
	});

	// Règle pour le bouton retour
	$(".retour_site a").bind("click", function() {
		$("#siteweb ul.gen").show();
		$("#siteweb .detail").hide(500);	
		$(".retour_site").fadeOut(500);
		
	    $("#siteweb").animate({height:site_h, width:'80%'}, {duration:500, complete:function() {
	    	
			$("#siteweb ul.gen").css({ width:ul_w, height:ul_h});
			$("#siteweb ul.gen").animate({opacity:1}, {duration:500});
			$("#siteweb ul.gen").css("overflow", "visible");
			
			$(".help").show(); // Réaffiche le message d'aide
		}});
		return false;
	});
	
	
	
				
	$(".info_rea").bind("click", function() {
		
		// Copie des dimensions
		if (set==0) {
			ul_h=$("#siteweb ul.gen").height();
			ul_w=$("#siteweb ul.gen").width();
			site_h=$("#siteweb").height();
			site_w=$("#siteweb").width();
			set=1;
		}
	
		// On récupèe le détail du site
		$.ajax({
		  type: "GET",
		  url: "ajax.php?folio&act=site_detail&prefix="+this.rel,
		  dataType: "htm",
		  success: function(html){
		  	
			var r = unescape(html);
			
			$("#siteweb ul.gen").css("overflow", "hidden");
			
			$("#siteweb .detail").html(r);
			  
	  		$("#siteweb ul.gen").animate({opacity:0, height:0, width:0}, {duration:500, complete:function() {
				$("#siteweb ul.gen").hide();
			}});
			$("#siteweb").animate({height:'270px', width:'500px'}, {duration:1000, easing:'easeOutBounce', complete:function() {
				$("#siteweb").css({height:'auto'});
				$("#siteweb .detail").fadeIn(500);
				$(".retour_site").fadeIn(500);
			}});
					
			// Active les infos bulles sur les détails
			$('#siteweb .detail a').tooltip({ 
	    		track: true, 
	    		delay: 0, 
	    		showURL: false, 
	    		showBody: "|"
			});
			
			// Ré-Initialise le viewer d'image
			prettyPhoto.init();
			
			$(".help").hide(); // Vire le message d'aide		
		  }
		});
			

		return false;
	});

}


function info_tag(code) {
	
	var txt;
	switch(code) {
		case "web": txt="Ma spécialité, le web 2.0 : Esprit communautaires et nouvelles technos : Ajax, Ruby's ..."; break;
		case "geek": txt="Avec ma powerball, mon dual-screen, ma wii et mon hélico-télécommandé, je dois bien avouer que je suis un peu geek :)"; break;
		case "msn" : txt="Je ne compte plus le nombre de claviers usés pas ce logiciel !"; break;
		case "friends": txt="Parce que je ne suis pas un nolife, j'ai encore des ami(e)s !"; break;
		case "dev" : txt="Ma société, mes euros durement gagnés, et mes impots facilement perdus ! <br />Entrepreneur, un métier d'avenir."; break;
		case "societe": txt="Gérer une société, tâche difficile mais au combien gratifiante !"; break;
		case "musique": txt="10 ans de clarinette, 5 ans d'orchestre et une centaine de concerts"; break;
		case "ajax": txt="Non pas le nettoyant hyper puissant, mais un langage de programmation longtemps délaissé qui a permi l'avènement du web 2.0<br />Des appels PHP côté client, une véritable révolution !"; break;
		case "internet": txt="Le monde si riche d'internet, une de mes passions.<br />Rien ne m'échape, toutes les tendances passent par mon aggrégateur rss."; break;
		case "design": txt="Le web-design, le product-design, la déco... bref l'Art <br />Malheureusement, Dieu n'a pas pensé à me donner ce don !"; break;
		case "comic":  txt="Une passion toute particulière pour ces Web-BD si amusantes.<br />Ma préférée : <a href='http://www.maliki.com'>Maliki</a>"; break;
		case "serigraphie": txt="L'impression de motifs personnalisés sur Teeshirt, une activité florissante. <br />Ajoutez à cela une communauté de designer ultra-motivés, vous obtenez une Start-Up en pleine croissance.<br />cf : <a href='http://www.lafraise.com'>LaFraise</a> - Un exemple à suivre !"; break;
		case "open" : txt="Travailler en collaboration sur des projets Open-Source, un loisir gratifiant mais hautement complexe"; break;
		case "firefox": txt="Le logiciel qui a surement le plus d'heure à son actif sur mon pc !<br />Ce que je préfère, c'est sa moduralité : il est très simple de créer des extentions.<br />Message perso : vous qui utilisez IE6, pensez à nous pauvres développeurs, et passez à FF svp !"; break;
		case "partage": txt="Le partage est la notion la plus importante sur un réseau, et internet la remplie parfaitement. <br />Echange d'idée, de connaissances, d'avis, de fichiers :)"; break;
		case "mario": txt="Qui n'aime pas le plombier moustachu ?"; break;
		case "series": txt="Je dois bien avouer que mon addiction aux séries TV est loin de s'arranger :<br />Jericho, Heroes, Lost, Grey Anatomy, Dexter, Earl, NCIS, Nip Tuck... la liste est longue :)"; break;
		case "mangas": txt="Les mangas, les animes, principalement celles de Monsieur Hayao Miyazaki : de purs chefs d'oevres."; break;
		case "entrepreneur": txt="Entrepreneur, un métier d'avenir ?"; break;
		case "ada": txt="Entre ADA et moi, une grande histoire d'amour.<br />Pour les non-initié, ADA est un langage de programmation à la rigueur militaire, et c'est ce langage que nous apprenons à l'IUT"; break;
		case "netvibes": txt="Netvibes, ou 'un exemple de réussite à la française'. La homepage web 2.0 de référence grâce à ces nombreux widgets, sa communauté, et son aggregateur RSS sans faille"; break;
		case "twitter": txt="Twitter, Facebook, Loomiz : les dernières tendances du web, des succès immédiats.<br />Note à moi même : penser à prendre exemple."; break;
		case "google": txt="Google : sauveur ou exécuteur ? La seule entreprise à pouvoir contrecarer le monopole de Microsoft.<br />+ L'entreprise aux employés les plus productifs. Je suis perplexe"; break;
		case "IUT":  txt="Comment parler du lieu où je passe 1/3 de ma vie :)<br /> Des gars cool, des geek, des nolifes, mais en tout cas, pas assez de filles ^^"; break;
		case "programmation": txt="Une passion qui a commencé très jeune. <br />Ma première réalisation ? De souvenir, un pong en Qbasic et un site sur les Pokemons !"; break;
		
		default: txt="Bouh !"; break;
	
	}
	
	
	$("#taginfo").html(txt).animate({borderWidth: "3px", padding:"3px"}, {duration:100}).animate({borderWidth: "1px", padding:"5px"}, {duration:100});
	
}