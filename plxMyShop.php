<?php
/**
 * Plugin plxMyShop
 * @author    David L
 **/
class plxMyShop extends plxPlugin {
	
	public $aProds = array(); # Tableau de tous les produits
	public $donneesModeles = array();
	
	public $plxMotor;
	public $cheminImages;
	public $idProduit;
	
	
    public function __construct($default_lang) {
        
        # appel du constructeur de la classe plxPlugin (obligatoire)
        parent::__construct($default_lang);
        # Accès au menu admin réservé au profil administrateur
        $this->setAdminProfil(PROFIL_ADMIN, PROFIL_MANAGER);
        # droits pour accèder à la page config.php du plugin
        $this->setConfigProfil(PROFIL_ADMIN);
        # Personnalisation du menu admin
        $this->setAdminMenu(
			($this->getParam('shop_name') !== "" ? $this->getParam('shop_name') : "MyShop") . ' ' . $this->getInfo('version')
			, 5
			, 'Affichage des produits / catégories'
		);

        $this->addHook('plxMotorPreChauffageBegin', 'plxMotorPreChauffageBegin');
        $this->addHook('plxShowConstruct', 'plxShowConstruct');
        $this->addHook('plxShowPageTitle', 'plxShowPageTitle');
        $this->addHook('plxShowStaticListEnd', 'plxShowStaticListEnd');
        $this->addHook('SitemapStatics', 'SitemapStatics');
		
        $this->addHook('AdminPrepend', 'AdminPrepend');
        
		$this->getProducts();
		
		if (!is_dir(PLX_ROOT.'data/commandes/')) {
			mkdir(PLX_ROOT.'data/commandes/', 0755, true);
		}
		if (!is_file(PLX_ROOT.'data/commandes/index.html')) {
			$mescommandeindex = fopen(PLX_ROOT.'data/commandes/index.html', 'w+');
			fclose($mescommandeindex);
		}
		
		
		// méthodes de paiement
		
		$tabMethodespaiement = array(
			"cheque" => array(
				"libelle" => "Chèque",
				"codeOption" => "payment_cheque",
			),
			"paypal" => array(
				"libelle" => "Paypal",
				"codeOption" => "payment_paypal",
			),
		);
		
		$tabChoixMethodespaiement = array();
		
		foreach ($tabMethodespaiement as $codeMethodespaiement => $m) {
			if ("1" === $this->getParam($m["codeOption"])) {
				$tabChoixMethodespaiement[$codeMethodespaiement] = $m;
			}
		}
		
		$this->donneesModeles["tabChoixMethodespaiement"] = $tabChoixMethodespaiement;
		
    }

