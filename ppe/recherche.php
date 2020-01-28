<?php

session_start();

include 'fonctions.php';
require('config.php');

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
            <li class="nav-item ">
                <a class="nav-link" href="home.php">Accueil</a>
            </li>
            <li class="nav-item active">
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


    </br>

    <form action="" method="post">

        <div class="container" align="center">
            <div class="row">
                <div class="col-sm">
                    <span>Type de véhicule</span>
                    <div class="form-check">
                        <select class="custom-select" name="vType" required>
                            <option value="1">Berline</option>
                            <option value="2">Coupé</option>
                            <option value="3">Familiale</option>
                            <option value="4">Cabriolet</option>
                            <option value="5">Roadster</option>
                            <option value="6">Pickup</option>
                            <option value="7">4x4</option>
                            <option value="8">VUS</option>
                            <option value="9">Multisegments (Crossover)</option>
                            <option value="10">Minivan</option>
                            <option value="11">Voiture sportive</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <span>Type de carburant</span>
                    <div class="form-check">
                        <select class="custom-select" name="vCarbu" required>
                            <option value="0">Biodiesel</option>
                            <option value="1">Bioéthanol</option>
                            <option value="2">Algocarburant</option>
                            <option value="3">Biogaz</option>
                            <option value="4">LPG</option>
                            <option value="5">E5</option>
                            <option value="6">E10</option>
                            <option value="7">E85</option>
                            <option value="8">B7</option>
                            <option value="9">B10</option>
                            <option value="10">XTL</option>
                            <option value="11">H2</option>
                            <option value="12">GNC</option>
                            <option value="13">GNL</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <span>Nom de la marque</span>
                    <div class="form-check">
                        <select class="custom-select" name="vMarque" required>
                            <option value="0">Peugeot</option>
                            <option value="1">Renault</option>
                            <option value="2">Opel</option>
                            <option value="3">Citroen</option>
                            <option value="4">Volkswagen</option>
                            <option value="5">Mercedes</option>
                            <option value="6">Nissan</option>
                            <option value="7">Audi</option>
                            <option value="8">BMW</option>
                            <option value="9">Ford</option>
                            <option value="10">Toyota</option>
                            <option value="11">Fiat</option>
                            <option value="12">Autre</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="container" align="center">
            <div class="row">
                <div class="col-sm">
                    <span>Prix</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="vPrix" id="pLow" checked>
                        <label class="form-check-label" for="pLow">0€ à 5000€</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="vPrix" id="pMid">
                        <label class="form-check-label" for="pMid">5000€ à 10000€</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="vPrix" id="pHigh">
                        <label class="form-check-label" for="pHigh">Plus de 10000€</label>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-check">
                        <label for="vMod">Modèle du véhicule</label>
                        <input type="text" class="form-control" name="vMod" required>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-check">
                        <label for="vKm">Kilométrage ( Inférieur à ...)</label>
                        <input type="text" class="form-control" name="vKm" required>
                    </div>
                </div>
            </div>

            </br>

            <div align="center">
                <button type="submit" class="btn btn-primary" name="submit">Filtrer les résultats</button>
            </div>

    </form>

    </br>

    <div class="container" align="center">

        <?php

        afficherRechercheVoiture();

        ?>

    </div>

    <!--Lien JS Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>