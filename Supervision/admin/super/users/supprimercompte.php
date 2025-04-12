<?php
include("../../../fonctions.php");
$id_User   = $_GET["id_User"];
supprimer_user($conn,$id_User);
header("location:../affichecompte.php");
?>