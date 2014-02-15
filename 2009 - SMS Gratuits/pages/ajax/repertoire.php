<?
header('Content-Type: text/html; charset=ISO-8859-1'); 
session_start();
	include '../../include/fonctions.php';
security();
switch(array_shift(array_keys($_GET))){

	// Affiche le formulaire pour ajouter un contact
	case "ajouter":
	
		?>
		<html>
		<head>
			<style media="all" type="text/css">
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				strong  { font-weight:normal;color:#FF9900; }	
				input { background-color:#FFF; border:1px solid #AAAAAA; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#00A8FF; padding:2px 1px 2px 1px; text-align:center;margin-bottom:6px  }
				input:focus { background-color:#FFF; border:1px solid #46B9F0; }
				#submit { background-color:#EAFAFF; color:#0099FF; border:1px solid #09F; cursor:pointer  }
				#submit:focus { background-color:#FFF7EC; color:#F90; border:1px solid #F90; }
			</style>
			<script src="../../include/js/yotsumi.js"> </script>
			<script src="../../include/js/prototype.js"> </script>
		</head>
		<body>	
				
			<h1>Ajouter un contact</h1>
			Quel nom souhaiter vous attribuer au <br />
			<strong id='num'><?php echo $_GET['num'] ?></strong><br /><br />
			<input type='text' name='nom' id='nom' /><br />
			<input type='submit' value='ajouter' id='submit' onclick='ajouterNum2(); return false'/>
			<img id='wait' src='../../images/wait2.gif' style='display:none'>
			
		</body>
		</html>
		<?php
		
	break;
	
	// Ajoute le contact dans la BDD
	case "ajouter2":
	
		$sql_nb=mysql_query("SELECT nom FROM repertoire
							 WHERE num='".addslashes($_GET['num'])."' 
							 AND id_membre='".$_SESSION['sess_id']."'");
		
		if (mysql_num_rows($sql_nb)==0) 
		{
			$sql=mysql_query("INSERT INTO repertoire 
							  	(`id_membre`,`nom`,`num`)
					   		  VALUES (
								'".$_SESSION['sess_id']."', 
								'".addslashes($_GET['nom'])."', 
								'".addslashes($_GET['num'])."' ) ");
			echo "ok";
			
		} else { 
			echo "bug";	
		}	   
	
	break;
	
	// On affiche le répertoire avec les Liens JVS et les options Suppr/Modif
	case "recupRepertoire":
	
		?>
		<html>
		<head>
			<style media="all" type="text/css">
			
				BODY { margin:5px !important; margin:2px; font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;text-align:center}
				h1 { font-weight:bold;color:#00A8FF;font-size:13px; }
				input { background-color:#FFF; border:1px solid #AAAAAA; font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#00A8FF; padding:2px 1px 2px 1px; text-align:center;margin-bottom:6px  }
				input:focus { background-color:#FFF; border:1px solid #46B9F0; }
				#overflow { height:215px !important; height:205px; width:258px; overflow:auto;  }	
				table { font-family:Verdana; color:#000; font-size:12px }
				.ligne1 { background-color:#ECF5FF; margin:2px; } /*#F7F7F7*/
				.ligne2 { background-color:#DDEDFF; margin:2px; }
				td { padding:2px 1px 2px 1px; border-bottom:1px solid #DDD; vertical-align:middle}
				tr:hover { background-color:#F7F7F7; } /*#C1DDFF*/
				.num { font-size:10px }
				img { border:0 }
				a { text-decoration:none; color:00A8FF }
				a:hover { color:#FF66FF}
				a:active { outline:0; color:#33FF00  }
				a:focus { outline:0; color:#FF00FF; font-variant:small-caps }
			</style>
			<script src="../../include/js/yotsumi.js"> </script>
			<script src="../../include/js/prototype.js"> </script>
			<script src="../../include/js/editinplace.js"> </script>
		</head>
		<body>	
		
			<h1>Répertoire de <?php echo ucfirst($_SESSION['sess_pseudo']); ?></h1>
			<div id="overflow">
			
				<table id="tablo">
				
			<?php
			$sql=mysql_query("SELECT * FROM repertoire WHERE id_membre=".$_SESSION['sess_id']);
				
				// On gère le rajout du scroll
				$num=mysql_num_rows($sql);
				if ($num<=10) $width=array('150','75','33');
				else $width=array('120','60','33');
				
			$i=1;
			while ($d=mysql_fetch_object($sql)) 
			{
			?>	
				<tr class="ligne<?php echo $i ?>" id="tr<?php echo $d->id ?>">
					<td style="width:<?php echo $width[0] ?>px"><a href="#" onClick="majNum('<?php echo $d->num ?>')"><?php echo $d->nom ?></a></td>
					<td style="width:<?php echo $width[1] ?>px" class="num"><?php echo $d->num ?></td>
					<td style="width:<?php echo $width[2] ?>px"><a href="#"><img src='../../images/edit.png' id="edit<?php echo $d->id ?>"></a>&nbsp;<a href="#" onClick="supprNum(<?php echo $d->id ?>)"><img src='../../images/suppr.png'></a></td>
				</tr>
				
			<?php
			
				$i++;
				if ($i==3) $i=1;
				$tablo[]=$d->id;
			}
			?>
				</table>

				<script> 
				
						var tableau = new PhpArray2Js('<?php echo serialize($tablo); ?>');
						var tab = tableau.retour();
						
						</script>
				
			</div>
		
		</body>
		</html>
		<?php
		
	break;
	
	// Supprimer un numéro
	case "suppr";
	
		$id=(int)$_GET['id'];
		$sql=mysql_query("DELETE FROM repertoire WHERE id=$id AND id_membre=".$_SESSION['sess_id']);
		echo $id;
		
	break;
	
	case "modif":
	
		$nom=addslashes(htmlspecialchars($_POST['nom']));
		$id=(int)$_POST['id'];
		$sql=mysql_query("UPDATE repertoire SET `nom`='".$nom."' WHERE `id`='".$id."'");
		echo $_POST['nom'];			
	
	break;
}
?>
