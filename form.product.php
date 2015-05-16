<?php if(!defined('PLX_ROOT')) exit; 
//unset($_SESSION['prods']);

$plxShow = plxShow::getInstance();
$plxPlugin = $plxShow->plxMotor->plxPlugins->aPlugins['plxMyShop'];
$plxPlugin->donneesModeles["plxPlugin"] = $plxPlugin;

// cryptage
require(PLX_PLUGINS.'plxMyShop/inc/xorCrypt.inc.php');
$xorCrypt = new xorCrypt();
$xorCrypt->set_key($plxPlugin->getParam('keyxorcrypt'));

static $totalkg=0.000;

function shippingMethod($kg, $op){
	$plxShow = plxShow::getInstance();
	$plxPlugin = $plxShow->plxMotor->plxPlugins->aPlugins['plxMyShop'];
	
    $accurecept=(float)$plxPlugin->getParam('acurecept');
    if ($kg<=0) {
        $shippingPrice=0.00;
    } else if ((float)$kg<=$plxPlugin->getParam('p01')) {
        $shippingPrice=$shippingPrice1;
    } else if ((float)$kg<=$plxPlugin->getParam('p02')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv02')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p03')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv03')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p04')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv04')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p05')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv05')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p06')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv06')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p07')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv07')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p08')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv08')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p09')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv09')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p10')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv10')+$accurecept);
    } else if ((float)$kg<=(float)$plxPlugin->getParam('p11')) {
        $shippingPrice=((float)$plxPlugin->getParam('pv11')+$accurecept);
    } else {
        $shippingPrice=0.00;
    }
    return (float)$shippingPrice;
}

/* TON MAIL */
$TONMAIL=$plxPlugin->getParam('email');
$TON2EMEMAIL=$plxPlugin->getParam('email_cc');
$SHOPNAME=$plxPlugin->getParam('shop_name');
$COMMERCANTNAME=$plxPlugin->getParam('commercant_name');
$COMMERCANTPOSTCODE=$plxPlugin->getParam('commercant_postcode');
$COMMERCANTCITY=$plxPlugin->getParam('commercant_city');
$COMMERCANTSTREET=$plxPlugin->getParam('commercant_street');

$IFSOCO=($plxPlugin->getParam('shipping_colissimo')==1?true:false);

$tabMethodespaiement = array(
	"cheque" => array(
		"libelle" => "Chèque",
		"codeOption" => "payment_cheque",
	),
	"paypal" => array(
		"libelle" => "Paypal",
		"codeOption" => "payment_paypal",
	),
);

$tabChoixMethodespaiement = array();

foreach ($tabMethodespaiement as $codeMethodespaiement => $m) {
	if ("1" === $plxPlugin->getParam($m["codeOption"])) {
		$tabChoixMethodespaiement[$codeMethodespaiement] = $m;
	}
}

$plxPlugin->donneesModeles["tabChoixMethodespaiement"] = $tabChoixMethodespaiement;


if (	isset($_POST["methodpayment"])
	&&	!isset($tabChoixMethodespaiement[$_POST["methodpayment"]])
) {
	// si la méthode de paiement n'est pas autorisé, choix par défaut
	$_POST["methodpayment"] = current($tabChoixMethodespaiement);
}


if (($plxPlugin->aProds[ $plxPlugin->productNumber()]['active']!=1 || $plxPlugin->aProds[ $plxPlugin->productNumber()]['readable']!=1) && ($plxPlugin->aProds[ $plxPlugin->productNumber()]['pcat']!=1)) header('Location: index.php');

