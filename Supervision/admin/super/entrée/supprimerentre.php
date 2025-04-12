<?php
include("../../../fonctions.php");
$id_ent   = $_GET["id_ent"];
supprimer_entre($conn,$id_ent);
header("location:../afficheentre.php");
?>