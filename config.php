<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(defined('PLX_MYMULTILINGUE')) {
	$array =  explode(',', PLX_MYMULTILINGUE);
	$aLangs = array_intersect($array, array('fr', 'en', 'es'));
} else {
	$aLangs = array($plxPlugin->default_lang);
}

$tabAffPanier = array(
    "basPage" => $plxPlugin->getlang('L_PANIER_POS_BOTTOM') ,
    "pageSeparee" => $plxPlugin->getlang('L_PANIER_POS_SEPARATE') ,
    "partout" => $plxPlugin->getlang('L_PANIER_POS_BOTH') ,
);

$tabPosDevise = array(
    "before" => $plxPlugin->getlang('L_BEFORE') ,
    "after" => $plxPlugin->getlang('L_AFTER') ,
);


$var = array();
if(!empty($_POST)) {
	
	//socolissimo reco
	$plxPlugin->setParam('shipping_colissimo', $_POST['shipping_colissimo'], 'numeric');
	$plxPlugin->setParam('acurecept', $_POST['acurecept'], 'string');
	$plxPlugin->setParam('p01', $_POST['p01'], 'string'); $plxPlugin->setParam('pv01', $_POST['pv01'], 'string');
	$plxPlugin->setParam('p02', $_POST['p02'], 'string'); $plxPlugin->setParam('pv02', $_POST['pv02'], 'string');
	$plxPlugin->setParam('p03', $_POST['p03'], 'string'); $plxPlugin->setParam('pv03', $_POST['pv03'], 'string');
	$plxPlugin->setParam('p04', $_POST['p04'], 'string'); $plxPlugin->setParam('pv04', $_POST['pv04'], 'string');
	$plxPlugin->setParam('p05', $_POST['p05'], 'string'); $plxPlugin->setParam('pv05', $_POST['pv05'], 'string');
	$plxPlugin->setParam('p06', $_POST['p06'], 'string'); $plxPlugin->setParam('pv06', $_POST['pv06'], 'string');
	$plxPlugin->setParam('p07', $_POST['p07'], 'string'); $plxPlugin->setParam('pv07', $_POST['pv07'], 'string');
	$plxPlugin->setParam('p08', $_POST['p08'], 'string'); $plxPlugin->setParam('pv08', $_POST['pv08'], 'string');
	$plxPlugin->setParam('p09', $_POST['p09'], 'string'); $plxPlugin->setParam('pv09', $_POST['pv09'], 'string');
	$plxPlugin->setParam('p10', $_POST['p10'], 'string'); $plxPlugin->setParam('pv10', $_POST['pv10'], 'string');
	$plxPlugin->setParam('p11', $_POST['p11'], 'string'); $plxPlugin->setParam('pv11', $_POST['pv11'], 'string');
	//end socolissimo reco
	$plxPlugin->setParam('shipping_ups', 0, 'numeric');
	$plxPlugin->setParam('shipping_tnt', 0, 'numeric');
	$plxPlugin->setParam('payment_cheque', $_POST['payment_cheque'], 'numeric');	
	$plxPlugin->setParam('payment_cash', $_POST['payment_cash'], 'numeric');	
	//paypal
	$plxPlugin->setParam('payment_paypal', $_POST['payment_paypal'], 'numeric');
	$plxPlugin->setParam('payment_paypal_test', $_POST['payment_paypal_test'], 'numeric');
	$plxPlugin->setParam('payment_paypal_currencycode', $_POST['payment_paypal_currencycode'], 'string');
	$plxPlugin->setParam('payment_paypal_overalldescription', $_POST['payment_paypal_overalldescription'], 'string');
	//test
	$plxPlugin->setParam('payment_paypal_test_user', $_POST['payment_paypal_test_user'], 'string');
	$plxPlugin->setParam('payment_paypal_test_pwd', $_POST['payment_paypal_test_pwd'], 'string');
	$plxPlugin->setParam('payment_paypal_test_signature', $_POST['payment_paypal_test_signature'], 'string');
	//prod
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
	$plxPlugin->setParam('keyxorcrypt', $_POST['keyxorcrypt'], 'string');
	$plxPlugin->setParam('menu_position', $_POST['menu_position'], 'numeric');
	
    $plxPlugin->setParam('affPanier', $_POST['affPanier'], 'string');


    $plxPlugin->setParam('position_devise', $_POST['position_devise'], 'string');
	
	
	$plxPlugin->saveParams();
	header('Location: parametres_plugin.php?p=plxMyShop');
	exit;
}
# initialisation des variables communes à chaque langue
$var['subject'] = $plxPlugin->getParam('subject')=='' ? "Récapitulatif de commande" : $plxPlugin->getParam('subject');
$var['newsubject'] = $plxPlugin->getParam('newsubject')=='' ? "Nouvelle commande" : $plxPlugin->getParam('newsubject');
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
$var['shipping_colissimo'] = $plxPlugin->getParam('shipping_colissimo')=='' ? '' : $plxPlugin->getParam('shipping_colissimo');
$var['acurecept'] = $plxPlugin->getParam('acurecept')=='' ? '' : $plxPlugin->getParam('acurecept');
$var['p01'] = $plxPlugin->getParam('p01')=='' ? '' : $plxPlugin->getParam('p01');
$var['pv01'] = $plxPlugin->getParam('pv01')=='' ? '' : $plxPlugin->getParam('pv01');
$var['p02'] = $plxPlugin->getParam('p02')=='' ? '' : $plxPlugin->getParam('p02');
$var['pv02'] = $plxPlugin->getParam('pv02')=='' ? '' : $plxPlugin->getParam('pv02');
$var['p03'] = $plxPlugin->getParam('p03')=='' ? '' : $plxPlugin->getParam('p03');
$var['pv03'] = $plxPlugin->getParam('pv03')=='' ? '' : $plxPlugin->getParam('pv03');
$var['p04'] = $plxPlugin->getParam('p04')=='' ? '' : $plxPlugin->getParam('p04');
$var['pv04'] = $plxPlugin->getParam('pv04')=='' ? '' : $plxPlugin->getParam('pv04');
$var['p05'] = $plxPlugin->getParam('p05')=='' ? '' : $plxPlugin->getParam('p05');
$var['pv05'] = $plxPlugin->getParam('pv05')=='' ? '' : $plxPlugin->getParam('pv05');
$var['p06'] = $plxPlugin->getParam('p06')=='' ? '' : $plxPlugin->getParam('p06');
$var['pv06'] = $plxPlugin->getParam('pv06')=='' ? '' : $plxPlugin->getParam('pv06');
$var['p07'] = $plxPlugin->getParam('p07')=='' ? '' : $plxPlugin->getParam('p07');
$var['pv07'] = $plxPlugin->getParam('pv07')=='' ? '' : $plxPlugin->getParam('pv07');
$var['p08'] = $plxPlugin->getParam('p08')=='' ? '' : $plxPlugin->getParam('p08');
$var['pv08'] = $plxPlugin->getParam('pv08')=='' ? '' : $plxPlugin->getParam('pv08');
$var['p09'] = $plxPlugin->getParam('p09')=='' ? '' : $plxPlugin->getParam('p09');
$var['pv09'] = $plxPlugin->getParam('pv09')=='' ? '' : $plxPlugin->getParam('pv09');
$var['p10'] = $plxPlugin->getParam('p10')=='' ? '' : $plxPlugin->getParam('p10');
$var['pv10'] = $plxPlugin->getParam('pv10')=='' ? '' : $plxPlugin->getParam('pv10');
$var['p11'] = $plxPlugin->getParam('p11')=='' ? '' : $plxPlugin->getParam('p11');
$var['pv11'] = $plxPlugin->getParam('pv11')=='' ? '' : $plxPlugin->getParam('pv11');
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
$var['devise'] = $plxPlugin->getParam('devise')=='' ? '€' : $plxPlugin->getParam('devise');
$var['keyxorcrypt'] = $plxPlugin->getParam('keyxorcrypt')=='' ? 'Ab123cD$' : $plxPlugin->getParam('keyxorcrypt');
$var['menu_position'] = $plxPlugin->getParam('menu_position')=='' ? 3 : $plxPlugin->getParam('menu_position');

