<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementPanier();
$afficheMessage = FALSE;
if ( isset($_SESSION["plxMyShop"]['msgCommand'])
 && !empty($_SESSION["plxMyShop"]['msgCommand'])
){
 $afficheMessage = TRUE;
 $message = $_SESSION["plxMyShop"]['msgCommand'];
 unset($_SESSION["plxMyShop"]['msgCommand']);
}
# Hook Plugins
eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierDebut'));
?>
<a id="panier"></a>
<div align="center" class="panierbloc">
 <div align="center" id="listproducts">
  <section align="center" class="productsect">
   <header><?php
     $plxPlugin->lang('L_PUBLIC_BASKET');
    if ($afficheMessage) {
     echo '<br />'.$message;
    }
   ?></header>
   <div id="shoppingCart">
<?php
     $sessioncart="";
     $totalpricettc=0;
     $totalpoidg=0;
     $totalpoidgshipping = 0;
     $nprod=0;
     if (isset($_SESSION["plxMyShop"]['prods']) && $_SESSION["plxMyShop"]['prods']) {
?>
       <form method="POST">
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierFormProdsDebut')); # Hook Plugins ?>
        <table class="tableauProduitsPanier">
         <tr>
          <th><?php $plxPlugin->lang('L_PRODUCT'); ?></th>
          <th><?php $plxPlugin->lang('L_UNIT_PRICE'); ?></th>
          <th><?php $plxPlugin->lang('L_NUMBER'); ?></th>
          <th><?php $plxPlugin->lang('L_TOTAL_PRICE'); ?></th>
          <th></th>
         </tr>
<?php   foreach ($_SESSION["plxMyShop"]['prods'] as $pId => $nb) { 
           $prixUnitaire = (float) $plxPlugin->aProds[$pId]['pricettc'];
           $prixttc = $prixUnitaire * $nb;
           $poidg = (float) $plxPlugin->aProds[$pId]['poidg'] * $nb;
           $totalpricettc += $prixttc;
           $totalpoidg += $poidg;
           $nprod++;
?>
         <tr>
          <td><?php echo $plxPlugin->aProds[$pId]['name'];?></td>
          <td class="nombre"><?php echo $plxPlugin->pos_devise($prixUnitaire);?></td>
          <td><input type="number" name="nb[<?php echo $pId;?>]" value="<?php echo htmlspecialchars($nb);?>" /></td>
          <td class="nombre"><?php echo $plxPlugin->pos_devise($prixttc);?></td>
          <td><input type="submit" class="red" name="retirerProduit[<?php echo $pId;?>]" value="<?php echo htmlspecialchars($plxPlugin->getLang('L_DEL'));?>" /></td>
         </tr>
<?php   } // FIN foreach ($_SESSION["plxMyShop"]['prods'] as $pId => $nb) ?>
        </table>
        <input type="submit" name="recalculer" value="<?php echo htmlspecialchars($plxPlugin->getLang('L_PANIER_RECALCULER'));?>" />
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierFormProdsFin')); # Hook Plugins ?>
       </form>
<?php $totalpoidgshipping = $plxPlugin->shippingMethod($totalpoidg, 1); ?>
       <span id="spanshipping"></span>
       <span id='totalCart'><?php
        echo htmlspecialchars($plxPlugin->getLang('L_TOTAL_BASKET').
        (($plxPlugin->getParam("shipping_colissimo"))?$plxPlugin->getLang('L_TOTAL_BASKET_PORT'):'')).
        '&nbsp;:&nbsp;'.
        $plxPlugin->pos_devise($totalpricettc + $totalpoidgshipping);
       ?></span>
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierProdsFin')); # Hook Plugins
     }
    if (0 === $nprod && !$afficheMessage) {?>
     <em><?php $plxPlugin->lang('L_PUBLIC_NOPRODUCT'); ?></em>
<?php } ?>
   </div>
   <form id="formcart" method="POST" action="#panier">
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierCoordsDebut')) # Hook Plugins ?>
    <p><span class='startw'><?php $plxPlugin->lang('L_PUBLIC_MANDATORY_FIELD'); ?></span></p>
    <p><strong id="labelFirstnameCart"><?php $plxPlugin->lang('L_PUBLIC_FIRSTNAME'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="text" name="firstname" id="firstname" value="" required="required" />
    <strong id="labelLastnameCart"><?php $plxPlugin->lang('L_PUBLIC_LASTNAME'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="text" name="lastname" id="lastname" value="" required="required" /></p>
    <p><strong id="labelMailCart"><?php $plxPlugin->lang('L_PUBLIC_EMAIL'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="email" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" id="email" value="" required="required" /></p>
    <p><strong id="labelTelCart"><?php $plxPlugin->lang('L_PUBLIC_TEL'); ?>&nbsp;:</strong> <input type="text" name="tel" id="tel" value=""></p>
    <p><strong id="labelAddrCart"><?php $plxPlugin->lang('L_PUBLIC_ADDRESS'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="text" name="adress" id="adress" value="" required="required" /></p>
    <p><strong id="labelPostcodeCart" ><?php $plxPlugin->lang('L_PUBLIC_ZIP'); ?><span class='star'>*</span>&nbsp;:</strong> <input  type="text" name="postcode" id="postcode" value="" required="required" />
    <strong id="labelCityCart"><?php $plxPlugin->lang('L_PUBLIC_TOWN'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="text" name="city" id="city" value=""  required="required"></p>
    <p><strong id="labelCountryCart"><?php $plxPlugin->lang('L_PUBLIC_COUNTRY'); ?><span class='star'>*</span>&nbsp;:</strong> <input type="text" name="country" id="country" value="" required="required" /></p>
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierCoordsMilieu')) # Hook Plugins ?>
    <p>
     <label for="choixCadeau">
      <input type="checkbox" id="choixCadeau" name="choixCadeau"<?php echo (!isset($_POST["choixCadeau"])) ? '' : ' checked="checked"';?> />
      <?php $plxPlugin->lang('L_PUBLIC_GIFT'); ?>
     </label>
    </p>
    <p class="conteneurNomCadeau" id="conteneurNomCadeau">
     <label for="nomCadeau">
      <?php $plxPlugin->lang('L_PUBLIC_GIFTNAME'); ?>
      <input type="text" name="nomCadeau" id="nomCadeau" value="<?php echo (!isset($_POST["nomCadeau"])) ? '' : htmlspecialchars($_POST['nomCadeau']);?>" />
     </label>
    </p>
    <strong id="labelMsgCart"><?php $plxPlugin->lang('L_PUBLIC_COMMENT'); ?></strong><br /><textarea name="msg" id="msgCart"  rows="3"></textarea><br />
    <textarea name="prods" id="prodsCart" rows="3"></textarea>
    <input type="hidden" name="total" id="totalcommand" value="0" />
    <input type="hidden" name="shipping" id="shipping" value="0" />
    <input type="hidden" name="shipping_kg" id="shipping_kg" value="0" />
    <input type="hidden" name="idsuite" id="idsuite" value="0" />
    <input type="hidden" name="numcart" id="numcart" value="0" />
    <strong><?php $plxPlugin->lang('L_EMAIL_CUST_PAYMENT'); ?>&nbsp;:&nbsp;&nbsp;</strong>
    <select onchange="changePaymentMethod(this.value);" name="methodpayment" id="methodpayment">
<?php
      $methodpayment = !isset($_SESSION["plxMyShop"]["methodpayment"]) ? "" : $_SESSION["plxMyShop"]["methodpayment"];
      foreach ($d["tabChoixMethodespaiement"] as $codeM => $m) {?>
      <option value="<?php echo htmlspecialchars($codeM);?>"<?php
       echo ($codeM !== $methodpayment) ? "" : ' selected="selected"';
      ?>><?php echo htmlspecialchars($m["libelle"]);?></option>
<?php } ?>
    </select>
    <br />
<?php if ("" !== $plxPlugin->getParam("urlCGV")) {?>
     <label for="valideCGV">
      <input type="checkbox" name="valideCGV" id="valideCGV"<?php echo (!isset($_POST["valideCGV"])) ? "" : " checked=\"checked\"";?>  required="required" />
      <span class='star'>*</span>
      <a href="<?php echo htmlspecialchars($plxPlugin->getParam("urlCGV"));?>"><?php echo htmlspecialchars($plxPlugin->getParam("libelleCGV"));?></a>
     </label>
<?php } ?>
    <input type="submit" class="green" name="validerCommande" id="btnCart" value="<?php $plxPlugin->lang('L_PUBLIC_VALIDATE_ORDER'); ?>" /><br />
   </form>
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierCoordsFin')) # Hook Plugins ?>
  </section>
 </div>
</div>
<script type='text/javascript' src='<?php echo $d["plxPlugin"]->plxMotor->racine . PLX_PLUGINS;?>plxMyShop/js/panier.js?v0131'></script>
<?php eval($plxPlugin->plxMotor->plxPlugins->callHook('plxMyShopPanierFin')) # Hook Plugins ?>