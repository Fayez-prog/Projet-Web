<<?php
include("../../../fonctions.php");
if(!verif_session_super_users()){
    header("location:../../../super.php");
    }
    if(isset($_GET['id_ent'])){
        $id_entre = $_GET['id_ent'];
       $query = "SELECT * FROM entre WHERE id_entre = '".$id_entre."'";
       $res = mysqli_query($conn, $query);
       $fetch = mysqli_fetch_array($res);
       /*echo "<pre>";
        die(var_dump($fetch));*/
    }
    
    if(isset($_POST['btn_update'])){
        //die(var_dump($_POST));

    $id_entre = $_POST["id_entre"];
    $nom_machine = $_POST["nom_machine"];
    $nom_ent1 = $_POST["nom_ent1"];
    $choix_ent1 = $_POST["choix_ent1"];
    $nom_ent2 = $_POST["nom_ent2"];
    $choix_ent2 = $_POST["choix_ent2"];
    $nom_ent3 = $_POST["nom_ent3"];
    $choix_ent3 = $_POST["choix_ent3"];
    $nom_ent4 = $_POST["nom_ent4"];
    $choix_ent4 = $_POST["choix_ent4"];
    $nom_ent5 = $_POST["nom_ent5"];
    $choix_ent5 = $_POST["choix_ent5"];
    $nom_ent6 = $_POST["nom_ent6"];
    $choix_ent6 = $_POST["choix_ent6"];

update_entre($conn,$id_entre,$_SESSION["id"],$nom_machine,$nom_ent1,$choix_ent1,$nom_ent2,$choix_ent2,$nom_ent3,$choix_ent3,$nom_ent4,$choix_ent4,$nom_ent5,$choix_ent5,$nom_ent6,$choix_ent6);
header("location:../afficheentre.php");
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
                    <div class="card-header bg-success text-white">Editer entr&eacute;es / sorties analogiques</div>
                    <div class="card-body">
                        <form action="" method="POST">
                           <table align="center">
                            <input type="hidden" class="form-control" name="id_entre" placeholder="Id" value="<?= $fetch['id_entre']; ?>"><br>
                            <input type="text" class="form-control" name="nom_machine" placeholder="Nom machine" value="<?= $fetch['nom_machine']; ?>"><br>
                            <tr><td>
                            <input type="text" class="form-control" name="nom_ent1" placeholder="Nom entr&eacute;e1" value="<?= $fetch['nom_ent1']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent1" placeholder="Choix entr&eacute;e1" value="<?= $fetch['choix_ent1']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent2" placeholder="Nom entr&eacute;e2" value="<?= $fetch['nom_ent2']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent2" placeholder="Choix entr&eacute;e2" value="<?= $fetch['choix_ent2']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent3" placeholder="Nom entr&eacute;e3" value="<?= $fetch['nom_ent3']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent3" placeholder="Choix entr&eacute;e3" value="<?= $fetch['choix_ent3']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent4" placeholder="Nom entr&eacute;e4" value="<?= $fetch['nom_ent4']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent4" placeholder="Choix entr&eacute;e4" value="<?= $fetch['choix_ent4']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent5" placeholder="Nom entr&eacute;e5" value="<?= $fetch['nom_ent5']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent5" placeholder="Choix entr&eacute;e5" value="<?= $fetch['choix_ent5']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent6" placeholder="Nom entr&eacute;e6" value="<?= $fetch['nom_ent6']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_ent6" placeholder="Choix entr&eacute;e6" value="<?= $fetch['choix_ent6']; ?>"><br>
                            </td></tr></table>
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