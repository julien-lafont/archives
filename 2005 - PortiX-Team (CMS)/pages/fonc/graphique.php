<?php
	

	function compare ($a, $b) {
		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

    $visites = array(138, 254, 381, 652, 896, 720, 140, 556, 663, 331, 407, 768);
    $visites2 = array(138, 254, 381, 652, 896, 720, 140, 556, 663, 331, 407, 768);
	usort ($visites2, "compare");
	$max=$visites2[0];

	
   header ("Content-type: image/png"); 
    $largeurImage = 50;
    $hauteurImage = 200;
    $im = ImageCreate ($largeurImage, $hauteurImage) 
            or die ("Erreur lors de la création de l'image");         
    $blanc = ImageColorAllocate ($im, 255, 255, 255); 
    $blanc2 = ImageColorAllocate ($im, 254, 254, 254); 
    $noir = ImageColorAllocate ($im, 0, 0, 0);  
    $bleu = ImageColorAllocate ($im, 0, 130, 255);  
	
		putenv('GDFONTPATH=' . realpath('.'));
		$font = 'pixel';		

		imagettftext($im, 6, 0, 23, $hauteurImage-2, $noir, $font, "JAN");
		imagettftext($im, 6, 0, 54, $hauteurImage-2, $noir, $font, "FEV");
		imagettftext($im, 6, 0, 80, $hauteurImage-2, $noir, $font, "MARS");
		imagettftext($im, 6, 0, 110, $hauteurImage-2, $noir, $font, "AVRIL");
		imagettftext($im, 6, 0, 144, $hauteurImage-2, $noir, $font, "MAI");
		imagettftext($im, 6, 0, 171, $hauteurImage-2, $noir, $font, "JUIN");
		imagettftext($im, 6, 0, 203, $hauteurImage-2, $noir, $font, "JUIL");
		imagettftext($im, 6, 0, 232, $hauteurImage-2, $noir, $font, "AOUT");
		imagettftext($im, 6, 0, 264, $hauteurImage-2, $noir, $font, "SEP");
		imagettftext($im, 6, 0, 294, $hauteurImage-2, $noir, $font, "OCT");
		imagettftext($im, 6, 0, 324, $hauteurImage-2, $noir, $font, "NOV");
		imagettftext($im, 6, 0, 354, $hauteurImage-2, $noir, $font, "DEC");

		
    $visitesMax = $max+55;
    $color_chiffre = ImageColorAllocate ($im, 0, 0, 0);


    for ($mois=1; $mois<=12; $mois++) {
        $hauteurImageRectangle = round(($visites[$mois-1]*$hauteurImage)/$visitesMax);
        ImageFilledRectangle ($im, $mois*30-7, $hauteurImage-$hauteurImageRectangle, $mois*30+7, $hauteurImage-10, $blanc2);
        imagettftext($im, 6, 0, $mois*30-10, $hauteurImage-$hauteurImageRectangle-5, $color_chiffre, $font, $visites[$mois-1]);
    }
    imagecolortransparent($im, $blanc);
    ImagePng ($im); 
?> 