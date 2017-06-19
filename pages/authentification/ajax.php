<?php

//$nom =$id = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_URL);

//var_dump($nom);
//die();

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    "test" => "OK",
);

echo "coucou: authentification.do";
