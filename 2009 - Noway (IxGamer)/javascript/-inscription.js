var no_efface=0;
var afficher_erreur=1;

		// Fonction générique appellée si 'elem' est bon.
		function good(elem)
		{
			$('#'+elem).css('border',"1px solid #88FB3B");
		}

		// Fonction générique appellée si 'elem' est incorrect.
		function bad(elem,mess) {
			$('#'+elem).css('border',"1px solid #FF7FB4");

			if (afficher_erreur==1) {
				$('#texte_info').html("<strong>Erreur :</strong><br /><div id='innnn' style='color:#F00'><br />"+mess+"</div>");
				$('#innnn').Pulsate(500,2);
			}

		}

//:: Verification Pseudo :://
function verifPseudo() 
{
	pseudo=$('#pseudo').val();
	 if (pseudo!='') 
	 {
		if (pseudo.length >= 3 && pseudo.length <= 20) {
			
			// Ajax ou non ?
			if (arguments.length==0) {
				ajax('get','pages/ajax/verif_inscription.php','pseudo='+escape(pseudo),'verifPseudoAjax');
			} else {
				good('pseudo');
			}
			
		} else {
			bad('pseudo','Le pseudo doit faire entre 3 et 20 caractères');
		}
	} else {
		bad('pseudo','Champs requis');
	}
	
}

function verifPseudoAjax(r) 
{
	pseudo=$('#pseudo').val();
	if (unescape(r)=="login_ok") {
		good('pseudo');
	} else {
		bad('pseudo','Ce pseudo est indisponible');
	} 
}

function verifEmail()
{
   email=$('#email').val();
   var arobase = email.indexOf("@")
   var point = email.lastIndexOf(".")
   if ((arobase < 3)||(point + 2 > email.length) ||(point < arobase+3)) {
	   bad('email', 'Adresse email invalide');
   } else {
	   	// ajax ou non ?
		if (arguments.length==0) {
			ajax('get','pages/ajax/verif_inscription.php','email='+escape(email),'verifEmailAjax');
		} else {
			good('email');
		}
   }
}
	
function verifEmailAjax(r)
{
	if (unescape(r)=="email_ok") good('email');
	else bad('email',"Cette adresse email est déjà enregistrée");	
}

function verifPass1() 
{
	if ($('#pass1').val().length==0 ) {
		bad('pass1',"Champs requis");
	} else if ($('#pass1').val().length<=3 || $('#pass1').val().length>=19) {
		bad('pass1',"Le Mdp doit faire entre 4 et 20 caractères");
	} else {
		good('pass1');
	}
}

function verifPass2() 
{
	if ($('#pass2').val().length==0 ) {
		bad('pass2',"Champs requis");
	} else if ($('#pass2').val().length<=3 || $('#pass2').val().length>=19) {
		bad('pass2',"Le Mdp doit faire entre 4 et 20 caractères");
	} else {
		if ($('#pass2').val()==$('#pass1').val()) { good('pass1'); good('pass2'); }
		else { bad('pass1',""); bad('pass2',"Les deux mots de passe sont différents"); }
	}
}


function verifTotal() 
{	
	
	afficher_erreur=0;
	verifPseudo('noAjax');		verifEmail('noAjax');		verifPass1();		verifPass2();	
	afficher_erreur=1;
	
	var coloneVerif=['pseudo', 'email', 'pass1', 'pass2']; 
	var error=0
	
	for (var i=0; i<=3; i++) {
		// On vérifie la présence du good sur toutes les lignes 
		if ($('#'+coloneVerif[i]).css('borderLeft')!='1px solid rgb(136, 251, 59)' && $('#'+coloneVerif[i]).css('borderLeft')!='#88fb3b 1px solid') { 
			error=1;
		}
	}
	
	if (error==1) {
			
			$('#texte_info').html("<strong>Erreur :</strong><br /><div id='innnn' style='color:#F00'><br />Le formulaire n'est pas correctement remplis !</div>");
			$('#innnn').Pulsate(500,2);
	
		return false;
		
	}
	else { return true; }
	
}

