		// Fonction générique appellée si 'elem' est bon.
		function good(elem)
		{
			$('#'+elem).removeClass('return bad');
			$('#statut_'+elem).css('display', 'none');
			return 1;
		}

		// Fonction générique appellée si 'elem' est incorrect.
		function bad(elem) {
			$('#'+elem).addClass('return bad');
			if (arguments.length==2) {
				$('#statut_'+elem).html(arguments[1]);
				$('#statut_'+elem).css('display', 'inline');
			}
			return 0;
		}

// --------------------------------------------------------------------------------------------------- //
// ----------------------------------- VERIFICATION COMMENTAIRES ------------------------------------- //
// --------------------------------------------------------------------------------------------------- //

//:: Verification Pseudo pour le postage de commentaire :://
function verif_pseudo(id) 
{
	var pseudo=$('#'+id).val();
	 if (pseudo!='') 
	 {
		if (pseudo.length >= 3 && pseudo.length <= 20) {
			
			// Ajax ou non ? Active la vérification ajax lorsqu'un deuxième paramètre est détecté.
			if (arguments.length==1) {
				
				$.ajax({
				  type: "GET",
				  url: "pages/ajax_standalone/verifs.php?pseudo="+escape(pseudo),
				  dataType: "htm",
				  success: function(r){
						
						if (unescape(r)=="login_ok") {
							$('#pass_hide').hide(300);
							return good(id);
						} else {
							
							$('#statut_'+id).html("Pseudo réservé. Entrez votre mdp");
							$('#statut_'+id).css('display', 'inline');
							$('#pass_hide').show(500);
							$('#pass_hide').focus();
						} 
				} })	
				
				
			} else {
				return good(id);
			}
			
		} else {
			return bad(id,'Entre 3 et 20 caractères');
		}
	} else {
		return bad(id,'Champs requis');
	}
	
}

//:: Verification Pseudo pour l'inscription :://
function verif_pseudo2(id) 
{

	var pseudo=$('#'+id).val();
	 if (pseudo!='') 
	 {
		if (pseudo.length >= 4 && pseudo.length <= 20) {
			
			// Ajax ou non ? Active la vérification ajax lorsqu'un deuxième paramètre est détecté.
			if (arguments.length==1) {
				
				$.ajax({
				  type: "GET",
				  url: "pages/ajax_standalone/verifs.php?pseudo="+escape(pseudo),
				  dataType: "htm",
				  success: function(r){
						
						if (unescape(r)=="login_ok") {
							return good(id);
						} else {
							return bad("pseudo", "Pseudo réservé");
						} 
				} })	
				
				
			} else {
				return good(id);
			}
			
		} else {
			return bad(id,'Entre 4 et 20 caractères');
		}
	} else {
		return bad(id,'Champs requis');
	}
	
}

function verif_pass1(id) 
{
	var pass1=$("#"+id).val();
	if (pass1.length==0 ) {
		return bad(id,"Champs requis");
	} else if (pass1.length<=3 || pass1.length>=19) {
		return bad(id,"Entre 4 et 20 caractères");
	} else {
		return good(id);
	}
}

function verif_pass2(id1, id2) 
{
	var pass1=$("#"+id1).val();
	var pass2=$("#"+id2).val();
	if (pass2.length==0 ) {
		return bad(id2,"Champs requis");
	} else if (pass2.length<=3 || pass2.length>=19) {
		return bad(id2,"Entre 4 et 20 caractères");
	} else {
		if (pass2==pass1) { good(id2); return good(id1); }
		else { bad(id1,""); return bad(id2,"Mots de passe différents"); }
	}
}



function verif_email(id)
{
   var email=$('#'+id).val();
   var arobase = email.indexOf("@")
   var point = email.lastIndexOf(".")
   if ((arobase < 3)||(point + 2 > email.length) ||(point < arobase+3)) {
	   return bad(id, 'Adresse email invalide');
   } else {
		return good(id);
   }
}

