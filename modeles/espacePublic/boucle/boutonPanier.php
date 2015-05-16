
<footer class="product_footer">
	<button class="product_addcart" onclick="addCart('<?php echo htmlspecialchars(plxMyShop::nomProtege($d["v"]['name'])); ?>', '<?php echo $d["v"]['pricettc']; ?><?php echo $d["v"]['device']; ?> TTC<?php echo ((int)$d["v"]['poidg']>0?'&nbsp;pour&nbsp;'.$d["v"]['poidg'].'Kg':''); ?>', <?php echo $d["v"]['pricettc']; ?>, <?php echo $d["v"]['poidg']; ?>,'<?php echo $d["k"]; ?>');">
		Ajouter au panier</button>
</footer>
