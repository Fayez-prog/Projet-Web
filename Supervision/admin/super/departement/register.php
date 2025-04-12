<?php
include("../../../fonctions.php");
$nom_departement = $_POST["nom_departement"];
$slot_departement = $_POST["slot_departement"];
$emplacement_departement = $_POST["emplacement_departement"];



ajout_departement($conn,$_SESSION["id"],$nom_departement,$slot_departement,$emplacement_departement);
header("location:../affichedepartement.php");
?>