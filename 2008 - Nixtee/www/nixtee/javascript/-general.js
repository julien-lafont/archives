
var load_en_cours=false;
var content='#page';

$(document).ready(function(){
  attribuer_regles();
});

function attribuer_regles() {
	
	// -------- antibug IE7 + Vista : réactivation des return false -----------
	//$("#page a[onclick*='return false']").click( function() { return false; } );
	$("#page a[@rel='blank']").click( function(e) { window.open(this.href); return false; });
	

	$("a.refresh_captcha").click( function(){ 
		var i=Math.round(Math.random(0)*1000)+1;
		$("#img_captcha").attr('src', 'classes/img_captcha.php?i='+i);
		return false;
	});
	
	$("a.ouvrir_apercu").click(function() {
		var id=$(this).attr('rel');
		if ($("#apercu_"+id).css("display")=="none") {
			$("#apercu_"+id).slideDown(1000, 'easeOutBounce');
			$(this).text("Fermer l'apercu");	
			
		} else {
			$("#apercu_"+id).slideUp(1000, 'easeOutBounce');
			$(this).text("Apercu des questions");
		}
		return false;
	});
	
	$("img.ajouter_buddy").click(function() {
		var gpe=$(this).attr('alt');
		var nom=$("#aj_nom_"+gpe).val();
		var email=$("#aj_email_"+gpe).val();

		  $.post("ajax.php?my-buddylist&act=ajouter",
		  	{ groupe:escape(gpe), nom:escape(nom), email:escape(email) },
		    function(r) {
		       switch(r) {
				case "doublon": alert("Erreur \nL'adresse email que vous tentez d'ajouter est déjà présente dans cette liste."); break;
				case "email_invalide": alert("Erreur\nL'adresse email que vous tentez d'ajouter est invalide."); break;
				case "1": $("#liste_"+gpe).append("<li><abbr title='"+email+"'>"+nom+"</abbr></li>"); break;
				default: alert("Une erreur inconnue est survenue.\n Si le problème persiste, merci d'en prévenir le staff"); break;
			   }
		    }
		  );	
	});
	
	$("img.suppr_buddy").click(function() {
		var email=$(this).parent().children("abbr").attr("title");
		var gpe=$(this).attr('alt');
		var thiss=this;
		
		  $.post("ajax.php?my-buddylist&act=supprimer",
		  	{ groupe:escape(gpe), email:escape(email) },
		    function(r) {
		       switch(r) {
				case "1": $(thiss).parent().remove(); break;
				default: alert("Une erreur inconnue est survenue.\n Si le problème persiste, merci d'en prévenir le staff"); break;
			   }
		    }
		  );			
	});
	
	

}



function isset(varname)  {
  if(typeof( window[ varname ] ) != "undefined") return true;
  else return false;
}

// Supprime les espaces inutiles en début et fin de la chaîne passée en paramètre.
function trim(aString) {
  return aString.replace(regExpBeginning, "").replace(regExpEnd, "");
}


function afficher_message(titre, message) {
		
	var fen;
	var fen_id="erreur_"+Math.round(Math.random(0)*1000)+1;
	
	fen='<div class="jqmAlert" id="'+fen_id+'"><div id="ex3b" class="jqmAlertWindow"><div class="jqmAlertTitle clearfix">';
	fen+='<h1>'+titre+'</h1><a href="#" class="jqmClose"><em>Close</em></a></div>';
	fen+='<div class="jqmAlertContent">'+message+'</div></div></div>';
	$("body").append(fen);
	
	$('#'+fen_id).jqm({overlay: 0, modal: false, trigger: false}).jqDrag('.jqmAlertTitle').jqmShow();
	return fen_id;
	
}

// ------------------------------------------------------------------------------------------------------------------------

function ajouter_points(id) {
	
  $.ajax({
	  type: "GET",
	  url: "pages/ajax_standalone/ajouter_point.php?id_billet="+escape(id),
	  dataType: "htm",
	  success: function(r){
			if (r=="erreur_membre") {
				 afficher_message('Vote non pris en compte', 'Vous devez être inscrit et connecté au blog pour pouvoir attribuer des points aux articles.');
			}
			else if (r=="erreur_vote") {
				 afficher_message('Vote non pris en compte', 'Vous avez déjà voté pour ce billet.');
			} else {
				var id = unescape(r).split("|:|")[0];
				var pts = unescape(r).split("|:|")[1];
				$("#span_pts_"+id).html(pts);
			}
		}
	})
}

function calendrier(new_mois, new_annee) {
  
  afficher_loader();
  $("#bloc_calendrier").fadeTo("fast", 0.01, function() {
													  
	 $.ajax({
	  type: "GET",
	  url: "ajax.php?maj_calendrier&mois="+escape(new_mois)+"&annee="+escape(new_annee),
	  dataType: "htm",
	  success: function(r){
				
		$("#bloc_calendrier").html(unescape(r));
		attribuer_regles();
		$("#bloc_calendrier").fadeTo("slow", 1);
		cacher_loader();
		}
		
	  })
  });
}

