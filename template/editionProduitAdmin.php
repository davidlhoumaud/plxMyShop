<?php if (!defined('PLX_ROOT')) exit;

/**
 * Edition du code source d'un produit
 *
 * @package PLX
 * @author David L
 **/

# Liste des langues disponibles et prises en charge par le plugin
$aLangs = array($plxPlugin->default_lang);
$arts_shop_fields = array(
 'title_htmltag',
 'meta_description',
 'meta_keywords',
 'template',
 'image',
 'pricettc',
 'pcat',
 'poidg',
 'name',
 'url',
 'active',
 'noaddcart',
 'iteminstock',
 'notice_noaddcart',
 'title_htmltag',
 'meta_description',
 'meta_keywords',
 'template'
);
# Si le plugin plxMyMultiLingue est installé on filtre sur les langues utilisées
# On garde par défaut le fr si aucune langue sélectionnée dans plxMyMultiLingue
if($plxPlugin->aLangs) {
 $aLangs = $plxPlugin->aLangs;
}

# On édite le produit
if(!empty($_POST) AND isset($plxPlugin->aProds[$plxPlugin->default_lang][$_POST['id']])) {//a verifier si default_lang est ok
 $plxPlugin->editProduct($_POST);
 header('Location: plugin.php?p='.$plxPlugin->plugName.'&amp;prod='.$_POST['id']);
 exit;
} elseif(!empty($_GET['prod'])) { # On affiche le contenu de la page
 $id = plxUtils::strCheck(plxUtils::nullbyteRemove($_GET['prod']));
 if(!isset($plxPlugin->aProds[$plxPlugin->default_lang][ $id ])) {//a verifier si default_lang est ok
  plxMsg::Error(L_PRODUCT_UNKNOWN_PAGE);
  header('Location: plugin.php?p='.$plxPlugin->plugName);
  exit;
 }
 # On récupère le contenu
 foreach ($aLangs as $lang) {
  foreach ($arts_shop_fields as $shop_field){
   ${$shop_field}[$lang] = isset($plxPlugin->aProds[$lang][$id][$shop_field])?$plxPlugin->aProds[$lang][$id][$shop_field]:'';
  }
  $content[$lang] = trim($plxPlugin->getFileProduct($id,$lang));
 }
} else { # Sinon, on redirige
 header('Location: products.php');
 exit;
}
# On récupère les templates du produit
$files = plxGlob::getInstance(PLX_ROOT.$plxAdmin->aConf['racine_themes'].$plxAdmin->aConf['style']);
if ($array = $files->query('/^static(-[a-z0-9-_]+)?.php$/')) {
 foreach($array as $k=>$v)
  $aTemplates[$v] = $v;
}
$modProduit = ("1" !== $pcat[ $plxPlugin->default_lang ] );
if (!isset($_SESSION)) {// inutile?
 session_start();
}
$_SESSION[$plxPlugin->plugName]["cheminImages"] = realpath(PLX_ROOT . $plxPlugin->cheminImages);
$_SESSION[$plxPlugin->plugName]["urlImages"] = $plxAdmin->urlRewrite($plxPlugin->cheminImages);
$imgNoUrl = PLX_PLUGINS.$plxPlugin->plugName.'/images/none.png';
?>
<p class="in-action-bar return-link plx<?php echo str_replace('.','-',@PLX_VERSION); echo $plxPlugin->aLangs?' multilingue':'';?>">
 <a href="plugin.php?p=<?php echo $plxPlugin->plugName.($modProduit ? '' : '&mod=cat');?>"><?php
  echo $plxPlugin->lang($modProduit ? 'L_PRODUCT_BACK_TO_PAGE' : 'L_CAT_BACK_TO_PAGE');
?></a>
</p>

<h3 id="pmsTitle" class="page-title">
 <?php $plxPlugin->lang($modProduit ? 'L_PRODUCT_TITLE' : 'L_CAT_TITLE');?>
 &laquo;<?php echo $name[$plxPlugin->default_lang];?>&raquo;
