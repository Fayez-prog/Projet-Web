<?php
include("../../../fonctions.php");
$id_dep   = $_GET["id_dep"];
supprimer_departement($conn,$id_dep);
header("location:../affichedepartement.php");
?>