<?php
include("../../../fonctions.php");
$id_mach   = $_GET["id_mach"];
supprimer_machine($conn,$id_mach);
header("location:../afficheparametre.php");
?>