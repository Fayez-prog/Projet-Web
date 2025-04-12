<?php
include("../../../fonctions.php");
$nom_machine = $_POST["nom_machine"];
$nom_sort1 = $_POST["nom_sort1"];
$choix_sort1 = $_POST["choix_sort1"];
$nom_sort2 = $_POST["nom_sort2"];
$choix_sort2 = $_POST["choix_sort2"];
$nom_sort3 = $_POST["nom_sort3"];
$choix_sort3 = $_POST["choix_sort3"];
$nom_sort4 = $_POST["nom_sort4"];
$choix_sort4 = $_POST["choix_sort4"];
$nom_sort5 = $_POST["nom_sort5"];
$choix_sort5 = $_POST["choix_sort5"];
$nom_sort6 = $_POST["nom_sort6"];
$choix_sort6 = $_POST["choix_sort6"];

ajout_sortie($conn,$_SESSION["id"],$nom_machine,$nom_sort1,$choix_sort1,$nom_sort2,$choix_sort2,$nom_sort3,$choix_sort3,$nom_sort4,$choix_sort4,$nom_sort5,$choix_sort5,$nom_sort6,$choix_sort6);
header("location:../affichesortie.php");
?>