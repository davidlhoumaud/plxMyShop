<?php if (!defined('PLX_ROOT')) exit;
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$minPnr = 1;
$maxPnr = $plxPlugin->aProds[$d["k"]]['iteminstock'] != '' ? 'max="'.$plxPlugin->aProds[$d["k"]]['iteminstock'].'" ' : '';
$prodsPnr = 1;
$txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));
$classPnrBtn = "blue";

if (isset($_SESSION[$plxPlugin->plugName]["prods"][$d["k"]])){
 if ($_SESSION[$plxPlugin->plugName]["prods"][$d["k"]]<1) {
  $_SESSION[$plxPlugin->plugName]["ncart"] -= $_SESSION[$plxPlugin->plugName]["prods"][$d["k"]];
  unset($_SESSION[$plxPlugin->plugName]["prods"][$d["k"]]);
 }else{
  $minPnr = 0;
  $prodsPnr = $_SESSION[$plxPlugin->plugName]["prods"][$d["k"]];
  $txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_DEL_BASKET'));
  $classPnrBtn = "red";
 }
}
$nbProdtype = (count($d["pileModeles"]) === 1)?'hidden':'number'; //dansShortcode = hidden
if(empty($plxPlugin->aProds[$d["k"]]['noaddcart'])){
?>
<form action="#prod<?php echo intval($d["k"]); ?>" method="POST" id="FormAddProd<?php echo $d["k"]; ?>" class="formulaireAjoutProduit" onsubmit="chngNbProd('<?php echo $d["k"]; ?>',true);">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <input type="<?php echo $nbProdtype; ?>" name="nb" value="<?php echo $prodsPnr; ?>" min="<?php echo $minPnr;?>" <?php echo $maxPnr; ?>id="nbProd<?php echo $d["k"]; ?>" onchange="chngNbProd('<?php echo $d["k"]; ?>',false);" data-o="<?php echo $prodsPnr; ?>" />
 <input class="<?php echo $classPnrBtn; ?>" type="submit" id="addProd<?php echo $d["k"]; ?>" name="ajouterProduit" value="<?php echo $txtPnrBtn; ?>" />
</form>
<?php
} else {
 echo '<span class="notice_noaddcart">'.(empty($plxPlugin->aProds[$d["k"]]['notice_noaddcart'])?$plxPlugin->getLang('L_NOTICE_NOADDCART'):$plxPlugin->aProds[$d["k"]]['notice_noaddcart']).'</span>'.PHP_EOL;
}