echo "<script type='text/javascript' src='".PLX_PLUGINS."plxMyShop/js/libajax.js'></script>
<script type='text/javascript'>var error=false;</script>";
            $_SESSION['msgCommand']="";
            $msgCommand="";
        if (isset($_POST['prods']) && plxUtils::cdataCheck($_POST['prods'])!="") {
            //récupération de la liste des produit du panier
            $totalpricettc=0.00;
            $totalpoidg=0.00;
            $totalpoidgshipping=0.00;
            $productscart=array();
            if (isset($_SESSION['prods'])) {
                foreach ($_SESSION['prods'] as $k => $v) {
                    $totalpricettc= ((float)$plxPlugin->aProds[$v]['pricettc']+(float)$totalpricettc);
                    $totalpoidg= ((float)$plxPlugin->aProds[$v]['poidg']+(float)$totalpoidg);
                    $productscart[$v]=array('pricettc' => $plxPlugin->aProds[$v]['pricettc'],
                                            'poidg' => $plxPlugin->aProds[$v]['poidg'],
                                            'name' => $plxPlugin->aProds[$v]['name'],
                                            'device' => $plxPlugin->aProds[$v]['device']
                                        );
                }
                $totalpoidgshipping=shippingMethod($totalpoidg, 1);
            }

            //if ( $_POST['methodpayment']== "paypal") {
                
            //} elseif($_POST['methodpayment']== "cheque") {
                #Mail de nouvelle commande pour le commerçant.
                $sujet = 'Nouvelle commande '.$SHOPNAME;
                $message = plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."<br />".
                plxUtils::cdataCheck($_POST['adress'])."<br />".
                plxUtils::cdataCheck($_POST['postcode'])." ".plxUtils::cdataCheck($_POST['city'])."<br />".
                plxUtils::cdataCheck($_POST['country'])."<br />".
                "Tel : ".plxUtils::cdataCheck($_POST['tel'])."<br /><br />".
                "Méthode de paiement : ".($_POST['methodpayment']=="paypal"?"Paypal":"Chèque").
                "<br>Liste des produits :<br /><ul>";
                foreach ($productscart as $k => $v) {
                    $message.="<li>".$v['name']." ".$v['pricettc'].$v['device'].((float)$v['poidg']>0?" pour ".$v['poidg']."Kg":"")."</li>";
                }
                $message.="</ul><br /><br>".
                "<strong>Total (frais de port inclus): ".($totalpricettc+$totalpoidgshipping)."&euro;</strong><br />".
                "<em><strong>Frais de port : ".$totalpoidgshipping."&euro;</strong><br />".
                "<strong>Poids : ".$totalpoidg."kg</strong><br /><br /></em>".
                "Commentaire : <br>".plxUtils::cdataCheck($_POST['msg']);
                $destinataire = $TONMAIL.(isset($TON2EMEMAIL) && !empty($TON2EMEMAIL)?', '.$TON2EMEMAIL:"");
                $headers = "MIME-Version: 1.0\r\nFrom: \"".plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."\"<".$_POST['email'].">\r\n";
                $headers .= "Reply-To: ".$_POST['email']."\r\nX-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $_SERVER["REMOTE_ADDR"] . "\r\n";
                $headers .= "Content-Type: text/html;charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
                
                if (    (isset($_POST['email']) && $_POST['email']!="") && 
                        (isset($_POST['firstname']) && plxUtils::cdataCheck($_POST['firstname'])!="") && 
                        (isset($_POST['lastname']) &&  plxUtils::cdataCheck($_POST['lastname'])!="") && 
                        (isset($_POST['adress']) &&  plxUtils::cdataCheck($_POST['adress'])!="") && 
                        (isset($_POST['postcode']) &&  plxUtils::cdataCheck($_POST['postcode'])!="") && 
                        (isset($_POST['city']) && plxUtils::cdataCheck($_POST['city'])!="") && 
                        (isset($_POST['country']) && plxUtils::cdataCheck($_POST['country'])!="") 
                    ) {
                    
                    if(mail($destinataire,$sujet,$message,$headers)){
                        if ($_POST['methodpayment']=="paypal") {
                            $msgCommand.= "<h2 class='h2okmsg' >La commande est confirmé et en cours de validation de votre par sur Paypal</h2>";
                        } else if ($_POST['methodpayment']=="cheque") { 
                             $msgCommand.= "<h2 class='h2okmsg'>La commande a bien été confirmé et envoyé par email.</h2>";
                        }
                        $commandError=false;
                        #Mail de récapitulatif de commande pour le client.
                        $sujet = 'Récapitulatif commande '.$SHOPNAME;
                        $message = "<p>Vous venez de confirmer une commande sur <a href='http://".$_SERVER["HTTP_HOST"]."'>".$SHOPNAME."</a>".
                        "<br>Cette commande est en ".($_POST['methodpayment']=="cheque"?"attente":"cours")." de règlement</p>";
                        if ($_POST['methodpayment']=="cheque") {
                            $message .="<p>Pour finaliser cette commande veuillez établir le chèque à l'ordre de : ".$COMMERCANTNAME."<br>Envoyer votre chèque à cette addresse :".
                            "<br><em>&nbsp;&nbsp;&nbsp;&nbsp;".$SHOPNAME."".
                            "<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTNAME."".
                            "<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTSTREET."".
                            "<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTPOSTCODE." ".$COMMERCANTCITY."</em></p>";
                        } elseif ($_POST['methodpayment']=="paypal") {
                             $message .="<p>Cette commande sera finalisé une fois le paiement Paypal contrôlé.</p>";
                        }
                        $message .= "<br><h1><u>Récapitulatif de votre commande :</u></h1>".
                        "<br><strong>Addresse de livraison :</strong>".plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."<br />".
                        plxUtils::cdataCheck($_POST['adress'])."<br />".
                        plxUtils::cdataCheck($_POST['postcode'])." ".plxUtils::cdataCheck($_POST['city'])."<br />".
                        plxUtils::cdataCheck($_POST['country'])."<br />".
                        "<strong>Tel : </strong>".plxUtils::cdataCheck($_POST['tel'])."<br /><br />".
                        "<strong>Méthode de paiement : </strong>".($_POST['methodpayment']=="paypal"?"Paypal":"Chèque").
                        "<br><strong>Liste des produits :</strong><br />";
                        foreach ($productscart as $k => $v) {
                            $message.="<li>".$v['name']." ".$v['pricettc'].$v['device'].((float)$v['poidg']>0?" pour ".$v['poidg']."Kg":"")."</li>";
                        }
                        $message.= "<br /><br>".
                        "<strong>Total (frais de port inclus) : </strong>".($totalpricettc+$totalpoidgshipping)."&euro;<br />".
                        "<em><strong>Frais de port : </strong>".$totalpoidgshipping."&euro;<br />".
                        "<strong>Poids : </strong>".$totalpoidg."kg<br /><br /></em>".
                        "<strong>Votre Commentaire : </strong><br>".plxUtils::cdataCheck($_POST['msg']);
                        $destinataire = $_POST['email'];
                        $headers = "MIME-Version: 1.0\r\nFrom: \"".$SHOPNAME."\"<".$TONMAIL.">\r\n";
                        $headers .= "Reply-To: ".$TONMAIL.(isset($TON2EMEMAIL) && !empty($TON2EMEMAIL)?', '.$TON2EMEMAIL:"")."\r\nX-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $_SERVER["REMOTE_ADDR"] . "\r\n";
                        $headers .= "Content-Type: text/html;charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
                        if(mail($destinataire,$sujet,$message,$headers)){
                            $msgCommand.= "<h2 class='h2okmsg2'>Un email de récapitulatif de commande vous a été envoyé.</h2>";
                            $msgCommand.= "<h2 class='h2okmsg3' >Si l'email de récapitulatif de commande n'apparait pas dans votre liste de mails en attente ou que celui-ci est signalé en tant que Spam. Veuillez ajouter \"".$TONMAIL."\" à votre liste de contacts.</h2>";
                            if ( $_POST['methodpayment']== "paypal") include(PLX_PLUGINS.'plxMyShop/paypal_api/SetExpressCheckout.php');
                            $nf=PLX_ROOT.'data/commandes/'.date("Y-m-d_H-i-s_").$_POST['methodpayment'].'_'.$totalpricettc.'_'.$totalpoidgshipping.'.html';
                            $monfichier = fopen($nf, 'w+');
                            $commandeContent="<!DOCTYPE html>
<html>
    <head>
        <title>Commande du ".date("d m Y")."</title>
        <meta charset=\"UTF-8\">
        <meta name=\"description\" content=\"Commande\">
        <meta name=\"author\" content=\"plxMyShop\">
    </head>
    <body>
        ".$message."
    </body>
</html>";
                            fputs($monfichier, $commandeContent);
                            fclose($monfichier);
                            chmod($nf, 0644);
                            unset($_SESSION['prods']);
                            unset($_SESSION['ncart']);
                        }else{
                            $msgCommand.= "<h2 class='h2nomsg'>Une erreur c'est produite lors de l'envois de votre email de récapitulatif.</h2>";
                        }
                    }else{
                        $msgCommand.= "<h2 class='h2nomsg'>Une erreur c'est produite lors de l'envois de la commande par email.</h2>";
                        echo "<script type='text/javascript'>error=true;</script>";
                        $commandError=true;
                    }
                    $_SESSION['msgCommand']=$msgCommand;
                } else {
                    if ( (!isset($_POST['email']) || empty($_POST['email']) || $_POST['email']=="") ) {
                        $msgCommand.= "<h2 class='h2nomsg'>l'addresse email n'est pas défini.</h2>";
                    }
                    
                    if (  (!isset($_POST['firstname']) ||  plxUtils::cdataCheck($_POST['firstname'])=="") ) {
                        $msgCommand.= "<h2 class='h2nomsg'>Le prénom n'est pas défini</h2>";
                    }
                    
                    if ( (!isset($_POST['lastname']) ||  plxUtils::cdataCheck($_POST['lastname'])=="")  ) {
                        $msgCommand.= "<h2 class='h2nomsg'>Le nom de famille n'est pas défini</h2>";
                    }
                    
                    if ( (!isset($_POST['adress']) ||  plxUtils::cdataCheck($_POST['adress'])=="")  ) {
                        $msgCommand.= "<h2 class='h2nomsg'>L'addresse n'est pas défini</h2>";
                    }
                    
                    if ( (!isset($_POST['postcode']) ||  plxUtils::cdataCheck($_POST['postcode'])=="") ) {
                        $msgCommand.= "<h2 class='h2nomsg'>Le code postal n'est pas défini</h2>";
                    }
                    
                    if ( (!isset($_POST['city']) ||  plxUtils::cdataCheck($_POST['city'])=="") ) {
                        $msgCommand.= "<h2 class='h2nomsg'>La ville n'est pas défini.</h2>";
                    }
                    
                    if ( (!isset($_POST['country']) ||  plxUtils::cdataCheck($_POST['country'])=="") ) {
                        $msgCommand.= "<h2 class='h2nomsg'>Le pays n'est pas défini.</h2>";
                    }
                    echo "<script type='text/javascript'>error=true;</script>";
                    $_SESSION['msgCommand']=$msgCommand;
                    $commandError=true;
                }
            //}
        }
