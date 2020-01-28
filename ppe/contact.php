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
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
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
      <li class="nav-item active">
        <a class="nav-link" href="about.php">À propos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>

    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="subscribe.php">Inscription</a>
      </li>
      <li class="nav-item">
        <?php

            afficherBoutonProfil();

        ?>
      </li>
    </ul>
  </nav>
  <p align="center"><strong>Contact</strong></p>
<table width="500" border="0" align="center" cellpadding="15" cellspacing="15">
<form action="envoi.php" method="post" enctype="application/x-www-form-urlencoded" name="formulaire">
<tr>
<td colspan="3"><strong>Envoyer un message</strong></td>
</tr>
<tr>
<td><div align="left"> Nom:</div></td>
<td colspan="2"><input type="text" name="nom" size="45" maxlength="100" required></td>
</tr>
<tr>
<td width="17%"><div align="left">Mail:</div></td>
<td colspan="2"><input type="text" name="mail" size="45" maxlength="100" required></td>
</tr>
<tr>
<td><div align="left">Sujet: </div></td>
<td colspan="2"><input type="text" name="objet" size="45" maxlength="120" required></td>
</tr>
<tr>
<td><div align="left">Message: </div></td>
<td colspan="2"><textarea name="message" cols="50" rows="10" required></textarea></td>
</tr>
<tr>
<td></td>
<td width="42%"><center>
<input type="reset" name="Submit" value="Réinitialiser le formulaire">
</center></td>
<td width="41%"><center>
<input type="submit" name="Submit" value="Envoyer">
</center></td>
</tr>
</form>

</body>