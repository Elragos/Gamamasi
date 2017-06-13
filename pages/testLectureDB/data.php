<?php

$clients = $_SESSION["DB_MANAGER"]->exec("SELECT * FROM wam_client");

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "title" => "Test Lecture Table client",
    "clientResults" => $clients
);
