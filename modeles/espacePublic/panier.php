<a id="panier"></a>
<div align="center" class="panierbloc">
	<div align="center" id="listproducts">
		<section align="center" class="productsect">
			<header >
				Votre panier&nbsp;&nbsp;&nbsp;&nbsp;<span id='totalCart'>Total : 0.00&euro;</span><span id="spanshipping"></span>
			<?php if (isset($_SESSION['msgCommand']) && !empty($_SESSION['msgCommand']) && $_SESSION['msgCommand']!=""){
					echo $_SESSION['msgCommand'];
					$_SESSION['msgCommand']="";
					unset($_SESSION['msgCommand']);
			 }?>
			</header>
			<form id="formcart" method="POST" action="#panier">
				<div id="shoppingCart" ><em>Aucun produit pour le moment.</em></div>
				<p ><strong id="labelFirstnameCart"><span class='startw'>* = champs obligatoire</span> <br>
				<br>Prénom<span class='star'>*</span> :</strong> <input  type="text" name="firstname" id="firstname" value=""><strong id="labelLastnameCart">&nbsp;et Nom<span class='star'>*</span> :</strong> <input type="text" name="lastname"  id="lastname" value=""></p>
				<p ><strong id="labelMailCart">Votre email<span class='star'>*</span> :</strong> <input type="email" name="email"  id="email" value=""></p>
				<p ><strong id="labelTelCart">Tel :</strong> <input type="text" name="tel" id="tel" value=""></p>
				<p ><strong id="labelAddrCart">Addresse<span class='star'>*</span> :</strong> <input type="text" name="adress" id="adress" value=""></p>
				<p ><strong id="labelPostcodeCart" >Code postal<span class='star'>*</span> :</strong> <input  type="text" name="postcode" id="postcode" value=""><strong id="labelCityCart"> Ville :</strong> <input type="text" name="city" id="city" value=""></p>
				<p ><strong id="labelCountryCart" >Pays<span class='star'>*</span> :</strong> <input type="text" name="country" id="country" value=""></p>
				<strong id="labelMsgCart">Votre commentaire :</strong><br><textarea name="msg" id="msgCart"  rows="3"></textarea><br>
				<textarea name="prods" id="prodsCart" rows="3"></textarea>
				<input type="hidden" name="total" id="totalcommand" value="0">
				<input type="hidden" name="shipping" id="shipping" value="0">
				<input type="hidden" name="shipping_kg" id="shipping_kg" value="0">
				<input type="hidden" name="idsuite" id="idsuite" value="0">
				<input type="hidden" name="numcart" id="numcart" value="0">
				<strong>Méthode de paiement&nbsp;:&nbsp;&nbsp;</strong><select onchange="changePaymentMethod(this.value);" name="methodpayment">
					<?php foreach ($d["tabChoixMethodespaiement"] as $codeM => $m) {?>
						<option value="<?php echo htmlspecialchars($codeM);?>">
							<?php echo htmlspecialchars($m["libelle"]);?>
						</option>
					<?php }?>
				</select><br>
				<input type="submit"  id="btnCart" value="Validez la commande" ><br>
			</form>
		</section>
	</div>
</div>
<div id="msgAddCart">&darr; Produit ajouté au panier &darr;</div>
