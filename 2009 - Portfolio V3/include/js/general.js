//:: Configuration :://
_URL='http://www.studio-dev.fr/';
//_URL='http://127.0.0.1/portfolio%20V2/';









var fenetreConnexionOuverte=0;



// Règles

$(document).ready(function(){
	/* ---- Panneau navigation mobile */
	$('#navigationOuvrir').click( function() {
			$('#utils').slideDown(1000, 'easeOutBounce', null);
			$(this).fadeOut(100, function() { 
				$('#navigationFermer').fadeIn(900);
			});
	} );
	
	$('#navigationFermer').click( function() {
			$('#utils').slideUp(1000, 'easeInExpo', null);
			$(this).fadeOut(100, function() { 
				$('#navigationOuvrir').fadeIn(900);
			});
	} );	/* ---- Changement de background ---- */
	$('#bg3').click( function() {
			changerWallpaper('bg7.jpg', 3);
	} );	
	$('#bg2').click( function() {		
	changerWallpaper('bg9.jpg', 2);
	} );	$('#bg1').click( function() {
	changerWallpaper('bg5.jpg', 1);
	} );	/* ---- Système de connexion ---- */
	$('#lien_header').click( function() {
			afficherConnexion();
	} );	
	$('#closeConnexion').click( function() {
			fermerConnexion();
	} );
	
});

	
//-- Connexion AJAX --//
function afficherConnexion() {
	
	
	// On affiche les 2 input //
	if ($('#con_login')) $('#con_login').css("display","inline");
	if ($('#con_pass')) $('#con_pass').css("display","inline");
	if ($('#con_sub')) $('#con_sub').css("display","inline");
	
	if (fenetreConnexionOuverte==0) {
		
		$('#connexion').animate(
		{
			left: '140px',
			top: '180px',
			width:'200px',
			height:'230px',
			opacity: '0.85'
			
		},
		1000, 
		'easeOutCirc' );
		fenetreConnexionOuverte=1;
		$('#connexion').draggable();
	}
	
}

function fermerConnexion() {
	
	if (fenetreConnexionOuverte==1) {
		
		$('#connexion').animate(
		{
			left: '800px',
			top: '100px',
			width:'50px',
			height:'50px',
			opacity: '0'
			
		},
		2500, 
		'easeInBounce' );		
		fenetreConnexionOuverte=0;
		
	}
}
function connexion_ajax() {
	_login=escape($('con_login').value);
	_pass=escape($('con_pass').value);
	
	if (_login.length<=3) $('con_pass').style.borderColor="#FF6600";
	else if (_pass.length<=3) $('con_pass').style.borderColor="#FF6600";
	else {
		$('con_sub').value="Verification";
		ajax('post', 'pages/fonctions/connexion.php', 'login='+_login+'&pass='+_pass, 'connexion_verif');
	}	
}
function connexion_verif(r) {
	r=unescape(r);
	if (r=="+")  {
		pseudo=$('con_login').value;
		txt="<div style='text-align:center'><p>&nbsp;</p><p>Bienvenue <b>"+pseudo+"</b></p><p><a href='?admin/accueil'>Accéder à l'administration</a></p></div>";
		new Effect.Fade('con_contenu', { duration:1, afterFinish:function() {
			$('con_contenu').innerHTML=txt;
			new Effect.Appear('con_contenu');
		} });
	}
	else 
	{
		$('con_mess').innerHTML="<span style='color:#F6F; font-weight:bold'>Identifiants inconnus</span>";
		$('con_sub').value="Connexion";
	}
	
}


