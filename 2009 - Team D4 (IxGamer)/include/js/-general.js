// VARIABLES DE CONFIGURATION
var _URL = "http://www.yotsumi.info/d4/";

function fenetreNouveauMessage(nb) 
{
	if (typeof winMess != "undefined") winMess.destroy();
	winMess = new Window('newMess', {className: "alphacube", title: "Messagerie", width:250, height:100, maximizable:false,  resizable: true, showEffectOptions: {duration:1}});
	winMess.getContent().innerHTML= "<html><head><style>#newMess a { color:#222; text-decoration:none; border-bottom:1px dashed #FF7FB4} #newMess a:hover { color:#000; border-bottom:1px solid #FF7FB4} </style></head><body><div style='padding:10px; font-size:12px; font-family:verdana; color:#333'><div style='color:#00A8FF; font-weight:bold' id='newMess'>Vous avez un nouveau message </div><br />Allez vite le consulter depuis votre <a href='"+_URL+"membre/messagerie/'>messagerie personelle</a></div></body></html>";
	winMess.showCenter();
}

// Connexion automatique 
function loginAjax() 
{
	$('status_log').innerHTML="<img src='images/wait4.gif' style='vertical-align:middle'/> Vérification ...";
	$('status_log').style.display="inline";
	$('status_log').style.color="#5FCAFF";

	_login=escape($F('log_login'));
	_pass=escape($F('log_pass'));
	_currentPath=escape($('ajax_path').innerHTML);
	
	ajax('post', 'pages/ajax/connexion.php', 'login='+_login+'&pass='+_pass+'&current_path='+escape(_currentPath), 'loginAjaxAction');
	
}