</h3>
<script type="text/javascript">//surcharge du titre dans l'action bar
 var title = document.getElementById('pmsTitle');
 title.className += " hide";
 document.getElementsByClassName('inline-form')[0].firstChild.nextSibling.innerHTML = '<?php echo $plxPlugin->plugName; ?> - '+title.innerHTML;
</script>
<!-- Utilisation du selecteur d'image natif à PluXml -->
<script type="text/javascript">
 function refreshImg(id_img) {console.log(id_img);
  var dta = document.getElementById(id_img.replace('_img','')).value;
  if(dta.trim()==='') {
   document.getElementById(id_img).innerHTML = '<img src="<?php echo $imgNoUrl ?>" alt="" />';
  } else {//console.log(document.getElementById('id_image_img').innerHTML);
   var link = dta.match(/^(https?:\/\/[^\s]+)/gi) ? dta : '<?php echo $plxAdmin->racine ?>'+dta;
   document.getElementById(id_img).innerHTML = '<img src="'+link+'" alt="" />';
  }
 }

 function toggleNoaddcart(a,e){
  var b = document.getElementById('id_notice_noaddcart'+e);
  var c = document.getElementById('config_notice_noaddcart'+e);
  var d = document.getElementById('cartImg'+e);
  if(a==1){
   b.setAttribute("placeholder","<?php echo $plxPlugin->getLang('L_NOTICE_NOADDCART').' ('.$plxPlugin->getLang('L_BY_DEFAULT').')';?>");
   c.classList.remove("hide");
   d.src = "<?php echo PLX_PLUGINS.$plxPlugin->plugName.'/images/empty.png'; ?>";
  }else{
   b.removeAttribute("placeholder");c.classList.add("hide");
   d.src = "<?php echo PLX_PLUGINS.$plxPlugin->plugName.'/images/full.png'; ?>";
  }
 }
</script>
<div class="grid">
 <div class="col sml-12 med-6">
  <p class="informationsShortcodeProduit"><?php $plxPlugin->lang('L_PRODUCTS_SHORTCODE'); ?>&nbsp;:<br/>
  <span class="code">[<?php echo $plxPlugin->shortcode.'&nbsp;'.$id;?>]</span></p>
 </div>
</div>

<?php eval($plxAdmin->plxPlugins->callHook('AdminProductTop')); // hook plugin ?>
<form action="plugin.php?p=<?php echo $plxPlugin->plugName; ?>" method="post" id="form_article">
 <div class="grid" id="tabContainer">
  <fieldset class="col sml-12">
   <?php plxUtils::printInput('prod', $_GET['prod'], 'hidden');?>
   <?php plxUtils::printInput('id', $id, 'hidden');?>
<?php if($plxPlugin->aLangs){#ml ?>
   <div class="tabs">
    <ul class="col sml-12">
<!--
     <li id="tabHeader_main"><?php $plxPlugin->lang('L_MAIN') ?></li>
-->
<?php
     foreach($aLangs as $lang){
      echo '     <li id="tabHeader_'.$lang.'"'.($lang==$plxAdmin->aConf['default_lang']?' class="active"':'').($lang==$plxPlugin->default_lang?' data-default_lang title="'.$plxPlugin->getLang('L_PRODUCTS_WEIGHT').' & Stock"':'').'>'.strtoupper($lang).'</li>'.PHP_EOL;
     }
?>
    </ul>
   </div>
<?php }#fi ml ?>
   <div class="grid tabscontent">
<!--
    <div class="tabpage" id="tabpage_main"></div>
-->

