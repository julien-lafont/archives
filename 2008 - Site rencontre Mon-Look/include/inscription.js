function ChangeStatut(formulaire) {
	if(document.getElementById("agree").checked == true) { document.getElementById("send").style.display="block"; }
    if(document.getElementById("agree").checked == false) { document.getElementById("send").style.display="none"; }
}
		
function block(evt,type) {
	if (type==3) { /* ALL - Espace*/ var interdit = 'àâäãçéèêëìîïòôöõùûüñ& +=.µ¨~@*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else if (type==4) { /* Only NUMBER */ var interdit = ' azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ&+=.µ¨~@*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else if (type==5) /* Email */{ var interdit = 'àâäãçéèêëìîïòôöõùûüñ&+=µ¨~*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	else { /* ALL + Espace*/ var interdit = 'àâäãçéèêëìîïòôöõùûüñ&+=.µ¨~@*?!:;,\t#~"^%$£?²¤§%*()[]{}<>|\\/`\''; }
	var keyCode = evt.which ? evt.which : evt.keyCode;
	if (keyCode==9) return true;
	if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) {
		return false;
	}
}

function verif()
	{
	erreur=0;
			
	if (document.myform.pseudo.value=="") {
		alert("Vous devez vous choisir un pseudo !");
		window.document.myform.pseudo.focus();
		erreur=1; }
		
	if (document.myform.pass1.value=="") {
		alert("Veuillez entrer un mot de passe !");
		window.document.myform.pass1.focus();
		erreur=1; }
	if (document.myform.pass2.value=="") {
		alert("Veuillez confirmer votre mot de passe !");
		window.document.myform.pass2.focus();
		erreur=1; }
	if (document.myform.pass2.value!=document.myform.pass1.value) {
		alert("Les deux mots de passe ne sont pas identiques !");
		window.document.myform.pass1.focus();
		erreur=1; }

	if (document.myform.email.value=="") {
		alert("Veuillez entrer votre adresse email !");
		window.document.myform.email.focus();
		erreur=1; }
	if (document.myform.prenom.value=="") {
		alert("Veuillez entrer votre prénom !");
		window.document.myform.prenom.focus();
		erreur=1; }
	if (document.myform.age.value=="") {
		alert("Veuillez entrer votre age !");
		window.document.myform.age.focus();
		erreur=1; }

	if (erreur==0) {
		document.myform.submit();
	} 
}