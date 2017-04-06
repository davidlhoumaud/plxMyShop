<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
if (!isset($_SESSION)) {
 session_start();
}
$msgProdUpDate = FALSE;

if ( isset($_SESSION["plxMyShop"]["msgProdUpDate"])
 && $_SESSION["plxMyShop"]["msgProdUpDate"]
) {
 $msgProdUpDate = TRUE;
 unset($_SESSION["plxMyShop"]["msgProdUpDate"]);
}
?>
<div id="msgUpDateCart"><?php $this->lang('L_PUBLIC_MSG_BASKET_UP'); ?></div>
<script type="text/JavaScript">
<?php if ($msgProdUpDate){ ?>
 var msgUpDateCart = document.getElementById("msgUpDateCart");
 msgUpDateCart.style.display = "block";
 setTimeout(function(){document.getElementById("msgUpDateCart").style.display = "none"; }, 3000);
<?php } ?>
 var shoppingCart = null;
</script>