## PlxMyShop Change Log (incompatible 5.2 (inexistance du dossier 'media' a l'époque c'était 'images')

##si vous utilisez Multilingue, faite en sorte qu'il soit avant MyShop (sinon il a un temps de retards, il traduit le plug la page d'après ;)

##notes, todo & suggests 4 the future##
* Pourquoi s'affiche "Cette page est actuellement en cours de rédaction" coté public dans une catégorie? Solution: Éditer au moins une fois la catégorie de produit. Et/ou ajouter le texte et/ou l'image pour égayer ;)
? Bizarre que cela soit le même shortcode pour les prods et les catégorie ::: prod002: [boutonPanier 002], cat001: [boutonPanier 001] [pour les categories cela affiche une vignette produit et permet même de l'ajouter au panier, qui se fait avoir, le produit "catégorie"]
* $d = $this->donneesModeles; ($d == données modele)
* tester paypal
* Utiliser la gallerie de Media native de PluXml?
* Faire évoluer les formulaires d'édition de produit (compatible PluCss) et de commande (panier coté public)
* intégrer en interne? et/ou harmoniser jquery.dataTables & cdn
* Vérifier comment il fonctionne sur pluxml <=5.4? (classes css pour la sidebar?) ::: v0.13 (tout semble ok)
* Verifier la récriture d'url (activé et ou avec MyBetterUrls)
* intégrer datatable.js pour la liste des produits et/ou des catégories de produits? (+comlexe)
* "voir" une commande en mode smoothframe (avec jquery?)
* Une boutique par utilisateur?
* Ajout de noscript pour avertir l'internaute (panier! et bouton produit) par ex: Afin de poursuivre et validé la commande, veuillez s'il vous plaît activer le javascript de votre navigateur.
* Peaufiner l'aide

****
* Si jamais configuré : petit BUG Config PAYPAL et frais de port (JavaScript), le panneau est caché. Se régle en jouant avec le l'interupteur ou après la premiere config enregistrée tout rentre dans l'ordre ;)

****
* Attention a l'utilisation de plxMultilingue : si vous le réglez pour avoir un dossier de media par langue (après avoir créé des produits avec image), il y perte de l'image du produit pour toute les langues! 
** Solution de fortune: Placer une image avec le "même nom de fichier" dans chaque dossiers media/[lang] et elles s'afficheront (cela permet une image du produit par langue)

****
* Attention Frais de port, si au dela de votre config ils deviennent zéro (bug)

**** (theme default 5.6)
* Sur chrom(e)ium, s'il y a un souci de grosseur de characteres (gros boutons), en trifouillant les réglages du zoom de chrome tout est rentré dans l'ordre ;) (font size: medium, zoom: 100%) ::: [Huge font in Chrome 37](https://productforums.google.com/forum/?_escaped_fragment_=topic/chrome/17kfuau1ApM#!topic/chrome/17kfuau1ApM)

BUG les drapeaux le multilingue disparaissent au panier, mais sont présent dans catégories & produits ;)
BUG l'option "afficher le bouton ajouter au panier" ne fonctionne pas, si à non, l'affiche quant même ::: la changer pour le lien panier. Est-ce important?
Bug "J'ai lu et j'accepte les conditions générales de vente." reste en français ainsi que le selecteur du mode de paiement (alors que tout le panier est en anglais), il prend la phrase de la config ;)
Bug Si le produit est désactivé ou supprimé et qu'il est enregistré dans le cookie paner du client, il possible de le(s) commander quant-même. (Vérifier si le(s) produit(s) du cookie sont encores disponibles a la vente)

dire a l'utilisateur que le panier s'affiche que si javascript est activé (boutons la boutique)
le plugin spxplugdowloader provoque la perte de l'action bar au plugin qui ont un admin.php (vue avec plx5.4 & maybe after)

##v0.13.1b4 16/04/2017##
* [+] Admin : Utilisation du selecteur d'image natif à PluXml (Yannic)
* Fix Config : texte d'exemple des champs de l'emplacement des données placeholder
* Fix menu barre d'action : boutons valide Xhtml 

##v0.13.1b3 15/04/2017##
* [+] Public : panier.css transferé dans site.css, Nettoyage des javascripts & jquery en Vanilla
* [+] Admin : ajout des options du choix de l'emplacement des dossiers de données + langues (fr, en) (Yannic)
* [+] Admin : ajout de l'option Afficher le lien votre panier \_/ en haut des pages produits et catégories
* [+] Admin : libajax.js appelé uniquement dans l'édition de produit et de catégorie
* [+] Bouton paypal : Nettoyage & jquery en vanilla js
* [+] Lang English : Modify basket to Update the basket
* Fix : Sélecteur du mode de paiement 100% de large. Ajout de l'id #methodpayment et réglé en css avec width:auto;
* Fix : Admin Html : erreur de '/' au 1er form & input hors d'élément du tableau & &amp;
* [-] panier.css supprimé

##v0.13.1b2 13/04/2017##
* [+] Possibilité d'utiliser les shortcode dans les page du blog (articles)
* [+] Admin : Titres dans la barre d'action (5.4+)
* [+] Admin : Édition d'un produit, si image est changée, elle s'affiche. (Penser en enregistrer pour rendre effectif le changement)
* [+] Public : Élargissement des affichettes produits, le 'remove from basket' dépasse a droite. (25% to 30%)
* [+] Public : Lors de modif du panier par la vignette, revenir sur celle-ci (testé aussi sur chrome)
* Fix : Multilingue perte de la langue en cours : Hook mini panier (Yannic) & appliqué aux endroits en conséquence.
* Fix : décalage symbole monétaire
* Fix : Double slash : appel des thèmes et dans l'url des images (avertir l'utilisateur d'éviter le premier slash ***a faire?)

##v0.13.1b 11/04/2017#
* Fix : Si utilisation shortcode (noJs bouton panier et message) : hook ThemeEndBody quant shortcode actif & clean
* Fix : Afficher le poids d'un produits inférieur à 1 kg (yannic)
* Fix : Cookie n'est pas toujours initialisé lors de la première session. hook plxMotorConstruct vers le hook Index (MyShopCookie) (yannic)
* Fix : Balise de fermeture script (yannic)

##v0.13.1a 07/04/2017#
* [+] Admin : Avertir l'utilisateur si le courriel d'envoi du plugin est non configuré ou si le fichier de langue est absent (inspiré de plxMyContact)
* [+] Responsive : Meilleure adaptabilité des boutons et des liens avec l'action-bar adaptative de PluXml 5.6 (rétrocompatible avec 5.4 & 5.5)
* [+] Sélecteur d'image du produit retravaillé et en position absolue
* Fix : Espace superflu entre et dans les boutons du menu (apparaît _ entre les boutons)

##v0.13 06/04/2017##
* [+] Ajout du hook plxMyShopShowMiniPanier basé sur l'idée de WorldBot alias [Yannic](http://forum.pluxml.org/viewtopic.php?pid=53411#p53411)
* [+] Compatible Multilingue 0.8 & pluxml 5.6 (worldBot)
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