?>

<?php

if ("1" === $plxPlugin->aProds[$plxPlugin->productNumber()]['pcat']) {
	$plxPlugin->modele("espacePublic/categorie");
} else { 
	$plxPlugin->modele("espacePublic/produit");
}

?>


<?php $plxPlugin->modele("espacePublic/panier");?>


<script type="text/javascript">
var total=0;
var totalkg=0;
var shippingPrice=0;
var tmpship=0;
var nprod=0;
var realnprod=0;
var formCart=document.getElementById('formcart');
var shoppingCart=document.getElementById('shoppingCart');
var btnCart=document.getElementById('btnCart');
var msgCart=document.getElementById('msgCart');
var labelMsgCart=document.getElementById('labelMsgCart');
var PRODS=document.getElementById('prodsCart');
var msgAddCart=document.getElementById('msgAddCart');
var notiNumShoppingCart=document.getElementById('notiNumShoppingCart');

var idSuite=document.getElementById('idsuite');
var numCart=document.getElementById('numcart');

var mailCart=document.getElementById('email');
var labelMailCart=document.getElementById('labelMailCart');
var firstnameCart=document.getElementById('firstname');
var labelFirstnameCart=document.getElementById('labelFirstnameCart');
var lastnameCart=document.getElementById('lastname');
var labelLastnameCart=document.getElementById('labelLastnameCart');