$var["affPanier"] = ("" === $plxPlugin->getParam("affPanier")) ? current(array_keys($tabAffPanier)) : $plxPlugin->getParam("affPanier");

$var["position_devise"] = ("" === $plxPlugin->getParam("position_devise")) ? current(array_keys($tabPosDevise)) : $plxPlugin->getParam("position_devise");

# On récupère les templates des pages statiques
$aTemplates = array();
$files = plxGlob::getInstance(PLX_ROOT.$plxAdmin->aConf['racine_themes'].$plxAdmin->aConf['style']);
if ($array = $files->query('/^static(-[a-z0-9-_]+)?.php$/')) {
	foreach($array as $k=>$v)
		$aTemplates[$v] = $v;
}
?>

<h2><?php echo $plxPlugin->getInfo('title') ?></h2>
<a href="plugin.php?p=plxMyShop"><button><?php $plxPlugin->lang('L_MENU_PRODUCTS') ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plugin.php?p=plxMyShop&mod=cat"><button><?php $plxPlugin->lang('L_MENU_CATS') ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plugin.php?p=plxMyShop&mod=cmd"><button><?php $plxPlugin->lang('L_MENU_ORDERS') ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="parametres_plugin.php?p=plxMyShop"><button disabled><?php $plxPlugin->lang('L_MENU_CONFIG') ?></button></a></p>

