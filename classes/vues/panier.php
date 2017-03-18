<?php
require_once dirname(__FILE__) . "/../VuePublique.php";
class panier extends VuePublique {
 public function traitementVuePublique() {
  $this->fichierAffichageVuePublique = "panier";
 }
 public function titreVuePublique() {
  return $this->plxPlugin->getLang("L_TITRE_PANIER");
 }
}