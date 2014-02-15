function supprNum(id) {
	ajaxGetA('repertoire.php?suppr&id='+id,'majRep');
}

function majRep(r) {
	Element.remove('tr'+unescape(r));
}

function afficherRep() {
	if (typeof win10 != "undefined") win10.destroy();
	
	_left=(screen.width/2)+85;
	win10 = new Window('rep', {className: "alphacube", title: "Mon répertoire", url: "pages/ajax/repertoire.php?recupRepertoire", top:245, left:_left, width:270, height:250, maximizable:false, minimizable:false, resizable: true, showEffectOptions: {duration:1}})
	win10.show();
}

function majNum(numero) {
	parent.document.getElementById('num').value=numero;
}

function ajouterNum() {
	_num=$F('num');
	if (_num.length!=10) 
	{
		win13 = new Window('error', {className: "alphacube", title: "Nouveau contact", width:205, height:90, maximizable:false, minimizable:false,  resizable: true, showEffectOptions: {duration:1}})
		win13.getContent().innerHTML="<div style='margin:5px; font-family:verdana; font-size:12px; color:#333; text-align:center'><h1 style='color:#00A8FF; font-size:14px'>Erreur !</h1> Vous devez entrer un numéro valide avant de l'enregistrer dans votre répertoire.</div>";
		win13.setDestroyOnClose();
		win13.showCenter();
		return false
	}
		
	
	if (typeof win8 != "undefined") win8.destroy();

	win8 = new Window('addnum', {className: "alphacube", title: "Nouveau contact", url: "pages/ajax/repertoire.php?ajouter&num="+_num, width:300, height:145, maximizable:false, minimizable:false, resizable: true, showEffectOptions: {duration:1}})
	//win8.setDestroyOnClose();
	win8.showCenter();
}

function ajouterNum2() {
	_nom=escape($F("nom"));
	_num=escape($("num").innerHTML);
	if (_nom.length==0) return false;
	
	Element.hide('submit');
	Element.show('wait');
	
	ajaxGetA('repertoire.php?ajouter2&nom='+_nom+'&num='+_num,'ajouterNum3');
}

function ajouterNum3(r) {

	if (unescape(r)=="ok") {
		parent.Windows.close("addnum");
	} else {
		parent.Windows.close("addnum");
		win9 = new parent.Window('erreur89', {className: "alphacube", title: "", width:200, height:80, maximizable:false, minimizable:false, resizable: true, showEffectOptions: {duration:1}})
		win9.getContent().innerHTML="<div style='margin:5px; font-family:verdana; font-size:12px; color:#333; text-align:center'><h1 style='color:#00A8FF; font-size:14px'>Erreur !</h1> Vous avez déjà attribué un nom à ce numéro de portable</div>";
		win9.showCenter();
	}
	
}

function messFraude(nb) {
	win7 = new Window('erreur78', {className: "alphacube", title: "Fraude détectée", width:300, height:200, maximizable:false,  resizable: true, showEffectOptions: {duration:1}})
	win7.getContent().innerHTML= "<div style='padding:10px;'> <b>Fraude "+nb+"/5</b><br><br>Vous devez absolument cliquer sur une pub ( et pas seulement faire semblant ) !<br><br> Votre SMS a quand même été envoyé, mais ne recommancez plus ! <br><br>Merci.</div>";
	win7.showCenter();
}

function sendSms() { 
	num0=$F('num');
	mess0=$F('mess');
	date0=$('date').innerHTML;
	time0=$('timestamp').innerHTML;
	
	if (num0.length!=10 || mess0.length>161) {
		win4 = new Window('erreur32', {className: "alphacube", title: "Erreur !", width:300, height:200, maximizable:false,  resizable: true, showEffectOptions: {duration:1}})
		win4.getContent().innerHTML= "<div style='padding:10px; font-family:verdana; font-size:12px; color:#333;'> <b>Une erreur a été détectée.</b><br><br>Nous vous rapellons que tout les champs doivent être remplis correctement : <br><br><div style='margin-left:10px; font-size:11px'>- Numéro de téléphone Français à 10 chiffres<br>- Message de 160 caractères maximum<br></div></div>";
		win4.showCenter();
	} else {
		Element.hide('envoyer');
		$('wait2').style.display="block";
		ajaxPostA('pages/ajax/send.php','num='+escape(num0)+'&mess='+escape(mess0)+'&date='+escape(date0)+'&time='+escape(time0),'sendSms2');
	}
}

/* Spécial Compte démo */
function sendSmsDemo() {  
	num0=$F('num');
	mess0=$F('mess');
	
	if (num0.length!=10 || mess0.length>161) {
		win4 = new Window('erreur17', {className: "alphacube", title: "Erreur !", width:300, height:200, maximizable:false,  resizable: true, showEffectOptions: {duration:1.5}})
		win4.getContent().innerHTML= "<div style='padding:10px; font-family:verdana; font-size:12px; color:#333;'> <b>Une erreur a été détectée.</b><br><br>Nous vous rapellons que tout les champs doivent être remplis correctement : <br><br><div style='margin-left:10px; font-size:11px'>- Numéro de téléphone Français à 10 chiffres<br>- Message de 160 caractères maximum<br></div></div>";
		win4.showCenter();
	} else {
		Element.hide('envoyer');
		$('wait2').style.display="block";
		ajaxPostA('pages/ajax/send.php','num='+escape(num0)+'&mess='+escape(mess0),'sendSms2');
	}
}

