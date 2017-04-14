<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
// e-mail de la commande
$_SESSION["plxMyShop"]['msgCommand']="";
$d["plxPlugin"]->validerCommande();
$this->vue->affichageVuePublique($d["plxPlugin"]);
?>
<!-- this is vue public -->
<script type='text/javascript'>
var error = false;
var repertoireAjax = '<?php echo $d["plxPlugin"]->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/ajax/';
var devise = '<?php echo $d["plxPlugin"]->getParam("devise");?>';
var pos_devise = '<?php echo $d["plxPlugin"]->getParam("pos_devise");?>';
var shoppingCart = null;
var L_FOR = '<?php echo $d["plxPlugin"]->getlang('L_FOR'); ?>';
var L_DEL = '<?php echo $d["plxPlugin"]->getlang('L_DEL'); ?>';
var L_TOTAL = '<?php echo $d["plxPlugin"]->getlang('L_TOTAL_BASKET'); ?>';
</script>