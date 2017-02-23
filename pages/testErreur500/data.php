<?php

global $renderManager;

$renderManager->pageDatas = array(
    // Indiquer le titre de la page
    "title" => "Test Erreur serveur",
);

throw new Exception("Test erreur serveur");