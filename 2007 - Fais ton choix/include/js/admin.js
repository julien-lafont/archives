function proposition(statut, id) {
	ajax('get', 'pages/admin/propositions_ajax.php', 'action='+statut+'&id='+id, 'proposition2');
}

function proposition2(r) {
	if (unescape(r)=="bad") alert('ERREUR !!');
	else Element.remove('tr'+unescape(r));
		
}