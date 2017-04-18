<?php
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
// e-mail de la commande
$_SESSION["plxMyShop"]['msgCommand']="";
$d["plxPlugin"]->validerCommande();
$this->vue->affichageVuePublique($d["plxPlugin"]);