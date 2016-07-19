# plxMyShop version 1 du ../08/2016

## Une boutique en ligne pour PluXML

Cette extension au code source libre fournit les fonctionnalités suivantes : 
- liste de produits classés par catégorie
- champs du produit : image, description, prix, poids
- paiement par chèque, virement ou Paypal
- calcul des frais de port en fonction du poids
- e-mails au client et au vendeur à chaque commande
- shortcode pour placer le bouton `Ajouter au panier` d'un produit dans une page statique

Exemples de sites utilisant plxMyShop : 
- https://longslowbakery.co.uk/
- http://institut-perle-de-beaute.fr/

## Personnalisation

Chaque produit et chaque catégorie peut utiliser un template de page statique différent. 
Vous trouverez aussi dans le répertoire `exemplesTemplate`, des exemples de template pour afficher sur une seule page tous les produits ou la liste des catégories de la boutique.

Pour des modifications plus importantes, vous pouvez surcharger tous les fichiers du répertoire `modeles` avec un fichier placé dans le thème. 
Par exemple pour modifier le fichier `espacePublic/boucle/produitRubrique.php` qui présente un résumé du produit dans la rubrique : 
1. à la racine du thème, créez un répertoire `modeles/plxMyShop/espacePublic/boucle`
2. copiez le fichier de base dans le répertoire en laissant le même nom
3. vous pouvez maintenant modifier le fichier du thème qui sera pris en compte automatiquement quand ce thème est activé

## Support

Pour toute question concernant l'utilisation de l'extension, vous pouvez vous rendre dans cette discussion sur le forum de PluXML :  
http://forum.pluxml.org/viewtopic.php?id=4854

Vous trouverez les modifications apportées par les différentes versions dans le fichier suivant :  
https://github.com/davidlhoumaud/plxMyShop/blob/develop/lang/fr/versions.md

## Contributions

Vous pouvez contribuer au projet de différentes façons : 
- En nous aidant à tenir les traductions à jour ou bien en proposant une nouvelle langue :  
https://github.com/davidlhoumaud/plxMyShop/labels/traduction
- En corrigant des erreurs de code ou en codant des nouvelles fonctionnalités :  
https://github.com/davidlhoumaud/plxMyShop/labels/question