//-- Changer wallpaper --//
function changerWallpaper(img, id)
{
	idLi=$('#liMin'+id);
	idMin=$('#bg'+id);

	// On remet les class par defaut
	elem=$('#couleurs img');
	$.each(elem, function(i) {
		if (elem[i].className=="active") elem[i].className="";
	} );
		
	idMin.fadeTo(700, 0.5, function() {
		// on affiche le bouton wait
		idLi.html(idLi.html()+"<img src='theme/images/ajax-loader2.gif' style='opcity:0.5; position:relative; top:-45px; left:10px' id='waitbg"+id+"' />");

		// On précharge l'image wallpaper
		imgPreloader = new Image();
		imgPreloader.onload=function(){
		// On cache le div actuel
		$('#primary').fadeTo(1000, 0.001, function() {
				
				
				$('#primary').css('background-image', "url(theme/images/"+img+")");
				
				// On le raffiche
				$('#primary').fadeTo(700,1,  function() {
						;
					// Suppression de l'image wait
					$('#waitbg'+id).fadeOut(500, function() {
						
						// Miniature opacité normale avec style actif
						$('#liMin'+id+' a:first').html("<img src='theme/images/min_"+img+"' class='active' id='bg"+id+"' onclick='changerWallpaper(\""+img+"\","+id+"); return false' />");
					} );
					
				} );
																										   
		} );	
		
		}
		imgPreloader.src = 'theme/images/'+img;
		
	} );
	
	// On sauvegarde le thème dans un cookies
	document.cookie ="theme='theme/images/"+img+"'; path=/portfolio/;";
}
	

//-- Changement News --//
function news_naviguer(action, obj) {
	idCurrent=Math.round($('#id_news_courante').html());
	$('#wait').show();
	ajax('get', 'pages/news_ajax.php', 'act=recup_apercu&idCurrent='+idCurrent+'&dir='+action+'&obj='+obj, 'afficherNews');
}
function direct_news(id) {
	$('#wait').show();
	ajax('get', 'pages/news_ajax.php', 'act=recup_apercu&idAff='+id, 'afficherNews');	
}
function news_detail() {
	id=Math.round($('#id_news_courante').html());
	$('#wait').show();
	ajax('get', 'pages/news_ajax.php', 'act=recup_apercu&idAff='+id+'&obj=detail', 'afficherNewsDetail');
	
}
function afficherNews(r) {
	
	var doc = eval(unescape(r)); /* Données Json dans infosNews */
	
	$('#n_contenu').fadeTo(1000, 0.001, function() { 
		$('#n_titre').html(infosNews.titre);
		$('#n_date').html(infosNews.date);
		$('#n_contenu').html(infosNews.contenu);
		$('#n_cat').html(infosNews.cat);
		$('#id_news_courante').html(infosNews.id);
		
		if (infosNews.suivant==0) $('#fleche_droite').hide();
			else $('#fleche_gauche').show();
		if (infosNews.precedent==0) $('#fleche_gauche').hide();
			else $('#fleche_droite').show();

		$("#n_contenu").fadeTo(700, 1, function() { 
			$('#wait').hide(); 
		} );
	} );
				
}
function afficherNewsDetail(r) {
	
	var doc = eval(unescape(r)); /* Données Json dans infosNews */
	
	$('#primary').fadeTo(1000, 0.001, function() { 
		$('#primary').removeClass('twocol-stories');
		$('#primary').addClass('onecol-stories');
		$('#n_titre').html(infosNews.titre);
		$('#n_date').html(infosNews.date);
		$('#n_contenu').html(infosNews.contenu);
		$('#n_cat').html(infosNews.cat);
		$('#id_news_courante').html(infosNews.id);
		
		if (infosNews.suivant==0) $('#fleche_droite').hide();
			else $('#fleche_gauche').show();
		if (infosNews.precedent==0) $('#fleche_gauche').hide();
			else $('#fleche_droite').show();
		
		$("#primary").fadeTo(700, 1, function() { 
			$('#wait').hide(); 
		});
	});	

}

function contact_cacher()
{
  $('#infos').hide();
  $('#partenariat').hide();
  $('#devis').hide();
}

function contact_afficher(id)
{
	$('#'+id).fadeIn();
}

function contact_verif() {
	
	switch($('#form_type').val()) {
		case "infos": num=1; break;
		case "devis": num=2; break;
		case "partenariat": num=3; break;
	}
	
	statut=$('#statut'+num);
	
	statut.html('Traitement en cours<br /><img src="images/wait.gif" alt="wait" />');
	statut.show();
	
	error=0;
	if ( $('#form_email').val()=="") {
		error=1;
		$('#form_email').css('borderColor',"#FF3333");
	}
	else { $('#form_email').css('borderColor',"#B9B9B9"); }
	if ( $('#form_nom').val()=="") {
		error=1;
		$('#form_nom').css('borderColor',"#FF3333");
	}
	else { $('#form_nom').css('borderColor',"#B9B9B9"); }
	
	if (error==1) {
		statut.html('<b style="color:#FF3333">Erreur</b><br />Le formulaire n\'a pas été rempli correctement.</b>');
	}
	else
	{
		donnees=getDataFromForm(document.contact);
		ajax('post', 'pages/contact_ajax.php', donnees, 'contact_send');
	}	
	
}

