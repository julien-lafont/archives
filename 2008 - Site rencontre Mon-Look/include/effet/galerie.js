
function majDescription() {
	mess=escape(document.getElementById('mess').value);
	id=document.getElementById('idImg').innerHTML;
	ajaxGetA('pages/membre/galerie_ajax.php?act=majdes&id='+id+'&mess='+mess,'majDescription2');
}

function majDescription2(r) {
	if (unescape(r)=="ok") window.location.replace("?p=membre/galerie&act=gerer");
	else alert('Erreur lors de la mise à jour !\n\nErreur:\n'+unescape(r));
}



// Script zoom miniature
//  + Script limitation Textarea


var ns6=document.getElementById&&!document.all
		
		function restrictinput(maxlength,e,placeholder){
		if (window.event&&event.srcElement.value.length>=maxlength)
		return false
		else if (e.target&&e.target==eval(placeholder)&&e.target.value.length>=maxlength){
		var pressedkey=/[a-zA-Z0-9\.\,\/]/ 
		if (pressedkey.test(String.fromCharCode(e.which)))
		e.stopPropagation()
		}
		}
		
		function countlimit(maxlength,e,placeholder){
		var theform=eval(placeholder)
		var lengthleft=maxlength-theform.value.length
		var placeholderobj=document.all? document.all[placeholder] : document.getElementById(placeholder)
		if (window.event||e.target&&e.target==eval(placeholder)){
		if (lengthleft<0)
		theform.value=theform.value.substring(0,maxlength)
		placeholderobj.innerHTML=lengthleft
		}
		}
		
		function displaylimit(thename, theid, thelimit){
		var theform=theid!=""? document.getElementById(theid) : thename
		var limit_text='<b><span id="'+theform.toString()+'">'+thelimit+'</span></b> Max'
		if (document.all||ns6)
		document.write(limit_text)
		if (document.all){
		eval(theform).onkeypress=function(){ return restrictinput(thelimit,event,theform)}
		eval(theform).onkeyup=function(){ countlimit(thelimit,event,theform)}
		}
		else if (ns6){
		document.body.addEventListener('keypress', function(event) { restrictinput(thelimit,event,theform) }, true); 
		document.body.addEventListener('keyup', function(event) { countlimit(thelimit,event,theform) }, true); 
		}
		}
		
		
		
		if(!window.JSFX)
	JSFX=new Object();
JSFX.ImageZoomRunning = false;

JSFX.zoomOn = function(img, zoomStep, maxZoom)
{
	if(img)
	{
		if(!zoomStep)
		{
			if(img.mode == "EXPAND")
				zoomStep = img.height/10;
			else
				zoomStep = img.width/10;
		}

		if(!maxZoom)
		{
			if(img.mode == "EXPAND")
				maxZoom = img.height/2;
			else
				maxZoom = img.width/2;
		}


		if(img.state == null)
		{
			img.state = "OFF";
			img.index = 0;
			img.orgWidth =  img.width;
			img.orgHeight = img.height;
			img.zoomStep = zoomStep;
			img.maxZoom  = maxZoom;
		}

		if(img.state == "OFF")
		{
			img.state = "ZOOM_IN";
			start_zooming();
		}
		else if( img.state == "ZOOM_IN_OUT"
			|| img.state == "ZOOM_OUT")
		{
			img.state = "ZOOM_IN";
		}
	}
}
JSFX.zoomIn = function(img, zoomStep, maxZoom)
{
	img.mode = "ZOOM";
	JSFX.zoomOn(img, zoomStep, maxZoom);
}
JSFX.stretchIn = function(img, zoomStep, maxZoom)
{
	img.mode = "STRETCH";
	JSFX.zoomOn(img, zoomStep, maxZoom);
}
JSFX.expandIn = function(img, zoomStep, maxZoom)
{
	img.mode = "EXPAND";
	JSFX.zoomOn(img, zoomStep, maxZoom);
}

JSFX.zoomOut = function(img)
{
	if(img)
	{
		if(img.state=="ON")
		{
			img.state="ZOOM_OUT";
			start_zooming();
		}
		else if(img.state == "ZOOM_IN")
		{
			img.state="ZOOM_IN_OUT";
		}
	}
}

function start_zooming()
{
	if(!JSFX.ImageZoomRunning)
		ImageZoomAnimation();
}

JSFX.setZoom = function(img)
{
	if(img.mode == "STRETCH")
	{
		img.width  = img.orgWidth  + img.index;
		img.height = img.orgHeight;
	}
	else if(img.mode == "EXPAND")
	{
		img.width  = img.orgWidth;
		img.height = img.orgHeight + img.index;
	}
	else
	{
		img.width  = img.orgWidth  + img.index;
		img.height  = img.orgHeight  + img.index;
	}
}

function ImageZoomAnimation()
{
	JSFX.ImageZoomRunning = false;
	for(i=0 ; i<document.images.length ; i++)
	{
		var img = document.images[i];
		if(img.state)
		{
			if(img.state == "ZOOM_IN")
			{
				img.index+=img.zoomStep;
				if(img.index > img.maxZoom)
					img.index = img.maxZoom;

				JSFX.setZoom(img);

				if(img.index == img.maxZoom)
					img.state="ON";
				else
					JSFX.ImageZoomRunning = true;
			}
			else if(img.state == "ZOOM_IN_OUT")
			{
				img.index+=img.zoomStep;
				if(img.index > img.maxZoom)
					img.index = img.maxZoom;

				JSFX.setZoom(img);
	
				if(img.index == img.maxZoom)
					img.state="ZOOM_OUT";
				JSFX.ImageZoomRunning = true;
			}
			else if(img.state == "ZOOM_OUT")
			{
				img.index-=img.zoomStep;
				if(img.index < 0)
					img.index = 0;

				JSFX.setZoom(img);

				if(img.index == 0)
					img.state="OFF";
				else
					JSFX.ImageZoomRunning = true;
			}
		}
	}
	if(JSFX.ImageZoomRunning)
		setTimeout("ImageZoomAnimation()", 40);
}