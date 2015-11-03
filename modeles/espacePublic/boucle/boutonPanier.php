<?php

$plxPlugin = $d["plxPlugin"];
$v = $plxPlugin->aProds[$d["k"]];

?>

<footer class="product_footer">
    <button class="product_addcart" onclick="addCart('<?php echo htmlspecialchars(plxMyShop::nomProtege($v['name'])); ?>', '<?php echo $v['pricettc']; ?>&nbsp;<?php echo $plxPlugin->getParam("devise");?> <?php $plxPlugin->lang('L_PUBLIC_TAX'); ?><?php echo ((int)$v['poidg']>0?'&nbsp;'.$plxPlugin->lang('L_FOR').'&nbsp;'.$v['poidg'].'&nbsp;kg':''); ?>', '<?php echo $v['pricettc']; ?>', '<?php echo $v['poidg']; ?>','<?php echo $d["k"]; ?>');">
<?php $plxPlugin->lang('L_PUBLIC_ADD_BASKET'); ?></button>
</footer>
