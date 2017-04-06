## PlxMyShop Change Log

##v0.13 06/04/2017##
* [+] Ajout du hook plxMyShopShowMiniPanier basé sur l'idée de WorldBot alias [ppmt](http://forum.pluxml.org/viewtopic.php?pid=53411#p53411)
* [+] Comptatible Multilingue 0.8 & pluxml 5.6 (worldBot)
* [+] Bouton produit : Ajouter, modifier et supprimer du panier (worldBot & swd) 
* [+] Panier : Retire Rouge, Valider Vert (worldBot)
* [+] Shortcode : Affiche au complet le produit (worldBot)
* [+] Lien Panier : Classe css product_priceimage -> basket_link_image
* [+] Produit : bouton déplacé sous l'image d'accroche
* [+] Templates d'exemple mis à jour et fonctionnel
* [+] Rapatriement de jquery (intégré en interne : public & admin)
* [+] Gestion des message 'basket is up to date' inside plugin & simplifié
* [-] Suppression du modele "espacePublic/ajoutProduit"

##v0.12 04/04/2017##
* [+] Panier : Style des message retour et largeur du tableau d'article mis a 100%
* [+] Panier localStorage : Si le client change ses coordonnées le bouton re-bascule sur "enregister"
* [+] Fichiers de langues Français & Anglais peaufinés + tentative d'occitan
* [+] Ajout des requis aux entrées du panier
* FIX : webkits X-XSS-Protection Content-Security-Policy

##v0.11.1 03/04/2017##
* [+] MyshopCookie intégré
* [+] Config : Switch to Switch
* [+] Panier : Boutons Save & Forget modifiés selon une idée de [ppmt](http://forum.pluxml.org/viewtopic.php?pid=53349#p53349)
* [+] Panier : Ajout d'un filtre ExpReg au champ courriel : pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" [src](https://blog.staffannoteberg.com/2012/03/01/html5-form-validation-with-regex/)
* [+] Courriel client dans le récapitulatif de commande (mailto)

##v0.11 02/04/2017##
Release

##v0.11b1 02/04/2017##
* FIX fichier langue fr suppression d'un <<<<<<HEAD oublié lors de la fusion 

##v0.11b + Panier dans le menu (worldBot) 02/04/2017##
* [+] Option d'ajouter ou non le lien vers le Panier dans le menu principal

##v0.11b 02/04/2017##
* FIX fichier langue fr : retour de ligne de rn(win) en n(tux)
* [+] Ajout des crochets suivant à panier.php (hook)
 + plxMyShopPanierDebut
 + plxMyShopPanierFormProdsDebut
 + plxMyShopPanierFormProdsFin
 + plxMyShopPanierProdsFin
 + plxMyShopPanierCoordsDebut
 + plxMyShopPanierCoordsMilieu
 + plxMyShopPanierCoordsFin
 + plxMyShopPanierFin
* [-] Sauvegarde locale des coordonnées du client au formulaire de commande déplacé dans le plugin MyShopCookie v0.2

v0.11a1 : Algo boucle des frais de ports config.php 

##v0.11a 31/03/2017##
* [+] Ajout de sauvegarde locale des coordonnées du client au formulaire de commande

##v0.10  18/03/2017##
* [+] Compatible PluXml 5.5, [5.6](https://github.com/pluxml/PluXml/releases/tag/5.6rc4)
* [+] Édition des produits compatible avec le plugin WymEditor et d'autres éditeurs (Changement de l'id form_produit VERS form_article)
* [+] Ajout du theme d'exemple static-boutique-produits-par-categories.php de Philippe Le Toquin : https://github.com/ppmt/plxMyShop/commit/411cc5e749fc53b9b2a54c064dd969d9f0c6db48
* [+] Intégration de dataTable.js pour l'affichage des commandes afin d'en simplifier le triage et les recherches
* [+] Ajout des nouvelles classes de pluCss et adaptation des boutons dans l'action-bar
* [+] Déplacement dans administration.css des styles html inside (dans le body) [template edit prod admin & ajax/select_img]
* [+] Ajout d'administration.css en javascript [config.php, template edit prod admin]
* [+] Ajout du nom du module en cour dans le titre de l'admin de la boutique
* [+] Complétion des fichiers de langues fr,en (manque quelques unes en occitan) 
* [+] Ré-indentation & Simplification du code (One Space Indent, boucles aux Frais De Ports, style, ...)
* FIX Champs du nombre de produits a commander (Possibilité d'en commander 0 ou -1 -2 -20 ...)
###### dans plxMyShop.php     
 - [ ] # //require PLX_PLUGINS . 'plxMyShop/classes/paypal_api/SetExpressCheckout.php'; c'est/était quoi?
 - [ ] require PLX_PLUGINS . 'plxMyShop/classes/paypal_api/boutonPaypalSimple.php'; (à tester)

##v0.9.9.0.dev  05/08/2016##
From develop branch of mathieu269 : [commit](https://github.com/davidlhoumaud/plxMyShop/commit/3f9df5b8656d989bec9827a9c0f2c477cf10758b)

##notes, todo & suggests 4 the future##
* affichage du shortcode dans les article
* $d = $this->donneesModeles; ($d == données modele)
* tester paypal
* Utiliser la gallerie de Media native de PluXml?
* Faire évoluer les formulaires d'édition de produit (compatible PluCss) et de commande (panier coté public)
* intégrer en interne? et/ou harmoniser jquery.dataTables & cdn
* "voir" une commande en mode smoothframe (avec jquery?)
* Vérifier comment il fonctionne sur pluxml <=5.4? (classes css pour la sidebar?)
* Verifier la récriture d'url (activé et ou avec MyBetterUrls)
* intégrer datatable.js pour la liste des produits et/ou des catégories de produits? (+comlexe)
* "voir" une commande en mode smoothframe (avec jquery?)

# Les Crochets (Hooks) du plugins 
      in plxMotorPreChauffageBegin() 
        eval($this->plxMotor->plxPlugins->callHook("plxMyShop_debut"));
      commentés pour le moment :
        in editProduct($content)
        # Hook Plugins
         //eval($this->plxPlugins->callHook('plxAdminEditProduct'));
        in plxShowProductInclude($id)
        # Hook Plugins
         //if(eval($this->plxMotor->plxPlugins->callHook('plxShowProductInclude'))) return ;