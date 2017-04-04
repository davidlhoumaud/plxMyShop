<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$dansShortcode = (count($d["pileModeles"]) === 1);

$NOMBRE = 1;
$PHRASE = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));
$MIN = 1;
$CLASS = 'blue';

if (isset($_SESSION["plxMyShop"]["prods"][$d["k"]])) 
{
	if ($_SESSION["plxMyShop"]["prods"][$d["k"]]<1)
	{
		$_SESSION["plxMyShop"]["ncart"] -= $_SESSION["plxMyShop"]["prods"][$d["k"]];
		unset($_SESSION["plxMyShop"]["prods"][$d["k"]]);
	}
	else
	{
		$NOMBRE = $_SESSION["plxMyShop"]["prods"][$d["k"]];
		$PHRASE = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_MOD_BASKET'));
		$MIN = 0;
		$CLASS = 'orange';
	}
}
?>
<form method="POST" class="formulaireAjoutProduit">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <?php if ($dansShortcode) {?>
  <input type="hidden" name="nb" value="<?= $NOMBRE; ?>" min="<?= $MIN; ?>">
 <?php } else {?>
  <input type="number" name="nb" value="<?= $NOMBRE; ?>" min="<?= $MIN; ?>">
 <?php }?>
 <input class="<?= $CLASS; ?>" type="submit" name="ajouterProduit" value="<?= $PHRASE; ?>">
</form>
