<?php if(!defined('PLX_ROOT')) exit;
# Control du token du formulaire
plxToken::validateFormToken($_POST);

# Liste des langues disponibles et prises en charge par le plugin
$aLangs = array($plxAdmin->aConf['default_lang']);

# Si le plugin plxMyMultiLingue est installé on filtre sur les langues utilisées
# On garde par défaut le fr si aucune langue sélectionnée dans plxMyMultiLingue
if($plxPlugin->aLangs) {
 $aLangs = $plxPlugin->aLangs;
}
$tabAffPanier = array(
 "basPage" => $plxPlugin->getlang('L_PANIER_POS_BOTTOM') ,
 "pageSeparee" => $plxPlugin->getlang('L_PANIER_POS_SEPARATE') ,
 "partout" => $plxPlugin->getlang('L_PANIER_POS_BOTH') ,
);

$tabPosDevise = array(
 "after" => $plxPlugin->getlang('L_AFTER') ,
 "before" => $plxPlugin->getlang('L_BEFORE') ,
);

$timeselection = array(
    "00:00" => "00:00",
    "01:00" => "01:00",
    "02:00" => "02:00",
    "03:00" => "03:00",
    "04:00" => "04:00",
    "05:00" => "05:00",
    "06:00" => "06:00",
    "07:00" => "07:00",
    "08:00" => "08:00",
    "09:00" => "09:00",
    "10:00" => "10:00",
    "11:00" => "11:00",
    "12:00" => "12:00",
    "13:00" => "13:00",
    "14:00" => "14:00",
    "15:00" => "15:00",
    "16:00" => "16:00",
    "17:00" => "17:00",
    "18:00" => "18:00",
    "19:00" => "19:00",
    "20:00" => "20:00",
    "21:00" => "21:00",
    "22:00" => "22:00",
    "23:00" => "23:00",
    "24:00" => "24:00",
);


