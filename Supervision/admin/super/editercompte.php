<?php
include("../../fonctions.php");
if(!verif_session_admin()){
header("location:../../admin.php");
}
if(isset($_GET['id_supUser'])){
    $id_super = $_GET['id_supUser'];
   $query = "SELECT * FROM super_users WHERE id_super = '".$id_super."'";
   $res = mysqli_query($conn, $query);
   $fetch = mysqli_fetch_array($res);
   /*echo "<pre>";
    die(var_dump($fetch));*/
}

if(isset($_POST['btn_update'])){
    //die(var_dump($_POST));

$id_super = $_POST["id_super"];
$nom_super = $_POST["nom_super"];
$login_super = $_POST["login_super"];
$mdp_super = $_POST["mdp_super"];


update_super($conn,$id_super,$_SESSION["id"],$nom_super,$login_super,$mdp_super);
header("location:../affichesuper.php");

}
?>
<html>
<head>
        <link href="../../css/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css">
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
                    <div class="card-header bg-success text-white">Editer super utilisateur</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" class="form-control" name="id_super" placeholder="Id" value="<?= $fetch['id_super']; ?>"><br>
                            <input type="text" class="form-control" name="nom_super" placeholder="Nom" value="<?= $fetch['nom_super']; ?>"><br>
                            <input type="text" class="form-control" name="login_super" placeholder="Login" value="<?= $fetch['login_super']; ?>"><br>
                            <input type="text" class="form-control" name="mdp_super" placeholder="Mot de passe" value="<?= $fetch['mdp_super']; ?>"><br>
                            <input type="submit" class="btn btn-primary" value="Modifier" name="btn_update">
                        </form>
                    </div>
                </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
        </section>
        <script src="../../css/jquery-3.5.1.slim.min.js"></script>
        <script src="../../css/popper.min.js"></script>
        <script src="../../css/bootstrap.min.js"></script>
    </body>
</html>