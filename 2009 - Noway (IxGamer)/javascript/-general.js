// antibug IE7 + Vista : réactivation des return false
$(document).ready(function(){ 
	$("a[@onclick~='return false']").click( function() { return false; } );
});

function show_flash(w, h, swf, color, fvar) {
    document.write("<object class=\"flash\" type=\"application/x-shockwave-flash\" data=\"" + swf + "\" width=\"" + w + "\" height=\"" + h + "\">");
    document.write("<param name=\"movie\" value=\"" + swf + "\" />");
    document.write("<param name=\"allowScriptAccess\" value=\"sameDomain\" />");
    document.write("<param name=\"pluginurl\" value=\"http://www.macromedia.com/go/getflashplayer\" />");
    document.write("<param name=\"wmode\" value=\"transparent\" />");
    document.write("<param name=\"bgcolor\" value=\"" + color + "\" />");
    document.write("<param name=\"menu\" value=\"false\" />");
    document.write("<param name=\"quality\" value=\"best\" />");
    document.write("<param name=\"scale\" value=\"exactfit\" />");
    document.write("<param name=\"flashvars\" value=\"" + fvar + "\" />");
    document.write("</object>");
}

function fenetreNouveauMessage(nb) 
{
	$("#window").css({height:'155px', width:'270px'});
	$('#windowContent').css({height:'100px', width:'230px'});
	$("#windowContent").html("<div style='padding:10px; font-size:12px; font-family:verdana; color:#333; text-align:center'><div style='color:#00A8FF; font-weight:bold' id='newMess'>Vous avez un nouveau message </div><br />Allez vite le lire depuis votre <br /><a href='"+_URL+"membre/messagerie/' style=\'color:#FF9900; font-size:12px\'>messagerie personelle</a></div>");
	ouvrirFenetreTransfert('header');

}

// Connexion automatique 
function loginAjax() 
{
	$('#status_log').html("<img src='images/indicator2.gif' style='vertical-align:middle'/> Vérification");
	$('#status_log').css('display',"inline");
	$('#status_log').css('color',"#0066FF");

	_login=escape($('#log_login').val());
	_pass=escape($('#log_pass').val());
	//_currentPath=escape($('ajax_path').html());
	
	ajax('post', 'pages/ajax/connexion.php', 'login='+_login+'&pass='+_pass, 'loginAjaxAction');
	
}

function loginAjaxAction(r)
{
	var verif = unescape(r).split('|:|');
	if (verif[0]=="+") {
			$('#menu_log').html(verif[2]);
			
			if (window.location.hash=="#invite") { 
				if (rediriger0.lenght!=0) 
					naviguer_forum(rediriger0, rediriger1,0);	   
				else history.go(-1);
				rediriger0=null;
			}
			
		if (verif[1]!=0) {  fenetreNouveauMessage(verif[1]); }
				
	}
	else
	{		
		$('#status_log').html("Identifiants incorrects");
		$('#status_log').css('display',"inline");
		$('#status_log').css('color',"#FF0066");
	}

}


//:: Controle les caractères tappés par l'utilisateur dans un formulaire :://
function valid(evt,type) {
	if      (type=="alphanum")  var interdit = ' +àâäãçéèêëìîïòôöõùûüñ&*?!:;,\t#~"^%$£?²¤§*@°¨µ=.()[]{}<>|\\/`\''; 
	else if (type=="site")		var interdit = '+àâäãçéèêëìîïòôöõùûüñ*!;,\t#"=^$£²¤§%*@°¨µ()[]{}<>|\`\''; 
	else if (type=="num") 		var interdit = '+azertyuiopqsdfghjklmnbvcxwAZERTYUIOPMLKJHGFDSQWXCVBNàâäãçéèêëìîïòôöõùûüñ&*?@_ =!-:;,\t#~"^$£?²¤§%*°¨µ()[]{}<>|\\/`\''; 
	else if (type=="email") 	var interdit = '+àâäãçéèêëìîïòôöõùûüñ= &*?!:;,\t#~"^%$£?²¤§*°¨µ()[]{}<>|\\/`\''; 
	else 						var interdit = '+àâäãçéèêëìîïòôöõùûüñ=&*?!:;,\t#~"^%$£?²¤§*°¨µ@_.()[]{}<>|\\/`\''; 
	var keyCode = evt.which ? evt.which : evt.keyCode;
	if (keyCode==9 || keyCode==71) return true;
	if (interdit.indexOf(String.fromCharCode(keyCode)) >= 0) {
		return false;
	}
}
// Cache le status 'Identifiants incorrects' si nécessaire :
function hideStatus() 
{
	if ($('status_log').style.display!="none" && $('status_log').style.display!="")
	{
		$('status_log').style.display="none";
		$('log_login').style.border="1px solid #c5c7cb";
		$('log_pass').style.border="1px solid #c5c7cb";
	}
}


