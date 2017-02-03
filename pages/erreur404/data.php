<?php

// On indique qu'il s'agit de la page d'erreur 404
header('HTTP/1.0 404 Page Not Found', true, 404);

// Indiquer le titre de la page
$this->pageTitle = "Page Introuvable";

// Indiquer le template à utiliser
$this->pageBody = __DIR__ . DIRECTORY_SEPARATOR . "content.tpl";