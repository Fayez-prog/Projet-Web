<?php
include("../../../fonctions.php");
if(verif_session_users()){
    header("location:dashboard.php");
}
$login_users = $_POST['login_users'];
$pass_users  = $_POST["mdp_users"];
if(login_users($conn,$login_users,$pass_users)){
    ajout_session("users",id_users($conn,$login_users,$pass_users));
    header("location:dashboard.php");
}else{
    header("location:../../../users.php?error");
}



?>