// Utilise les fonctions PHP pour mettre un style aux textes ( appel en synchrone, ne pas en abuser )
function miseEnForme(type, txt) 
{
	return ajaxPost('pages/ajax/miseenforme.php', 'type='+escape(type)+'&txt='+escape(txt));
}

function scrollSimple() {
	return true; // koi ??? 
}

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

// Fonction POST a délaissée ( POST en Synchrone )
function ajaxPost(fichier,variable)
{
	if(window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if(window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
		return(false);
	xhr_object.open("POST", _URL+fichier, false);
	xhr_object.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=iso-8859-1');
	xhr_object.send(variable);
	if(xhr_object.readyState == 4) return(xhr_object.responseText);
	else return(false);
}


// Equivalent perso de isset( )
function isset(varname){
  return (typeof(varname)!='undefined');
}

// Tester navigateur
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
	



/**
 *
 * Can show a tooltip over an element
 * Content of tooltip is the title attribute value of the element
 * Tested with Firefox, IE6, IE5.5, IE7, Konqueror
 *
 */


// the tooltip object
var tooltip = {
    // setup properties of tooltip object
    id:"tooltip",
    offsetx : 10,
    offsety : 10,
    _x : 0,
    _y : 0,
    _tooltipElement:null,
    _saveonmouseover:null,
	width:0,
	position:null
}

/**
* Open ToolTip. The title attribute of the htmlelement is the text of the tooltip
* Call this method on the mouseover event on your htmlelement
*/
tooltip.show = function (htmlelement, text /*, style */ /*, positionBulle */) {

	if ( arguments.length==3 ) var style = arguments[2];
	if ( arguments.length==4 ) this.position = arguments[3];
	else 					   this.position="droite";

    // we save text of title attribute to avoid the showing of tooltip generated by browser
    /*var text=htmlelement.getAttribute("title");
    htmlelement.setAttribute("title","");
    htmlelement.setAttribute("title_saved",text);*/

	if(document.getElementById){
        this._tooltipElement = document.getElementById(this.id);
	}else if ( document.all ) {
        this._tooltipElement = document.all[this.id].style;
	}

	if (style=="big") {
		this._tooltipElement.style.width="200px";	
		this._tooltipElement.style.height="100px";
		this.width=200;
		$("#"+this.id).css('backgroundImage', 'url(theme/images/fond-bulle2BIG.png)');

	}
	else 
	{
		this._tooltipElement.style.width="144px";		
		this._tooltipElement.style.height="70px";
		this.width=144;
		$("#"+this.id).css('backgroundImage', 'url(theme/images/fond-bulle2.png)');
	}
	
    this._saveonmouseover = document.onmousemove;
    document.onmousemove = this.mouseMove;

    this._tooltipElement.innerHTML = text;

    this.moveTo(this._x + this.offsetx , this._y + this.offsety);

    if(this._tooltipElement.style){
        this._tooltipElement.style.visibility ="visible";
    }else{
        this._tooltipElement.visibility = "visible";

		
    }
	

   return false;
}

/**
* hide tooltip
* call this method on the mouseout event of the html element
* ex : <div id="myHtmlElement" ... onmouseout="tooltip.hide(this)"></div>
*/
tooltip.hide = function (htmlelement) {
   /* htmlelement.setAttribute("title",htmlelement.getAttribute("title_saved"));
    htmlelement.removeAttribute("title_saved");*/

    if(this._tooltipElement.style){
        this._tooltipElement.style.visibility ="hidden";
    }else{
        this._tooltipElement.visibility = "hidden";
    }
    document.onmousemove=this._saveonmouseover;
}



// Moves the tooltip element
tooltip.mouseMove = function (e) {
   // we don't use "this" because this method is assign to an event of document
   // and so is dereferenced
    if(e == undefined)
        e = event;

    if( e.pageX != undefined){ // gecko, konqueror,
        tooltip._x = e.pageX;
        tooltip._y = e.pageY;
    }else if(event != undefined && event.x != undefined && event.clientX == undefined){ // ie4 ?
        tooltip._x = event.x;
        tooltip._y = event.y;
    }else if(e.clientX != undefined ){ // IE6,  IE7, IE5.5
        if(document.documentElement){
            tooltip._x = e.clientX + ( document.documentElement.scrollLeft || document.body.scrollLeft);
            tooltip._y = e.clientY + ( document.documentElement.scrollTop || document.body.scrollTop);
        }else{
            tooltip._x = e.clientX + document.body.scrollLeft;
            tooltip._y = e.clientY + document.body.scrollTop;
        }
    }else{
        tooltip._x = 0;
        tooltip._y = 0;
    }
    tooltip.moveTo( tooltip._x +tooltip.offsetx , tooltip._y + tooltip.offsety);
	$('#tooltip').css('display', 'block');

}

// Move the tooltip element
tooltip.moveTo = function (xL,yL) {
	
	if (this.position=="droite") { xL=xL; yL=yL }
	else if (this.position=="gauche") xL=xL-this.width;
	else if (this.position=="centre") { xL=xL-(this.width/2); yL=yL+10 }
	
	
    if(this._tooltipElement.style){
        this._tooltipElement.style.left = xL +"px";
        this._tooltipElement.style.top = yL +"px";
    }else{
        this._tooltipElement.left = xL;
        this._tooltipElement.top = yL;
    }
}



	function getScroll()
	{
		if (navigator.appName == "Microsoft Internet Explorer")
		{
	//		return document.body.scrollTop;
			return document.documentElement.scrollTop
		}
		else
		{
			return window.pageYOffset;
		}
	}


function modalDialogShow_IE(url,width,height) //IE
	{
	return window.showModalDialog(url,window,
		"dialogWidth:"+width+"px;dialogHeight:"+height+"px;edge:Raised;center:Yes;help:No;Resizable:Yes;Maximize:Yes");
	}
function modalDialogShow_Moz(url,width,height) //Moz
    {
    var left = screen.availWidth/2 - width/2;
    var top = screen.availHeight/2 - height/2;
    activeModalWin = window.open(url, "", "width="+width+"px,height="+height+",left="+left+",top="+top);
    window.onfocus = function(){if (activeModalWin.closed == false){activeModalWin.focus();};};
    }
var sActiveAssetInput;
function setAssetValue(v) //required by the asset manager
    {
    document.getElementById(sActiveAssetInput).value = v;
	document.getElementById('img_select').src=v;
    }
function openAsset(s)
	{
	sActiveAssetInput = s
	if(navigator.appName.indexOf('Microsoft')!=-1){
		document.getElementById(sActiveAssetInput).value=modalDialogShow_IE(_URL+"javascript/Editor/assetmanager/assetmanager.php?lang=french",640,465); //IE
		document.getElementById('img_select').src=document.getElementById(sActiveAssetInput).value; }
	else {
		modalDialogShow_Moz(_URL+"javascript/Editor/assetmanager/assetmanager.php?lang=french",640,465); //Moz	
		}
	}





/* ----------------------------------------------------------------------------------------------------------------*/
/* ------------->>> Calendrier Javascript <<<----------------------------------------------------------------------*/
/* ----------------------------------------------------------------------------------------------------------------*/



// Initialise the calendar
$(document).ready(function() {
   popUpCal.init();
   if ($("#date")) $("#date").calendar();
   if ($("#date_naiss")) $("#date_naiss").calendar({ yearRange: '-40:0' });
});

	/* MarcGrabanski.com v2.3 */
/* Pop-Up Calendar Built from Scratch by Marc Grabanski */
/* Enhanced by Keith Wood (kbwood@iprimus.com.au). */
/* Under the Creative Commons Licence http://creativecommons.org/licenses/by/3.0/
	Share or Remix it but please Attribute the authors. */
var popUpCal = {
	selectedDay: new Date().getDate(),
	selectedMonth: new Date().getMonth(), // 0-11
	selectedYear: new Date().getFullYear(), // 4-digit year
	closeText: 'Close', // Display text for close link
	appendText: '', // Display text following the input box, e.g. showing the format
	buttonText: '...', // Text for trigger button
	buttonImage: _URL+'images/calendar.gif', // URL for trigger button image
	buttonImageOnly: true, // True if the image appears alone, false if it appears on a button
	dateFormat: 'YMD-', // First three are day, month, year in the required order, fourth is the separator, e.g. US would be 'MDY/'
	yearRange: '-10:+10', // Range of years to display in drop-down, either relative to current year (-nn:+nn) or absolute (nnnn:nnnn)
	firstDay: 1, // The first day of the week, Sun = 0, Mon = 1, ...
	showOtherMonths: false, // True to show dates in other months, false to leave blank
	minDate: null, // The earliest selectable date, or null for no limit
	maxDate: null, // The latest selectable date, or null for no limit
	speed: 'fast', // Speed of display/closure
	autoPopUp: 'both', // 'focus' for popup on focus, 'button' for trigger button, or 'both' for either
	closeAtTop: true, // True to have the clear/close at the top, false to have them at the bottom
	customDate: null, // Function that takes a date and returns an array with [0] = true if selectable, false if not,
		// [1] = custom CSS class name(s) or '', e.g. popUpCal.noWeekends
	clearText : 'Enlevez',
	closeText : 'Fermez',
	prevText : '&lt;Préc',
	nextText : 'Proch&gt;',
	currentText : 'En cours',
	dayNames : new Array('Di','Lu','Ma','Me','Je','Ve','Sa'),
	monthNames : new Array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'),
	
	init: function() {
		this.popUpShowing = false;
		this.lastInput = null;
		$('body').append('<div id="calendar_div"></div>');
		$(document).mousedown(popUpCal.checkExternalClick);
		this.showFunction = function(target) { // pop-up calendar when triggered
			input = (target.nodeName && target.nodeName.toLowerCase() == 'input' ? target : this);
			if (input.nodeName.toLowerCase() != 'input') { // find from button/image trigger
				input = $('../input', input)[0];
			}
			if (popUpCal.lastInput == input) {
				return;
			}
			popUpCal.input = $(input);
			popUpCal.hideCalendar();
			popUpCal.lastInput = input;
			if (($('#date_naiss')) && $('#date_naiss').val()!='00-00-0000') popUpCal.setDateFromField();
			popUpCal.setPos(input, $('#calendar_div'));
			popUpCal.showCalendar(); 
		};
		this.keyDownFunction = function(e) {
			if (popUpCal.popUpShowing) {
				if (e.keyCode == 9) { // hide on tab out
					popUpCal.hideCalendar();
				}
				else if (e.keyCode == 27) { // hide on escape
					popUpCal.hideCalendar(popUpCal.speed);
				}
				else if (e.keyCode == 33) { // previous month/year on page up/+ ctrl
					popUpCal.adjustDate(-1, (e.ctrlKey ? 'Y' : 'M'));
				}
				else if (e.keyCode == 34) { // next month/year on page down/+ ctrl
					popUpCal.adjustDate(+1, (e.ctrlKey ? 'Y' : 'M'));
				}
				else if (e.keyCode == 35 && e.ctrlKey) { // clear on ctrl+end
					$('#calendar_clear').click();
				}
				else if (e.keyCode == 36 && e.ctrlKey) { // current on ctrl+home
					$('#calendar_current').click();
				}
				else if (e.keyCode == 37 && e.ctrlKey) { // -1 day on ctrl+left
					popUpCal.adjustDate(-1, 'D');
				}
				else if (e.keyCode == 38 && e.ctrlKey) { // -1 week on ctrl+up
					popUpCal.adjustDate(-7, 'D');
				}
				else if (e.keyCode == 39 && e.ctrlKey) { // +1 day on ctrl+right
					popUpCal.adjustDate(+1, 'D');
				}
				else if (e.keyCode == 40 && e.ctrlKey) { // +1 week on ctrl+down
					popUpCal.adjustDate(+7, 'D');
				}
				else if (e.keyCode == 13) { // select the value on enter
					popUpCal.selectDate();
				}
			}
			else if (e.keyCode == 36 && e.ctrlKey) { // display the calendar on ctrl+home
				popUpCal.showFunction(this);
				popUpCal.showCalendar();
			}
		};
		this.keyPressFunction = function(e) {
			chr = String.fromCharCode(e.charCode == undefined ? e.keyCode : e.charCode);
			if (chr > ' ' && chr != popUpCal.dateFormat.charAt(3) && (chr < '0' || chr > '9')) { // only allow numbers and separator
				return false;
			}
			return true;
		};
	}, // end init
	
	connectCalendar: function(target) {
		var $input = $(target);
		$input.after('<span class="calendar_append">' + this.appendText + '</span>');
		if (this.autoPopUp == 'focus' || this.autoPopUp == 'both') { // pop-up calendar when in the marked fields
			$input.focus(this.showFunction);
		}
		if (this.autoPopUp == 'button' || this.autoPopUp == 'both') { // pop-up calendar when button clicked
			$input.wrap('<span class="calendar_wrap"></span>').
				after(this.buttonImageOnly ? '<img class="calendar_trigger" src="' + 
				this.buttonImage + '" alt="' + this.buttonText + '" title="' + this.buttonText + '"/>' :
				'<button class="calendar_trigger">' + (this.buttonImage != '' ? 
				'<img src="' + this.buttonImage + '" alt="' + this.buttonText + '" title="' + this.buttonText + '"/>' : 
				this.buttonText) + '</button>');
			$((this.buttonImageOnly ? 'img' : 'button') + '.calendar_trigger', $input.parent('span')).click(this.showFunction);
		}
		$input.keydown(this.keyDownFunction).keypress(this.keyPressFunction);
	},
	
	showCalendar: function() {
		this.popUpShowing = true;
		// build the calendar HTML
		html = (this.closeAtTop ? '<div id="calendar_control">' +
			'<a id="calendar_close">' + this.closeText + '</a></div>' : '') +
			'<div id="calendar_links"><a id="calendar_prev">' + this.prevText + '</a>' +
			'<a id="calendar_current">' + this.currentText + '</a>' +
			'<a id="calendar_next">' + this.nextText + '</a></div>' +
			'<div id="calendar_header"><select id="calendar_newMonth">';
		inMinYear = (this.minDate != null && this.minDate.getFullYear() == this.selectedYear);
		inMaxYear = (this.maxDate != null && this.maxDate.getFullYear() == this.selectedYear);
		for (var month = 0; month < 12; month++) {
			if (!((inMinYear && month < this.minDate.getMonth()) ||
					(inMaxYear && month > this.maxDate.getMonth()))) {
				html += '<option value="' + month + '"' + 
					(month == this.selectedMonth ? ' selected="selected"' : '') + 
					'>' + this.getMonthName(month) + '</option>';
			}
		}
		html += '</select> <select id="calendar_newYear">';
		// determine range of years to display
		years = this.yearRange.split(':');
		if (years.length != 2) {
			year = this.selectedYear - 10;
			endYear = this.selectedYear + 10;
		}
		else if (years[0].charAt(0) == '+' || years[0].charAt(0) == '-') {
			year = this.selectedYear + parseInt(years[0]);
			endYear = this.selectedYear + parseInt(years[1]);
		}
		else {
			year = parseInt(years[0]);
			endYear = parseInt(years[1]);
		}
		if (this.minDate != null) {
			year = Math.max(year, this.minDate.getFullYear());
		}
		if (this.maxDate != null) {
			endYear = Math.min(endYear, this.maxDate.getFullYear());
		}
		for (; year <= endYear; year++) {
			html += '<option value="' + year + '"' + 
				(year == this.selectedYear ? ' selected="selected"' : '') + 
				'>' + year + '</option>';
		}
		html += '</select></div>' +
			'<table id="calendar" cellpadding="0" cellspacing="0"><thead>' +
			'<tr class="calendar_titleRow">';
		for (var dow = 0; dow < this.dayNames.length; dow++) {
			html += '<td>' + this.dayNames[(dow + this.firstDay) % 7] + '</td>';
		}
		html += '</tr></thead><tbody>';
		daysInMonth = this.getDaysInMonth(this.selectedYear, this.selectedMonth);
		this.selectedDay = Math.min(this.selectedDay, daysInMonth);
		noPrintDays = (this.getFirstDayOfMonth(this.selectedYear, this.selectedMonth) - this.firstDay + 7) % 7;
		currentDate = new Date(this.currentYear, this.currentMonth, this.currentDay);
		selectedDate = new Date(this.selectedYear, this.selectedMonth, this.selectedDay);
		printDate = new Date(this.selectedYear, this.selectedMonth, 1 - noPrintDays);
		numRows = Math.ceil((noPrintDays + daysInMonth) / 7); // calculate the number of rows to generate
		today = new Date();
		today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		for (var row = 0; row < numRows; row++) { // create calendar rows
			html += '<tr class="calendar_daysRow">';
			for (var dow = 0; dow < 7; dow++) { // create calendar days
				customSettings = (this.customDate == null ? [true, ''] : this.customDate(printDate));
				otherMonth = (printDate.getMonth() != this.selectedMonth);
				unselectable = otherMonth || !customSettings[0] || 
					(this.minDate != null && printDate < this.minDate) || 
					(this.maxDate != null && printDate > this.maxDate);
				html += '<td class="calendar_daysCell' + 
					((dow + this.firstDay + 6) % 7 >= 5 ? ' calendar_weekEndCell' : '') + // highlight weekends
					(otherMonth ? ' calendar_otherMonth' : '') + // highlight days from other months
					(printDate.getTime() == selectedDate.getTime() ? ' calendar_daysCellOver' : '') + // highlight selected day
					(unselectable ? ' calendar_unselectable' : '') +  // highlight unselectable days
					(!otherMonth || this.showOtherMonths ? ' ' + customSettings[1] : '') + '"' + // highlight custom dates
					(printDate.getTime() == currentDate.getTime() ? ' id="calendar_currentDay"' : // highlight current day
					(printDate.getTime() == today.getTime() ? ' id="calendar_today"' : '')) + '>' + // highlight today (if different)
					(otherMonth ? (this.showOtherMonths ? printDate.getDate() : '&nbsp;') : // display for other months
					(unselectable ? printDate.getDate() : '<a>' + printDate.getDate() + '</a>')) + '</td>'; // display for this month
				printDate.setDate(printDate.getDate() + 1);
			}
			html += '</tr>';
		}
		html += '</tbody></table><!--[if lte IE 6.5]><iframe src="javascript:false;" id="calendar_cover"></iframe><![endif]-->' +
			(this.closeAtTop ? '' : '<div id="calendar_control"><a id="calendar_clear">' + this.clearText + '</a>' +
			'<a id="calendar_close">' + this.closeText + '</a></div>');
		// add calendar to element to calendar Div
		$('#calendar_div').empty().append(html).show(this.speed);
		this.input[0].focus();
		this.setupDayLinks();
		// clear button link
		$('#calendar_clear').click(function() {
			popUpCal.clearDate();
		});
		// close button link
		$('#calendar_close').click(function() {
			popUpCal.hideCalendar(popUpCal.speed);
		});
		// setup navigation links
		$('#calendar_prev').click(function() {
			popUpCal.adjustDate(-1, 'M'); 
		});
		$('#calendar_next').click(function() {
			popUpCal.adjustDate(+1, 'M'); 
		});
		$('#calendar_current').click(function() {
			this.currentDay = new Date().getDate();
			popUpCal.selectedDay = new Date().getDate();
			popUpCal.selectedMonth = new Date().getMonth();
			popUpCal.selectedYear = new Date().getFullYear();
			popUpCal.showCalendar(); 
		});
		$('#calendar_newMonth').change(function() {
			popUpCal.selectedMonth = this.options[this.selectedIndex].value - 0;
			popUpCal.adjustDate(); 
		});
		$('#calendar_newYear').change(function() {
			popUpCal.selectedYear = this.options[this.selectedIndex].value - 0;
			popUpCal.adjustDate(); 
		});
	}, // end showCalendar
	
	setupDayLinks: function() {
		// set up link events on calendar table
		$('#calendar td[a]').hover( 
			function() {
				$(this).addClass('calendar_daysCellOver');
			}, function() {
				$(this).removeClass('calendar_daysCellOver');
		});
		$('#calendar a').click(function() {
			popUpCal.selectedDay = $(this).html();
			popUpCal.selectDate();
		});
	},
	
	hideCalendar: function(speed) {
		if (this.popUpShowing) {
			$('#calendar_div').hide(speed);
			this.popUpShowing = false;
			this.lastInput = null;
		}
	},
	
	selectDate: function() {
		this.hideCalendar(this.speed);
		setVal = this.formatDate(this.selectedDay, this.selectedMonth, this.selectedYear);
		this.input.val(setVal);		
	},

	clearDate: function() {
		this.hideCalendar(this.speed);
		this.input.val('');		
	},
	
	checkExternalClick: function(event) {
		if (popUpCal.popUpShowing) {
			node = event.target;
			cal = $('#calendar_div')[0];
			while (node != null && node != cal && node.className != 'calendar_trigger') {
				node = node.parentNode;
			}
			if (node == null) {
				popUpCal.hideCalendar();
			}
		}
	},
	
	noWeekends: function(date) {
		day = date.getDay();
		return [!(day == 0 || day == 6), ''];
	},
	
	/* Functions Dealing with Dates */
	formatDate: function(day, month, year) {
		month++; // adjust javascript month
		if (month <10) month = '0' + month; // add a zero if less than 10
		if (day < 10) day = '0' + day; // add a zero if less than 10
		var dateString = '';
		for (var i = 0; i < 3; i++) {
			dateString += this.dateFormat.charAt(3) + (this.dateFormat.charAt(i) == 'D' ? day : 
				(this.dateFormat.charAt(i) == 'M' ? month : 
				(this.dateFormat.charAt(i) == 'Y' ? year : '?')));
		}
		return dateString.substring(1);
	},
	
	setDateFromField: function() {
		currentDate = this.input.val().split(this.dateFormat.charAt(3));
		if (currentDate.length == 3) {
			this.currentDay = parseInt(this.trimNumber(currentDate[this.dateFormat.indexOf('D')]));
			this.currentMonth = parseInt(this.trimNumber(currentDate[this.dateFormat.indexOf('M')])) - 1;
			this.currentYear = parseInt(this.trimNumber(currentDate[this.dateFormat.indexOf('Y')]));
		} else {
			this.currentDay = new Date().getDate();
			this.currentMonth = new Date().getMonth();
			this.currentYear = new Date().getFullYear();
		}
		this.selectedDay = this.currentDay;
		this.selectedMonth = this.currentMonth;
		this.selectedYear = this.currentYear;
		this.adjustDate(0, 'D', true);
	},
	
	trimNumber: function(value) {
		if (value == '')
			return '';
		while (value.charAt(0) == '0') {
			value = value.substring(1);
		}
		return value;
	},
	
	adjustDate: function(offset, period, dontShow) {
		// adjust the data as requested
		if (period == 'D') {
			this.selectedDay = this.selectedDay + offset;
		}
		else if (period == 'M') {
			this.selectedMonth = this.selectedMonth + offset;
		}
		else if (period == 'Y') {
			this.selectedYear = this.selectedYear + offset;
		}
		date = new Date(this.selectedYear, this.selectedMonth, this.selectedDay);
		// ensure it is within the bounds set
		if (this.minDate != null) {
			date = (date > this.minDate ? date : this.minDate);
		}
		if (this.maxDate != null) {
			date = (date < this.maxDate ? date : this.maxDate);
		}
		this.selectedDay = date.getDate();
		this.selectedMonth = date.getMonth();
		this.selectedYear = date.getFullYear();
		if (!dontShow) {
			this.showCalendar();
		}
	},
	
	getMonthName: function(month) {
		return this.monthNames[month];
	},
	
	getDayName: function(day) {
		return this.dayNames[day];
	},
	
	getDaysInMonth: function(year, month) {
		return 32 - new Date(year, month, 32).getDate();
	},
	
	getFirstDayOfMonth: function(year, month) {
		return new Date(year, month, 1).getDay();
	},
	
	/* Position Functions */
	setPos: function(targetObj, moveObj) {
		var coords = this.findPos(targetObj);
		moveObj.css('position', 'absolute');
		moveObj.css('left', coords[0] + 'px');
		moveObj.css('top', (coords[1] + targetObj.offsetHeight) + 'px');
	},
	
	findPos: function(obj) {
		var curleft = curtop = 0;
		if (obj.offsetParent) {
			curleft = obj.offsetLeft;
			curtop = obj.offsetTop;
			while (obj = obj.offsetParent) {
				var origcurleft = curleft;
				curleft += obj.offsetLeft;
				if (curleft < 0) { 
					curleft = origcurleft;
				}
				curtop += obj.offsetTop;
			}
		}
		return [curleft,curtop];
	}
};

$.fn.calendar = function(settings) {
	// customise the calendar object
	if (settings) {
		for (var attr in settings) {
			popUpCal[attr] = settings[attr];
		}
	}
	// attach the calendar to each nominated input element
	this.each(function() {
		if (this.nodeName.toLowerCase() == 'input') {
			popUpCal.connectCalendar(this);
		}
	});
	return this;
};



