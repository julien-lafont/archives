
// Bloquer l'écriture des caractères spéciaux ( sauf certains autorisés : 'é,è,ù,ï,à,-'
function valid_mail(evt,type) {
	if (type==2) { var interdit = 'azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ -&*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\`\''; }
	else if (type==3) { var interdit = 'àâäãçéèêëìîïòôöõùûüñ&*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else if (type==4) { var interdit = ' azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ&*?!-:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else if (type==5) { var interdit = 'àâäãçéèêëìîïòôöõùûüñ &*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else { var interdit = '+àâäãçéèêëìîïòôöõùûüñ&*?!:;,\t#~"^%$£?²¤§%*@_.()[]{}<>|\\/`\''; }
	var keyCode = evt.which ? evt.which : evt.keyCode;
	if (keyCode==9) return true;
	if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) {
		return false;
	}
}
			// Affiche Image OK en fonction de la ligne
			function good(ligne) {
					img = document.createElement("img");
					img.src='theme/version1/images/bon2.png';
					/* Anti Bug Colspan=2 */ if (ligne <=9 ) colone=3*ligne-1; else colone=3*ligne;
					$('inscription').getElementsByTagName("td")[colone].innerHTML="";
					$('inscription').getElementsByTagName("td")[colone].appendChild(img);
			}
			// Affiche Image BAD + Message d'erreur en fonction de la ligne
			function bad(ligne,mess) {
					img = document.createElement("img");
					img.src='theme/version1/images/pasbon.jpg';
					img.setAttribute("style","vertical-align:middle"); 
					texte=document.createTextNode(" "+mess);
					
					/* Anti Bug Colspan=2 */ if (ligne <=9 ) colone=3*ligne-1; else colone=3*ligne;
					$('inscription').getElementsByTagName("td")[colone].innerHTML="";
					$('inscription').getElementsByTagName("td")[colone].appendChild(img);
					$('inscription').getElementsByTagName("td")[colone].appendChild(texte);
					
					$('inscription').getElementsByTagName("td")[colone].setAttribute("style","color:red;font-weight:normal; font-size:10px"); 
					/* pr IE */ if (document.all) { $('inscription').getElementsByTagName("td")[colone].style.setAttribute("cssText","color:red;font-weight:normal; font-size:10px; vertical-align:middle"); }
			}
			// Affiche une erreur dans le cadre ROUND
			function erreur(txt) {
				$('round').style.width="95%";
				$('round').style.backgroundColor="#ec5994";
				$('round').innerHTML="<b>Erreur :</b><br>"+txt+"";
				if(!NiftyCheck()) return; Rounded("div.round","all","#FFFFFF","#ec5994"," smooth");
				new Effect.Appear("round", {duration:.5});
			}

function verifCivilite() {
	if( $('civilite1').checked==true || $('civilite2').checked==true || $('civilite3').checked==true) good(1); 
	else bad(1,'Veuillez choisir votre civilité');
}

function verifNom() { 
	if ($F('nom').length!=0 ) good(2);
	else bad(2,"Champs obligatoire");
}

function verifPrenom() {
	if ($F('prenom').length!=0 ) good(3);
	else bad(3,"Champs obligatoire");
}

function verifDate() {
	
	 d=$F('naiss');
     e = new RegExp("^[0-9]{1,2}\/[0-9]{1,2}\/([0-9]{2}|[0-9]{4})$");
     j = parseInt(d.split("/")[0], 10);
     m = parseInt (d.split("/")[1], 10);
     a = parseInt(d.split("/")[2], 10);
     /* Année sur 2 chiffres -> on en met 4 */ if (a < 1000) { if (a < 35) { a+=2000; $('naiss').value=j+"/"+m+"/"+a; } else { a+=1900; $('naiss').value=j+"/"+m+"/"+a; } }
     /* Bixextille */if (a%4 == 0 && a%100 !=0 || a%400 == 0) fev = 29; else fev = 28;
	 nbJours = new Array(31,fev,31,30,31,30,31,31,30,31,30,31);
     //:: Les tests:: //
	 if (d == "") bad(4,"Champs obligatoire");
     if (!e.test(d)) bad(4,"Invalide jj/mm/aaaa");
     if( m >= 1 && m <=12 && j >= 1 && j <= nbJours[m-1] ) good(4);
	 else bad(4,"Invalide jj/mm/aaaa");

}

function verifAdresse() {
	
	if ($F('adresse').length!=0 ) {
		if ($F('adresse').length<=10 || $F('adresse').indexOf(" ")==-1 ) bad(5,"Invalide ( <10 caracts )");  /* rajouter présence ' ' */
		else good(5);
	} else {
		bad(5,"Champs obligatoire");
	}
}

function verifCp() {
	if ($F('cp').length==0 ) {
		bad(6,"Champs obligatoire");
	} else if ($F('cp').length<=4) {
		bad(6,"Invalide ( <5 chiffres )");
	} else {
		good(6);
	}
}

function verifVille() { 
	if ($F('ville').length!=0 ) good(7);
	else bad(7,"Champs obligatoire");
}

function verifPays() { 
	if ($F('pays').length!=0 ) good(8);
	else bad(8,"Champs obligatoire");
}

function verifTel() {
	if ($F('tel').length==0 ) {
		$('inscription').getElementsByTagName("td")[26].innerHTML="";
	} else if ($F('tel').length<=8) {
		bad(9,"Invalide ?");
	} else {
		good(9);
	}
}

function verifEmail() {
	
	var place = $F('mail').indexOf("@",1); var point = $F('mail').indexOf(".",place+1);
	if ((place > -1) && ($F('mail').length >2) && (point > 1) )  { 
		// Recherche si compte est déjà créé
		ajaxGetA('pages/version1/ajax_req.php?act=verif_email&email='+escape($F('mail')),'verifEmail2');   
	} else {
		bad(10,"Adresse invalide");
	}
}

function verifEmail2(result) {
	if (unescape(result)=="OK") good(10);
	else bad(10,"Email déjà enregistré");
}

function verifPass1() {
	if ($F('pass1').length==0 ) {
		bad(11,"Champs obligatoire");
	} else if ($F('pass1').length<=4) {
		bad(11,"Invalide ( <5 caracts )");
	} else {
		good(11);
	}
}

function verifPass2() {
	if ($F('pass2').length==0 ) {
		bad(12,"Champs obligatoire");
	} else if ($F('pass2').length<=4) {
		bad(12,"Invalide ( <5 caracts )");
	} else {
		if ($F('pass2')==$F('pass1')) { good(11); good(12); }
		else { bad(11,"MdP différents"); bad(12,""); }
	}
}

function verifAgree() {
	if($('agree').checked == false) { new Effect.Fade("send", { duration:.8});  new Effect.Fade("round", { duration:.8});}
	
	if($('agree').checked == true) { 
		verifCivilite();	verifNom();			verifPrenom();
		verifDate(); 		verifAdresse();		verifCp();
		verifVille();		verifPays();		verifTel();
		verifEmail();		verifPass1();		verifPass2();
	
			var coloneVerif=[2,5,8,11,14,17,20,23,30,33,36]; /* Les colones à vérifier */ var error=0
			for (var i=0; i<=10; i++) {
				// On vérifie la présence du good sur toutes les lignes 
				if ($('inscription').getElementsByTagName("td")[coloneVerif[i]].innerHTML.length!=42) { 
					error=1;
				}
			}
		if (error==1) { erreur("Le formulaire n'est pas correctement rempli<br> <b>> <a href='#' onClick='verifAgree(); return false' style='#6DE4FA'>RE-VERIFIER</a> <</b>"); }
		else { new Effect.Appear("send", { duration:.8}); new Effect.Fade("round", { duration:.8});}
	}
}

function verifSend() {
	
		// Affichage du message d'attente
		Element.hide('send');
		$('round').style.width="80%";
		$('round').style.backgroundColor="#00A8FF";
		$('round').innerHTML="<b>Informations en cours d'envoie...</b>";
		if(!NiftyCheck()) return; Rounded("div.round","all","#FFFFFF","#00A8FF"," smooth");
		new Effect.Appear("round", {duration:.5});

	// On met en variables les différents élements
	if ($F('civilite1')=="mr") civilite="Mr";
	else if ($F('civilite2')=="mme") civilite="Mme";
	else if ($F('civilite3')=="melle") civilite="Melle";
	nom=escape($F('nom'));
	prenom=escape($F('prenom'));
	naiss=escape($F('naiss'));
	adr=escape($F('adresse'));
	cp=escape($F('cp'));
	ville=escape($F('ville'));
	pays=escape($F('pays'));
	mail=escape($F('mail'));
	tel=escape($F('tel'));
	pass=escape($F('pass1'));
	
	ajaxPostA("pages/version1/ajax_req.php?act=inscription",'civ='+civilite+'&nom='+nom+'&prenom='+prenom+'&naiss='+naiss+'&adr='+adr+'&cp='+cp+'&ville='+ville+'&pays='+pays+'&tel='+tel+'&mail='+mail+'&pass='+pass,"verifSend2" )
	
}
function verifSend2(result) {
	if (unescape(result)=="OK") showPage('inscriptionOk');
	else { erreur("Une erreur est survenue durant l'envoie du formulaire"); }
}