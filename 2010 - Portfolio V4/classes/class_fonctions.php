<?php

class Fonctions
{
	
	// Définis dynamiquement les métatags description/keywords à partir d'un texte
	public static function metatag_seo($desc=NULL, $key=NULL) {
	
		global $m; 
		
		$F_post_content = $desc;
		$F_post_content = strip_tags($F_post_content);
		$F_post_content = strtr($F_post_content, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
		$F_post_content = preg_replace ('/('.CHR(9).'|'.CHR(13).'|'.CHR(10).')/', "", $F_post_content);
		$F_post_content = str_replace('"', '', $F_post_content);
			$trimed=trim($desc);
			
		$keywords=self::extraire_keywords($key);
		
			if (!empty($trimed)) $separateur1=" - ";
			if (!empty($keywords)) $separateur2=" , ";
		if (!empty($desc)) $m->design->assign('description', self::tronquerChaine($F_post_content.$separateur1.DESCRIPTION, 250));
		if (!empty($key))  $m->design->assign('keywords', self::tronquerChaine($keywords.$separateur2.KEYWORDS, 250));
	}

	// Transforme une chaine de caractère optimisée pour de l'URL Rewriting
	public static function recode($txt, $supprEsp=true){
		 $new= strtr($txt,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
		 $new = preg_replace('#\[#', '-', $new);
		 $new = preg_replace('#\]#', '-', $new);
		 $new = preg_replace("#[\\\'?!:,;|*=+°)(}{\#~&%$£<>./\"\$]#", "-", $new);
		 if ($supprEsp) $new = preg_replace("#[ ]#", "-", $new);
		 $new = preg_replace("#[-_]+#", "-", $new); /* Si plusieurs -- ou ___ on en met qu'un seul */
		 $new = preg_replace("#[-_]$#", "", $new); /* Vire le - ou _ final */
		 return $new;
	}

	// Extrait les mots clés importants à partir d'un texte
	public static function extraire_keywords($F_post_content) {
	
		$F_accuracy = 2; $F_length= 4;
		
		$F_mot_inutile = array( " de ", " etre "," par "," comme "," pour " ,  
		 " mais ", " ou ", " et ", " donc " ," or ", " ni ", " car ", 
		 " le ", " la ", " un ", " une ", " des ",
		 " comment " , " ont ", " of ",  " je " ," il ", " elle ", " nous ", " vous ", " en ", " vers ",  " tu ", " dans " , 
		 " suis ", " est " , " sont ",
		 " ton ", " ta ", " nos ", " mon ", "son",  
		 " tout " ," ce " , " sur ", " que ", " plus ", " avec ", " pas ", " sans ", " ai ", " as ", " a ", " avons ", " ont ", " suis ", " es",  
		 " dont ", " autre ", " non " , " oui ",   " bon " ,  " de ", ",", "<?php", " du ", " au ", 
		 ".", "'", "(", ")", "{", "}", "[", "]", "{", "}", "=", "+", "-", "*", "?", "/", '"',
		 " a ", ":", ";", " d ", " l ", " c ", " s ", " t ", "  ", "\n", "\r", "\t", "&nbsp;", "&nbsp");
		  
		$F_accent = array( "à", "ä", "â", "â", "é", "è", "ë", "ê", "ï", "î", "ô", "ö", "ù", "ü", "û", "ç", "&eacute", "&agrave" );
		$F_nacc = array( "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "o", "o", "u", "u", "u", "c", "e", "a" );
		
		$F_post_content =strip_tags($F_post_content);
		$F_post_content = str_replace( $F_accent, $F_nacc, $F_post_content );
		$F_post_content = strtolower( $F_post_content);
		$F_post_content = str_replace($F_mot_inutile, " ", $F_post_content );
		$F_split_words = split( " ", $F_post_content );
	
		$F_tab_words = array();
		foreach( $F_split_words as $F_word )
			if ( strlen( $F_word ) > $F_length )
				$F_tab_words[ $F_word ]++;
	
		ksort( $F_tab_words );	
		
		foreach( $F_tab_words as $F_word => $F_pop ) {
			if ( isset( $F_tab_words[ $F_word."s" ] )) {
				$F_tab_words[ $F_word ] = $F_pop + $F_tab_words[ $F_word."s" ];
				unset( $F_tab_words[ $F_word."s" ] );
			}
		}
		
		arsort( $F_tab_words );
	
		$F_split_words = array();
		foreach( $F_tab_words as $F_word => $F_pop )
			if ($F_pop >= $F_accuracy )
				$F_split_words[] = $F_word;
	
		$F_keywords = $F_split_words[ 0 ];
		$F_i = 1;
		while ( $F_i < count( $F_split_words ) && strlen ($F_keywords.", ".$F_split_words[ $F_i]) < 1000 ) {
			$F_keywords .= ",".$F_split_words[$F_i];
			$F_i++;
		}
	
		return $F_keywords;	
		
	}

	// Tronque une chaine au bout de $max caractères
	public static function tronquerChaine($chaine, $max=100, $points=true)
	{
		if(strlen($chaine)>=$max){
		   $chaine=substr($chaine,0,$max); 
		   if ($points=="dot") $chaine.="&rsaquo;";
		   else if ($points) $chaine.=" ..."; 
		}  
		return $chaine;
	}

	// Echappe un caractère ou un tableau de caractères
	public static function escape($txt) {
	
		if(is_array($txt)){
			foreach($txt as $n=>$v){
				 if (!get_magic_quotes_gpc())	$txt[$n]=mysql_real_escape_string(urldecode($v));
				 else							$txt[$n]=mysql_real_escape_string(stripslashes(urldecode($v)));
			}
			return $txt;
		} 
		else
		{
			 if (!get_magic_quotes_gpc())	return mysql_real_escape_string($txt);
			 else							return mysql_real_escape_string(stripslashes($txt));
		}
	
	}	

	// Sécurise une variable ou un tableau avant l'envoie dans une requête sql
	public static function addBdd($txt)
	{
		if(is_array($txt)){
			foreach($txt as $n=>$v){
				 if (!get_magic_quotes_gpc())	$txt[$n]=addslashes(htmlspecialchars(urldecode($v)));
				 else							$txt[$n]=addslashes(htmlspecialchars(stripslashes(urldecode($v))));
			}
			return $txt;
		} 
		else
		{
			 if (!get_magic_quotes_gpc())	return addslashes(htmlspecialchars(trim(urldecode($txt))));
			 else							return addslashes(htmlspecialchars(stripslashes(trim(urldecode($txt )))));
		}
	}

	// Récupère une variable ou un tableau précédemment sécurisé via la fonction addBdd
	public static function recupBdd($txt)
	{
		if(is_array($txt)){
			foreach($txt as $n=>$v){
				 $txt[$n]=stripslashes($v);
			}
			return $txt;
		} 
		else
		{
			 return stripslashes($txt);
		}
	}


	// Echo spécial compressant le texte ( suppression saut à la lignes, espaces redondants ... ).
	public static function echoAjax($txt, $json=false)
	{
		$txt = preg_replace ('/('.CHR(13).'|'.CHR(10).')/', "", $txt);
		if ($json) $txt = preg_replace ('#\'#', '\\\'', $txt);
		echo trim($txt);
	}

	// Différence entre une date et aujourd'hui
	public static function difference_date($time) {
		$now=time();
		$diff=$now-$time;
		if ($diff<=60) $r=$diff."s";
		if ($diff>60 && $diff<=3600 ) $r=round(($diff/60))."mn";
		if ($diff>3600 && $diff<=86400) $r=round(($diff/3600))."h";
		if ($diff>86400) $r=round(($diff/86400))."j";
		return $r;
	}
	
	// Génère une clé aléatoire
	public static function GenKey($nbcaract = 8)
	{
		$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		for($i = 0;$i < $nbcaract;$i++) {
			@$str .= $string[mt_rand() % strlen($string)];
		} 
		return $str;
	} 
	
	// Trouve l'adresse IP ( à traver un proxy faible sécurité )
	public static function ip() {
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];}
		elseif(isset($_SERVER['HTTP_CLIENT_IP'])) { $ip  = $_SERVER['HTTP_CLIENT_IP']; }
		else {$ip = $_SERVER['REMOTE_ADDR']; }
		return $ip;
	}

	// Cré une barre d'avancement
	public static function barre($pourc)
	{
		echo '<div style="border:1px solid #8E8E8E;width:300px;height:15px"><div style="background-color:#B91313;width:'.(3*$pourc).'px;height:15px;font-size:8pt;color:white">&nbsp;'.$pourc.'%</div></div>';
	}
	
	// Fonction qui formate une date quelconque en un format choisis avec strftime
	public static function formatDate($date, $format, $langue = "fr_FR")
	{
		$date = strtotime($date);
		setlocale (LC_ALL, $langue);
		return strftime($format, $date);
	}
	
	// Retourne un datetime sql au format RFC822, pour les flux RSS 2.0
	public static function date_rss($date_sql) 
	{
		$newstime = $date_sql;
        list($date, $hours) = split(' ', $newstime);
        list($year,$month,$day) = split('-',$date);
        list($hour,$min,$sec) = split(':',$hours);
 
 		return date(r,mktime($hour, $min, $sec, $month, $day, $year));
	}


	// Fonction plus que basique : envoyer un mail en HTML
	public static function email( $dest, $sujet, $message, $from )
	{
	
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: ".$from."\n";
	
		return mail( $dest, $sujet, $message, $headers );
	
	}

	// Met en forme une url et la tronque si nécessaire
	public static function formater_url($url, $link = '')
	{
		global $pun_user;
	
		$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
		if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
			$full_url = 'http://'.$full_url;
		else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
			$full_url = 'ftp://'.$full_url;
		else if (!preg_match('#^([a-z0-9]{3,6})://#', $url, $bah)) 	// Else if it doesn't start with abcdef://, we add http://
			$full_url = 'http://'.$full_url;
	
		// Ok, not very pretty :-)
		$link = ($link == '' || $link == $url) ? ((strlen($url) > 40) ? substr($url, 0 , 29).' &hellip; '.substr($url, -5) : $url) : stripslashes($link);
	
		return '<a href="'.$full_url.'">'.$link.'</a>';
	}
}
?>