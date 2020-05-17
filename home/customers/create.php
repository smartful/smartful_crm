<?php
// Activation des sessions
session_start();

require_once "../../lib/factory/PDOFactory.php";
require_once "../../lib/managers/AddressManager.php";
require_once "../../lib/managers/CityManager.php";
require_once "../../lib/managers/CompanyManager.php";
require_once "../../lib/managers/CompanyTypeManager.php";
require_once "../../lib/managers/UserManager.php";
require_once "../../lib/Address.class.php";
require_once "../../lib/City.class.php";
require_once "../../lib/Company.class.php";
require_once "../../lib/utils/HtmlTools.php";
require_once "../../config.php";

// Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

// Déconnecter l'utilisateur
if (isset($_GET['deconnexion'])) {
  session_destroy();
  header("Location: ../../index.php");
}

// Création du manager de user
$userManager = new UserManager($bdd);

// Création du manager de type d'entreprise : on veut les clients
$companyTypeManager = new CompanyTypeManager($bdd);
$customerTypeId = $companyTypeManager->getIdByTypeName(CUSTOMER_TYPE);

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

// Création du manager de ville
$cityManager = new CityManager($bdd);

// Récupération des villes
$cities = $cityManager->getList();

// Traitement de données du formulaire
if (isset($_GET['submit'])) {
  $dataCustomer = [
    'name' => htmlspecialchars($_POST['name']),
    'address_1' => htmlspecialchars($_POST['address_1']),
    'address_2' =>htmlspecialchars($_POST['address_2']),
    'city_id' => (int) $_POST['city'],
    'email' => htmlspecialchars($_POST['email']),
    'phone' =>htmlspecialchars($_POST['phone']),
    'siren' => htmlspecialchars($_POST['siren']),
    'siret' =>htmlspecialchars($_POST['siret'])
  ];
  $htmlTools = new HtmlTools($dataCustomer, []);
  $errorMessages = [];

  if (!$htmlTools->isFormFilled()) {
    $errorMessages[] = "Des champs du formulaire ne sont pas remplis !";
  } else {
    // On enregistre les données dans la base de données
    if (empty($errorMessages)) {
      // On récupère la ville
      $city = $cityManager->get($dataCustomer['city_id']);

      // On enregistre l'adresse
      $addressManager = new AddressManager($bdd);
      $addressData = [
        'id_city' => $city->get('id'),
        'address_1' => $dataCustomer['address_1'],
        'address_2' => $dataCustomer['address_2'],
        'email' => $dataCustomer['email'],
        'phone' => $dataCustomer['phone'],
      ];
      $address = new Address($addressData);
      $addressId = $addressManager->add($address);

      $companyManager = new companyManager($bdd);
      $companyData = [
        'id_address' => $addressId,
        'name' => $dataCustomer['name'],
        'siren' => $dataCustomer['siren'],
        'siret' => $dataCustomer['siret'],
        'id_type' => $customerTypeId
      ];
      $company = new Company($companyData);
      $companyId = $companyManager->add($company);
      $success = "L'opération a bien été enregistrée !";
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="../../css/style.css" media="all">
    <title>Nouveau client</title>
  </head>
  <body>
    <div class="container">
      <div class="text-center">
        <h1><a href="../index.php"><?= APP_NAME ?></a></h1>
      </div>
      <hr>

      <?php if (!empty($errorMessages)) : ?>
        <?php foreach ($errorMessages as $errorMessage) : ?>
          <div class="alert alert-warning" role="alert">
            <?= $errorMessage; ?>
          </div>
        <?php endforeach; ?>
      <?php elseif (isset($success)): ?>
        <div class="alert alert-success" role="alert">
          <?= $success; ?>
        </div>
      <?php endif; ?>

      <h3>Créez le client :</h3>
      <form action="create.php?submit" method="post">
        <div class="form-group">
          <label for="name">Nom</label>
          <input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="form-group">
          <label for="address_1">Adresse 1</label>
          <input type="text" class="form-control" name="address_1" id="address_1">
        </div>
        <div class="form-group">
          <label for="address_2">Adresse 2</label>
          <input type="text" class="form-control" name="address_2" id="address_2">
        </div>
        <div class="form-group">
          <label for="city">Ville - code postale</label>
          <select class="form-control" name="city" id="city">
            <option></option>
            <?php foreach ($cities as $city) : ?>
              <option value="<?= $city->get('id'); ?>"><?= $city->get('name')." - ".$city->get('postal_code'); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group">
          <label for="phone">Téléphone</label>
          <input type="phone" class="form-control" name="phone" id="phone">
        </div>
        <div class="form-group">
          <label for="siren">SIREN</label>
          <input type="text" class="form-control" name="siren" id="siren">
        </div>
        <div class="form-group">
          <label for="siret">SIRET</label>
          <input type="text" class="form-control" name="siret" id="siret">
        </div>
        
        <button type="submit" class="registerbtn">Enregistrer</button>
      </form>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";