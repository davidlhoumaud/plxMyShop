<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/


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
			<a href="<?php echo htmlspecialchars($d["lienPanier"]);?>" id="notiShoppingCart">
				<span id="notiNumShoppingCart"></span>
                <img src="<?php echo PLX_PLUGINS; ?>plxMyShop/icon.png">&nbsp;<?php $plxPlugin->lang('L_PUBLIC_BASKET'); ?></a>
			<?php echo ($plxPlugin->aProds[$plxPlugin->productNumber()]["image"]!=""?'<img class="product_image" src="'.$plxPlugin->productImage().'">':''); ?>
        </div>
        <span class="product_pricettc"><?php echo $plxPlugin->pos_devise($plxPlugin->productPriceTTC()); ?></span>
        <?php echo ((int)$plxPlugin->productPoidG()>0?'&nbsp;'.$plxPlugin->lang('L_FOR').'&nbsp;<span class="product_poidg">'.$plxPlugin->productPoidG().'Kg</span>':''); ?>
    </header>
    <article>
        <?php $plxPlugin->plxShowProductContent(); ?>
    </article>
	<?php
		$plxPlugin->donneesModeles["k"] = $plxPlugin->productNumber();
		$plxPlugin->modele("espacePublic/boucle/boutonPanier");
	?>
</section>
