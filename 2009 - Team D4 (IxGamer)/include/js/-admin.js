//:: ---------- NEWS ADMIN ---------- :://
function verifAjouterNews()
{
	$("contenu").value = oEdit1.getHTMLBody();
	if ($F("contenu")=="" || $F("_titre")=="")
	{
		alert("Vous devez remplir tout les champs requis.");
		return false;
	}
	else
	{
		return true;
	}
}

//:: ------- NEWS accueil -------- :://
function ConfirmSuppr(id) {
	el=document.getElementById('news'+id).getElementsByTagName("div")[0];	
	new Effect.Scale(el, 300, { scaleY:false, scaleContent:false, afterFinish:function() { 
			new Effect.Highlight(el,{duration: 0.5, startcolor:'#FFFFFF', endcolor:'#FFDFF1'});
			el.innerHTML="<span style='font-size:10px'>Confirmer suppression ? <br /><a href='#' onclick='adSupprNews("+id+"); return false'>Oui</a> - <a href='#' onclick='fermerBloc("+id+"); return false'>Non</a></span>";
	} });
}
function fermerBloc(id) {
	el=document.getElementById('news'+id).getElementsByTagName("div")[0];	
	new Effect.Squish(el);
}
function adSupprNews(id) {
	ajax('get', 'pages/_admin/news_breves_ajax.php', 'action=supprNews&id='+escape(id), 'adSupprNews2');
}
function adSupprNews2(r) {
	Element.remove('news'+escape(r));
}

//:: ------ Brèves accueil ------ :://
function ConfirmSupprBreve(id) {
	el=$('bloc_admin');	
	new Effect.Scale(el, 300, { scaleY:false,  afterFinish:function() { 
			new Effect.Highlight(el,{duration: 0.5, startcolor:'#FFFFFF', endcolor:'#FFDFF1'});
			el.innerHTML="<span style='font-size:10px'>Confirmer suppression ? <br /><a href='#' onclick='adSupprBreve("+id+"); return false'>Oui</a> - <a href='#' onclick='fermerBlocBreve("+id+"); return false'>Non</a></span>";
	} });
}
function fermerBlocBreve(id) {
	el=$('bloc_admin');	
	new Effect.Squish(el);
}
function adSupprBreve(id) {
	ajax('get', 'pages/_admin/news_breves_ajax.php', 'action=supprBreve&id='+escape(id), 'adSupprBreve2');
}
function adSupprBreve2(r) {
	el=document.getElementById('simple').getElementsByTagName("td")[3];
	el.innerHTML="<br /><br /><br /><center><b>Brève supprimée !</b></center></br /><br /><br /><br />";
}

//:: --------- Pages ADMIN -------- :://
function showUrl(url)
{
	$('temp_url').style.display='inline'; 
	$('temp_url').value=url;
}

//:: ------- Admin Contact --------- :://
function classerContact(obj)
{
	value=obj.options[obj.selectedIndex].value;
	id=obj.id;

	if (value!="")
	{
		obj.options[obj.selectedIndex].text="Modif...";
		obj.style.color="#00FF00";
		ajax('get', 'pages/_admin/contact_ajax.php', 'action=changerEtat&id='+id+'&value='+value, 'classerContact2')
	}
}

function classerContact2(r)
{
	var verif = unescape(r).split('|:|');
	if (verif[0]!="ok") alert("Une erreur est survenue durant le changement d'état !");
	else {
		id=verif[1];
		value=verif[2];
		
		if (value=="Supprimer")
		{
			Element.remove('tr'+id);
		}
		else
		{
			$('tr'+id).cells[1].innerHTML="<u>"+value+"</u>";
			$(id).options[$(id).selectedIndex].text=value;
			$(id).style.color="#5FCAFF";
		}
	}
}

//:: -------- Admin TEAM -------- :://
function showIdPseudo() 
{
	if (typeof winRelID != "undefined") winRelID.destroy();
	winRelID = new Window('RelIdPseudo', {className: "alphacube", title: "Relation ID-Pseudo", url: _URL+"pages/_admin/team_ajax.php?act=affRelation", width:300, height:400, maximizable:true, minimizable:true, resizable: true, showEffectOptions: {duration:1}});
	winRelID.showCenter();	
}

//:: ------ ADMIN galerieD4 ------ :://
/* Miniatures galerie */
function showimage() {
	if (!document.images)
		return 
	$('imgCible').src='images/upload/galerieD4/' + $('selectImg').options[$('selectImg').selectedIndex].value;
}

function verifChangeMin() {
	min=$('selectImg').options[$('selectImg').selectedIndex].value;
	if (min=="default/error.jpg") {
		alert('Erreur ! \nVous devez sélectionne une miniature');
		return false;
	} else if (min=="default/no_min1b.jpg") {
		$('newImg').value="";
		return true;
	} else {
		$('newImg').value=min;
		return true;
	}	
}

//:: ------ ADMIN membres ------- :://
function verifSearch() {
	email=$F('email');
	pseudo=$F('pseudo');
	
	if ( ( email.length!=0 && pseudo.length!=0 ) || ( email.length==0 && pseudo.length==0 ) )
	{
		alert('Vous devez indiquez un pseudo ou un email obligatoirement !');
		return false;
	}
	else
	{
		return true;
	}
}

function crypterPass() {
	newPass=escape($F('newPass'));
	ajax('post', 'pages/_admin/membres_ajax.php?act=crypter', 'pass='+newPass, 'crypterPass2');
}
function crypterPass2(r) {
	newPass=unescape(r);
	$('mdp').value=newPass;
	$('mdp').style.borderColor='#00FF00';
}
	