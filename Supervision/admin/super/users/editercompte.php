<?php
include("../../../fonctions.php");
if(!verif_session_super_users()){
    header("location:../../../super.php");
    }
    if(isset($_GET['id_User'])){
        $id_users = $_GET['id_User'];
       $query = "SELECT * FROM users WHERE id_users = '".$id_users."'";
       $res = mysqli_query($conn, $query);
       $fetch = mysqli_fetch_array($res);
       /*echo "<pre>";
        die(var_dump($fetch));*/
    }
    
    if(isset($_POST['btn_update'])){
        //die(var_dump($_POST));
    
    $id_users = $_POST["id_users"];
    $nom_users = $_POST["nom_users"];
    $login_users = $_POST["login_users"];
    $mdp_users = $_POST["mdp_users"];
    
    
    update_user($conn,$id_users,$_SESSION["id"],$nom_users,$login_users,$mdp_users);
    header("location:../affichecompte.php");
    
    }
?>
<html>
<head>
        <link href="../../../css/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../css/style.css">
    </head>
    <body>
  <br><br><br>
     <section id="hero">
        <div align="center" class="container">
            <div>
                
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                <br><br>
                <div class="card" style="background-color: rgba(245, 245, 245, 0.4);">
                    <div class="card-header bg-success text-white">Editer utilisateur</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" class="form-control" name="id_users" placeholder="Id" value="<?= $fetch['id_users']; ?>"><br>
                            <input type="text" class="form-control" name="nom_users" placeholder="Nom" value="<?= $fetch['nom_users']; ?>"><br>
                            <input type="text" class="form-control" name="login_users" placeholder="Login" value="<?= $fetch['login_users']; ?>"><br>
                            <input type="text" class="form-control" name="mdp_users" placeholder="Mot de passe" value="<?= $fetch['mdp_users']; ?>"><br>
                            <input type="submit" class="btn btn-primary" value="Modifier" name="btn_update">
                        </form>
                    </div>
                </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
        </section>
        <script src="css/jquery-3.5.1.slim.min.js"></script>
        <script src="css/popper.min.js"></script>
        <script src="css/bootstrap.min.js"></script>
    </body>
</html>