function verifSite(id) 
{
	valId=$('#'+id).val();
	if (valId.length!=0)
	{
		if(valId.search(/^([http]+[/:/]+[\///])+(.+)?[/\./]+[a-z]{2,4}$/) == -1)
		{
			if(valId.search(/^([www])+(.+)?[/\./]+[a-z]{2,4}$/) == -1) {
				valId.css('border',"1px solid #FF7FB4");
			} else {
				valId.val("http://"+$valId);
				valId.css('border', "1px solid #CCC");
			}
		} else {
			valId.css('border', "1px solid #CCC");
		}
	} else {
		valId.css('border', "1px solid #CCC");
	}
	
}

// -- Modification du mot de passe -- //
function affWindowsPass()
{
	$("#lienPass").html('Chargement en cours');
	$("#window").css({height:'215px'});
	$('#windowContent').css({height:'170px'});
	$("#windowContent").load(_URL+"pages/_membre/mon-compte_ajax.php?act=affPass", null, function() { ouvrirFenetreTransfert('lienPass'); } );
}
function modifPass()
{
	_pass=escape($("#newMdp").val());
	if (_pass.length<4) { alert('Mot de passe trop court !'); return false; }
	
	$('#submit').hide();
	$('#wait').show();
	
	ajax('get','pages/_membre/mon-compte_ajax.php','act=modifPass&newPass='+_pass,'modifPass2');
}
function modifPass2(r)
{
	if (unescape(r)=="ok") {
		fermerFenetre();
		$("#lienPass").html("Mot de passe modifié avec succés !");
		$("#lienPass").addClass("ok");

	} else {
		fermerFenetre();
		$("#lienPass").html("!! Erreur !!");
		alert('Erreur\nVotre mot de passe n\'a pas pu être modifié');
	}
}

// -- Uploader un avatar -- //
function affWindowsAvatar()
{
	//$("#lienAvatar").html('Chargement en cours');
	$("#window").css({height:'300px', width:'460px',top:'1250px'});
		
	$('#windowContent').css({height:'245px', width:'420px'});
	$("#windowContent").load(_URL+"pages/_membre/mon-compte_ajax.php?act=affAvatar", null, function() { ouvrirFenetreTransfert('lienAvatar'); } );

}
function champsAvatar()
{
	Element.hide('submit'); Element.show('wait');
	_url=$F('url');
	_file=$('file').value;
	
	if (_url=="" && _file=="") { alert("Vous ne devez spécifier qu'un seul champs !"); Element.show('submit'); Element.hide('wait'); return false; }
	else if (_url!="" && _file!="") { alert("Vous devez remplir un champs !"); Element.show('submit'); Element.hide('wait'); return false; }
	else { return true; }
}

// -- Uploader sa config -- //
function affWindowsConfig()
{
	//$("#lienConfig").html('Chargement en cours');
	$("#window").css({height:'300px', width:'460px',top:'1250px'});
		
	$('#windowContent').css({height:'245px', width:'420px'});
	$("#windowContent").load(_URL+"pages/_membre/mon-compte_ajax.php?act=affConfig", null, function() { ouvrirFenetreTransfert('lienConfig'); } );

}

function testPassword(passwd) {
    var description = new Array;
    description[0] = "<table border=0 cellpadding=0 cellspacing=0><tr><td><table cellpadding=0 cellspacing=2><tr><td height=15 width=30 bgcolor=#ff0000></td><td height=15 width=120 bgcolor=#eee></td></tr></table></td><td class=bold>Faible</td></tr></table>";
    description[1] = "<table border=0 cellpadding=0 cellspacing=0><tr><td><table cellpadding=0 cellspacing=2><tr><td height=15 width=60 bgcolor=#bb0000></td><td height=15 width=90 bgcolor=#eee></td></tr></table></td><td class=bold>Moyenne</td></tr></table>";
    description[2] = "<table border=0 cellpadding=0 cellspacing=0><tr><td><table cellpadding=0 cellspacing=2><tr><td height=15 width=90 bgcolor=#ff9900></td><td height=15 width=60 bgcolor=#eee></td></tr></table></td><td class=bold>Elevée</td></tr></table>";
    description[3] = "<table border=0 cellpadding=0 cellspacing=0><tr><td><table cellpadding=0 cellspacing=2><tr><td height=15 width=150 bgcolor=#00ee00></td></tr></table></td><td class=bold>Inviolable</td></tr></table>";
    description[5] = "<table border=0 cellpadding=0 cellspacing=0><tr><td><table cellpadding=0 cellspacing=2><tr><td height=15 width=150 bgcolor=#eee></td></tr></table></td><td class=bold></td></tr></table>";
    var intScore = 0;
    var strVerdict = 0;
    if (passwd.length == 0 || !passwd.length) {
        intScore = -1;
    } else if (passwd.length > 0 && passwd.length < 5) {
        intScore = intScore + 3;
    } else if (passwd.length > 4 && passwd.length < 8) {
        intScore = intScore + 6;
    } else if (passwd.length > 7 && passwd.length < 12) {
        intScore = intScore + 12;
    } else if (passwd.length > 11) {
        intScore = intScore + 18;
    }
    if (passwd.match(/[a-z]/)) {
        intScore = intScore + 1;
    }
    if (passwd.match(/[A-Z]/)) {
        intScore = intScore + 5;
    }
    if (passwd.match(/\d+/)) {
        intScore = intScore + 5;
    }
    if (passwd.match(/(.*[0-9].*[0-9].*[0-9])/)) {
        intScore = intScore + 5;
    }
    if (passwd.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
        intScore = intScore + 2;
    }
    if (passwd.match(/(\d.*\D)|(\D.*\d)/)) {
        intScore = intScore + 2;
    }
    if (intScore == -1) {
        strVerdict = description[5];
    } else if (intScore > -1 && intScore < 10) {
        strVerdict = description[0];
    } else if (intScore > 9 && intScore < 18) {
        strVerdict = description[1];
    } else if (intScore > 17 && intScore < 25) {
        strVerdict = description[2];
    } else {
        strVerdict = description[3];
    }
    document.getElementById("Words").innerHTML = strVerdict;
}




