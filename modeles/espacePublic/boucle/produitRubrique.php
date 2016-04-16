<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/


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
		<span class="lproduct_pricettc"><?php echo $plxPlugin->pos_devise($v['pricettc']);?></span>
		<?php echo (int)$v['poidg']>0?'&nbsp;'.$plugin->lang('L_FOR').'&nbsp;<span class="product_poidg">'.$v['poidg'].'&nbsp;kg</span>':'';?>
	</header>
	<?php
		$plxPlugin->modele("espacePublic/boucle/boutonPanier");
	?>
</div>
