<?php

// Créer un objet vide, pour création
$customer = new Customer("", "", "", "", "", null, new Address("", "", ""));

// Si on a un client en session
if (Customer::hasActiveSession()){
    $customer = Customer::getActiveSession();
}

$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    // Indiquer le titre de la page
    "title" => "Espace Client",
    "customer" => $customer
);
