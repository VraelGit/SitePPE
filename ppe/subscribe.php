<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Include config file
require('config.php');
include 'fonctions.php';

// Define variables and initialize with empty values
$subMail = $subMDP = $subConfMDP = "";
$subMail_err = $subMDP_err = $confirm_subMDP_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["subMail"]))) {
        echo $subMail_err = "Entrer une adresse e-mail";
    } else {
        // Prepare a select statement
        $sql = "SELECT uID FROM utilisateur WHERE uLogin = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_login);
            // Set parameters
            $param_login = trim($_POST["subMail"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    echo $subMail_err = ('<div style="position: absolute; bottom: 2px;">Cette adresse e-mail est déjà utilisée.</div>');
                } else {
                    $subMail = trim($_POST["subMail"]);
                }
            } else {
                echo ('<div style="position: absolute; bottom: 2px;">Quelque chose s\'est mal passé, réessayer plus tard.</div>');
            }
        }
        // Close statement
        $stmt->close();
    }

    // Validate password
    if (empty(trim($_POST["subMDP"]))) {
        echo $subMDP_err = "Entrer un mot de passe";
    } elseif (strlen(trim($_POST["subMDP"])) < 3) {
        echo $subMDP_err = ('<div style="position: absolute; bottom: 2px;">Le mot de passe doit faire 3 caractères ou plus.</div>');
    } else {
        $subMDP = trim($_POST["subMDP"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["subConfMDP"]))) {
        echo $confirm_subMDP_err = ('<div style="position: absolute; bottom: 2px;">Confirmer le mot de passe</div>');
    } else {
        $subConfMDP = trim($_POST["subConfMDP"]);
        if (empty($subMDP_err) && ($subMDP != $subConfMDP)) {
            echo $confirm_subMDP_err = ('<div style="position: absolute; bottom: 2px;">Les mots de passe ne correspondent pas.</div>');
        }
    }

    if($_POST["subConc"] == 0)
    {
        var_dump($_POST["subConc"]);
    }

    if((($_POST["subConc"]) == 1) && (empty(trim($_POST["subConcSiret"])))) {
        echo $concsiret_err = ('<div style="position: absolute;">Le numéro de SIRET n\'a pas été saisi.</div>');
    }

    if((($_POST["subConc"]) == 1) && (empty(trim($_POST["subConcRais"])))) {
        echo $concrais_err = ('<div style="position: absolute;">La raison sociale n\'a pas été saisi.</div>');
    }

    if ($_POST["subConc"] == 1) {
        if (empty($concsiret_err) && empty($concrais_err) && empty($subMail_err) && empty($subMDP_err) && empty($confirm_subMDP_err)) {
            if ($sql3 = $mysqli->query("select uid from utilisateur")) {
                $uidconcarr = $sql3->fetch_array(MYSQLI_NUM);
                $uidconcint = implode($uidconcarr);
            }

            $sql2 = "INSERT INTO concessionnaire (concSiret, concRaisSoc) VALUES (?, ?)";

            if ($req = $mysqli->prepare($sql2)) {

                $req->bind_param("is", $param_concsiret, $param_concrais);

                $param_concsiret = trim($_POST["subConcSiret"]);
                $param_concrais = trim($_POST["subConcRais"]);

                if ($req->execute()) {
                } else {
                    echo ('<div style="position: absolute; bottom: 2px;">Quelque chose s\'est mal passé, réessayer plus tard.</div>');
                }
                $req->close();
            }
        } else {
            echo ('<div style="position: absolute; bottom: 2px;">Quelque chose s\'est mal passé, réessayer plus tard.</div>');
        }
    }

    // Check input errors before inserting in database
    if (empty($subMail_err) && empty($subMDP_err) && empty($confirm_subMDP_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO utilisateur (uLogin, uMDP, uPrenom, uNom, uAddr, uVille, uCP, uDepart, uConc, uTel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssssisis", $param_login, $param_mdp, $param_prenom, $param_nom, $param_addr, $param_ville, $param_CP, $param_depart, $param_conc, $param_utel);

            // Set parameters
            $param_login = $subMail;
            $param_mdp = password_hash($subMDP, PASSWORD_DEFAULT); // Creates a password hash
            $param_prenom = trim($_POST["subPrenom"]);
            $param_nom = trim($_POST["subNom"]);
            $param_addr = trim($_POST["subAddr"]);
            $param_ville = trim($_POST["subVille"]);
            $param_CP = trim($_POST["subCP"]);
            $param_depart = trim($_POST["subDepart"]);
            $param_conc = $_POST["subConc"];
            $param_utel = trim($_POST["subTel"]);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo ('<div style="position: absolute; bottom: 2px;">Quelque chose s\'est mal passé, réessayer plus tard.</div>');
            }
            // Close statement
            $stmt->close();
        }else{
            echo "erreur 1";
        }
    }else{
        echo "erreur 2";
    }
    // Close connection
    $mysqli->close();
}
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

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
                <a class="nav-link" href="about.php">A propos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>

        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="subscribe.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Connexion</a>
            </li>
        </ul>
    </nav>

    <form action="" method="post">

        <div class="form-row">

            <div class="form-group col-md-2 offset-md-4">
                <label for="subPrenom">Prénom</label>
                <input type="text" class="form-control" name="subPrenom" required>
            </div>

            <div class="form-group col-md-2">
                <label for="subNom">Nom</label>
                <input type="text" class="form-control" name="subNom" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subAddress">Adresse</label>
                <input type="text" class="form-control" name="subAddr" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subTel">Téléphone</label>
                <input type="tel" class="form-control" id="subTel" name="subTel" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subMail">Adresse e-mail</label>
                <input type="mail" class="form-control" id="subMail" name="subMail" required>
            </div>

            <div class="form-group col-md-2 offset-md-4">
                <label for="subVille">Ville</label>
                <input type="text" class="form-control" name="subVille" required>
            </div>

            <div class="form-group col-md-2">
                <label for="subCP">Code Postal</label>
                <input type="text" class="form-control" name="subCP" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subDepart">Département</label>
                <input type="text" class="form-control" name="subDepart" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subMDP">Mot de passe</label>
                <input type="password" class="form-control" id="subMDP" name="subMDP" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subConfMDP">Confirmer mot de passe</label>
                <input type="password" class="form-control" id="subConfMDP" name="subConfMDP" required>
            </div>

            <script>
                function conc(that) {
                    if (that.value == "1") {
                        document.getElementById("concinfo").style.display = "flex";
                    } else {
                        document.getElementById("concinfo").style.display = "none";
                    }
                }
            </script>

            <div class="form-group col-md-4 offset-md-4">
                <label for="subConc">Concessionaire</label>
                <select class="custom-select" name="subConc" onchange="conc(this);">
                    <option value="0">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <div class="form-row" id="concinfo" style="display: none;">

                <div class="form-group col-md-4 offset-md-4">
                    <label for="subConcSiret">N° SIRET</label>
                    <input type="text" class="form-control" name="subConcSiret">
                </div>

                <div class="form-group col-md-4 offset-md-4">
                    <label for="subConcRais">Raison sociale</label>
                    <input type="text" class="form-control" name="subConcRais">
                </div>

            </div>

            <div class="form-group col-md-4 offset-md-4">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>

        </div>

    </form>


    <!--Lien JS Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>