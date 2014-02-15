<?php

// ------------------------------------------------------------------------- //
// Classe d'accès à MySQL                                                    //
// ------------------------------------------------------------------------- //
// Auteur: Julien LAFON                            //
// Portail : Ix'Class                                                      //
// ------------------------------------------------------------------------- //



Class Sql {

/*
** Liste des variables
** de connexion à remplacer
** par les votres.
*/

private $mysql_user = "" ;        /* Login de connexion           */
private $mysql_pass = "" ;     /* Password de connexion        */
private $mysql_host = "localhost" ;  /* Adresse du serveur           */
private $mysql_db   = "" ;      /* Base de donnée principale    */
private $mysql_port = 3306 ;           /* Port de connexion à MySQL    */

/*
** Liste des variables internes
*/

private $mysql_connect_id ;            /* ID de connexion à MySQL      */
private $mysql_resultat ;              /* ID de résultat               */
private $mysql_num_res ;               /* Nombre de lignes retournées  */
private $last_id_insert ;              /* Dernier Auto-ID inséré       */

private $sqlerreurno = 0 ;             /* n° de l'erreur mysql                 */
private $sqlerreurmsg = "" ;           /* n° de l'erreur mysql                 */
private $erreurmsg  = "" ;             /* message de l'erreur mysql    */
public $debug              = 1 ;      /* Afficher les erreurs                 */

// ----------------------------------------------------------------------------

/* 
****    CONSTRUCTEUR AVEC ARGUMENTS MULTIPLES   ***
****    1 : login
****    2 : password
****    3 : host
****    4 : database
****    5 : port
*/

public function __construct()
{
    $numargs = func_num_args();
    switch($numargs) {
        // Sans argument, pas de connexion
        // (pour pouvoir changer un paramètre spécifique)
        case 0  :       
        case 1  :       break ; // juste pour le style :-)

        // deux arguments : login et mot de passe
        case 2  :       $this->mysql_user       = func_get_arg(0) ;
        $this->mysql_pass       = func_get_arg(1) ;
        $this->connect() ;
        break ;

        // trois arguments : login, password, et adresse du serveur
        case 3  :       $this->mysql_user       = func_get_arg(0) ;
        $this->mysql_pass       = func_get_arg(1) ;
        $this->mysql_host       = func_get_arg(2) ;
        $this->connect() ;
        break ;

        // quatre arguments : avec en plus la base de donnée à sélectionner             
        case 4  :       $this->mysql_user       = func_get_arg(0) ;
        $this->mysql_pass       = func_get_arg(1) ;
        $this->mysql_host       = func_get_arg(2) ;
        $this->mysql_db         = func_get_arg(3) ;
        $this->connect() ;
        break ;

        // Le port en plus
        case 5  :       $this->mysql_user       = func_get_arg(0) ;
        $this->mysql_pass       = func_get_arg(1) ;
        $this->mysql_host       = func_get_arg(2) ;
        $this->mysql_db         = func_get_arg(3) ;
        $this->mysql_port       = func_get_arg(4) ;
        $this->connect() ;
        break ;
    }
}

/* ---------------------------------------
** Fonction de connexion à la base
--------------------------------------- */

public function connect($db="-")
{
    /** Connexion à MySQL */
    $this->erreurno = 0 ;
    $this->mysql_connect_id =
       @mysql_pconnect($this->mysql_host.":".$this->mysql_port, 
                       $this->mysql_user, 
                       $this->mysql_pass)
       or $this->Erreur("Echec de connexion !") ;
    if($db!="-") $base = $db ;
    else $base = $this->mysql_db ;

    /** Sélection de la base de donnée */
    @mysql_select_db($base, $this->mysql_connect_id)
    or $this->Erreur("Séléction de la base IMPOSSIBLE !!") ;
}

/* ---------------------------------------
** Fonction de de-connexion à la base
--------------------------------------- */
public function close()
{
    @mysql_close($this->mysql_connect_id) ;
}

// ----------------------------------------------------------------------------

/* ---------------------------------------
** Selection d'une autre base de donnée
--------------------------------------- */

public function selectDb($db)
{
    @mysql_select_db($db, $this->mysql_connect_id)
    or $this->Erreur("Séléction de la base IMPOSSIBLE !!") ;
}

// ----------------------------------------------------------------------------

/* ----------------------------------
** Fonction d'éxecution de requètes
---------------------------------- */

public function query($query)
{
    /** Exécution de la requète passée en paramètre */
    $this->mysql_resultat = 
        @mysql_query($query, $this->mysql_connect_id)
        or $this->Erreur("Exécution de requète IMPOSSIBLE !!") ;

    if($this->sqlerreurno != 0) return false ;
    

    return $this->mysql_resultat;
}

// ----------------------------------------------------------------------------



/* --------------------------------------------------------
**      Retourne une ligne de resultat sous différentes formes
-------------------------------------------------------- */

// Tableau à indice numériques : $ligne[0] ;
public function getRow($sql)
{
    return mysql_fetch_row($sql) ;
}

// Tableau renvoyant sous la forme $ligne['chp1'] $ligne['chp2']
public function getRowAssoc($sql)
{
	return mysql_fetch_array($sql, MYSQL_ASSOC);  // ?

}

// Tableau à indice alphabétique : $ligne["ma_colonne"] ;               
public function getArray($sql)
{
    return $ligne = mysql_fetch_array($sql) ;
}


public function GetAllArray($sql)
{
	$lignes=array();
	while ($l=$this->getRowAssoc($sql)) {
		$lignes[]=$l;
	}
	return $lignes;
}

// Objet : $ligne->ma_colonne ;
public function getObject($sql)
{
    return mysql_fetch_object($sql) ;
}                               

// ----------------------------------------------------------------------------




public function last_id() {
	return mysql_insert_id();
}

public function nb($sql, $query=false) {
	if ($query) {
		$sql=$this->query($sql);
	}
	return round(mysql_num_rows($sql));
}


/* ------------------------------
** Fonction d'erreur
------------------------------ */

public function Erreur($error_string)
{
    /*
    ** Récuperation des messages et n° d'erreurs **
    */

    $this->sqlerreurno = mysql_errno() ;
    $this->erreurmsg = $error_string ;
    $this->sqlerreurmsg = mysql_error() ;

    /*
    ** En mode debug, on affiche le message et le n° de
    ** l'erreur en terminant le script.'*/

    if($this->debug == 1) {

    /*
    ** On ferme les balises susceptibles
    ** d'empecher l'affichage du message
    ** d'erreur.
    */

    print "</li></dl></ol></table></script>" ;

    /*
    ** On affiche l'erreur.
    */

    print "<font color=\"#FF0000\"><p><strong>Erreur : </strong>";
    print "$error_string </font><br>" ;
    print mysql_error() . "Erreur n° : " . mysql_errno() ;

    /*
    ** On arrete le script.
    */

    die() ;
    }
}

// ----------------------------------------------------------------------------
}