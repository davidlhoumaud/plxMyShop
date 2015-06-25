<?php

$plxPlugin = $d["plxPlugin"];
$v = $plxPlugin->aProds[$d["k"]];

?>

<div class="lproduct_content" align="center">
	<header>
		<h1 class="product_poidg"><a href="<?php echo $plxPlugin->productRUrl($d["k"]); ?>" ><?php echo $v['name']; ?></a></h1>
		<?php echo $v['image'] != ''
			? '<a href="'.$plxPlugin->productRUrl($d["k"]).'"><img class="product_image" src="'.$plxPlugin->plxMotor->urlRewrite(PLX_ROOT.$plxPlugin->cheminImages.$v['image']).'"></a>'
			: '<a href="'.$plxPlugin->productRUrl($d["k"]).'"><img class="product_image" src="'.PLX_PLUGINS.'plxMyShop/images/none.png"></a>';
		?><br>
		<span class="lproduct_pricettc"><?php echo $v['pricettc']. "&nbsp;" . $plxPlugin->getParam("devise");?></span>
		<?php echo (int)$v['poidg']>0?'&nbsp;pour&nbsp;<span class="product_poidg">'.$v['poidg'].'&nbsp;kg</span>':'';?>
	</header>
	<?php
		$plxPlugin->modele("espacePublic/boucle/boutonPanier");
	?>
</div>
