//-- Ajouter un ami --//
function ajouterAmi(id)
{
	ajax('get', 'pages/profil_ajax.php','act=ajouterAmi&id='+id, 'ajouterAmi2');
}
function ajouterAmi2(r)
{
	$('#details').html(unescape(r));
}

//-- Envoyer un message --//
function afficherFormMessage()
{
	ajax('get', 'pages/profil_ajax.php','act=writeMess', 'message2');
}
function message2(r)
{
	if ($('#details').html()=="")
	{
		$('#details').html(unescape(r));
		$("#details").BlindDown();
	}
	else
	{
		$("#details").BlindUp(700, function() { 
			$('#details').html(unescape(r));
			$("#details").BlindDown();
		});
	}
}
function sendMsg() {
	if ($('#sujet').val().length==0) { $('sujet').style.border='1px solid #FF7FB4'; }
	else if ($('#message').val().length==0) { $('message').style.border='1px solid #FF7FB4'; }
	else if ($('#dest_id').val()==0) { alert("Erreur dans la sélection du destinataire"); }
	else {
		_sujet=escape($('#sujet').val());
		_mess=escape($('#message').val());
		_dest=$('#dest_id').val();
		ajax('post', 'pages/_membre/messagerie_ajax.php?act=send_profil','sujet='+_sujet+'&mess='+_mess+'&dest='+_dest,"sendMsg3");
	}
}
function sendMsg3(r) {
	var verif = unescape(r).split('|:|');
	if(unescape(verif[0])!="ok") { alert('Erreur durant l\'envoie du message !'); }
	else {
		$('#details').html("<div style='margin-top:15px; text-align:center; font-weight:bold; color:#09F'>Votre message a été envoyé.</div>");
	}
}

function gbWrite() {
	
	$("#writeMessage").DropInDown(1000); 
	$("#imgMessage").fadeOut('fast');

}

function gbSend() {
	_mess=escape($('#messageBG').val());
	_id=escape($('#id_membre').val());
	
	if (_mess.length<10) { alert('Votre message est trop court !'); return false }
	if (_id==0) { alert('Erreur : destinataire inconnu'); return false }
	$('#sendGb').hide();
	$('#waitGb').show();
	ajax('post', 'pages/profil_ajax.php?act=guestbook_send','message='+_mess+'&id='+_id, 'gbSend2');

}

function gbSend2(r) {
	if (unescape(r)!="ok") { alert('Une erreur est survenue durant l\'envoie de votre message.'); }
	else {
		$('#imgMessage').html("<br /><br /><br /><br /><b>Votre message a été envoyé avec succés !</b><br /><br /><br /><br />");
		$("#imgMessage").fadeIn(1000); 
		$("#writeMessage").fadeOut('fast');
		
	}
	
}

//-- Notter une photo de la galerie
function noterPhoto(idPhoto, note)
{
	$("#vote"+idPhoto).html('<br /><u>Vote en cours</u>');
	ajax('post', 'pages/galerie-photo_ajax.php?act=noter_photo','idPhoto='+escape(idPhoto)+'&note='+escape(note), 'noterPhoto2');
}

function noterPhoto2(r)
{
	var verif = unescape(r).split('|:|');
	if (verif[0]!="+") { alert('Une erreur est survenue durant l\'enregistrement de votre vote.'); }
	else 
	{
			if (verif[3]>1) pluriel="s"; 
			else pluriel="";

		$("#note"+verif[1]).html("Note : <strong>"+verif[2]+"/5</strong> ( "+verif[3]+" vote"+pluriel+" )");
		$("#vote"+verif[1]).fadeOut(500);		
	}
	
}





// ############################################################
// SCRIPT BBCODE Version 2
// ############################################################

var imageTag = false;
var theSelection = false;
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version
var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);
var is_moz = 0;

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[quote]','[/quote]','[code]','[/code]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]','[-left]','[/-left]','[-center]','[/-center]','[-right]','[/-right]');


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}



function emoticon(text) {
	var txtarea = document.getElementById('messageBG');
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.getElementById('messageBG');

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.getElementById('messageBG');

	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			//buttext = eval('document.post.addbbcode' + butnumber + '.value');
			//eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}

	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				//buttext = eval('document.post.addbbcode' + butnumber + '.value');
				//eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return;
	} else { // Open tags

		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}

		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		//eval('document.post.addbbcode'+bbnumber+'.value += "*"');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
}

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}