function contact_send(r) {

	if (unescape(r)=="ok") {
		$('#primary_effect').fadeTo(500, 0.05, function() { 												  
			$('#contenu').html("<br /><br /><br /><br /><center><b>Votre message m\'a été transmis avec succés.</b><br /><br /><br />Une réponse vous sera envoyée dans les plus bref délais.<br />Julien LAFONT</center><br /><br /><br /><br />");
			$('#primary_effect').fadeTo(500,1);
		});
	}
	else
	{
		alert('Une erreur est survenue durant l\'envoie du formulaire. \n\nVeuillez réitérer votre demande ultérieurement ou me contacter directement à l\'adresse : contact@studio-dev.fr\n\nMerci.');
	}
}

function plus_largeur(id, idFleche2) {
	taille_courant=$("#"+id).width();
	$("#"+id).animate({width:(taille_courant+80)+'px'});
	left_courant=$("#"+idFleche2).css('margin-left').split('px');
	$("#"+idFleche2).animate({marginLeft:(parseInt(left_courant[0])+80)+'px'}); 	
}

function plus_hauteur(id) {
	taille_courant=$("#"+id).height();
	$("#"+id).animate({height:(taille_courant+80)+'px'}); 
}




// ----------------------------------------------------------------------------------- //
// ----------------------- FONCTIONS GENERALES ---------------------------- //
// ----------------------------------------------------------------------------------- //

