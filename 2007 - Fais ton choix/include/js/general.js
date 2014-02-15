//:: Configuration :://
_URL='http://127.0.0.1/TopOuFlop/';
	_DUEL=_URL+'upload/duels/';
	_PHOTO=_URL+'upload/photos/';
	_MIN=_URL+'upload/minTheme/';
//-- Fin configuration --//

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


  //************************************************************************************************************* //
 //----- On répertorie dans un premier temps toutes les fonctions pour lesquelles jvs n'est pas obligatoire -----//
//************************************************************************************************************* //

if (activer_jvs==1) { // Version lite ?


	  // #################################################################### //
	 //          --------   Actions sur les Duels   --------                 //
	// #################################################################### //

	  //****************************//
	 //----- Afficher un duel -----//
	//****************************//
	
	function afficher_duel(action) {
		idEnCours=$('numDuel').innerHTML;
		
		// On prépare pour l'affichage d'un nouveau duel.
			new Effect.Fade('image1', { duration:0.5, from:1, to: 0.1}); 
			new Effect.Fade('image2', { duration:0.5, from:1, to: 0.1, afterFinish:function() {
				new Effect.Appear('waitImg1', { duration:0.5} );
				new Effect.Appear('waitImg2', { duration:0.5, afterFinish:function() { 
					ajax('get', 'pages/duel_ajax.php', 'act=afficher&action='+escape(action)+'&idCurrent='+escape(idEnCours), 'afficher_duel2');
				} } );
			} }); 
		
		
	}
	
	function afficher_duel2(r) {
		
		var doc = eval(unescape(r)); /* Données Json dans infosNews */
		
		// On précharge l'image wallpaper
		imgPreloader = new Image();
		imgPreloader2 = new Image();
		imgPreloader2.onload=function(){
			
		// On met à jour les noms et les deux barres de %
			$('numDuel').innerHTML=infosDuel.id;
			$('nom1').innerHTML=infosDuel.nom1;
			$('nom2').innerHTML=infosDuel.nom2;
			$('pourcentage1').innerHTML=infosDuel.note1+' %';
			$('pourcentage2').innerHTML=infosDuel.note2+' %';
			$('barre1').style.width=infosDuel.note1+"%";
			$('barre2').style.width=infosDuel.note2+"%";
			
			// Par défaut les deux images 'étoile' ne sont pas affichées.
			_etoile1="none";
			_etoile2="none"
				if 		(infosDuel.vote==1) { _etoile1="block"; $('statut_vote').innerHTML="<span style='font-size:10px'>Vous avez déjà voté !</span>"; }
				else if (infosDuel.vote==2) { _etoile2="block"; $('statut_vote').innerHTML="<span style='font-size:10px'>Vous avez déjà voté !</span>"; }
				else						{ $('statut_vote').innerHTML=""; }
			
			// On met à jour la première images
			$('lien1').href='voter_pour_'+infosDuel.nom1r+'-'+infosDuel.id+'-1.htm';
			$('lien1').setAttribute('onclick', 'voterDuel('+infosDuel.id+',1); return false');
			$('lien1').title='Vote pour '+infosDuel.nom1r;
			$('lien1').style.cursor="pointer";
			$('img1').src=_DUEL+infosDuel.img1;
			$('etoile1').style.display=_etoile1;
	
			// Puis la seconde
			$('lien2').href='voter_pour_'+infosDuel.nom2r+'-'+infosDuel.id+'-2.htm';
			$('lien2').setAttribute('onclick', 'voterDuel('+infosDuel.id+',2); return false');
			$('lien2').title='Vote pour '+infosDuel.nom2r;
			$('lien2').style.cursor="pointer";
			$('img2').src=_DUEL+infosDuel.img2;
			$('etoile2').style.display=_etoile2;
	
			// On cache les deux images wait
			$('waitImg1').style.display="none";
			$('waitImg2').style.display="none";
			
			// On s'occupe de la première flèche
			if (infosDuel.precedent==1) {
				$('lienFlG').href="#";
				$('lienFlG').setAttribute("onclick","afficher_duel(\'precedent\'); return false");
				$('lienFlG').title="Duel précédent !";
				$('lienFlG').style.cursor="pointer";
				$('imgFlG').setAttribute("onMouseOver","if (document.images) document.flG.src=\'theme/images/gauche_hover.png\'");
				$('imgFlG').setAttribute("onMouseOut", "if (document.images) document.flG.src=\'theme/images/gauche.png\'");
			} else {
				$('lienFlG').href="";
				$('lienFlG').setAttribute("onclick","return false");
				$('lienFlG').title="";
				$('lienFlG').style.cursor="default";
				$('imgFlG').setAttribute("onMouseOver","return false");
				$('imgFlG').setAttribute("onMouseOut","return false");
			}
			
			// Puis de la seconde
			if (infosDuel.suivant==1)  {
				$('lienFlD').href="#";
				$('lienFlD').setAttribute("onclick","afficher_duel(\'suivant\'); return false");
				$('lienFlD').title="Duel précédent !";
				$('lienFlD').style.cursor="pointer";
				$('imgFlD').setAttribute("onMouseOver","if (document.images) document.flD.src=\'theme/images/droite_hover.png\'");
				$('imgFlD').setAttribute("onMouseOut", "if (document.images) document.flD.src=\'theme/images/droite.png\'");
			} else {
				$('lienFlD').href="";
				$('lienFlD').setAttribute("onclick","return false");
				$('lienFlD').title="";
				$('lienFlD').style.cursor="default";
				$('imgFlD').setAttribute("onMouseOver","return false");
				$('imgFlD').setAttribute("onMouseOut","return false");
			}
			
				new Effect.Appear('image1', { from:0.1, to:1, duration:1} );
				new Effect.Appear('image2', { from:0.1, to:1, duration:1} );
				
				
		}
		imgPreloader.src = _DUEL+infosDuel.img1;
		imgPreloader2.src = _DUEL+infosDuel.img2;
	}

	  //******************************//
	 //----- Voter pour un duel -----//
	//******************************//

	function voterDuel(id, photo) {
		
		new Effect.Fade('image'+photo, { duration:0.5, from:1, to: 0.1, afterFinish:function() { 
			
			var Noeuds = $A( $('duel').getElementsByTagName('a') );
				Noeuds.each(function(noeud){
					noeud.onclick=function() { return false }; /* plus de vote */
					noeud.style.cursor="default";
			});
			
			new Effect.Appear('waitImg'+photo, { duration:0.5, afterFinish:function() { 
				ajax('get', 'pages/voter_ajax.php', 'act=voterDuel&idDuel='+id+'&gagnant='+photo, 'voterDuel2');
			}} );
			
		}} );
		
	}
	
	function voterDuel2(r) {
		
		var verif = unescape(r).split('|:|');
			statut=verif[0];
			
		// Cas double vote : message d'erreur
		if (statut=="error_ip") { 
			idVote=verif[1];
			new Effect.Fade('waitImg'+idVote, {duration:0.5} );
			//$('image'+idVote).innerHTML+="<div style=' color:#F00;'>Vous avez déjà voté !</div>";
			$('img'+idVote).src="images/doublevote.png";
			new Effect.Appear('image'+idVote);
			
		}
		// Erreur inconnue
		else if (statut!="ok") {
			alert('Une erreur est survenue durant l\'envoi de votre vote.\nSi le problème persiste, merci de prévenir un administrateur.');
		}
		// Vote ok 
		else
		{
			idDuel=verif[4];
			idVote=verif[3];
			note1=verif[1];
			note2=verif[2];
			
			pub=verif[5];
			
		   // On enlève le fading, on modifie les pourcentage
		   new Effect.Fade('waitImg'+idVote, {duration:0.5, afterFinish:function() { 
			 $('barre1').morph('width:'+note1+'%;',{duration:0.5});
			 $('barre2').morph('width:'+note2+'%;',{duration:0.5});
			 $('pourcentage1').innerHTML=note1+" %";
			 $('pourcentage2').innerHTML=note2+" %";
			 $('statut_vote').innerHTML="Vote effectué !";
			 $('indic'+idDuel).innerHTML="<b>&bull;</b>";
			 new Effect.Appear('image'+idVote, { duration:0.5, from:0.1, to: 1, afterFinish:function() { 
					new Effect.Appear('etoile'+idVote, {duration:0.5} );
					// Si nécessaire on affiche la pub et on lance le compte à rebour
					if (pub==1) setTimeout("Modalbox.show('Pause Publicitaire', 'pages/publicite.php', {width: 520, height:300, afterLoad:function() { lancer_decompte(); }});", 2000);
				} });
		   } } );
	
		}
	
	}
	
	// Gestion du compte à rebour pr la pub
	var decompteTps=10;
	function lancer_decompte() {
		x = window.setInterval('decompte()', 1000);	
	}
	function decompte() {
		if (decompteTps> 0)		document.getElementById('tps').innerHTML = --decompteTps;
		else 				{ 	window.clearInterval(x); Modalbox.hide(); }
	}
		
	  //**************************//
	 //----- Duels: divers -----//
	//************************//
		
		
		//**** Soumettre un duel ****//
		function afficher_soumettre() {
			if (Element.visible('liste_duels'))  new Effect.Phase('liste_duels');
			if (Element.visible('soumettreOk'))  new Effect.Phase('soumettreOk');
			if (!Element.visible('soumettre')) new Effect.Phase('soumettre');
		}
		function form_soumettre() {
			_idee1=escape($F('idee1'));
			_idee2=escape($F('idee2'))
			if (_idee1.length==0) $('idee1').style.border="1px solid #FF3300";
			else if (_idee2.length==0) $('idee2').style.border="1px solid #FF3300";
			else {
				$('wait3').style.display="block";
				
				_pseudo=escape($F('soum_pseudo'));
				_site=escape($F('soum_site'));
				
				ajax('get', 'pages/proposer_ajax.php', 'idee1='+_idee1+'&idee2='+_idee2+'&pseudo='+_pseudo+'&site='+_site, 'form_soumettre2');
			}
		}
		
		function form_soumettre2(r) {
			if (unescape(r)=="ok") {
				
				if (Element.visible('liste_duels'))   new Effect.Phase('liste_duels');
				if (Element.visible('soumettre')) 	  new Effect.Phase('soumettre');	
				if (!Element.visible('soumettreOk'))  new Effect.Phase('soumettreOk', { afterFinish:function() { 
					$('wait3').style.display="none";																							
				} });
			
			} else {
				alert('Une erreur est survenue durant l\'envoi de votre proposition.\nSi le problème persiste, merci de prévenir un administrateur.');
			}
		}
		
		function fin_soumission() {
			if (Element.visible('soumettreOk'))  	new Effect.Phase('soumettreOk');
			if (Element.visible('soumettre')) 		new Effect.Phase('soumettre');
			if (!Element.visible('liste_duels')) 	new Effect.Phase('liste_duels');
		}
	
	
	  // #################################################################### //
	 //          --------   Actions sur les Themes   --------                //
	// #################################################################### //
	
	
      //*****************************//
	 //----- Afficher un thème -----//
	//*****************************//

	// ***** Première ouverture d'un thème ***** //
	function ouvrir_theme(id) { 
		
		// Si un thème est déjà coloré on le remet normal
		if ($('themeId').innerHTML!=0) {
			idOpen=$('themeId').innerHTML;
			
			$('liTheme'+idOpen).firstChild.firstChild.style.border="1px solid #ccc";
			$('liTheme'+idOpen).firstChild.firstChild.style.padding="2px";
			$('liTheme'+idOpen).style.color="#666";
		} else {
			new Effect.Appear('theme_retour', { duration:0.5});	
			
		}
		
		// On colore la miniature ouverte
		$('liTheme'+id).firstChild.firstChild.style.border="3px solid #00A8FF";
		$('liTheme'+id).firstChild.firstChild.style.padding="0";
		$('liTheme'+id).style.color="#00A8FF";
		$('themeId').innerHTML=id;
		
		// On prépare pour l'affichage d'un nouveau duel.
		new Effect.Fade('image1', { duration:0.5, from:1, to: 0.1}); 
		new Effect.Fade('image2', { duration:0.5, from:1, to: 0.1, afterFinish:function() {
			new Effect.Appear('waitImg1', { duration:0.5} );
			new Effect.Appear('waitImg2', { duration:0.5, afterFinish:function() { 
				// On récupère tout ce dont on a besoin
				ajax('get', 'pages/theme_ajax.php', 'act=afficherFirst&id='+escape(id), 'ouvrir_theme2');
			} } );
		} }); 
	
		
	}
	
	function ouvrir_theme2(r) {
		var verif = unescape(r).split('|:|');
		nom=verif[0];
		id=verif[1];
		json=verif[2];
		liste=verif[3];
		nomr=verif[4];
		
		// On change le titre avec le nom du thème :
		$('nom_cat2').innerHTML='Thème : '+nom;
	
		// On affiche le duel :
			var doc = eval(json); /* Données Json dans infosNews */
		
			// On précharge l'image 
			imgPreloader = new Image();
			imgPreloader2 = new Image();
			imgPreloader2.onload=function(){
				
				// ON met à jour les noms et les deux barres de %
				$('nom1').innerHTML=infosDuel.nom1;
				$('nom2').innerHTML=infosDuel.nom2;
				$('pourcentage1').innerHTML=infosDuel.note1+' %';
				$('pourcentage2').innerHTML=infosDuel.note2+' %';
				$('barre1').style.width=infosDuel.note1+"%";
				$('barre2').style.width=infosDuel.note2+"%";
				
				// On met à jour la première image
				$('lien1').href='theme-'+nomr+'-voter_pour_'+infosDuel.nom1r+'-'+infosDuel.id1+'-'+id+'.htm';
				$('lien1').setAttribute('onclick', 'voterDuelTheme('+id+','+infosDuel.id1+','+infosDuel.id2+',1); return false');
				$('lien1').title='Vote pour '+infosDuel.nom1r;
				$('lien1').style.cursor="pointer";
				$('img1').src=_PHOTO+infosDuel.img1;
				$('etoile1').style.display='none';
				
				// Puis la seconde
				$('lien2').href='theme-'+nomr+'-voter_pour_'+infosDuel.nom2r+'-'+infosDuel.id2+'-'+id+'.htm';
				$('lien2').setAttribute('onclick', 'voterDuelTheme('+id+', '+infosDuel.id2+','+infosDuel.id1+',2); return false');
				$('lien2').title='Vote pour '+infosDuel.nom2r;
				$('lien2').style.cursor="pointer";
				$('img2').src=_PHOTO+infosDuel.img2;
				$('etoile2').style.display='none';
				
				// On enlève l'image 'patienter'
				$('waitImg1').style.display="none";
				$('waitImg2').style.display="none";
				
				// On enlève les actions sur la flèche gauche
				$('lienFlG').href="";
				$('lienFlG').setAttribute("onclick","return false");
				$('lienFlG').title="";
				$('lienFlG').style.cursor="default";
				$('imgFlG').setAttribute("onMouseOver","return false");
				$('imgFlG').setAttribute("onMouseOut","return false");
				
				// Idem sur la droite
				$('lienFlD').href="";
				$('lienFlD').setAttribute("onclick","return false");
				$('lienFlD').title="";
				$('lienFlD').style.cursor="default";
				$('imgFlD').setAttribute("onMouseOver","return false");
				$('imgFlD').setAttribute("onMouseOut","return false");
		
				$('statut_vote').innerHTML="";
				
					// On affiche les deux nouvelles images
					new Effect.Appear('image1', { duration:1} );
					new Effect.Appear('image2', { duration:1, afterFinish:function() { 		
						
						// Puis on affiche le classement
						new Effect.DropOut('liste_duels', {duration:1, afterFinish:function() { 
							$('liste_duels').innerHTML=liste;
							$('liste_duels').style.overflow ="scroll";
							new Effect.BlindDown('liste_duels', {duration:1});
						} });
						
					} } );
			}
			imgPreloader.src = _PHOTO+infosDuel.img1;
			imgPreloader2.src = _PHOTO+infosDuel.img2;
		
	}
		
	//***** Affiche un nouveau duel , la catégorie thème étant déjà ouverte *****//
	function afficher_duel_theme(infosDuel, _nomTheme) { 
		infos=unescape(infosDuel);
		
		$('statut_vote').innerHTML='';
		
		// On prépare pour l'affichage d'un nouveau duel.
		new Effect.Fade('image1', { duration:1, from:1, to: 0.1}); 
		new Effect.Fade('image2', { duration:1, from:1, to: 0.1, afterFinish:function() {
	
			// On affiche le duel :
			var doc = eval(infos); /* Données Json dans infosNews */
		
			// On précharge l'image 
			imgPreloader = new Image();
			imgPreloader2 = new Image();
			imgPreloader2.onload=function(){
				
				// On vire le focus à la barbare ^^
				document.formBlur.web.focus();
				
				// On met à jour les noms et les deux barres de %
				$('nom1').innerHTML=infosDuel.nom1;
				$('nom2').innerHTML=infosDuel.nom2;
				$('pourcentage1').innerHTML=infosDuel.note1+' %';
				$('pourcentage2').innerHTML=infosDuel.note2+' %';
				$('barre1').style.width=infosDuel.note1+"%";
				$('barre2').style.width=infosDuel.note2+"%";
							
				
				// On met à jour la première image
				$('lien1').href='theme-'+_nomTheme+'-voter_pour_'+infosDuel.nom1r+'-'+infosDuel.id1+'-'+infosDuel.idTheme+'.htm';
				$('lien1').setAttribute('onclick', 'voterDuelTheme('+infosDuel.idTheme+','+infosDuel.id1+','+infosDuel.id2+',1); return false');
				$('lien1').title='Vote pour '+infosDuel.nom1r;
				$('lien1').style.cursor="pointer";
				$('img1').src=_PHOTO+infosDuel.img1;
				$('etoile1').style.display='none';
				
				// Puis la seconde
				$('lien2').href='theme-'+_nomTheme+'-voter_pour_'+infosDuel.nom2r+'-'+infosDuel.id2+'-'+infosDuel.idTheme+'.htm';
				$('lien2').setAttribute('onclick', 'voterDuelTheme('+infosDuel.idTheme+', '+infosDuel.id2+','+infosDuel.id1+',2); return false');
				$('lien2').title='Vote pour '+infosDuel.nom2r;
				$('lien2').style.cursor="pointer";
				$('img2').src=_PHOTO+infosDuel.img2;
				$('etoile2').style.display='none';
	
				$('waitImg1').style.display="none";
				$('waitImg2').style.display="none";
				
				//$('fleche_gauche').innerHTML='<img src="theme/images/gauche.png" />';
				//$('fleche_droite').innerHTML='<img src="theme/images/droite.png" />';
		
				new Effect.Appear('image1', { duration:1.5} );
				new Effect.Appear('image2', { duration:1.5} );
			}
			imgPreloader.src = _PHOTO+infosDuel.img1;
			imgPreloader2.src = _PHOTO+infosDuel.img2;
	
		} }); 
	
	}
	
	  //*******************************//
	 //----- Voter pour un thème -----//
	//*******************************//

	function voterDuelTheme(idTheme, idGagnant, idPerdant, photo1ou2) {
			
		new Effect.Fade('image'+photo1ou2, { duration:0.5, from:1, to: 0.1, afterFinish:function() { 
			
			var Noeuds = $A( $('duel').getElementsByTagName('a') );
				Noeuds.each(function(noeud){
					noeud.onclick=function() { return false }; /* plus de vote */
					noeud.style.cursor="default";
			});
			
			new Effect.Appear('waitImg'+photo1ou2, { duration:0.5, afterFinish:function() { 
				ajax('get', 'pages/theme_ajax.php', 'act=voterDuel&idGagnant='+escape(idGagnant)+'&idTheme='+escape(idTheme)+'&win1ou2='+escape(photo1ou2)+'&idPerdant='+escape(idPerdant), 'voterDuelTheme2');
			}} );
			
		}} );
	
	}
	
	function voterDuelTheme2(r) {
		
		var verif = unescape(r).split('|:|');
			statut=verif[0];
			
		if (statut=="error_ip") {
			idVote=verif[1];
			new Effect.Fade('waitImg'+idVote, {duration:0.5} );
			//$('image'+idVote).innerHTML+="<div style=' color:#F00;'>Vous avez déjà voté !</div>";
			$('img'+idVote).src="images/doublevote.png";
			new Effect.Appear('image'+idVote);
			
		}
		else if (statut!="ok") {
			alert('Une erreur est survenue durant l\'envoi de votre vote.\nSi le problème persiste, merci de prévenir un administrateur.');
		}
		else
		{
			idVote=verif[1];
			
			if (idVote==1) { note1=verif[2]; note2=verif[3]; }
			else		   { note1=verif[3]; note2=verif[2]; }
			
			newDuel=verif[4];
			_nomTheme=verif[5];
		   
		   new Effect.Fade('waitImg'+idVote, {duration:0.5, afterFinish:function() { 
			 
				 $('barre1').morph('width:'+note1+'%;',{duration:0.5});
				 $('barre2').morph('width:'+note2+'%;',{duration:0.5});
				 $('pourcentage1').innerHTML=note1+" %";
				 $('pourcentage2').innerHTML=note2+" %";
			
			 $('statut_vote').innerHTML="Vote effectué !<br /><br /><br /><br /><span style='color:#666; font-size:11px; font-weight:normal'>Chargement en cours</span><br /><img src='images/loading.gif' />";
			 new Effect.Appear('image'+idVote, { duration:0.5, from:0.1, to: 1, afterFinish:function() { 
					new Effect.Appear('etoile'+idVote, {duration:0.5} ); 
					setTimeout('afficher_duel_theme(\''+escape(newDuel)+'\', \''+escape(_nomTheme)+'\');',5000);
			 } });
		   } } );
	
		}
	
	}
	
	  //**************************//
	 //----- Thème : divers -----//
	//**************************//

		// **** Mise à jour du classement ****//
		function maj_liste_theme() {
			_idTheme=$('themeId').innerHTML;
			ajax('get', 'pages/theme_ajax.php', 'act=refreshListe&idTheme='+escape(_idTheme), 'maj_liste_theme2');
			
		}
		
		function maj_liste_theme2(r) {
			
			liste=unescape(r);
			// Puis on affiche le classement
			new Effect.DropOut('liste_duels', {duration:1, afterFinish:function() { 
				$('liste_duels').innerHTML=liste;
				//$('liste_duels').style.overflow ="scroll";
				new Effect.BlindDown('liste_duels', {duration:1});
			} });
		
			
		}
	


	  //********************************************//
	 //----- AFFICHER/MASQUER les blocs ajax  -----//
	//********************************************//


	function afficher_concours() {
		new Effect.Phase('inTablePrincipal', { duration:1, afterFinish:function() { 
			new Effect.Phase('concours', { duration:1 });
		} });
	}
	function afficher_webmaster() {
		new Effect.Phase('inTablePrincipal', { duration:1, afterFinish:function() {
			new Effect.Phase('webmaster', { duration:1 });
		} });
	}
	function afficher_principe() {
		if (Element.visible('concours')) new Effect.Phase('concours', { duration:1.5 });
		if (Element.visible('webmaster')) new Effect.Phase('webmaster', { duration:1.5 });
		if (Element.visible('principeC')) new Effect.Phase('principeC', { duration:1.5 });
		if (Element.visible('inTablePrincipal') )
		{
			new Effect.Phase('inTablePrincipal', { duration:1, afterFinish:function() { 
				new Effect.Phase('principeC', { duration:1 });
			} });
		}
		else
		{
			new Effect.Phase('principeC', { duration:1 });
		}
	}
	
	function afficher_principal(){
		if (Element.visible('concours')) new Effect.Phase('concours', { duration:1.5 });
		if (Element.visible('webmaster')) new Effect.Phase('webmaster', { duration:1.5 });
		if (Element.visible('principeC')) new Effect.Phase('principeC', { duration:1.5 });
		new Effect.Phase('inTablePrincipal', { duration:1.5 });
	}

	function montrer_classement() {
		$('wait3').style.display="block";
		ajax('get', 'pages/membre_ajax.php', 'act=classement', 'afficher_classement');
	}
	function afficher_classement(r) {
		r=unescape(r);
		
		if (!Element.visible('kdo_lien1')) new Effect.Appear('kdo_lien1', {duration:0.3}); 
		new Effect.Fade('kdo_lien2', {duration:0.3});
		if (!Element.visible('kdo_lien3')) new Effect.Appear('kdo_lien3', {duration:0.3});
		
		new Effect.BlindUp('kdos', {duration:0.7});
		new Effect.BlindUp('concours', {duration:0.7, afterFinish:function() { 
			$('classement').innerHTML=r;
			new Effect.BlindDown('classement', {duration:1, afterFinish:function() { 
				$('wait3').style.display="none";
			} });
		} });
		
	}

}