<p></p>
<p></p>

<div id="tabContainer">
<form id="form_plxmyshop" action="parametres_plugin.php?p=plxMyShop" method="post">

	<div>
        <h2><?php $plxPlugin->lang('L_CONFIG_SHOP_INFO') ?></h2><br>
        <p class="field"><label for="id_shop_name"><?php $plxPlugin->lang('L_CONFIG_SHOP_NAME') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('shop_name',$var['shop_name'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_commercant_name"><?php $plxPlugin->lang('L_CONFIG_SHOP_OWNER') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('commercant_name',$var['commercant_name'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_commercant_street"><?php $plxPlugin->lang('L_CONFIG_SHOP_STREET') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('commercant_street',$var['commercant_street'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_commercant_postcode"><?php $plxPlugin->lang('L_CONFIG_SHOP_ZIP') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('commercant_postcode',$var['commercant_postcode'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_commercant_city"><?php $plxPlugin->lang('L_CONFIG_SHOP_TOWN') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('commercant_city',$var['commercant_city'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_devise"><?php $plxPlugin->lang('L_CONFIG_SHOP_CURRENCY') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('devise',$var['devise'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_position_devise"><?php $plxPlugin->lang('L_CONFIG_POSITION_CURRENCY') ?>&nbsp;:</label></p>
			    <p><?php plxUtils::printSelect("position_devise", $tabPosDevise, $var["position_devise"]) ?></p>
				<p></p>
	    
        <h2><?php $plxPlugin->lang('L_CONFIG_SECURITY') ?></h2><br>
        <p class="field"><label for="id_keyxorcrypt"><?php $plxPlugin->lang('L_CONFIG_SECURITY_KEY') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('keyxorcrypt',$var['keyxorcrypt'],'text','100-120') ?></p>
				<p></p>
				
        <h2><?php $plxPlugin->lang('L_CONFIG_DELIVERY_TITLE') ?></h2><br>
        <p class="field"><label for="shipping_colissimo"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_SHIPPING') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printSelect('shipping_colissimo',array('1'=>L_YES,'0'=>L_NO),$var['shipping_colissimo'], "", '" onchange="if (this.value==\'1\') { document.getElementById(\'blocksocoreco\').style.display=\'block\';}else{document.getElementById(\'blocksocoreco\').style.display=\'none\';}'); ?></p>
				<p></p>
		<fieldset id="blocksocoreco" align="center" style="border:1px solid #333;display:<?php echo ($var['shipping_colissimo']==1?"block":"none"); ?>;">
        <legend><?php $plxPlugin->lang('L_CONFIG_DELIVERY_CONFIG') ?></legend>
		    <table>
		        <tr>
                    <td colspanb='2'><?php $plxPlugin->lang('L_CONFIG_RECORDED_DELIVERY') ?>:&nbsp;<?php plxUtils::printInput('acurecept',$var['acurecept'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
                    <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p01',$var['p01'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv01',$var['pv01'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p02',$var['p02'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv02',$var['pv02'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p03',$var['p03'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv03',$var['pv03'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p04',$var['p04'],'text','25-120') ?>&nbsp;<=</td>
	    
        <h2><?php $plxPlugin->lang('L_CONFIG_SECURITY') ?></h2><br>
        <p class="field"><label for="id_keyxorcrypt"><?php $plxPlugin->lang('L_CONFIG_SECURITY_KEY') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('keyxorcrypt',$var['keyxorcrypt'],'text','100-120') ?></p>
				<p></p>
				
        <h2><?php $plxPlugin->lang('L_CONFIG_DELIVERY_TITLE') ?></h2><br>
        <p class="field"><label for="shipping_colissimo"><?php $plxPlugin->lang('L_CONFIG_DELIVERY_SHIPPING') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printSelect('shipping_colissimo',array('1'=>L_YES,'0'=>L_NO),$var['shipping_colissimo'], "", '" onchange="if (this.value==\'1\') { document.getElementById(\'blocksocoreco\').style.display=\'block\';}else{document.getElementById(\'blocksocoreco\').style.display=\'none\';}'); ?></p>
				<p></p>
		<fieldset id="blocksocoreco" align="center" style="border:1px solid #333;display:<?php echo ($var['shipping_colissimo']==1?"block":"none"); ?>;">
        <legend><?php $plxPlugin->lang('L_CONFIG_DELIVERY_CONFIG') ?></legend>
		    <table>
		        <tr>
                    <td colspanb='2'><?php $plxPlugin->lang('L_CONFIG_RECORDED_DELIVERY') ?>:&nbsp;<?php plxUtils::printInput('acurecept',$var['acurecept'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
                    <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p01',$var['p01'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv01',$var['pv01'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p02',$var['p02'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv02',$var['pv02'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p03',$var['p03'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv03',$var['pv03'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p04',$var['p04'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv04',$var['pv04'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p05',$var['p05'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv05',$var['pv05'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p06',$var['p06'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv06',$var['pv06'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p07',$var['p07'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv07',$var['pv07'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p08',$var['p08'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv08',$var['pv08'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p09',$var['p09'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv09',$var['pv09'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p10',$var['p10'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv10',$var['pv10'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		        <tr>
		            <td><?php $plxPlugin->lang('L_CONFIG_DELIVERY_WEIGHT') ?>&nbsp;:&nbsp;<?php plxUtils::printInput('p11',$var['p11'],'text','25-120') ?>&nbsp;<=</td>
		            <td><?php plxUtils::printInput('pv11',$var['pv11'],'text','25-120') ?>&nbsp;<?php echo $var['devise'];?></td>
		        </tr>
		    </table>
		</fieldset>
		
        <p class="field"><label for="id_payment_cheque"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_CHEQUE') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printSelect('payment_cheque',array('1'=>L_YES,'0'=>L_NO),$var['payment_cheque']); ?></p>
				<p></p>
        <p class="field"><label for="id_payment_cash"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_CASH') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printSelect('payment_cash',array('1'=>L_YES,'0'=>L_NO),$var['payment_cash']); ?></p>
				<p></p>
        <p class="field"><label for="id_payment_paypal"><?php $plxPlugin->lang('L_CONFIG_PAYMENT_PAYPAL') ?>&nbsp;:</label></p><?php plxUtils::printSelect('payment_paypal',array('1'=>L_YES,'0'=>L_NO),$var['payment_paypal'], "", '" onchange="if (this.value==\'1\') { document.getElementById(\'blockpaypal\').style.display=\'block\';}else{document.getElementById(\'blockpaypal\').style.display=\'none\';}'); ?></p>
				<p></p>
				
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
				
                <p class="field"><label for="payment_paypal_user"><?php $plxPlugin->lang('L_CONFIG_EMAIL_PAYPAL') ?>&nbsp;:</label></p>
				<p><input name='payment_paypal_user' value="<?php echo $var['payment_paypal_user'];?>" type='text' ></p>
				<p></p>
                <p class="field" ><label for="payment_paypal_currencycode"><?php $plxPlugin->lang('L_CONFIG_CURRENCY_PAYPAL') ?> (<?php echo $var['payment_paypal_currencycode']; ?>)&nbsp;:</label></p>
				<p><input name='payment_paypal_currencycode' value="<?php echo ($var['payment_paypal_currencycode']!=""?$var['payment_paypal_currencycode']:"EUR"); ?>" type='text' ></p>
				<p></p>
                <p class="field" ><label for="payment_paypal_returnurl"><?php $plxPlugin->lang('L_CONFIG_RETURN_URL_PAYPAL') ?>&nbsp;:</label></p>
				<p><input name='payment_paypal_returnurl' value="<?php echo ($var['payment_paypal_returnurl']!=""?$var['payment_paypal_returnurl']:$_SERVER['HTTP_HOST']); ?>" type='text' ></p>
				<p></p>
                <p class="field" ><label for="payment_paypal_cancelurl"><?php $plxPlugin->lang('L_CONFIG_CANCEL_URL_PAYPAL') ?>&nbsp;:</label></p>
				<p><input name='payment_paypal_cancelurl' value="<?php echo ($var['payment_paypal_cancelurl']!=""?$var['payment_paypal_cancelurl']:$_SERVER['HTTP_HOST']); ?>" type='text' ></p>
				<p></p>
		</fieldset>
        <h2><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_TITLE') ?></h2><br>
	    <p class="field"><label for="id_email"><?php $plxPlugin->lang('L_EMAIL') ?>&nbsp;:</label></p>
				<p><input name='email' value="<?php echo $var['email']; ?>" type='text' ></p>
				<p></p>
		<p class="field"><label for="id_email_cc"><?php $plxPlugin->lang('L_EMAIL_CC') ?>&nbsp;:</label></p>
				<p><input name='email_cc' value="<?php echo $var['email_cc']; ?>" type='text' ></p>
				<p></p>
		<p class="field"><label for="id_email_bcc"><?php $plxPlugin->lang('L_EMAIL_BCC') ?>&nbsp;:</label></p>
				<p><input name='email_bcc' value="<?php echo $var['email_bcc']; ?>" type='text' ></p>
				<p></p>
                <p class="field"><label for="id_subject"><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_SUBJECT_CUST') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('subject',$var['subject'],'text','100-120') ?></p>
				<p></p>
                <p class="field"><label for="id_newsubject"><?php $plxPlugin->lang('L_CONFIG_EMAIL_ORDER_SUBJECT_SHOP') ?>&nbsp;:</label></p>
				<p><?php plxUtils::printInput('newsubject',$var['newsubject'],'text','100-120') ?></p>
		<p></p>
		<br/>
		
        <h2><?php $plxPlugin->lang('L_CONFIG_MENU_TITLE') ?></h2>
        <p class="field"><label for="id_menu_position"><?php $plxPlugin->lang('L_CONFIG_MENU_POSITION') ?>&nbsp;:</label></p>
			<p><?php plxUtils::printInput('menu_position',$var['menu_position'],'number','100-120') ?></p>
		<p></p>
		<br/>
		
        <h2><?php $plxPlugin->lang('L_CONFIG_PAGE') ?></h2>
        <p class="field"><label for="id_affPanier"><?php $plxPlugin->lang('L_CONFIG_BASKET_DISPLAY') ?>&nbsp;:</label></p>
			<p><?php plxUtils::printSelect("affPanier", $tabAffPanier, $var["affPanier"]) ?></p>
            <p class="field"><label for="id_template"><?php $plxPlugin->lang('L_CONFIG_PAGE_TEMPLATE') ?>&nbsp;:</label></p>
			<p><?php plxUtils::printSelect('template', $aTemplates, $var['template']) ?></p>
		<p></p>
		
		
	</div>
	<fieldset align="center"></p>
				<p></p>
		<p>
			<?php echo plxToken::getTokenPostMethod() ?>
            <input type="submit" name="submit" value="<?php $plxPlugin->lang('L_CONFIG_SUBMIT') ?>" />
		</p>
	</fieldset>
</form>
</div>