<!-- Content en multilingue -->
<?php
foreach($aLangs as $lang) {
 $lng=($plxPlugin->aLangs)?'_'.$lang:'';
?>
   <div class="tabpage<?php echo(empty($lng) | $lang==$plxAdmin->aConf['default_lang'])?' active':'" style="display:none;'; ?>" id="tabpage<?php echo $lng ?>">
    <div class="grid gridthumb">
     <div class="col sml-12 med-5 label-centered"><p class="lang_helper">Admin:<?php echo $plxAdmin->aConf['default_lang'].' - plug:'.$plxPlugin->default_lang.' - Tab:'.$lang ?></p>
      <label for="id_image<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_IMAGE_CHOICE') ?> <a title="<?php echo L_THUMBNAIL_SELECTION ?>" id="toggler_thumbnail<?php echo $lng ?>" href="javascript:void(0)" onclick="mediasManager.openPopup('id_image<?php echo $lng ?>', true, 'id_image<?php echo $lng ?>')" style="outline:none; text-decoration: none"> +</a></label>
      <?php plxUtils::printInput('image'.$lng,plxUtils::strCheck($image[$lang]),'text','255-255',false,'full-width','','onKeyUp="refreshImg(\'id_image_img'.$lng.'\')"'); ?>
     </div>
     <div class="col sml-12 med-7">
      <div class="image_img" id="id_image<?php echo $lng ?>_img">
<?php
       $imgUrl = PLX_ROOT.$plxPlugin->cheminImages.$image[$lang];
       $imgUrl = is_file($imgUrl)?$imgUrl:$imgNoUrl;
?>
       <img src="<?php echo $imgUrl ?>" alt="" />
      </div>
     </div>
    </div>
  <!-- Fin du selecteur d'image natif de PluXml -->
<?php if ($modProduit){ ?>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_pricettc<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_PRICE') ;?> (<?php echo trim($plxPlugin->getParam("devise"));?>)&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('pricettc'.$lng,plxUtils::strCheck($pricettc[$lang]),'text','0-255'); ?>
      </div>
     </div>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_poidg<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_WEIGHT') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('poidg'.$lng,plxUtils::strCheck($poidg[$lang]),'text','0-255',($lang!=$plxPlugin->default_lang)); ?>
      </div>
      <div class="col sml-12 med-5 label-centered">
       <label for="id_iteminstock<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_ITEM_INSTOCK') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('iteminstock'.$lng,plxUtils::strCheck($iteminstock[$lang]),'text','0-255',($lang!=$plxPlugin->default_lang)); ?>
      </div>
     </div>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_noaddcart<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_BUTTON') ;?>&nbsp;:<?php echo '<img id="cartImg'.$lng.'" class="noaddcartImg" src="'.PLX_PLUGINS.$plxPlugin->plugName.'/images/'.(empty($noaddcart[$lang])?'full':'empty').'.png" />'; ?></label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printSelect('noaddcart'.$lng, array('1'=>L_YES,'0'=>L_NO), plxUtils::strCheck($noaddcart[$lang]), false,'" onChange="toggleNoaddcart(this.options[this.selectedIndex].value,\''.$lng.'\');'); ?>
       <?php if($lang==$plxPlugin->default_lang) {plxUtils::printInput('noaddcart4all','','checkbox'); echo '&nbsp;'.L_ALL.'?';} ?>
      </div>
     </div>
     <div class="grid<?php echo $noaddcart[$lang]?'':' hide'; ?>" id="config_notice_noaddcart<?php echo $lng ?>">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_notice_noaddcart<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_NO_BUTTON') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('notice_noaddcart'.$lng,plxUtils::strCheck($notice_noaddcart[$lang]),'text','0-255', false, 'notice_noaddcart'.($noaddcart[$lang]?'" placeholder="'.$plxPlugin->getLang('L_NOTICE_NOADDCART').' ('.$plxPlugin->getLang('L_BY_DEFAULT').')':'')); ?>
      </div>
     </div>
     <hr/>
     <?php $plxPlugin->lang('L_PRODUCTS_CATEGORIES');?>&nbsp;:<br/>
<?php
 $listeCategories = explode(",", $plxPlugin->aProds[$lang][$id]["group"]);
 foreach ($plxPlugin->aProds[$lang] as $idCategorie => $p) {
  if ("1" !== $p["pcat"]) {
   continue;
  }
?>
      <label for="categorie_<?php echo $idCategorie.$lng;?>">
       <input type="checkbox"
         name="listeCategories<?php echo $lng ?>[]"
         value="<?php echo $idCategorie;?>"
         id="categorie_<?php echo $idCategorie.$lng;?>"
         <?php echo (!in_array($idCategorie, $listeCategories)) 
         ? "" : " checked=\"checked\"";?>
        />
       <?php echo plxUtils::strCheck($p["name"]); ?>
      </label>
     <?php } ?>
     <hr/>
<?php } else { ?>
     <?php plxUtils::printInput('pricettc'.$lng,plxUtils::strCheck($pricettc[$lang]),'hidden','0-255');?>
     <?php plxUtils::printInput('poidg'.$lng,plxUtils::strCheck($poidg[$lang]),'hidden','50-255');?>
     <?php plxUtils::printInput('noaddcart'.$lng,plxUtils::strCheck($noaddcart[$lang]),'hidden','0-255');?>
     <?php plxUtils::printInput('iteminstock'.$lng,plxUtils::strCheck($iteminstock[$lang]),'hidden','50-255');?>
     <?php plxUtils::printInput('notice_noaddcart'.$lng,plxUtils::strCheck($notice_noaddcart[$lang]),'hidden','50-255');?>
<?php } ?>
    <div class="grid">
     <div class="col sml-12">
      <label for="id_content<?php echo $lng ?>"><?php echo L_CONTENT_FIELD ?>&nbsp;:</label>
       <?php plxUtils::printArea('content'.$lng,plxUtils::strCheck($content[$lang]),140,30);?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_template<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCTS_TEMPLATE_FIELD');?>&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printSelect('template'.$lng, $aTemplates, $template);?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_title_htmltag<?php echo $lng ?>"><?php $plxPlugin->lang('L_PRODUCT_TITLE_HTMLTAG');?>&nbsp;(<?php $plxPlugin->lang('L_OPTIONEL');?>)&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('title_htmltag'.$lng,plxUtils::strCheck($title_htmltag[$lang]),'text','0-255');?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_meta_description<?php echo $lng ?>"><?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_DESCRIPTION':'L_CAT_META_DESCRIPTION');?>&nbsp;(<?php $plxPlugin->lang('L_OPTIONEL');?>)&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('meta_description'.$lng,plxUtils::strCheck($meta_description[$lang]),'text','0-255'); ?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_meta_keywords<?php echo $lng ?>"><?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_KEYWORDS':'L_CAT_META_KEYWORDS');?>&nbsp;(<?php $plxPlugin->lang('L_OPTIONEL');?>)&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('meta_keywords'.$lng,plxUtils::strCheck($meta_keywords[$lang]),'text','0-255');?>
     </div>
    </div>
  <p class="in-action-bar plx<?php echo str_replace('.','-',@PLX_VERSION); echo $plxPlugin->aLangs?' multilingue':'';?>">
   <?php echo plxToken::getTokenPostMethod() ?>
   <input type="submit" value="<?php $plxPlugin->lang($modProduit?'L_PRODUCT_UPDATE':'L_CAT_UPDATE');?>"/>
<?php
    if($active){
     $link = $plxAdmin->urlRewrite('index.php?product'.intval($id).'/'.$url[$lang]);
     $codeTexte = $modProduit ? 'L_PRODUCT_VIEW_PAGE_ON_SITE' : 'L_CAT_VIEW_PAGE_ON_SITE';
     $texte = sprintf($plxPlugin->getLang($codeTexte), '<i class="myhide">'.plxUtils::strCheck($name[$lang]).'</i>');
?>
    <br class="med-hide" /><a href="<?php echo $link;?>"><?php echo $texte;?></a>
<?php } ?>
  </p>
   </div>
<?php } ?>
<!-- Fin du content en multilingue -->
  </div><!-- fi tabpage id:tabscontent -->

  </fieldset>
 </div><!-- fi tabContainer -->
</form>
<?php if($plxPlugin->aLangs){#ml ?>
<script type="text/javascript" src="<?php echo PLX_PLUGINS.$plxPlugin->plugName."/js/tabs.js" ?>"></script>
<?php } ?>
