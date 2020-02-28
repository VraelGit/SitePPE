<?php

session_start();
require('config.php');
include 'fonctions.php';

?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!--Assurer le bon rendu et le zoom tactile sur tout les appareils-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>AutoPower</title>

  <!--Lien CSS Bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
    table,
    td {
      border: 1px solid #333;
    }

    th {
      background: grey;
    }
  </style>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">

    <span class="navbar-brand mb-0 h1">AutoPower</span>

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="home.php">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="recherche.php">Recherche</a>
      </li>
      <li class="nav-item">
        <?php

        afficherBoutonAnnonce();

        ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">À propos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>

    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="subscribesecond.php">Inscription</a>
      </li>
      <li class="dropdown">
        <?php

        afficherBoutonProfil();

        ?>
      </li>
    </ul>
  </nav>

  <?php

  if (isset($_SESSION["loggedin"]) && (isset($_GET["uid"]))) {

    if ($_GET["uid"] != $_SESSION["username"]) {
      header("location: home.php");
    } else {
  ?>
  <?php

$sqlutil = "select annonce.uid from annonce, utilisateur where annonce.uid = utilisateur.uid and utilisateur.ulogin = ?";

if ($res = $mysqli->prepare($sqlutil)) {
  $res->bind_param("s", $param_log);

  $param_log = $_SESSION["username"];

  if ($res->execute()) {
    $val = $res->get_result();
    while ($row = $val->fetch_array(MYSQLI_NUM)) {
      foreach ($row as $r) {
      }
    }
  }
}

if (!isset($r)) {
?>

  <p align="center" style="bottom: 20px">Vous n'avez publié aucune annonce.</p>

<?php

  exit;
}
?>
      </br>

      <div class="container" align="center">
        <table>
          <thead>
            <tr>
              <th colspan="1">Numéro de la plaque d'immatriculation</th>
              <th colspan="1">Date d'immatriculation</th>
              <th colspan="1">Kilométrage (Km)</th>
              <th colspan="1">Prix proposé (€)</th>
              <th colspan="1">Type de véhicule</th>
              <th colspan="1">Date d'ajout</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php

              if ($sql = $mysqli->query("select vehicule.*, typeLib from type_vehi, vehicule, annonce, utilisateur, concessionnaire where type_vehi.typeVehi = vehicule.typeVehi and vehicule.vnum = annonce.vnum and utilisateur.uid = concessionnaire.uid and concessionnaire.uid = annonce.uid and annonce.uid = $r")) {
                $param_vnum = array();
                $param_vim = array();
                $param_vdateim = array();
                $param_kmcpt = array();
                $param_prixpro = array();
                $param_typevehi = array();
                $param_dateaj = array();
                $param_nomtype = array();
              }

              for ($i = 0; $i < ($row = mysqli_fetch_array($sql)); $i++) {

                $param_vnum[$i] = $row["vNum"];
                $param_vim[$i] = $row['vImmatriculation'];
                $param_vdateim[$i] = $row['vDateImmatriculation'];
                $param_kmcpt[$i] = $row['vKmCpt'];
                $param_prixpro[$i] = $row['vPrixPro'];
                $param_typevehi[$i] = $row['typeVehi'];
                $param_dateaj[$i] = $row['vDateAjout'];
                $param_nomtype = $row["typeLib"];

              ?>
                <td>
                  <?php echo $param_vim[$i] ?>
                </td>
                <td>
                  <?php echo $param_vdateim[$i] ?>
                </td>
                <td>
                  <?php echo $param_kmcpt[$i] ?>
                </td>
                <td>
                  <?php echo $param_prixpro[$i] ?>
                </td>
                <td>
                  <?php echo $param_nomtype ?>
                </td>
                <td>
                  <?php echo $param_dateaj[$i] ?>
                </td>
                <td>
                  <a href="suppannonce.php?vnum=<?php echo $param_vnum[$i] ?>">Suppression annonce</a>
                </td>
            </tr>
          <?php
              }
          ?>
          </tbody>

        </table>
      </div>

  <?php
    }
  } else {
    header("location: home.php");
  }
  ?>

  <!--Lien JS Bootstrap-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>