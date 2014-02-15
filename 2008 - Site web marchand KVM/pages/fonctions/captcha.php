<?php
session_start();

##### Nombre de caractères de la chaine générés dans l'image #####
$taille_chaine = 5;

##### Taille de l'image #####
$width = 76; //horizontal
$height = 20; //vertical

##### Là, on défini le header de la page pour la transformer en image #####
header("Content-type: image/png");

##### Création de couleurs aléatoires #####
$foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //couleur du texte
$background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255)); //couleur du fond

##### Là, on cré notre image sans bordure #####
$_img = imagecreatetruecolor($width, $height);
imageantialias($_img, 1); //on applique un antialiasing

##### Là, on cré une image plus grande que l'originale pour s'en servir de bordure #####
$_img_border = imagecreatetruecolor($width+2, $height+2); //bordure de 1 pixel
$color_border = imagecolorallocate($_img_border, 0x99, 0x99, 0x99); //couleur du bord: #999999
imagefill($_img_border, 0, 0, $color_border);

##### On détruit les variables inutiles #####
unset($color_border);

##### On cré une image avec les couleurs définies #####
$foreground = imagecolorallocate($_img, $foreground_color[0], $foreground_color[1], $foreground_color[2]);
$background = imagecolorallocate($_img, $background_color[0], $background_color[1], $background_color[2]);
imagefill($_img, 0, 0, $background);

##### On cré un fond aléatoire #####
for( $i = 0; $i < 40; $i++ ) {
	$r = mt_rand (140, 255);
	$v = mt_rand (140, 255);
	$b = mt_rand (140, 255);
	$color = imagecolorallocate($_img, $r, $v, $b);
	imageline( $_img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $color);
	imagearc($_img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), 0, 360, $color);
}

##### Ici on crée la variable qui contiendra la chaine aléatoire #####
$aleat = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
$chaine = '';
for( $i = 0; $i < $taille_chaine; $i++ )
	$chaine .= $aleat[ mt_rand( 0, strlen ($aleat) - 1 ) ];

##### On détruit les variables inutiles #####
unset($aleat);

##### On a fini de créer la chaine aléatoire, on le rentre maintenant dans une variable de session #####
$_SESSION['captcha'] = $chaine;

##### On insere la chaine générée dans l'image #####
$j = 0;
for( $i = 0; $i < $taille_chaine; $i++ ) {
	if ($i === 0)
		$j = 3;
		
	imagestring($_img, mt_rand(7, 11), $j + $i * 14 + 3, 2, $chaine[$i], $foreground);
}

##### On détruit les variables inutiles #####
unset($chaine);
unset($taille_chaine);
unset($i);
unset($j);

// ##### On applique une déformation à l'image contenant le texte grace a un algorithme #####
	$_img_deforme = imagecreatetruecolor($width, $height);
	
	// periodes
	$rand1=mt_rand(900000,1000000)/10000000;
	$rand2=mt_rand(900000,1000000)/10000000;
	$rand3=mt_rand(900000,1000000)/10000000;
	$rand4=mt_rand(900000,1000000)/10000000;
	// phases
	$rand5=mt_rand(0,3141592)/500000;
	$rand6=mt_rand(0,3141592)/500000;
	$rand7=mt_rand(0,3141592)/500000;
	$rand8=mt_rand(0,3141592)/500000;
	// amplitudes
	$rand9=mt_rand(130,250)/110;
	$rand10=mt_rand(130,250)/110;

	for($x=0;$x<$width;$x++){
	    for($y=0;$y<$height;$y++){
	        $sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$width/2+($width/2)+1;
	        $sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

	        if($sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1){
	            $color=255;
	            $color_x=255;
	            $color_y=255;
	            $color_xy=255;
	        }else{
	            $color=imagecolorat($_img, $sx, $sy) & 0xFF;
	            $color_x=imagecolorat($_img, $sx+1, $sy) & 0xFF;
	            $color_y=imagecolorat($_img, $sx, $sy+1) & 0xFF;
	            $color_xy=imagecolorat($_img, $sx+1, $sy+1) & 0xFF;
	        }

	        if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
	            $newred=$foreground_color[0];
	            $newgreen=$foreground_color[1];
	            $newblue=$foreground_color[2];
	        }else if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
	        	$newred=$background_color[0];
	            $newgreen=$background_color[1];
	            $newblue=$background_color[2];
	        }else{
	            $frsx=$sx-floor($sx);
	            $frsy=$sy-floor($sy);
	            $frsx1=1-$frsx;
	            $frsy1=1-$frsy;

	            $newcolor=(
	                $color*$frsx1*$frsy1+
	                $color_x*$frsx*$frsy1+
	                $color_y*$frsx1*$frsy+
	                $color_xy*$frsx*$frsy);

	            if($newcolor>255) $newcolor=255;
	            $newcolor=$newcolor/255;
	            $newcolor0=1-$newcolor;

	            $newred=$newcolor0*$foreground_color[0]+$newcolor*$background_color[0];
	            $newgreen=$newcolor0*$foreground_color[1]+$newcolor*$background_color[1];
	            $newblue=$newcolor0*$foreground_color[2]+$newcolor*$background_color[2];
	        }

	        imagesetpixel($_img_deforme, $x, $y, imagecolorallocate($_img_deforme, $newred, $newgreen, $newblue));
	    }
	}

##### On détruit les variables inutiles #####
unset($foreground);
unset($foreground_color);
unset($background);
unset($background_color);
	
##### On détruit l'image sans les bords #####
imagedestroy($_img);

##### On applique la bordure a notre image déformée #####
imagecopymerge($_img_border, $_img_deforme, 1, 1, 0, 0, $width, $height, 100);

##### On détruit les variables inutiles #####
unset($width);
unset($height);

##### On détruit l'image sans les bords déformée #####
imagedestroy($_img_deforme);

##### On affiche l'image finale avec la bordure #####
imagepng($_img_border);

##### On détruit l'image finale #####
imagedestroy($_img_border);
?>