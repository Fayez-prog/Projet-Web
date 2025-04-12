<?php
include("../../../fonctions.php");
$nom_users = $_POST["nom_users"];
$login_users = $_POST["login_users"];
$mdp_users = $_POST["mdp_users"];

ajout_users($conn,$_SESSION["id"],$nom_users,$login_users,$mdp_users);
header("location:../affichecompte.php");

?>