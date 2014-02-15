function infoAmi(id)
{
	
	ajax('get', 'pages/_membre/mes-amis_ajax.php', 'act=infos&id='+id, 'infoAmi2');
}

function infoAmi2(r)
{
	
	var infos = unescape(r).split('|:|');
		id = infos[0];
		info = infos[1];
	
	if (is_ie)	/* Spécial pour IE */
	{
		if (window.dejaOuvert!=undefined)
		{
			new Effect.Fade('liInfo'+window.dejaOuvert, { duration:1, afterFinish:function() { 
				new Insertion.After('li'+id, '<li id="liInfo'+id+'" style="display:none; height:135px">'+info+'</li>');
				new Effect.Appear('liInfo'+id+'', {duration:1.5});
			} } )
		}
		else
		{
			new Insertion.After('li'+id, '<li id="liInfo'+id+'" style="display:none; height:135px">'+info+'</li>');		
			new Effect.Appear('liInfo'+id+'', {duration:1.5});
		}
		

	}
	else       /* Et pour les autres */
	{
		if (window.dejaOuvert!=undefined)
		{
			new Effect.Phase('liInfo'+window.dejaOuvert, {duration:1});
		}
	
		new Insertion.After('li'+id, '<li id="liInfo'+id+'" style="display:none; height:135px">'+info+'</li>')
		
		// Redimentionne la taille de l'avatar
		redim('img'+id, 114, 130 );
		
		new Effect.Phase('liInfo'+id+'', {duration:1});
	}
	
		window.dejaOuvert=id;

}

function supprAmi(id)
{
	ajax('get', 'pages/_membre/mes-amis_ajax.php', 'act=suppr&id='+id, 'supprAmi2');
}

function supprAmi2(r)
{	
	var verif = unescape(r).split('|:|');
	if (verif[0]=="ok")
	{	
		id=verif[1];
		Element.remove('li'+id);
		$('liInfo'+id).innerHTML="<center style='color:#FF6600'>Ami retiré de votre liste</center>";
		$('liInfo'+id).style.height="28px";
	}
	else
	{
		alert("Erreur durant la suppression de cet ami.");
	}
}