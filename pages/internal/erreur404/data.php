<?php

// On indique qu'il s'agit de la page d'erreur 404
header('HTTP/1.0 404 Page Not Found', true, 404);

Config::get("RENDER_MANAGER")->pageDatas = array(
    // Indiquer le titre de la page
    "titre" => "Page Introuvable",
);
