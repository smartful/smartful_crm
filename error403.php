<?php
require_once "./config.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once "./includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all">
    <title>FORBIDDEN</title>
  </head>
  <body>
<div class="container">
      <div class="text-center">
        <h1><?= APP_NAME ?></h1>
      </div>
      <hr>

      <div class="alert alert-danger" role="alert">
        <h3 class="alert-heading">Accès interdit</h3>
        <p>Vous n'avez pas les accès pour accéder à la page demandée</p>
      </div>

      <div class="text-center">
        <img src="https://media.giphy.com/media/V5Jc8pRfCFkQw/giphy.gif" alt="NO"/>
        <br/><br/>
        <a href='index.php'>Retour à l'accueil</a>
      </div>

    </div>
<?php
require_once "./includes/html_foot.php";