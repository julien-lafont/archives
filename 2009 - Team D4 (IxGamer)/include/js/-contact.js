function windowsError(message)
{
	if (typeof winMess != "undefined") winMess.destroy();
	winMess = new Window('newMess', {className: "alphacube", title: "Erreur détectée", width:250, height:100, maximizable:false,  minimizable:false, resizable: true, showEffectOptions: {duration:1}});
	winMess.getContent().innerHTML= "<html><head></head><body><div style='padding:10px; font-size:12px; font-family:verdana; color:#333'><div style='color:#00A8FF; font-weight:bold' id='newMess'>Erreur !</div><br />"+message+"</div></body></html>";
	winMess.showCenter();
		
}

function verifContactLog() 
{
	_choix=escape($F('_choix'));
	_message=escape($F('_message'));
	
	if (_message.length<=10) {  windowsError('Votre message est trop court'); return false }
	ajax('post', 'pages/contact_ajax.php?act=posterLog','message='+_message+'&sujet='+_choix, 'resultat');
}

function verifContact() 
{
	_choix=escape($F('_choix'));
	_message=escape($F('_message'));
	_nom=escape($F('_nom'));
	_email=$F('_email');
	
	if (_nom.length==0) { windowsError('Vous devez spécifier un nom'); return false; }
	
	var arobase = _email.indexOf("@")
	var point = _email.lastIndexOf(".")
	if ((arobase < 3)||(point + 2 > _email.length) ||(point < arobase+3)) {
		 windowsError('Votre adresse email est incorrecte !'); return false; }

	if (_message.length<=10) {  windowsError('Votre message est trop court'); return false }
	
	ajax('post', 'pages/contact_ajax.php?act=posterNoLog','message='+_message+'&sujet='+_choix+'&nom='+_nom+'&email='+_email, 'resultat');
}

function resultat(r) 
{
	var verif = unescape(r).split('|:|');
	if (verif[0]!="ok") 
	{
		alert("Une erreur est survenue durant l'envoie de votre message.\nVeuillez ré-essayer ultérieurement.");
	}
	else
	{
		$('result').innerHTML=verif[1];
		new Effect.Phase("contact", {duration:1});
		new Effect.Phase("result", {duration:1});
	}
}