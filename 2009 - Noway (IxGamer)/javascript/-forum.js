var rediriger0; var rediriger1;
var content='.content';

function naviguer_forum (action, id, page /* message */ ) {
	
	if ( arguments.length==4 ) var message = arguments[3];

	
	// Fading du contenu :
	if (isset(message)) $('#in_chargement_txt').html(message);
	else { $('#in_chargement_txt').html(""); $("#chargement").fadeIn(700); }
	
	
	$(content).fadeOut(700, function() { 
		
		// On génère les arguments pour l'envoie ajax
		switch(action) {
			case "categorie":
				arg='act=liste_sujets&id='+id+'&page='+page;
			 break;
			case "accueil":
				arg='act=accueil';
			 break;
			case "message":
				arg='act=afficher_message&id='+id+'&page='+page;
			 break;
			case "nouveau":
				arg='act=nouveau&id='+id;
			 break;
			case "repondre":
				arg='act=repondre&id='+id;
			 break;
			case "editer":
				arg='act=editer&id='+id;
			 break;
			case "invite": /* invité -> impossible de poster */
				arg='act=invite';
			 break;
		}
		
		// Préparation de la requete ajax :
		ajax('get', 'pages/forum_ajax.php', arg, 'afficher_forum');
				

												  
	} );
	
	
}

// Retour ajax : affiche le nouveau contenu
function afficher_forum(r) {
	var r = unescape(r).split('|:|');
	
	document.title=r[0];
	
	h.majHashCourant(r[1]);
	window.location.hash=r[1];

	$(content).html(r[2]);
		

	$(content).fadeIn(700, null, 'elasticin');
	$('#chargement').fadeOut(700);
	
	if ($("#raccourci_admin")) { JSFX_FloatTopDiv(); }

}

var editInPlaceS=0;
var editInPlaceM=0;

function editInPlaceSujets(action, id, page) {
	
	// Si l'édition n'est pas encore activée
	if (editInPlaceS==0) {
		
		 $(".editme1").parent().each(function(i){ 		$(this).removeAttr('onclick');
														$(this).removeAttr('href');
												});
		 $(".editme1").each(function(i){ $(this).css({ background:'#D7F1FF', borderBottom:'1px dotted #00A8FF', paddingBottom:'1px'}); });

		 $(".editme1").editInPlace({
			url: _URL+"pages/forum_ajax.php?act=admin_edit_sujet"
		});
		 
		$("#editSujet").children("p").children("a").html("<center><span style='color:#0066FF'>Stopper l'édition</span></center>");
		
		 editInPlaceS=1;
	}
	else
	{
		editInPlaceS=0;
		naviguer_forum(action, id, page);
	}
}

function editInPlaceMessage(action, id, page) {
	
	// Si l'édition n'est pas encore activée
	if (editInPlaceM==0) {
		
		 $(".contenu_forum").each(function(i){ $(this).css({ background:'#D7F1FF', borderBottom:'1px dotted #00A8FF', paddingBottom:'1px'}); });

		 $(".contenu_forum").editInPlace({
			url: _URL+"pages/forum_ajax.php?act=admin_edit_message",
			field_type:'textarea'

		  });
		 
		$("#editMessage").children("a").children("p").html("<center><span style='color:#0066FF'>Stopper l'édition</span></center>");
		
		 editInPlaceM=1;
	}
	else
	{
		editInPlaceM=0;
		naviguer_forum(action, id, page);
	}
}

function supprMessAdmin(id) {
	
	$("#chargement").fadeIn(700); 
	$(content).fadeOut(700, function() { 
		
		// Préparation de la requete ajax :
		ajax('get', 'pages/forum_ajax.php', 'act=admin_suppr&id='+escape(id), 'afficher_forum');
				
	} );
}

function postitAdmin(id, act) {
		
	// Préparation de la requete ajax :
	ajax('get', 'pages/forum_ajax.php', 'act=admin_postit&id='+escape(id)+'&action='+escape(act), 'postitAdmin2');
}

function postitAdmin2(r) {
	if (unescape(r)=="ok") 
		$("#adminPostit").children("p").children("a").html("Mis à jour !");
	else 
		alert('Une erreur est survenue !');
}

function verif_nouveau_message(page) {
	
	
	_mess=escape($('#messageBG').val());
	
	if (page=="cat") {  //  Nouveau message dans une catégorie
						_id=escape($('#id_cat').val()); 
						_titre=escape($('#titre').val()); 
						act="poster_nouveau_message"; 
						retour="retour_nouveau_message"; 
						
	} else	{ 			// Réponse à un message
						_id=escape($('#id_mess').val()); 
						act="poster_nouvelle_reponse";
						retour="retour_nouvelle_reponse"; 
						_titre="";
	}
		  
	error=0;
	
		// Vérification du titre
		if (page=="cat") {   
		if (_titre.length<=5) {
			$('#titre').css({border:"1px dotted #FF3333"});
			$('#retour_titre').html("<img src='images/boutons/button_cancel.png' /> Le titre doit faire 5 caractères au minimum.");
			$('#retour_titre').BlindDown(500, function() { 
				$('#retour_titre').Shake(1);							   
			}); 												  
			error=1;
		}
		else
		{
			$('#titre').css({border:"1px solid #ccc"});
			$('#retour_titre').hide();
			
		}
		}
			
		// Vérification du message
		if (_mess.length<10) {
			$('#messageBG').css("border","1px dotted #FF3333");
			$('#retour_message').html("<img src='images/boutons/button_cancel.png' /> Votre message est trop court pour être posté.");
			$('#retour_message').BlindDown(500, function() { 
				$('#retour_message').Shake(1);							   
			}); 												  
			error=1;
		}
		else
		{
			$('#messageBG').css({border:"1px solid #ccc"});
			$('#retour_message').hide();
		}
		
		// Envoie :
		if (error==0) {
			$('#send').val("Envoie en cours ...");
			$('#chargement').fadeIn(700);
			$(content).fadeOut(1000, function() { 
				ajax('post', 'pages/forum_ajax.php?act='+act, 'id='+_id+'&titre='+_titre+'&message='+_mess, retour);									  
			 } );
			
			
		}
	
}

