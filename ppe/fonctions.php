<?php

function afficherBoutonAnnonce()
{

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

        require('config.php');

        $sql = "select uConc from utilisateur where uLogin = ?";

        if ($stmt = $mysqli->prepare($sql)) {

            $stmt->bind_param("s", $param_sess);

            $param_sess =  $_SESSION["username"];

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $str = implode($row);
                }

                if ($str == 1) {
                    echo ('<a class="nav-link" href="annonce.php">Poster une annonce</a>');
                }
            }
        }
    }
}

function afficherRechercheVoiture()
{

    require('config.php');

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

?>

            <div class="card" style="max-width: 50%;">
                <img class="card-img-top" src="images/<?php echo $param_vnum[$i]; ?>" alt="Image de voiture">
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
}

function afficherBoutonProfil()
{
    if (!isset($_SESSION["username"])) {
        echo ('<a class="nav-link" href="login.php">Connexion</a>');
    } else if (isset($_SESSION["username"])) { ?>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($_SESSION["username"]); ?></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profil.php?uid=<?php echo $_SESSION["username"] ?>">Mon profil</a>
                <a class="dropdown-item" href="logout.php">Se déconnecter</a>
            </div>
        </div>
    <?php
    }
}


function afficherDetailVoiture()
{

    require('config.php');

    /*
    $modLibelle;
    $modMarque;
    $vPrixPro;
    $vDesc;
    $vnum;
    $vImmatriculation;
    $vKmCpt;
    $typeLib;
    $carbuType;
    $vDateAjout;
    $concSiret;
    $concRaisSoc;
    $telephone;
    $adresse;
    */

    //$sql = "select vMod,marqNom,vPrixPro,vDesc,vImmatriculation,vKmCpt,typeLib,carbuType,vDateAjout,concSiret,concRaisSoc,uTel,uAddr from utilisateur, vehicule, type_vehi, carburant, concessionnaire, marque where vNum=? and vehicule.typeVehi=type_vehi.typeVehi and vehicule.carbuCode=carburant.carbuCode";

    $sqlvoit = "select vmod, vprixpro, vdesc, vimmatriculation, vkmcpt, vdateajout from vehicule where vnum = ?";

    if ($stmt = $mysqli->prepare($sqlvoit)) {

        $stmt->bind_param("i", $vnum);

        $vnum = trim($_GET["vnum"]);

        if ($stmt->execute()) {

            $result = $stmt->get_result();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                var_dump($row);

                    //$modLibelle = $row["vMod"];
                    //$modMarque = $row["marqNom"];
                    $vPrixPro = $row['vprixpro'];
                    $vDesc = $row['vdesc'];
                    $vImmatriculation = $row['vimmatriculation'];
                    $vKmCpt = $row['vkmcpt'];
                    //$typeLib = $row["typeLib"];
                    //$carbuType = $row["carbuType"];
                    $vDateAjout = $row['vdateajout'];

                }
            }
        } else {
            echo "execute fail";
        }



    $sqlutil = "select utel, uaddr from utilisateur, annonce where utilisateur.uid = annonce.uid and annonce.vnum = ?";

    if ($stmt = $mysqli->prepare($sqlutil)) {

        $stmt->bind_param("i", $vnum);

        $vnum = trim($_GET["vnum"]);

        if ($stmt->execute()) {

            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                    //$modLibelle = $row["vMod"];
                    //$modMarque = $row["marqNom"];
                    //$typeLib = $row["typeLib"];
                    //$carbuType = $row["carbuType"];
                    $telephone = $row['utel'];
                    $adresse = $row['uaddr'];

            }
        } else {
            echo "execute fail";
        }
    } else {
        echo "prepare fail";
    }

    $sqlconc = "select concsiret, concraissoc from concessionnaire,annonce where concessionnaire.uid = annonce.uid";

    if ($stmt = $mysqli->prepare($sqlconc)) {

        if ($stmt->execute()) {

            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {

                var_dump($row);

                    //$modLibelle = $row["vMod"];
                    //$modMarque = $row["marqNom"];
                    //$typeLib = $row["typeLib"];
                    //$carbuType = $row["carbuType"];
                    $concSiret = $row['concsiret'];
                    $concRaisSoc = $row['concraissoc'];

            }
        } else {
            echo "execute fail";
        }
    } else {
        echo "prepare fail";
    }

    ?>

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-1">Détail véhicule</h1>
            <div class="list-group">
                <p class="list-group-item">Type vehicule : <?php echo $typeLib ?></p>
                <p class="list-group-item">Type moteur : </p>
                <p class="list-group-item">Kilometrage : <?php echo $vKmCpt ?></p>
                <p class="list-group-item">Carburant : <?php echo $carbuType ?></p>
                <p class="list-group-item">Date annonce : <?php echo $vDateAjout ?></p>
                <p href="" class="list-group-item">Immatriculation : <?php echo $vImmatriculation ?></p>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card mt-4" align="center">
                <img class="card-img-top img-fluid" src=<?php echo "images/" . $vnum ?> alt="">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $modMarque . " " . $modLibelle; ?></h3>
                    <h4><?php echo $vPrixPro . "€" ?></h4>
                    <p class="card-text"><?php echo $vDesc ?></p>

                </div>
            </div>

            <div class="card mt-4" align="center">
                <div class="card-body">
                    <h3 class="card-title">Contact Concessionaire</h3>
                    <h4>Siret:<?php echo $concSiret ?></h4>
                    <h4>Raison sociale: <?php echo $concRaisSoc ?></h4>
                    <h4>Telephone: <?php echo $telephone ?></h4>
                    <h4>Adresse: <?php echo $adresse ?></h4>

                </div>
            </div>
            <!-- /.card -->
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    <?php
}
    ?>