function demoQuotat() {
	win7 = new Window('erreur45', {className: "alphacube", title: "Erreur quotat", width:300, height:200, maximizable:false,  resizable: true, showEffectOptions: {duration:1.5}})
	win7.getContent().innerHTML= "<div style='padding:10px; text-align:center'> <img src='images/error.png' /> <br><br> <b>Le compte 'démo' est limité à 1 sms / jour</b><br><br>Ce quotat a été atteint, mais vous pouvez cependant tester le site sans problèmes .</div>";
	win7.showCenter();
}

/* ---------------FIN DEMO-------------------------- */

function sendSms2(r) {
	if (unescape(r)=="ok") {
		ajaxGetA('pages/ajax/pages.php?p=smsok','showPage');
	} else if (unescape(r)=="fraude") {
		ajaxGetA('pages/ajax/pages.php?p=smsok&fraude=1','showPage');
	} else {
		win5 = new Window('erreur15', {className: "alphacube", title: "Erreur !", width:250, height:150, maximizable:false,  resizable: false, showEffectOptions: {duration:1.5}})
		win5.getContent().innerHTML= "<div style='padding:10px; font-family:verdana; font-size:12px; color:#333; text-align:center'> <b>Une erreur a été détectée.</b><br><br>"+unescape(r)+"</div>";
		win5.showCenter();
		$('envoyer').style.display="block";
		Element.hide('wait2');
	}
}
 
function etape2(num) {
	time=escape($('timestamp').innerHTML);
	if (num==1) window.open("http://sms.yotsumi.info/?partenaire&time="+time);
	if (num==2) window.open("http://sms.yotsumi.info/?partenaires&time="+time);
	if (num==3) window.open("http://www.wixpay.com/?page=yotsumi&time="+time);
	if (num==4) window.open("http://www.philharduvaucluse.info/?page=juju&time="+time);
	ajaxGetA('pages/ajax/pages.php?p=etape3','etape3');
}

function etape3(r) {
	new Effect.Fade('etape2', { duration:1, afterFinish:function() { 
			$('etape2').innerHTML=unescape(r);
			Nifty("div.roundpub", "smooth");
			new Effect.Appear('etape2', { duration:1 });
		}} );
}

function verifNum() {
	num=$F('num');
	if (num.length==10) { $('num').style.borderLeft="3px solid #00cc00"; $('num').style.bgcolor="#FFFFFF"; }
	else { $('num').style.borderLeft="3px solid #FF0000"; }
}	

function login() {
	Element.update('wait','<img src="images/wait2.gif">');
	pseudo=unescape($F('pseudo'));
	pass=unescape($F('pass'));
	ajaxGetA('pages/ajax/connexion.php?login='+pseudo+'&pass='+pass,'login2');
	
}

function login2(r) {
	Element.hide('wait');
	if (unescape(r)=="bad") {
		$('etat').style.display="none";
		$('etat').innerHTML="<b>Identifiants incorrects</b>";
		$('etat').style.backgroundColor="#ec5994";
		$('etat').style.width="25%";
		$('etat').style.padding="2px";
		Nifty("div.round2","smooth fixed-height");
		new Effect.Appear("etat", {duration:1.5});
		
		$('pseudo').value="";
		$('pass').value="";
	} else {
		ajaxGetA('pages/ajax/pages.php?p=home','showPage');
	}
			
}

function showPage(r) {
	new Effect.BlindUp('contenu', { duration:0.5, afterFinish:function() { 
			var sms = r.split("%7C%3A%7C"); // Gestion des erreurs : vérification du code OK 
			
			if (unescape(sms[0])=="OK") {
				$('contenu').innerHTML=unescape(sms[2]);
				
				new Effect.BlindDown("contenu", {  duration:1});
				eval(unescape(sms[1]));
			} else {
				$('contenu').innerHTML="<br><br><br><center><a href='index.php'>Retourner sur la page d'accueil</a></center><br><br><br>";
				new Effect.Appear("contenu", {from:0.1, to:1, duration:1});
				alert('Erreur durant le chargement de la page');
			}
	} });
}

function deco() {
	ajaxGetA('pages/ajax/deconnexion.php','deco2');
}
function deco2() {
	ajaxGetA('pages/accueil.php?ajax=1','showPage');
}

function showInfos(time) { ajaxPostA('pages/ajax/valid.php','time='+escape(time),''); }

function valid_mail(evt) {
	var interdit = ' azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ+=@_¨µ.&*?!-:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\'';
	var keyCode = evt.which ? evt.which : evt.keyCode;
	if (keyCode==9) return true;
	if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) {
		return false;
	}
}

function limit(evt) {
	$('limit').innerHTML=$F('mess').length+"/160";
	if ($F('mess').length>=160) { 
		var interdit = ' azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBN0123456789àâäãçéèêëìîïòôöõùûüñ+=@_¨µ.&*?!-:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\'';
		var keyCode = evt.which ? evt.which : evt.keyCode;
		if (keyCode==9) return true;
		if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) return false;

	}
}

//-----------------------------------------------------------------------------------------------------

function ajaxGetA(fichier, fonction) {
	
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else alert('Votre navigateur n\'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés');
		requete.open('get',fichier,true);
		requete.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=iso-8859-1');
		requete.send(null);
			requete.onreadystatechange = function()  { 
				if(requete.readyState == 4 && requete.responseText != "")
				{				
					if (fonction!='') eval(fonction + "('"+escape(requete.responseText)+"')");
				} 
			}
}

function ajaxPostA(fichier,variable, fonction) {
	
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else alert('Votre navigateur n\'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés');
		requete.open("POST", fichier, true);
		requete.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
		requete.send(variable);
			requete.onreadystatechange = function()  { 
				if(requete.readyState == 4 && requete.responseText != "")
				{	
					if (fonction!='') eval(fonction + "('"+escape(requete.responseText)+"')");
				} 
		}
}		


//-------------------------------------------------------------------------