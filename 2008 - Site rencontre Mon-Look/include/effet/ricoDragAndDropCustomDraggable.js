function fini() {
	
	document.getElementById('status').innerHTML="<img src='images/indicator.gif'>";
	jetter=document.getElementById('dropZone2').innerHTML;
	garder=document.getElementById('dropZone').innerHTML;
	secur2=document.getElementById('securees').innerHTML;
	result=ajaxPost("pages/admin/ajax_valid.php","jetter="+escape(jetter)+"&garder="+escape(garder)+"&secure="+escape(secur2));

	if (result=="ok") {
		document.getElementById('dropZone').innerHTML="";
		document.getElementById('dropZone2').innerHTML="";
		document.getElementById('status').innerHTML="Mise à jour effectuée avec succés";
	} else {
		alert(result);
	}

}

function fini_gal() {
	
	document.getElementById('status').innerHTML="<img src='images/indicator.gif'>";
	jetter=document.getElementById('dropZone2').innerHTML;
	garder=document.getElementById('dropZone').innerHTML;
	secur2=document.getElementById('securees').innerHTML;
	result=ajaxPost("pages/admin/ajax_valid.php","galerie=1&jetter="+escape(jetter)+"&garder="+escape(garder)+"&secure="+escape(secur2));

	if (result=="ok") {
		document.getElementById('dropZone').innerHTML="";
		document.getElementById('dropZone2').innerHTML="";
		document.getElementById('status').innerHTML="Mise à jour effectuée avec succés";
	} else {
		alert(result);
	}

}

/**
 *  Sample 'CustomDraggable' object which extends the Rico.Draggable to
 *  override the behaviors associated with a draggable object...
 *
 **/
var CustomDraggable = Class.create();

CustomDraggable.removeOnDrop = true;
CustomDraggable.revereNamesOnDrop = true;

CustomDraggable.prototype = (new Rico.Draggable()).extend( {

   initialize: function( htmlElement, name ) {
      this.type        = 'Custom';
      this.htmlElement = $(htmlElement);
      this.name        = name;
   },

   log: function(str) {
      new Insertion.Bottom( $('logger'), "<span class='logMsg'>" + str + "</span>" );
      $('logger').scrollTop = $('logger').lastChild.offsetTop;

   },

   select: function() {
	    
      this.selected = true;
      var el = this.htmlElement;

      // show the item selected.....
      el.style.color           = "#ffffff";
      el.style.backgroundColor = "#3FCEED";
      el.style.border          = "1px solid #3FCEED";
   },

   deselect: function() {
	   
      this.selected = false;
      var el = this.htmlElement;
      el.style.color           = "#33FFFF";
      el.style.backgroundColor = "transparent";
      el.style.border = "0px";
   },

   startDrag: function() {
	   
	  new Rico.Effect.FadeTo( this.htmlElement, .2, 1, 15 );
      var el = this.htmlElement;
      this.log("startDrag: [" + this.name +"]");
   },

   cancelDrag: function() {
	  new Rico.Effect.FadeTo( this.htmlElement, 1, .5, 7 );
      var el = this.htmlElement;
      this.log("cancelDrag: [" + this.name +"]");
   },

   endDrag: function() {
      var el = this.htmlElement;
      this.log("endDrag: [" + this.name +"]");
      if ( CustomDraggable.removeOnDrop )
         this.htmlElement.style.display = 'none';
	

   },

   getSingleObjectDragGUI: function() {
	   
      var el = this.htmlElement;
      var div = document.createElement("div");
      div.className = 'customDraggable';
      div.style.width = (this.htmlElement.offsetWidth - 10) + "px";
	  var names = this.name.split("|");
      new Insertion.Top( div, names[0] );
      return div;
   },

   getMultiObjectDragGUI: function( draggables ) {
	   
      var el = this.htmlElement;

      var names = "";
      for ( var i = 0 ; i < draggables.length ; i++ ) {
         names += draggables[i].name;
         if ( i != (draggables.length - 1) )
            names += ",<br/>";
      }

      var div = document.createElement("div");
      div.className = 'customDraggable';
      div.style.width = (this.htmlElement.offsetWidth - 10) + "px";
      new Insertion.Top( div, names );
      return div;
   },

   getDroppedGUI: function() {
	   

	var el = this.htmlElement;

      var div = document.createElement("div");
      var names = this.name.split("|");
      if ( CustomDraggable.revereNamesOnDrop ) {
         new Insertion.Top( div, names[1]+"<br>" );
		 
	  }
      else
         new Insertion.Top( div, "<span class='nameSpan'>" + this.name+ "</span>" );
      return div;
   },

   toString: function() {
      return this.name;
   }

} );