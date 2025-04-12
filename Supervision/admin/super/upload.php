<?php
include("../../fonctions.php");
$nom_super = $_POST["nom_super"];
$login_super = $_POST["login_super"];
$mdp_super = $_POST["mdp_super"];

ajout_super_users($conn,$_SESSION["id"],$nom_super,$login_super,$mdp_super);
header("location:../affichesuper.php");

?>