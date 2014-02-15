//######################################################
//-------------------- Messagerie ----------------------
//######################################################

function msgShow(result) {
	new Effect.BlindUp('messagerie', {duration:1.5, afterFinish:function() { 
		Element.update('messagerie', unescape(result));
		new Effect.BlindDown("messagerie", {duration:1.5});
	} });
}

//----------------
function supprMp(id) {
	ajaxGetA('pages/membre/inbox_ajax.php?act=supprmp&id='+escape(id),'supprMp2');
	Element.show('img_attente');
} function supprMp2(result) {
	Element.hide('TB_window');
	Element.hide('TB_overlay');
	ajaxGetA('pages/membre/inbox_ajax.php?act=listemsg','listeMsg');
}

function SupprMpNoBug(id) {
	if ($('wait')) { Element.show('wait'); }
	ajaxGetA('pages/membre/inbox_ajax.php?act=supprmp&id='+escape(id),"supprMpNoBug2");
} function supprMpNoBug2(result) {
	ajaxGetA('pages/membre/inbox_ajax.php?act=listemsg','listeMsg');
}

//---------
function listeMsg() {
	ajaxGetA('pages/membre/inbox_ajax.php?act=listemsg','msgShow');
}

//---------
function listeHist() {
	ajaxGetA('pages/membre/inbox_ajax.php?act=historique','msgShow');
}

//----------
function viewMp(id) {
	Element.show('wait');
	ajaxGetA('pages/membre/inbox_ajax.php?act=viewmp&id='+escape(id),'msgShow');
}
function viewMpHist(id) {
	Element.show('wait');
	ajaxGetA('pages/membre/inbox_ajax.php?act=viewmpHist&id='+escape(id),'msgShow');
}

//-----------
function writeMsg() {
	Element.show('wait');
	ajaxGetA('pages/membre/inbox_ajax.php?act=write','msgShow');
}
function sendMsg() {
	if ($F('sujet').length==0) { $('sujet').style.border='1px solid #FF0000'; }
	else if ($F('mess').length==0) { $('mess').style.border='1px solid #FF0000'; }
	else {
		Element.show('wait');
		sujet=escape($F('sujet'));
		mess=escape($F('mess'));
		dest=$F('dest');
		ajaxPostA('pages/membre/inbox_ajax.php?act=write2','sujet='+sujet+'&mess='+mess+'&dest='+dest,"sendMsg3");
	}
}
function sendMsg3(result) {
	var look = result.split("%7C%3A%7C");  
	if(unescape(look[0])!="ok") { alert('Erreur durant l\'envoie du message !'); }
	else {
		new Effect.Fade('messagerie', {duration:1.5, afterFinish:function() { 
			Element.update('messagerie', unescape(look[1]));
			new Effect.Appear("messagerie", {duration:1.5, afterFinish:function() { 
				setTimeout('listeMsg()',1500);
			} });
		} });
	}
}

//######################################################
//------------------- Infos Profil ---------------------
//######################################################

function sms1(pseudo) {
	document.getElementById('fonctions').innerHTML="<br><center>Cette fonction sera activé dans les prochains jours.<br><br>Merci de votre compréhension<br><br>- <a href='#' onClick='retour(\""+pseudo+"\"); return false'>Retour</a> -</center><br>"; 
	round();
}

//-----------------------------------------------------------//
function vote1(pseudo) {
	txt=ajaxGet("pages/infos_ajax.php?act=vote1&pseudo="+escape(pseudo));
	document.getElementById('fonctions').innerHTML=txt;
	round();
}
function vote2() {
	note=document.getElementById('vote').value;
	idd=document.getElementById('id').innerHTML;
	document.getElementById('fonctions').innerHTML='<br><center><img src="images/indicator.gif"></center><br><br>';
	ajaxGetA("pages/infos_ajax.php?act=vote2&note="+escape(note)+"&id="+escape(idd),'vote3');
}
function vote3(result) {
	pseudo=document.getElementById('ajax_speudo').innerHTML;
	maj = unescape(result).split("---");
	document.getElementById('fonctions').innerHTML=maj[2];
	round();
	document.getElementById('bloc_note').innerHTML=maj[0];
	document.getElementById('bloc_coeff').innerHTML=maj[1];

	setTimeout('retour(pseudo);',1500);

}

//-----------------------------------------------------------//
function mess1(pseudo) {
	txt=ajaxGet("pages/infos_ajax.php?act=mess1&pseudo="+escape(pseudo));
	document.getElementById('fonctions').innerHTML=txt;
	round();
}
function mess2() {
	
	messs=document.getElementById('mess').value;
	idd=document.getElementById('id').innerHTML;
	document.getElementById('fonctions').innerHTML='<br><center><img src="images/indicator.gif"></center><br><br>';
	round();
	ajaxGetA('pages/infos_ajax.php?act=mess2&mess='+escape(messs)+'&dest='+escape(idd),'mess3');
}
function mess3(result) {
	document.getElementById('fonctions').innerHTML = unescape(result);
	round();
	
	pseudo=document.getElementById('ajax_speudo').innerHTML;
	setTimeout('retour(pseudo);',1500);
}

//-------------------------------------------
function retour(pseudo) {
	ajaxGetA('pages/infos_ajax.php?act=retour&pseudo='+escape(pseudo),'retour2');
	document.getElementById('fonctions').innerHTML='<br><center><img src="images/indicator.gif"></center><br><br>';
	round();
}
function retour2(result) {
	document.getElementById('fonctions').innerHTML=unescape(result);
	round();
}

//######################################################
//----------------------- AJAX ------------------------
//######################################################
function ajaxGetA(fichier, nom_fonction) {
	
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else alert('Votre navigateur n\'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés');
		requete.open('get',fichier,true);
		requete.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=iso-8859-1');
		requete.send(null);
			requete.onreadystatechange = function()  { 
				if(requete.readyState == 4 && requete.responseText != "")
				{				
					eval(nom_fonction + "('"+escape(requete.responseText)+"')");
				} 
			}
}

function ajaxPostA(fichier,variable, nom_fonction) {
	
		if (window.XMLHttpRequest) requete = new XMLHttpRequest();
		else if (window.ActiveXObject) requete = new ActiveXObject("Microsoft.XMLHTTP");
		else alert('Votre navigateur n\'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés');
		requete.open("POST", fichier, true);
		requete.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
		requete.send(variable);
			requete.onreadystatechange = function()  { 
				if(requete.readyState == 4 && requete.responseText != "")
				{				
					eval(nom_fonction + "('"+escape(requete.responseText)+"')");
				} 
		}
}


function ajaxGet(fichier)
{
	if(window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
		return(false);
	xhr_object.open("GET", fichier, false);
	xhr_object.send(null);
	if(xhr_object.readyState == 4) return(xhr_object.responseText);
	else return(false);
}

function ajaxPost(fichier,variable)
{
	if(window.XMLHttpRequest) xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else return(false);
	xhr_object.open("POST", fichier, false);
	xhr_object.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xhr_object.send(variable);
	if(xhr_object.readyState == 4) return(xhr_object.responseText);
	else return(false);
}