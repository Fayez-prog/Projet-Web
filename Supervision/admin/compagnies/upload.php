<?php
include("../../fonctions.php");
$nom_entreprise = $_POST["nom_entreprise"];
$localisation_entreprise = $_POST["localisation_entreprise"];
$email_entreprise = $_POST["email_entreprise"];
$tel_entreprise = $_POST["tel_entreprise"];
$web_entreprise = $_POST["web_entreprise"];

ajout_entreprise($conn,$_SESSION["id"],$nom_entreprise,$localisation_entreprise,$email_entreprise,$tel_entreprise,$web_entreprise);
header("location:../affichecompagnie.php");


?>