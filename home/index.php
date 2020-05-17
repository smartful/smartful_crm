<?php
// Activation des sessions
session_start();

require_once "../config.php";
require_once "../lib/factory/PDOFactory.php";
require_once "../lib/managers/UserManager.php";

// Chargement de la bdd
$bdd = PDOFactory::getMySQLConnexion();

// Déconnecter l'utilisateur
if (isset($_GET['deconnexion'])) {
  session_destroy();
  header("Location: ../index.php");
}

// Création du manager de l'utilisateur
$userManager = new UserManager($bdd);

if (isset($_SESSION['id_user'])) {
  // Cas où l'utilisateur est déjà connecté
  if ($_SESSION['id_user'] > 0) {
    $user = $userManager->get($_SESSION['id_user']);
  } else {
    header("Location: ../error403.php");
  }
} else {
  // Cas où l'utilisateur se connecte
  $email = htmlspecialchars($_POST['email_user']);
  $password = htmlspecialchars($_POST['password_user']);

  // Vérification de la présence mail
  if ($userManager->existByMail($email)) {
    $user = $userManager->getByMail($email)[0];
    if ($user->get('password') == md5($password)) {
      // Vérification du mot de passe
      $_SESSION['id_user'] = $user->get('id');
    } else {
      header("Location: ../error403.php");
    }
  } else {
    header("Location: ../error403.php");
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="all">
    <title>Accueil</title>
  </head>
  <body>
    <div class="container">
      <div class="text-center">
        <h1><?= APP_NAME ?></h1>
        <h3><span class="badge badge-dark">Accueil</span></h3>
        <h4>Bonjour <?= $user->get('first_name') ?> <?= $user->get('last_name') ?></h4>
      </div>
      <hr>

      <div class="text-center">
        <img src="../images/logo_80.png">
      </div>
      <br>

      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link btn btn-dark mr-3" href="./customers/index.php" role="btn">Clients</a>
        </li>
      </ul>
      <br><br>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";