$var = array();
if(!empty($_POST)){
 //socolissimo reco
 $plxPlugin->setParam('shipping_by_price', isset($_POST['shipping_by_price'])?'1':'0', 'numeric');
 $plxPlugin->setParam('shipping_nb_lines', isset($_POST['shipping_nb_lines'])?($_POST['shipping_nb_lines']>='99'?'99':$_POST['shipping_nb_lines']):'11', 'numeric');
 $plxPlugin->setParam('shipping_colissimo', isset($_POST['shipping_colissimo'])?'1':'0', 'numeric');
 $plxPlugin->setParam('delivery_date', isset($_POST['delivery_date'])?'1':'0', 'numeric');
 $plxPlugin->setParam('delivery_nb_days', isset($_POST['delivery_nb_days'])?($_POST['delivery_nb_days']>='99'?'99':$_POST['delivery_nb_days']):'11', 'numeric');
 $plxPlugin->setParam('delivery_start_time', $_POST['delivery_start_time'], 'string');
 $plxPlugin->setParam('delivery_end_time', $_POST['delivery_end_time'], 'string');
 $plxPlugin->setParam('delivery_nb_timeslot', isset($_POST['delivery_nb_timeslot'])?($_POST['delivery_nb_timeslot']>='24'?'24':$_POST['delivery_nb_timeslot']):'2', 'numeric');
 $plxPlugin->setParam('freeshipw', $_POST['freeshipw'], 'string');//free shipping weight
 $plxPlugin->setParam('freeshipp', $_POST['freeshipp'], 'string');//free shipping price
 $plxPlugin->setParam('acurecept', $_POST['acurecept'], 'string');
 for($i=1;$i<=$plxPlugin->getParam('shipping_nb_lines');$i++){
  $num=str_pad($i, 2, "0", STR_PAD_LEFT);
  $plxPlugin->setParam('p'.$num, $_POST['p'.$num], 'string');
  $plxPlugin->setParam('pv'.$num, $_POST['pv'.$num], 'string');
 }
 //end socolissimo reco
 $plxPlugin->setParam('shipping_ups', 0, 'numeric');
 $plxPlugin->setParam('shipping_tnt', 0, 'numeric');
 $plxPlugin->setParam('payment_cheque', isset($_POST['payment_cheque'])?'1':'0', 'numeric');
 $plxPlugin->setParam('payment_cash', isset($_POST['payment_cash'])?'1':'0', 'numeric');
 //paypal
 $plxPlugin->setParam('payment_paypal', isset($_POST['payment_paypal'])?'1':'0', 'numeric');
 $plxPlugin->setParam('payment_paypal_test', $_POST['payment_paypal_test'], 'numeric');
 $plxPlugin->setParam('payment_paypal_currencycode', $_POST['payment_paypal_currencycode'], 'string');
 $plxPlugin->setParam('payment_paypal_overalldescription', $_POST['payment_paypal_overalldescription'], 'string');
 //test
 $plxPlugin->setParam('payment_paypal_test_user', $_POST['payment_paypal_test_user'], 'string');
 $plxPlugin->setParam('payment_paypal_test_pwd', $_POST['payment_paypal_test_pwd'], 'string');
 $plxPlugin->setParam('payment_paypal_test_signature', $_POST['payment_paypal_test_signature'], 'string');
 //prod
 $plxPlugin->setParam('payment_paypal_amount', $_POST['payment_paypal_amount'], 'string');
 $plxPlugin->setParam('payment_paypal_user', $_POST['payment_paypal_user'], 'string');
 $plxPlugin->setParam('payment_paypal_pwd', $_POST['payment_paypal_pwd'], 'string');
 $plxPlugin->setParam('payment_paypal_signature', $_POST['payment_paypal_signature'], 'string');

 $plxPlugin->setParam('payment_paypal_logoimg', $_POST['payment_paypal_logoimg'], 'string');
 $plxPlugin->setParam('payment_paypal_returnurl', $_POST['payment_paypal_returnurl'], 'string');
 $plxPlugin->setParam('payment_paypal_cancelurl', $_POST['payment_paypal_cancelurl'], 'string');
 $plxPlugin->setParam('payment_paypal_ipnurl', $_POST['payment_paypal_ipnurl'], 'string');
 $plxPlugin->setParam('payment_paypal_payflowcolor', $_POST['payment_paypal_payflowcolor'], 'string');
 $plxPlugin->setParam('payment_paypal_cartbordercolor', $_POST['payment_paypal_cartbordercolor'], 'string');
 //end paypal

 $plxPlugin->setParam('payment_mercanet', 0, 'numeric');
 $plxPlugin->setParam('payment_kwixo', 0, 'numeric');
 $plxPlugin->setParam('email', $_POST['email'], 'string');
 $plxPlugin->setParam('email_cc', $_POST['email_cc'], 'string');
 $plxPlugin->setParam('email_bcc', $_POST['email_bcc'], 'string');
 $plxPlugin->setParam('subject', $_POST['subject'], 'string');
 $plxPlugin->setParam('newsubject', $_POST['newsubject'], 'string');
 $plxPlugin->setParam('template', $_POST['template'], 'string');
 $plxPlugin->setParam('shop_name', $_POST['shop_name'], 'string');
 $plxPlugin->setParam('commercant_name', $_POST['commercant_name'], 'string');
 $plxPlugin->setParam('commercant_street', $_POST['commercant_street'], 'string');
 $plxPlugin->setParam('commercant_city', $_POST['commercant_city'], 'string');
 $plxPlugin->setParam('devise', $_POST['devise'], 'string');
 $plxPlugin->setParam('commercant_postcode', $_POST['commercant_postcode'], 'string');
 $plxPlugin->setParam('menu_position', $_POST['menu_position'], 'numeric');
 $plxPlugin->setParam('submenu', trim($_POST['submenu']), 'string');
 $afficheCategoriesMenu = isset($_POST['afficheCategoriesMenu']) ? "" : "non";
 $plxPlugin->setParam('afficheCategoriesMenu', $afficheCategoriesMenu, 'string');
 $plxPlugin->setParam('afficheLienPanierTop', isset($_POST['afficheLienPanierTop'])?'1':'0', 'numeric');
 $plxPlugin->setParam('affPanier', $_POST['affPanier'], 'string');
 $affichePanierMenu = isset($_POST['affichePanierMenu']) ? "" : "non";
 $plxPlugin->setParam('affichePanierMenu',$affichePanierMenu, 'string');
 $plxPlugin->setParam('localStorage', isset($_POST['localStorage'])?'1':'0', 'numeric');
 $plxPlugin->setParam('cookie', (isset($_POST['localStorage'])&&isset($_POST['cookie'])?'1':'0'), 'numeric');
 $plxPlugin->setParam('position_devise', $_POST['position_devise'], 'string');
 $plxPlugin->setParam('useLangCGVDefault', isset($_POST['useLangCGVDefault'])?'1':'0', 'numeric');
 $plxPlugin->setParam('libelleCGV', $_POST['libelleCGV'], 'string');
 $plxPlugin->setParam('urlCGV', $_POST['urlCGV'], 'string');

 $plxPlugin->setParam('racine_commandes', (empty(trim($_POST['racine_commandes']))?'data/commandes/':trim($_POST['racine_commandes'])), 'string');;
 $plxPlugin->setParam('racine_products', (empty(trim($_POST['racine_products']))?'data/products/':trim($_POST['racine_products'])), 'string');

 $plxPlugin->saveParams();
 header('Location: parametres_plugin.php?p='.$plxPlugin->plugName);
 exit;
}
# initialisation des variables communes à chaque langue
$var['subject'] = $plxPlugin->getParam('subject')=='' ? $plxPlugin->lang('L_DEFAULT_OBJECT') : $plxPlugin->getParam('subject');
$var['newsubject'] = $plxPlugin->getParam('newsubject')=='' ? $plxPlugin->lang('L_EMAIL_SUBJECT') : $plxPlugin->getParam('newsubject');
$var['payment_cheque'] = $plxPlugin->getParam('payment_cheque')=='' ? '' : $plxPlugin->getParam('payment_cheque');
$var['payment_cash'] = $plxPlugin->getParam('payment_cash')=='' ? '' : $plxPlugin->getParam('payment_cash');
//paypal
$var['payment_paypal'] = $plxPlugin->getParam('payment_paypal')=='' ? '' : $plxPlugin->getParam('payment_paypal');
$var['payment_paypal_test'] = $plxPlugin->getParam('payment_paypal_test')=='' ? '' : $plxPlugin->getParam('payment_paypal_test');
$var['payment_paypal_currencycode'] = $plxPlugin->getParam('payment_paypal_currencycode')=='' ? '' : $plxPlugin->getParam('payment_paypal_currencycode');
$var['payment_paypal_overalldescription'] = $plxPlugin->getParam('payment_paypal_overalldescription')=='' ? '' : $plxPlugin->getParam('payment_paypal_overalldescription');
 //test
