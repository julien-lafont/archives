<?php
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../include/fonctions.php';
	securite_membre(true);

switch(@$_GET['act'])
{
case "com_send":

	$message=addbdd($_POST['message']);
	$id=(int)$_POST['id'];
	$id_auteur=$_SESSION['sess_id'];
	$ip=ip();
	
	$sql=mysql_query("INSERT INTO ".PREFIX."breves_com
						(`id_breve`, `id_auteur`, `message`, `date`, `ip`)
					   VALUES
						('$id', '$id_auteur', '$message', NOW(), '$ip')");
					
	$sql2=mysql_query("UPDATE ".PREFIX."breves
					   SET nb_com=nb_com+1
					   WHERE id=$id");
					
	if ($sql) echo "ok";
	else	  echo "bad";

break;

case "com_suppr":

	securite_admin(true);
	
	$id=$_GET['id'];
	$idBreve=$_GET['idBreve'];
	
	$sql  = mysql_query("DELETE FROM ".PREFIX."breves_com WHERE id=$id");
	$sql2 = mysql_query("UPDATE ".PREFIX."breves SET nb_com=nb_com-1 WHERE id=$idBreve");
	
	if ($sql) 	echo $id;
	else		echo "BAD";

break;

case "com_edit":
	
	$id=(int)$_GET['id'];
	if ($_SESSION['sess_admin']==true)
	{
		securite_admin(true);
		$sql=mysql_query("SELECT * FROM ".PREFIX."breves_com WHERE id=$id");
	}
	else
	{
		$myId=$_SESSION['sess_id'];
		$sql=mysql_query("SELECT * FROM ".PREFIX."breves_com WHERE id='$id' AND id_auteur='$myId'");
	}
	
	$d=mysql_fetch_object($sql);

		?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; margin-bottom:5px}
				strong  { font-weight:normal;color:#FF9900; }	
				input 			{ background-color:#FFFFFF; border:1px solid #CCC; padding:2px 1px 2px 1px; text-align:center; margin-bottom:6px; font-size:12px; font-family:Verdana; color:#333333; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../../images/fond_input1.jpg) }
				input:focus		{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }
				#submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
				#form textarea.size100	{ background-color:#FFFFFF; border:1px solid #CCC; padding:4px; font-size:11px; font-family:Verdana; color:#333333; width:300px;  height:100px; background-color:#FFF; margin:2px 0 2px 0; color:#0099FF; background-image:url(../images/fond_textarea100.jpg) }
				#form textarea:focus	{ background-color:#FFFFFF; border:1px solid #5FCAFF; color:#0099FF }

			</style>
			<script src="../include/js/-general.js"> </script>
			<script src="../include/js/prototype.js"> </script>
		</head>
		<body>	
				
			<h1>Editer votre commentaire</h1>
			<br />
			<form id="form" method="post" action="?act=com_edit2">
			<textarea name="mess" id="mess" class="size100"><?php echo $d->message ?></textarea><br /><br />
			<input type="hidden" name="id" id="id" value="<?php echo $id ?>" />
			<input type='submit' value='modifier' id='submit'/>
			</form>
		</body>
		</html>
		<?php
break;

case "com_edit2":

	$id=(int)$_POST['id'];
	$mess=addBdd($_POST['mess']);
	
	if ($_SESSION['sess_admin']==true)
	{
		securite_admin(true);
		$sql=mysql_query("UPDATE ".PREFIX."breves_com SET message='$mess' WHERE id='$id'");
	}
	else
	{
		$myId=$_SESSION['sess_id'];
		$sql=mysql_query("UPDATE ".PREFIX."breves_com SET message='$mess' WHERE id='$id' AND id_auteur='$myId'");
	}
	
	?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				strong  { font-weight:normal;color:#FF9900; }	
			</style>
		</head>
		<body>	
				
			<br /><br /><br />
				<h1>Modification effectuée</h1>
			<br />
				Les changements seront effectifs aprés rafraichissent de la page.
			
		</body>
		</html>
	
	<?php
	
break;
}

?>