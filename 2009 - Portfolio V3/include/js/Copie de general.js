
//:: Tester navigateur :://
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



// ----------------------------------------------------------------------------------- //
// ----------------------- FONCTIONS GENERALES ---------------------------- //
// ----------------------------------------------------------------------------------- //

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
