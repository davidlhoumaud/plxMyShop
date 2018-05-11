<?php if(!defined('PLX_ROOT')) exit; ?>

<p class="in-action-bar page-title">Aide du plugin plxMyShop</p>
<p style="color:orange"><i>Cette documentation est à compléter avec les fonctionnalités actuelles de l'extension.</i></p>
<h1><span>Sommaire</span></h1>
<ul>
 <li>
<p><span><a href="#2.Installation">Installation</a></span></p>
</li>
 <li>
<p><span><a href="#3.Configuration">Configuration</a></span></p>
</li>
 <li>
<p><span><a href="#4.Création d'un produit">Création d'un produit</a></span></p>
</li>
 <li>
<p><span><a href="#">Création d'une catégorie de produit</a></span></p>
</li>
 <li>
<p><span><a href="#">Liste des commandes</a></span></p>
</li>
</ul>
<h1><a name="2.Installation"></a><span>Installation</span></h1>
Extraire l'archive zip dans le répertoire <b>plugins</b> de pluxml.
Ensuite dans l'administration de pluxml dans le menu <b>Paramètres&gt;plugins</b>,
dans la section <b>Plugins inactifs</b>, coché et activer plxMyShop.
Une fois activé plxMyShop se trouvera dans la section <b>Plugins actifs</b>.