function loginAjaxAction(r)
{
	var verif = unescape(r).split('|:|');
	if (verif[0]=="+") {
		new Effect.SlideUp('cadre_membre', { duration:0.7, afterFinish:function() { 
			$('cadre_membre').innerHTML=verif[2];
			new Effect.SlideDown('cadre_membre', { duration:0.7 } );
		} });
	}
	else
	{		
		$('status_log').innerHTML="Identifiants incorrects";
		$('status_log').style.display="inline";
		$('log_login').style.border="1px solid #FF7FB4";
		$('log_pass').style.border="1px solid #FF7FB4";
	}

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

// Redimensionne une image en gardant la proportion
function redim(idImg, maxW, maxH)
{

	w=$(idImg).width;
	h=$(idImg).height;

	  if ((h >= maxH) || (w >= maxW)) {
		if ((h >= maxH) && (w >= maxW)) 
		{
		  if (h > w) {
			dH = maxH;
			dW = parseInt((w * dH) / h, 10);
		  } else {
			dW = maxW;
			dH = parseInt((h * dW) / w, 10);
		  }
		} 
		else if ((h > maxH) && (w < maxW)) 
		{
		  dH = maxH;
		  dW = parseInt((w * dH) / h, 10);
		} 
		else if ((h < maxH) && (w > maxW)) 
		{
		  dW = maxW;
		  dH = parseInt((h * dW) / w, 10);
		}
		
		$(idImg).style.width=dW+"px";
		$(idImg).style.height=dH+"px";
	}
	  
	

}


// Cache le status 'Identifiants incorrects' si nécessaire :
function hideStatus() 
{
	if ($('status_log').style.display!="none" && $('status_log').style.display!="")
	{
		$('status_log').style.display="none";
		$('log_login').style.border="1px solid #c5c7cb";
		$('log_pass').style.border="1px solid #c5c7cb";
	}
}


// Utilise les fonctions PHP pour mettre un style aux textes ( appel en synchrone, ne pas en abuser )
function miseEnForme(type, txt) 
{
	return ajaxPost('pages/ajax/miseenforme.php', 'type='+escape(type)+'&txt='+escape(txt));
}

function scrollSimple() {
	new Effect.ScrollTo("simple",{duration:1});
}

function showMessageNoLog() {
	if (typeof winNoLog != "undefined") winNoLog.destroy();
	winNoLog = new Window('newMess', {className: "alphacube", title: "Accés non-autorisé", width:250, height:130, maximizable:false, minimizable:false,  resizable: true, showEffectOptions: {duration:1}});
	winNoLog.getContent().innerHTML= "<html><head><style>#newMess a { color:#222; text-decoration:none; border-bottom:1px dashed #FF7FB4} \n\n#newMess a:hover { color:#000; border-bottom:1px solid #FF7FB4} </style></head><body><div style='padding:10px; font-size:12px; font-family:verdana; color:#333'><div style='color:#00A8FF; font-weight:bold' id='newMess'>Accés refusé</div><br />Vous devez être connecté pour accéder à cette page. <br /><br /><a href='Inscription/'>Inscription</a></div></body></html>";
	winNoLog.showCenter();		
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

// Fonction POST a délaissée ( POST en Synchrone )
function ajaxPost(fichier,variable)
{
	if(window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
		return(false);
	xhr_object.open("POST", _URL+fichier, false);
	xhr_object.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
	xhr_object.send(variable);
	if(xhr_object.readyState == 4) return(xhr_object.responseText);
	else return(false);
}


// Equivalent perso de isset( )
function isset(varname){
  return (typeof(varname)!='undefined');
}

// Inclure des fichiers
function include(fichier)
{
  try
  {
    SCRIPT = document.createElement("script");
    SCRIPT.type = "text/javascript";
    SCRIPT.src  = fichier;
    HEAD = document.getElementsByTagName("head");
    HEAD[0].appendChild(SCRIPT);
  }
  catch(e)
  {
    document.write('$lt;script type="text/javascript" src="' + fichier + '"><\/script>');
  }
}

// Tester navigateur
   var agt=navigator.userAgent.toLowerCase();
   var appVer=navigator.appVersion.toLowerCase();
    var is_opera = (agt.indexOf("opera") != -1);
    var is_mac = (agt.indexOf("mac")!=-1);
    var is_konq = (agt.indexOf('konqueror') != -1);
    var is_safari = ((agt.indexOf('safari')!=-1)
		&&(agt.indexOf('mac')!=-1))?true:false;
    var is_khtml  = (is_safari || is_konq);
    var is_gecko = ((!is_khtml)&&(navigator.product)
		&&(navigator.product.toLowerCase()=="gecko"))?true:false;                          
    var is_fb = ((agt.indexOf('mozilla/5')!=-1) && (agt.indexOf('spoofer')==-1) &&
                 (agt.indexOf('compatible')==-1) && (agt.indexOf('opera')==-1)  &&
                 (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1)     &&
                 (is_gecko) && (navigator.vendor=="Firebird"));
    var is_fx = ((agt.indexOf('mozilla/5')!=-1) && (agt.indexOf('spoofer')==-1) &&
                 (agt.indexOf('compatible')==-1) && (agt.indexOf('opera')==-1)  &&
                 (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1)     &&
                 (is_gecko) && ((navigator.vendor=="Firefox")||(agt.indexOf('firefox')!=-1)));
    var is_moz   = ((agt.indexOf('mozilla/5')!=-1) && (agt.indexOf('spoofer')==-1) &&
                    (agt.indexOf('compatible')==-1) && (agt.indexOf('opera')==-1)  &&
                    (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1)     &&
                    (is_gecko) && (!is_fb) && (!is_fx) &&
                    ((navigator.vendor=="")||(navigator.vendor=="Mozilla")||(navigator.vendor=="Debian")));
    var is_nav  = ((agt.indexOf('mozilla')!=-1) && (agt.indexOf('spoofer')==-1)
                && (agt.indexOf('compatible') == -1) && (agt.indexOf('opera')==-1)
                && (agt.indexOf('webtv')==-1) && (agt.indexOf('hotjava')==-1)
                && (!is_khtml) && (!(is_moz)) && (!is_fb) && (!is_fx));
    var is_ie   = ((appVer.indexOf('msie') != -1) && (!is_opera) && (!is_khtml));
	
