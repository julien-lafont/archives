<?php /* Smarty version 2.6.18, created on 2008-04-18 17:00:17
         compiled from buddylist.tpl */ ?>
<div class="titre">
	<div class="g"></div>
	<h2>GERER MES GROUPES D'AMIS</h2>
	<div class="d"></div>
</div>
<div class="bloc buddy">

	<p>Utilisez cet espace pour gérer vos buddy-list, c'est à dire vos <strong>groupes de contacts</strong>. <br />
	L'étape de diffusion des questionnaire en sera alors facilité : pas de doublon dans les adresses, choix rapide des groupes à qui envoyer chaque questionnaire, etc...</p> 

	<h1>Gérer mes amis manuellement</h1>
	
	
	<table class="quart" style="margin-bottom:30px">
		<tr>
			<td>
				<div class="bloc1">
					<h2>Amis 'Mecs'</h2>
					<ul id="liste_h">
					<?php $_from = $this->_tpl_vars['liste']['h']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
						<?php if (! empty ( $this->_tpl_vars['elem']['1'] )): ?>
							<li><abbr title="<?php echo $this->_tpl_vars['elem']['1']; ?>
"><?php echo $this->_tpl_vars['elem']['0']; ?>
</abbr> <img src="images/bullet_delete.png" class="suppr_buddy" alt="h"/></li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				</div>
				<div class="bloc1" style="height:38px; text-align:left">
					<input type="text" id="aj_nom_h" value="Nom de l'amis" onfocus="this.value='';"/>  &nbsp; <img src="images/ajouter.png" class="ajouter_buddy" alt="h" /><br />
					<input type="text" id="aj_email_h" value="Email de l'amis" onfocus="this.value='';"/>
				</div>
			</td>
			<td>
				<div class="bloc2">
					<h2>Amis 'Femmes'</h2>
					<ul id="liste_f">
					<?php $_from = $this->_tpl_vars['liste']['f']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
						<?php if (! empty ( $this->_tpl_vars['elem']['1'] )): ?>
							<li><abbr title="<?php echo $this->_tpl_vars['elem']['1']; ?>
"><?php echo $this->_tpl_vars['elem']['0']; ?>
</abbr> <img src="images/bullet_delete.png" class="suppr_buddy" alt="f"/></li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				</div>
				<div class="bloc2" style="height:38px; text-align:left">
					<input type="text" id="aj_nom_f" value="Nom de l'amis" onfocus="this.value='';"/>  &nbsp; <img src="images/ajouter.png" class="ajouter_buddy" alt="f" /><br />
					<input type="text" id="aj_email_f" value="Email de l'amis" onfocus="this.value='';"/>
				</div>
			</td>
			<td>
				<div class="bloc3">
					<h2>Groupe perso A</h2>
					<ul id="liste_p1">
					<?php $_from = $this->_tpl_vars['liste']['p1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
						<?php if (! empty ( $this->_tpl_vars['elem']['1'] )): ?>
							<li><abbr title="<?php echo $this->_tpl_vars['elem']['1']; ?>
"><?php echo $this->_tpl_vars['elem']['0']; ?>
</abbr> <img src="images/bullet_delete.png" class="suppr_buddy" alt="p1"/></li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				</div>
				<div class="bloc3" style="height:38px; text-align:left">
					<input type="text" id="aj_nom_p1" value="Nom de l'amis" onfocus="this.value='';"/>  &nbsp; <img src="images/ajouter.png"  class="ajouter_buddy" alt="p1" /><br />
					<input type="text" id="aj_email_p1" value="Email de l'amis" onfocus="this.value='';"/>
				</div>
			</td>
			<td>
				<div class="bloc4">
					<h2>Groupe perso B</h2>
					<ul id="liste_p2">
					<?php $_from = $this->_tpl_vars['liste']['p2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elem']):
?>
						<?php if (! empty ( $this->_tpl_vars['elem']['1'] )): ?>
							<li><abbr title="<?php echo $this->_tpl_vars['elem']['1']; ?>
"><?php echo $this->_tpl_vars['elem']['0']; ?>
</abbr> <img src="images/bullet_delete.png" class="suppr_buddy" alt="p2"/></li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				</div>
				<div class="bloc4" style="height:38px; text-align:left">
					<input type="text" id="aj_nom_p2" value="Nom de l'amis" onfocus="this.value='';"/>  &nbsp; <img src="images/ajouter.png"  class="ajouter_buddy" alt="p2" /><br />
					<input type="text" id="aj_email_p2" value="Email de l'amis" onfocus="this.value='';"/>
				</div>
			</td>
		</tr>
	</table>
	
	<h1>Ajout assisté à partir de mes contacts msn.</h1>
	
	<p>Bientôt disponible !</p>
	
</div>
<div class="b"></div>