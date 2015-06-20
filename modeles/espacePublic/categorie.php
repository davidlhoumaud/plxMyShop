<?php

$plxPlugin = $d["plxPlugin"];

?>

<section class="list_products">
    <header>
        <div class="product_priceimage">
			<a href="<?php echo htmlspecialchars($d["lienPanier"]);?>" id="notiShoppingCart">
				<span id="notiNumShoppingCart"></span><img src="<?php echo PLX_PLUGINS; ?>plxMyShop/icon.png">&nbsp;Votre panier</a>
        </div>
        <div class="cat_image">
			<?php echo ($plxPlugin->aProds[$plxPlugin->productNumber()]["image"]!="") ? '<img class="product_image_cat" src="'.$plxPlugin->productImage().'">' : '';?>
        </div>
    </header>
    <article>
        <?php $plxPlugin->plxShowProductContent(); ?>
    </article>
    <?php
		if (isset($plxPlugin->aProds)) {
			foreach($plxPlugin->aProds as $k => $v) {
				if (	preg_match('#'.$plxPlugin->productNumber().'#', $v['group']) 
					&&	$v['active']==1 
					&&	$v['readable']==1
				) {
					
					$plxPlugin->donneesModeles["k"] = $k;
					
					$plxPlugin->modele("espacePublic/boucle/produitRubrique");
					
				}
			}
		}
	?>
</section>
