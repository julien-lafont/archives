<?php /* Smarty version 2.6.18, created on 2008-04-29 13:23:54
         compiled from inscription.tpl */ ?>
<div class="centre">
    <h1 class="style" class="width:100%">Service d'inscription au blog</h1>
    
    <p class="txt11">
    	Apr&egrave;s votre inscription, vous b&eacute;n&eacute;ficierez de nombreuses fonctionnalit&eacute;s suppl&eacute;mentaires.<br />
        Vous aurez ainsi la possibilit&eacute; de profiter d'une messagerie priv&eacute;, d'avoir un profil personnalis&eacute; ou encore de pouvoir poster des commentaires sans restriction.
     </p>
</div>     
     
     <div class="erreur" <?php if (isset ( $this->_tpl_vars['erreur'] )): ?>style="display:block"<?php endif; ?>><?php echo $this->_tpl_vars['erreur']; ?>
</div>
          
     <form action="inscription-valider.htm" name="inscription" method="post" onsubmit="verifier_form_inscription(); return false" class="style inscription">
     
     <fieldset class="cadre">
		<div class="infos_inscript" id="a1">
        	&nbsp;<img src="images/fleche_inclinee.gif" alt="-->" />&nbsp; <strong>identifiants</strong>
            <p>Cet identifiant vous sera demand&eacute; pour vous connecter au site.<br />
               <span>Entre 4 et 20 caract&egrave;res alphanum&eacute;riques sans espaces ( remplacez par - ou _ )</span>  
			</p>
        </div>
        <div class="champs">
        	 <label for="pseudo">Identifiant</label>
             <input type="text" id="pseudo" name="pseudo" onfocus="inscription_afficher(this); this.focus();" onkeyup="verif_pseudo2('pseudo');"/>  <span id="statut_pseudo"></span>
        </div>
    </fieldset>

    <fieldset class="cadre">
		<div class="infos_inscript" id="a2">
        	&nbsp;<img src="images/fleche_inclinee.gif" alt="-->" />&nbsp; <strong>adresse email</strong>
            <p>Entrez ici une adresse email valide qui vous permettra de valider votre inscription, ou de suivre un billet.</p>
        </div>
        <div class="champs">
        	 <label for="email">Adresse email</label>
             <input type="text" id="email" name="email"  onfocus="inscription_afficher(this);"  onkeyup="verif_email('email');"/> <span id="statut_email"></span>
        </div>
    </fieldset>
    
    <fieldset class="cadre">
		<div class="infos_inscript" id="a3">
        	&nbsp;<img src="images/fleche_inclinee.gif" alt="-->" />&nbsp; <strong>mot de passe</strong>
            <p>Choisissez un code secret qui vous service &agrave; vous connecter &agrave; votre compte. Pensez &agrave; choisir un mdp complexe !<br />
            	<span>Entre 4 et 20 caract&egrave;res alphanum&eacute;riques libres.</span><br />
                <br /><table>
                	<tr>
                    	<td style="width:400px; text-align:right">Niveau de s&eacute;curit&eacute; :</td>
                        <td><div style="width:100px; height:15px; border:1px solid #666; color:#000; text-align:center; font-size:11px; font-family:Georgia, "Times New Roman", Times, serif" id="indice_secu"></div></td>
                    </tr>
                </table>
                <div id="test"></div>
            </p>
            
        </div>
        <div class="champs">
        	 <label for="pass1">Mot de passe</label>
             <input type="password" id="pass1" name="pass1" onfocus="inscription_afficher(this);" onblur="verif_pass1('pass1');" onkeyup="testMdp('pass1', 'indice_secu')" /> <span id="statut_pass1"></span><br /><br />
             
             <label for="pass2">Confirmez</label>
             <input type="password" id="pass2" name="pass2"  onblur="verif_pass2('pass1', 'pass2');"/>  <span id="statut_pass2"></span>
        </div>
    </fieldset>
    
    <fieldset class="cadre">
		<div class="infos_inscript" id="a4">
        	&nbsp;<img src="images/fleche_inclinee.gif" alt="-->" />&nbsp; <strong>site / blog</strong>
            <p>Si vous poss&eacute;dez un site internet ou un blog et d&eacute;sirez que nos visiteurs puissent le voir, alors entrez son adresse ici.</p>
        </div>
        <div class="champs">
        	 <label for="site">Site / Blog</label>
             <input type="text" id="site" name="site"  onfocus="inscription_afficher(this);" onblur="verif_site('site');"/> <span id="statut_site"></span>
        </div>
    </fieldset>

    <br /><label for="submit_com">&nbsp;</label> &nbsp;&nbsp;&nbsp;<input type="image" src="templates/images/submit.png" class="image" id="submit_inscription"/>
                   
</form>