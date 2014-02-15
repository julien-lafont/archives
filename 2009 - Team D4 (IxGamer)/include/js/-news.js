
function showWriteCom() 
{
	new Effect.Phase("posterCom", {duration:1});
	new Effect.Phase("posterComDetail", {duration:1, afterFinish:function() {
		new Effect.ScrollTo('simple',{duration:1});
	} });
	
}

function comSend() {
	_mess=escape($F('messageBG'));
	_id=escape($F('id_news'));
	
	if (_mess.length<10) { alert('Votre message est trop court !'); return false }
	if (_id==0) { alert('Erreur : News inconnue'); return false }
	ajax('post', 'pages/news_ajax.php?act=com_send','message='+_mess+'&id='+_id, 'comSend2');

}

function comSend2(r) {
	if (unescape(r)!="ok") { alert('Une erreur est survenue durant l\'envoie de votre message.'); }
	else {
		$('posterCom').innerHTML="<span style='color:#00A8FF'>Votre commentaire a été posté avec succés !</span>";
		new Effect.Phase("posterComDetail", {duration:1});
		new Effect.Phase("posterCom", {duration:1});	
		
	}
	
}

// Avis aux amateurs : sa ne sert à rien d'essayer de hacker le site via ses fonctions, si je les est laissé visibles,
// c'est bien entendu car il n'y a aucun risque.
// La page appelé en ajax vérifiera bien entendu si vous êtes admin :)
function adSuppr(id, idNews) {
	ajax('get', 'pages/news_ajax.php','act=com_suppr&id='+id+'&idNews='+idNews, 'adSuppr2');
}
function adSuppr2(r) {
	Element.remove("com"+unescape(r));
}
function adEdit(id) {
	if (typeof edit != "undefined") edit.destroy();
	edit = new Window('showEdit', {className: "alphacube", title: "Mes commentaires", url: _URL+"pages/news_ajax.php?act=com_edit&id="+id, width:335, height:200, maximizable:true, minimizable:true, resizable: true, showEffectOptions: {duration:1}});
	edit.showCenter();
}
