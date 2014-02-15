<?php /* Smarty version 2.6.18, created on 2008-04-18 19:00:26
         compiled from index.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<title><?php echo $this->_tpl_vars['titrePage']; ?>
 - <?php echo $this->_tpl_vars['nomSite']; ?>
</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
	<meta name="Keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
	<meta name="generator" content="www.Studio-Dev.fr - Julien LAFONT" />
	
	<script type="text/javascript" src="javascript/librairies/jquery.js"></script>
	<script type="text/javascript" src="javascript/-general.js"></script>
	<script type="text/javascript" src="javascript/-verifs.js"></script>

	<link rel="stylesheet" href="styles_min.css" type="text/css" />	
    <!--[if IE 6]> <link rel="stylesheet" type="text/css" href="templates/styles_ie6.css" /> <![endif]-->	
    <?php echo $this->_tpl_vars['header']; ?>

    
</head>
<body>

<div id="page">

	<div id="header">
    	<div id="logo"><a href="./" title="#"></a></div>
        <div id="pub"></div>
    </div>


	<div id="bandeau">
    	<div class="left">
        	<div id="connexion">
        	

	             	  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_blocs/login.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                
            </div>
            <div id="visiteurs">13 connectés,  25 visiteurs et 3000 avis remplis</div>
      </div>
      
        <div class="right">
        	<ul>
            	<li class="inscrip ">
                	<div class="image <?php if ($this->_tpl_vars['est_connecte']): ?>barre<?php endif; ?>"><a href="inscription.htm" title="Inscrivez-vous sur Nixtee pour commencer à personnaliser vos questionnaires."><img src="images/pix.gif" width="45" height="45" alt="" /></a></div>
                    <div class="texte <?php if ($this->_tpl_vars['est_connecte']): ?>barre<?php endif; ?>">
                    	<h4><a href="inscription.htm" title="Inscrivez-vous sur Nixtee pour commencer à personnaliser vos questionnaires.">PAS ENCORE INSCRIT(E) ?</a></h4>
                        <h5>Vous devez passer par cette étape pour créer vos questionnaires</h5>
                    </div>
                </li>
            	<li class="log">
                	<div class="image"><a href="#" title=""><img src="images/pix.gif" width="45" height="45" alt="" /></a></div>
                    <div class="texte">
                    	<h4><a href="mon-compte.htm" title="Accéder à mon compte : mes avis et mes questionnaires">MON COMPTE NIXTEE.COM</a></h4>
                        <h5>Crée tes questionnaires, lis les avis de tes amis et consulte tes questionnaires</h5>
                    </div>
                </li> 
                
            	<li class="rechercher">
                	<div class="image"><a href="#" title=""><img src="images/pix.gif" width="45" height="45" alt="" /></a></div>
                    <div class="texte">
                    	<h4><a href="#" title="">RECHERCHER UN AMI !</a></h4>
                        <h5>Et remplit le(s) questionnaire(s) sur leur personnalité en tout anonymat.</h5>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    
    
    
    <div id="contenu">
    	
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['page']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        
    </div>    
          
    <div id="tops">
    
    	<div class="gauche">
            <div class="h"><h3>Tops 1 caché</h3></div>
            <div class="bloc">
                <table>
                	<tr>
                    	<td colspan="2" class="titre">&nbsp;<b>P s e u d o</b></td>
                        <td colspan="2" class="titre">&nbsp;<b>N o t e</b></td>
                    </tr>
                    <tr>
                    	<td class="classement">1.</td>
                    	<td class="pseudo"><a href="#" title="">YoTsumi</a></td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>
                    <tr>
                    	<td class="classement">2.</td>
                    	<td class="pseudo"><a href="#" title="">YoTsumi</a></td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                

                    <tr>
                    	<td class="classement">3.</td>
                    	<td class="pseudo"><a href="#" title="">YoTsumi</a></td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">4.</td>
                    	<td class="pseudo"><a href="#" title="">YoTsumi</a></td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">5.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>            
                    <tr>
                    	<td class="classement">6.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>
                    <tr>
                    	<td class="classement">7.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                

                    <tr>
                    	<td class="classement">8.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">9.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">10.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/etoile2.png" alt="Or" /></td>
                    	<td class="note">13.66</td>
                    </tr> 
                 </table>                    
            </div>
            <div class="b"></div>
        </div>
        
        <div class="centre">
        	<div id="presentation"></div>
        </div>
        
        <div class="droite">
            <div class="h"><h3>Tops 2 caché</h3></div>
            <div class="bloc">
                <table>
                	<tr>
                    	<td colspan="2" class="titre">&nbsp;<b>P s e u d o</b></td>
                        <td colspan="2" class="titre">&nbsp;<b>A m i s</b></td>
                    </tr>
                    <tr>
                    	<td class="classement">1.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">132</td>
                    </tr>
                    <tr>
                    	<td class="classement">2.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">121</td>
                    </tr>                

                    <tr>
                    	<td class="classement">3.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">103</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">4.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">99</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">5.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">95</td>
                    </tr>            
                    <tr>
                    	<td class="classement">6.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">91</td>
                    </tr>
                    <tr>
                    	<td class="classement">7.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">86</td>
                    </tr>                

                    <tr>
                    	<td class="classement">8.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">83</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">9.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">82</td>
                    </tr>                     
                    <tr>
                    	<td class="classement">10.</td>
                    	<td class="pseudo">YoTsumi</td>
                    	<td><img src="images/silouhette.png" alt="Or" /></td>
                    	<td class="note">59</td>
                    </tr> 
                 </table>                    
            </div>
            <div class="b"></div>
       </div>
       
   </div>
   
   <br class="clear" />
   <div id="footer">
   	  <div class="g">
    	 Développement <span>2.0</span> réalisé par <strong>Julien LAFONT</strong> pour <a href="#" title="">Studio-dev.fr</a>. Webdesign par Samuel Hubert<br />
   		 Pour toute réclamation, contactez le staff.
      </div>
        
      <div class="d">
      	<img src="images/css.png" alt="" /><br />
        <img src="images/xhtml.png" alt="" />
      </div>  
        
    </div>
  
</div>


            

</body>
</html>