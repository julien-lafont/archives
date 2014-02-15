<?php

 $c='<div class="titreMessagerie">Résultat de votre recherche</div>
 
	<div id="googleSearchUnitIframe" style="margin:10px;"></div>
	
	<script type="text/javascript">
	   var googleSearchIframeName = \'googleSearchUnitIframe\';
	   var googleSearchFrameWidth = 650;
	   var googleSearchFrameborder = 0 ;
	   var googleSearchDomain = \'www.google.fr\';
	</script>
	<script type="text/javascript"
			 src="http://www.google.com/afsonline/show_afs_search.js">
	</script>
	<!-- Google Search Result Snippet Ends -->';
	
	$design->zone('titrePage', 'Module recherche');
	$design->zone('contenu', $c);
	
?>