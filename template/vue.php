<?php if (!defined('PLX_ROOT')) exit;
$plxMotor = plxMotor::getInstance();
$plxPlugin = $plxMotor->plxPlugins->aPlugins[$plxMotor->cible];
$plxPlugin->vue->affichage();