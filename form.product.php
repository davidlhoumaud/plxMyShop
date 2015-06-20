<?php

$plxShow = plxShow::getInstance();
$plxPlugin = $plxShow->plxMotor->plxPlugins->aPlugins['plxMyShop'];
$plxPlugin->donneesModeles["plxPlugin"] = $plxPlugin;


if (($plxPlugin->aProds[ $plxPlugin->productNumber()]['active']!=1 || $plxPlugin->aProds[ $plxPlugin->productNumber()]['readable']!=1) && ($plxPlugin->aProds[ $plxPlugin->productNumber()]['pcat']!=1)) header('Location: index.php');

?>

<script type='text/javascript' src='<?php echo $plxPlugin->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/js/libajax.js'></script>
<script type='text/javascript' src='<?php echo $plxPlugin->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/js/panier.js'></script>

<script type='text/javascript'>

var error = false;
var repertoireAjax = '<?php echo $plxPlugin->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/ajax/';
var shoppingCart = null;

</script>

<?php

// e-mail de la commande

$_SESSION['msgCommand']="";


if (isset($_POST['prods']) && plxUtils::cdataCheck($_POST['prods'])!="") {
	$plxPlugin->validerCommande();
}

if ("1" === $plxPlugin->aProds[$plxPlugin->productNumber()]['pcat']) {
	$plxPlugin->modele("espacePublic/categorie");
} else {
	$plxPlugin->modele("espacePublic/produit");
}

if (in_array(
		$plxPlugin->getParam("affPanier")
		, array("basPage", "partout")
	)
) {
	$plxPlugin->modele("espacePublic/panier");
} else {
	$plxPlugin->modele("espacePublic/ajoutProduit");
}

