$(document).ready(function(){ 
	// Positionnement centré du div de chargement :
	if ( $('#chargement').css("top")=="0px") {
		
		$('#chargement').css( { top:'500px'});
	} 
	$('#lien1').click( function() { $('#lien1').Pulsate(400,2); });
	$('#lien2').click( function() { $('#lien2').Pulsate(400,2); });
	$('#lien3').click( function() { $('#lien3').Pulsate(400,2); });
	$('#menuinbox1').click( function() { $('#lien1').Pulsate(400,2); });
	$('#menuinbox2').click( function() { $('#lien2').Pulsate(400,2); });
	$('#menuinbox3').click( function() { $('#lien3').Pulsate(400,2); });
	
});

// Fonction générique : met à jour le contenu
function msgShow(result) {
	
		$('#messagerie').html(unescape(result));
		
		$('#messagerie').fadeTo(1000, 1);
		$('#chargement').fadeOut(1000);
	
}

//---- Liste les messages
function listeMsg() {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get', 'pages/_membre/messagerie_ajax.php','act=listemsg','msgShow');
	}  );
}
function listeHist() {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get','pages/_membre/messagerie_ajax.php','act=historique','msgShow');
	}  );
}

//---- Supprimer un message
function supprMp(id) {
	$('#chargement').fadeIn(700);
	ajax('get', 'pages/_membre/messagerie_ajax.php', 'act=supprmp&id='+escape(id),'supprMp2');
	
}
function supprMp2(r) {
	r=unescape(r);
	$('#chargement').fadeOut(700);
	if (r=="bad") {
		alert("Erreur durant la suppression du MP");
	} else {
		$("#tr"+r).remove();
	}
}
function supprDirect(id) {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get', 'pages/_membre/messagerie_ajax.php', 'act=supprmp&id='+escape(id),'supprDirect2');
	}  );
}
function supprDirect2(r) {
	r=unescape(r);
	if (r=="bad") {
		alert("Erreur durant la suppression du MP");
	} else {
		listeMsg();
	}
}

//---- Afficher un message
function viewMp(id) {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get','pages/_membre/messagerie_ajax.php','act=viewmp&id='+escape(id),'msgShow');
	}  );
}
function viewMpHist(id) {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get','pages/_membre/messagerie_ajax.php','act=viewmpHist&id='+escape(id),'msgShow');
	}  );
}

//---- Ecrire un message
function writeMsg() {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get','pages/_membre/messagerie_ajax.php','act=write','writeMsgAfficher');
	}  );
}
function writeMsgAfficher(r) {
	$('#messagerie').html(unescape(r));

	/*new Ajax.Autocompleter ("dest",
					"dest_update",
					_URL+"pages/_membre/messagerie_ajax.php?act=autocomplete",
					{
							method: "post",
							paramName: "dest",
							afterUpdateElement: ac_return
					});	*/


var fadeInSuggestion = function(suggestionBox, suggestionIframe) 
{
	$(suggestionBox).fadeTo(300,0.9);
};
var maj = function(d) {
	$("#dest_id").val(d.ID);
	$("#pseudo_ok").show();
};


$('#dest').Autocomplete(
	{
		source: _URL+"pages/_membre/messagerie_ajax.php?act=autocomplete",
		delay: 700,
		fx: {
			type: 'slide',
			duration: 100
		},
		autofill: false,
		helperClass: 'autocompleter',
		selectClass: 'selectAutocompleter',
		onShow : fadeInSuggestion,
		onSelect : maj,
		minchars: 1
	} );



	$('#messagerie').fadeTo(1000, 1);
	$('#chargement').fadeOut(1000);
	
}

function repondre(id) {
	$('#chargement').fadeIn(700);
	$('#messagerie').fadeTo(1000, 0.01,function() { 													   
		ajax('get','pages/_membre/messagerie_ajax.php','act=write&id='+escape(id),'msgShow');
	}  );
}

function sendMsg() {
	if ($('#sujet').val().length==0) { $('#sujet').css('border','1px solid #FF7FB4'); }
	else if ($('#mess').val().length==0) { $('#mess').css('border','1px solid #FF7FB4'); }
	else if ($('#dest_id').val()==0) { alert("Erreur dans la sélection du destinataire"); }
	else {
		sujett=escape($('#sujet').val());
		messs=escape($('#mess').val());
		destt=$('#dest_id').val();
		
		$('#in_chargement_txt').html("<b>Envoi en cours</b>");
		
		$('#chargement').fadeIn(700);
		$('#messagerie').fadeTo(1000, 0.01,function() { 													   
			ajax('post', 'pages/_membre/messagerie_ajax.php?act=write2','sujet='+sujett+'&mess='+messs+'&dest='+destt,"sendMsg3");
	}  );

	}
}
function sendMsg3(r) {
	var verif = unescape(r).split('-');
	if(unescape(verif[0])=="bad") { alert('Erreur durant l\'envoie du message !');  }
	else {
		$('#in_chargement_txt').html("");
		msgShow(unescape(r));
	}
}
function ac_return(field, item){
        var regex = new RegExp('[0123456789]*-idcache', 'i');
        var nomimage = regex.exec($(item).innerHTML);
        id = nomimage[0].replace('-idcache', '');
        $(field.name+'_id').value = id;
}
