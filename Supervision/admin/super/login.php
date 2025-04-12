<?php
include("../../fonctions.php");
if(verif_session_super_users()){
    header("location:page.php");
}
$login_super = $_POST['login_super'];
$pass_super  = $_POST["mdp_super"];
if(login_super_users($conn,$login_super,$pass_super)){
    ajout_session("super_users",id_super_users($conn,$login_super,$pass_super));
    header("location:page.php");
}else{
    header("location:../../super.php?error");
}



?>