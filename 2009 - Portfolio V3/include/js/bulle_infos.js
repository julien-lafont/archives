// Script affichant les bulles d'infos
var iBulle=false; 
	
function move(e) 
{
	

  if(iBulle) 
  {  
	
	if (navigator.appName!="Microsoft Internet Explorer") 
	{ 
	   $("#curseur").css('left',e.pageX + 15 +"px");
	   $("#curseur").css('top',e.pageY + 5 +"px");
	}
	else 
	{
		if(document.documentElement.clientWidth>0) 
		{
		   $("#curseur").css('left',20+event.x+document.documentElement.scrollLeft+"px");
		   $("#curseur").css('top',10+event.y+document.documentElement.scrollTop+"px");
		}
		else 
		{
		   $("#curseur").css('left',20+event.x+document.body.scrollLeft+"px");
		   $("#curseur").css('top',10+event.y+document.body.scrollTop+"px");
		}
	}
	
  }
}
	
function montre(id) 
{
  if(iBulle==false) 
  {
     $("#curseur").css('visibility',"visible");
     $("#curseur").html(document.getElementById(id).rel);
     iBulle=true;
  }
}
function cache() 
{
  if(iBulle==true) 
  {
    $("#curseur").css('visibility',"hidden"); 
    iBulle=false;
  }
}

document.onmousemove=move; 

