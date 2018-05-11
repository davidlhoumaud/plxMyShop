<?php if (!defined('PLX_ROOT')) exit;
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$produit = $plxPlugin->aProds[$plxPlugin->default_lang][$plxPlugin->productNumber()];
if (is_array($plxPlugin->productGroupTitle())) {
 echo '<div id="prod'.intval($plxPlugin->productNumber()).'"></div>';
 $i=0;
 foreach($plxPlugin->productGroupTitle() as $key => $value) {
  echo ($i>0?',':'').'<a href="'.$plxPlugin->productRUrl($key).'">'.$value.'</a>';
  $i=1;
 }
 echo '&nbsp;&rsaquo;&nbsp;'; $plxPlugin->productTitle();
} else {
?>
  <a href="?product<?php $plxPlugin->productGroup(); ?>/"><?php echo $plxPlugin->productGroupTitle(); ?></a>&nbsp;&rsaquo;&nbsp;<?php $plxPlugin->productTitle();?>
<?php
}
?>

<section class="product_content">
 <header>
<?php if ($plxPlugin->getParam('afficheLienPanierTop')) { ?>
  <div class="basket_link_image">
   <a href="<?php echo htmlspecialchars($d["lienPanier"]);?>" id="notiShoppingCart">
    <span id="notiNumShoppingCart"></span>
    <img src="<?php echo PLX_PLUGINS.$plxPlugin->plugName; ?>/icon.png">&nbsp;<?php $plxPlugin->lang('L_PUBLIC_BASKET'); ?></a>
  </div>
<?php } ?>
  <div class="image_product">
<?php
  echo ($plxPlugin->aProds[$plxPlugin->default_lang][$plxPlugin->productNumber()]["image"]!="") ? '<img class="product_image" src="'.$plxPlugin->productImage().'">' : '';
  $plxPlugin->donneesModeles["k"] = $plxPlugin->productNumber();
  $plxPlugin->modele("espacePublic/boucle/boutonPanier");
?>
  </div>
<?php if ($produit["pricettc"] > 0) { ?>
   <span class="product_pricettc"><?php echo $plxPlugin->pos_devise($plxPlugin->productPriceTTC());?></span>
<?php } ?>
<?php if ($produit["poidg"] > 0) { ?>
   <span class="product_poidg"><?php echo $plxPlugin->productPoidG();?>&nbsp;kg</span>
<?php } ?>
 </header>
 <article>
  <?php $plxPlugin->plxShowProductContent(); ?>
 </article>

</section>