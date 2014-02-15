<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">

   <url>  
      <loc>{$URL}</loc>     
      <changefreq>always</changefreq>     
   </url>
   
   {foreach from=$liens item=lien}   
	<url>	
		<loc>{$URL}{$lien|recodeLight}</loc>		
		<changefreq>always</changefreq>		
	</url>	
	
    {/foreach}

</urlset>
