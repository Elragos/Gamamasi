<?php

// Indiquer le titre de la page
$this->pageTitle = "Test Erreur serveur";

// Indiquer le template à utiliser
$this->pageBody = __DIR__ . DIRECTORY_SEPARATOR . "content.tpl";

throw new Exception("Test erreur serveur");