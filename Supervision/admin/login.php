<?php
include("../fonctions.php");
if(verif_session_admin()){
    header("location:page.php");
}

$login_admin = $_POST['login_admin'];
$pass_admin  = $_POST["mdp_admin"];

if(login_admin($conn,$login_admin,$pass_admin)){
    ajout_session("admin",id_admin($conn,$login_admin,$pass_admin));
    header("location:page.php");
}else{
    header("location:../admin.php?error");
}



?>