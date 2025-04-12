<?php
include("../../../fonctions.php");
$id_sort   = $_GET["id_sort"];
supprimer_sortie($conn,$id_sort);
header("location:../affichesortie.php");
?>