// ************************* FIN version -> Si Javascript activé <- ***************************** //
// ********************* Les fonctions suivantes sont toujours accessibles ********************** //

	  //*************************//
	 //----- Espace Membre -----//
	//*************************//

	function login() {
		$('wait3').style.display="block";
		
		_email=$F('email');
		if (_email.length<=5) 
		{
			$('email').style.borderColor="#FF6633";
		}
		else
		{
		   
		   var arobase = _email.indexOf("@")
		   var point = _email.lastIndexOf(".")
		   if ((arobase < 3)||(point + 2 > _email.length) ||(point < arobase+3)) 
		   {
			   $('email').style.borderColor="#FF6633";
			   $('wait3').style.display="none";
		   } 
		   else 
		   {
				ajax('get', 'pages/membre_ajax.php', 'act=connexion&email='+escape(_email), 'login2');	
		   }
		}
	}
	
	function login2(r) {
		
		var verif = unescape(r).split('|:|');
			statut=verif[0];
			points=verif[1];
			pos=verif[2];
			
		new Effect.Fade('form_log_email', { duration:0.5, afterFinish:function() { 
			if (points==0) {
				$('form_log_email').innerHTML='<table id="tableStats"><tr><td><u>Merci de vous être connecté</u><br /><br />Toutes vos actions seront maintenant comptabilisées.</td><td style="width:16px;"><a href="#" class="no"><img src="images/recur.png" /></a><br /><a href="#" class="no"><img src="images/configure.png" /></a><br /><a href="#" onclick="deconnexion(); return false" class="no" title="Me déconnecter"><img src="images/aim_online.png" /></a></td></tr></table>';
			} else {
				if (pos==1) position="1ère";
				else position=pos+"ème";
				$('form_log_email').innerHTML='<table id="tableStats"><tr><td><u>Mes Stats</u> <br /><br /><b id="nbPoints">'+points+'</b> points <br /><b id="position">'+position+'</b> position </td><td style="width:16px;"><a href="#" onclick="refreshScore(); return false" class="no" title="Mettre à jour mes Stats"><img src="images/recur.png" /></a><br /><img src="images/configure.png" style="opacity:0.5" /><br /><a href="#" onclick="deconnexion(); return false" class="no" title="Me déconnecter"><img src="images/aim_online.png" /></a></td></tr></table>';
			}
			new Effect.Appear('form_log_email', { duration:1 } );
			$('wait3').style.display="none";
		} } );
	}
		
	function deconnexion() {
		$('wait3').style.display="block";
		ajax('get', 'pages/membre_ajax.php', 'act=deconnexion', 'deconnexion2');	
	}
	function deconnexion2() {
		$('form_log_email').innerHTML='<legend style="color:#666"><span style="color:#0099FF">G</span>agner des Kdos</legend>  <i style="color:#F60">Vous n\'êtes plus connecté !</i><br /><input type="text" name="email" id="email" class="form_email" value="Entrez votre email" onclick="if (this.value==\'Entrez votre email\') this.value=\'\';"/>&nbsp;&nbsp;<a href="#" onclick="login(); return false">OK</A>';
		$('wait3').style.display="none";
	}
	
	function refreshScore() {
		$('wait3').style.display="block";
		ajax('get', 'pages/membre_ajax.php', 'act=refresh', 'refreshScore2');
	}
	
	function refreshScore2(r) {
		var verif = unescape(r).split('|:|');
		score=verif[0];
		pos=verif[1];
		
		if (pos==1) position="1ère";
		else position=pos+"ème";
	
		$('nbPoints').innerHTML=score;
		$('position').innerHTML=position;
		$('wait3').style.display="none";
	
	}
	
	  //*****************************//
	 //----- Listage des duels -----//
	//*****************************//
	
	function liste_suivant() {
		
		dernierDuel=$('last_duel').innerHTML;
		ajax('get', 'pages/duel_ajax.php', 'act=liste&dernier='+escape(dernierDuel)+'&ordre=suivant', 'afficher_liste');
		
	}
	function liste_precedent() {
		
		premierDuel=$('first_duel').innerHTML;
		ajax('get', 'pages/duel_ajax.php', 'act=liste&premier='+escape(premierDuel)+'&ordre=precedent', 'afficher_liste');
		
	}
	function afficher_liste(r) {
		var verif = unescape(r).split('|:|');
		premier=verif[0];
		dernier=verif[1];
		liste=verif[2];
		
		$('first_duel').innerHTML=premier;
		$('last_duel').innerHTML=dernier;
		new Effect.DropOut('liste_duels', {duration:1, afterFinish:function() { 
			$('liste_duels').innerHTML=liste;	
			new Effect.BlindDown('liste_duels', {duration:1});
		} });
	
	}

	function montrer_stats() {
		
		new Effect.Fade('kdo_lien1', {duration:0.3}); 
		if (!Element.visible('kdo_lien2')) new Effect.Appear('kdo_lien2', {duration:0.3});
		if (!Element.visible('kdo_lien3')) new Effect.Appear('kdo_lien3', {duration:0.3});
		
		new Effect.BlindUp('classement', {duration:0.7});
		new Effect.BlindUp('concours', {duration:0.7, afterFinish:function() { 
			new Effect.BlindDown('kdos', {duration:1});	
		} });
	
	}
	
	

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

