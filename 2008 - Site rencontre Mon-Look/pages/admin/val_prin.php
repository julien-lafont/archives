<?php
security_admin();

	$add='<script src="include/effet/prototype.js" type="text/javascript"></script>
			<script src="include/effet/rico.js" type="text/javascript"></script>
			<script src="include/effet/ricoDragAndDropCustomDraggable.js" type="text/javascript"></script>
			<script src="include/script.js" type="text/javascript"></script>';

head($add);


echo '
<table style="width:100%; border:0">
	<tr>
	 <td rowspan="3" style="width:130px;vertical-align:top" ><div id="dragBox" style="vertical-align:top">';
	 
	 $sql=mysql_query("SELECT id_membre, img_principale, username FROM members WHERE img_principale!='' AND img_valid='0'");
		while ($d=mysql_fetch_object($sql)) {
	echo "<span id='d$d->id_membre' class='imggg'><img src='upload/principal/$d->img_principale' style='border:1px solid #000000'></span><br>
	      <script>dndMgr.registerDraggable( new CustomDraggable($('d".$d->id_membre."'), '<img src=\"upload/principal/".$d->img_principale."\">|".ucfirst($d->username)."') );</script>";
}
		echo'</div></td>
	<td id="dropBox" style="height:170px; width:130px; padding:0 10px 0 10px;vertical-align:top; color:#00E426; font-size:12px; font-weight:bold; text-align:center">Accepter
	 	<div id="dropZone" style="border:1px solid #00FF00; height:160px; text-align:center; font-size:12px; color:#0066FF; padding:3px 3px 0px 3px; margin-top:3px; overflow:auto; line-height:17px; font-weight:normal"></div></td>
		
	 <td id="dropBox2" style="height:170px; width:130px; padding:0 15px 0 10px;vertical-align:top; color:#FF0000; font-size:12px; font-weight:bold; text-align:center">Refuser
	 	<div id="dropZone2" style="border:1px solid #FF0000; height:160px; text-align:center; font-size:12px; color:#0066FF; padding:3px 3px 0px 3px; margin-top:3px; verflow:auto; line-height:17px; font-weight:normal"></div></td>
	</tr>
	<tr>
	 <td colspan="2" style="height:700px; padding:10 10px 0 10px; vertical-align:top">
	 <div style="border:1px solid #FFFFFF; height:80px; text-align:center; vertical-align:top">
	    <div id="securees" style="display:none">'.$_SESSION['sess_secure'].'</div>
	 	<div class="envoyer" style="width:115px; margin-top:5px; margin-left:auto; margin-right:auto" OnClick="fini()" >Valider</div>
	 	<div id="status" style="text-align:center; margin-top:5px; width:80%; background-color:#FFFFFF; border:1px solid #999999; margin-left:auto; margin-right:auto; color:#3366FF; padding:2px">En attente</div>
	 </div></td>
	</tr>
	<tr>
	 <td></td>
	 <td></td>
	</tr>
</table>
<div style="clear:both;margin-left:8px; display:none">
   <span id=\'loghead\' style="background-color:#FFFFFF; border:1px solid #000000">drag-n-drop message log:</span>
   <div class="logBox" id="logger" style="width:235px;margin-bottom:8px;height:140px;overflow:auto">
   </div>
</div>
<div class="rc codeBox" id="codeContainer">
</div>
<script>
  dndMgr.registerDropZone( new Rico.Dropzone($(\'dropZone\')));
  dndMgr.registerDropZone( new Rico.Dropzone($(\'dropZone2\')));

</script>';

foot();

?>