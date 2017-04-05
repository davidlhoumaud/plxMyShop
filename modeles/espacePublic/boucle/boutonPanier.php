<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
$plxPlugin = $d["plxPlugin"];
$plxPlugin->traitementAjoutPanier();

$prodsPnr = 1;
$txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET'));
$classPnrBtn = "blue";

if (isset($_SESSION["plxMyShop"]["prods"][$d["k"]])) {
 if ($_SESSION["plxMyShop"]["prods"][$d["k"]]<1) {
  $_SESSION["plxMyShop"]["ncart"] -= $_SESSION["plxMyShop"]["prods"][$d["k"]];
  unset($_SESSION["plxMyShop"]["prods"][$d["k"]]);
 }else{
  $prodsPnr = $_SESSION["plxMyShop"]["prods"][$d["k"]];
  $txtPnrBtn = htmlspecialchars($plxPlugin->getLang('L_PUBLIC_DEL_BASKET'));
  $classPnrBtn = "red";
 }
}

$dansShortcode = (count($d["pileModeles"]) === 1);
?>
<form method="POST" class="formulaireAjoutProduit" id="FormAddProd<?php echo $d["k"]; ?>" onsubmit="chngBB<?php echo $d["k"]; ?>(true);">
 <input type="hidden" name="idP" value="<?php echo htmlspecialchars($d["k"]);?>">
 <?php if ($dansShortcode) {?>
  <input type="hidden" name="nb" value="<?php echo $prodsPnr; ?>" min="1">
 <?php } else {?>
  <input type="number" name="nb" value="<?php echo $prodsPnr; ?>" min="1" id="nbProd<?php echo $d["k"]; ?>" onchange="chngBB<?php echo $d["k"]; ?>(false);" data-o="<?php echo $prodsPnr; ?>">
 <?php }?>
 <input class="<?php echo $classPnrBtn; ?>" type="submit" id="addProd<?php echo $d["k"]; ?>" name="ajouterProduit" value="<?php echo $txtPnrBtn; ?>">
</form>
<script type="text/javascript">
 function chngBB<?php echo $d["k"]; ?>(sbmt){
  var btn = document.getElementById("addProd<?php echo $d["k"]; ?>");
  var nb = document.getElementById("nbProd<?php echo $d["k"]; ?>");
  if(btn.value != '<?php echo htmlspecialchars($plxPlugin->getLang('L_PUBLIC_ADD_BASKET')); ?>'){
   if(nb.getAttribute("data-o") == nb.value){
    if(sbmt){//delete
     nb.value="0";
    }
    btn.value = '<?php echo htmlspecialchars($plxPlugin->getLang('L_PUBLIC_DEL_BASKET')); ?>';
    btn.setAttribute("class", "red");
   }else{
    btn.value = '<?php echo htmlspecialchars($plxPlugin->getLang('L_PUBLIC_MOD_BASKET')); ?>';
    btn.setAttribute("class", "orange");
   }
  }
 }
</script>