<?php
session_start();
include("base.php");

//fonctions sur la session 

function ajout_session($role,$id){
    $_SESSION["role"] = $role;
    $_SESSION["id"] = $id;
}

function verif_session_admin(){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"] == "admin"){
            return true;
        }
    }
    return false;
}

function verif_session_super_users(){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"] == "super_users"){
            return true;
        }
    }
    return false;
}

function verif_session_users(){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"] == "users"){
            return true;
        }
    }
    return false;
}
//fonctions sur l'admin
function login_admin($con,$login_admin,$pass_admin){
    $query = "select * from admin where login_admin = '".$login_admin."' and mdp_admin = '".$pass_admin."'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_num_rows($result);
    if($rows>0){
        return true;
    }else{
        return false;
    }
}
function id_admin($con,$login_admin,$pass_admin){
    $query = "select id_admin from admin where login_admin = '".$login_admin."' and mdp_admin = '".$pass_admin."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_admin"];
}
function ajout_admin($con,$nom_admin,$login_admin,$mdp_admin){
    $query = "insert into admin (nom_admin,login_admin,mdp_admin) values ('".$nom_admin."','".$login_admin."','".$mdp_admin."')";
    $result = mysqli_query($con,$query);
}
//fonctions sur le entreprise
function id_entreprise($con,$nom_entreprise,$localisation_entreprise,$email_entreprise,$tel_entreprise,$web_entreprise){
    $query = "select id_entreprise from entreprise where nom_entreprise = '".$nom_entreprise."' and localisation_entreprise = '".$localisation_entreprise."' and email_entreprise = '".$email_entreprise."' and tel_entreprise = '".$tel_entreprise."' and web_entreprise = '".$web_entreprise."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_entreprise"];
}
function ajout_entreprise($con,$id_admin,$nom_entreprise,$localisation_entreprise,$email_entreprise,$tel_entreprise,$web_entreprise){
    $query = "insert into entreprise (id_admin,nom_entreprise,localisation_entreprise,email_entreprise,tel_entreprise,web_entreprise) values ('".$id_admin."','".$nom_entreprise."','".$localisation_entreprise."','".$email_entreprise."','".$tel_entreprise."','".$web_entreprise."')";
    $result = mysqli_query($con,$query);
}
function compteentrepriseparid($con,$id){
    $query = "select * from entreprise where id_entreprise='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_entreprise($con,$id_ent){
    $query = "DELETE FROM entreprise WHERE id_entreprise='".$id_ent."'";
    $result = mysqli_query($con,$query);
}
function update_entreprise($con,$id_entreprise,$id_admin,$nom_entreprise,$localisation_entreprise,$email_entreprise,$tel_entreprise,$web_entreprise){
    $query = "UPDATE `entreprise` SET `id_admin`= '$id_admin' ,`nom_entreprise`= '$nom_entreprise' ,`localisation_entreprise`= '$localisation_entreprise' ,`email_entreprise`='$email_entreprise' ,`tel_entreprise`='$tel_entreprise' ,`web_entreprise`='$web_entreprise'  WHERE id_entreprise =  '$id_entreprise' ; ";
    $result = mysqli_query($con,$query);
    
}
function listCompteEntrepriseAjouter($con,$id_admin){
    $query = "select * from entreprise where id_admin='".$id_admin."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
//fonctions sur le super users
function login_super_users($con,$login_super,$pass_super){
    $query = "select * from super_users where login_super = '".$login_super."' and mdp_super = '".$pass_super."'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_num_rows($result);
    if($rows>0){
        return true;
    }else{
        return false;
    }
}
function id_super_users($con,$login_super,$pass_super){
    $query = "select id_super from super_users where login_super = '".$login_super."' and mdp_super = '".$pass_super."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_super"];
}
function ajout_super_users($con,$id_admin,$nom_super,$login_super,$mdp_super){
    $query = "insert into super_users (id_admin,nom_super,login_super,mdp_super) values ('".$id_admin."','".$nom_super."','".$login_super."','".$mdp_super."')";
    $result = mysqli_query($con,$query);
}
function comptesuperparid($con,$id){
    $query = "select * from super_users where id_super='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_super_user($con,$id_user){
    $query = "DELETE FROM super_users WHERE id_super='".$id_user."'";
    $result = mysqli_query($con,$query);
}
function update_super($con,$id_super,$id_admin,$nom_super,$login_super,$mdp_super){
    $query = "UPDATE `super_users` SET `id_admin`= '$id_admin' ,`nom_super`= '$nom_super' ,`login_super`= '$login_super' ,`mdp_super`='$mdp_super' WHERE id_super =  '$id_super' ; ";
    $result = mysqli_query($con,$query);
    
}
function listCompteSuperUsersAjouter($con,$id_admin){
    $query = "select * from super_users where id_admin='".$id_admin."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
//fonctions sur le users
function login_users($con,$login_users,$pass_users){
    $query = "select * from users where login_users = '".$login_users."' and mdp_users = '".$pass_users."'";
    $result = mysqli_query($con,$query);
    $rows = mysqli_num_rows($result);
    if($rows>0){
        return true;
    }else{
        return false;
    }
}
function id_users($con,$login_users,$pass_users){
    $query = "select id_users from users where login_users = '".$login_users."' and mdp_users = '".$pass_users."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);  
    return $result["id_users"];
}
function ajout_users($con,$id_super,$nom_users,$login_users,$mdp_users){
    $query = "insert into users(id_super,nom_users,login_users,mdp_users) values('".$id_super."','".$nom_users."','".$login_users."','".$mdp_users."')";
    $result = mysqli_query($con,$query);
}
function compteusersparid($con,$id){
    $query = "select * from users where id_users='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_user($con,$id_User){
    $query = "DELETE FROM users WHERE id_users='".$id_User."'";
    $result = mysqli_query($con,$query);
}
function update_user($con,$id_users,$id_super,$nom_users,$login_users,$mdp_users){
    $query = "UPDATE `users` SET `id_super`= '$id_super' ,`nom_users`= '$nom_users' ,`login_users`= '$login_users' ,`mdp_users`='$mdp_users' WHERE id_users =  '$id_users' ; ";
    $result = mysqli_query($con,$query);
}
function listCompteUsersAjouter($con,$id_super){
    $query = "select * from users where id_super='".$id_super."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
//logout commun
function logout(){
    unset($_SESSION["role"]);
    unset($_SESSION["id"]);
 }
 //fonctions sur le machine
 function id_machine($con,$nom_machine,$type_machine,$fournisseur_machine){
    $query = "select id_machine from machine where nom_machine = '".$nom_machine."' and type_machine = '".$type_machine."' and fournisseur_machine = '".$fournisseur_machine."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_machine"];
}
 function ajout_machine($con,$id_super,$nom_machine,$type_machine,$fournisseur_machine){
    $query = "insert into machine (id_super,nom_machine,type_machine,fournisseur_machine) values ('".$id_super."','".$nom_machine."','".$type_machine."','".$fournisseur_machine."')";
    $result = mysqli_query($con,$query);
}
 function comptemachineparid($con,$id){
    $query = "select * from machine where id_machine='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_machine($con,$id_mach){
    $query = "DELETE FROM machine WHERE id_machine='".$id_mach."'";
    $result = mysqli_query($con,$query);
}
function update_machine($con,$id_machine,$id_super,$nom_machine,$type_machine,$fournisseur_machine){
    $query = "UPDATE `machine` SET `id_super`= '$id_super' ,`nom_machine` = '$nom_machine' , `type_machine` = '$type_machine' , `fournisseur_machine` = '$fournisseur_machine'  WHERE id_machine =  '$id_machine' ; ";
    $result = mysqli_query($con,$query);
}
function listMachineAjouter($con,$id_super){
    $query = "select * from machine where id_super='".$id_super."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
 //fonctions sur le departement
 function id_departement($con,$nom_departement,$slot_departement,$emplacement_departement){
    $query = "select id_departement from departement where nom_departement = '".$nom_departement."' and slot_departement = '".$slot_departement."' and emplacement_departement = '".$emplacement_departement."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_departement"];
}
 function ajout_departement($con,$id_super,$nom_departement,$slot_departement,$emplacement_departement){
    $query = "insert into departement (id_super,nom_departement,slot_departement,emplacement_departement) values ('".$id_super."','".$nom_departement."','".$slot_departement."','".$emplacement_departement."')";
    $result = mysqli_query($con,$query);
}
 function comptedepartementparid($con,$id){
    $query = "select * from departement where id_departement='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_departement($con,$id_dep){
    $query = "DELETE FROM departement WHERE id_departement='".$id_dep."'";
    $result = mysqli_query($con,$query);
}
function update_departement($con,$id_departement,$id_super,$nom_departement,$slot_departement,$emplacement_departement){
    $query = "UPDATE `departement` SET `id_super`= '$id_super' ,`nom_departement` = '$nom_departement' , `slot_departement` = '$slot_departement' , `emplacement_departement` = '$emplacement_departement' WHERE id_departement =  '$id_departement' ; ";
    $result = mysqli_query($con,$query);
}
function listDepartementAjouter($con,$id_super){
    $query = "select * from departement where id_super='".$id_super."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
 //fonctions sur le entrée
 function id_entre($con,$nom_machine,$nom_ent1,$choix_ent1,$nom_ent2,$choix_ent2,$nom_ent3,$choix_ent3,$nom_ent4,$choix_ent4,$nom_ent5,$choix_ent5,$nom_ent6,$choix_ent6){
    $query = "select id_entre from entre where nom_machine = '".$nom_machine."' and nom_ent1 = '".$nom_ent1."' and choix_ent1 = '".$choix_ent1."' and nom_ent2 = '".$nom_ent2."' and choix_ent2 = '".$choix_ent2."' and nom_ent3 = '".$nom_ent3."' and choix_ent3 = '".$choix_ent3."' and nom_ent4 = '".$nom_ent4."' and choix_ent4 = '".$choix_ent4."' and nom_ent5 = '".$nom_ent5."' and choix_ent5 = '".$choix_ent5."' and nom_ent6 = '".$nom_ent6."' and choix_ent6 = '".$choix_ent6."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_entre"];
}
 function ajout_entre($con,$id_super,$nom_machine,$nom_ent1,$choix_ent1,$nom_ent2,$choix_ent2,$nom_ent3,$choix_ent3,$nom_ent4,$choix_ent4,$nom_ent5,$choix_ent5,$nom_ent6,$choix_ent6){
    $query = "insert into entre (id_super,nom_machine,nom_ent1,choix_ent1,nom_ent2,choix_ent2,nom_ent3,choix_ent3,nom_ent4,choix_ent4,nom_ent5,choix_ent5,nom_ent6,choix_ent6) values ('".$id_super."','".$nom_machine."','".$nom_ent1."','".$choix_ent1."','".$nom_ent2."','".$choix_ent2."','".$nom_ent3."','".$choix_ent3."','".$nom_ent4."','".$choix_ent4."','".$nom_ent5."','".$choix_ent5."','".$nom_ent6."','".$choix_ent6."')";
    $result = mysqli_query($con,$query);
}
 function compteentreeparid($con,$id){
    $query = "select * from entre where id_entre='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_entre($con,$id_ent){
    $query = "DELETE FROM entre WHERE id_entre='".$id_ent."'";
    $result = mysqli_query($con,$query);
}
function update_entre($con,$id_entre,$id_super,$nom_machine,$nom_ent1,$choix_ent1,$nom_ent2,$choix_ent2,$nom_ent3,$choix_ent3,$nom_ent4,$choix_ent4,$nom_ent5,$choix_ent5,$nom_ent6,$choix_ent6){
    $query = "UPDATE `entre` SET `id_super`= '$id_super' ,`nom_machine` = '$nom_machine' , `nom_ent1` = '$nom_ent1' , `choix_ent1` = '$choix_ent1' , `nom_ent2` = '$nom_ent2' , `choix_ent2` = '$choix_ent2', `nom_ent3` = '$nom_ent3' , `choix_ent3` = '$choix_ent3', `nom_ent4` = '$nom_ent4' , `choix_ent4` = '$choix_ent4', `nom_ent5` = '$nom_ent5' , `choix_ent5` = '$choix_ent5', `nom_ent6` = '$nom_ent6' , `choix_ent6` = '$choix_ent6' WHERE id_entre =  '$id_entre' ; ";
    $result = mysqli_query($con,$query);
}
function listEntreeAjouter($con,$id_super){
    $query = "select * from entre where id_super='".$id_super."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
//fonctions sur le sortie
function id_sortie($con,$nom_machine,$nom_sort1,$choix_sort1,$nom_sort2,$choix_sort2,$nom_sort3,$choix_sort3,$nom_sort4,$choix_sort4,$nom_sort5,$choix_sort5,$nom_sort6,$choix_sort6){
    $query = "select id_sortie from sortie where nom_machine = '".$nom_machine."' and nom_sort1 = '".$nom_sort1."' and choix_sort1 = '".$choix_sort1."' and nom_sort2 = '".$nom_sort2."' and choix_sort2 = '".$choix_sort2."' and nom_sort3 = '".$nom_sort3."' and choix_sort3 = '".$choix_sort3."' and nom_sort4 = '".$nom_sort4."' and choix_sort4 = '".$choix_sort4."' and nom_sort5 = '".$nom_sort."' and choix_sort5 = '".$choix_sort5."' and nom_sort6 = '".$nom_sort6."' and choix_sort6 = '".$choix_sort6."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result["id_sortie"];
}
 function ajout_sortie($con,$id_super,$nom_machine,$nom_sort1,$choix_sort1,$nom_sort2,$choix_sort2,$nom_sort3,$choix_sort3,$nom_sort4,$choix_sort4,$nom_sort5,$choix_sort5,$nom_sort6,$choix_sort6){
    $query = "insert into sortie (id_super,nom_machine,nom_sort1,choix_sort1,nom_sort2,choix_sort2,nom_sort3,choix_sort3,nom_sort4,choix_sort4,nom_sort5,choix_sort5,nom_sort6,choix_sort6) values ('".$id_super."','".$nom_machine."','".$nom_sort1."','".$choix_sort1."','".$nom_sort2."','".$choix_sort2."','".$nom_sort3."','".$choix_sort3."','".$nom_sort4."','".$choix_sort4."','".$nom_sort5."','".$choix_sort5."','".$nom_sort6."','".$choix_sort6."')";
    $result = mysqli_query($con,$query);
}
 function comptesortieparid($con,$id){
    $query = "select * from sortie where id_sortie='".$id."'";
    $result = mysqli_query($con,$query);
    $result = mysqli_fetch_assoc($result);
    return $result;
}
function supprimer_sortie($con,$id_sort){
    $query = "DELETE FROM sortie WHERE id_sortie='".$id_sort."'";
    $result = mysqli_query($con,$query);
}
function update_sortie($con,$id_sortie,$id_super,$nom_machine,$nom_sort1,$choix_sort1,$nom_sort2,$choix_sort2,$nom_sort3,$choix_sort3,$nom_sort4,$choix_sort4,$nom_sort5,$choix_sort5,$nom_sort6,$choix_sort6){
    $query = "UPDATE `sortie` SET `id_super`= '$id_super' ,`nom_machine` = '$nom_machine' , `nom_sort1` = '$nom_sort1' , `choix_sort1` = '$choix_sort1' , `nom_sort2` = '$nom_sort2' , `choix_sort2` = '$choix_sort2', `nom_sort3` = '$nom_sort3' , `choix_sort3` = '$choix_sort3', `nom_sort4` = '$nom_sort4' , `choix_sort4` = '$choix_sort4', `nom_sort5` = '$nom_sort5' , `choix_sort5` = '$choix_sort5', `nom_sort6` = '$nom_sort6' , `choix_sort6` = '$choix_sort6' WHERE id_sortie =  '$id_sortie' ; ";
    $result = mysqli_query($con,$query);
}
function listSortieAjouter($con,$id_super){
    $query = "select * from sortie where id_super='".$id_super."'";
    $result = mysqli_query($con,$query);
    return mysqli_fetch_all($result,MYSQLI_ASSOC);
}


?>