<?php

/**
 * Edition du code source d'un produit
 *
 * @package PLX
 * @author David L
 **/

# On édite le produit
if(!empty($_POST) AND isset($plxPlugin->aProds[$_POST['id']])) {
 $plxPlugin->editProduct($_POST);
 header('Location: plugin.php?p=plxMyShop&amp;prod='.$_POST['id']);
 exit;
} elseif(!empty($_GET['prod'])) { # On affiche le contenu de la page
 $id = plxUtils::strCheck(plxUtils::nullbyteRemove($_GET['prod']));
 if(!isset($plxPlugin->aProds[ $id ])) {
  plxMsg::Error(L_PRODUCT_UNKNOWN_PAGE);
  header('Location: plugin.php?p=plxMyShop');
  exit;
 }
 # On récupère le contenu
 $content = trim($plxPlugin->getFileProduct($id));
 $image = $plxPlugin->aProds[$id]['image'];
 $pricettc = $plxPlugin->aProds[$id]['pricettc'];
 $pcat = $plxPlugin->aProds[$id]['pcat'];
 $poidg = $plxPlugin->aProds[$id]['poidg'];
 $title = $plxPlugin->aProds[$id]['name'];
 $url = $plxPlugin->aProds[$id]['url'];
 $active = $plxPlugin->aProds[$id]['active'];
 $noaddcart = $plxPlugin->aProds[$id]['noaddcart'];
 $notice_noaddcart = $plxPlugin->aProds[$id]['notice_noaddcart'];
 $title_htmltag = $plxPlugin->aProds[$id]['title_htmltag'];
 $meta_description = $plxPlugin->aProds[$id]['meta_description'];
 $meta_keywords = $plxPlugin->aProds[$id]['meta_keywords'];
 $template = $plxPlugin->aProds[$id]['template'];
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

# On inclut le header
//include(dirname(__FILE__).'/top.php');

$modProduit = ("1" !== $pcat);


if (!isset($_SESSION)) {
 session_start();
}

$_SESSION["plxMyShop"]["cheminImages"] = realpath(PLX_ROOT . $plxPlugin->cheminImages);
$_SESSION["plxMyShop"]["urlImages"] = $plxAdmin->urlRewrite($plxPlugin->cheminImages);

$cssAdmn = PLX_PLUGINS.get_class($plxPlugin).'/css/administration.css';
?>
<script type="text/javascript">
 var s = document.createElement("link"); s.href = "<?php echo $cssAdmn;?>"; s.async = true; s.rel = "stylesheet"; s.type = "text/css"; s.media = "screen";;
 var mx = document.getElementsByTagName('link'); mx = mx[mx.length-1]; mx.parentNode.insertBefore(s, mx.nextSibling);
</script>
<noscript><link rel="stylesheet" type="text/css" href="<?php echo $cssAdmn;?>" /></noscript>

<script type='text/javascript' src='<?php echo PLX_PLUGINS;?>plxMyShop/js/libajax.js'></script>
<p class="in-action-bar return-link plx<?php echo str_replace('.','-',@PLX_VERSION); echo defined('PLX_MYMULTILINGUE')?' multilingue':'';?>">
 <a href="plugin.php?p=plxMyShop<?php echo ($modProduit ? '' : '&mod=cat');?>"><?php
  echo $plxPlugin->lang($modProduit ? 'L_PRODUCT_BACK_TO_PAGE' : 'L_CAT_BACK_TO_PAGE');
?></a>
</p>

<h3 id="pmsTitle" class="page-title">
 <?php $plxPlugin->lang($modProduit ? 'L_PRODUCT_TITLE' : 'L_CAT_TITLE');?>
 &laquo;<?php echo plxUtils::strCheck($title);?>&raquo;
</h3>
<script type="text/javascript">//surcharge du titre dans l'admin
 var title = document.getElementById('pmsTitle');
 title.className += " hide";
 document.getElementsByClassName('inline-form')[0].firstChild.nextSibling.innerHTML = 'plxMyShop - '+title.innerHTML;
</script>
<script type='text/javascript' src='<?php echo PLX_PLUGINS.get_class($plxPlugin); ?>/js/libajax.js'></script>
<noscript><p class="warning">Oups! No JS</p></noscript>
<?php eval($plxAdmin->plxPlugins->callHook('AdminProductTop'));?>

<form action="plugin.php?p=plxMyShop" method="post" id="form_article">
 <fieldset>
  <?php plxUtils::printInput('prod', $_GET['prod'], 'hidden');?>
  <?php plxUtils::printInput('id', $id, 'hidden');?>
  <div class="informationsShortcodeProduit">
   <?php $plxPlugin->lang('L_PRODUCTS_SHORTCODE'); ?>&nbsp;:<br/>
   <span class="code">[<?php echo $plxPlugin->shortcode;?> <?php echo $id;?>]</span>
  </div>

  <!-- Utilisation du selecteur d'image natif à PluXml -->
  <script>
  function refreshImg(dta) {
   if(dta.trim()==='') {
    document.getElementById('id_image_img').innerHTML = '';
   } else {
    var link = dta.match(/^(https?:\/\/[^\s]+)/gi) ? dta : '<?php echo $plxAdmin->racine ?>'+dta;
    document.getElementById('id_image_img').innerHTML = '<img src="'+link+'" alt="" />';
   }
  }
  </script>
  <fieldset>
   <p class="field"><label><?php $plxPlugin->lang('L_PRODUCTS_IMAGE_CHOICE') ?> <a title="<?php echo L_THUMBNAIL_SELECTION ?>" id="toggler_thumbnail" href="javascript:void(0)" onclick="mediasManager.openPopup('id_image', true)" style="outline:none; text-decoration: none"> +</a></label>
   <?php plxUtils::printInput('image',plxUtils::strCheck($image),'text','140-255',false,'','','onkeyup="refreshImg(this.value)"'); ?>
   </p>
  </fieldset>
<?php
  $imgUrl = PLX_ROOT.$plxPlugin->cheminImages.$image;
  if(is_file($imgUrl)) {
   echo '<div id="id_image_img"><img src="'.$imgUrl.'" alt="" /></div>';
  }
  else {
   echo '<div id="id_image_img"></div>';
  }
?>
<!-- Fin du selecteur d'image natif de PluXml -->

  <p id="p_content"><label for="id_content"><?php echo L_CONTENT_FIELD ?>&nbsp;:</label></p>
  <?php plxUtils::printArea('content', plxUtils::strCheck($content),140,30); ?>

<?php
  if($active) : 
   $link = $plxAdmin->urlRewrite('index.php?product'.intval($id).'/'.$url);
   $codeTexte = $modProduit ? 'L_PRODUCT_VIEW_PAGE_ON_SITE' : 'L_CAT_VIEW_PAGE_ON_SITE';
   $texte = sprintf($plxPlugin->getLang($codeTexte), $title);
?>
   <p><a href="<?php echo $link;?>"><?php echo plxUtils::strCheck($texte);?></a></p>
  <?php endif; ?>

  <?php if ($modProduit): ?>
   <p><label for="id_pricettc"><?php $plxPlugin->lang('L_PRODUCTS_PRICE') ;?> (<?php echo $plxPlugin->getParam("devise");?>) &nbsp;:</label></p>
   <?php plxUtils::printInput('pricettc',plxUtils::strCheck($pricettc),'text','50-255'); ?>
   <p><label for="id_poidg"><?php $plxPlugin->lang('L_PRODUCTS_WEIGHT') ;?>&nbsp;:</label></p>
   <?php plxUtils::printInput('poidg',plxUtils::strCheck($poidg),'text','50-255'); ?>
   <p><label for="id_noaddcart"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_BUTTON') ;?>&nbsp;:</label></p>
   <?php plxUtils::printSelect('noaddcart', array('1'=>L_YES,'0'=>L_NO), plxUtils::strCheck($noaddcart)); ?>
   <p><label for="id_notice_noaddcart"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_NO_BUTTON') ;?>&nbsp;:</label></p>
   <?php plxUtils::printInput('notice_noaddcart',plxUtils::strCheck($notice_noaddcart),'text','50-255'); ?>
   <hr/>
   <?php $plxPlugin->lang('L_PRODUCTS_CATEGORIES');?>&nbsp;:<br/>
   <?php $listeCategories = explode(",", $plxPlugin->aProds[$id]["group"]);?>
   <?php foreach ($plxPlugin->aProds as $idCategorie => $p) {?>
    <?php 
     if ("1" !== $p["pcat"]) {
      continue;
     }
    ?>
    <label for="categorie_<?php echo $idCategorie;?>">
     <input type="checkbox"
       name="listeCategories[]"
       value="<?php echo $idCategorie;?>"
       id="categorie_<?php echo $idCategorie;?>"
       <?php echo (!in_array($idCategorie, $listeCategories)) 
       ? "" : " checked=\"checked\"";?>
      />
     <?php echo plxUtils::strCheck($p["name"]); ?>
    </label>
    <br/>
   <?php } ?>
   <hr/>
  <?php else: ?>
   <?php plxUtils::printInput('pricettc',plxUtils::strCheck($pricettc),'hidden','50-255');?>
   <?php plxUtils::printInput('poidg',plxUtils::strCheck($poidg),'hidden','50-255');?>
   <?php plxUtils::printInput('noaddcart', plxUtils::strCheck($noaddcart),'hidden','50-255');?>
   <?php plxUtils::printInput('notice_noaddcart',plxUtils::strCheck($notice_noaddcart),'hidden','50-255');?>
  <?php endif; ?>
  <p>
   <label for="id_template">
    <?php $plxPlugin->lang('L_PRODUCTS_TEMPLATE_FIELD');?>&nbsp;:
   </label>
  </p>
  <?php plxUtils::printSelect('template', $aTemplates, $template);?>
  <p>
   <label for="id_title_htmltag">
    <?php $plxPlugin->lang('L_PRODUCT_TITLE_HTMLTAG');?>&nbsp;:
   </label>
  </p>
  <?php plxUtils::printInput('title_htmltag',plxUtils::strCheck($title_htmltag),'text','50-255');?>
  <p>
   <label for="id_meta_description">
    <?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_DESCRIPTION':'L_CAT_META_DESCRIPTION');?>&nbsp;:
   </label>
  </p>
  <?php plxUtils::printInput('meta_description',plxUtils::strCheck($meta_description),'text','50-255'); ?>
  <p>
   <label for="id_meta_keywords">
    <?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_KEYWORDS':'L_CAT_META_KEYWORDS');?>&nbsp;:
   </label>
  </p>
  <?php plxUtils::printInput('meta_keywords',plxUtils::strCheck($meta_keywords),'text','50-255');?>
 </fieldset>
 <p class="in-action-bar plx<?php echo str_replace('.','-',@PLX_VERSION); echo defined('PLX_MYMULTILINGUE')?' multilingue':'';?>">
  <?php echo plxToken::getTokenPostMethod() ?>
  <input type="submit" value="<?php $plxPlugin->lang($modProduit?'L_PRODUCT_UPDATE':'L_CAT_UPDATE');?>"/>
 </p>
</form>