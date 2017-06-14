<?php

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_URL);
$tmp = $_SESSION["DB_MANAGER"]->exec("UPDATE wam_client SET timestamp_creation_fiche = :time WHERE id = :id", array(
    "time" => date("Y-m-d H:i:s"),
    "id" => $id
), false);

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    "done" => $tmp == 1,
);
