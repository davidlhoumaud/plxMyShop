<?php if(!defined('PLX_ROOT')) exit; ?>

<h2>Aide</h2>
<p>Fichier d&#039;aide du plugin plxMyShop</p>

<p>&nbsp;</p>
<h3>Installation</h3>
<p>Pensez &agrave; activer le plugin.<br/>
Editez le fichier template "sidebar.php". Ajoutez y le code suivant &agrave; l&#039;endroit o&ugrave; vous souhaitez voir apparaitre le mini panier:</p>
<pre>
	&lt;?php eval($plxShow-&gt;callHook(&#039;plxMyShopShowMiniPanier&#039;)); ?&gt;
</pre>

