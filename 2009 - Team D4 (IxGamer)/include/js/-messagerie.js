// Fonction générique : met à jour le contenu
function msgShow(result) {
	if ($('wait')) { Element.hide('wait'); }
	new Effect.SlideUp('messagerie', {duration:0.7, afterFinish:function() { 
		Element.update('messagerie', unescape(result));
		new Effect.SlideDown("messagerie", {duration:1 });
	} });
}

//---- Liste les messages
function listeMsg() {
	ajax('get', 'pages/_membre/messagerie_ajax.php','act=listemsg','msgShow');
}
function listeHist() {
	ajax('get','pages/_membre/messagerie_ajax.php','act=historique','msgShow');
}

//---- Supprimer un message
function supprMp(id) {
	ajax('get', 'pages/_membre/messagerie_ajax.php', 'act=supprmp&id='+escape(id),'supprMp2');
}
function supprMp2(r) {
	r=unescape(r);
	if (r=="bad") {
		alert("Erreur durant la suppression du MP");
	} else {
		Element.remove("tr"+r);
	}
}
function supprDirect(id) {
	ajax('get', 'pages/_membre/messagerie_ajax.php', 'act=supprmp&id='+escape(id),'supprDirect2');
}
function supprDirect2(r) {
	r=unescape(r);
	if (r=="bad") {
		alert("Erreur durant la suppression du MP");
	} else {
		listeMsg();
	}
}

//---- Afficher un message
function viewMp(id) {
	Element.show('wait');
	ajax('get','pages/_membre/messagerie_ajax.php','act=viewmp&id='+escape(id),'msgShow');
}
function viewMpHist(id) {
	Element.show('wait');
	ajax('get','pages/_membre/messagerie_ajax.php','act=viewmpHist&id='+escape(id),'msgShow');
}

//---- Ecrire un message
function writeMsg() {
	Element.show('wait');
	ajax('get','pages/_membre/messagerie_ajax.php','act=write','msgShow');
}
function repondre(id) {
	Element.show('wait');
	ajax('get','pages/_membre/messagerie_ajax.php','act=write&id='+escape(id),'msgShow');
}

function sendMsg() {
	if ($F('sujet').length==0) { $('sujet').style.border='1px solid #FF7FB4'; }
	else if ($F('mess').length==0) { $('mess').style.border='1px solid #FF7FB4'; }
	else if ($F('dest_id')==0) { alert("Erreur dans la sélection du destinataire"); }
	else {
		Element.show('wait');
		sujett=escape($F('sujet'));
		messs=escape($F('mess'));
		destt=$F('dest_id');
		ajax('post', 'pages/_membre/messagerie_ajax.php?act=write2','sujet='+sujett+'&mess='+messs+'&dest='+destt,"sendMsg3");
	}
}
function sendMsg3(r) {
	var verif = unescape(r).split('|:|');
	if(unescape(verif[0])!="ok") { alert('Erreur durant l\'envoie du message !'); Element.hide('wait'); }
	else {
		new Effect.Fade('messagerie', {duration:0.7, afterFinish:function() { 
			Element.update('messagerie', unescape(verif[1]));
			new Effect.Appear("messagerie", {duration:1, afterFinish:function() { 
				setTimeout('listeMsg()',1500);
			} });
		} });
	}
}
function ac_return(field, item){
        var regex = new RegExp('[0123456789]*-idcache', 'i');
        var nomimage = regex.exec($(item).innerHTML);
        id = nomimage[0].replace('-idcache', '');
        $(field.name+'_id').value = id;
}
