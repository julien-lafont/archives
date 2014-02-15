// JavaScript Document

function calendrier(mois, annee, sens) {
	
	ajax('get', 'pages/coverage_ajax.php', 'mois='+escape(mois)+'&annee='+escape(annee)+'&sens='+escape(sens), 'calendrier_show');
	
}

function calendrier_show(res) {
	
	r=unescape(res).split('|:|');
	
	if(r[0]=="g") {
		$('#ap-calendrier').DropOutLeft(750, function() {
			$('#ap-calendrier').html(r[1]);
			$('#ap-calendrier').DropInRight(750);
		});
	}
	else
	{
		$('#ap-calendrier').DropOutRight(750, function() {
			$('#ap-calendrier').html(r[1]);
			$('#ap-calendrier').DropInLeft(750);
		});
		
	}
	
}


function toggle_futur() {
	
	if($('#coverage_futur').css('display')=="none") {
		$('#coverage_futur').BlindDown();
	}
	else
	{
		$('#coverage_futur').BlindUp();
	}
	
}

function toggle_passe() {
	
	if($('#coverage_ante').css('display')=="none") {
		$('#coverage_ante').BlindDown();
	}
	else
	{
		$('#coverage_ante').BlindUp();
	}
	
}