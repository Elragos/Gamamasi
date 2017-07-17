<?php

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "title" => "Test Lecture Table client",
    "clientResults" => Customer::loadAll()
);
