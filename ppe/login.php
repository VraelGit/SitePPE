<?php



// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}
// Include config file
require('config.php');
include 'fonctions.php';

session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Define variables and initialize with empty values
$logMail = $logMDP = "";
$logMail_err = $logMDP_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["logMail"]))) {
        $logMail_err = "Please enter username.";
    } else {
        $logMail = trim($_POST["logMail"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["logMDP"]))) {
        $logMDP_err = "Please enter your password.";
    } else {
        $logMDP = trim($_POST["logMDP"]);
    }

    $sql2 = "select uactif from utilisateur where ulogin = ?;";

    if ($stmt2 = $mysqli->prepare($sql2)) {
        $stmt2->bind_param("s", $param_login);

        $param_login = $logMail;

        if ($stmt2->execute()) {

            $result = $stmt2->get_result();
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                foreach ($row as $r) {
                    //Vide
                }
            }
            if ($r == 0) {

                echo "Votre compte n'est pas activé";
                exit;
            }
        }
    }


    // Validate credentials
    if (empty($logMail_err) && empty($logMDP_err)) {
        // Prepare a select statement
        $sql = "SELECT uID, uLogin, uMDP FROM utilisateur WHERE uLogin = ?;";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_login);

            // Set parameters
            $param_login = $logMail;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $logMail, $hashed_logMDP);
                    if ($stmt->fetch()) {
                        if (password_verify($logMDP, $hashed_logMDP)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $logMail;
                            $_SESSION["admin"] = false;

                            // Redirect user to welcome page
                            header("location: home.php");
                        } else {
                            // Display an error message if password is not valid
                            echo $logMDP_err = ('<div style="position: absolute; bottom: 2px;">Le mot de passe entré n\'est pas valide</div>');
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    echo $logMail_err = ('<div style="position: absolute; bottom: 2px;">Aucun compte avec cette adresse e-mail n\'a été trouvé</div>');
                }
            } else {
                echo "Quelque chose s'est mal passé, réessayer plus tard svp.";
            }
        }

        // Close statement
        $stmt->close();
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
            <li class="nav-item">
                <a class="nav-link" href="subscribesecond.php">Inscription</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Connexion</a>
            </li>
        </ul>
    </nav>

    <a href="adminlogin.php">Accés administrateur</a>

    <form action="" method="post">

        <div class="form-row">

            <div class="form-group col-md-4 offset-md-4">
                <label for="logMail">Adresse e-mail</label>
                <input type="mail" class="form-control" id="logMail" name="logMail" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <label for="logMDP">Mot de passe</label>
                <input type="password" class="form-control" id="logMDP" name="logMDP" required>
            </div>

            <div class="form-group col-md-4 offset-md-4">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="submit">Envoyer</button>
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