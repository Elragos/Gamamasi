<?php

// On indique qu'il s'agit de la page d'erreur 500
header('HTTP/1.0 500 Internal Server Error', true, 500);

// Indiquer le titre de la page
$this->pageTitle = "Erreur serveur";

// Indiquer le template à utiliser
$this->pageBody = __DIR__ . DIRECTORY_SEPARATOR . "content.tpl";