$var['payment_paypal_test_user'] = $plxPlugin->getParam('payment_paypal_test_user')=='' ? '' : $plxPlugin->getParam('payment_paypal_test_user');
$var['payment_paypal_test_pwd'] = $plxPlugin->getParam('payment_paypal_test_pwd')=='' ? '' : $plxPlugin->getParam('payment_paypal_test_pwd');
$var['payment_paypal_test_signature'] = $plxPlugin->getParam('payment_paypal_test_signature')=='' ? '' : $plxPlugin->getParam('payment_paypal_test_signature');
 //prod
$var['payment_paypal_amount'] = $plxPlugin->getParam('payment_paypal_amount')=='' ? '0' : $plxPlugin->getParam('payment_paypal_amount');
$var['payment_paypal_user'] = $plxPlugin->getParam('payment_paypal_user')=='' ? '' : $plxPlugin->getParam('payment_paypal_user');
$var['payment_paypal_pwd'] = $plxPlugin->getParam('payment_paypal_pwd')=='' ? '' : $plxPlugin->getParam('payment_paypal_pwd');
$var['payment_paypal_signature'] = $plxPlugin->getParam('payment_paypal_signature')=='' ? '' : $plxPlugin->getParam('payment_paypal_signature');
 //url
$var['payment_paypal_returnurl'] = $plxPlugin->getParam('payment_paypal_returnurl')=='' ? '' : $plxPlugin->getParam('payment_paypal_returnurl');
$var['payment_paypal_cancelurl'] = $plxPlugin->getParam('payment_paypal_cancelurl')=='' ? '' : $plxPlugin->getParam('payment_paypal_cancelurl');
$var['payment_paypal_ipnurl'] = $plxPlugin->getParam('payment_paypal_ipnurl')=='' ? '' : $plxPlugin->getParam('payment_paypal_ipnurl');
 //others
$var['payment_paypal_logoimg'] = $plxPlugin->getParam('payment_paypal_logoimg')=='' ? '' : $plxPlugin->getParam('payment_paypal_logoimg');
$var['payment_paypal_payflowcolor'] = $plxPlugin->getParam('payment_paypal_payflowcolor')=='' ? '' : $plxPlugin->getParam('payment_paypal_payflowcolor');
$var['payment_paypal_cartbordercolor'] = $plxPlugin->getParam('payment_paypal_cartbordercolor')=='' ? '' : $plxPlugin->getParam('payment_paypal_cartbordercolor');
//end paypal
//socolissimo reco
$var['shipping_by_price'] = $plxPlugin->getParam('shipping_by_price')=='' ? '0' : $plxPlugin->getParam('shipping_by_price');
$var['shipping_nb_lines'] = $plxPlugin->getParam('shipping_nb_lines')=='' ? '11' : $plxPlugin->getParam('shipping_nb_lines');
$var['shipping_colissimo'] = $plxPlugin->getParam('shipping_colissimo')=='' ? '' : $plxPlugin->getParam('shipping_colissimo');
$var['delivery_date'] = $plxPlugin->getParam('delivery_date')=='' ? '' : $plxPlugin->getParam('delivery_date');
$var['delivery_nb_days'] = $plxPlugin->getParam('delivery_nb_days')=='' ? '11' : $plxPlugin->getParam('delivery_nb_days');
$var["delivery_start_time"] = ("" === $plxPlugin->getParam("delivery_start_time")) ? current(array_keys($timeselection)) : $plxPlugin->getParam("delivery_start_time");
$var["delivery_end_time"] = ("" === $plxPlugin->getParam("delivery_end_time")) ? current(array_keys($timeselection)) : $plxPlugin->getParam("delivery_end_time");
$var['delivery_nb_timeslot'] = $plxPlugin->getParam('delivery_nb_timeslot')=='' ? '2' : $plxPlugin->getParam('delivery_nb_timeslot');
$var['freeshipw'] = $plxPlugin->getParam('freeshipw')=='' ? '' : $plxPlugin->getParam('freeshipw');
$var['freeshipp'] = $plxPlugin->getParam('freeshipp')=='' ? '' : $plxPlugin->getParam('freeshipp');
$var['acurecept'] = $plxPlugin->getParam('acurecept')=='' ? '' : $plxPlugin->getParam('acurecept');