function bloc_connexion_top() {
  //afficher_loader();
  $.ajax({
	  type: "GET",
	  url: "ajax.php?my-connexion&pseudo="+escape($("#con1_login").val())+"&pass="+escape($("#con1_pass").val()),
	  dataType: "htm",
	  success: function(r){
		 	if (r=="bad") {
				afficher_message("Echec dans votre tentative de connexion", "Le login et le mot de passe que vous avez entrez ne nous a pas permis de vous identifier.<br /><br />Merci de v&eacute;rifier les informations saisies.");
			}
			else
			{
				$("#connexion").fadeTo("fast", 0.01, function() {
					$("#connexion").html(unescape(r));												
					$("#connexion").fadeTo("slow", 1);
					//cacher_loader();
				});
			}
			
		}
	})	
}

function messagerie_envoyer() {
	
	afficher_loader();
	
	var id_dest=escape($("#dest_id").val());
	var sujet=escape($("#sujet").val());
	var message=escape($("#mess").val());
	
	if (sujet.length==0 || message.length==0 || id_dest.length==0) {
		afficher_message("Erreur durant l'envoie du message", "Le formulaire n'a pas été remplis correctement.");
	} else {
	  $.ajax({
		  type: "POST",
		  url: "ajax.php?my-messagerie&act=envoyer",
		  data: "id_dest="+id_dest+"&sujet="+sujet+"&message="+message,
		  dataType: "htm",
		  success: function(r){
				naviguer('messagerie', "accueil",0, null, "messagerie_retour('"+escape(r)+"')");
			}
		})	
	}
}

function messagerie_retour(r) {
	if (unescape(r)=="ok") {
		afficher_message("Message envoyé !", "Votre message a été envoyé avec succés.");
	} else {
		afficher_message("Erreur détectée !", "Une erreur est survenue durant l'envoie de votre message.<br />Si le problème persiste, merci de contacter un administrateur.");
	}
	
}

function init_inscription() {
	$(".infos_inscript").corner("round tl 25px");  
	$("#cadre_erreur").corner("round 15px"); 
	
	// Cacher les éléments d'infos sauf le premier
	$("div.infos_inscript:gt(0)").each(function () {
		$(this).css('display', 'none');
	});
}


function inscription_afficher(elem) {
	// Cacher les éléments  affichés
	$("div.infos_inscript:visible").each(function () {
		if ($(this).attr("id")!=$(elem).parent().prev().attr("id")) $(this).slideUp();
	});
	
	// On affiche notre élément
	var infos = $(elem).parent().prev().slideDown("normal", function() { $(elem).focus() });
	
}

function init_fiche() {
	
		$("#contenu_infos ul:not(:first)").hide();
		$("#contenu_infos h3").click(function(){
			var t=this;
			$("#contenu_infos ul:visible").slideUp("slow", function() { 
				$(t).next().slideDown("slow"); 
			});
			$('.fiche_curseur').hide();	
		});
}

function message_valider_compte() {
	$(document).ready(function(){ 
		afficher_message("Compte activé avec succés !", "Votre compte a été activé.<br /><br />Vous pouvez dés à présent vous connectez au blog et profiter de nombreuses fonctionnalités supplémentaires.");
	});
}

function afficher_changer_pass() {
	$.get("ajax.php?my-popup_moncompte&act=pass1", function(data){
	  afficher_message("Changer mon mot de passe", data);
	});
}
function afficher_changer_avatar() {
	$.get("ajax.php?my-popup_moncompte&act=avatar1", function(data){
	  afficher_message("Modifier mon avatar", data);
	});
}	

function procedure_pass_perdu() {
	afficher_loader();
	
	var email=$("#email_pass_perdu").val();
	$.post("ajax.php?mot_passe_perdu&act=email", "email_pass_perdu="+escape(email), 
		function (r) {
			if (r=="ok") 
				naviguer("mot_passe_perdu", "confirmation", 0);
			else 
				naviguer("mot_passe_perdu", "erreur", 0);
			cacher_loader();
		});
}

function procedure_contact() {
	afficher_loader();
	
	var email=escape($("#contact_email").val());
	var sujet=escape($("#contact_sujet").val());
	var message=escape($("#contact_message").val());
	var captcha=escape($("#contact_captcha").val());

	$.post("ajax.php?contact", "contact_email="+email+"&contact_sujet="+sujet+"&contact_message="+message+"&contact_captcha="+captcha,  
		function (r) {
			if (r=="erreur_captcha") 	afficher_message("Une erreur est survenue","Le code captcha que vous avez entré est incorrect");
			else if (r=="erreur_form") 	afficher_message("Une erreur est survenue", "Vous devez remplir tous les champs");
			else						naviguer("contact", "confirmation", 0);
			
			cacher_loader();
		}
	);
}