var adressCart=document.getElementById('adress');
var labelAddrCart=document.getElementById('labelAddrCart');
var postcodeCart=document.getElementById('postcode');
var labelPostcodeCart=document.getElementById('labelPostcodeCart');
var cityCart=document.getElementById('city');
var labelCityCart=document.getElementById('labelCityCart');
var countryCart=document.getElementById('country');
var labelCountryCart=document.getElementById('labelCountryCart');

var telCart=document.getElementById('tel');
var labelTelCart=document.getElementById('labelTelCart');

var totalCart=document.getElementById('totalCart');
var totalcommand=document.getElementById('totalcommand');
var shipping=document.getElementById('shipping');
var shipping_kg=document.getElementById('shipping_kg');
var spanshipping=document.getElementById('spanshipping');
<?php
if (isset($_SESSION['prods']) && is_array($_SESSION['prods'])) {
    $sessioncart="";
    $totalpricettc=0.00;
    $totalpoidg=0.00;
    $nprod=0;
    
    foreach ($_SESSION['prods'] as $k => $v) {
        if (isset($plxPlugin->aProds[$v])){
            $totalpricettc= ((float)$plxPlugin->aProds[$v]['pricettc']+(float)$totalpricettc);
            $totalpoidg= ((float)$plxPlugin->aProds[$v]['poidg']+(float)$totalpoidg);
            $productscart[$v]=array('pricettc' => $plxPlugin->aProds[$v]['pricettc'],
                                    'poidg' => $plxPlugin->aProds[$v]['poidg'],
                                    'name' => $plxPlugin->aProds[$v]['name'],
                                    'device' => $plxPlugin->aProds[$v]['device']);
            $sessioncart.="<span id=\"p".$nprod."\"><br>-".preg_replace("/'/",'&apos;',$productscart[$v]['name'])."&nbsp;&nbsp;&nbsp;&nbsp;".$productscart[$v]['pricettc'].$productscart[$v]['device'].((float)$productscart[$v]['poidg']>0?" pour ".$productscart[$v]['poidg']."Kg":"").'&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="removeCart(\\\'p'.$nprod.'\\\', '.$productscart[$v]['pricettc'].', '.$productscart[$v]['poidg'].', \\\''.$v.'\\\');return false;" id="delp'.$nprod.'">Supprimer</button></span>';
            $nprod++;
        }
    }
    $totalpoidgshipping=shippingMethod($totalpoidg, 1);
    if (sizeof($_SESSION['prods']) > 0 ) echo "var error=true;\n";
    else echo "var error=false;\n";
?>
if (error) {
    shoppingCart.innerHTML='<?php echo $sessioncart; ?>';
    PRODS.value=shoppingCart.innerHTML;
    btnCart.style.display='inline-block';
    msgCart.style.display='inline-block';
    labelMsgCart.style.display='inline-block';
    
    mailCart.style.display='inline-block';
    mailCart.value="<?php echo (isset($_POST['email'])?$_POST['email']:''); ?>";
    labelMailCart.style.display='inline-block';
    
    firstnameCart.style.display='inline-block';
    firstnameCart.value="<?php echo (isset($_POST['firstname'])?preg_replace('/\"/','\\\"',$_POST['firstname']):''); ?>";
    labelFirstnameCart.style.display='inline-block';
    
    lastnameCart.style.display='inline-block';
    lastnameCart.value="<?php echo (isset($_POST['lastname'])?preg_replace('/\"/','\\\"',$_POST['lastname']):''); ?>";
    labelLastnameCart.style.display='inline-block';
    
    adressCart.style.display='inline-block';
    adressCart.value="<?php echo (isset($_POST['adress'])?preg_replace('/\"/','\\\"',$_POST['adress']):''); ?>";
    labelAddrCart.style.display='inline-block';
    
    postcodeCart.style.display='inline-block';
    postcodeCart.value="<?php echo (isset($_POST['postcode'])?preg_replace('/\"/','\\\"',$_POST['postcode']):''); ?>";
    labelPostcodeCart.style.display='inline-block';
    
    cityCart.style.display='inline-block';
    cityCart.value="<?php echo (isset($_POST['city'])?preg_replace('/\"/','\\\"',$_POST['city']):''); ?>";
    labelCityCart.style.display='inline-block';
    
    countryCart.style.display='inline-block';
    countryCart.value="<?php echo (isset($_POST['country'])?preg_replace('/\"/','\\\"',$_POST['country']):''); ?>";
    labelCountryCart.style.display='inline-block';
    
    telCart.style.display='inline-block';
    telCart.value="<?php echo (isset($_POST['tel'])?preg_replace('/\"/','\\\"',$_POST['tel']):''); ?>";
    labelTelCart.style.display='inline-block';
    
    idSuite.value="<?php echo (isset($_SESSION['ncart'])?$_SESSION['ncart']:''); ?>";
    numCart.value="<?php echo (isset($_SESSION['ncart'])?$_SESSION['ncart']:''); ?>";
    nprod=<?php echo (isset($_SESSION['ncart'])?(int)$_SESSION['ncart']:0); ?>;
    realnprod=<?php echo (isset($_SESSION['ncart'])?(int)$_SESSION['ncart']:0); ?>;
    notiNumShoppingCart.innerHTML=realnprod;
    tmpship=<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>;
    total=<?php echo (isset($totalpricettc)?$totalpricettc:0.00); ?>;
    if (total >0) displayTotal=(total+<?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>);
    else displayTotal=0;
    
    totalCart.innerHTML="Total&nbsp;: "+displayTotal.toFixed(2)+"&nbsp;&euro;";
    spanshipping.innerHTML="<p class='spanshippingp'>Frais de port&nbsp;: <?php echo (isset($totalpoidgshipping)?$totalpoidgshipping:0.00); ?>&nbsp;&euro; pour <?php echo $totalpoidg; ?>&nbsp;kg</p>";
    totalcommand.value=total;
}
<?php 
} else if (isset($_SESSION['prods']) && !is_array($_SESSION['prods'])) {
    unset($_SESSION['prods']);
}
?>
function changePaymentMethod(method) {
    if (method=="cheque")formCart.action="#panier";
    else if (method=="paypal") formCart.action="#panier";
}

