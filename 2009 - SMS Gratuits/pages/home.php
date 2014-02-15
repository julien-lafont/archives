<?php

if (!is_log()) { echo "Accés interdit !"; exit(); }
security(); /* en double mais bon */

$design['contenu']='&nbsp;<p><br/><br /><br />
	<div style="text-align:center"><img src="images/wait3.gif"><br>Chargement en cours</br></div>
	<br/><br /><br /></p>&nbsp;';

$design['onload']='
	<script type="text/javascript">
		window.onload=function(){
			ajaxGetA("pages/ajax/pages.php?p=home","showPage");
		}	
	</script>';

?>