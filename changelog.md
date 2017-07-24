## PlxMyShop Change Log (incompatible 5.2 (inexistance du dossier 'media' a l'époque c'était 'images')

##si vous utilisez Multilingue, faite en sorte qu'il soit avant MyShop (en 1er) (sinon il a un temps de retards, il traduit le plug la page d'après ;)

##notes, todo & suggests 4 the future##
* Pourquoi s'affiche "Cette page est actuellement en cours de rédaction" coté public dans une catégorie? Solution: Éditer au moins une fois la catégorie de produit. Et/ou ajouter le texte et/ou l'image pour égayer ;)
* Un Noscript avertit l'internaute au panier (et bouton produit?).
? Admin : Faire en sorte que l'onglet de la langue en cours soit activé lors de l'édition (option)?
? Bizarre que cela soit le même shortcode pour les prods et les catégorie ::: prod002: [boutonPanier 002], cat001: [boutonPanier 001] [pour les categories cela affiche une vignette produit et permet même de l'ajouter au panier, qui se fait avoir, le produit "catégorie"]
* $d = $this->donneesModeles; ($d == données modele)
* tester paypal
* Vérifier comment il fonctionne sur pluxml <=5.4? (classes css pour la sidebar?) ::: v0.13 (tout semble ok)
* Récriture d'url Verifié (activé et avec MyBetterUrls.1.5.5)
* intégrer datatable.js pour la liste des produits et/ou des catégories de produits? (+comlexe)
* Une boutique par utilisateur?
* Peaufiner l'aide
* kw, meta & title en MyMultilingue

****
* Si jamais configuré : petit BUG Config PAYPAL et frais de port (JavaScript), le panneau est caché. Se régle en jouant avec le l'interupteur ou après la premiere config enregistrée tout rentre dans l'ordre ;)

****
* Attention a l'utilisation de plxMultilingue : si vous le réglez pour avoir un dossier de media par langue (après avoir créé des produits avec image), il y perte de l'image du produit pour toute les langues! 
** Solution de fortune: Placer une image avec le "même nom de fichier" dans chaque dossiers media/[lang] et elles s'afficheront (cela permet une image du produit par langue)

****https://www.colissimo.entreprise.laposte.fr/fr/faq-technique
* Attention Frais de port, si au dela de votre config il y a une règles qui calcule approximativement le tarif et le client est avertit)

**** (theme default 5.6)
* Sur chrom(e)ium, s'il y a un souci de grosseur de characteres (gros boutons), en trifouillant les réglages du zoom de chrome tout est rentré dans l'ordre ;) (font size: medium, zoom: 100%) ::: [Huge font in Chrome 37](https://productforums.google.com/forum/?_escaped_fragment_=topic/chrome/17kfuau1ApM#!topic/chrome/17kfuau1ApM)

BUG les drapeaux le multilingue disparaissent au panier, mais sont présent dans catégories & produits, ben non, c'était dans la sidebar (en full-width elle n'y est pas) ;-)
le plugin spxplugindowloader.2.5 provoque la perte de l'action bar aux plugins qui ont un admin.php (vu avec plx5.4 & maybe after)

Effet de bord : si on ajoute un shortCode [boutonPanier ###] a un prod/cat et que le panier est sur toutes les pages (il s'affiche 2 fois (av et aprés le form de commande)?????

##v0.13.1r4s 24/07/2017##
[+] Ajout d'un systeme de stock (basé sur une idée de ppmt) :utilise le nouveau hook plxMyShopEditProductBegin:: si le nombre de produits en stock est présent et que le client commande la totalité, automatiquement le produit se rend indisponible et le bouton "ajouter au panier" est remplacé par votre texte paramétré avec "produit indisponible" sur oui (d'origine "En rupture de stock").
[+] Ajout du hook plxMyShopEditProductBegin
[+] Ajout du hook plxMyShopEditProduct

##v0.13.1r4 11/06/2017##
[+] Fins de lignes unifiées par dos2unix (merci Bazooka)
[+] Config & panier : Montant minimum pour afficher le choix du paiement par Paypal (contrib ppmy)
[+] Config & panier : choix de date et heure de livraison (contrib ppmy)
[+] get_class() et plug['name'] remplacé par plugName

