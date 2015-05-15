<?php
/**
 * Plugin plxMyShop
 * @author    David L
 **/
class plxMyShop extends plxPlugin {
    public $aProds = array(); # Tableau de tous les produits
    public $get = false; # Donnees variable GET
    public $cible = false; # Article, categorie, produit ou page statique cible
	
    public function __construct($default_lang) {
        
        # appel du constructeur de la classe plxPlugin (obligatoire)
        parent::__construct($default_lang);
        # Accès au menu admin réservé au profil administrateur
        $this->setAdminProfil(PROFIL_ADMIN, PROFIL_MANAGER);
        # droits pour accèder à la page config.php du plugin
        $this->setConfigProfil(PROFIL_ADMIN);
        # Personnalisation du menu admin
        $this->setAdminMenu(($this->getParam('shop_name')!=""?$this->getParam('shop_name'):"MyShop").' '.$this->getInfo('version'), 5, 'Affichage des produits/catégories');

        $this->addHook('plxMotorPreChauffageBegin', 'plxMotorPreChauffageBegin');
        $this->addHook('plxShowConstruct', 'plxShowConstruct');
        $this->addHook('plxShowPageTitle', 'plxShowPageTitle');
        $this->addHook('plxShowStaticListEnd', 'plxShowStaticListEnd');
        $this->addHook('SitemapStatics', 'SitemapStatics');
        
        //echo PLX_ROOT.PLX_CONFIG_PATH.'products.xml'; exit;
         $this->getProducts();
         $this->get = plxUtils::getGets();
         if (!is_dir(PLX_ROOT.'data/commandes/')) {
                mkdir(PLX_ROOT.'data/commandes/', 0755, true);
         }
         if (!is_file(PLX_ROOT.'data/commandes/index.html')) {
                $mescommandeindex = fopen(PLX_ROOT.'data/commandes/index.html', 'w+');
                fclose($mescommandeindex);
         }

         
    }

    public function productNumber(){
    
        $capture=explode("/",$this->get);
        
        $capture=explode("product",$capture[0]);

       
        if (isset($capture[1])){
#             $ii=0;
#             echo count($this->aProds);
#            while($ii<(sizeof($this->aProds)+2)) {
#                $ii++;
#                if ((int)$capture[1]===(int)$ii) {

                    return str_pad($capture[1],3,"0",STR_PAD_LEFT);
#                }
#                $ii++;
#            }
        }
    }

