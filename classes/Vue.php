<?php

abstract class Vue {
	
	protected $titre;
	protected $fichierAffichage;
	
	public $plxPlugin;
	
	
	public abstract function traitement();
	
	public abstract function titre();
	
	public function affichage() {
		$this->plxPlugin->donneesModeles["plxPlugin"] = $this->plxPlugin;
		
		$this->plxPlugin->modele($this->fichierAffichage);
	}
	
}