for($i=1;$i<=$var['shipping_nb_lines'];$i++){
 $num=str_pad($i, 2, "0", STR_PAD_LEFT);
 $var['p'.$num] = $plxPlugin->getParam('p'.$num)=='' ? '' : $plxPlugin->getParam('p'.$num);
 $var['pv'.$num] = $plxPlugin->getParam('pv'.$num)=='' ? '' : $plxPlugin->getParam('pv'.$num);
}
//end socolissimo reco
$var['email'] = $plxPlugin->getParam('email')=='' ? '' : $plxPlugin->getParam('email');
$var['email_cc'] = $plxPlugin->getParam('email_cc')=='' ? '' : $plxPlugin->getParam('email_cc');
$var['email_bcc'] = $plxPlugin->getParam('email_bcc')=='' ? '' : $plxPlugin->getParam('email_bcc');
$var['template'] = $plxPlugin->getParam('template')=='' ? 'static.php' : $plxPlugin->getParam('template');
$var['shop_name'] = $plxPlugin->getParam('shop_name')=='' ? 'My Shop' : $plxPlugin->getParam('shop_name');
$var['commercant_name'] = $plxPlugin->getParam('commercant_name')=='' ? 'David.L' : $plxPlugin->getParam('commercant_name');
$var['commercant_street'] = $plxPlugin->getParam('commercant_street')=='' ? 'Rue de la plume' : $plxPlugin->getParam('commercant_street');
$var['commercant_postcode'] = $plxPlugin->getParam('commercant_postcode')=='' ? '09600' : $plxPlugin->getParam('commercant_postcode');
$var['commercant_city'] = $plxPlugin->getParam('commercant_city')=='' ? 'Dun' : $plxPlugin->getParam('commercant_city');
$var['devise'] = $plxPlugin->getParam('devise')=='' ? ' €' : $plxPlugin->getParam('devise');
$var['menu_position'] = $plxPlugin->getParam('menu_position')=='' ? 3 : $plxPlugin->getParam('menu_position');
$var['submenu'] = $plxPlugin->getParam('submenu')=='' ? '' : $plxPlugin->getParam('submenu');
$var['afficheCategoriesMenu'] = $plxPlugin->getParam('afficheCategoriesMenu');
$var['afficheLienPanierTop'] = $plxPlugin->getParam('afficheLienPanierTop');
$var["affPanier"] = ("" === $plxPlugin->getParam("affPanier")) ? current(array_keys($tabAffPanier)) : $plxPlugin->getParam("affPanier");
$var['affichePanierMenu'] = $plxPlugin->getParam('affichePanierMenu');
$var['localStorage'] = $plxPlugin->getParam('localStorage')!='' ? $plxPlugin->getParam('localStorage') : '1';
$var['cookie'] = $plxPlugin->getParam('cookie')!='' ? $plxPlugin->getParam('cookie') : '1';
$var["position_devise"] = ("" === $plxPlugin->getParam("position_devise")) ? current(array_keys($tabPosDevise)) : $plxPlugin->getParam("position_devise");
$var['useLangCGVDefault'] = $plxPlugin->aLangs ? $plxPlugin->getParam('useLangCGVDefault') : '0';
$var["libelleCGV"] = ("" === $plxPlugin->getParam("libelleCGV")) ? $plxPlugin->getLang("L_COMMANDE_LIBELLE_DEFAUT") : $plxPlugin->getParam("libelleCGV");
$var["urlCGV"] = ("" === $plxPlugin->getParam("urlCGV")) ? "" : $plxPlugin->getParam("urlCGV");

$var['racine_commandes'] = (empty(trim($plxPlugin->getParam('racine_commandes')))?'data/commandes/':trim($plxPlugin->getParam('racine_commandes')));
$var['racine_products'] = (empty(trim($plxPlugin->getParam('racine_products')))?'data/products/':trim($plxPlugin->getParam('racine_products')));

# On récupère les templates des pages statiques
$aTemplates = array();
$files = plxGlob::getInstance(PLX_ROOT.$plxAdmin->aConf['racine_themes'].$plxAdmin->aConf['style']);
if ($array = $files->query('/^static(-[a-z0-9-_]+)?.php$/')) {
 foreach($array as $k=>$v)
  $aTemplates[$v] = $v;
}
?>

<h3 id="pmsTitle" class="in-action-bar page-title hide"><?php echo $plxPlugin->lang('L_MENU_CONFIG').' '.$plxPlugin->getInfo('title');?></h3>
<script type="text/javascript">//surcharge du titre dans l'admin
 var title = document.getElementById('pmsTitle').innerHTML;
 document.getElementsByClassName('inline-form')[0].firstChild.nextSibling.innerHTML = '<?php echo $plxPlugin->plugName; ?> - '+title;
</script>

