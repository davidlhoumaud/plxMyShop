<?php if (!defined('PLX_ROOT')) exit;
/*
Si vous réutilisez ce fichier dans votre thème, nous vous conseillons de noter la version actuelle de plxMyShop
version : 
*/
// e-mail de la commande
$_SESSION[$d["plxPlugin"]->plugName]['msgCommand']="";
$d["plxPlugin"]->validerCommande();
$this->vue->affichageVuePublique($d["plxPlugin"]);