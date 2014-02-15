$(document).ready(function(){ 

	// Afficher le bloc de connexion
	$(".onglet a").click(function() {
								  
		if ($('.connexion').css('display')=="none")
			$(".connexion").toggle("blind", { direction: "vertical", easing:"easeOutExpo"}, 500);
		else
			$(".connexion").toggle("blind", { direction: "vertical", easing:"easeOutExpo"}, 500);
			
		return false; // Annule l'action normal du lien
	});
	
	$("a.lien_contact").click(function() {
		var type=$(this).attr('rel');
		
		var mess="";
		switch(type) {
			case "support" : mess="Contacter le support technique"; break;
			case "commercial" : mess="Contacter le service commercial"; break;
			case "revendeur" : mess="Contacter l'espace revendeur"; break;
			case "recrutement" : mess="Proposer sa candidature spontannée"; break;
		}
		
		$("#type_contact").text(mess);
		
		$("#choix_contact").slideUp();
		$("#form_contact").slideDown();
		
	});
	
	 $(".infobulle").tooltip({
		 track: true,
		 delay: 0,
		 showURL: false,
		 showBody: "|",
		 fade:250, 
		 top:-60,
		 left:-100
	 });

	 $(".infobulle2").tooltip({
		 track: true,
		 delay: 0,
		 showURL: false,
		 showBody: "|",
		 fade:250
	 });
	 
	$(".menu .contenu").accordion({
	   header: "h4",
	   event:"mouseover",
	   clearStyle: true,
	   autoHeight: false,
	   alwaysOpen: false,
	   active: "false"
	});
	
	$("#page a[@rel='blank']").click( function(e) { window.open(this.href); return false; });
	

	$("a.refresh_captcha").click( function(){ 
		var i=Math.round(Math.random(0)*1000)+1;
		$("#img_captcha").attr('src', 'classes/img_captcha.php?i='+i);
		return false;
	});
	
	
	$('.inner').innerfade({
		speed: 1000,
		timeout: 7000,
		type: 'sequence',
		containerheight: "220px"
	});
	
	$('a[@rel*=lightbox]').lightBox();

});




function procedure_contact() {
	//afficher_loader();
	
	$("input.submitC").val("Patientez...");
	
	var email=escape($("#contact_email").val());
	var sujet=escape($("#contact_sujet").val());
	var message=escape($("#contact_message").val());
	var captcha=escape($("#contact_captcha").val());

	$.post("ajax.php?contact", "contact_email="+email+"&contact_sujet="+sujet+"&contact_message="+message+"&contact_captcha="+captcha,  
		function (r) {
			if (r=="erreur_captcha") 	{ 
				alert("Une erreur est survenue \nLe code captcha que vous avez entré est incorrect"); 
				$("input.submitC").val("Envoyer"); 
			}
			else if (r=="erreur_form") 	{
				alert("Une erreur est survenue \nVous devez remplir tous les champs"); 
				$("input.submitC").val("Envoyer"); 
			}
			else						{
				$("#contact_global").fadeTo(1000, 0.01, function() { 
					$("#contact_global").load("ajax.php?afficher_template&tpl=_general/contact_confirmation");
					$("#contact_global").fadeTo(500,1);	
				});
				
			}
			
			//cacher_loader();
		}
	);
}




function procedure_connexion() {
  //afficher_loader();
  $.ajax({
	  type: "GET",
	  url: "ajax.php?my-connexion&pseudo="+escape($("#con1_pseudo").val())+"&pass="+escape($("#con1_pass").val()),
	  dataType: "htm",
	  success: function(r){
		 	if (r=="bad") {
				alert("Echec dans votre tentative de connexion\nLe login et le mot de passe que vous avez entrez ne nous a pas permis de vous identifier.\n\nMerci de v&eacute;rifier les informations saisies.");
			}
			else
			{
				$(".connexion").toggle("blind", { direction: "vertical", easing:"easeOutExpo"}, 500, function() {
					$(".connexion .c").html(unescape(r));												
					$(".connexion").toggle("blind", { direction: "vertical", easing:"easeOutExpo"}, 500);
					//cacher_loader();
				});
			}
			
		}
	});	
}