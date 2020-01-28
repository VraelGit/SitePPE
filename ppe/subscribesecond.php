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
      <li class="nav-item ">
        <a class="nav-link" href="about.php">À propos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>

    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="subscribesecond.php">Inscription</a>
      </li>
      <li class="nav-item">
        <?php

            afficherBoutonProfil();

        ?>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">

    <p align="center"><a href="subscribecli.php"> Inscription client</a></p>
    <p align="center"><a href="subscribeconc.php"> Inscription concessionnaire</a></p>

  </div>

  <!--Lien JS Bootstrap-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>