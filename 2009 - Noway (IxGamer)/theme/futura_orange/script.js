$(document).ready(function(){ 

// Gestion du hover sur les liens titres
		$('#menu_top .hover').mouseover( function() { 
			nomm=this.src; l=nomm.length;
			this.src=nomm.substr(0, (l-4))+'_h.png';
		} );
		$('#menu_top .hover').mouseout( function() { 
			nomm=this.src; l=nomm.length;
			this.src=nomm.substr(0, (l-6))+'.png';
		} );	
		
		
	// Affichage du carrousel ( images défilantes )
	if ($("#mycarousel")) {
		jQuery("#mycarousel").jcarousel({ 
		 itemVisible:3,
		 itemScroll: 3,
		 buttonNextHTML:'<a href="#" id="mini_galerie_droite" onclick="return false"><img src="'+_URL+'images/mid_fleche_droite.png" class="jcarousel-next"/></a>',
		 buttonPrevHTML:'<a href="#" id="mini_galerie_gauche" onclick="return false"><img src="'+_URL+'images/mid_fleche_gauche.png" class="jcarousel-prev"/></a>'	 
		});
	}
});

		function afficher_nom(txt) {
			$('#fond_last').html(txt);
			if ( $('#fond_last').css('display')=="none" ) $('#fond_last').BlindDown(250);
		}
		function cacher_nom() {
			$('#fond_last:visible').css('display', 'none');
		}