<?php
require_once "./config.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <?php require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_head.php"; ?>
    <link rel="stylesheet" type="text/css" href="./css/style.css" media="all">
    <title>Documentation</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="text-center">
        <h1><?= APP_NAME ?></h1>
        <h3>DOCUMENTATION</h3>
      </div>
      <hr>

      <h3>Liste des méthode des managers</h3>

      <h4><span class="badge badge-primary">BaseManager</span></h4>
      <div class="card">
        <div class="card-body">
          Les méthodes communes à tous les managers
        </div>
      </div><br/>

      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>exist</b></td>
            <td>(mixed) $id</td>
            <td>(bool) $isExist</td>
            <td>Vérifie si une entité existe à partir d'un ID</td>
          </tr>
          <tr>
            <td><b>count</b></td>
            <td>(void)</td>
            <td>(int) $nombre</td>
            <td>Retourne le nombre d'entité</td>
          </tr>
          <tr>
            <td><b>add</b></td>
            <td>(Base) $object</td>
            <td>(int) $id</td>
            <td>Ajout d'une entité</td>
          </tr>
          <tr>
            <td><b>update</b></td>
            <td>(Base) $object</td>
            <td>(void)</td>
            <td>Mise à jour d'une entité</td>
          </tr>
          <tr>
            <td><b>delete</b></td>
            <td>(Base) $object</td>
            <td>(void)</td>
            <td>Supprime une entité de la base de données</td>
          </tr>
          <tr>
            <td><b>get</b></td>
            <td>
              (int) $id <br/>
              (array) $formatDate (par défaut : [])
            </td>
            <td>(object) $object</td>
            <td>Récupère une entité en fonction de son ID</td>
          </tr>
          <tr>
            <td><b>getList</b></td>
            <td>(array) $formatDate (par défaut : [])</td>
            <td>(array) $objects</td>
            <td>Récupère la liste des entités</td>
          </tr>
          <tr>
            <td><b>getIdByTypeName</b></td>
            <td>$type [string]</td>
            <td>(int) $isExist</td>
            <td>Récupère l'ID de l'entite en fonction du nom rentré en paramètre</td>
          </tr>
          <tr>
            <td><b>getRelationshipId</b></td>
            <td>
              (int) $tableAId <br/>
              (int) $tableBId
            </td>
            <td>(int) $id</td>
            <td>Récupère l'ID d'une table de relation en fonction des ID des 2 tables mises en relation</td>
          </tr>
        </tbody>
      </table>

      <h4><span class="badge badge-primary">CityManager</span></h4>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>getCityByPostalCode</b></td>
            <td>(int) $postalCode</td>
            <td>$data [array]</td>
            <td>Récupère les informations d'une ville en fonction du code postale.</td>
          </tr>
        </tbody>
      </table>

      <h3>Liste des méthode de génération de requêtes</h3>
      <h4><span class="badge badge-primary">ManagerCreator</span></h4>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>getInsertFields</b></td>
            <td>(void)</td>
            <td>(array) $result</td>
            <td>Prend les attributs de la classe et les traduits en chaîne de caractères</td>
          </tr>
          <tr>
            <td><b>getSettingFields</b></td>
            <td>(void)</td>
            <td>(string) $settingFields</td>
            <td>Adapte les attributs de la classe pour l'usage lors d'un Update</td>
          </tr>
          <tr>
            <td><b>getReadFields</b></td>
            <td>(array)$formatDates (par défaut: [])</td>
            <td>(string) $attributes</td>
            <td>Adapte les attributs de la classe pour l'usage lors d'un Update</td>
          </tr>
          <tr>
            <td><b>getAddQuery</b></td>
            <td>(void)</td>
            <td>(string) $query</td>
            <td>Génère une requête d'ajout</td>
          </tr>
          <tr>
            <td><b>getUpdateQuery</b></td>
            <td>(void)</td>
            <td>(string) $query</td>
            <td>Génère une requête de mise à jour</td>
          </tr>
          <tr>
            <td><b>getDeleteQuery</b></td>
            <td>(void)</td>
            <td>(string) $query</td>
            <td>Génère une requête de suppression</td>
          </tr>
          <tr>
            <td><b>getReadQuery</b></td>
            <td>
              (array) $formatOption (par défaut: [])<br/>
              (bool) $isList (par défaut: false)
            </td>
            <td>(string) $query</td>
            <td>Génère une requête de suppression</td>
          </tr>
          <tr>
            <td><b>getIdRelationshipQuery</b></td>
            <td>(void)</td>
            <td>(string) $query</td>
            <td>Génère une requête de lecture de l'ID d'une table de relation</td>
          </tr>
          <tr>
            <td><b>getBindOperation</b></td>
            <td>
              (string) $objectName<br/>
              (array) $options (par défaut: [])
            </td>
            <td>(array) $bindOperations</td>
            <td>Génère un tableau contenant les bind des valeurs des attributs à leur étiquette dans une requête</td>
          </tr>
          <tr>
            <td><b>getBindRelationship</b></td>
            <td>(array) $tab</td>
            <td>(array) $bindOperations</td>
            <td>Génère un tableau contenant les bind pour les tables de relation</td>
          </tr>
        </tbody>
      </table>

      <h3>Liste des méthode à propos des dates</h3>
      <h4><span class="badge badge-primary">DateTools</span></h4>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>litteralMonthFr</b></td>
            <td>$monthNumber [int]</td>
            <td>(string) $monthsFr</td>
            <td>Associe un nombre à son mois littéral (FR)</td>
          </tr>
          <tr>
            <td><b>fromIsoToArray</b></td>
            <td>(void)</td>
            <td>(array) $dateArray</td>
            <td>
              Décompose une date ISO 8601 (YYYY-MM-DD) en dans un tableau associatif<br/>
              Clés : "day", "month", "year"
            </td>
          </tr>
          <tr>
            <td><b>fromIsoToLitteral</b></td>
            <td>(void)</td>
            <td>(string) $litteralDate</td>
            <td>Transforme une date ISO 8601 (YYYY-MM-DD) en texte littéral (ex : 1 octobre 1909)</td>
          </tr>
          <tr>
            <td><b>getTimestamp</b></td>
            <td>(void)</td>
            <td>(int)</td>
            <td>Obtenir le timestamp de la date</td>
          </tr>
        </tbody>
      </table>

      <h3>Liste des méthode des outils HTLM</h3>
      <h4><span class="badge badge-primary">HtmlTools</span></h4>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>isFormFilled</b></td>
            <td>(void)</td>
            <td>(bool)</td>
            <td>Vérifie que les champs d'un formulaire sont bien remplies</td>
          </tr>
          <tr>
            <td><b>createOptionFromValues</b></td>
            <td>(void)</td>
            <td>(string) $optionBlock</td>
            <td>Transforme un tableau de valeurs en une liste d'options pour une balise select</td>
          </tr>
          <tr>
            <td><b>isEmail</b></td>
            <td>(string) $emailInput</td>
            <td>(bool)</td>
            <td>Vérifie que la chaîne de caractère est bien un email</td>
          </tr>
        </tbody>
      </table>

      <h3>Liste des méthode mathématique</h3>
      <h4><span class="badge badge-primary">MathTools</span></h4>
      <table class="table table-striped table-dark">
        <thead>
          <th>Nom</th>
          <th>Paramètres</th>
          <th>Retour</th>
          <th>Description</th>
        </thead>
        <tbody>
          <tr>
            <td><b>distance</b></td>
            <td>
              (float) $xa <br/>
              (float) $ya <br/>
              (float) $xb <br/>
              (float) $yb 
            </td>
            <td>(float) $result</td>
            <td>Calcul la distance entre 2 points dans un espace en 2D</td>
          </tr>
        </tbody>
      </table>
    </div>

<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/includes/html_foot.php";