//Magic Menu V2.1.1 - http://www.ToutJavaScript.com/magicmenu
var main=""; function CREERMAGIC() {
main=new CreerMain(214,117,15);
main.Add("Couteau",100,"","cs_armesCouteau.html");main.Add("Pistolets",100,"","cs_armesPistolet.html");main.Add("Mitraillettes",100,"","cs_armesMitraillette.html");main.Add("Fusil & Sniper",100,"","cs_armesFusils.html");main.Add("Machin Gun",100,"","cs_armesMachin.html");} CREERMAGIC();var font="ms sans serif";var colBarre="#CCCCCC";var colFond="#CCCCCC";var colContour="black";var colOver="navy";var colTextOff="black"; var colTextOn="white";var cssTexte=";font-weight:bold;color:black;font-family:ms sans serif;font-size:12px";var hauteur=15;var nivmax=4;var delai=500;var isout=0;
function CreerMain(X,Y,haut,colFOn,colFOff,colTOn,colTOff) {this.nb=0;this.X=X;this.Y=Y;this.haut=haut;this.Add=AddMain;this.Print=PrintMain;}
function AddMain(txt,larg,mnu,url,target) {var m=new Object; m.txt=txt;m.larg=larg,m.mnu=mnu,m.url=url;m.target=target;this.nb++;this[this.nb]=m;if(mnu!=''){eval(mnu+'.parent="'+txt+'"')};}
function PrintMain() {
	X=this.X; Y=this.Y; A="";
	for (var i=1;i<=this.nb;i++) {
 if (this[i].mnu==""){this[i].mnu='0';}
		if ((document.all)||(window.sidebar)) {
         var clic=""; var style=""; if(this[i].url!="") {style="cursor:hand;"; clic=" onclick='window.location=\""+this[i].url+"\"'";}
			A+="<DIV id='main"+i+"' style='position:absolute;left:"+X+";top:"+Y+";"+style+"width:"+this[i].larg+";height:"+this.haut+";background-color:"+colBarre+";"+cssTexte+";text-align:center' onmouseover='start("+i+","+this[i].mnu+","+X+","+(Y+this.haut+1)+")'"+clic+">"+this[i].txt+"</DIV>";
		}
		if (document.layers) {
alert("Version de démo non compatible avec Netscape");
		}
		X+=this[i].larg+1;
	}
	document.write(A);
}
function CreerMenu(nom,niv,target) {this.nb=0; this.X=0;this.Y=0; this.width=1; this.niv=niv; this.parent=""; this.ON=-1;this.nom=nom;this.target=""; if ((target!="")&&(target!=null)) this.target=target;this.add=Add;this.aff=Aff;}
function Add(lib,lnk,mnu,target) {var rub = new Object;	rub.lib=lib; rub.target=target;	rub.lnk=""; if ((lnk!="")&&(lnk!=null)) rub.lnk=lnk; rub.mnu=""; if ((mnu!="")&&(mnu!=null)) {rub.mnu=mnu; mnu.parent=this}	this[this.nb]=rub;	this.nb++;}
function start(i,mnu,x,y) {
	isout=1;hideall(i);isout=0
	if (mnu!=0){mnu.aff(x,y)};
	BGCalque("main"+i,colOver); FontCalque("main"+i,colTextOn); SizeCalque("fond",mmgetlarg()-x+20);
	MoveCalque("fond",x-50,y+1);
	ShowCalque("fond");
	return false;
}
function onfond() {
	isout=1;
	setTimeout("hideall()",delai);
}
function hideall(i) {
	if (isout==1) {
		for (var i=0;i<nivmax;i++) {HideCalque("niv"+i); HideCalque("fond");}
		for (var i=1;i=main.nb;i++) {BGCalque("main"+i,colBarre); FontCalque("main"+i,colTextOff);}
	window.status="";MoveCalque("fond",1,1);
	}
}
function hide(mnu) {
	if (mnu.ON>-1) {
		if (mnu[mnu.ON].mnu!="") {
			var nom="niv"+mnu[mnu.ON].mnu.niv;
			HideCalque(nom);
			hide(mnu[mnu.ON].mnu);
		}
	}
	mnu.ON=-1;
}
function over(mnu,i) {
	var nom="niv"+mnu.niv+"n"+i;
	var nomtd=nom+"td";
	isout=0;
	BGCalque(nom,colOver);
	FontCalque(nomtd,colTextOn);
}
function out(mnu,i) {
	var nom="niv"+mnu.niv+"n"+i; 	var nomtd=nom+"td";
	if (mnu[i].lib!="-") {
		BGCalque(nom,colFond);
		FontCalque(nomtd,colTextOff)
	}
}
function clear(mnu) {
	  for (var j=0;j<mnu.nb;j++) {
	   out(mnu,j);
	   hide(mnu);
	}
}
function mmover(mnu,i) {
	clear(mnu);
	over(mnu,i);
	mnu.ON=i;
	if (mnu[i].mnu!="") {
		mnu[i].mnu.aff();
	}
var ok=1; var Y=""; var Z=mnu[i].lib; var u=mnu; while (u.niv>0) {Z=u.parent[u.parent.ON].lib+" > "+Z;u=u.parent;} Z=u.parent+" > "+Z;
for (var j=0;j<Z.length ;j++ ){
	if (Z.charAt(j)=="<") {ok=0;}
	if (ok==1) {Y+=Z.charAt(j) }
	if (Z.charAt(j)==">") {ok=1;}
}window.status=Y;
}
function mmclick(mnu) {
	lnk=mnu[mnu.ON].lnk;
	if (lnk!="") {
			if (mnu[mnu.ON].target=="_blank") {window.open(lnk)}
			else {
				if   (mnu[mnu.ON].target=="")	{window.location=lnk;}
				else {parent.frames[mnu[mnu.ON].target].location.href=lnk;}
			}
	}
}
function mmgetlarg() {if (document.layers){return parseInt(document.width)} else {return parseInt(document.body.offsetWidth)}}
function AFF() {
var n=new Image; n.src="fleche.gif";var m=new Image; m.src="vide.gif";	if ((document.all)||(window.sidebar)) {
var A="<DIV id='fond' style='position:absolute;top:10;left:100;width:500;height:400;visibility:hidden;font-family:"+font+"' onmouseover='onfond()'></DIV>";A+="<DIV id='niv0' style='position:absolute;top:10;left:100;visibility:visible;font-family:"+font+"'></DIV>";A+="<DIV id='niv1' style='position:absolute;top:10;left:100;visibility:visible;font-family:"+font+"'></DIV>";A+="<DIV id='niv2' style='position:absolute;top:10;left:100;visibility:visible;font-family:"+font+"'></DIV>";A+="<DIV id='niv3' style='position:absolute;top:10;left:100;visibility:visible;font-family:"+font+"'></DIV>";}	document.write(A);main.Print();
}
function Aff(x,y) {
var nom=this.nom;	var niv="niv"+this.niv;
if (this.niv==0) {X=x;Y=y;}
else {X=this.parent.X+this.parent.width-2;Y=this.parent.Y+(hauteur+4)*this.parent.ON}if ((document.all)||(window.sidebar)) {
var A=""
A+="<TABLE border=0 cellpadding=0 cellspacing=0 style='border-color:"+colContour+";border-style:solid;border-width:1px'>";
for (var i=0;i<this.nb;i++) {
if (this[i].lib=="-") {
A+="TR><TD style='background-color:"+colFond+";font-size:10px;border-style:none;margin:0px;height:"+(hauteur-2)+"px' colspan=2><DIV  style='background-color:"+colFond+";height:"+(hauteur+2)+"px'><HR noshade style='color:"+colContour+";height:1px'></DIV></TD></TR>"; 
} else {
var img="../vide.gif";if (this[i].mnu!="") { img="../fleche.gif"}
A+="<TR><TD style='cssTexte;border-style:none;margin:0px'><DIV id='"+niv+"n"+i+"' style='cursor:hand;background-color:"+colFond+cssTexte+"'  onmouseover='mmover("+this.nom+","+i+")' onClick='mmclick("+this.nom+")'><TABLE border=0 width=100% cellspacing=0><TR><TD style='font-size:12px;padding-top:3px;padding-bottom:3px;padding-left:3px;'><DIV id='"+niv+"n"+i+"td' style='"+cssTexte+"'>"+this[i].lib+"</DIV></TD><TD width=10 align=right><IMG src='%22%2Bimg%2B%22' height='"+hauteur+"' width='"+hauteur+"'></TD></TR></TABLE></DIV></TD></TR>";
}
}
A+="</TABLE>"
}else{
var A="<table border=0 cellspacing=0 cellpadding=1><tr><td bgcolor="+colContour+">";
A+="<TABLE border=0 cellpadding=0 cellspacing=0 bgcolor="+colFond+" width=100%>";
for (var i=0;i<this.nb;i++) {
if (this[i].lib=="-") {
A+="TR><TD><HR width=99% height=1%></TD></TR>";
} else {
var img="../vide.gif";if (this[i].mnu!="") { img="../fleche.gif"}
A+="<TR><TD><TABLE border=0 width=100% cellspacing=0><TR><TD><A href='javascript:mmclick("+this.nom+")' onmouseover='mmover("+this.nom+","+i+")'><SPAN style='background-color:"+colFond+cssTexte+"'>"+this[i].lib+"</SPAN></A></TD><TD width=10 align=right><IMG src='%22%2Bimg%2B%22' height="+hauteur+" width="+hauteur+"></TD></TR></TABLE></TD></TR>";
}
}
A+="</TABLE></TD></TR></TABLE>"
}
if (document.all) {document.all[niv].innerHTML=A+" ";document.all[niv].style.top=Y;document.all[niv].style.left=X;document.all[niv].style.visibility="visible";this.X=X;this.Y=Y;this.width=document.all[niv].clientWidth;}
if (window.sidebar) {document.getElementById(niv).innerHTML=A;document.getElementById(niv).style.top=Y;document.getElementById(niv).style.left=X;document.getElementById(niv).style.visibility="visible";this.X=X;this.Y=Y;this.width=document.getElementById(niv).offsetWidth;}
if (document.layers) {document.layers[niv].left=X;document.layers[niv].top=Y;document.layers[niv].document.write(A);document.layers[niv].document.close();document.layers[niv].visibility="show";this.X=X;this.Y=Y;this.width=document.layers[niv].clip.width;}}
function HideCalque(nom) {
if (document.all) {document.all[nom].style.visibility="hidden";}
if (window.sidebar) {document.getElementById(nom).style.visibility="hidden";}
if (document.layers) {document.layers[nom].visibility="hide";}
}
function ShowCalque(nom) {
if (document.all) {document.all[nom].style.visibility="visible";}
if (window.sidebar) {document.getElementById(nom).style.visibility="visible";}
if (document.layers) {document.layers[nom].visibility="show";}
}
function BGCalque(nom,BG) {
if (document.all) {document.all[nom].style.backgroundColor=BG;}
if (window.sidebar) {document.getElementById(nom).style.backgroundColor=BG;}
}
function FontCalque(nom,Font) {
if (document.all) {document.all[nom].style.color=Font;}
if (window.sidebar) {document.getElementById(nom).style.color=Font;}
}
function MoveCalque(nom,X,Y) {
if (document.all) {document.all[nom].style.top=Y;document.all[nom].style.left=X;}
if (window.sidebar) {document.getElementById(nom).style.top=Y;document.getElementById(nom).style.left=X;}
if (document.layers) {document.layers[nom].top=Y;document.layers[nom].left=X;}
}
function GetLeft(nom) {
if (document.all) {return document.all[nom].style.left;}
if (window.sidebar) {return document.getElementById(nom).style.left}
if (document.layers) {return document.layers[nom].left;}
}
function SizeCalque(nom,larg) {
if (document.all) {document.all[nom].style.width=larg;}
if (window.sidebar) {document.getElementById(nom).style.width=larg;}
if (document.layers) {document.layers[nom].width=larg;}
}
// VERSION
