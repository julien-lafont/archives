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


function $() {
 var elements = new Array();
 for (var i=0,len=arguments.length;i<len;i++) {
	 var element = arguments[i];
	if (typeof element == 'string') {
	   var matched = document.getElementById(element);
	   if (matched) {
			 elements.push(matched);
	   } else {
			var allels = (document.all) ? document.all : document.getElementsByTagName('*');
			var regexp = new RegExp('(^| )'+element+'( |$)');
			for (var i=0,len=allels.length;i<len;i++) if (regexp.test(allels[i].className)) elements.push(allels[i]);
		 }
	   if (!elements.length) elements = document.getElementsByTagName(element);
	   if (!elements.length) {
			elements = new Array();
			var allels = (document.all) ? document.all : document.getElementsByTagName('*');
			for (var i=0,len=allels.length;i<len;i++) if (allels[i].getAttribute(element)) elements.push(allels[i]);
		}
		if (!elements.length) {
			var allels = (document.all) ? document.all : document.getElementsByTagName('*');
		  for (var i=0,len=allels.length;i<len;i++) if (allels[i].attributes) for (var j=0,lenn=allels[i].attributes.length;j<lenn;j++) if (allels[i].attributes[j].specified) if (allels[i].attributes[j].nodeValue == element) elements.push(allels[i]);
	   }
	} else {
		 elements.push(element);
   }
}
 if (elements.length == 1) {
	 return elements[0];
 } else {
	return elements;
 }
}
