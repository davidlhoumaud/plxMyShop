<?php

require_once dirname(__FILE__) . "/Vue.php";


abstract class VuePublique extends Vue {
	
	protected $fichierAffichageVuePublique;
	
	public abstract function traitementVuePublique();
	public abstract function titreVuePublique();
	
	public function traitement() {
		$this->traitementVuePublique();
		
		$this->fichierAffichage = "vuePublique";
	}
	
	public function titre() {
		return $this->titreVuePublique();
	}
	
	public function affichageVuePublique($plxPlugin) {
		$plxPlugin->modele("espacePublic/{$this->fichierAffichageVuePublique}");
	}
	
}
