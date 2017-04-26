<?php if (!defined('PLX_ROOT')) exit;

/**
 * Edition du code source d'un produit
 *
 * @package PLX
 * @author David L
 **/
 
# Liste des langues disponibles et prises en charge par le plugin
$aLangs = array($plxAdmin->aConf['default_lang']);

# Si le plugin plxMyMultiLingue est installé on filtre sur les langues utilisées
# On garde par défaut le fr si aucune langue sélectionnée dans plxMyMultiLingue
if(defined('PLX_MYMULTILINGUE')) {
 $langs = plxMyMultiLingue::_Langs();
 $multiLangs = empty($langs) ? array() : explode(',', $langs);
 $aLangs = $multiLangs;
}

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
 foreach ($aLangs as $lang) {
  $content[$lang] = trim($plxPlugin->getFileProduct($id,$lang));
 }
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

$modProduit = ("1" !== $pcat);

if (!isset($_SESSION)) {// inutile?
 session_start();
}
$_SESSION["plxMyShop"]["cheminImages"] = realpath(PLX_ROOT . $plxPlugin->cheminImages);
$_SESSION["plxMyShop"]["urlImages"] = $plxAdmin->urlRewrite($plxPlugin->cheminImages);

?>
<p class="in-action-bar return-link plx<?php echo str_replace('.','-',@PLX_VERSION); echo defined('PLX_MYMULTILINGUE')?' multilingue':'';?>">
 <a href="plugin.php?p=plxMyShop<?php echo ($modProduit ? '' : '&mod=cat');?>"><?php
  echo $plxPlugin->lang($modProduit ? 'L_PRODUCT_BACK_TO_PAGE' : 'L_CAT_BACK_TO_PAGE');
?></a>
</p>

<h3 id="pmsTitle" class="page-title">
 <?php $plxPlugin->lang($modProduit ? 'L_PRODUCT_TITLE' : 'L_CAT_TITLE');?>
 &laquo;<?php echo plxUtils::strCheck($title);?>&raquo;
</h3>
<script type="text/javascript">//surcharge du titre dans l'action bar
 var title = document.getElementById('pmsTitle');
 title.className += " hide";
 document.getElementsByClassName('inline-form')[0].firstChild.nextSibling.innerHTML = 'plxMyShop - '+title.innerHTML;
</script>

<?php eval($plxAdmin->plxPlugins->callHook('AdminProductTop')); // hook plugin ?>
<form action="plugin.php?p=plxMyShop" method="post" id="form_article">
 <div id="tabContainer">
  <fieldset>
   <?php plxUtils::printInput('prod', $_GET['prod'], 'hidden');?>
   <?php plxUtils::printInput('id', $id, 'hidden');?>
   <div class="informationsShortcodeProduit">
    <?php $plxPlugin->lang('L_PRODUCTS_SHORTCODE'); ?>&nbsp;:<br/>
    <span class="code">[<?php echo $plxPlugin->shortcode;?> <?php echo $id;?>]</span>
   </div>
   <div class="grid tabs">
    <ul>
     <li id="tabHeader_main"><?php $plxPlugin->lang('L_MAIN') ?></li>
<?php
     foreach($aLangs as $lang){
      echo '     <li id="tabHeader_'.$lang.'"><span class="myhide">'.L_CONTENT_FIELD.'</span> '.strtoupper($lang).'</li>'.PHP_EOL;
     }
?>
    </ul>
   </div>
   <div class="tabscontent">
    <div class="tabpage" id="tabpage_main">
    <!-- Utilisation du selecteur d'image natif à PluXml -->
    <script type="text/javascript">
    function refreshImg(dta) {
     if(dta.trim()==='') {
      document.getElementById('id_image_img').innerHTML = '';
     } else {
      var link = dta.match(/^(https?:\/\/[^\s]+)/gi) ? dta : '<?php echo $plxAdmin->racine ?>'+dta;
      document.getElementById('id_image_img').innerHTML = '<img src="'+link+'" alt="" />';
     }
    }
    </script>
    <div class="grid gridthumb">
     <div class="col sml-12 med-5 label-centered">
      <label><?php $plxPlugin->lang('L_PRODUCTS_IMAGE_CHOICE') ?> <a title="<?php echo L_THUMBNAIL_SELECTION ?>" id="toggler_thumbnail" href="javascript:void(0)" onclick="mediasManager.openPopup('id_thumbnail', true)" style="outline:none; text-decoration: none"> +</a></label>
      <?php plxUtils::printInput('image',plxUtils::strCheck($image),'text','255-255',false,'full-width','','onkeyup="refreshImg(this.value)"'); ?>
     </div>
     <div class="col sml-12 med-7">
<?php
    $imgUrl = PLX_ROOT.$plxPlugin->cheminImages.$image;
    if(is_file($imgUrl))
     echo '<div id="id_thumbnail_img"><img src="'.$imgUrl.'" alt="" /></div>';
?>
     </div>
    </div>
  <!-- Fin du selecteur d'image natif de PluXml -->

