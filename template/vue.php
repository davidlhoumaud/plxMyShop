<?php if (!defined('PLX_ROOT')) exit;
$plxMotor = plxMotor::getInstance();
$plxPlugin = $plxMotor->plxPlugins->aPlugins[ rtrim($plxMotor->cible,'/') ];
$plxPlugin->vue->affichage();