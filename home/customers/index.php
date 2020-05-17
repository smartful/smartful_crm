<?php
// Activation des sessions
session_start();

require_once "../../config.php";
require_once "../../lib/factory/PDOFactory.php";
require_once "../../lib/managers/CompanyManager.php";
require_once "../../lib/managers/AddressManager.php";
require_once "../../lib/managers/CityManager.php";
require_once "../../lib/managers/UserManager.php";

// Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

// Déconnecter l'utilisateur
if (isset($_GET['deconnexion'])) {
  session_destroy();
  header("Location: ../../index.php");
}

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

// Création du manager des clients
$companyManager = new CompanyManager($bdd);
// Récupération des clients
$customers = $companyManager->getCustomerList();
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="../../css/style.css" media="all">
    <title>Clients</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="text-center">
        <h1><a href="../index.php"><?= APP_NAME ?></a></h1>
        <h3><span class="badge badge-dark">Clients</span></h3>
      </div>
      <hr>

      <div class="text-center">
        <h5><?= $user->get('first_name') ?> <?= $user->get('last_name') ?></h5>
      </div>

      <h3>Liste des produits</h3>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Adresse 1</th>
          <th>Adresse 2</th>
          <th>Ville</th>
          <th>Code Postale</th>
          <th>E-mail</th>
          <th>Téléphone</th>
          <th>SIREN</th>
          <th>SIRET</th>
        </thead>
        <tbody>
          <?php foreach($customers as $customer) : ?>
            <?php
              // Création des managers des produits
              $addressManager = new AddressManager($bdd);
              $cityManager = new CityManager($bdd);
              $companyAddress = $addressManager->get($customer->get('id_address'));
              $city = $cityManager->get($companyAddress->get('id_city'));
            ?>
            <tr>
              <td><?= $customer->get('name'); ?></td>
              <td><?= $companyAddress->get('address_1'); ?></td>
              <td><?= $companyAddress->get('address_2'); ?></td>
              <td><?= $city->get('name'); ?></td>
              <td><?= $city->get('postal_code'); ?></td>
              <td><?= $companyAddress->get('email'); ?></td>
              <td><?= $companyAddress->get('phone'); ?></td>
              <td><?= $customer->get('siren'); ?></td>
              <td><?= $customer->get('siret'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <br/><br/>

      <div class="row">
        <button type="button" class="btn btn-outline-primary mr-3"><a href="./create.php">Créer un nouveau client</a></button>
        <button type="button" class="btn btn-outline-primary mr-3"><a href="./export.php">Export CSV 	&#9935;</a></button>
        <button type="button" class="btn btn-outline-primary"><a href="./mass_create.php">Création en masse</a></button>
      </div>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";