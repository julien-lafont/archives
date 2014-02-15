<?php /* Smarty version 2.6.18, created on 2008-08-13 17:30:09
         compiled from fr/_quisuisje/nuagetag.tpl */ ?>
<img src="images/T_NuageTag.png" alt="Qui suis-je ?" /><br /><br />

	<div class="center">
		Pour terminer, voici quelques mots qui résument parfaitement mon monde.
		
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
   				codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,24"
   				width="550" height="350">
		<param name="movie" value="images/tagcloud.swf"  /> 
		<param name="quality" value="high"  />
		<param name="menu" value="false"  />
		<param name="wmode" value="transparent"  />
		<param name="flashvars" value="tcolor=0xffffff&amp;tagcloud=<?php echo $this->_tpl_vars['tags']; ?>
" />
		
		 <!--[if !IE]> <-->
		 <object data="images/tagcloud.swf"
		         width="550" height="350" type="application/x-shockwave-flash">
		     <param name="quality" value="high"  />
		     <param name="menu" value="false"  />
			 <param name="wmode" value="transparent"  />
		     <param name="pluginurl" value="http://www.macromedia.com/go/getflashplayer"  />
		     <param name="flashvars" value="tcolor=0xffffff&amp;tagcloud=<?php echo $this->_tpl_vars['tags']; ?>
" />
		 </object>
		 <!--> <![endif]-->
	  </object>
	  
	</div>
	


	<div id="taginfo">
		Cliquez sur un tag pour avoir plus d'infos <em>( flash nécessaire )</em>
	</div>
	
<table class="suiv_prec">
	<tr>
		<td style="width:50%; text-align:left;"> &lsaquo; <a href="#3" class="cross-link">Mon projet</a> : Page précédente &lsaquo; </td>
				<td style="width:50%"></td>
	</tr>
</table>