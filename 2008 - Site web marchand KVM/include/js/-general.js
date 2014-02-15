// VARIABLES DE CONFIGURATION
var _URL = "http://www.yotsumi.info/kvm/";

/*
son of suckerfish menu script from:
http://www.htmldog.com/articles/suckerfish/dropdowns/
 */
 
 sfHover = function() {
 	var sfEls = $('#nav li');
	//var sfEls = document.getElementById("nav").getElementsByTagName("LI");
	for (var i=0; i<sfEls.length; i++) {
		sfEls[i].onmouseover=function() {
			this.className+=" sfhover";
			this.style.zIndex=200; //this line added to force flyout to be above relatively positioned stuff in IE
		}
		sfEls[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);






function show_flash(w, h, swf, color, fvar) {
    document.write("<object class=\"flash\" type=\"application/x-shockwave-flash\" data=\"" + swf + "\" width=\"" + w + "\" height=\"" + h + "\">");
    document.write("<param name=\"movie\" value=\"" + swf + "\" />");
    document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
    document.write("<param name=\"pluginurl\" value=\"http://www.macromedia.com/go/getflashplayer\" />");
    document.write("<param name=\"wmode\" value=\"transparent\" />");
    document.write("<param name=\"bgcolor\" value=\"" + color + "\" />");
    document.write("<param name=\"menu\" value=\"false\" />");
    document.write("<param name=\"quality\" value=\"best\" />");
    document.write("<param name=\"scale\" value=\"exactfit\" />");
    document.write("<param name=\"flashvars\" value=\"" + fvar + "\" />");
    document.write("</object>");
}

function connexion( /* position */ ) {
	
	//Y-a-t-il un un argument
	if ( arguments.length==1 ) 	var position = arguments[0];
	else 						var position = "bloc";
	
		//>> Appel normal ( bloc )
		if (position=="bloc") suffix="";
		//>> Appel à l'intérieur de la page
		else if (position=="inPage") suffix="_in";

	$('#log_submit'+suffix).hide();
	$('#log_statut'+suffix).show();
	_login = escape($('#log_pseudo'+suffix).val());
	_pass   = escape($('#log_pass'+suffix).val());
		
	ajax('post', 'pages/ajax/connexion.php', 'login='+_login+'&pass='+_pass, "loginAjaxAction"+suffix);
}

	// Retour normal de l'appel connexion ( bloc )
	function loginAjaxAction(r_json) {
		var json = eval(unescape(r_json)); /* Données Json dans retourConnexion */
		if (retourConnexion.statut=="+") {
			$('#bloc_membre').html(retourConnexion.newMenu);
			$('#bloc_panier #ulListePanier').html(retourConnexion.newPanier);
			$('#ulListePanier').Highlight(500, '#FFFFCC');
			
		}
		else
		{
			$('#log_submit').show();
			$('#log_statut').html(retourConnexion.erreur);
			$('#log_statut').css('color', '#FF0000');
			$('#form_connexion input.log').css({border:"1px solid #FF888B"});
		}
	}
	
	// Retour du formulaire de connexion secondaire
	function loginAjaxAction_in(r_json) {
		var json = eval(unescape(r_json)); /* Données Json dans retourConnexion */
		if (retourConnexion.statut=="+") {
			window.location.replace("commander-coordonnees.htm");
		}
		else
		{
			$('#log_submit_in').show();
			$('#log_statut_in').html(retourConnexion.erreur);
			$('#log_statut_in').css('color', '#FF0000');
			$('#form_connexion_in input.log').css({border:"1px solid #FF888B"});
		}
	}

var id_photo_plus=0;
function ajouter_photos() {
	
	champ =	' <div class="boutonBlanc float"><a href="#" onclick="this.blur(); openAsset(\'image_plus_'+id_photo_plus+'\'); return false;" >Parcourir</a></div>';
	champ+= ' <input type="text" name="image_plus_'+id_photo_plus+'" id="image_plus_'+id_photo_plus+'" style="margin:5px 20px 10px 25px; width:300px"><br />';

	$("#image_plus").before(champ);
	id_photo_plus++;
}



function ajouter_panier(id) {

	$('#imageProduit'+id).TransferTo ({
    	to:'#panierr',
		duration: 700,
		className:'transferer1',
		easing:'elasticout',
		complete:function() { ajax('get', 'pages/panier_ajax.php', 'action=ajouter_article&id='+escape(id), 'maj_panier'); }
	} );
}

function maj_panier(r) {

	r=unescape(r);
	$('#ulListePanier').html(r);
	$('#ulListePanier').Highlight(500, '#FFFFCC');
	
}

function modif_quantite(plusoumoins, id) {

	if (plusoumoins=="+") 	val=1;
	else					val=0;
	
	ajax('get', 'pages/panier_ajax.php', 'action=modif_qtt&val='+val+'&id='+escape(id), 'maj_prix');
	
}

function maj_prix(r_json) {
	var json = eval(unescape(r_json));
	
	$('#nbProduit'+modifQtt.id).html(modifQtt.nb);
	
	$('#prixTTC'+modifQtt.id).html( modifQtt.new_prix_TTC +" &euro;");
	$('#prixHT'+modifQtt.id).html( modifQtt.new_prix_HT +" &euro;");
	$('#prixECO'+modifQtt.id).html( modifQtt.new_prix_ECO +" &euro;");

	$('#totalTTC').html( modifQtt.total_prix_TTC );
	$('#totalHT').html( modifQtt.total_prix_HT );
	$('#totalECO').html( modifQtt.total_prix_ECO );
}


function affichers_produits(zone) {
	id=$('#select_cat').val();
	if (id!=0) {
		ajax('post', 'pages/_admin/produits/pageAccueil_ajax.php', 'id='+id+'&zone='+escape(zone), 'affichers_produits_r');
	}	
}

function affichers_produits_r(r) {
	r=unescape(r);
	
	$("#liste_produits").fadeOut(500, function() { 
		$("#liste_produits").html(r);
		$("#liste_produits").fadeIn();	
	});
	
}

//:: Controle les caractères tappés par l'utilisateur dans un formulaire :://
function valid(evt,type) {
	if      (type=="alphanum")  var interdit = ' +àâäãçéèêëìîïòôöõùûüñ&*?!:;,\t#~"^%$£?²¤§*@°¨µ=.()[]{}<>|\\/`\''; 
	else if (type=="site")		var interdit = '+àâäãçéèêëìîïòôöõùûüñ*!;,\t#"=^$£²¤§%*@°¨µ()[]{}<>|\`\''; 
	else if (type=="num") 		var interdit = '+azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ&*?@_ =!-:;,\t#~"^$£?²¤§%*°¨µ()[]{}<>|\\/`\''; 
	else if (type=="email") 	var interdit = '+àâäãçéèêëìîïòôöõùûüñ= &*?!:;,\t#~"^%$£?²¤§*°¨µ()[]{}<>|\\/`\''; 
	else 						var interdit = '+àâäãçéèêëìîïòôöõùûüñ=&*?!:;,\t#~"^%$£?²¤§*°¨µ@_.()[]{}<>|\\/`\''; 
	var keyCode = evt.which ? evt.which : evt.keyCode;
	if (keyCode==9 || keyCode==71) return true;
	if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) {
		return false;
	}
}

// Script Ajax perso ( POST/GET en asynchrone )
function ajax ( type, fichier, variables /* , fonction */ ) 
{ 
	if ( window.XMLHttpRequest ) var req = new XMLHttpRequest();
	else if ( window.ActiveXObject ) var req = new ActiveXObject("Microsoft.XMLHTTP");
	else alert("Votre navigateur n'est pas assez récent pour accéder à cette fonction, ou les ActiveX ne sont pas autorisés");
	if ( arguments.length==4 ) var fonction = arguments[3];

	if (type.toLowerCase()=="post") {
		req.open("POST", _URL+fichier, true);
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
		req.send(variables);
	} else if (type.toLowerCase()=="get") {
		req.open('get', _URL+fichier+"?"+variables, true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=iso-8859-1');
		req.send(null);
	} else { 
		alert("Méthode d'envoie des données invalide"); 
	}

	req.onreadystatechange = function()  { 
		if (req.readyState == 4 && req.responseText != null )
		{				
			if (fonction) eval( fonction + "('"+escape(req.responseText)+"')");
			
		} 
	}
}
// Equivalent perso de isset( )
function isset(varname){
  return (typeof(varname)!='undefined');
}

// Tester navigateur
var agt=navigator.userAgent.toLowerCase();
var appVer=navigator.appVersion.toLowerCase();
var is_opera=(agt.indexOf("opera")!=-1);
var is_mac=(agt.indexOf("mac")!=-1);
var is_konq=(agt.indexOf('konqueror')!=-1);
var is_safari=((agt.indexOf('safari')!=-1)&&(agt.indexOf('mac')!=-1))?true:false;
var is_khtml=(is_safari||is_konq);
var is_gecko=((!is_khtml)&&(navigator.product)&&(navigator.product.toLowerCase()=="gecko"))?true:false;
var is_fb=((agt.indexOf('mozilla/5')!=-1)&&(agt.indexOf('spoofer')==-1)&&(agt.indexOf('compatible')==-1)&&(agt.indexOf('opera')==-1)&&(agt.indexOf('webtv')==-1)&&(agt.indexOf('hotjava')==-1)&&(is_gecko)&&(navigator.vendor=="Firebird"));
var is_fx=((agt.indexOf('mozilla/5')!=-1)&&(agt.indexOf('spoofer')==-1)&&(agt.indexOf('compatible')==-1)&&(agt.indexOf('opera')==-1)&&(agt.indexOf('webtv')==-1)&&(agt.indexOf('hotjava')==-1)&&(is_gecko)&&((navigator.vendor=="Firefox")||(agt.indexOf('firefox')!=-1)));
var is_moz=((agt.indexOf('mozilla/5')!=-1)&&(agt.indexOf('spoofer')==-1)&&(agt.indexOf('compatible')==-1)&&(agt.indexOf('opera')==-1)&&(agt.indexOf('webtv')==-1)&&(agt.indexOf('hotjava')==-1)&&(is_gecko)&&(!is_fb)&&(!is_fx)&&((navigator.vendor=="")||(navigator.vendor=="Mozilla")||(navigator.vendor=="Debian")));
var is_nav=((agt.indexOf('mozilla')!=-1)&&(agt.indexOf('spoofer')==-1)&&(agt.indexOf('compatible')==-1)&&(agt.indexOf('opera')==-1)&&(agt.indexOf('webtv')==-1)&&(agt.indexOf('hotjava')==-1)&&(!is_khtml)&&(!(is_moz))&&(!is_fb)&&(!is_fx));
var is_ie=((appVer.indexOf('msie')!=-1)&&(!is_opera)&&(!is_khtml));
var is_ie7=((appVer.indexOf('msie 7.0')!=-1)&&(!is_opera)&&(!is_khtml));
	



function modalDialogShow_IE(url,width,height) //IE
	{
	return window.showModalDialog(url,window,
		"dialogWidth:"+width+"px;dialogHeight:"+height+"px;edge:Raised;center:Yes;help:No;Resizable:Yes;Maximize:Yes");
	}
function modalDialogShow_Moz(url,width,height) //Moz
    {
    var left = screen.availWidth/2 - width/2;
    var top = screen.availHeight/2 - height/2;
    activeModalWin = window.open(url, "", "width="+width+"px,height="+height+",left="+left+",top="+top);
    window.onfocus = function(){if (activeModalWin.closed == false){activeModalWin.focus();};};
    }
var sActiveAssetInput;
function setAssetValue(v) //required by the asset manager
    {
    document.getElementById(sActiveAssetInput).value = v;
	if (document.getElementById('img_select')) document.getElementById('img_select').src=v;
    }
function openAsset(s)
	{
	sActiveAssetInput = s
	if(navigator.appName.indexOf('Microsoft')!=-1){
		document.getElementById(sActiveAssetInput).value=modalDialogShow_IE(_URL+"include/Editor/assetmanager/assetmanager.php?lang=french",640,465); //IE
		if (document.getElementById('img_select')) document.getElementById('img_select').src=document.getElementById(sActiveAssetInput).value; }
	else {
		modalDialogShow_Moz(_URL+"include/Editor/assetmanager/assetmanager.php?lang=french",640,465); //Moz	
		}
	}