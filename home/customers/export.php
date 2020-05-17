<?php
// Activation des sessions
session_start();

require_once "../../lib/factory/PDOFactory.php";
require_once "../../lib/managers/CompanyManager.php";
require_once "../../lib/managers/AddressManager.php";
require_once "../../lib/managers/CityManager.php";
require_once "../../lib/managers/UserManager.php";

$filename = "export_customers_".date("d-m-Y");
header("Content-Type: text/plain");
header("Content-disposition: attachment; filename=".$filename.".csv");

$fp = fopen("php://output", 'w');
// Insertion UTF-8
fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

// Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

// Création du manager de user
$userManager = new UserManager($bdd);

// Sécurité
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['id_user'] > 0) {
        $user = $userManager->get($_SESSION['id_user']);
    } else {
        header("Location: ../../error403.php");
    }
} else {
    header("Location: ../../error403.php");
}

// Création des managers
$companyManager = new CompanyManager($bdd);
$addressManager = new AddressManager($bdd);
$cityManager = new CityManager($bdd);


$customers = $companyManager->getCustomerList();

$header = "";
$header .= "Nom".";";
$header .= "Adresse_1".";";
$header .= "Adresse_2".";";
$header .= "Ville".";";
$header .= "Code_postale".";";
$header .= "E-mail".";";
$header .= "Telephone".";";
$header .= "Siren".";";
$header .= "Siret".";";
$header .= "\n";
fputs($fp, $header);

foreach ($customers as $customer) {
    $addressManager = new AddressManager($bdd);
    $cityManager = new CityManager($bdd);
    $companyAddress = $addressManager->get($customer->get('id_address'));
    $city = $cityManager->get($companyAddress->get('id_city'));

    $line = "";
    $line .= $customer->get('name').";";
    $line .= $companyAddress->get('address_1').";";
    $line .= $companyAddress->get('address_2').";";
    $line .= $city->get('name').";";
    $line .= $city->get('postal_code').";";
    $line .= $companyAddress->get('email').";";
    $line .= $companyAddress->get('phone').";";
    $line .= $customer->get('siren').";";
    $line .= $customer->get('siret').";";
    $line .= "\n";
    fputs($fp, $line);
}

fclose($fp);
die;