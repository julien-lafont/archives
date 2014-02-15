{literal}
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout('$.scrollTo("#main", {speed:1000, axis:"y", easing:"expoout"}); $("#ppp").slideView() ', 1000);
	});
</script>
{/literal}

<br /><br />



<div id="ppp" class="svw">
	<ul>
		{section name=num start=1 loop=14 step=1}
		<li><img src="images/ppp/Diapositive{$smarty.section.num.index}.PNG" alt="Diapo {$smarty.section.num.index}" /></li>
		{/section}
	</ul>
</div>
<div class="center">
	<strong>Télécharger mon PPP</strong><br /> 
	<a href="telecharger/ppp.pdf" title="Télécharger mon PPP - Format pdf - 600 ko" class="noborder"><img src="images/pdf_min.png" alt="Pdf" /></a>
</div>