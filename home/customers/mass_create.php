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
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="../../css/style.css" media="all">
    <title>Import : données en masse</title>
  </head>
  <body>
    <div class="container">
      <div class="text-center">
        <h1><a href="../index.php"><?= APP_NAME ?></a></h1>
      </div>
      <hr>

      <div id="loader" class="container-fluid">
        <div class="text-center">
          <img src="../../images/ajax-loader.gif" alt="Loading" />
        </div>
      </div>

      <h3>Import</h3>

      <div class="row">
        <div class="col-md-8" id="depot">Déposez le fichier des clients ici (au format .csv)</div>
        <div class="col-md-4">
          <h3>Format du fichier CSV : </h3>
          <ul>
            <li>Nom</li>
            <li>Adresse 1</li>
            <li>Adresse 2</li>
            <li>Code Postal</li>
            <li>E-mail</li>
            <li>Numéro de téléphone</li>
            <li>SIREN</li>
            <li>SIRET</li>
          </ul>
        </div>
      </div>
      <output id="noms_fichiers"></output>

      <div id="line_process"></div>
    </div>

    <script src="./js/process_data.js"></script>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";