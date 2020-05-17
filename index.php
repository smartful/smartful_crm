<?php
require_once "./config.php";
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
      </div>
      <hr>

      <div class="text-center">
        <h2>Connexion</h2>
        <form action="home/index.php" method="post">
        <label for="email">email</label>
        <input type="email" name="email_user" id="email"/>
        <label for="password">password</email>
        <input type="password" name="password_user" id="password"/>
        <input type="submit" value="connexion"/>
        </form>
      </div>

      <div class="text-center">
        <img src="../images/logo_480.png">
      </div>
      <br>

      
      <br><br>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";