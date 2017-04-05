<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$dansShortcode = (count($d["pileModeles"]) === 1);

$prodsPnr = 1;
$txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));
$minPnrPrm = 1;
$classPnrBtn = 'blue';

if (isset($_SESSION["plxMyShop"]["prods"][$d["k"]])) {
 if ($_SESSION["plxMyShop"]["prods"][$d["k"]]<1) {
  $_SESSION["plxMyShop"]["ncart"] -= $_SESSION["plxMyShop"]["prods"][$d["k"]];
  unset($_SESSION["plxMyShop"]["prods"][$d["k"]]);
 }else{
  $prodsPnr = $_SESSION["plxMyShop"]["prods"][$d["k"]];
  $txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_MOD_BASKET'));
  $minPnrPrm = 0;
  $classPnrBtn = 'orange';
 }
}
?>
<form method="POST" class="formulaireAjoutProduit">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <?php if ($dansShortcode) {?>
  <input type="hidden" name="nb" value="<?php echo $prodsPnr; ?>" min="<?php echo $minPnrPrm; ?>">
 <?php } else {?>
  <input type="number" name="nb" value="<?php echo $prodsPnr; ?>" min="<?php echo $minPnrPrm; ?>">
 <?php }?>
 <input class="<?php echo $classPnrBtn; ?>" type="submit" name="ajouterProduit" value="<?php echo $txtPnrBtn; ?>">
</form>
