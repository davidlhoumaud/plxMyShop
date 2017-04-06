<?php if(!defined('PLX_ROOT')) exit; ?>

<h2>Help</h2>
<p>plxMyShop plugin help file</p>

<p>&nbsp;</p>
<h3>Installation</h3>
<p>Activate plugin.<br/>
Edit the template file "sidebar.php". Add following code where you want to see your mini basket :</p>
<pre>
	&lt;?php eval($plxShow-&gt;callHook(&#039;plxMyShopShowMiniPanier&#039;)); ?&gt;
</pre>





