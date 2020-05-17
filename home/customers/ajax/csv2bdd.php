<?php
require_once "../../../lib/factory/PDOFactory.php";
require_once "../../../lib/Company.class.php";
require_once "../../../lib/Address.class.php";
require_once "../../../lib/City.class.php";
require_once "../../../lib/managers/CompanyManager.php";
require_once "../../../lib/managers/AddressManager.php";
require_once "../../../lib/managers/CompanyTypeManager.php";
require_once "../../../lib/managers/CityManager.php";
require_once "../../../lib/utils/HtmlTools.php";
require_once "../../../config.php";

// Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

// Création du manager des clients / adresses / villes / et des types
$companyManager = new CompanyManager($bdd);
$addressManager = new AddressManager($bdd);
$companyTypeManager = new CompanyTypeManager($bdd);
$cityManager = new CityManager($bdd);

// Création du manager de type d'entreprise : on veut les clients
$companyTypeManager = new CompanyTypeManager($bdd);
$customerTypeId = $companyTypeManager->getIdByTypeName(CUSTOMER_TYPE);
$fieldNumbers = 8;

// On récupère les données du CSV
$customersFromFile = $_POST['customers'];
$customersArray = json_decode($customersFromFile);

// On supprime l'en-tête
array_shift($customersArray);

foreach ($customersArray as $index => $customerData) {
    if (count($customerData) < $fieldNumbers) {
        $errorMessage = "<div class='alert alert-danger' role='alert'>";
        $errorMessage .= "Ligne n° ".($index + 1)." : vide ou incomplête !";
        $errorMessage .= "</div>";
        echo $errorMessage;
        continue;
    }

    echo "Nom : ".$customerData[0].
         " | Adresse 1 : ".$customerData[1].
         " | Adresse 2 : ".$customerData[2].
         " | Code postale : ".$customerData[3].
         " | E-mail : ".$customerData[4].
         " | Telephone : ".$customerData[5]."<br>".
         "SIREN : ".$customerData[6].
         " | SIRET : ".$customerData[7]."<br><br>";
    $name = htmlspecialchars($customerData[0]);
    $address_1 = htmlspecialchars($customerData[1]);
    $address_2 = htmlspecialchars($customerData[2]);
    $postalCode = htmlspecialchars($customerData[3]);
    $email = htmlspecialchars($customerData[4]);
    $phone = htmlspecialchars($customerData[5]);
    $siren = htmlspecialchars($customerData[6]);
    $siret = htmlspecialchars($customerData[7]);

    // Vérification des adresses email
    if (!HtmlTools::isEmail($email)) {
        $errorMessage = "<div class='alert alert-danger' role='alert'>";
        $errorMessage .= "L'e-mail du client : <strong>".$email."</strong> n'est pas valide !";
        $errorMessage .= "</div>";
        echo $errorMessage;
        continue;
    }

    // Gestion des doublons
    if ($addressManager->existByEmail($email)) {
        $sameEmailCustomers = $addressManager->getByEmail($email);
        $errorMessage = "<div class='alert alert-danger' role='alert'>";
        $errorMessage .= "L'e-mail du client : ".$email.
                         " est déjà utilisé par <strong>".$sameEmailCustomers->get('name')."</strong>";
        $errorMessage .= "</div>";
        echo $errorMessage;
        continue;
    }

    // On enregistre l'adresse
    $cityData = $cityManager->getCityByPostalCode($postalCode);
    if ($cityData == false) {
        $errorMessage = "<div class='alert alert-danger' role='alert'>";
        $errorMessage .= "Le code postal : <strong>".$postalCode."</strong> est invalide !";
        $errorMessage .= "</div>";
        echo $errorMessage;
        continue 1;
    }
    $city = new City($cityData);

    $addressData = [
        'id_city' => $city->get('id'),
        'address_1' => $address_1,
        'address_2' => $address_2,
        'phone' => $phone,
        'email' => $email
    ];
    $address = new Address($addressData);
    $addressId = (int) $addressManager->add($address);

    // On enregistre l'entreprise
    $customerDataToObject = [
        'id_address' => $addressId,
        'id_type' => $customerTypeId,
        'name' => $name,
        'siren' => $siren,
        'siret' => $siret
    ];
    $customer = new Company($customerDataToObject);
    $customerId = $companyManager->add($customer);

    if ($addressId != false && $customerId != false) {
        $successMessage = "<div class='alert alert-success' role='alert'>";
        $successMessage .= "Les enregistrements en base de données se sont fait avec succès !";
        $successMessage .= "</div>";
        echo $successMessage;
    } else {
        if ($customerId != false) {
            $errorMessage = "<div class='alert alert-danger' role='alert'>";
            $errorMessage .= "Erreur à l'enregistrement du l'adresse !";
            $errorMessage .= "</div>";
            echo $errorMessage;
        } else {
            $errorMessage = "<div class='alert alert-danger' role='alert'>";
            $errorMessage .= "Erreur à l'enregistrement du lead !";
            $errorMessage .= "</div>";
            echo $errorMessage;
        }
    }
}