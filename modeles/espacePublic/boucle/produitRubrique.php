<?php

$plxPlugin = $d["plxPlugin"];

?>

<div class="lproduct_content" align="center">
	<header>
		<h1 class="product_poidg"><a href="<?php echo $plxPlugin->productRUrl($d["k"]); ?>" ><?php echo $d["v"]['name']; ?></a></h1>
		<?php echo $d["v"]['image'] != ''
			? '<a href="'.$plxPlugin->productRUrl($d["k"]).'"><img class="product_image" src="'.$d["v"]['image'].'"></a>'
			: '<a href="'.$plxPlugin->productRUrl($d["k"]).'"><img class="product_image" src="'.PLX_PLUGINS.'plxMyShop/images/none.png"></a>';
		?><br>
		<span class="lproduct_pricettc"><?php echo $d["v"]['pricettc']. "&nbsp;" . $d["v"]['device']; ?></span>
		<?php echo (int)$d["v"]['poidg']>0?'&nbsp;pour&nbsp;<span class="product_poidg">'.$d["v"]['poidg'].'&nbsp;kg</span>':'';?>
	</header>
	<?php
		$plxPlugin->modele("espacePublic/boucle/boutonPanier");
	?>
</div>