    public function productNumber() {
		return $this->idProduit;
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
    
	
	
	public function AdminPrepend() {
		
		$this->plxMotor = plxAdmin::getInstance();
		
		if (isset($this->plxMotor->aConf['images'])) {
			// jusqu'à la version 5.3.1
			$this->cheminImages = $this->plxMotor->aConf['images'];
		} else {
			$this->cheminImages = $this->plxMotor->aConf['media'];
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

	public function plxMotorPreChauffageBegin() {
		
		$this->plxMotor = plxMotor::getInstance();
		
		if (isset($this->plxMotor->aConf['images'])) {
			// jusqu'à la version 5.3.1
			$this->cheminImages = $this->plxMotor->aConf['images'];
		} else {
			$this->cheminImages = $this->plxMotor->aConf['media'];
		}
		
		
		$nomPlugin = __CLASS__;
		
		
		// contrôleur des pages du plugin
		
		
		if ("boutique/panier" === $this->plxMotor->get) {
			
			$classeVue = "panier";
			
			require_once "classes/vues/$classeVue.php";
			$this->vue = new $classeVue();
			$this->vue->traitement();
			
			$this->plxMotor->mode = "static";
			$this->plxMotor->cible = $nomPlugin;
			$this->plxMotor->template = $this->getParam("template");
			
			$this->plxMotor->aConf["racine_statiques"] = "";
			$this->plxMotor->aStats[$this->plxMotor->cible] = array(
				"name" => $this->vue->titre(),
				"url" => "/../{$this->plxMotor->aConf["racine_plugins"]}/$nomPlugin/template/vue",
				"active" => 1,
				"menu" => "non",
				"readable" => 1,
				"title_htmltag" => "",
			);
			
			echo "<?php return TRUE;?>";
		}
		
		
		// pages des produits et des catégories
		
		if (preg_match("#product([0-9]+)/?([a-z0-9-]+)?#", $this->plxMotor->get, $resultat)) {
			$this->idProduit = str_pad($resultat[1], 3, "0", STR_PAD_LEFT);
			
			$template = $this->aProds[$this->productNumber()]["template"] === ""
				 ? $this->getParam('template')
				 : $this->aProds[$this->productNumber()]["template"];
			
			$this->plxMotor->mode = "product";
			$this->plxMotor->aConf["racine_statiques"] = "";
			$this->plxMotor->cible = "{$this->plxMotor->aConf["racine_plugins"]}/$nomPlugin/form";
			$this->plxMotor->template = $template;
			
			echo "<?php return TRUE;?>";
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
	
	
	public static function nomProtege($nomProduit) {
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
                    $this->aProds[$product_id]['group'] = (isset($this->aProds[$product_id]['group'])?$this->aProds[$product_id]['group']:'');
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
    public function editProduct($content) {
        # Mise à jour du fichier product.xml
		
		if (isset($content["listeCategories"])) {
			$this->aProds[$content['id']]['group'] = implode(",", $content["listeCategories"]);
		}
        
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
		
		echo plxUtils::strCheck(
			preg_replace(
				"/'/"
				, '&apos;'
				, $this->aProds[ $this->productNumber()]['name']
			)
		);
    }
    
    /**
     * Méthode qui affiche l'image du produit
     *
     * @return    stdout
     * @scope    product
     * @author    David.L

     **/
    public function productImage() {
		
		return plxUtils::strCheck(
			$this->plxMotor->urlRewrite(
				$this->cheminImages
				. $this->aProds[$this->productNumber()]["image"]
			)
		);
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
		
		
		$positionMenu = $this->getParam('menu_position') - 1;
		
		
		if (in_array(
				$this->getParam("affPanier")
				, array("pageSeparee", "partout")
			)
		) {
			// ajout du lien vers le panier
			
			$nomPlugin = __CLASS__;
			
			$panierSelectionne = (
					("static" === $this->plxMotor->mode)
				&&	($nomPlugin === $this->plxMotor->cible)
				&&	("panier" === get_class($this->vue))
			);
			
			
			$classeCss = $panierSelectionne ? "active" : "noactive";
			
			$lienPanier = $this->plxMotor->urlRewrite("index.php?boutique/panier");
			
			require_once "classes/vues/panier.php";
			$vuePanier = new panier();
			
			$titreProtege = plxMyShop::nomProtege($vuePanier->titre());
			
			
			echo "<?php";
			echo "	array_splice(\$menus, $positionMenu, 0";
			echo "		, '<li><a class=\"static $classeCss\" href=\"$lienPanier\" title=\"' . htmlspecialchars('$titreProtege') . '\">$titreProtege</a></li>'";
			echo "	);";
			echo "?>";
		}
		
		
		if ("pageSeparee" !== $this->getParam("affPanier")) {
			$lienPanier = "#panier";
		}
		
		$this->donneesModeles["lienPanier"] = $lienPanier;
		
		
        # ajout du menu pour accèder aux rubriques
		
        if (isset($this->aProds) && is_array($this->aProds)) {
			
			
            foreach(array_reverse($this->aProds) as $k=>$v) {
                if ($v['menu']!='non' && $v['menu']!='') {
					
					$nomProtege = self::nomProtege($v['name']);
					
					$categorieSelectionnee = (
							("product" === $this->plxMotor->mode)
						&&	("product$k/{$v["url"]}" === $this->plxMotor->get)
					);
					
					
					$classeCss = $categorieSelectionnee ? "active" : "noactive";
					$lien = $this->plxMotor->urlRewrite("index.php?product$k/{$v["url"]}");
					
					echo "<?php";
					echo "	array_splice(\$menus, $positionMenu, 0";
					echo "		, '<li><a class=\"static $classeCss\" href=\"$lien\" title=\"' . htmlspecialchars('$nomProtege') . '\">$nomProtege</a></li>'";
					echo "	);";
					echo "?>";
					
                }
            }
        }
    }
    
	
	public function modele($modele) {
		
		if (!isset($this->donneesModeles["pileModeles"])) {
			$this->donneesModeles["pileModeles"] = array();
		}
		
		$this->donneesModeles["pileModeles"][] = $modele;
		
		
		// fichier du modèle dans le thème
		
		$plxMotor = plxMotor::getInstance();
		
		$racineTheme = PLX_ROOT . $plxMotor->aConf["racine_themes"] . $plxMotor->style;
		$fichier = "$racineTheme/modeles/plxMyShop/$modele.php";
		
		
		// si le fichier du modèle n'existe pas dans le thème
		if (!is_file($fichier)) {
			// on choisi le fichier par défaut dans le répertoire de l'extension
			$fichier = "modeles/$modele.php";
		}
		
		$d = $this->donneesModeles;
		
		require $fichier;
		
		
		// rétablissement des noms des modèles
		array_pop($this->donneesModeles["pileModeles"]);
		
	}
	
	public function validerCommande() {
		
		$tabChoixMethodespaiement = $this->donneesModeles["tabChoixMethodespaiement"];
		
		
		if (	isset($_POST["methodpayment"])
			&&	!isset($tabChoixMethodespaiement[$_POST["methodpayment"]])
		) {
			// si la méthode de paiement n'est pas autorisé, choix par défaut
			$_POST["methodpayment"] = current($tabChoixMethodespaiement);
		}
		
		
		$msgCommand="";
		
		$TONMAIL=$this->getParam('email');
		$TON2EMEMAIL=$this->getParam('email_cc');
		$SHOPNAME=$this->getParam('shop_name');
		$COMMERCANTNAME=$this->getParam('commercant_name');
		$COMMERCANTPOSTCODE=$this->getParam('commercant_postcode');
		$COMMERCANTCITY=$this->getParam('commercant_city');
		$COMMERCANTSTREET=$this->getParam('commercant_street');
		
		//récupération de la liste des produit du panier
		$totalpricettc=0.00;
		$totalpoidg=0.00;
		$totalpoidgshipping=0.00;
		$productscart=array();
		if (isset($_SESSION['prods'])) {
			foreach ($_SESSION['prods'] as $k => $v) {
				$totalpricettc= ((float)$this->aProds[$v]['pricettc']+(float)$totalpricettc);
				$totalpoidg= ((float)$this->aProds[$v]['poidg']+(float)$totalpoidg);
				$productscart[$v]=array('pricettc' => $this->aProds[$v]['pricettc'],
										'poidg' => $this->aProds[$v]['poidg'],
										'name' => $this->aProds[$v]['name'],
										'device' => $this->aProds[$v]['device']
									);
			}
			$totalpoidgshipping = $this->shippingMethod($totalpoidg, 1);
		}
		
		#Mail de nouvelle commande pour le commerçant.
		$sujet = 'Nouvelle commande '.$SHOPNAME;
		$message = plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."<br />".
		plxUtils::cdataCheck($_POST['adress'])."<br />".
		plxUtils::cdataCheck($_POST['postcode'])." ".plxUtils::cdataCheck($_POST['city'])."<br />".
		plxUtils::cdataCheck($_POST['country'])."<br />".
		"Tel : ".plxUtils::cdataCheck($_POST['tel'])."<br /><br />".
		"Méthode de paiement : ".($_POST['methodpayment']=="paypal"?"Paypal":"Chèque").
		"<br>Liste des produits :<br /><ul>";
		foreach ($productscart as $k => $v) {
			$message.="<li>".$v['name']." ".$v['pricettc'].$v['device'].((float)$v['poidg']>0?" pour ".$v['poidg']."Kg":"")."</li>";
		}
		$message.="</ul><br /><br>".
		"<strong>Total (frais de port inclus): ".($totalpricettc+$totalpoidgshipping)."&euro;</strong><br />".
		"<em><strong>Frais de port : ".$totalpoidgshipping."&euro;</strong><br />".
		"<strong>Poids : ".$totalpoidg."kg</strong><br /><br /></em>".
		"Commentaire : <br>".plxUtils::cdataCheck($_POST['msg']);
		$destinataire = $TONMAIL.(isset($TON2EMEMAIL) && !empty($TON2EMEMAIL)?', '.$TON2EMEMAIL:"");
		$headers = "MIME-Version: 1.0\r\nFrom: \"".plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."\"<".$_POST['email'].">\r\n";
		$headers .= "Reply-To: ".$_POST['email']."\r\nX-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $_SERVER["REMOTE_ADDR"] . "\r\n";
		$headers .= "Content-Type: text/html;charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
		
		if (	(isset($_POST['email']) && $_POST['email']!="")
			&&	(isset($_POST['firstname']) && plxUtils::cdataCheck($_POST['firstname'])!="")
			&&	(isset($_POST['lastname']) &&  plxUtils::cdataCheck($_POST['lastname'])!="")
			&&	(isset($_POST['adress']) &&  plxUtils::cdataCheck($_POST['adress'])!="")
			&&	(isset($_POST['postcode']) &&  plxUtils::cdataCheck($_POST['postcode'])!="")
			&&	(isset($_POST['city']) && plxUtils::cdataCheck($_POST['city'])!="")
			&&	(isset($_POST['country']) && plxUtils::cdataCheck($_POST['country'])!="")
		) {
			
			if(mail($destinataire,$sujet,$message,$headers)){
				if ($_POST['methodpayment']=="paypal") {
					$msgCommand.= "<h2 class='h2okmsg' >La commande est confirmé et en cours de validation de votre par sur Paypal</h2>";
				} else if ($_POST['methodpayment']=="cheque") { 
					 $msgCommand.= "<h2 class='h2okmsg'>La commande a bien été confirmé et envoyé par email.</h2>";
				}
				
				#Mail de récapitulatif de commande pour le client.
				$sujet = 'Récapitulatif commande '.$SHOPNAME;
				$message = "<p>Vous venez de confirmer une commande sur <a href='http://".$_SERVER["HTTP_HOST"]."'>".$SHOPNAME."</a>".
				"<br>Cette commande est en ".($_POST['methodpayment']=="cheque"?"attente":"cours")." de règlement</p>";
				if ($_POST['methodpayment']=="cheque") {
					$message .="<p>Pour finaliser cette commande veuillez établir le chèque à l'ordre de : ".$COMMERCANTNAME."<br>Envoyer votre chèque à cette addresse :".
					"<br><em>&nbsp;&nbsp;&nbsp;&nbsp;".$SHOPNAME."".
					"<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTNAME."".
					"<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTSTREET."".
					"<br>&nbsp;&nbsp;&nbsp;&nbsp;".$COMMERCANTPOSTCODE." ".$COMMERCANTCITY."</em></p>";
				} elseif ($_POST['methodpayment']=="paypal") {
					 $message .="<p>Cette commande sera finalisé une fois le paiement Paypal contrôlé.</p>";
				}
				$message .= "<br><h1><u>Récapitulatif de votre commande :</u></h1>".
				"<br><strong>Addresse de livraison :</strong>".plxUtils::cdataCheck($_POST['firstname'])." ".plxUtils::cdataCheck($_POST['lastname'])."<br />".
				plxUtils::cdataCheck($_POST['adress'])."<br />".
				plxUtils::cdataCheck($_POST['postcode'])." ".plxUtils::cdataCheck($_POST['city'])."<br />".
				plxUtils::cdataCheck($_POST['country'])."<br />".
				"<strong>Tel : </strong>".plxUtils::cdataCheck($_POST['tel'])."<br /><br />".
				"<strong>Méthode de paiement : </strong>".($_POST['methodpayment']=="paypal"?"Paypal":"Chèque").
				"<br><strong>Liste des produits :</strong><br />";
				foreach ($productscart as $k => $v) {
					$message.="<li>".$v['name']." ".$v['pricettc'].$v['device'].((float)$v['poidg']>0?" pour ".$v['poidg']."Kg":"")."</li>";
				}
				$message.= "<br /><br>".
				"<strong>Total (frais de port inclus) : </strong>".($totalpricettc+$totalpoidgshipping)."&euro;<br />".
				"<em><strong>Frais de port : </strong>".$totalpoidgshipping."&euro;<br />".
				"<strong>Poids : </strong>".$totalpoidg."kg<br /><br /></em>".
				"<strong>Votre Commentaire : </strong><br>".plxUtils::cdataCheck($_POST['msg']);
				$destinataire = $_POST['email'];
				$headers = "MIME-Version: 1.0\r\nFrom: \"".$SHOPNAME."\"<".$TONMAIL.">\r\n";
				$headers .= "Reply-To: ".$TONMAIL.(isset($TON2EMEMAIL) && !empty($TON2EMEMAIL)?', '.$TON2EMEMAIL:"")."\r\nX-Mailer: PHP/" . phpversion() . "\r\nX-originating-IP: " . $_SERVER["REMOTE_ADDR"] . "\r\n";
				$headers .= "Content-Type: text/html;charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
				if(mail($destinataire,$sujet,$message,$headers)){
					$msgCommand.= "<h2 class='h2okmsg2'>Un email de récapitulatif de commande vous a été envoyé.</h2>";
					$msgCommand.= "<h2 class='h2okmsg3' >Si l'email de récapitulatif de commande n'apparait pas dans votre liste de mails en attente ou que celui-ci est signalé en tant que Spam. Veuillez ajouter \"".$TONMAIL."\" à votre liste de contacts.</h2>";
					if ( $_POST['methodpayment']== "paypal") include(PLX_PLUGINS.'plxMyShop/paypal_api/SetExpressCheckout.php');
					$nf=PLX_ROOT.'data/commandes/'.date("Y-m-d_H-i-s_").$_POST['methodpayment'].'_'.$totalpricettc.'_'.$totalpoidgshipping.'.html';
					$monfichier = fopen($nf, 'w+');
					$commandeContent="<!DOCTYPE html>
	<html>
	<head>
	<title>Commande du ".date("d m Y")."</title>
	<meta charset=\"UTF-8\">
	<meta name=\"description\" content=\"Commande\">
	<meta name=\"author\" content=\"plxMyShop\">
	</head>
	<body>
	$message
	</body>
	</html>";
					fputs($monfichier, $commandeContent);
					fclose($monfichier);
					chmod($nf, 0644);
					unset($_SESSION['prods']);
					unset($_SESSION['ncart']);
				}else{
					$msgCommand.= "<h2 class='h2nomsg'>Une erreur c'est produite lors de l'envoi de votre e-mail récapitulatif.</h2>";
				}
			}else{
				$msgCommand.= "<h2 class='h2nomsg'>Une erreur c'est produite lors de l'envoi de la commande par e-mail.</h2>";
				echo "<script type='text/javascript'>error=true;</script>";
			}
			
		} else {
			if ( (!isset($_POST['email']) || empty($_POST['email']) || $_POST['email']=="") ) {
				$msgCommand.= "<h2 class='h2nomsg'>l'addresse email n'est pas défini.</h2>";
			}
			
			if (  (!isset($_POST['firstname']) ||  plxUtils::cdataCheck($_POST['firstname'])=="") ) {
				$msgCommand.= "<h2 class='h2nomsg'>Le prénom n'est pas défini</h2>";
			}
			
			if ( (!isset($_POST['lastname']) ||  plxUtils::cdataCheck($_POST['lastname'])=="")  ) {
				$msgCommand.= "<h2 class='h2nomsg'>Le nom de famille n'est pas défini</h2>";
			}
			
			if ( (!isset($_POST['adress']) ||  plxUtils::cdataCheck($_POST['adress'])=="")  ) {
				$msgCommand.= "<h2 class='h2nomsg'>L'addresse n'est pas défini</h2>";
			}
			
			if ( (!isset($_POST['postcode']) ||  plxUtils::cdataCheck($_POST['postcode'])=="") ) {
				$msgCommand.= "<h2 class='h2nomsg'>Le code postal n'est pas défini</h2>";
			}
			
			if ( (!isset($_POST['city']) ||  plxUtils::cdataCheck($_POST['city'])=="") ) {
				$msgCommand.= "<h2 class='h2nomsg'>La ville n'est pas défini.</h2>";
			}
			
			if ( (!isset($_POST['country']) ||  plxUtils::cdataCheck($_POST['country'])=="") ) {
				$msgCommand.= "<h2 class='h2nomsg'>Le pays n'est pas défini.</h2>";
			}
			
			echo "<script type='text/javascript'>error=true;</script>";
		}
		
		$_SESSION['msgCommand']=$msgCommand;
	}
	
	
	function shippingMethod($kg, $op) {
		
		$accurecept = (float) $this->getParam('acurecept');
		
		if ($kg<=0) {
			$shippingPrice=0.00;
		} else if ((float)$kg<=$this->getParam('p01')) {
			$shippingPrice=$shippingPrice1;
		} else if ((float)$kg<=$this->getParam('p02')) {
			$shippingPrice=((float)$this->getParam('pv02')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p03')) {
			$shippingPrice=((float)$this->getParam('pv03')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p04')) {
			$shippingPrice=((float)$this->getParam('pv04')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p05')) {
			$shippingPrice=((float)$this->getParam('pv05')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p06')) {
			$shippingPrice=((float)$this->getParam('pv06')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p07')) {
			$shippingPrice=((float)$this->getParam('pv07')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p08')) {
			$shippingPrice=((float)$this->getParam('pv08')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p09')) {
			$shippingPrice=((float)$this->getParam('pv09')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p10')) {
			$shippingPrice=((float)$this->getParam('pv10')+$accurecept);
		} else if ((float)$kg<=(float)$this->getParam('p11')) {
			$shippingPrice=((float)$this->getParam('pv11')+$accurecept);
		} else {
			$shippingPrice=0.00;
		}
		
		return (float) $shippingPrice;
	}
}

