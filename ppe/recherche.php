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
                <?php

                afficherBoutonInscription();

                ?>
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

    $sqltypevehi = "select typeLib from type_vehi";

    if ($stmt = $mysqli->query($sqltypevehi)) {

        while ($str1 = $stmt->fetch_array(MYSQLI_ASSOC)) {
            $typevehi[] = $str1;
        }
    }

    $sqlcarbu = "select carbutype from carburant";

    if ($stmt = $mysqli->query($sqlcarbu)) {

        while ($str2 = $stmt->fetch_array(MYSQLI_ASSOC)) {
            $typecarbu[] = $str2;
        }
    }

    $sqlmarq = "select marqNom from marque";

    if ($stmt = $mysqli->query($sqlmarq)) {

        while ($str3 = $stmt->fetch_array(MYSQLI_ASSOC)) {
            $typemarq[] = $str3;
        }
    }

    ?>

    <form action="" method="post">

        <div class="container" align="center">
            <div class="row">
                <div class="col-sm">
                    <span>Type de véhicule</span>
                    <div class="form-check">
                        <select class="custom-select" name="vType" required>
                            <?php

                            for ($i = 0; $i <= 10; $i++) {
                                echo "<option value='$i'>" ?><?php echo implode($typevehi[$i]) ?><?php echo "</option>";
                                                                                                }

                                                                                                    ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <span>Type de carburant</span>
                    <div class="form-check">
                        <select class="custom-select" name="vCarbu" required>
                            <?php

                            for ($i = 0; $i <= 10; $i++) {
                                echo "<option value='$i'>" ?><?php echo implode($typecarbu[$i]) ?><?php echo "</option>";
                                                                                                }
                                                                                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm">
                    <span>Nom de la marque</span>
                    <div class="form-check">
                        <select class="custom-select" name="vMarque" required>
                            <?php

                            for ($i = 0; $i <= 10; $i++) {
                                echo "<option value='$i'>" ?><?php echo implode($typemarq[$i]) ?><?php echo "</option>";
                                                                                                }

                                                                                                    ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        </br>

        <div class="container" align="center">
            <div class="row">
                <div class="col-sm">
                    <div class="form-check">
                        <label for="vPrix">Prix de la voiture ( Prix max )</label>
                        <input type="text" class="form-control" name="vPrix">
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-check">
                        <label for="vMod">Modèle du véhicule</label>
                        <input type="text" class="form-control" name="vMod" >
                    </div>

                </div>

                <div class="col-sm">
                    <div class="form-check">
                        <label for="vKm">Kilométrage ( Inférieur à ...)</label>
                        <input type="text" class="form-control" name="vKm">
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $typev = $_POST["vType"];
            $vcarbu = $_POST["vCarbu"];
            $vmarq = $_POST["vMarque"];
            $vprix = $_POST["vPrix"];
            if($vprix == null)
            {
                $vprix = 1000000000;
            }

            $vmod = $_POST["vMod"];

            $vkm = $_POST["vKm"];
            if($vkm == null)
            {
                $vkm = 1000000000;
            }

            if ($sql = $mysqli->query("select * from vehicule where typeVehi = $typev and carbuCode = $vcarbu and marqNum = $vmarq and vPrixPro between 0 and $vprix and vMod like '%$vmod%' and vKmCpt between 0 and $vkm")) {

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

        ?>

                    <div class="card" style="max-width: 50%;">
                        <img class="card-img-top" src="images/<?php echo $param_vnum[$i] ?>.jpg" alt="Image de voiture">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo ("$str $param_vmod[$i]") ?></h5>
                            <p class="card-text"><?php echo $param_desc[$i]; ?></p>
                            <a class="btn btn-primary" href="voiture.php?vnum=<?php echo $param_vnum[$i]; ?>" role="button">Plus de détail sur la voiture</a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Annonce postée le <?php echo $param_dateaj[$i] ?></small>
                        </div>
                    </div>

                    </br>

        <?php

                }
            }
        } else {

            afficherRechercheVoiture();
        }

        ?>

    </div>

    <!--Lien JS Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>