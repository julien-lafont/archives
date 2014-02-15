<div class="centre">
    <h2>{$pseudo}, bienvenue sur votre espace personnel</h2><br /><br />
    
    <span class="txt11">Cette zone vous permet de modifier les informations de votre profil, de contacter un autre membre via notre messagerie internet et surtout de contribuer au site en soumettant du contenu.</span>
    <table style="width:80%; margin:30px auto" id="liste_lien_moncompte">
        <tr>
            <td style="width:50%; text-align:center"><a href="mon-compte-infos.htm" class="naviguer_moncompte" rel="infos"><strong>Mon profil</strong></a></td>
            <td style="width:50%; text-align:center"><a href="ma-messagerie.htm" class="naviguer_messagerie" rel="accueil"><strong>Messagerie interne</strong></a></td>
        </tr>
        <tr>
            <td style="text-align:center"><a href="mon-compte-infos.htm" class="naviguer_moncompte" rel="infos"><img src="images/membre/Login_Manager.png" alt="Profil" /></a></td>
            <td style="text-align:center"><a href="ma-messagerie.htm" class="naviguer_messagerie" rel="accueil"><img src="images/membre/chat.png" alt="Messagerie" /></a></td>
        </tr>
     	<tr>
        	<td style="text-align:center"><a href="membre-{$infos.id_membre}-{$infos.pseudo|recode}.htm" title="" class="naviguer_membre lien" rel="{$infos.id_membre}">&rsaquo; Voir ma fiche &lsaquo;</a></td>
            <td></td>
        </tr>
    </table>
</div>