##v0.13.1r3 11/05/2017##
* [+] Appel des hook selon l'espace en cours (public ou admin)
* [+] hard coded plxMyShop vers get_class() pour simplifier le changement de nom
* [+] Fonction nomProtege($nomProduit) remplacé par plxUtils::strCheck()
* Fix le titre (prod/cat) optionnel n'est pas affiché (réécriture du hook plxShowPageTitle + Ajout de "Votre panier" a la balise du titre)
* Fix manque les metas prod & cat (keyWords & desc) : Ajout du hook plxShowMeta dans plxShow->meta($meta='')
* [+] Avertir dans les courriels de commandes (admin et client) qu'il est détecté que "Le montant des frais de port (sont) peut être (à) réévalué."
* [+] Config & Édition : meilleure adaptibilité sur petits et grands écrans (table -> grid pour les interrupteurs oui/non, l'attribut size supprimé aux inputs text, tabs: 1px border-bottom & image prod/cat responsive)
* [+] Édition : Lien "Visualiser le prod/cat sur le site" dans l'action bar & Message retour de sauvegarde amélioré.
* [+] Option config : Utiliser le libellé des C.G.V. (nom du lien) fournit par My Shop (si traduit dans la langue et plxMyMultilingue actif) ::: Fix "J'ai lu et j'accepte les conditions générales de vente." reste en français ainsi que le selecteur du mode de paiement (alors que tout le panier est en anglais), il prend la phrase de la config ;)
* [+] Option config : L'url des C.G.V. est réécrite par le moteur de PluXml pour une prise en compte du changement de langue (si plxMyMultilingue actif)
* [+] Nouveau formulaire de commandes client (html, js & css simplifié) ::: Faire évoluer les formulaires de commande (panier coté public) (compatible PluCss)
* Fix Panier : minimum de produit limité a 0
* Fix Panier : Si erreur d'envoi des courriels, commentaires & conteneurNomCadeau non gardé et réaffiché
* Fix Courriel de commande : La methode de paiement "cash" est transformé en "chèque"
* [+] Nouvelle icône du plugin et du mini panier. Info: Pour retrouver l'iĉône originale, renommé icon.origin.png en icon.png ;) 
* [+] Admin : Ajout d'une icône a l'option Produit Indisponible (nouvelle "cacher le bouton ajout au panier") pour voir son état d'un coup d'oeil (liste et produit)
* Fix Public : Si bouton "ajouter au panier" est caché, faire en sorte de sortir le produit du panier (si dans la session existante (cookie) le produit est présent)
* [+] Fixé & Amélioré option "cacher le bouton ajouter au panier" + L_NOTICE_NOADDCART ::: #1 l'option "cacher le bouton ajouter au panier" ne fonctionne pas, si à oui, l'affiche quant même ::: la changer pour le lien panier. Est-ce important? #1 idée de texte: ce produit est indiponible et en cours de réaprovisionement
* [+] Ajout de la redirection 301 de PluXml 5.6 en son seing pour gardé la compat 5.4+
* Fix Mauvaise redirection product2/index.php & product3/index.php
* Fix Panier : Warning division / 0 si ligne de frais de ports non configuré & Prevenir si erreur de réglage des frais de port (client & admin)
* Fix Érreur responsive en mode mobile pour le lien voir, (2 clics pour afficher la lightbox featherlight) ::: Featherlight: no content filter found  (no target specified)
* Fix Lignes max : Config Frais de port (impossible au dela de 99 lignes)
* Fix Bad id's : Admin edit thumbnail image

