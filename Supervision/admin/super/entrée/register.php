<?php
include("../../../fonctions.php");
$nom_machine = $_POST["nom_machine"];
$nom_ent1 = $_POST["nom_ent1"];
$choix_ent1 = $_POST["choix_ent1"];
$nom_ent2 = $_POST["nom_ent2"];
$choix_ent2 = $_POST["choix_ent2"];
$nom_ent3 = $_POST["nom_ent3"];
$choix_ent3 = $_POST["choix_ent3"];
$nom_ent4 = $_POST["nom_ent4"];
$choix_ent4 = $_POST["choix_ent4"];
$nom_ent5 = $_POST["nom_ent5"];
$choix_ent5 = $_POST["choix_ent5"];
$nom_ent6 = $_POST["nom_ent6"];
$choix_ent6 = $_POST["choix_ent6"];

ajout_entre($conn,$_SESSION["id"],$nom_machine,$nom_ent1,$choix_ent1,$nom_ent2,$choix_ent2,$nom_ent3,$choix_ent3,$nom_ent4,$choix_ent4,$nom_ent5,$choix_ent5,$nom_ent6,$choix_ent6);
header("location:../afficheentre.php");
?>