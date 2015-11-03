

jQuery(function ($) {
	
	afficherConteneurNomCadeau($);
	
	$("#choixCadeau").click(function () {afficherConteneurNomCadeau($);});
	
});

function afficherConteneurNomCadeau($) {
	
	var conteneurNomCadeau = $(".conteneurNomCadeau");
	
	if ($("#choixCadeau").prop("checked")) {
		conteneurNomCadeau.show();
	} else {
		conteneurNomCadeau.hide();
	}
	
}


function addCart(product, price, realprice, kg, id) {
    sendWithAjaxE4(
            repertoireAjax + 'add_product.php',
            'POST',
            'eval(xh.responseText);',
            null,
            'pid='+id
    );
    
	msgAddCart.style.display="block";
	
    setTimeout(function() {
        msgAddCart.style.display="none";
    },
    3000);

	if (null === shoppingCart) {
		return;
	}
	
    if (shoppingCart.innerHTML=="<em>Aucun produit pour le moment</em>") {
        shoppingCart.innerHTML='';
    }
	
    shoppingCart.innerHTML=shoppingCart.innerHTML+'<span id="p'+nprod+'"><br>-&nbsp;'+product+'&nbsp;&nbsp;&nbsp;&nbsp;'+price+'&nbsp;&nbsp;&nbsp;&nbsp;'+'<button onclick="return removeCart(\'p'+nprod+'\', '+realprice+', '+kg+', \''+id+'\');" id="delp'+nprod+'">'+L_DEL+'</button></span>';
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
    formcart.style.display='inline-block';
    
    nprod++;
    idSuite.value=nprod;
    realnprod++;
    numCart.value=realnprod;

    total = parseFloat(total) + parseFloat(realprice);
    tmpship=shippingMethod(kg, 1);
	displayTotal=(total+tmpship);
    totalCart.innerHTML=L_TOTAL +"&nbsp;: "+displayTotal.toFixed(2)+"&nbsp;" + devise + "";
    totalcommand.value=total.toFixed(2);
    shipping.value=tmpship.toFixed(2);
    shipping_kg.value=totalkg.toFixed(2);
    if (totalkg>0) spanshipping.innerHTML="<p class='spanshippingp'>Frais de port&nbsp;: "+tmpship.toFixed(2)+"&nbsp;" + devise + " pour "+totalkg.toFixed(2)+"&nbsp;kg</p>";
    else spanshipping.innerHTML="";
}

function removeCart(obj, realprice, kg, id) {
    sendWithAjaxE4(
            repertoireAjax + 'del_product.php',
            'POST',
            'eval(xh.responseText);',
            null,
            'pid='+id
    );
	
    var product=document.getElementById(obj);
    product.parentNode.removeChild(product);
    PRODS.value=shoppingCart.innerHTML;
    if (shoppingCart.innerHTML=='') {
        shoppingCart.innerHTML="<em>Aucun produit pour le moment</em>";
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
		
		formcart.style.display='none';
		
        sendWithAjaxE4(
            repertoireAjax + 'del_product.php',
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
    totalCart.innerHTML="Total&nbsp;: "+displayTotal.toFixed(2)+"&nbsp;" + devise + "";
    totalcommand.value=total.toFixed(2);
    shipping.value=tmpship.toFixed(2);
    shipping_kg.value=totalkg.toFixed(2);
    if (totalkg>0) spanshipping.innerHTML="<p class='spanshippingp'>Frais de port&nbsp;: "+tmpship.toFixed(2)+"&nbsp;" + devise + " pour "+totalkg.toFixed(2)+"&nbsp;kg</p>";
    else spanshipping.innerHTML="";
    
    realnprod--;
    numCart.value=realnprod;

	return false;
}
