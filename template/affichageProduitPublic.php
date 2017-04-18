<?php if (!defined('PLX_ROOT')) exit;
$plxShow = plxShow::getInstance();
$plxPlugin = $plxShow->plxMotor->plxPlugins->aPlugins['plxMyShop'];
$plxPlugin->donneesModeles["plxPlugin"] = $plxPlugin;
if (($plxPlugin->aProds[ $plxPlugin->productNumber()]['active']!=1 || $plxPlugin->aProds[ $plxPlugin->productNumber()]['readable']!=1) && ($plxPlugin->aProds[ $plxPlugin->productNumber()]['pcat']!=1)) header('Location: index.php');
// e-mail de la commande
$_SESSION["plxMyShop"]['msgCommand']="";
$plxPlugin->validerCommande();
if ("1" === $plxPlugin->aProds[$plxPlugin->productNumber()]['pcat']) {
 $plxPlugin->modele("espacePublic/categorie");
} else {
 $plxPlugin->modele("espacePublic/produit");
}
if (in_array($plxPlugin->getParam("affPanier"), array("basPage", "partout"))){
 $plxPlugin->modele("espacePublic/panier");
}