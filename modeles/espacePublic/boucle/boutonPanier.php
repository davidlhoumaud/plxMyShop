<?php if (!defined('PLX_ROOT')) exit;
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$minPnr = 1;
$prodsPnr = 1;
$txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));
$classPnrBtn = "blue";

if (isset($_SESSION["plxMyShop"]["prods"][$d["k"]])){
 if ($_SESSION["plxMyShop"]["prods"][$d["k"]]<1) {
  $_SESSION["plxMyShop"]["ncart"] -= $_SESSION["plxMyShop"]["prods"][$d["k"]];
  unset($_SESSION["plxMyShop"]["prods"][$d["k"]]);
 }else{
  $minPnr = 0;
  $prodsPnr = $_SESSION["plxMyShop"]["prods"][$d["k"]];
  $txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_DEL_BASKET'));
  $classPnrBtn = "red";
 }
}

$nbProdtype = (count($d["pileModeles"]) === 1)?'hidden':'number'; //dansShortcode = hidden
?>
<form action="#prod<?php echo $d["k"]; ?>" method="POST" id="FormAddProd<?php echo $d["k"]; ?>" class="formulaireAjoutProduit" onsubmit="chngNbProd('<?php echo $d["k"]; ?>',true);">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <input type="<?php echo $nbProdtype; ?>" name="nb" value="<?php echo $prodsPnr; ?>" min="<?php echo $minPnr; ?>" id="nbProd<?php echo $d["k"]; ?>" onchange="chngNbProd('<?php echo $d["k"]; ?>',false);" data-o="<?php echo $prodsPnr; ?>" />
 <input class="<?php echo $classPnrBtn; ?>" type="submit" id="addProd<?php echo $d["k"]; ?>" name="ajouterProduit" value="<?php echo $txtPnrBtn; ?>" />
</form>