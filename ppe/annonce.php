<?php
session_start();
require_once('config.php');
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
            <li class="nav-item active">
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

    <?php
    if (!isset($_SESSION["loggedin"])) {
    ?>
        <div class="container" align="center">
            <span>Vous n'êtes pas connecté ou alors vous n'avez pas le rôle de concessionnaire.</span>
            <?php
            header('Refresh: 3; URL=login.php');
            ?>
        </div>
    <?php
        die();
    }
    ?>

    <form action="" method="post">

        <div class="form-row">

            <div class="form-group col-md-4 offset-md-4">
                <label for="aNom">Nom de l'annonce</label>
                <input type="text" class="form-control" name="aNom" required>
            </div>


            <div class="form-group col-md-4 offset-md-4">
                <label for="vIm">Numéro d'immatriculation</label>
                <input type="text" class="form-control" name="vIm" required>
            </div>


            <div class="form-group col-md-2 offset-md-4">
                <label for="vDIm">Date d'immatriculation</label>
                <input type="date" class="form-control" name="vDIm" required>
            </div>


            <div class="form-group col-md-2">
                <label for="vKm">Kilométrage</label>
                <input type="text" class="form-control" name="vKm" required>
            </div>


            <div class="form-group col-md-4 offset-md-4">
                <label for="vPrix">Prix proposé</label>
                <input type="text" class="form-control" name="vPrix" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="vType">Type de véhicule</label>
                <select class="custom-select" name="vType" required>
                    <option>...</option>
                    <option value="0">Berline</option>
                    <option value="1">Coupé</option>
                    <option value="2">Familiale</option>
                    <option value="3">Cabriolet</option>
                    <option value="4">Roadster</option>
                    <option value="5">Pickup</option>
                    <option value="6">4x4</option>
                    <option value="7">VUS</option>
                    <option value="8">Multisegments (Crossover)</option>
                    <option value="9">Minivan</option>
                    <option value="10">Voiture sportive</option>
                </select>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="vMarque">Marque du véhicule</label>
                <select class="custom-select" name="vMarque" required>
                    <option>...</option>
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

            <div class="form-group col-md-4 offset-md-4">
                <label for="vMod">Modèle du véhicule</label>
                <input type="text" class="form-control" name="vMod" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="vCarbu">Type de carburant du véhicule</label>
                <select class="custom-select" name="vCarbu" required>
                    <option>...</option>
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

            <div class="form-group col-md-4 offset-md-4">
                <label for="vDesc">Description</label>
                <textarea rows=4 class="form-control" name="vDesc" required></textarea>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <p>Vous pourrez mettre une photo de la voiture dans la page suivante.</p>
            </div>


            <div class="form-group col-md-4 offset-md-4">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Poster l'annonce</button>
                </div>
            </div>

        </div>

    </form>

    <?php

    $insertarr = array();

    if ($sqlvnum = $mysqli->query("select vnum from vehicule where vnum >= all (select vnum from vehicule);")) {

        $col = $sqlvnum->num_rows;

        if ($col == 0) {
            $insertint = -1;
        } else {
            $insertarr = $sqlvnum->fetch_array(MYSQLI_NUM);
            $insertint = implode($insertarr);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $sql = "INSERT INTO vehicule (vnum, vimmatriculation, vdateimmatriculation, vkmcpt, vprixpro, marqnum, vmod, typevehi, carbucode, vdateajout, vdesc, vimg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        
        if (($stmt = $mysqli->prepare($sql))) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("iisiiisiisss", $param_vnum, $param_vim, $param_vdateim, $param_vkm, $param_vprix, $param_vmarque, $param_vmod, $param_typevehi, $param_carbucode, $param_vdateajout, $param_desc, $param_vimg);
            // Set parameters

            $param_vnum = $insertint + 1;
            $resultat = $param_vnum;
            $param_vim = trim($_POST['vIm']);
            $param_vdateim = $_POST['vDIm'];
            $param_vkm = trim($_POST['vKm']);
            $param_vprix = trim($_POST['vPrix']);
            $param_desc = trim($_POST['vDesc']);
            $param_vmod = trim($_POST["vMod"]);
            $param_typevehi = $_POST["vType"];
            $param_vmarque = $_POST["vMarque"];
            $param_carbucode = $_POST["vCarbu"];
            $param_vimg = "images/$resultat";

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {

                $sqlannonce = "insert into annonce (anum,anom, vnum, uid) values (?, ?, ?, ?);";

                if ($stmtannonce = $mysqli->prepare($sqlannonce)) {

                    $stmtannonce->bind_param("isii", $param_anum, $param_anom, $param_vnum, $param_uid);

                    $param_anom = trim($_POST["aNom"]);
                    $param_vnum = $insertint + 1;
                    $param_uid = $_SESSION["id"];
                    $param_anum = $param_vnum;

                    if ($stmtannonce->execute()) {

                // Redirect to login page
    ?>
                <script>
                    window.location.replace("imagevoiture.php<?php echo "?vnum=$param_vnum" ?>");
                </script>
    <?php
            } else {
                echo ('<div style="position: absolute; bottom: 2px;">aaaQuelque chose s\'est mal passé, réessayer plus tard.</div>');
            }
        } else {
            echo ('<div style="position: absolute; bottom: 2px;">bbbQuelque chose s\'est mal passé, réessayer plus tard.</div>');
        }
        //header("location: imagevoiture.php?vnum=$param_vnum");

        // Close statement
        $stmt->close();
    }else{
        echo "erreur 1";
    }
}else{
    echo "erreur 2";
}
    }

    // Close connection
    $mysqli->close();

    ?>

    <!--Lien JS Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>