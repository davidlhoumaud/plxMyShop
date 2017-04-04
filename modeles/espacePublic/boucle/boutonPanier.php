<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$dansShortcode = (count($d["pileModeles"]) === 1);
?>
<form method="POST" class="formulaireAjoutProduit">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <?php if ($dansShortcode) {?>
  <input type="hidden" name="nb" value="1" min="1">
 <?php } else {?>
  <input type="number" name="nb" value="1" min="1">
 <?php }?>
 <input type="submit" name="ajouterProduit" value="<?php echo htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));?>">
</form>
