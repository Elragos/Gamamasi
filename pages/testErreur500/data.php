<?php

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Test Erreur serveur",
);

throw new Exception("Test erreur serveur");