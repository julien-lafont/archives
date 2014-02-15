<?php


switch($_GET['act']) {
default:

	// Cas du visionnage de la première page : on récupère les paramètres en POST
	if (empty($_GET['search_id'])) {
			
			$gender=addslashes($_POST['gender']);
			$city=strtolower(addslashes($_POST['city']));
			$country=addslashes($_POST['country']);
			$age1=intval($_POST['age1']);
			$age2=intval($_POST['age2']);
			
			if (empty($gender) && empty($city) && empty($country) && empty($age1)) rediriger('?p=erreur&code=7');
			
			if (!empty($gender)) $where="`gender`='$gender'";
			if (!empty($city)) { if (empty($where)) $where="`city`='$city'";
								 else $where.=" AND `city`='$city'";
							   }
			if (!empty($country)) { if (empty($where)) $where="`country`='$country'";
									else $where.=" AND `country`='$country'";
								  }
			if ($age1!=0 && $age2!=0) { if (empty($where)) $where="`age`>=$age1 AND `age`<=$age2";
										else $where=" AND `age`>=$age1 AND `age`<=$age2";
			}
			$secure=md5(session_id().$where);

	// Cas du visionnage des autres pages : on récupère les paramètres en GET ( search_id en decode64 ) avec protection md5 perso	
	} else {
	
		$where=base64_decode($_GET['search_id']);
		$secure=$_GET['secure'];
		if (md5(session_id().$where)!=$secure) rediriger('?p=erreur&code=8');
		
	}
	
	$first=$_GET['first']; $last=$_GET['last'];
	if ($first==null || $last==null) $limit="LIMIT 0,10"; 
	else $limit="LIMIT $first,$last";
	
		$sql_pre=mysql_query("SELECT id_membre FROM members WHERE $where");
			$nb=mysql_num_rows($sql_pre);
		$sql=mysql_query("SELECT username, gender, cherche, age, city, joindate, lastdate, note, coeff_note, img_principale, img_valid 
					  FROM members
					  WHERE $where ORDER BY note DESC $limit");

		head('<link rel="stylesheet" type="text/css" href="include/effet/niftyCorners.css">
		<link rel="stylesheet" type="text/css" href="include/effet/niftyPrint.css" media="print">
		<script type="text/javascript" src="include/effet/nifty.js"></script>');
		
		echo '<script type="text/javascript">
		window.onload=function(){
			if(!NiftyCheck()) return;
			Rounded("div.round","all","#B4E4E6","#B4E4E6","smooth, border #FFFFFF");}
		</script>';
		
	echo "<h3>Résultats de votre recherche</h3>";
	
	if ($nb>10) { 
		$secure=md5(session_id().$where);
		$nbpages=ceil($nb/10); $current=(round($first/10))+1;
		
		$pages="<center><div style='color:#999; text-align:center; padding:2px; background-color:#FFF; border:1px solid #999; width:50%'>";
			for ($i=1; $i<=$nbpages; $i++) {
				if ($i!=1) $pages.=" . ";
				if ($i==$current) $pages.= "<b>$i</b>";
				else $pages.= "<a href='?p=search&first=".(($i*10)-10)."&last=".($i*10)."&search_id=".base64_encode($where)."&secure=".$secure."'>$i</a>";
			}
		$pages.="</div></center>";
	}
	
	
	echo $pages."<br>";
	mini_fiche($sql,$first+1);
	echo $pages."<br><br>";
	foot();
			  
	
	
	
break;
}
?>
