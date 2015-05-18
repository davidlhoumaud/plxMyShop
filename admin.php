<?php

/**
 * Edition des produits
 *
 * @package PLX
 * @author    David L 
 **/



# Control du token du formulaire
plxToken::validateFormToken($_POST);


# Control de l'accès à la page en fonction du profil de l'utilisateur connecté
$plxAdmin->checkProfil(PROFIL_ADMIN, PROFIL_MANAGER);

# On édite les produits
$fakeget='';
if(!empty($_POST)) {
    $plxPlugin->editProducts($_POST, true);
    if (isset($_POST['prod']) && !empty($_POST['prod'])) {
        $plxPlugin->editProduct($_POST);
        $fakeget='&prod='.$_POST['prod'];
    } else {
        $plxPlugin->editProducts($_POST);
        $fakeget=(isset($_GET['mod']) && !empty($_GET['mod'])?'&mod='.$_GET['mod']:'');
    }
    header('Location: plugin.php?p=plxMyShop'.$fakeget);
    exit;
}

$dir = PLX_ROOT."data/commandes/";
if (isset($_GET['kill']) && !empty($_GET['kill']) && is_file($dir.$_GET['kill'])) {
        unlink($dir.$_GET['kill']);
        header('Location: plugin.php?p=plxMyShop&mod=cmd');
}

if ((isset($_GET['prod']) && !empty($_GET['prod'])) || 
    (isset($_POST['prod']) && !empty($_POST['prod'])) ) 
        include(dirname(__FILE__).'/product.php');
else {
# On inclut le header
//include(dirname(__FILE__).'/top.php');
?>
<script type="text/javaScript">
function checkBox(obj) {
    obj.value = (obj.checked==true) ? '1': '0';
}
</script>
<h2>
<?php
if (!isset($_GET['mod']) || (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])!='cmd')) {
echo $plxPlugin->lang('CREATE_PRODUCTS_CATS').(isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?$plxPlugin->lang('CREATE_CATS'):$plxPlugin->lang('CREATE_PRODUCTS')); 
} else {
echo $plxPlugin->lang('LIST_ORDERS');
}
?></h2>
<a href="plugin.php?p=plxMyShop"><button <?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])==('cat'||'cmd')?"style='cursor:pointer;'":"disabled"); ?> ><?php echo $plxPlugin->lang('L_MENU_PRODUCTS'); ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plugin.php?p=plxMyShop&mod=cat"><button <?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?"disabled":"style='cursor:pointer;'"); ?>><?php echo $plxPlugin->lang('L_MENU_CATS'); ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="plugin.php?p=plxMyShop&mod=cmd"><button <?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cmd'?"disabled":"style='cursor:pointer;'"); ?>><?php echo $plxPlugin->lang('L_MENU_ORDERS'); ?></button></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="parametres_plugin.php?p=plxMyShop"><button><?php echo $plxPlugin->lang('L_MENU_CONFIG'); ?></button></a>

