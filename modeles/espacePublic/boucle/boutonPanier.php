<?php

$plxPlugin = $d["plxPlugin"];
$v = $plxPlugin->aProds[$d["k"]];

?>

<footer class="product_footer">
    <button class="product_addcart" onclick="addCart('<?php echo htmlspecialchars(plxMyShop::nomProtege($v['name'])); ?>', '<?php echo $plxPlugin->pos_devise($v['pricettc']); ?> <?php $plxPlugin->lang('L_PUBLIC_TAX'); ?><?php echo ((int)$v['poidg']>0?'&nbsp;'.$plxPlugin->lang('L_FOR').'&nbsp;'.$v['poidg'].'&nbsp;kg':''); ?>', '<?php echo $v['pricettc']; ?>', '<?php echo $v['poidg']; ?>','<?php echo $d["k"]; ?>');">
<?php $plxPlugin->lang('L_PUBLIC_ADD_BASKET'); ?></button>
</footer>
