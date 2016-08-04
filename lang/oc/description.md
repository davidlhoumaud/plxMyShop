# plxMyShop version 1 del ../08/2016

## Una botiga en linha per PluXML

Aquesta extension al còdi d'origina liure fornís las fonccionalitats seguentas : 
- lista dels produits classats per categoria
- camps del produit : imatge, descripcion, prètz, pes
- pagament per chèc, virament o Paypal
- calcul dels fraisses de pòrt segon lo pes
- corrièls al client e al vendeire per cada comanda
- acorchis per plaçar lo boton `Ajutar al panièr` d'un produit dins una pagina estatica

Exemples de sites qu'emplegan plxMyShop : 
- https://longslowbakery.co.uk/
- http://institut-perle-de-beaute.fr/

## Personalizacion

Cada produit e cada categoria pòdon emplegar un modèl de pagina estatica diferent.
Traparatz tanben dins lo repertòri `exemplesTemplate`, d'exemples de modèls per afichar sus una sola pagina tots los produits o la lista de las categorias de la botiga.

Per de modificacions mai importantas, podètz subrecargar tots los fichièrs del repertòri `modeles` amb un ficièr plaçat dins lo tèma.
Per exemple per modificar lo fichièr `espacePublic/boucle/produitRubrique.php` qu'es un resumit del produit dins la rubrica : 
1. a la raiç del tèma, creatz un repertòri `modeles/plxMyShop/espacePublic/boucle`
2. copiatz lo fichièr de basa dins lo repertòri en daissant lo meteis nom
3. podètz ara modificar lo fichièr del tèma que serà emplegar automaticament quand aqueste tèma es activat

## Assisténcia

Per qual que siague question tocant l'utilizacion de l'extension, podètz anar sus aquesta discussion sul forum de PluXML :  
http://forum.pluxml.org/viewtopic.php?id=4854

Traparatz las modificacions aportadas per las diferentas versions dins lo fichièr seguent :  
https://github.com/davidlhoumaud/plxMyShop/blob/develop/lang/fr/versions.md

## Contribucions

Podètz contribuïr al projècte de mantun manièra : 
- En nos ajudant a tenir las traduccions a jorn o ben en prepausant una novèla lenga :  
https://github.com/davidlhoumaud/plxMyShop/labels/traduction
- En corregissent des errors de còdi o en codant de novèlas fonccionalitats :  
https://github.com/davidlhoumaud/plxMyShop/labels/question