<form action="plugin.php?p=plxMyShop<?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?"&mod=cat":""); ?>" method="post" id="form_products">
    <table class="table">
    <thead>
        <tr>
            <?php if (!isset($_GET['mod']) || (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])!='cmd')): ?>
            <th class="checkbox"><input type="checkbox" onclick="checkAll(this.form, 'idProduct[]')" /></th>
            <th style="width:80px"><?php $plxPlugin->lang('L_PRODUCTS_ID') ?></th>
            <th><!--Catégorie--></th>
            <th><?php $plxPlugin->lang('L_PRODUCTS_TITLE') ?></th>
            <th><?php $plxPlugin->lang('L_PRODUCTS_URL') ?></th>
            <th><?php $plxPlugin->lang('L_PRODUCTS_ACTIVE') ?></th>
            <th><?php $plxPlugin->lang('L_PRODUCTS_ORDER') ?></th>
            <?php if(isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat') {
            echo '<th>';
            $plxPlugin->lang('L_PRODUCTS_MENU');
            echo '</th>';
            } ?>
            <th><?php $plxPlugin->lang('L_PRODUCTS_ACTION') ?></th>
            <?php else: ?>
            <th><?php $plxPlugin->lang('L_DATE') ?></th>
            <th><?php $plxPlugin->lang('L_PAIEMENT') ?></th>
            <th><?php $plxPlugin->lang('L_MONTANT') ?></th>
            <th><?php $plxPlugin->lang('L_ACTIONS') ?></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php
    # Initialisation de l'ordre
    $num = 0;
    # Si on a des produits
    if($plxPlugin->aProds) {
        foreach($plxPlugin->aProds as $k=>$v) { # Pour chaque produit
              $url=$v['url'];
            if ((isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat' && $v['pcat']!=1)||(isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cmd'))continue;
            if (!isset($_GET['mod']) && $v['pcat']==1)continue;
            $ordre = ++$num;
            echo '<tr class="line-'.($num%2).'">';
            echo '<td><input type="checkbox" name="idProduct[]" value="'.$k.'" /><input type="hidden" name="productNum[]" value="'.$k.'" /></td>';
            echo '<td>'.$k.'</td>';
            $selected = $v['pcat']==1 ? ' checked="checked"' : '';
            $valued = $v['pcat']==1 ? '1' : '0'; ?>
            <td><input title="<?php $plxPlugin->lang('L_CAT') ?><?php echo '" type="hidden" name="'.$k.'_pcat" value="'.$valued.'"'.$selected.' onclick="checkBox(this);" /></td>';

            echo '<td>';
            plxUtils::printInput($k.'_name', plxUtils::strCheck($v['name']), 'text', '13-255');
            echo '</td><td>';
            plxUtils::printInput($k.'_url', $v['url'], 'text', '12-255');
            echo '</td><td>';
            plxUtils::printSelect($k.'_active', array('1'=>L_YES,'0'=>L_NO), $v['active']);
            echo '</td><td>';
            plxUtils::printInput($k.'_ordre', $ordre, 'text', '2-3');
            echo '</td>';
            if ($v['pcat']==1) {
            echo '<td>';
            plxUtils::printSelect($k.'_menu', array('oui'=>L_DISPLAY,'non'=>L_HIDE), $v['menu']);
            echo '</td>';
            }
            if(!plxUtils::checkSite($v['url'])) {
                echo '<td>';
                echo '<a href="plugin.php?p=plxMyShop&prod='.$k.'" title="';
                $plxPlugin->lang('L_PRODUCTS_SRC_TITLE');
                echo '">';
                $plxPlugin->lang('L_PRODUCTS_SRC');
                echo '</a>';
                if($v['active']) {
                    echo '&nbsp;-&nbsp;<a href="'.$plxAdmin->urlRewrite('index.php?product'.intval($k).'/'.$url).'" title="Visualiser '.plxUtils::strCheck($v['name']).' sur le site">'.L_VIEW.'</a>';
                }
                echo '</td></tr>';
            }
            elseif($url[0]=='?')
                echo '</td><td>b <a href="'.$plxAdmin->urlRewrite('index.php?product'.intval($k).'/'.$url).'" title="'.plxUtils::strCheck($v['name']).'">'.L_VIEW.'</a></td></tr>';
            else
                echo '</td><td>c <a href="'.$plxAdmin->urlRewrite('index.php?product'.intval($k).'/'.$url).'" title="'.plxUtils::strCheck($v['name']).'">'.L_VIEW.'</a></td></tr>';
        }
        # On récupère le dernier identifiant
        $a = array_keys($plxPlugin->aProds);
        rsort($a);
    } else {
        $a['0'] = 0;
    }
    $new_productid = str_pad($a['0']+1, 3, "0", STR_PAD_LEFT);
    ?>
     <?php if (!isset($_GET['mod']) || (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])!='cmd')): ?>
        <tr class="new">
            <td>&nbsp;</td>
            <td><?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?"Nouvelle catégorie":"Nouveau produit"); ?></td>
            <?php
                echo '<input type="hidden" name="productNum[]" value="'.$new_productid.'" />'; ?>
                <td><input title="<?php $plxPlugin->lang('L_CAT') ?><?php echo '" type="hidden" name="'.$new_productid.'_pcat" value="'.(isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?'1':'0').'" '.(isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?'checked':'').' onclick="checkBox(this);" ></td>';
                echo '<td>';
                plxUtils::printInput($new_productid.'_name', '', 'text', '13-255');
                plxUtils::printInput($new_productid.'_template', $plxPlugin->getParam('template'), 'hidden');
                echo '</td><td>';
                plxUtils::printInput($new_productid.'_url', '', 'text', '12-255');
                echo '</td><td>';
                plxUtils::printSelect($new_productid.'_active', array('1'=>L_YES,'0'=>L_NO), '0');
                echo '</td><td>';
                plxUtils::printInput($new_productid.'_ordre', ++$num, 'text', '2-3');
                echo '</td>';
                if (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat') {
                echo '<td>';
                plxUtils::printSelect($new_productid.'_menu', array('oui'=>L_DISPLAY,'non'=>L_HIDE), '0');
                echo '<td>';
                }
            ?>
            <td>&nbsp;</td>
        </tr>
    <?php else:
    
    $dh  = opendir($dir);
    $filescommande= array();
    while (false !== ($filename = readdir($dh))) {
        if (is_file($dir.$filename) && $filename!='.' && $filename!='..' && $filename!='index.html') {
            $filescommande[] = $filename;
        }
    }
    rsort($filescommande);
    while (list ($key, $val) = each ($filescommande) ) {
        $namearray=preg_split('/_/',$val);
        $date=preg_split('/-/',$namearray[0]);
        echo '<tr>'.
            '   <td>'.$date[2].'-'.$date[1].'-'.$date[0].' &agrave; '.preg_replace('/-/',':',$namearray[1]).'</td>'.
            '   <td>'.$namearray[2].'</td>'.
            '   <td>'.((float)$namearray[3]+(float)preg_replace('/.html/','',$namearray[4])).'</td>'.
            '   <td><a onclick="if(confirm(\'Confirmez-vous la supression de cette commande ?\')) return true; else return false;" href="plugin.php?p=plxMyShop&mod=cmd&kill='.$val.'">Supprimer</a> - <a href="'.$dir.$val.'" target="_BLANK">Voir</a></td>'.
            '</tr>';
    }; 
    
    endif; ?>
    </tbody>
    </table>
    <?php if (!isset($_GET['mod']) || (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])!='cmd')): ?>
    <p class="center">
        <?php echo plxToken::getTokenPostMethod() ?>
        <input class="button update" type="submit" name="update" value="Modifier la liste des <?php echo (isset($_GET['mod']) && plxUtils::strCheck($_GET['mod'])=='cat'?'catégories':'produits'); ?>" />
    </p>
    <p>
        <?php plxUtils::printSelect('selection', array( '' =>L_FOR_SELECTION, 'delete' =>L_DELETE), '', false, '', 'id_selection') ?>
        <input class="button submit" type="submit" name="submit" value="<?php echo L_OK ?>" onclick="return confirmAction(this.form, 'id_selection', 'delete', 'idProduct[]', '<?php echo L_CONFIRM_DELETE ?>')" />
    </p>
    <?php endif; ?>
</form>

<?php } ?>