    /**
     * Méthode de traitement du hook plxShowConstruct
     *
     * @return    stdio
     * @author    Stephane F
     **/
    public function plxShowConstruct() {
        
        if (isset($this->aProds[$this->productNumber()]['name'])) {
            # infos sur la page statique
            $string  = "if(\$this->plxMotor->mode=='product') {";
            $string .= "    \$array = array();";
            $string .= "    \$array[\$this->plxMotor->cible] = array(
                'name'        => '" . self::nomProtege($this->aProds[$this->productNumber()]["name"]) . "',
                'menu'        => '',
                'url'        => 'product',
                'readable'    => 1,
                'active'    => 1,
                'group'        => ''
            );";
            $string .= "    \$this->plxMotor->aStats = array_merge(\$this->plxMotor->aStats, \$array);";
            $string .= "}";
            echo "<?php ".$string." ?>";
        }
    }

    /**
     * Méthode qui effectue une analyse de la situation et détermine
     * le mode à appliquer. Cette méthode alimente ensuite les variables
     * de classe adéquates
     *
     * @return    null
     * @author    Anthony GUÉRIN, Florent MONTHEL, Stéphane F
     **/
    public function plxMotorPreChauffageBegin($template="static.php") {
        if (isset($this->aProds[$this->productNumber()])) {
            $template = ($this->aProds[$this->productNumber()]["template"]==""?$this->getParam('template'):$this->aProds[$this->productNumber()]["template"]);
            $string= '$prefix = str_repeat("../", substr_count(trim(PLX_ROOT."data/products/", "/"), "/"));
    if ($this->get && preg_match("#product([0-9]+)/?([a-z0-9-]+)?#",$this->get)) {
        $capture=explode("/",$this->get);
        $capture=explode("product",$capture[0]);
        $this->cible = $prefix."'.PLX_PLUGINS.'plxMyShop/form";
        $this->mode = "product";
        $this->template = "'.$template.'";
        return true;
    }';
            echo "<?php ".$string." ?>"; 
        }
    }

    /**
     * Méthode qui renseigne le titre de la page dans la balise html <title>
     *
     * @return    stdio
     * @author    Stephane F
     **/
    public function plxShowPageTitle() {
        if (isset($this->aProds[$this->productNumber()]['name'])){
            echo '<?php
                if($this->plxMotor->mode == "product") {
                    echo plxUtils::strCheck($this->plxMotor->aConf["title"]  . \' - '
						. self::nomProtege($this->aProds[$this->productNumber()]["name"]) .'\');
                    return true;
                }
            ?>';
        }
    }
	
	
	public function nomProtege($nomProduit) {
		return str_replace("\\\"", "\"", addslashes($nomProduit));
	}

    /**
     * Méthode qui référence les produits dans le sitemap
     *
     * @return    stdio
     * @author    David.L
     **/
    public function SitemapStatics() {
        if (isset($this->aProds) && is_array($this->aProds)) {
            foreach($this->aProds as $key => $value) {
                if ($value['active']==1 &&  $value['readable']==1):
                    echo '<?php
                    echo "\n";
                    echo "\t<url>\n";
                    echo "\t\t<loc>".$plxMotor->urlRewrite("?product'.$key.'/'.$value['url'].'")."</loc>\n";
                    echo "\t\t<lastmod>'.date('Y-m-d').'</lastmod>\n";
                    echo "\t\t<changefreq>daily</changefreq>\n";
                    echo "\t\t<priority>0.8</priority>\n";
                    echo "\t</url>\n";
                    ?>';
                endif;
            }
        }
    }

    /**
     * Méthode qui parse le fichier les produits et alimente
     * le tableau aProds
     *
     * @param    filename    emplacement du fichier XML des produits
     * @return    null
     * @author    David.L
     **/
    public function getProducts($filename='') {
        $filename = $filename=='' ? PLX_ROOT.PLX_CONFIG_PATH.'products.xml' : $filename;

        if(!is_file($filename)) return;

        # Mise en place du parseur XML
        $data = implode('',file($filename));
        $parser = xml_parser_create(PLX_CHARSET);
        xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
        xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,0);
        xml_parse_into_struct($parser,$data,$values,$iTags);
        xml_parser_free($parser);
        if(isset($iTags['product']) AND isset($iTags['name'])) {
       
            $nb = sizeof($iTags['name']);
            $size=ceil(sizeof($iTags['product'])/$nb);
            for($i=0;$i<$nb;$i++) {
                $attributes = $values[$iTags['product'][$i*$size]]['attributes'];
                $number = $attributes['number'];
                # Recuperation du nom du produit
                $this->aProds[$number]['name']=plxUtils::getValue($values[$iTags['name'][$i]]['value']);
                # Recuperation prix ttc
                $pricettc = plxUtils::getValue($iTags['pricettc'][$i]);
                $this->aProds[$number]['pricettc']=plxUtils::getValue($values[$pricettc]['value']);
                
                # Recuperation noaddcart
                $noaddcart = plxUtils::getValue($iTags['noaddcart'][$i]);
                $this->aProds[$number]['noaddcart']=plxUtils::getValue($values[$noaddcart]['value']);
                $notice_noaddcart = plxUtils::getValue($iTags['notice_noaddcart'][$i]);
                $this->aProds[$number]['notice_noaddcart']=plxUtils::getValue($values[$notice_noaddcart]['value']);
                
                # Recuperation poid 
                $poidg = plxUtils::getValue($iTags['poidg'][$i]);
                $this->aProds[$number]['poidg']=plxUtils::getValue($values[$poidg]['value']);
                
                # Recuperation device 
                $device = plxUtils::getValue($iTags['device'][$i]);
                $this->aProds[$number]['device']=plxUtils::getValue($values[$device]['value']);
                
                # Recuperation image 
                $image = plxUtils::getValue($iTags['image'][$i]);
                $this->aProds[$number]['image']=plxUtils::getValue($values[$image]['value']);
                
                # Recuperation de la balise title
                $title_htmltag = plxUtils::getValue($iTags['title_htmltag'][$i]);
                $this->aProds[$number]['title_htmltag']=plxUtils::getValue($values[$title_htmltag]['value']);
                # Recuperation du meta description
                $meta_description = plxUtils::getValue($iTags['meta_description'][$i]);
                $this->aProds[$number]['meta_description']=plxUtils::getValue($values[$meta_description]['value']);
                # Recuperation du meta keywords
                $meta_keywords = plxUtils::getValue($iTags['meta_keywords'][$i]);
                $this->aProds[$number]['meta_keywords']=plxUtils::getValue($values[$meta_keywords]['value']);
                # Recuperation du groupe du produit
                $this->aProds[$number]['group']=plxUtils::getValue($values[$iTags['group'][$i]]['value']);
                # Recuperation du de la variable categorie
                $this->aProds[$number]['pcat']=plxUtils::getValue($values[$iTags['pcat'][$i]]['value']);
                
                $this->aProds[$number]['menu']=plxUtils::getValue($values[$iTags['menu'][$i]]['value']);
                # Recuperation de l'url du produit
                $this->aProds[$number]['url']=strtolower($attributes['url']);
                # Recuperation de l'etat du produit
                $this->aProds[$number]['active']=intval($attributes['active']);
                # recuperation du fichier template
                $this->aProds[$number]['template']=isset($attributes['template'])?$attributes['template']:$this->getParam('template');
                # On verifie que le produit existe bien
                $file = PLX_ROOT.'data/products/'.$number.'.'.$attributes['url'].'.php';
                # On test si le fichier est lisible
                $this->aProds[$number]['readable'] = (is_readable($file) ? 1 : 0);
            }
        }
    }

    /**

     * Méthode qui édite le fichier XML des produits selon le tableau $content
     *
     * @param    content    tableau multidimensionnel des produits
     * @param    action    permet de forcer la mise àjour du fichier
     * @return    string
     * @author    David L.
     **/
    public function editProducts($content, $action=false) {
        
        $save = $this->aProds;
        # suppression
        if(!empty($content['selection']) AND $content['selection']=='delete' AND isset($content['idProduct'])) {
            foreach($content['idProduct'] as $product_id) {
                $filename = PLX_ROOT.'data/products/'.$product_id.'.'.$this->aProds[$product_id]['url'].'.php';
                if(is_file($filename)) unlink($filename);
                # si le produit supprimée est en page d'accueil on met à jour le parametre
                unset($this->aProds[$product_id]);
                $action = true;
            }
        }
        # mise à jour de la liste des produits
        elseif(!empty($content['update'])) {
            foreach($content['productNum'] as $product_id) {
                $stat_name = $content[$product_id.'_name'];
                if($stat_name!='') {
                    $url = (isset($content[$product_id.'_url'])?trim($content[$product_id.'_url']):'');
                    $stat_url = ($url!=''?plxUtils::title2url($url):plxUtils::title2url($stat_name));
                    if($stat_url=='') $stat_url = L_DEFAULT_NEW_PRODUCT_URL;
                    # On vérifie si on a besoin de renommer le fichier du produit
                    if(isset($this->aProds[$product_id]) AND $this->aProds[$product_id]['url']!=$stat_url) {
                        $oldfilename = PLX_ROOT.'data/products/'.$product_id.'.'.$this->aProds[$product_id]['url'].'.php';
                        $newfilename = PLX_ROOT.'data/products/'.$product_id.'.'.$stat_url.'.php';
                        if(is_file($oldfilename)) rename($oldfilename, $newfilename);
                    }
                    $this->aProds[$product_id]['pcat'] = trim($content[$product_id.'_pcat']);
                    $this->aProds[$product_id]['menu'] = trim($content[$product_id.'_menu']);
                    $this->aProds[$product_id]['group'] = trim($content[$product_id.'_group']);
                    $this->aProds[$product_id]['name'] = $stat_name;
                    $this->aProds[$product_id]['url'] = plxUtils::checkSite($url)?$url:$stat_url;
                    $this->aProds[$product_id]['active'] = $content[$product_id.'_active'];
                    $this->aProds[$product_id]['ordre'] = intval($content[$product_id.'_ordre']);
                    $this->aProds[$product_id]['template'] = (isset($this->aProds[$product_id]['template'])?$this->aProds[$product_id]['template']:$this->getParam('template'));
                    $this->aProds[$product_id]['title_htmltag'] = (isset($this->aProds[$product_id]['title_htmltag'])?$this->aProds[$product_id]['title_htmltag']:'');
                    $this->aProds[$product_id]['image'] = (isset($this->aProds[$product_id]['image'])?$this->aProds[$product_id]['image']:'');
                    $this->aProds[$product_id]['noaddcart'] = (isset($this->aProds[$product_id]['noaddcart'])?$this->aProds[$product_id]['noaddcart']:'');
                    $this->aProds[$product_id]['notice_noaddcart'] = (isset($this->aProds[$product_id]['notice_noaddcart'])?$this->aProds[$product_id]['notice_noaddcart']:'');
                    $this->aProds[$product_id]['pricettc'] = (isset($this->aProds[$product_id]['pricettc'])?$this->aProds[$product_id]['pricettc']:'');
                    $this->aProds[$product_id]['poidg'] = (isset($this->aProds[$product_id]['poidg'])?$this->aProds[$product_id]['poidg']:'');
                    $this->aProds[$product_id]['device'] = (isset($this->aProds[$product_id]['device'])?$this->aProds[$product_id]['device']:'');
                    $this->aProds[$product_id]['meta_description'] = (isset($this->aProds[$product_id]['meta_description'])?$this->aProds[$product_id]['meta_description']:'');
                    $this->aProds[$product_id]['meta_keywords'] = (isset($this->aProds[$product_id]['meta_keywords'])?$this->aProds[$product_id]['meta_keywords']:'');
                    $action = true;
                }
            }
            
            # On va trier les clés selon l'ordre choisi
            if(sizeof($this->aProds)>0) uasort($this->aProds, create_function('$a, $b', 'return $a["ordre"]>$b["ordre"];'));
        }
        # sauvegarde
        if($action) {
            //var_dump($content); exit;
            $products_name = array();
            $products_url = array();
            # On génére le fichier XML
            $xml = "<?xml version=\"1.0\" encoding=\"".PLX_CHARSET."\"?>\n";
            $xml .= "<document>\n";
            if (isset($this->aProds) && is_array($this->aProds)) {
                foreach($this->aProds as $product_id => $product) {
                    
                    # control de l'unicité du titre de la page
                    if(in_array($product['name'], $products_name))
                        return plxMsg::Error(L_ERR_PRODUCT_ALREADY_EXISTS.' : '.plxUtils::strCheck($product['name']));
                    else
                        $products_name[] = $product['name'];
                    
                    # control de l'unicité de l'url de la page
                    if(in_array($product['url'], $products_url)) {
                        $this->aProds = $save;
                        return plxMsg::Error(L_ERR_URL_ALREADY_EXISTS.' : '.plxUtils::strCheck($product['url']));
                    }
                    else
                        $products_url[] = $product['url'];
                    $xml .= "\t<product number=\"".$product_id."\" active=\"".$product['active']."\" url=\"".$product['url']."\" template=\"".basename($product['template'])."\">";
                    $xml .= "<pcat><![CDATA[".plxUtils::cdataCheck($product['pcat'])."]]></pcat>";
                    $xml .= "<menu><![CDATA[".plxUtils::cdataCheck($product['menu'])."]]></menu>";
                    $xml .= "<group><![CDATA[".plxUtils::cdataCheck($product['group'])."]]></group>";
                    $xml .= "<name><![CDATA[".plxUtils::cdataCheck($product['name'])."]]></name>";
                    $xml .= "<image><![CDATA[".plxUtils::cdataCheck($product['image'])."]]></image>";
                    $xml .= "<noaddcart><![CDATA[".plxUtils::cdataCheck($product['noaddcart'])."]]></noaddcart>";
                    $xml .= "<notice_noaddcart><![CDATA[".plxUtils::cdataCheck($product['notice_noaddcart'])."]]></notice_noaddcart>";
                    $xml .= "<pricettc><![CDATA[".plxUtils::cdataCheck($product['pricettc'])."]]></pricettc>";
                    $xml .= "<poidg><![CDATA[".plxUtils::cdataCheck(($product['poidg']==0?"0.0":$product['poidg']))."]]></poidg>";
                    $xml .= "<device><![CDATA[".plxUtils::cdataCheck($product['device'])."]]></device>";
                    $xml .= "<meta_description><![CDATA[".plxUtils::cdataCheck($product['meta_description'])."]]></meta_description>";
                    $xml .= "<meta_keywords><![CDATA[".plxUtils::cdataCheck($product['meta_keywords'])."]]></meta_keywords>";
                    $xml .= "<title_htmltag><![CDATA[".plxUtils::cdataCheck($product['title_htmltag'])."]]></title_htmltag>";
                    # Hook plugins
                    //eval($this->plxPlugins->callHook('plxAdminEditProductsXml'));
                    $xml .=    "</product>\n";
                }
            }
            $xml .= "</document>";
            # On écrit le fichier si une action valide a été faite
            if(plxUtils::write($xml,PLX_ROOT.PLX_CONFIG_PATH.'products.xml')){
                
                return plxMsg::Info(L_SAVE_SUCCESSFUL);
            }else {
                $this->aProds = $save;
                return plxMsg::Error(L_SAVE_ERR.' '.PLX_ROOT.PLX_CONFIG_PATH.'products.xml');
            }
        }
    }
    
    /**
     * Méthode qui lit le fichier d'un produit
     *

     * @param    num    numero du fichier du produit
     * @return    string    contenu de la page
     * @author    Stephane F.
     **/
    public function getFileProduct($num) {

        # Emplacement de la page

        $filename = PLX_ROOT.'data/products/'.$num.'.'.$this->aProds[ $num ]['url'].'.php';
        if(is_file($filename) AND filesize($filename) > 0) {
            if($f = fopen($filename, 'r')) {
                $content = fread($f, filesize($filename));
                fclose($f);
                # On retourne le contenu
                return $content;
            }
        }
        return null;
    }

    /**
     * Méthode qui sauvegarde le contenu d'un produit
     *
     * @param    content    données à sauvegarder
     * @return    string
     * @author    David.L
     **/
    public function EditProduct($content) {
        # Mise à jour du fichier product.xml
        
        $this->aProds[$content['id']]['image'] = $content['image'];
        $this->aProds[$content['id']]['noaddcart'] = $content['noaddcart'];
        $this->aProds[$content['id']]['notice_noaddcart'] = $content['notice_noaddcart'];
        $this->aProds[$content['id']]['pricettc'] = $content['pricettc'];
        $this->aProds[$content['id']]['poidg'] = $content['poidg'];
        $this->aProds[$content['id']]['device'] = $content['device'];
        $this->aProds[$content['id']]['template'] = $content['template'];
        $this->aProds[$content['id']]['title_htmltag'] = trim($content['title_htmltag']);
        $this->aProds[$content['id']]['meta_description'] = trim($content['meta_description']);
        $this->aProds[$content['id']]['meta_keywords'] = trim($content['meta_keywords']);
        # Hook plugins
        //eval($this->plxPlugins->callHook('plxAdminEditProduct'));

        if($this->editProducts(null,true)) {
            if (!is_dir(PLX_ROOT.'data/products/')) {
                mkdir(PLX_ROOT.'data/products/', 0755, true);
            }
            # Génération du nom du fichier de la page statique
            $filename = PLX_ROOT.'data/products/'.$content['id'].'.'.$this->aProds[ $content['id'] ]['url'].'.php';
            # On écrit le fichier
            if(plxUtils::write($content['content'],$filename))
                return plxMsg::Info(L_SAVE_SUCCESSFUL);
            else
                return plxMsg::Error(L_SAVE_ERR.' '.$filename);
        }
    }
    

    /**
     * Méthode qui retourne l'id du produit active
     *
     * @return    int
     * @scope    product
     * @author    David.L
     **/
    public function productId() {
        # On va verifier que la categorie existe en mode categorie
        if($this->mode == 'product' AND isset($this->aProds[ $this->productNumber() ]))
            return intval($this->productNumber());
    }

    /**
     * Méthode qui affiche l'url du produit de type relatif ou absolu
     *
     * @param    type    type de lien : relatif ou absolu (URL complète)
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productUrl($type='relatif') {

        # Recupération ID URL
        $productId = $this->productId();
        $productIdFill = str_pad($productId,3,'0',STR_PAD_LEFT);
        if(!empty($productId) AND isset($this->aProds[ $productIdFill ]))
            echo $this->urlRewrite('index.php?product'.$productId.'/'.$this->aProds[ $productIdFill ]['url']);
    }
    
    public function productRUrl($key) {
        # Recupération ID URL
        $productId = intval($key);
        if(!empty($productId) AND isset($this->aProds[$key]))
            return plxShow::getInstance()->plxMotor->urlRewrite('index.php?product'.$productId.'/'.$this->aProds[$key]['url']);
    }

    /**
     * Méthode qui affiche le titre du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productTitle() {

        echo plxUtils::strCheck(preg_replace("/'/",'&apos;',$this->aProds[ $this->productNumber()]['name']));
    }
    
    /**
     * Méthode qui affiche l'image du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L

     **/
    public function productImage() {

        return plxUtils::strCheck($this->aProds[ $this->productNumber() ]["image"]);
    }
    
    /**
     * Méthode qui affiche le prix TTC du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productPriceTTC() {

        echo plxUtils::strCheck($this->aProds[ $this->productNumber() ]['pricettc']);
    }
    
    /**
     * Méthode qui affiche ou pas le bouton acheter
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productNoAddCart() {
        return plxUtils::strCheck($this->aProds[ $this->productNumber() ]['noaddcart']);
    }
    
    /**
     * Méthode qui affiche une notice si le bouton ajouter au panier n'est pas afficher
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productNoticeNoAddCart() {
        return plxUtils::strCheck($this->aProds[ $this->productNumber() ]['notice_noaddcart']);
    }
    
    /**
     * Méthode qui affiche le poid en gramme du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productPoidG() {

        return plxUtils::strCheck($this->aProds[ $this->productNumber() ]['poidg']);
    }
    
    /**
     * Méthode qui affiche la device du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productDevice() {

        echo plxUtils::strCheck($this->aProds[ $this->productNumber()]['device']);
    }

    /**
     * Méthode qui affiche le groupe du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productGroup() {

        echo plxUtils::strCheck($this->aProds[ $this->productNumber() ]['group']);
    }
    
    /**
     * Méthode qui affiche le titre du groupe du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productGroupTitle() {
        if ($gt=explode(',',$this->aProds[ $this->productNumber() ]['group'])) {
            $tmp=array();
            foreach($gt as $gTitle) {
                $tmp[$gTitle]=$this->aProds[$gTitle]['name'];
            }
            
            return $tmp;
        } else return plxUtils::strCheck($this->aProds[$this->aProds[ $this->productNumber() ]['group']]['name']);
    }

    /**
     * Méthode qui affiche la date de la dernière modification du produit selon le format choisi
     *
     * @param    format    format du texte de la date (variable: #minute, #hour, #day, #month, #num_day, #num_month, #num_year(4), #num_year(2))
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function productDate($format='#day #num_day #month #num_year(4)') {

        # On genere le nom du fichier dont on veux récupérer la date
        $file = PLX_ROOT.'data/products/'.$this->productNumber();
        $file .= '.'.$this->aProds[$this->productNumber() ]['url'].'.php';
        # Test de l'existence du fichier
        if(!is_file($file)) return;
        # On récupère la date de la dernière modification du fichier qu'on formate
        echo plxDate::formatDate(date('YmdHi', filemtime($file)), $format);
    }

    /**
     * Méthode qui inclut le code source du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L
     **/
    public function plxShowProductContent() {
       
        # On va verifier que la page a inclure est lisible
        if($this->aProds[ $this->productNumber() ]['readable'] == 1) {
            # On genere le nom du fichier a inclure
            $file = PLX_ROOT.'data/products/'.$this->productNumber();
            $file .= '.'.$this->aProds[ $this->productNumber() ]['url'].'.php';
            # Inclusion du fichier
            ob_start();
            require $file;
            $output = ob_get_clean();
            echo $output;
        } else {
            echo '<p>'.L_STATICCONTENT_INPROCESS.'</p>';
        }

    }

    /**
     * Méthode qui affiche un produit en lui passant son id (si ce produit est active ou non)
     *
     * @param    id numérique de la page product
     * @return    stdout
     * @scope    global
     * @author    David.L
     **/
    public function plxShowProductInclude($id) {
     
        # Hook Plugins
        //if(eval($this->plxMotor->plxPlugins->callHook('plxShowProductInclude'))) return ;
        # On génère un nouvel objet plxGlob
        $plxGlob_stats = plxGlob::getInstance(PLX_ROOT.'data/products/');
        if($files = $plxGlob_stats->query('/^'.str_pad($id,3,'0',STR_PAD_LEFT).'.[a-z0-9-]+.php$/')) {
            include(PLX_ROOT.'data/products/'.$files[0]);
        }
    }
    
    /**
     * Méthode de traitement du hook plxShowStaticListEnd
     *
     * @return    stdio
     * @author    David.L
     **/
    public function plxShowStaticListEnd() {

        # ajout du menu pour accèder à la page de contact
        if (isset($this->aProds) && is_array($this->aProds)) {
            foreach($this->aProds as $k=>$v) {
                if ($v['menu']!='non' && $v['menu']!='') {
					
					$nomProtege = self::nomProtege($v['name']);
					
					echo "<?php \$class = \$this->plxMotor->mode=='product'?'active':'noactive'; ?>";
					echo "<?php array_splice(\$menus, ".($this->getParam('menu_position')-1).", 0, '<li><a class=\"static '.\$class.'\" href=\"'.\$this->plxMotor->urlRewrite('index.php?product".$k."/".$v['url']."').'\" title=\"".$nomProtege."\">".$nomProtege."</a></li>'); ?>";
                }
            }
        }
    }
    
	
	public $donneesModeles = array();
	
	public function modele($modele) {
		
		$plxMotor = plxMotor::getInstance();
		
		$racineTheme = PLX_ROOT . $plxMotor->aConf["racine_themes"] . $plxMotor->style;
		$fichier = "$racineTheme/modeles/plxMyShop/$modele.php";
		
		
		// si le fichier du modèle n'existe pas dans le thème
		if (!file_exists($fichier)) {
			// on choisi le fichier par défaut dans le répertoire de l'extension
			$fichier = "modeles/$modele.php";
		}
		
		$d = $this->donneesModeles;
		require $fichier;
		
	}
	
}
?>