// Script Ajax perso ( POST/GET en asynchrone )
function ajax ( type, fichier, variables /* , fonction */ ) 
{ 
	if ( window.XMLHttpRequest ) var req = new XMLHttpRequest();
	else if ( window.ActiveXObject ) var req = new ActiveXObject("Microsoft.XMLHTTP");
	else alert("Votre navigateur n'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés");
	if ( arguments.length==4 ) var fonction = arguments[3];

	if (type.toLowerCase()=="post") {
		req.open("POST", _URL+fichier, true);
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
		req.send(variables);
	} else if (type.toLowerCase()=="get") {
		req.open('get', _URL+fichier+"?"+variables, true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=iso-8859-1');
		req.send(null);
	} else { 
		alert("Méthode d'envoie des données invalide"); 
	}

	req.onreadystatechange = function()  { 
		if (req.readyState == 4 && req.responseText != null )
		{				
			if (fonction) eval( fonction + "('"+escape(req.responseText)+"')");
			
		} 
	}
}

// Permet de retirer toutes les infos d'un form
function getDataFromForm(Form) {  
	var data=""; 
	var key=0; 
	for (key=0;key<Form.elements.length;key++) { 
		if (Form.elements[key].tagName.toLowerCase()=="select") {
			currentValue=getSelectValue(Form.elements[key]);
		} else {
			currentValue=Form.elements[key].value;
		}
		if (currentValue!="undefined" && currentValue!="") data+=escape(Form.elements[key].name)+"="+escape(currentValue)+"&"; 
	}  
	return data.substr(0, data.length-1); 
}
function getSelectValue(selectt) {
	var value="";
	for (var i=0; true; i++) {  
		if (selectt.options[i]) { if (selectt.options[i].selected) value += selectt.options[i].value + ","; } 
		else {return value.substr(0, value.length-1); }  
	} 
}	


// Equivalent perso de isset( )
function isset(varname){
  return (typeof(varname)!='undefined');
}



function show_flash(w, h, swf) {
    document.write("<object class=\"flash\" type=\"application/x-shockwave-flash\" data=\"" + swf + "\" width=\"" + w + "\" height=\"" + h + "\">");
    document.write("<param name=\"movie\" value=\"" + swf + "\" />");
    document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
    document.write("<param name=\"pluginurl\" value=\"http://www.macromedia.com/go/getflashplayer\" />");
    document.write("<param name=\"wmode\" value=\"transparent\" />");
    //document.write("<param name=\"bgcolor\" value=\"" + color + "\" />");
    document.write("<param name=\"menu\" value=\"false\" />");
    document.write("<param name=\"quality\" value=\"best\" />");
    document.write("<param name=\"scale\" value=\"exactfit\" />");
    //document.write("<param name=\"flashvars\" value=\"" + fvar + "\" />");
    document.write("</object>");
}

function afficher_crea(elem) {
	var srcImg;
	var nomImg;
	var url;
	
	 switch(elem) 
	 {
		case "creation_ftc": 	srcImg="ftc2.png"; 			nomImg="Fais Ton Choix"; 		url="http://www.studio-dev.fr/portfolio-9-Fais-ton-choix-Duels-de-photos-en-ligne.htm"; break;
		case "creation_img": 	srcImg="imagup.png"; 		nomImg="Imagup Recherche"; 		url="http://www.studio-dev.fr/portfolio-8-Pleax-Partage-communautaire-de-photos.htm"; break;
		case "creation_d4": 	srcImg="d42.png"; 			nomImg="Dimension 4"; 			url="http://www.studio-dev.fr/portfolio-2-Team-Dimension-4.htm"; break;
		case "creation_pf":		srcImg="studio-dev4.png"; 	nomImg="Studio-dev.fr"; 		url="http://www.studio-dev.fr/portfolio-1-Studio-Dev-Portfolio-web-2-0.htm"; break;
		case "creation_wb":		srcImg="wixblog.png"; 		nomImg="WixBlog"; 				url="http://www.studio-dev.fr/portfolio-3-Wixblog-Blog-gratuits-nouvelle-generation.htm"; break;
		case "creation_wp":		srcImg="wixpay.png"; 		nomImg="WixPay"; 				url="http://www.studio-dev.fr/portfolio-4-Wixpay_Votre-nouvelle-regie-publicitaire.htm"; break;
		case "creation_sms":	srcImg="sms2.png"; 			nomImg="Sms by YoTsumi";		url="http://www.studio-dev.fr/portfolio-5-Service-d-envoie-gratuit-de-sms-by-Yotsumi.htm"; break;
		case "creation_philhar":srcImg="philhar3.png"; 		nomImg="Philhar du Vaucluse"; 	url="http://www.studio-dev.fr/portfolio-6-les-philharmonistes-des-pays-du-vaucluse.htm"; break;
		case "creation_style":	srcImg="monstyle.png"; 		nomImg="Mon Style"; 			url="http://www.studio-dev.fr/portfolio-7-Mon-Style_Site-de-rencontre-Quebec.htm"; break;
		case "creation_hk":		srcImg="hk.png"; 			nomImg="Samuel Hounkpe Blog"; 	url="http://www.studio-dev.fr/portfolio-12-blog-2-0-de-samuel-hounkpe.htm"; break;
		case "creation_cp":		srcImg="cp.png"; 			nomImg="Chansons-Paroles"; 		url="http://www.studio-dev.fr/portfolio-11-chansons-paroles-traductions-clips-musique-francaise-et-internationale.htm"; break;
	 }
	
	if ($.browser.msie) {
		window.location.replace(url);
	}
	else
	{
		$("#nomRea").text(nomImg);
		$('#aff_detail').fadeTo(1000, 0.01, function() {
			ajax('get', 'pages/portfolio_ajax.php', 'act=detail&nom='+elem, 'show_details');
		});
	}
}

function show_details(r) {

	$('#aff_detail').html(unescape(r));
	
	$(document).ready( function(){
	    $('ul#animated-portfolio').animatedinnerfade({
		speed: 1000,
		timeout: 5000,
		type: 'sequence',
		containerheight: '250px',
		containerwidth: '400px',
		animationSpeed: 7000,
		animationtype: 'fade',
		bgFrame: 'none',
		controlBox: 'none',
		displayTitle: 'none'
		});
	} ); 
					
	$('#aff_detail').fadeTo("slow", 1);	
	
}

/* ---------------------------------------- ADMIN ------------------------------------------------- */
function verifAjouterNews()
{
		$("#_contenu").val(oEdit1.getHTMLBody());
		return true;
}
