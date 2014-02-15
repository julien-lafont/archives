
$(document).ready(function() {
	
	//
	// Effet sur les blocs de code
	//
	/*$('.syntaxhighlighter').live('mouseover mouseout', function(event) {
		  if (event.type == 'mouseover') {
			if (!$(this).attr('rel')) $(this).attr('rel', seekMaxWidth($("table", this)) + 10);
			if($(this).attr('rel')>618){
				$(this).stop(true,false)
						.css({zIndex:"99", position:"relative", overflow:"visible" })
						.animate({ width:$(this).attr('rel')+"px"}, {"duration": 1000,"easing":"easeOutBack"});
			}
		  } else {
			  $(this).stop(true,false)
				.animate({width:"100%"},{"duration":1000,"easing":"easeOutBack"});
		  }
	});*/
	
	
	//
	// Hover moving effect
	//
	$("#sidebar li a").hover(function() {	//On hover...
		$(this).find("span").stop().animate({ 
			marginLeft: "10" //Find the span tag and move it up 40 pixels
		}, 250);
	} , function() { //On hover out...
		$(this).find("span").stop().animate({
			marginLeft: "0" //Move the span back to its original state (0px)
		}, 250);
	});
	
	$(".nav ul li ul li a").hover(function() {	//On hover...
		$(this).find("span").stop().animate({ 
			marginLeft: "10" //Find the span tag and move it up 40 pixels
		}, 250);
	} , function() { //On hover out...
		$(this).find("span").stop().animate({
			marginLeft: "0" //Move the span back to its original state (0px)
		}, 250);
	});
	
	
	//
	// DropDown menu
	//
	$('.nav ul ul').css({display: 'none'});
	
	$('.nav ul li').hover(function(){
		$(this).find('ul:first').css({
			visibility: 'visible',
			display: 'none'
		}).fadeIn('1000');
	},
	function(){
		$(this).find('ul:first').css({
			visibility: 'hidden'
		});
	});
	
	
	//
	// Transformer un lien .submit en submission de formulaire 
	//
	$("a.submit").live('click', function(e) { 
		e.preventDefault();
		
		if ($(this).attr('rel')!='1') 
		{
			$(this).parents('form:first').submit();
			$(this).attr('rel', 1);
		}
		
	});
	
	//
	// Social Slider
	//
	$("ul.social_slider").hover(function() {
		$("ul.social_slider li").stop().animate({'margin-left':'-1px', 'padding-left':'5px'}, 500 ,'easeOutBounce'	);
	}, function() {
		$("ul.social_slider li").stop().animate({'margin-left':"-25px", 'padding-left':'0px', 'opacity':1}, 500 ,'easeOutBounce');
	});
	
	if (jQuery.support.opacity)
	{
		$("ul.social_slider li").hover(function() {
			$(this).fadeTo(200, 1);
			$(this).siblings().fadeTo(200, 0.6);
		}, function() {
			$(this).siblings().fadeIn();
		});
	}
	
	
	//
	// SmoothScroll
	//
	$('a.smooth').live('click', function(e) {
		e.preventDefault();
		$.scrollTo(getLinkTarget($(this).attr('href')), {speed:1000, axis:'y', easing:'easeOutQuint', offset:-10});
	});
	
	
	//
	// CV : Afficher les compétences qualifiées
	//
	$("#competences_qualifies").click(function(e) {
		e.preventDefault();
		if ($(".competences_texte:animated").length==0)
		{
			if($(".competences_texte:visible").length>0)
			{
				$(".competences_texte").stop().fadeOut(500);
				$(".competences_qualif").stop().fadeIn(500);
				$("#competences_qualifies span").text("Retourner aux compétences");
			}
			else
			{
				$(".competences_texte").stop().fadeIn(1000);
				$(".competences_qualif").stop().fadeOut(1000);		
				$("#competences_qualifies span").text("Afficher ces compétences qualifiées");
			}
		}
		
	});
	
	
	//
	// Scroller sur le bloc télécharger CV
	// 
	/*if(jQuery.isFunction(DIV_Scroll))*/ DIV_InitScroll();
    
	
	//
	// Lien imprimer CV
	//
	$("#imprimer_cv").click(function(e) {
		e.preventDefault;
		imprimer_cv();
		return false;
	});
	
	
	//
	// Module InFieldLabels sur les formulaires
	//
	if(jQuery.isFunction($.InFieldLabels)) $("label").inFieldLabels(); 
     
	
    //
	// Active les infobulles
	//
	if(jQuery.isPlainObject(jQuery.tooltip))  $('.tip').tooltip({ 
     	 delay:0,
         track: true,
         showURL: false,
         fade:true
     });
	
	
	//
	// Liens vers les articles du blog sur la homepage
	//
	$("#topArticlesResume article").click(function() {
		e.preventDefault();
		window.location.replace($(this).attr('rel'));
	});
	

	//
	// Folio : categories
	//
	_folio_last_call = -1;
	$("nav.folio a").click(function(e) { 
		
		e.preventDefault();
		
		var cat = $(this).attr('rel');
		var now = new Date().getTime();
		
		// Anti flood
		if (_folio_last_call > 0 && _folio_last_call > now - 1000)
		{
			console.log('kicked');
			return;
		}
		_folio_last_call = now;
		
		// Réafficher tout
		if ($(this).hasClass('active'))
		{
			// Liens
			$('nav.folio a').removeClass('active');
			
			// Créations
			$(".folio-list li").animate({height: '120px'}, { duration: 1000, easing:'easeInQuad'});
			$(".folio-list li:even").removeClass('odd').addClass('even');
			$(".folio-list li:odd").removeClass('even').addClass('odd');
		}
		
		// N'afficher que la catégorie sélectionnée
		else
		{
			// Sélectionne le lien de la catégorie
			$('nav.folio a').removeClass('active');
			$(this).addClass('active');
			
			// Affiche / cache les créations
			$(".folio-list li."+cat).animate({height: '120px'}, { duration: 1000, easing:'easeInQuad'});
			$(".folio-list li:not(."+cat+")").animate({height: '0px'}, { duration: 1000, easing:'easeOutQuad' });
			
			// Réaligne les odd/even
			$(".folio-list li."+cat+":even").removeClass('odd').addClass('even');
			$(".folio-list li."+cat+":odd").removeClass('even').addClass('odd');
		}
			
	});
	
	
	//
	// Folio: Lien Miniature
	//
	$(".miniature").hover(function() {
		$(".glass", this).stop().fadeTo(1000, 0.5);
	},
	function() { 
		$(".glass", this).stop().fadeTo(1000, 0.0);
	});

	if(typeof(jQueryNivo_loaded) != 'undefined')  $('#slider').nivoSlider({
		effect:'sliceDown', 
		slices:15,
		animSpeed:500,
		pauseTime:5000,
		startSlide:0, 
		directionNav:false, 
		directionNavHide:true,
		controlNav:true,
		controlNavThumbs:false,
		keyboardNav:true,
		pauseOnHover:true,
		manualAdvance:false,
		captionOpacity:0.8 
	});

	if(jQuery.isFunction(jQuery.fancybox)) $("a.fancy").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'easingIn'		:	'easeOutBack',
		'overlayOpacity':	0.8,
		'speedIn'		:	1500, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'autosScale'	:	true,
		'centerOnScroll':	true
	});

	
	
});


function DIV_InitScroll()
{
	var offset = $(".content").offset().left;
	var width = $(".content").width();
	var left =  (offset + width + 15 )+'px';
	
	//-- Prépare l'objet
	$("#bloc_telecharger_cv").css({ 
		position: 'absolute',
		top: '335px',
		left: left	
	});
	
	//-- Active le slide
	//O_DivScroll  = new DIV_Scroll('bloc_telecharger_cv');
	//if( O_DivScroll.Obj) IdTimer_2 = setInterval('DIV_CheckScroll()',100);
}


function seekMaxWidth(elems)
{
	var max=0;
	elems.each(function(i, elem){
		if ($(elem).width()>max) max = $(elem).width();
	});
	return max;
}

function getLinkTarget(href) 
{
  return href.substring(href.indexOf('#'));
}

function imprimer_cv()
{
	// Je kiff ce hack :)
	$('#iframe-impression').remove();
	jQuery('<iframe>', {
		 'id': 'iframe-impression',
		 'class': 'hide_size',
		 'src': '/uploads/cv-impression.pdf'
		}).appendTo("body");
}
	
	
