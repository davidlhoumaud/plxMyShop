<?php if (!defined('PLX_ROOT')) exit;
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
if(isset($this->aProds[$this->default_lang][$d["k"]])){//si le produit existe 
 $v = $this->aProds[$this->default_lang][$d["k"]];
?>
<div id="prod<?php echo intval($d["k"]); ?>" class="lproduct_content" align="center">
 <header>
  <h1 class="product_poidg"><a href="<?php echo $this->productRUrl($d["k"]); ?>" ><?php echo $v['name']; ?></a></h1>
  <?php echo $v['image'] != ''
   ? '<a href="'.$this->productRUrl($d["k"]).'"><img class="product_image" src="'.$this->plxMotor->urlRewrite($this->cheminImages.$v['image']).'"></a>'
   : '<a href="'.$this->productRUrl($d["k"]).'"><img class="product_image" src="'.PLX_PLUGINS.$this->plugName.'/images/none.png"></a>';
  ?><br />
  <?php if ($v['pricettc'] > 0) {?>
   <span class="lproduct_pricettc"><?php echo $this->pos_devise($v['pricettc']);?></span>
  <?php }?>
  <?php echo floatval($v['poidg'])>0.00&&$this->getParam("shipping_colissimo")?'&nbsp;'.$this->lang('L_FOR').'<span class="product_poidg">'.$v['poidg'].'&nbsp;kg</span>':'';?>
 </header>
 <?php $this->modele("espacePublic/boucle/boutonPanier"); ?>
</div>
<?php } ?>