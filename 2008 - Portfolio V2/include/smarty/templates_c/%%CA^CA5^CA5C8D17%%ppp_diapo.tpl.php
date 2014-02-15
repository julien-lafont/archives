<?php /* Smarty version 2.6.18, created on 2008-08-13 17:32:20
         compiled from fr/_quisuisje/ppp_diapo.tpl */ ?>
<?php echo '
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(\'$.scrollTo("#main", {speed:1000, axis:"y", easing:"expoout"}); $("#ppp").slideView() \', 1000);
	});
</script>
'; ?>


<br /><br />



<div id="ppp" class="svw">
	<ul>
		<?php unset($this->_sections['num']);
$this->_sections['num']['name'] = 'num';
$this->_sections['num']['start'] = (int)1;
$this->_sections['num']['loop'] = is_array($_loop=14) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['num']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['num']['show'] = true;
$this->_sections['num']['max'] = $this->_sections['num']['loop'];
if ($this->_sections['num']['start'] < 0)
    $this->_sections['num']['start'] = max($this->_sections['num']['step'] > 0 ? 0 : -1, $this->_sections['num']['loop'] + $this->_sections['num']['start']);
else
    $this->_sections['num']['start'] = min($this->_sections['num']['start'], $this->_sections['num']['step'] > 0 ? $this->_sections['num']['loop'] : $this->_sections['num']['loop']-1);
if ($this->_sections['num']['show']) {
    $this->_sections['num']['total'] = min(ceil(($this->_sections['num']['step'] > 0 ? $this->_sections['num']['loop'] - $this->_sections['num']['start'] : $this->_sections['num']['start']+1)/abs($this->_sections['num']['step'])), $this->_sections['num']['max']);
    if ($this->_sections['num']['total'] == 0)
        $this->_sections['num']['show'] = false;
} else
    $this->_sections['num']['total'] = 0;
if ($this->_sections['num']['show']):

            for ($this->_sections['num']['index'] = $this->_sections['num']['start'], $this->_sections['num']['iteration'] = 1;
                 $this->_sections['num']['iteration'] <= $this->_sections['num']['total'];
                 $this->_sections['num']['index'] += $this->_sections['num']['step'], $this->_sections['num']['iteration']++):
$this->_sections['num']['rownum'] = $this->_sections['num']['iteration'];
$this->_sections['num']['index_prev'] = $this->_sections['num']['index'] - $this->_sections['num']['step'];
$this->_sections['num']['index_next'] = $this->_sections['num']['index'] + $this->_sections['num']['step'];
$this->_sections['num']['first']      = ($this->_sections['num']['iteration'] == 1);
$this->_sections['num']['last']       = ($this->_sections['num']['iteration'] == $this->_sections['num']['total']);
?>
		<li><img src="images/ppp/Diapositive<?php echo $this->_sections['num']['index']; ?>
.PNG" alt="Diapo <?php echo $this->_sections['num']['index']; ?>
" /></li>
		<?php endfor; endif; ?>
	</ul>
</div>
<div class="center">
	<strong>Télécharger mon PPP</strong><br /> 
	<a href="telecharger/ppp.pdf" title="Télécharger mon PPP - Format pdf - 600 ko" class="noborder"><img src="images/pdf_min.png" alt="Pdf" /></a>
</div>