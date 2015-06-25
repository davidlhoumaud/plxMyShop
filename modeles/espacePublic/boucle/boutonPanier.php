<?php

$plxPlugin = $d["plxPlugin"];
$v = $plxPlugin->aProds[$d["k"]];

?>

<footer class="product_footer">
	<button class="product_addcart" onclick="addCart('<?php echo htmlspecialchars(plxMyShop::nomProtege($v['name'])); ?>', '<?php echo $v['pricettc']; ?>&nbsp;<?php echo $plxPlugin->getParam("devise");?> TTC<?php echo ((int)$v['poidg']>0?'&nbsp;pour&nbsp;'.$v['poidg'].'&nbsp;kg':''); ?>', '<?php echo $v['pricettc']; ?>', '<?php echo $v['poidg']; ?>','<?php echo $d["k"]; ?>');">
		Ajouter au panier</button>
</footer>
