<?php

/**
 * Edition du code source d'un produit
 *
 * @package PLX
 * @author    David L
 **/

# On édite le produit
if(!empty($_POST) AND isset($plxPlugin->aProds[$_POST['id']])) {
    $plxPlugin->editProduct($_POST);
    header('Location: plugin.php?p=plxMyShop&prod='.$_POST['id']);
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


?>
<script type='text/javascript' src='<?php echo PLX_PLUGINS;?>plxMyShop/js/libajax.js'></script>

<p class="back">
	<a href="plugin.php?p=plxMyShop<?php echo ($modProduit ? '' : '&mod=cat');?>">
		<?php echo $plxPlugin->lang($modProduit ? 'L_PRODUCT_BACK_TO_PAGE' : 'L_CAT_BACK_TO_PAGE'); ?></a>
</p>

<h2>
	<?php $plxPlugin->lang($modProduit ? 'L_PRODUCT_TITLE' : 'L_CAT_TITLE');?>
	"<?php echo plxUtils::strCheck($title);?>"
</h2>

<?php eval($plxAdmin->plxPlugins->callHook('AdminProductTop'));?>

<div id="block_select_image" style="box-shadow:0px 0px 5px #333;position:fixed;top:0px; width:600px;height:400px;overflow:auto;display:none;background-color:#dfdfdf;z-index:10000;"></div>
<form action="plugin.php?p=plxMyShop" method="post" id="form_product">
    <fieldset>
        <?php plxUtils::printInput('prod', $_GET['prod'], 'hidden');?>
        <?php plxUtils::printInput('id', $id, 'hidden');?>
        <p id="p_image"><label for="id_image">Image de pr&eacute;sentation&nbsp;:</label></p>
        <?php plxUtils::printInput('image',plxUtils::strCheck($image),'text','50-255'); ?> <span style="padding:3px; border:1px solid #999; background-color:#dfdfdf;cursor:pointer;" onclick="sendWithAjaxE4(
            '<?php echo PLX_PLUGINS;?>plxMyShop/ajax/select_image.php',
            'POST',
            'eval(xh.responseText)',
            null,
            null
		);">Choisir une image</span>
		<script type="text/javascript">
			var block_select_image=document.getElementById("block_select_image");
			var id_image=document.getElementById("id_image");
			function selectImage(img) {
				id_image.value=img;
				block_select_image.style.display="none";
			}
		</script>
		
		<p>
		<?php echo ($image!=""?'<img class="product_image" src="'.PLX_ROOT.$plxPlugin->cheminImages.$image.'">':''); ?>
		</p>
		
		<p id="p_content"><label for="id_content"><?php echo L_CONTENT_FIELD ?>&nbsp;:</label></p>
		<?php plxUtils::printArea('content', plxUtils::strCheck($content),140,30) ?>
		
		<?php if($active) : 
			$link = $plxAdmin->urlRewrite('index.php?product'.intval($id).'/'.$url);
			?>
			<p>
				<a href="<?php echo $link;?>">
					<?php $plxPlugin->lang($modProduit?'L_PRODUCT_VIEW_PAGE':'L_CAT_VIEW_PAGE');?>
					<?php echo plxUtils::strCheck($title); ?>
					<?php $plxPlugin->lang('L_PRODUCT_ON_SITE');?></a>
			</p>
        <?php endif; ?>
		
        <?php if ($modProduit): ?>
            <p><label for="id_pricettc">Prix TTC&nbsp;:</label></p>
            <?php plxUtils::printInput('pricettc',plxUtils::strCheck($pricettc),'text','50-255'); ?>
            <p><label for="id_poidg">Poids (kg)&nbsp;:</label></p>
            <?php plxUtils::printInput('poidg',plxUtils::strCheck($poidg),'text','50-255'); ?>
            <p><label for="id_noaddcart">Afficher le bouton "Ajouter au panier"&nbsp;:</label></p>
            <?php plxUtils::printSelect('noaddcart', array('1'=>L_YES,'0'=>L_NO), plxUtils::strCheck($noaddcart)); ?>
            <p><label for="id_notice_noaddcart">Afficher un message si le bouton "Ajouter au panier" n'est pas affiché&nbsp;:</label></p>
            <?php plxUtils::printInput('notice_noaddcart',plxUtils::strCheck($notice_noaddcart),'text','50-255'); ?>
			<hr/>
			Catégories de ce produit&nbsp;:<br/>
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
			<?php }?>
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
    <p class="center">
        <?php echo plxToken::getTokenPostMethod() ?>
        <input type="submit" value="<?php $plxPlugin->lang($modProduit?'L_PRODUCT_UPDATE':'L_CAT_UPDATE');?>"/>
    </p>
</form>

