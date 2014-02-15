<?php

class Toolbox {

  /**
   * Retourne le slug de la chaine de caractère
   * @param string $string
   * @return string
   */
  public static function slugify($string)
  {
    return Doctrine_Inflector::urlize($string);
  }

  /**
   * Retourne la chaine de caractère désaccentuée
   * @param string $string
   * @return string
   */
  public static function unaccent($string)
  {
    return Doctrine_Inflector::unaccent($string);
  }

  /**
   * Formatte un texte pour le générer un metatag description
   * @param string $string
   * @param int $taille
   * @return string
   */
  public static function format_meta_desc($string, $taille=100)
  {
    $string = strip_tags($string);
    if (strlen($string) > $taille)
    {
      $string = substr($string, 0, $taille);
      $string = substr($string, 0, strrpos($string, " "))."...";
    }
    return $string;
  }

  /**
   * L'appel provient t-il de la tâche doctrine:raw-dump ?
   * @return boolean
   */
  public static function isRawDump()
  {
    return isset($_SERVER['SCRIPT_NAME']) && $_SERVER['SCRIPT_NAME']=="symfony" && $_SERVER['argc']>=3 && $_SERVER['argv'][1]=='doctrine:raw-dump';

  }

  /**
   * 
   * @param unknown_type $Directory
   * @param array $extensions
   * @return array of Images
   */
  public static function scanDirectory($dossier_upload, array $extensions = null){
    $res = array();
    
    $dossier = sfConfig::get('sf_web_dir').$dossier_upload;
    
    if (is_dir($dossier) && is_readable($dossier)) 
    {
      if($MyDirectory = opendir($dossier)) 
      {
        while($fichier = readdir($MyDirectory)) 
        {
          if ($extensions !=null && !preg_match("#.(".implode("|", $extensions).")$#", strtolower($fichier))) continue;
          $res[] = array(
            $dossier_upload,
            $fichier
          );
          //$res[]= new Image(sfConfig::get('sf_web_dir').$dossier_upload, $fichier);
        }
        closedir($MyDirectory);
      }
    }
    
    return $res;

  }
  
  /**
   * Retourne si l'ip en cours est une ip autorisée
   * @return boolean
   */
  public static function checkIp()
  {
    $ips = sfConfig::get("app_ip");
    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip == $ips;
  }
  
  public static function isIE6() {
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if (stristr( $userAgent, "msie 6.0" )) {
      return true;
    } else {
      return false;
    }
  }
    
  /**
   * Get the last tweets of a twitter user
   * @param $login User name
   * @param $nbTweets Number of statuses to get
   * @return Array of statuses, each status has keys "text", "date" and "id"
   */
  public static function get_last_tweets($login, $nbTweets)
  {
    $tweets = array();
  
    if ($file = @file_get_contents("http://www.twitter.com/statuses/user_timeline.json?screen_name=".$login."&count=".$nbTweets))
    {
      $tab = json_decode($file);
  
      foreach ($tab as $status)
      {
        $tweets[] = array(
            'text' => replace_twitter_user_names(replace_text_url($status->text)),
            'date' => format_date_diff(strtotime($status->created_at)),
            'id'   => $status->id,
        );
      }
    }
    else
    {
      $tweets[] = array(
          'text' => "Access to this user's tweets is denied",
          'date' => '',
          'id'   => '',
      );
    }
  
    return $tweets;
  }
}