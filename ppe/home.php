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

  </style>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">

    <span class="navbar-brand mb-0 h1">AutoPower</span>

    <ul class="navbar-nav">
      <li class="nav-item active">
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
      <li class="nav-item">
        <?php

        afficherBoutonProfil();

        ?>
      </li>
    </ul>
  </nav>

  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">Location de voitures</h1>
      <p class="lead">placeholder</p>
      <hr class="my-4">
      <p>placeholder</p>
      <a class="btn btn-primary btn-lg" href="#listeVoitures" role="button">Explorer</a>
    </div>
  </div>

  <?php
  $sql = "select vimg from vehicule where vnum=?";

  if ($stmt2 = $mysqli->prepare($sql)) {
    $stmt2->bind_param("i", $param_test);

    $param_test = 0;

    if ($stmt2->execute()) {

      $result = $stmt2->get_result();
      while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        foreach ($row as $r) {
          //Vide
        }
      }
    }
  }
  ?>

  <img class="card-img-top img-fluid" src=<?php echo $r ?> alt="">

  <?php

  $randmaxarr = array();

  if ($sqlvnum = $mysqli->query("select vnum from vehicule where vnum >= all (select vnum from vehicule);")) {

    error_reporting(0);
    $randmaxarr = $sqlvnum->fetch_array(MYSQLI_NUM);
    $randmaxint = implode($randmaxarr);
  }

  $numvoit = range(0, $randmaxint);
  shuffle($numvoit);

  if ($sql = $mysqli->query("select * from vehicule")) {

    $param_vnum = array();
    $param_desc = array();
    $param_dateaj = array();
    $param_vmod = array();
    $param_vmarq = array();

    for ($i = 0; $i < ($row = mysqli_fetch_array($sql)); $i++) {

      $param_vnum[$i] = $row['vNum'];
      $param_desc[$i] = $row['vDesc'];
      $param_dateaj[$i] = $row['vDateAjout'];
      $param_vmod[$i] = $row['vMod'];
      $param_vmarq[$i] = $row['marqNum'];

      if ($sql2 = $mysqli->query("select marqNom from marque where marqNum = $param_vmarq[$i]")) {
        $arr = $sql2->fetch_array(MYSQLI_NUM);
        $str = implode($arr);
      }
    }
  }

  if ($randmaxint == null) {
    echo ('<div class="container" align="center">Aucune voiture à afficher</div>');
  }
  ?>
  <div class="container">
    <div class="card-deck mt-5" id="listeVoitures">

      <?php

      if (isset($randmaxint)) {

        if ($randmaxint >= 0) { ?>
          <div class="card">
            <img class="card-img-top" src="images/<?php echo $numvoit[0] ?>.jpg" alt="Image de voiture">
            <div class="card-body">
              <h5 class="card-title"><?php echo $param_vnum[$numvoit[0]] ?></h5>
              <p class="card-text"><?php echo $param_desc[$numvoit[0]] ?></p>
              <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[0] ?>" role="button">Accéder à la page de la voiture</a>
            </div>
            <div class="card-footer">
              <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[0]] ?></small>
            </div>
          </div>
        <?php } else {
        } ?>

        <?php

        if ($randmaxint >= 1) { ?>
          <div class="card">
            <img class="card-img-top" src="images/<?php echo $numvoit[1] ?>.jpg" alt="Image de voiture">
            <div class="card-body">
              <h5 class="card-title"><?php echo $param_vnum[$numvoit[1]] ?></h5>
              <p class="card-text"><?php echo $param_desc[$numvoit[1]] ?></p>
              <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[1] ?>" role="button">Accéder à la page de la voiture</a>
            </div>
            <div class="card-footer">
              <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[1]] ?></small>
            </div>
          </div>
        <?php } else {
        } ?>

        <?php

        if ($randmaxint >= 2) { ?>
          <div class="card">
            <img class="card-img-top" src="images/<?php echo $numvoit[2] ?>.jpg" alt="Image de voiture">
            <div class="card-body">
              <h5 class="card-title"><?php echo $param_vnum[$numvoit[2]] ?></h5>
              <p class="card-text"><?php echo $param_desc[$numvoit[2]] ?></p>
              <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[2] ?>" role="button">Accéder à la page de la voiture</a>
            </div>
            <div class="card-footer">
              <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[2]] ?></small>
            </div>
          </div>
        <?php } else {
        } ?>
    </div>

    <div class="card-deck mt-5">
      <?php

        if ($randmaxint >= 3) { ?>
        <div class="card">
          <img class="card-img-top" src="images/<?php echo $numvoit[3] ?>.jpg" alt="Image de voiture">
          <div class="card-body">
            <h5 class="card-title"><?php echo $param_vnum[$numvoit[3]] ?></h5>
            <p class="card-text"><?php echo $param_desc[$numvoit[3]] ?></p>
            <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[3] ?>" role="button">Accéder à la page de la voiture</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[3]] ?></small>
          </div>
        </div>
      <?php } else {
        } ?>
      <?php

        if ($randmaxint >= 4) { ?>
        <div class="card">
          <img class="card-img-top" src="images/<?php echo $numvoit[4] ?>" alt="Image de voiture">
          <div class="card-body">
            <h5 class="card-title"><?php echo $param_vnum[$numvoit[4]] ?></h5>
            <p class="card-text"><?php echo $param_desc[$numvoit[4]] ?></p>
            <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[4] ?>" role="button">Accéder à la page de la voiture</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[4]] ?></small>
          </div>
        </div>
      <?php } else {
        } ?>

      <?php

        if ($randmaxint >= 5) { ?>
        <div class="card">
          <img class="card-img-top" src="images/<?php echo $numvoit[5] ?>" alt="Image de voiture">
          <div class="card-body">
            <h5 class="card-title"><?php echo $param_vnum[$numvoit[5]] ?></h5>
            <p class="card-text"><?php echo $param_desc[$numvoit[5]] ?></p>
            <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $numvoit[5] ?>" role="button">Accéder à la page de la voiture</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$numvoit[5]] ?></small>
          </div>
        </div>
      <?php } else {
        } ?>
    </div>
  </div>

<?php } ?>

</div>
</div>

<footer class="footer text-muted" style="padding-top: 10rem; padding-bottom: 1.5rem;">
  <div class="container">
    <p class="float-right">
      <a href="#navbar">Retourner en haut de page</a>
    </p>
    <span class="text-muted">AutoPower, site PPE</span>
    <p>Location de voitures</p>
  </div>
</footer>
<!--Lien JS Bootstrap-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>