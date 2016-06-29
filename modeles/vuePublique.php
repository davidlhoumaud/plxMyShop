<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>


<script type='text/javascript' src='<?php echo $d["plxPlugin"]->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/js/libajax.js'></script>
<script type='text/javascript' src='<?php echo $d["plxPlugin"]->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/js/panier.js'></script>

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

<?php

// e-mail de la commande

$_SESSION['msgCommand']="";


if (isset($_POST['prods']) && ($_POST['prods'] !== "")) {
	$d["plxPlugin"]->validerCommande();
}

$this->vue->affichageVuePublique($d["plxPlugin"]);