function retour_nouveau_message(r) {
	var r = unescape(r).split('|:|');

	if (r[0]!="ok") alert('Erreur : \n'+r);
	else {
		naviguer_forum ('categorie', r[1], 1, "Votre message a été ajouté avec succés");
	}
}

function retour_nouvelle_reponse(r) {
	var r = unescape(r).split('|:|');

	if (r[0]!="ok") alert('Erreur : \n'+r);
	else {
		naviguer_forum ('message', r[1], 1, "Votre message a été ajouté avec succés");
	}
}

function verif_editer_message(page) {
	
	
	_mess=escape($('#messageBG').val());
	_id=escape($('#id_mess').val()); 
	
	if (page=="lite") 	_titre='';
	else	 			_titre=escape($('#titre').val()); 
						
	
		  
	error=0;
	
		// Vérification du titre
		if (page!="lite") {   
		if (_titre.length<=5) {
			$('#titre').css('border',"1px dotted #FF3333");
			$('retour_titre').html("<img src='images/boutons/button_cancel.png' /> Le titre doit faire 5 caractères au minimum.");
			$('#retour_titre').BlindDown(500, function() { 
				$('#retour_titre').Shake(1);							   
			}); 												  
			error=1;
		}
		else
		{
			$('#titre').css({border:"1px solid #ccc"});
			$('#retour_titre').hide();
			
		}
		}
			
		// Vérification du message
		if (_mess.length<10) {
			$('#messageBG').css("border","1px dotted #FF3333");
			$('#retour_message').html("<img src='images/boutons/button_cancel.png' /> Votre message est trop court pour être posté.");
			$('#retour_message').BlindDown(500, function() { 
				$('#retour_message').Shake(1);							   
			}); 												  
			error=1;
		}
		else
		{
			$('#messageBG').css({border:"1px solid #ccc"});
			$('#retour_message').hide();
		}
		
		// Envoie :
		if (error==0) {
			$('#send').val("Envoie en cours ...");
			$('#chargement').fadeIn(700);
			$(content).fadeOut(1000, function() { 
				ajax('post', 'pages/forum_ajax.php?act=editer_message', 'id='+_id+'&titre='+_titre+'&message='+_mess, 'retour_editer_message');									  
			 } );
			
			
		}
	
}
function retour_editer_message(r) {
	var r = unescape(r).split('|:|');

	if (r[0]!="ok") alert('Erreur : \n'+r);
	else {
		naviguer_forum ('categorie', r[1], 1, "Votre message a été édité avec succés");
	}
}


function historique ()
{

	this._hash = ""; 
	this._to = 400; 
	this._en = '';
}

/**
  * Rajout : met à jour le Hash courrant
  */
historique.prototype.majHashCourant = function(h) {
	 this._hash=h;
 }

  
/**
 * go to the specified page - override this function to handle specific actions
 * @param h		hash (#)
 */
historique.prototype.go = function (h)
{
	//  Cas de la page d'accueil :
	if (h=="accueil") {
		naviguer_forum('accueil',0,0);
		return;
	} else if (h=="invite") {
		naviguer_forum('invite',0,0);
		return;
	}
	
	//  les autres cas, syntaxe : #id-page/action-description
	var a = h.split('/');
	var b = a[0].split('-');
	var c = a[1].split('-');
	
	if (!a.length) return;
	
		id=b[0];
		numPage=b[1]; 
		page=c[0].toLowerCase();
			
		switch (page) {
			case "categorie":
				naviguer_forum('categorie', id, numPage);
			break;
			case "message":
				naviguer_forum('message', id, numPage);
			break;
			case "nouveau_sujet":
				naviguer_forum('nouveau', id, 0);
			break;
			case "repondre":
				naviguer_forum('repondre', id, 0);
			break;
			case "editer_message":
				naviguer_forum('editer', id, 0);
			break;
		}
		
	return;
}

/**
 * history initialization
 * @param name		hame of history object
 */
historique.prototype.init = function (name)
{
	this._en = name;

	this.handleHist ();
	window.setInterval(this._en + ".handleHist()", this._to);

	return true;
}

/**
 * handle history (ontimer function)
 */
historique.prototype.handleHist =  function ()
{
	if ( window.location.hash != this._hash )
	{		
		this._hash = window.location.hash;
		var h = this._hash.substr(1);			
		if (h.length) this.go (h);
	}
	return true;
}

/**
 * record history
 * @param h	hash
 */
historique.prototype.makeHist = function (h)
{
	if (h.charAt(0) != '#') h = '#' + h;
	
	if (window.location.hash == h) return;

		window.location.hash = h;
		this._hash = window.location.hash;


	return true;
}
