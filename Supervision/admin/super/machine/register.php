<?php
include("../../../fonctions.php");
$nom_machine = $_POST["nom_machine"];
$type_machine = $_POST["type_machine"];
$fournisseur_machine = $_POST["fournisseur_machine"];


ajout_machine($conn,$_SESSION["id"],$nom_machine,$type_machine,$fournisseur_machine);
header("location:../afficheparametre.php");
?>