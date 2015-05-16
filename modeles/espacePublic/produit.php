<?php

$plxPlugin = $d["plxPlugin"];

if (is_array($plxPlugin->productGroupTitle())) {
	$i=0;
	
	foreach($plxPlugin->productGroupTitle() as $key => $value) {
		echo ($i>0?',':'').'<a href="'.$plxPlugin->productRUrl($key).'">'.$value.'</a>';
		$i=1;
	}
	
	echo '&nbsp;&rsaquo;&nbsp;'; $plxPlugin->productTitle();
	
} else {
	?>
		<a href="?product<?php $plxPlugin->productGroup(); ?>/">
			<?php echo $plxPlugin->productGroupTitle(); ?></a>
		&nbsp;&rsaquo;&nbsp;<?php $plxPlugin->productTitle();?>
	<?php
}

?>

<section class="product_content">
    <header>
        <div class="product_priceimage">
<a href="#panier" id="notiShoppingCart"><span id="notiNumShoppingCart"></span><img src="<?php echo PLX_PLUGINS; ?>plxMyShop/icon.png">&nbsp;Votre panier</a>
<?php echo ($plxPlugin->productImage()!=""?'<img class="product_image" src="'.$plxPlugin->productImage().'">':''); ?>
        </div>
        <span class="product_pricettc"><?php $plxPlugin->productPriceTTC(); ?><?php $plxPlugin->productDevice(); ?></span>
        <?php echo ((int)$plxPlugin->productPoidG()>0?'&nbsp;pour&nbsp;<span class="product_poidg">'.$plxPlugin->productPoidG().'Kg</span>':''); ?>
    </header>
    <article>
        <?php $plxPlugin->plxShowProductContent(); ?>
    </article>
	<?php
		$plxPlugin->donneesModeles["v"] = $plxPlugin->aProds[$this->productNumber()];
		$plxPlugin->donneesModeles["k"] = $plxPlugin->productNumber();
		$plxPlugin->modele("espacePublic/boucle/boutonPanier");
	?>
</section>