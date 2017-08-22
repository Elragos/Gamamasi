<?php

// On indique qu'il s'agit de la page d'erreur 500
header('HTTP/1.0 500 Internal Server Error', true, 500);

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Erreur serveur",
);