<?php
    if($active){ 
     $link = $plxAdmin->urlRewrite('index.php?product'.intval($id).'/'.$url);
     $codeTexte = $modProduit ? 'L_PRODUCT_VIEW_PAGE_ON_SITE' : 'L_CAT_VIEW_PAGE_ON_SITE';
     $texte = sprintf($plxPlugin->getLang($codeTexte), $title);
?>
     <div class="grid">
      <div class="col sml-12">
       <p><a href="<?php echo $link;?>"><?php echo plxUtils::strCheck($texte);?></a></p>
      </div>
     </div>
<?php }
    if ($modProduit){ ?>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_pricettc"><?php $plxPlugin->lang('L_PRODUCTS_PRICE') ;?> (<?php echo $plxPlugin->getParam("devise");?>) &nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('pricettc',plxUtils::strCheck($pricettc),'text','50-255'); ?>
      </div>
     </div>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_poidg"><?php $plxPlugin->lang('L_PRODUCTS_WEIGHT') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('poidg',plxUtils::strCheck($poidg),'text','50-255'); ?>
      </div>
     </div>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_noaddcart"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_BUTTON') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printSelect('noaddcart', array('1'=>L_YES,'0'=>L_NO), plxUtils::strCheck($noaddcart)); ?>
      </div>
     </div>
     <div class="grid">
      <div class="col sml-12 med-5 label-centered">
       <label for="id_notice_noaddcart"><?php $plxPlugin->lang('L_PRODUCTS_BASKET_NO_BUTTON') ;?>&nbsp;:</label>
      </div>
      <div class="col sml-12 med-7">
       <?php plxUtils::printInput('notice_noaddcart',plxUtils::strCheck($notice_noaddcart),'text','50-255'); ?>
      </div>
     </div>
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
     <?php } ?>
     <hr/>
<?php } else { ?>
     <?php plxUtils::printInput('pricettc',plxUtils::strCheck($pricettc),'hidden','50-255');?>
     <?php plxUtils::printInput('poidg',plxUtils::strCheck($poidg),'hidden','50-255');?>
     <?php plxUtils::printInput('noaddcart', plxUtils::strCheck($noaddcart),'hidden','50-255');?>
     <?php plxUtils::printInput('notice_noaddcart',plxUtils::strCheck($notice_noaddcart),'hidden','50-255');?>
<?php } ?>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_template"><?php $plxPlugin->lang('L_PRODUCTS_TEMPLATE_FIELD');?>&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printSelect('template', $aTemplates, $template);?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_title_htmltag"><?php $plxPlugin->lang('L_PRODUCT_TITLE_HTMLTAG');?>&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('title_htmltag',plxUtils::strCheck($title_htmltag),'text','50-255');?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_meta_description"><?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_DESCRIPTION':'L_CAT_META_DESCRIPTION');?>&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('meta_description',plxUtils::strCheck($meta_description),'text','50-255'); ?>
     </div>
    </div>
    <div class="grid">
     <div class="col sml-12 med-5 label-centered">
      <label for="id_meta_keywords"><?php $plxPlugin->lang($modProduit?'L_PRODUCT_META_KEYWORDS':'L_CAT_META_KEYWORDS');?>&nbsp;:</label>
     </div>
     <div class="col sml-12 med-7">
      <?php plxUtils::printInput('meta_keywords',plxUtils::strCheck($meta_keywords),'text','50-255');?>
     </div>
    </div>
   </div><!-- fi tabpage_main -->

<!-- Content en multilingue -->
<?php foreach($aLangs as $lang) { ?>
   <div class="tabpage" id="tabpage_<?php echo $lang ?>" style="display:none;">
    <div class="grid">
     <div class="col sml-12">
      <label for="id_content_<?php echo $lang ?>"><?php echo L_CONTENT_FIELD ?>&nbsp;:</label>
      <?php 
      if(!defined('PLX_MYMULTILINGUE') || $lang==$plxAdmin->aConf['default_lang'])
       plxUtils::printArea('content',plxUtils::strCheck($content[$lang]),140,30);
      else
       plxUtils::printArea('content_'.$lang,plxUtils::strCheck($content[$lang]),140,30);
?>
     </div>
    </div>
   </div>
<?php } ?>
<!-- Fin du content en multilingue -->
  </div><!-- fi tabpage id:tabscontent -->

  <p class="in-action-bar plx<?php echo str_replace('.','-',@PLX_VERSION); echo defined('PLX_MYMULTILINGUE')?' multilingue':'';?>">
   <?php echo plxToken::getTokenPostMethod() ?>
   <input type="submit" value="<?php $plxPlugin->lang($modProduit?'L_PRODUCT_UPDATE':'L_CAT_UPDATE');?>"/>
  </p>
  </fieldset>
 </div><!-- fi tabContainer -->
</form>
<script type="text/javascript" src="<?php echo PLX_PLUGINS.get_class($plxPlugin)."/js/tabs.js" ?>"></script>
