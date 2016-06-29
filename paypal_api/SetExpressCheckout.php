<?php 
if (isset($_POST) && !empty($_POST) && is_array($_POST)) {
/**
* Send HTTP POST Request
* @param    string    The POST Message fields in &name=value pair format
* @param    string    The URL of the API endpoint
* @return    array    Parsed HTTP Response body
**/
function PaypalHTTPPost($p_nvpStr, $p_API_Endpoint) {
    //Create a new cURL resource
    $ch = curl_init();
                
    //Set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $p_API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
                
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);    

    //setting the nvp request as POST FIELD to curl
    curl_setopt($ch, CURLOPT_POSTFIELDS, $p_nvpStr);
            
    //Grap URL and pass it to the browser
    $response = curl_exec($ch);
                
    if(!$response) {
        exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
    }
                
    // Extract the response details.
    $httpResponseAr = explode("&", $response);
    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $i => $value) {
        $tmpAr = explode("=", $value);
        if(sizeof($tmpAr) > 1) {
            $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
        }
    }
    if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
        exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    }
                
    return $httpParsedResponseAr;
}

$SandboxFlag        =   ($plxPlugin->getParam('payment_paypal_test')=='1'?"True":"False"); # True for test mode else False
$PAYMENTACTION      =   "Sale"; # Sale, Order or Authorization
$CURRENCYCODE       =   $plxPlugin->getParam('payment_paypal_currencycode');
$BRANDNAME          =   $plxPlugin->getParam('shop_name');
$OVERALLDESCRIPTION =   $plxPlugin->getParam('payment_paypal_overalldescription');
#URL
$RETURNURL          =  $plxPlugin->getParam('payment_paypal_returnurl');
$CANCELURL          =  $plxPlugin->getParam('payment_paypal_cancelurl');
$IPNURL             =  $plxPlugin->getParam('payment_paypal_ipnurl');
#style
$PAYFLOWCOLOR       =   $plxPlugin->getParam('payment_paypal_payflowcolor');
$CARTBORDERCOLOR    =   $plxPlugin->getParam('payment_paypal_cartbordercolor');
$LOGOIMG            =   $plxPlugin->getParam('payment_paypal_logoimg'); #https:// de préférence
if ($SandboxFlag=="True") { #for test
    #ID
    $USER               =   $plxPlugin->getParam('payment_paypal_test_user');
    $PWD                =   $plxPlugin->getParam('payment_paypal_test_pwd');
    $SIGNATURE          =  $plxPlugin->getParam('payment_paypal_test_signature');
    $API_ENDPOINT       =   "https://api-3t.sandbox.paypal.com/nvp";
    $PAYPAL_URL         =   "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=";
} else { #for production
    #ID
    $USER               =   $plxPlugin->getParam('payment_paypal_user');
    $PWD                =   $plxPlugin->getParam('payment_paypal_pwd');
    $SIGNATURE          =  $plxPlugin->getParam('payment_paypal_signature');
    $API_ENDPOINT       =   "https://api-3t.paypal.com/nvp";
    $PAYPAL_URL         =   "https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=";
}



       $msgCommand.= '<div style="width:100%;" align="center">
            <p><img style="margin-top:10%;" src="' . $plxPlugin->plxMotor->racine . PLX_PLUGINS . 'plxMyShop/images/paypal_logo.gif" border="0"/></p>
            <p><img style="margin-top:2%;" src="' . $plxPlugin->plxMotor->racine . PLX_PLUGINS . 'plxMyShop/images/icon_load.gif" border="0"/></p>
            <span style="color:#003366;font-size:12px">Transfert des informations vers Paypal en cours...</span>
        </div>';


            $METHOD="SetExpressCheckout";
            $VERSION="98";

            //Shipping information, optional
            $SHIPPINGNAME=urlencode($_POST['firstname'].' '.$_POST['lastname']);
            $SHIPPINGSTREET=urlencode($_POST['adress']);
            $SHIPPINGCITY=urlencode($_POST['city']);
            $SHIPPINGZIPCODE=urlencode($_POST['postcode']);
            $SHIPPINGCOUNTRYCODE=urlencode("FR");
            $SHIPTOPHONENUM=urlencode($_POST['tel']);
            $TOTALAMT=($totalpricettc+$totalpoidgshipping);
            
            //Built the string request
            $nvpreq="METHOD=" . $METHOD //required
                . "&VERSION=" . $VERSION  //required
                . "&PWD=" . $PWD  //required
                . "&USER=" . $USER  //required
                . "&PAYFLOWCOLOR=". $PAYFLOWCOLOR
                . "&CARTBORDERCOLOR=". $CARTBORDERCOLOR
                . "&LOGOIMG=". $LOGOIMG
                . "&SIGNATURE=" .$SIGNATURE  //required
                . "&RETURNURL=http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&paypal=return' //required
                . "&CANCELURL=http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&paypal=cancel' //required    
                . "&PAYMENTREQUEST_0_DESC=" . $OVERALLDESCRIPTION  //optional but best practices
                . "&PAYMENTREQUEST_0_PAYMENTACTION=" . $PAYMENTACTION ////Could be Sale, Authorization or order
                . "&ADDROVERRIDE=1"
                . "&PAYMENTREQUEST_0_AMT=" . $TOTALAMT //required = PAYMENTREQUEST_0_ITEMAMT + PAYMENTREQUEST_0_SHIPPINGAMT + PAYMENTREQUEST_0_TAXAMT + PAYMENTREQUEST_0_INURANCEAMT
                . "&BUYERUSERNAME="//$_POST['customer_id']
                . "&BUYERID="//$_POST['customer_id']
                . "&PAYMENTREQUEST_0_CUSTOM="  //optional but best practices
                . "&MAXAMT=" . $TOTALAMT  //For using the choice of shipping method
                . "&PAYMENTREQUEST_0_CURRENCYCODE=" . $CURRENCYCODE  //optional but best practices
                //Address information
                . "&PAYMENTREQUEST_0_SHIPTONAME=" . $SHIPPINGNAME
                . "&PAYMENTREQUEST_0_SHIPTOSTREET=" . $SHIPPINGSTREET
                . "&PAYMENTREQUEST_0_SHIPTOSTREET2="
                . "&PAYMENTREQUEST_0_SHIPTOCITY=" . $SHIPPINGCITY
                //. "&PAYMENTREQUEST_0_SHIPTOSTATE=" . $SHIPPINGSTATE
                . "&PAYMENTREQUEST_0_SHIPTOZIP=" . $SHIPPINGZIPCODE
                . "&PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE=" . $SHIPPINGCOUNTRYCODE
                . "&PAYMENTREQUEST_0_SHIPTOPHONENUM=" . $SHIPTOPHONENUM        
                . "&PAYMENTREQUEST_0_NOTIFYURL=".$IPNURL 
                . "&SOLUTIONTYPE=Sole"  //With sole, there is the option to pay by credit card
                . "&BRANDNAME=" . $BRANDNAME //Label that owerrides the business name
                ;

            $resultEC = array();
            $resultEC = PaypalHTTPPost($nvpreq, $API_ENDPOINT);
        // DEBUG 
        // TO SEE THE PAYPAL ANSWER UNCOMMENT THE CODE BELOW AND COMMENT THE LINE 167
/*            echo '<table align="center">';
            foreach ($resultEC as $i => $value) {
                if($i == 'TOKEN') {
                    $_SESSION['PP_TOKEN'] = $value;
                }
                echo '<tr><td>';
                echo urldecode($i);
                echo '</td><td>';
                echo urldecode($value);
                echo '</td></tr>';
            }
            echo '</table>';
*/
            foreach ($resultEC as $i => $value) {
                if($i == 'TOKEN') {
                    $TOKEN=urldecode($value);
                    //$_SESSION['TOKEN'] = urldecode($value);
                }
            }
            //var_dump($resultEC); exit;
            $msgCommand.= '<script type="text/javascript" language="javascript">setTimeout(function () {window.location.href="' . $PAYPAL_URL . $TOKEN . '&useraction=commit"},1000);</script>';
            //Go to PayPal website //COMMENT THIS LINE FOR DEBUG
            //when you add &useraction=commit, on the PayPal website, the button label is "Pay Now", withoud this value, the button is "Continue"
        ?>
<?php } ?>
