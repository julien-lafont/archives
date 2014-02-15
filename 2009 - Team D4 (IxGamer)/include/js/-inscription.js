		// Fonction générique appellée si 'elem' est bon.
		function good(elem)
		{
			e=$(elem);
			$(e).style.border="1px solid #88FB3B";	
		}

		// Fonction générique appellée si 'elem' est incorrect.
		function bad(elem,mess) {
			e=$(elem);	
			e.style.border="1px solid #FF7FB4";
		}

//:: Verification Pseudo :://
function verifPseudo() 
{
	pseudo=$F('pseudo');
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
	pseudo=$F('pseudo');
	if (unescape(r)=="login_ok") {
		good('pseudo');
	} else {
		bad('pseudo','Ce Pseudo est indisponible');
	} 
}

function verifEmail()
{
   email=$F('email');
   var arobase = email.indexOf("@")
   var point = email.lastIndexOf(".")
   if ((arobase < 3)||(point + 2 > email.length) ||(point < arobase+3)) {
	   bad('email');
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
	if ($F('pass1').length==0 ) {
		bad('pass1',"Champs requis");
	} else if ($F('pass1').length<=3 || $F('pass1').length>=19) {
		bad('pass1',"Le Mdp doit faire entre 4 et 20 caractères");
	} else {
		good('pass1');
	}
}

function verifPass2() 
{
	if ($F('pass2').length==0 ) {
		bad('pass2',"Champs requis");
	} else if ($F('pass2').length<=3 || $F('pass2').length>=19) {
		bad('pass2',"Le Mdp doit faire entre 4 et 20 caractères");
	} else {
		if ($F('pass2')==$F('pass1')) { good('pass1'); good('pass2'); }
		else { bad('pass1',"Les deux mots de passe sont différents"); bad('pass2',""); }
	}
}


function verifTotal() 
{	
	
	verifPseudo('noAjax');		verifEmail('noAjax');		verifPass1();		verifPass2();	
	
	var coloneVerif=['pseudo', 'email', 'pass1', 'pass2']; 
	var error=0
	
	for (var i=0; i<=3; i++) {
		// On vérifie la présence du good sur toutes les lignes 
		if ($(coloneVerif[i]).style.borderLeft!='1px solid rgb(136, 251, 59)' && $(coloneVerif[i]).style.borderLeft!='#88fb3b 1px solid') { 
			error=1;
		}
	}
	
	if (error==1) {
			
			$('error').className="error";
			$('error').innerHTML="Le formulaire n'est pas correctement rempli.<br /> &nbsp;";
			Nifty("div#error","smooth small fixed-height");
			new Effect.Appear('error', { duration:1 } );
	
		return false;
		
	}
	else { return true; }
	
}

function verifSite(id) 
{
	if ($F(id).length!=0)
	{
		if($F(id).search(/^([http]+[/:/]+[\///])+(.+)?[/\./]+[a-z]{2,4}$/) == -1)
		{
			if($F(id).search(/^([www])+(.+)?[/\./]+[a-z]{2,4}$/) == -1) {
				$(id).style.border="1px solid #FF7FB4";
			} else {
				$(id).value="http://"+$F(id);
				$(id).style.border="1px solid #CCC";
			}
		} else {
			$(id).style.border="1px solid #CCC";	
		}
	} else {
		$(id).style.border="1px solid #CCC";
	}
	
}

// -- Modification du mot de passe -- //
function affWindowsPass()
{
	if (typeof win1 != "undefined") win1.destroy();
	win1 = new Window('showPass', {className: "alphacube", title: "Changer mdp", url: _URL+"pages/_membre/mon-compte_ajax.php?act=affPass", width:300, height:145, maximizable:true, minimizable:true, resizable: true, showEffectOptions: {duration:1}});
	win1.showCenter();
}
function modifPass()
{
	_pass=escape($F("newMdp"));
	if (_pass.length<4) { alert('Mot de passe trop court !'); return false; }
	
	Element.hide('submit');
	Element.show('wait');
	
	ajax('get','pages/_membre/mon-compte_ajax.php','act=modifPass&newPass='+_pass,'modifPass2');
}
function modifPass2(r)
{
	if (unescape(r)=="ok") {
		parent.Windows.close("showPass");
		parent.$("lienPass").innerHTML="Mot de passe modifié avec succés !";
		parent.$("lienPass").className="ok";

	} else {
		parent.Windows.close("showPass");
		win9 = new parent.Window('erreurShowPass', {className: "alphacube", title: "", width:200, height:80, maximizable:false, minimizable:false, resizable: true, showEffectOptions: {duration:1}})
		win9.getContent().innerHTML="<div style='margin:5px; font-family:verdana; font-size:12px; color:#333; text-align:center'><h1 style='color:#00A8FF; font-size:14px'>Erreur !</h1> Votre mot de passe n'a pas pu être modifié !</div>";
		win9.showCenter();
	}
}

// -- Uploader un avatar -- //
function affWindowsAvatar()
{
	if (typeof win2 != "undefined") win2.destroy();
	win2 = new Window('showAvatar', {className: "alphacube", title: "Mon avatar", url: _URL+"pages/_membre/mon-compte_ajax.php?act=affAvatar", width:410, height:255, maximizable:true, minimizable:true, resizable: true, showEffectOptions: {duration:1}});
	win2.showCenter();
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
