
function carousel_admin() {
	
	$('#carousel').Carousel(
	{
		itemWidth: 32,
		itemHeight: 32,
		itemMinWidth: 20,
		items: 'a',
		reflections: 0,
		rotationSpeed: 3
	});
	
	$('#cpanel').hide();
	$('#carousel').show();


}
//:: ---------- NEWS ADMIN ---------- :://
function verifAjouterNews()
{
	$("#contenu").val(oEdit1.getHTMLBody());
	if ($("#contenu").val()=="" || $("#_titre").val()=="" || $("#inpURL").val()=="" )
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
	el = document.getElementById('news'+id).getElementsByTagName("div")[0];
	
	// On bloque le fading
	$(el).attr("onMouseOut","return false");
	$(el).fadeIn("fast");;
	
	$(el).animate({width:'325px'}, "normal", null, function() { 
			$(el).Highlight(500, '#FFF'); /* #FFDFF1 */
			$(el).html("<center><span style='font-size:10px'>Confirmer suppression ? <a href='#' onclick='adSupprNews("+id+"); return false'>Oui</a> - <a href='#' onclick='fermerBloc("+id+"); return false'>Non</a></span></center>");
	} );
}
function fermerBloc(id) {
	el=document.getElementById('news'+id).getElementsByTagName("div")[0];
	
	$(el).Shrink(500);
}
function adSupprNews(id) {
	ajax('get', 'pages/_admin/news_breves_ajax.php', 'action=supprNews&id='+escape(id), 'adSupprNews2');
}
function adSupprNews2(r) {
	$('news'+escape(r)).remove();
}

//:: ------ Brèves accueil ------ :://
function ConfirmSupprBreve(id) {
	el=$('#bloc_admin');	
	el.animate({width:'300px'}, "normal", null, function() { 
			el.Highlight(500, '#FFF');
			el.html("<span style='font-size:10px'>Confirmer suppression ? <a href='#' onclick='adSupprBreve("+id+"); return false'>Oui</a> - <a href='#' onclick='fermerBlocBreve("+id+"); return false'>Non</a></span>");
	} );
}
function fermerBlocBreve(id) {
	el=$('#bloc_admin');	
	el.Shrink(500);
}
function adSupprBreve(id) {
	ajax('get', 'pages/_admin/news_breves_ajax.php', 'action=supprBreve&id='+escape(id), 'adSupprBreve2');
}
function adSupprBreve2(r) {
	el=$('#content');
	
	el.html("<br /><br /><br /><center><b>Brève supprimée !</b></center></br /><br /><br /><br />");
}


//:: ------ News Detail ------ :://
function ConfirmSupprNews(id) {
	el=$('#bloc_admin');	
	el.animate({width:'300px'}, "normal", null, function() { 
			el.Highlight(500, '#FFF');
			el.html("<span style='font-size:10px'>Confirmer suppression ? <a href='#' onclick='adSupprNewsDetail("+id+"); return false'>Oui</a> - <a href='#' onclick='fermerBlocBreve("+id+"); return false'>Non</a></span>");
	} );
}
function adSupprNewsDetail(id) {
	ajax('get', 'pages/_admin/news_breves_ajax.php', 'action=supprNews&id='+escape(id), 'adSupprNewsDetail');
}
function adSupprNewsDetail(r) {
	$('#content').html("<br /><br /><br /><center><b>News supprimée !</b></center></br /><br /><br /><br />");
}




//:: --------- Pages ADMIN -------- :://
function showUrl(url)
{
	$('#temp_url').css('display','inline'); 
	$('#temp_url').val(url);
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
			$('#tr'+id).remove();
		}
		else
		{
			$('#tr'+id+' td:eq(1)').html("<u>"+value+"</u>");
			document.getElementById(id).options[document.getElementById(id).selectedIndex].text=value;
			$('#'+id).css('color',"#5FCAFF");
		}
	}
}

//:: -------- Admin TEAM -------- :://
function showIdPseudo() 
{
	$("#lienPass").html('Chargement en cours');
	$("#windowContent").load(_URL+"pages/_admin/team_ajax.php?act=affRelation", null, function() { ouvrirFenetreTransfert('lienAvatar'); } );
	ouvrirFenetreTransfert('global');

}

//:: ------ ADMIN galerieD4 ------ :://
/* Miniatures galerie */
function showimage() {
	jQuery.noConflict(); 
	if (!document.images)
		return 
	document.getElementById('imgCible').src='images/upload/galerieOfficielle/' + document.getElementById('selectImg').options[document.getElementById('selectImg').selectedIndex].value;
}

function verifChangeMin() {
	min=document.getElementById('selectImg').options[document.getElementById('selectImg').selectedIndex].value;
	if (min=="default/error.jpg") {
		alert('Erreur ! \nVous devez sélectionne une miniature');
		return false;
	} else if (min=="default/no_min1b.jpg") {
		$('#newImg').val("");
		return true;
	} else {
		$('#newImg').val(min);
		return true;
	}	
}

//:: ------ ADMIN membres ------- :://
function verifSearch() {
	email=$('#email').val();
	pseudo=$('#pseudo').val();
	ip=$('#ip').val();
	
	if ( ( email.length!=0 && pseudo.length!=0 && ip.length!=0) || ( email.length==0 && pseudo.length==0 && ip.length==0) )
	{
		alert('Vous devez indiquez un pseudo, un email, OU une ip obligatoirement !');
		return false;
	}
	else
	{
		return true;
	}
}

function crypterPass() {
	newPass=escape($('#newPass').val());
	ajax('get', 'pages/_admin/membres_ajax.php', 'act=crypter&pass='+newPass, 'crypterPass2');  //
}
function crypterPass2(r) {
	newPass=unescape(r);
	$('#mdp').val(newPass);
	$('#mdp').css('borderColor','#00FF00');
}
	
	
//:: ---------- Bloc sponsor ---------- :://
function modifSponsor()
{
	$("#contenu").val(oEdit1.getHTMLBody());
	return true;
}

	
