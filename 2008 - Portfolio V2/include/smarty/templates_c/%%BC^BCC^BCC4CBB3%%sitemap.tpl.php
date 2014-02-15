<?php /* Smarty version 2.6.18, created on 2008-02-04 16:05:11
         compiled from sitemap.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
   <url>
      <loc><?php echo $this->_tpl_vars['URL']; ?>
</loc>
      <changefreq>always</changefreq>
   </url>
   <?php $_from = $this->_tpl_vars['liens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lien']):
?>
	<url>
		<loc><?php echo $this->_tpl_vars['URL']; ?>
<?php echo $this->_tpl_vars['lien']; ?>
</loc>
		<changefreq>always</changefreq>
	</url>
    <?php endforeach; endif; unset($_from); ?>
</urlset>