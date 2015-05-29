<?php

abstract class Vue {
	
	protected $titre;
	protected $fichierAffichage;
	
	public abstract function traitement();
	
	public abstract function titre();
	
	public function affichage($plxPlugin) {
		$plxPlugin->donneesModeles["plxPlugin"] = $plxPlugin;
		
		$plxPlugin->modele($this->fichierAffichage);
	}
	
}
