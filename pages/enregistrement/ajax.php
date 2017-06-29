<?php

/* JP: peut-on cumuler les filtres de validation et de nettoyage via un OU logique ? est-ce utile ?
 * JP: revoir la longueur des champs dans la BDD
 */

$nom            = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_URL);
$prenom         = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_URL);
$identifiant    = filter_input(INPUT_POST, "identifiant", FILTER_SANITIZE_URL);
$password       = filter_input(INPUT_POST, "password", FILTER_SANITIZE_URL);
$password2      = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_URL);
$email          = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$raison_sociale = filter_input(INPUT_POST, "raison_sociale", FILTER_SANITIZE_URL);
$siret          = filter_input(INPUT_POST, "siret", FILTER_SANITIZE_URL);
$nom_dirigeant  = filter_input(INPUT_POST, "nom_dirigeant", FILTER_SANITIZE_URL);
$tel            = filter_input(INPUT_POST, "tel", FILTER_SANITIZE_URL);

//$date_naissance = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_URL);
$jour = $_POST["jour"];
$mois = $_POST["mois"];
$annee = $_POST["annee"]; 
$date_naissance = $annee.'-'.$mois.'-'.$jour;

$avatar         = filter_input(INPUT_POST, "avatar", FILTER_SANITIZE_STRING);
$adresse1       = filter_input(INPUT_POST, "adresse1", FILTER_SANITIZE_STRING);
$adresse2       = filter_input(INPUT_POST, "adresse2", FILTER_SANITIZE_STRING); // /!\ le filtre "FILTER_SANITIZE_URL" retire les espaces
$code_postal    = filter_input(INPUT_POST, "code_postal", FILTER_SANITIZE_URL);
$ville          = filter_input(INPUT_POST, "ville", FILTER_SANITIZE_STRING);

//var_dump($adresse1);
//var_dump($adresse2);
//var_dump($avatar);
var_dump($date_naissance);

//die();
//print_r($_POST);


/*
 *  JP: vérifications sur:
 *      - encodage des caractères car accent non pris en compte lors de l'insertion dans la BDD
 *      - champs vides ? (le "required" en html devrait suffire)
 *      - login déjà existant ou couple identifiant/email ou mail déja existant (peut-il exister 2 mails identiques pour 2 login différents: exemple d'une personne qui utilise le même mail pour se connecter en pro ou en particulier, acec des login différents ?)
 *      - match password/password2 (à crypter par la suite si succès du match)
 *      - destructions des variables en fin de traitement
*/
$tmp = $_SESSION["DB_MANAGER"]->exec(
    // param 1: requête préparée
    "INSERT INTO wam_client VALUES(
        default,
        :nom,
        :prenom,
        :identifiant,
        :password,
        :email,
        :raison_sociale,
        :siret,
        :nom_dirigeant,
        :tel,
        :date_naissance,
        :avatar,
        :adresse1,
        :adresse2,
        :code_postal,
        :ville,
        default)",
    // param 2: valeurs issues du formulaire
    array(
        "nom" => $nom,
        "prenom" => $prenom,
        "identifiant" => $identifiant,
        "password" => $password,
        "email" => $email,
        "raison_sociale" => $raison_sociale,
        "siret" => $siret,
        "nom_dirigeant" => $nom_dirigeant,
        "tel" => $tel,
        "date_naissance" => $date_naissance,
        "avatar" => $avatar,
        "adresse1" => $adresse1,
        "adresse2" => $adresse2,
        "code_postal" => $code_postal,
        "ville" => $ville
        //"time" => date("Y-m-d H:i:s")
    ),
    // param 3: true = lecture, false = écriture
    false);

var_dump($tmp);
var_dump($date_naissance);

die();

/*
$_SESSION["RENDER_MANAGER"]->pageDatas = array(
    "test" => "OK",
);

echo "coucou: espace client .do";
*/