##v0.13.1r2 28/04/2017##
* [+] Option Config : nombre de ligne de configurations des Frais de port
* [+] Option Config : [Frais de port suivant le montant de la commande](http://forum.pluxml.org/viewtopic.php?pid=53688#p53688)
* [+] Admin : Ordre des commandes, les dernières en premières + big locals updates js/css + adaptative au petits écrans ::: intégrer en interne? et/ou harmoniser jquery.dataTables & cdn
* [+] Admin : Voir les commandes dans une lightbox iframe [featherlight](http://noelboss.github.io/featherlight/) ::: "voir" une commande en mode smoothframe (avec jquery?)
* [+] Core des messages de Commandes simplifié et amélioré (il y avait des parties commune aux 2 messages + backup)
* Fix float number

##v0.13.1r1 27/04/2017##
* Fix SHIPMAXWEIGHT ::: si dépassement de proids prévu au maximum de la config (calcul approximatif du prix est appliqué aux frais de port et le client en est avertit par un message en rouge dans le formulaire de commande
* [+] Config hook gratuité des frais de port** : options SHIPFREEWEIGHT & SHIPFREEPRICE ::(laisser vide pour le(s) désactivé(s)):: Frais de port gratuit si superieur ou égale a tel poids et/ou superieur ou égale a tel prix (ttc)
* [+] Hook **plxMyShopShippingMethod amélioré, affiche les chiffres pour dire au client a partir d'où les frais de port lui sont offerts 
* [+] Ajout du prix total TTC dans la fonction ShippingMethod pour amélioré l'utilité du hook plxMyShopShippingMethod
* [+] Hook plxMyShopShippingMethod dépacé pour avoir la possibilité de modifier le prix de base des frais de port
* [+] Formulaire PayPal Multilingue
* fix when display basket ::: Undefined property: plxMyShop::$plxPlugins && Fatal error: Call to a member function callHook()

##v0.13.1r 26/04/2017##
* [+] Possibilité d'ajouter un sous-menu dédié a la boutique groupant les catégories et le panier (Yannic)
* [+] Ajout du hook plxMyShopShippingMethod pour avoir la possibilité de modifier les frais de port
* [+] Formulaires d'édition de produit & config compatible grille PluCss1.2
* [+] dire a l'utilisateur que le panier s'affiche que si javascript est activé (boutons la boutique)
* [+] Compatible avec les fonctions de plxMyMultilingue 0.8.1 (remove personal tests jobs)
* Fix zéros superflus dans urls et ancres & espace entre devise non attendu (Yannic) ::: bug? les url sont non claire, et permettent de basculer d'une url a l'autre (attention au DC de GG) ::: produit (mauvaise redirection, ou pas, si par exemple product 2 est une catégorie alors que l'on cherche un produit atterrit sur une catégorie, et l'url n'est pas réécrite, c'est pareil avec les catégories => prod) 


##v0.13.1b6 20/04/2017##
* [+] Contenu des produits compatible Mulitilingue.0.8.1 (Yannic)
* [+] Admin : Grille PluCss
* [+] Public : Anglais bouton trop large (Remove from basket => Remove of basket)
Éditeurs compatible: 
 100%: plxToolbar.1.4.1
 onglet de la langue en cour: CKEditor.4.6.2 et WymEditor.1.1.2

##v0.13.1b5 18/04/2017##
* [+] Plus joli (Yannic)
* [+] Ajout d'un bouton au mini paniers pour enlever les produits (hook plxMyShopShowMiniPanier)
* [+] Ajout des liens produits aux paniers
* [+] panier.php : Js en ligne déplacé dans une fonction interne du plugin et utilise le hook plxMyShopPanierFin
* [+] Améliorer l'adaptibilité sur les petit écrans, listes + ajout des liens sur l'id pour éditer & ajout du titre "voir" dans le fichier de langue
* Fix : Enlever les produits du panier qui ont été supprimés/désactivés entre temps
* FiX : Utiliser plxMotor déja instancié dans la fonction "modele"
* Fix : Si l'url de la catègorie & produit est inexistante, aucune redirction 404!
* Fix : Texte d'exemple des champs de l'emplacement des données, placeholder pour 5.4, 5.5 & 5.6 (fonction printInput)
* Fix : noscript sur toutes les pages de l'admin 

##v0.13.1b4 16/04/2017##
* [+] Admin : Utilisation du selecteur d'image natif à PluXml (Yannic) minimum compat media system 5.4
* Fix : Config : texte d'exemple des champs de l'emplacement des données placeholder (5.6 only)
* Fix : Admin : Menu barre d'action : boutons valide Xhtml 

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