<form id="config_plxmyshop" action="parametres_plugin.php?p=<?php echo $plxPlugin->plugName; ?>" method="post">
<?php echo plxToken::getTokenPostMethod() ?>
 <fieldset class="config">
  <p class="in-action-bar plx<?php echo str_replace('.','-',@PLX_VERSION); echo $plxPlugin->aLangs?' multilingue':'';?>">
   <input type="submit" name="submit" value="<?php $plxPlugin->lang('L_CONFIG_SUBMIT') ?>" />
  </p>
  <h2><?php $plxPlugin->lang('L_CONFIG_SHOP_INFO') ?></h2>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_shop_name"><?php $plxPlugin->lang('L_CONFIG_SHOP_NAME') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('shop_name',$var['shop_name'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_commercant_name"><?php $plxPlugin->lang('L_CONFIG_SHOP_OWNER') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('commercant_name',$var['commercant_name'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_commercant_street"><?php $plxPlugin->lang('L_CONFIG_SHOP_STREET') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('commercant_street',$var['commercant_street'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_commercant_postcode"><?php $plxPlugin->lang('L_CONFIG_SHOP_ZIP') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('commercant_postcode',$var['commercant_postcode'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_commercant_city"><?php $plxPlugin->lang('L_CONFIG_SHOP_TOWN') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('commercant_city',$var['commercant_city'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_devise"><?php $plxPlugin->lang('L_CONFIG_SHOP_CURRENCY') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('devise',$var['devise'],'text','5-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_position_devise"><?php $plxPlugin->lang('L_CONFIG_POSITION_CURRENCY') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printSelect("position_devise", $tabPosDevise, $var["position_devise"]) ?>
   </div>
  </div>

  <h2><?php $plxPlugin->lang('L_CONFIG_DELIVERY_TITLE') ?></h2>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_delivery_date"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_DATE');?>&nbsp;:</label>
   </div>

    <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_delivery_date" name="delivery_date" type="checkbox"<?php echo (("0" === $var["delivery_date"]) ? "" : " checked=\"checked\"").' onchange="if (this.checked) { document.getElementById(\'blockdelidate\').style.display=\'block\';}else{document.getElementById(\'blockdelidate\').style.display=\'none\';}"';?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
    </div>

  <fieldset id="blockdelidate" style="display:<?php echo ($var['delivery_date']==1?"block":"none"); ?>;">
   <legend><?php $plxPlugin->lang('L_CONFIG_DELIVERY_MINDAYS') ?></legend>
    <table class="full-width">
     <tr>
      <td colspan="3" class="text-right"><?php $plxPlugin->lang('L_CONFIG_NB_DAYS') ?>&nbsp;:</td>
      <td colspan="2"><?php plxUtils::printInput('delivery_nb_days',$var['delivery_nb_days'],'number','2-2',false,'',' min="1" max="99"') ?></td>
     </tr>
     <tr>
      <td colspan="3" class="text-right"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_STARTTIME') ?>&nbsp;:</td>
      <td colspan="2"><?php plxUtils::printSelect('delivery_start_time',$timeselection, $var["delivery_start_time"]) ?></td>
     </tr>
     <tr>
      <td colspan="3" class="text-right"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_ENDTIME') ?>&nbsp;:</td>
      <td colspan="2"><?php plxUtils::printSelect('delivery_end_time',$timeselection, $var["delivery_end_time"]) ?></td>
     </tr>
     <tr>
      <td colspan="3" class="text-right"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_TIMESLOT') ?>&nbsp;:</td>
      <td colspan="2"><?php plxUtils::printInput('delivery_nb_timeslot',$var['delivery_nb_timeslot'],'number','2-2',false,'',' min="1" max="24"') ?></td>
     </tr>
    </table>
  </fieldset>

   <div class="col sml-9 label-centered">
    <label for="id_shipping_colissimo"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_SHIPPING');?>&nbsp;:</label>
   </div>

   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_shipping_colissimo" name="shipping_colissimo" type="checkbox" <?php echo (("0" === $var["shipping_colissimo"]) ? "" : " checked=\"checked\"").' onchange="if (this.checked) { document.getElementById(\'blocksocoreco\').style.display=\'block\';}else{document.getElementById(\'blocksocoreco\').style.display=\'none\';}"';?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>

  <fieldset id="blocksocoreco" style="display:<?php echo ($var['shipping_colissimo']==1?"block":"none"); ?>;">
   <legend><?php $plxPlugin->lang('L_CONFIG_DELIVERY_CONFIG') ?></legend>
   <div class="scrollable-table">
    <table class="full-width">
     <tr>
      <td class="text-right"><b title="<?php $plxPlugin->lang('L_CONFIG_FREESHIPP') ?>"><?php $plxPlugin->lang('L_CONFIG_FREE') ?></b>&nbsp;(<?php $plxPlugin->lang('L_OPTIONEL');?>)&nbsp;:</td>
      <td><?php plxUtils::printInput('freeshipp',$var['freeshipp'],'text','11-120') ?></td>
      <td><?php echo $var['devise'];?>&nbsp;<sub><?php $plxPlugin->lang('L_AND'); ?>/<?php $plxPlugin->lang('L_OR'); ?></sub></td>
      <td><?php plxUtils::printInput('freeshipw',$var['freeshipw'],'text','11-120') ?></td>
      <td>kg</td>
     </tr>
     <tr>
      <td class="text-right"><?php $plxPlugin->lang('L_CONFIG_PRIX_BASE') ?>&nbsp;:</td>
      <td><?php plxUtils::printInput('acurecept',$var['acurecept'],'text','11-120') ?></td>
      <td class="text-left"><?php echo $var['devise'];?></td>
      <td colspan="2">&nbsp;</td>
     </tr>
     <tr>
      <td colspan="3" class="text-right"><?php $plxPlugin->lang('L_CONFIG_NB_LINES') ?>&nbsp;:</td>
      <td colspan="2"><?php plxUtils::printInput('shipping_nb_lines',$var['shipping_nb_lines'],'number','2-2',false,'',' min="1" max="99"') ?></td>
     </tr>
     <tr>
      <td class="text-left" colspan="2">
       <label for="id_shipping_by_price"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_BY_PRICE');?>&nbsp;:</label>
      </td>
      <td colspan="3">
       <label class="switch switch-left-right">
        <input class="switch-input" id="id_shipping_by_price" name="shipping_by_price" type="checkbox"<?php
        echo 
         (("0" === $var["shipping_by_price"]) ? '' : ' checked="checked"')
         .' onchange="if (this.checked) {confdelivery(\''.$plxPlugin->getLang('L_CONFIG_DELIVERY_PRICE').$var['devise'].'\')}else{confdelivery(\''.$plxPlugin->getLang('L_CONFIG_DELIVERY_WEIGHT').'\')}"';
        ?> />
        <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
        <span class="switch-handle"></span>
        <script type="text/javascript">
        function confdelivery(content) {
         var elems = document.getElementsByTagName('td'), i;
         for (i in elems) {
          if((' ' + elems[i].className + ' ').indexOf(' confdelivery ') > -1) {
           elems[i].innerHTML = content + '&nbsp;:';
          }
         }
        }
        </script>
       </label>
      </td>
     </tr>
<?php
      for($i=1;$i<=$var["shipping_nb_lines"];$i++){
       $num=str_pad($i, 2, "0", STR_PAD_LEFT);
       $cnf=("0" === $var["shipping_by_price"]) ? $plxPlugin->getLang('L_CONFIG_DELIVERY_WEIGHT'): $plxPlugin->getLang('L_CONFIG_DELIVERY_PRICE').$var['devise'];
?>
     <tr>
      <td class="text-right confdelivery"><?php echo $cnf; ?>&nbsp;:</td>
      <td><?php plxUtils::printInput('p'.$num,$var['p'.$num],'text','0-120') ?></td>
      <td class="text-center">&lt;=</td>
      <td><?php plxUtils::printInput('pv'.$num,$var['pv'.$num],'text','0-120') ?></td>
      <td class="text-left"><?php echo $var['devise'];?></td>
     </tr>
<?php } ?>
    </table>
   </div>
  </fieldset>

   <div class="grid">
    <div class="col sml-9 label-centered">
     <label for="id_payment_cheque"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_CHEQUE');?>&nbsp;:</label>
    </div>
    <div class="col sml-3">
     <label class="switch switch-left-right">
      <input class="switch-input" id="id_payment_cheque" name="payment_cheque" type="checkbox"<?php echo ("0" === $var["payment_cheque"]) ? "" : " checked=\"checked\"";?> />
      <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
      <span class="switch-handle"></span>
     </label>
    </div>
   </div>
   <div class="grid">
    <div class="col sml-9 label-centered">
     <label for="id_payment_cash"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_CASH');?>&nbsp;:</label>
    </div>
    <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_payment_cash" name="payment_cash" type="checkbox"<?php echo ("0" === $var["payment_cash"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
    </div>
   </div>
   <div class="grid">
    <div class="col sml-9 label-centered">
     <label for="id_payment_paypal"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_PAYPAL');?>&nbsp;:</label>
    </div>
    <div class="col sml-3">
     <label class="switch switch-left-right">
      <input class="switch-input" id="id_payment_paypal" name="payment_paypal" type="checkbox"<?php echo (("0" === $var["payment_paypal"]) ? "" : " checked=\"checked\"").' onchange="if (this.checked) { document.getElementById(\'blockpaypal\').style.display=\'block\';}else{document.getElementById(\'blockpaypal\').style.display=\'none\';}"';?> />
      <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
      <span class="switch-handle"></span>
     </label>
    </div>
   </div>

  <fieldset id="blockpaypal" align="center" style="border:1px solid #333;display:<?php echo ($var['payment_paypal']==1?"block":"none"); ?>;">
   <legend><?php $plxPlugin->lang('L_CONFIG_CONF_PAYPAL') ?></legend>
   <input type="hidden" name="payment_paypal_test" value="<?php echo $var["payment_paypal_test"];?>"/>
   <input type="hidden" name="payment_paypal_test_user" value="<?php echo $var["payment_paypal_test_user"];?>"/>
   <input type="hidden" name="payment_paypal_test_pwd" value="<?php echo $var["payment_paypal_test_pwd"];?>"/>
   <input type="hidden" name="payment_paypal_test_signature" value="<?php echo $var["payment_paypal_test_signature"];?>"/>

   <input type="hidden" name="payment_paypal_pwd" value="<?php echo $var["payment_paypal_pwd"];?>"/>
   <input type="hidden" name="payment_paypal_signature" value="<?php echo $var["payment_paypal_signature"];?>"/>
   <input type="hidden" name="payment_paypal_overalldescription" value="<?php echo $var["payment_paypal_overalldescription"];?>"/>
   <input type="hidden" name="payment_paypal_ipnurl" value="<?php echo $var["payment_paypal_ipnurl"];?>"/>
   <input type="hidden" name="payment_paypal_logoimg" value="<?php echo $var["payment_paypal_logoimg"];?>"/>
   <input type="hidden" name="payment_paypal_payflowcolor" value="<?php echo $var["payment_paypal_payflowcolor"];?>"/>
   <input type="hidden" name="payment_paypal_cartbordercolor" value="<?php echo $var["payment_paypal_cartbordercolor"];?>"/>

   <div class="grid">
    <div class="col sml-12 med-5 label-centered">
     <label for="payment_paypal_amount"><?php $plxPlugin->lang('L_CONFIG_AMOUNT_PAYPAL') ?>&nbsp;(<?php echo $var['devise']; ?>)&nbsp;:</label>
    </div>
    <div class="col sml-12 med-7">
     <input name='payment_paypal_amount' value="<?php echo $var['payment_paypal_amount'];?>" type='text' >
    </div>
   </div>
   <div class="grid">
    <div class="col sml-12 med-5 label-centered">
     <label for="payment_paypal_user"><?php $plxPlugin->lang('L_CONFIG_EMAIL_PAYPAL') ?>&nbsp;:</label>
    </div>
    <div class="col sml-12 med-7">
     <input name='payment_paypal_user' value="<?php echo $var['payment_paypal_user'];?>" type='text' >
    </div>
   </div>
   <div class="grid">
    <div class="col sml-12 med-5 label-centered">
     <label for="payment_paypal_currencycode"><?php $plxPlugin->lang('L_CONFIG_CURRENCY_PAYPAL') ?> (<?php echo $var['payment_paypal_currencycode']; ?>)&nbsp;:</label>
    </div>
    <div class="col sml-12 med-7">
     <input name='payment_paypal_currencycode' value="<?php echo ($var['payment_paypal_currencycode']!=""?$var['payment_paypal_currencycode']:"EUR"); ?>" type='text' >
    </div>
   </div>
   <div class="grid">
    <div class="col sml-12 med-5 label-centered">
     <label for="payment_paypal_returnurl"><?php $plxPlugin->lang('L_CONFIG_RETURN_URL_PAYPAL') ?>&nbsp;:</label>
    </div>
    <div class="col sml-12 med-7">
     <input name='payment_paypal_returnurl' value="<?php echo ($var['payment_paypal_returnurl']!=""?$var['payment_paypal_returnurl']:$_SERVER['HTTP_HOST']); ?>" type='text' >
    </div>
   </div>
   <div class="grid">
    <div class="col sml-12 med-5 label-centered">
     <label for="payment_paypal_cancelurl"><?php $plxPlugin->lang('L_CONFIG_CANCEL_URL_PAYPAL') ?>&nbsp;:</label>
    </div>
    <div class="col sml-12 med-7">
     <input name='payment_paypal_cancelurl' value="<?php echo ($var['payment_paypal_cancelurl']!=""?$var['payment_paypal_cancelurl']:$_SERVER['HTTP_HOST']); ?>" type='text' >
    </div>
   </div>
  </fieldset>


  <h2><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_TITLE') ?></h2>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_email"><?php $plxPlugin->lang('L_EMAIL') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <input name='email' value="<?php echo $var['email']; ?>" type='text' >
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_email_cc"><?php $plxPlugin->lang('L_EMAIL_CC') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <input name='email_cc' value="<?php echo $var['email_cc']; ?>" type='text' >
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_email_bcc"><?php $plxPlugin->lang('L_EMAIL_BCC') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <input name='email_bcc' value="<?php echo $var['email_bcc']; ?>" type='text' >
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_subject"><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_SUBJECT_CUST') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('subject',$var['subject'],'text','0-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_newsubject"><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_SUBJECT_SHOP') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('newsubject',$var['newsubject'],'text','0-120') ?>
   </div>
  </div>

  <h2><?php $plxPlugin->lang('L_CONFIG_VALIDATION_COMMANDE') ?></h2>
<?php if($plxPlugin->aLangs){ ?>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_useLangCGVDefault"><?php $plxPlugin->lang('L_CONFIG_LANGUE_CGV_SYSTEME');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_useLangCGVDefault" name="useLangCGVDefault" type="checkbox"<?php echo (empty($var["useLangCGVDefault"])) ? '' : ' checked="checked"';?> onchange="if (this.checked) { document.getElementById('libCGV').style.display='none';}else{document.getElementById('libCGV').style.display='block';}" />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>
<?PHP } ?>
  <div class="grid" id="libCGV"<?php echo (empty($var["useLangCGVDefault"])) ? '' : ' style="display:none;"';?>>
   <div class="col sml-12 med-5 label-centered">
    <label><?php $plxPlugin->lang('L_CONFIG_LIBELLE_CGV') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <input name="libelleCGV" value="<?php echo $var['libelleCGV']; ?>" type="text">
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 success">
    <p><?php $plxPlugin->lang('L_CONFIG_INFO_CGV') ?></p>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered success">
    <label><?php $plxPlugin->lang('L_CONFIG_URL_CGV') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7 success">
    <input name="urlCGV" value="<?php echo $var['urlCGV']; ?>" type="text" placeholder="?static1">
   </div>
  </div>

  <h2><?php $plxPlugin->lang('L_CONFIG_MENU_TITLE') ?></h2>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_menu_position"><?php $plxPlugin->lang('L_CONFIG_MENU_POSITION') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('menu_position',$var['menu_position'],'number','5-120') ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_submenu"><?php $plxPlugin->lang('L_CONFIG_SUBMENU') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('submenu',$var['submenu'],'text','0-120') ?>
   </div>
  </div>

  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_affichePanierMenu"><?php $plxPlugin->lang('L_CONFIG_AFFICHER_PANIER_MENU');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_affichePanierMenu" name="affichePanierMenu" type="checkbox" <?php echo ("non" === $var["affichePanierMenu"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_afficheCategoriesMenu"><?php $plxPlugin->lang('L_CONFIG_AFFICHER_CATEGORIES_MENU');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_afficheCategoriesMenu" name="afficheCategoriesMenu" type="checkbox" <?php echo ("non" === $var["afficheCategoriesMenu"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_afficheLienPanierTop"><?php $plxPlugin->lang('L_CONFIG_AFFICHER_LIEN_PANIER_TOP');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_afficheLienPanierTop" name="afficheLienPanierTop" type="checkbox" <?php echo ("0" === $var["afficheLienPanierTop"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_localStorage"><?php $plxPlugin->lang('L_CONFIG_LOCALSTORAGE');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_localStorage" name="localStorage" type="checkbox" <?php echo ("0" === $var["localStorage"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-9 label-centered">
    <label for="id_cookie"><?php $plxPlugin->lang('L_CONFIG_COOKIE');?>&nbsp;:</label>
   </div>
   <div class="col sml-3">
    <label class="switch switch-left-right">
     <input class="switch-input" id="id_cookie" name="cookie" type="checkbox" <?php echo ("0" === $var["cookie"]) ? "" : " checked=\"checked\"";?> />
     <span class="switch-label" data-on="<?php echo L_YES ?>" data-off="<?php echo L_NO ?>"></span>
     <span class="switch-handle"></span>
    </label>
   </div>
  </div>

  <h2><?php $plxPlugin->lang('L_CONFIG_PAGE') ?></h2>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_affPanier"><?php $plxPlugin->lang('L_CONFIG_BASKET_DISPLAY') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printSelect("affPanier", $tabAffPanier, $var["affPanier"]) ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_template"><?php $plxPlugin->lang('L_CONFIG_PAGE_TEMPLATE') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printSelect('template', $aTemplates, $var['template']) ?>
   </div>
  </div>

  <h2><?php $plxPlugin->lang('L_CONFIG_FOLDERS') ?></h2>
<?php $placeholder = (defined('PLX_VERSION') && PLX_VERSION > '5.5')?' placeholder="data/commandes/"':'data/commandes'; ?>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_racine_commandes"><?php $plxPlugin->lang('L_CONFIG_ORDERS_FOLDER') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('racine_commandes',$var['racine_commandes'],'text','0-120', false, '', $placeholder) ?>
   </div>
  </div>
  <div class="grid">
   <div class="col sml-12 med-5 label-centered">
    <label for="id_racine_products"><?php $plxPlugin->lang('L_CONFIG_PRODUCTS_FOLDER') ?>&nbsp;:</label>
   </div>
   <div class="col sml-12 med-7">
    <?php plxUtils::printInput('racine_products',$var['racine_products'],'text','0-120', false, '', $placeholder) ?>
   </div>
  </div>
 </fieldset>
</form>

<p class="in-action-bar save-button plx<?php echo str_replace('.','-',@PLX_VERSION); echo $plxPlugin->aLangs?' multilingue':'';?>">
 <?php $plxPlugin->menuAdmin("configuration");?>
</p>
