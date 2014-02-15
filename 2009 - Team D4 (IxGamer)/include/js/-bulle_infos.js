// Script affichant les bulles d'infos
var i=false; 
function move(e) 
{
  if(i) 
  {  
	
	if (navigator.appName!="Microsoft Internet Explorer") 
	{ 
	   $("curseur").style.left=e.pageX + 15 +"px";
	   $("curseur").style.top=e.pageY + 5 +"px";
	}
	else 
	{
		if(document.documentElement.clientWidth>0) 
		{
		   $("curseur").style.left=20+event.x+document.documentElement.scrollLeft+"px";
		   $("curseur").style.top=10+event.y+document.documentElement.scrollTop+"px";
		}
		else 
		{
		   $("curseur").style.left=20+event.x+document.body.scrollLeft+"px";
		   $("curseur").style.top=10+event.y+document.body.scrollTop+"px";
		}
	}
	
  }
}
	function replaceAll( str, from, to ) {
    var idx = str.indexOf( from );


    while ( idx > -1 ) {
        str = str.replace( from, to );
        idx = str.indexOf( from );
    }

    return str;
}
function montre(id) 
{
 temp=$(id).alt;
  if(i==false && temp.length!=0) 
  {
     $("curseur").style.visibility="visible";
	 text = replaceAll(temp, "<[^>]*>", "");
     $("curseur").innerHTML = temp;
     i=true;
  }
}
function cache() 
{
  if(i==true) 
  {
    $("curseur").style.visibility="hidden"; 
    i=false;
  }
}

document.onmousemove=move; 