function shippingMethod(kg, op){
    if (op==1)totalkg=(parseFloat(totalkg.toFixed(3))+parseFloat(kg.toFixed(3)));
    if (op==0)totalkg=(parseFloat(totalkg.toFixed(3))-parseFloat(kg.toFixed(3)));
    accurecept=<?php echo (float)$plxPlugin->getParam('acurecept'); ?>;
    if (totalkg.toFixed(3)<=0.000) {
        shippingPrice=0.00;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p01'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv01'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p02'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv02'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p03'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv03'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p04'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv04'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p05'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv05'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p06'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv06'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p07'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv07'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p08'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv08'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p09'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv09'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p10'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv10'); ?>+accurecept;
    } else if (totalkg.toFixed(3)<=<?php echo (float)$plxPlugin->getParam('p11'); ?>) {
        shippingPrice=<?php echo (float)$plxPlugin->getParam('pv11'); ?>+accurecept;
    }
    return shippingPrice;
}

function addCart(product, price, realprice, kg, id){
    if (shoppingCart.innerHTML=="<em>Aucun produit pour le moment.</em>") {
        shoppingCart.innerHTML='';
    }
    msgAddCart.style.display="none";
    shoppingCart.innerHTML=shoppingCart.innerHTML+'<span id="p'+nprod+'"><br>-&nbsp;'+product+'&nbsp;&nbsp;&nbsp;&nbsp;'+price+'&nbsp;&nbsp;&nbsp;&nbsp;'+'<button onclick="removeCart(\'p'+nprod+'\', '+realprice+', '+kg+', \''+id+'\');" id="delp'+nprod+'">Supprimer</button></span>';
    PRODS.value=PRODS.value+'<span id="p'+nprod+'">-&nbsp;'+product+'&nbsp;&nbsp;&nbsp;&nbsp;'+price+'</span><br>';
    btnCart.style.display='inline-block';
    msgCart.style.display='inline-block';
    labelMsgCart.style.display='inline-block';
    
    mailCart.style.display='inline-block';
    labelMailCart.style.display='inline-block';
    firstnameCart.style.display='inline-block';
    labelFirstnameCart.style.display='inline-block';
    lastnameCart.style.display='inline-block';
    labelLastnameCart.style.display='inline-block';
    
    adressCart.style.display='inline-block';
    labelAddrCart.style.display='inline-block';
    postcodeCart.style.display='inline-block';
    labelPostcodeCart.style.display='inline-block';
    cityCart.style.display='inline-block';
    labelCityCart.style.display='inline-block';
    countryCart.style.display='inline-block';
    labelCountryCart.style.display='inline-block';
    
    telCart.style.display='inline-block';
    labelTelCart.style.display='inline-block';
    
    nprod++;
    idSuite.value=nprod;
    realnprod++;
    notiNumShoppingCart.innerHTML=realnprod;
    numCart.value=realnprod;
    
    total=(total+realprice);
    tmpship=shippingMethod(kg, 1);
    displayTotal=(total+tmpship);
    totalCart.innerHTML="Total (frais de port inclus)&nbsp;: "+displayTotal.toFixed(2)+"&nbsp;&euro;";
    totalcommand.value=total.toFixed(2);
    shipping.value=tmpship.toFixed(2);
    shipping_kg.value=totalkg.toFixed(2);
    if (totalkg>0) spanshipping.innerHTML="<p class='spanshippingp'>Frais de port&nbsp;: "+tmpship.toFixed(2)+"&nbsp;&euro; pour "+totalkg.toFixed(2)+"&nbsp;kg</p>";
    else spanshipping.innerHTML="";
    msgAddCart.style.display="block";
    setTimeout(function() {
        msgAddCart.style.display="none";
    },
    3000);
    sendWithAjaxE4(
            '<?php echo PLX_PLUGINS; ?>plxMyShop/ajax/add_product.php',
            'POST',
            'eval(xh.responseText);',
            null,
            'pid='+id
    );
}
function removeCart(obj, realprice, kg, id){
    var product=document.getElementById(obj);
    product.parentNode.removeChild(product);
    PRODS.value=shoppingCart.innerHTML;
    if (shoppingCart.innerHTML=='') {
        shoppingCart.innerHTML="<em>Aucun produit pour le moment.</em>";
        nprod=0;
        btnCart.style.display='none';
        msgCart.style.display='none';
        labelMsgCart.style.display='none';
        
        mailCart.style.display='none';
        labelMailCart.style.display='none';
        firstnameCart.style.display='none';
        labelFirstnameCart.style.display='none';
        lastnameCart.style.display='none';
        labelLastnameCart.style.display='none';
    
        adressCart.style.display='none';
        labelAddrCart.style.display='none';
        postcodeCart.style.display='none';
        labelPostcodeCart.style.display='none';
        cityCart.style.display='none';
        labelCityCart.style.display='none';
        countryCart.style.display='none';
        labelCountryCart.style.display='none';
    
        telCart.style.display='none';
        labelTelCart.style.display='none';
        sendWithAjaxE4(
            '<?php echo PLX_PLUGINS; ?>plxMyShop/ajax/del_product.php',
            'POST',
            'eval(xh.responseText);',
            null,
            'killcartsession='+id
        );
    } 
    total=(total-realprice);
    tmpship=shippingMethod(kg, 0);
    if (total >0) displayTotal=(total+tmpship);
    else displayTotal=0;
    totalCart.innerHTML="Total : "+displayTotal.toFixed(2)+"&euro;";
    totalcommand.value=total.toFixed(2);
    shipping.value=tmpship.toFixed(2);
    shipping_kg.value=totalkg.toFixed(2);
    if (totalkg>0) spanshipping.innerHTML="<p class='spanshippingp'>Frais de port&nbsp;: "+tmpship.toFixed(2)+"&nbsp;&euro; pour "+totalkg.toFixed(2)+"&nbsp;kg</p>";
    else spanshipping.innerHTML="";
    
    realnprod--;
    notiNumShoppingCart.innerHTML=realnprod;
    numCart.value=realnprod;
    sendWithAjaxE4(
            '<?php echo PLX_PLUGINS; ?>plxMyShop/ajax/del_product.php',
            'POST',
            'eval(xh.responseText);',
            null,
            'pid='+id
    );
}
</script>
