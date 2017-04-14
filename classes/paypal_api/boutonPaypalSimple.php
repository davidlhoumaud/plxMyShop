<?php
$montant = $totalpricettc;
$livraison = $totalpoidgshipping;
$devise = $plxPlugin->getParam("payment_paypal_currencycode");
$urlRetour = $plxPlugin->getParam("payment_paypal_returnurl");
$urlAnnulation = $plxPlugin->getParam("payment_paypal_cancelurl");
$adresseEmailPaypal = $plxPlugin->getParam("payment_paypal_user");;
$nomClient = "{$_POST["firstname"]} {$_POST["lastname"]}";
ob_start();
?>
 <form id="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="amount" value="<?php echo htmlspecialchars($montant);?>"/>
  <input type="hidden" name="currency_code" value="<?php echo htmlspecialchars($devise);?>"/>
  <input type="hidden" name="shipping" value="<?php echo htmlspecialchars($livraison);?>"/>
  <input type="hidden" name="tax" value="0.00"/>
  <input type="hidden" name="return" value="<?php echo htmlspecialchars($urlRetour);?>"/>
  <input type="hidden" name="cancel_return" value="<?php echo htmlspecialchars($urlAnnulation);?>"/>
  <input type="hidden" name="cmd" value="_xclick"/>
  <input type="hidden" name="business" value="<?php echo htmlspecialchars($adresseEmailPaypal);?>"/>
  <input type="hidden" name="item_name" value="Commande de <?php echo htmlspecialchars($nomClient);?>"/>
  <input type="hidden" name="no_note" value="0"/>
  <input type="hidden" name="lc" value="FR"/>
  <input type="hidden" name="bn" value="PP-BuyNowBF"/>
  <input type="image" onClick="postFormPayPal();" alt="" name="submit" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_LG.gif" style="width:initial;"/>
 </form>
 <p><img src="<?php echo $plxPlugin->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/images/paypal_logo.gif" alt=""/></p>
 <p><img src="<?php echo $plxPlugin->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/images/icon_load.gif" alt=""/></p>
 <script type="text/JavaScript">
  function postFormPayPal() {
   var paypal_form = document.getElementById("paypal_form");
   paypal_form.style.display ="none";
   paypal_form.submit();
  });
 </script>
<?php
$msgCommand .= ob_get_clean();