<h2>Afficher le mini panier dans votre thème</h2>
Editez le fichier template "sidebar.php". Ajoutez y le code suivant à l'endroit où vous souhaitez voir apparaitre le mini panier:</p>
<pre>
 &lt;?php eval($plxShow-&gt;callHook(&#039;plxMyShopShowMiniPanier&#039;)); ?&gt;
</pre>

<h1><a name="3.Configuration"></a><span>Configuration</span></h1>
Dans <b>Plugins actifs </b>ou<b> inactifs </b>cliquez sur <b>Configuration</b> de plxMyShop. Dans cette page vous pourrez configurer :
<ul>
 <li><a>les informations relatives au commerçant</a></li>
 <li><a>les modules paiement/livraison</a>
<ul>
 <li><a>Module de livraison (basé sur Socolissimo recommandé)</a></li>
 <li><a>Paypal</a></li>
</ul>
</li>
 <li><a>les </a><a>mails</a><a> de commande </a><a>pour le client et le commerçant</a></li>
 <li><a>la position dans le menu pour les catégories</a></li>
 <li><a>le template par défaut pour les pages produit et catégorie</a></li>
</ul>
<h2><a name="3.1.Informations relatives au commerçant"></a> Informations relatives au commerçant</h2>
Entrer dans les différents champs les informations d'adressage du commerçant utilisés en entre autres par le module chèque. Veuillez aussi renseigner le nom de la boutique.

<h2><a name="3.2.Modules paiement/livraison"></a> Modules paiement/livraison</h2>
Activer ou pas les modules de paiement/livraison désirés.
<h3><a name="3.2.1.Socolissimo Recommandé"></a> Socolissimo Recommandé</h3>
La configuration du module de livraison <del>Socolissimo Recommandé</del> est vraiment simple.

Une fois activé, il suffit d'indiquer dans le tableau les poids et les tarifs correspondant.
La particularité réside dans le fait que vous pourrez mettre à jour vos tarifications de livraison à la volé.
Il est possible qu'il y est un supplément de tarification si vous voulez recevoir l'accusé de réception.
Pour cela indiquer la somme dans le champs « Accuser de réception ».

Noté que ce module se base sur vos indications,
vous pourrez l'utiliser pour d'autre tarification de livraison
<i>(autre que Socolissimo recommandé)</i>

<h3><a name="3.2.1.Paypal"></a>Paypal</h3>
La configuration de Paypal nécessite que vous ayez 2 jeux d'identifiants commerçant,
un jeu pour la phase de test et l'autre pour la phase de mise en production. Ces identifiants comprennent
<ul>
 <li>Un identifiant commerçant</li>
 <li>Un mot de passe</li>
 <li>Une signature</li>
</ul>
Ensuite vous devrez renseigner les informations suivante :
<ul>
 <li>Code de devise, par défaut «EUR»</li>
 <li>Nom de description de la boutique</li>
 <li>Url <i>avec le HTTP </i>de retour</li>
 <li>Url <i>avec le HTTP </i>d'annulation</li>
 <li>Url <i>avec le HTTP </i>du retour automatique IPN</li>
 <li>Url <i>avec le HTTP </i>du logo de la boutique, par défaut le logo de plxMyShop</li>
 <li>le code couleur global de la page Paypal, par défaut #296899</li>
 <li>le code couleur des bordure de la page Paypal, par défaut #296899</li>
</ul>
<h2><a name="3.4.Template par défaut pour les pages produit"></a></h2>
<h2><a name="3.3.Mails de commande pour le client et le commerçant"></a>Mails de commande pour le client et le commerçant</h2>
Entrez les adresse mail utilisé pour recevoir les mails des commandes effectué. Vous pouvez aussi définir le titre de vos mails, pour le mail commerçant ainsi que celui du client.
<h2><a name="3.4.Position dans le menu pour les catégories"></a> Position dans le menu pour les catégories</h2>
Il est possible à la création d'une catégorie de l'afficher dans le menu principal du site.
Cette option vous permettra de définir sa position par défaut.
<h2>Template par défaut pour les pages produit et catégorie</h2>
Cette option vous permettra de définir le template utilisé par défaut par vos page de fiche produit et catégorie de produit.

<h1><a name="4.Création d'un produit"></a><span>Création d'un produit</span></h1>
Une fois plxMyShop d'activé, un nouveau menu apparaît dans l'administration de pluxml en dessous des pages statiques. Ce menu porte le nom de votre boutique ainsi que le numéro de version du plxMyShop

Dans ce menu en haut de page vous avez quatre boutons :
<ul>
 <li>Produits</li>
 <li>Catégories</li>
 <li>Commandes</li>
 <li>Configuration</li>
</ul>

Dans la liste des <b>produits</b>, pour créer un produit il suffit de faire la même chose que pour créer une page statique.
Renseigner le nom de votre produit, activez le ou pas et ensuite cliquer sur le bouton <b>Modifier la liste des produits</b>.
Une fois créé cliquer sur le lien <b>éditer</b> à la droite du produit pour accéder à sa page d'édition.
<br />
Dans la page d'édition du produit, veuillez renseigner le lien de l'image du produit, que le lien soit en relatif ou absolue ne pose aucun problème,
en utilisant le bouton vous pourrez directement choisir une image disponible dans votre zone de média.
Ensuite taper une description et renseignez le prix affiché du produit.
Faite de même pour le poids et la devise affichée.
Si le poids n'est pas renseigner ou égal à zéro il ne sera pas prix en compte.
Ensuite comme pour les pages statiques, veuillez renseigner le template utilisé et les informations des balise méta.

Cliquer sur le bouton <b>Enregistrer ce produit</b>.

Pour visualiser le produit dans la partie publique de votre site,
cliquer sur le lien <b>VOIR</b> à coté du lien <b>Éditer</b> à droite de chaques produits de la liste.

<h1><a name="5.Création d'une catégorie de produit"></a>Création d'une catégorie de produit</h1>
A quelques détails près le processus de création est exactement le même que celui d'un produit.

Pour attribuer un produit à une catégorie,
il vous suffira de cocher la/les catégorie(s) en question dans le champs «ID catégorie »  du listing des produits.

Comme indiquer plus haut, vous avez la possibilité d'afficher vos catégories dans le menu principal du site.

<h1><a name="6.Liste des commandes"></a>Liste des commandes</h1>
La liste des commandes vous permettra d'avoir un visuel rapide des commandes effectuées.
Vous pourrez les supprimer et/ou voir le mail envoyé au client.
<i>(je compte l'améliorer dans le futur)</i>
