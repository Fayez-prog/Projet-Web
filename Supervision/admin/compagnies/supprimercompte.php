<?php
include("../../fonctions.php");
$id_ent   = $_GET["id_ent"];
supprimer_entreprise($conn,$id_ent);
header("location:../affichecompagnie.php");
?>