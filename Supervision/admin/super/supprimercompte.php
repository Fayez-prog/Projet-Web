<?php
include("../../fonctions.php");
$id_user   = $_GET["id_supUser"];
supprimer_super_user($conn,$id_user);
header("location:../affichesuper.php");

?>