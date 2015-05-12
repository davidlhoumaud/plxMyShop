
<div class="lproduct_content" align="center">
	<header>
		<h1 class="product_poidg"><a href="<?php echo $d["plxPlugin"]->productRUrl($d["k"]); ?>" ><?php echo $d["v"]['name']; ?></a></h1>
		<?php echo $d["v"]['image'] != ''
			? '<a href="'.$d["plxPlugin"]->productRUrl($d["k"]).'"><img class="product_image" src="'.$d["v"]['image'].'"></a>'
			: '<a href="'.$d["plxPlugin"]->productRUrl($d["k"]).'"><img class="product_image" src="'.PLX_PLUGINS.'plxMyShop/none.png"></a>';
		?><br>
		<span class="lproduct_pricettc"><?php echo $d["v"]['pricettc'].$d["v"]['device']; ?></span>
		<?php echo ((int)$d["v"]['poidg']>0?'&nbsp;pour&nbsp;<span class="product_poidg">'.$d["v"]['poidg'].'Kg</span>':''); ?>
	</header>
	<footer class="product_footer">
		<button class="product_addcart" onclick="addCart('<?php echo $d["v"]['name']; ?>', '<?php echo $d["v"]['pricettc']; ?><?php echo $d["v"]['device']; ?> TTC<?php echo ((int)$d["v"]['poidg']>0?'&nbsp;pour&nbsp;'.$d["v"]['poidg'].'Kg':''); ?>', <?php echo $d["v"]['pricettc']; ?>, <?php echo $d["v"]['poidg']; ?>,'<?php echo $d["k"]; ?>');">
			Ajouter au panier</button>
	</footer>
</div>