function verif_site(id) 
{
	var valId=$('#'+id).val();
	if (valId.length!=0) {
		if(valId.search(/^([http]+[/:/]+[\///])+(.+)?[/\./]+[a-z]{2,4}$/) == -1)
			{
				if(valId.search(/^([www])+(.+)?[/\./]+[a-z]{2,4}$/) != -1) {
					$('#'+id).val("http://"+valId);
				}
			} 
	}
}

function verif_message(id) 
{
	var message=$('#'+id).val();
	if (message.length==0) {
		return bad(id);
	} else {
		return good(id);
	}
}


function verif_pass_com(id_login, id_pass) {
	
	var pass=$("#"+id_pass).val();
	var login=$("#"+id_login).val();
	
	if (pass.length==0 ) {
		return bad(id_pass);
	} else if (pass.length<=3 || pass.length>=19) {
		return bad(id_pass,"Entre 4 et 20 caractères");
	}
	

	$.ajax({
	  type: "GET",
	  url: "pages/ajax_standalone/verifs.php?connexion_login="+escape(login)+"&connexion_pass="+escape(pass),
	  dataType: "htm",
	  success: function(r){
			
			if (unescape(r)=="pass_bad") {
				$("#statut_pass").html("Mot de passe incorrect !");
			}
			else
			{
				$("#info_user").hide(500, function() {
					$("#info_user").html(unescape(r));
					$("#info_user").show();
				} );
				
				// Met à jour le bloc connexion
				bloc_connexion();
			}
		

	} })	


}

function verifier_form_com() 
{	

	// Membre connecté
	if ($("#pseudo").val()=="log") {

		if (!verif_message('message')) {
			$("#erreur_com").slideDown("slow");	
		} else { 
			 $.ajax({
  				 type: "POST",
				 url:"ajax.php?poster_com&ajax=1",
				 data:
				{
					message:escape($('#message').val()),
					captcha:escape($('#captcha').val()),
					id_billet:$('#id_billet').val(),
					captcha:escape($('#captcha').val())
					
				}, 
				dataType:"html",
				success:function(r) { verifier_form_com_r(r), "html" }
				
			});
			
		}

	}
	
	// Membre non connecté
	else {
		
		if (!verif_pseudo('pseudo', false) || !verif_email('email') || !verif_message('message')) {
			$("#erreur_com").slideDown("slow");	
			
		} else { 
			$.post("ajax.php?poster_com&ajax=1", 
				{
					pseudo: escape($('#pseudo').val()), 
					email: escape($('#email').val()),
					site:escape($('#site').val()),
					message:escape($('#message').val()),
					captcha:escape($('#captcha').val()),
					id_billet:$('#id_billet').val(),
					captcha:escape($('#captcha').val())
				}, 
				function(r) { verifier_form_com_r(r), "text" }
				);
			
		}
	}
	
}
		function verifier_form_com_r(r) { 
					verif=unescape(r).split("|:|");
					if (verif[0]=="post_ok") {
						$("#poster_commentaire").slideUp("slow", function() {
							$("#commentaires .in").append(verif[1]);
							$(".com:last").show("slow");
						});
					}
					else if (verif[0]="post_bad") {
						if (verif[1]=="inconnu") alert("Erreur inconnue #1 !");
						else 					 {
							$("#erreur_detail").html("<br />"+verif[1]);
							$("#erreur_com").slideDown("slow");
							$.scrollTo( '#poster_commentaire', {speed:500, easing:'easeInQuad', axis:'y' });	
						}
					}
					else {
						alert("Erreur inconnue #2 !");
					}

			} 








function verifier_form_inscription() 
{	


		
	if (!verif_pseudo('pseudo', false) || !verif_email('email') || !verif_pass2("pass2", "pass1")) {
		$("#cadre_erreur").html("Merci de remplir correctement le formulaire avant de continuer.").slideDown("slow");	
		
	} else { 
			$("#erreur_com").slideUp();	
			$('#submit_inscription').attr("disabled", "disabled");
			
			$.post("ajax.php?inscription&act=valider", 
			{
				pseudo: escape($('#pseudo').val()), 
				email: escape($('#email').val()),
				site:escape($('#site').val()),
				pass1:escape($('#pass1').val()),
				pass2:escape($('#pass2').val())
			}, 
			function(r) { verifier_form_inscription_r(r) }
			);

	}
	
}
		function verifier_form_inscription_r(r) { 
					verif=unescape(r).split("|:|");
					if (verif[0]=="erreur") {
						$("#cadre_erreur").html(verif[1]).slideDown("slow");	
						$('#submit_inscription').removeAttr("disabled");
					}

					else if (verif[0]=="Confirmation de votre inscription") {
						naviguer('inscription','confirmation', 0, null, "init_inscription()");
					}
					else {
						$("#cadre_erreur").html(verif[1]).slideDown("slow");	
						$('#submit_inscription').removeAttr("disabled");
						//alert("Erreur inconnue !\n"+unescape(r));
					}

			} 



