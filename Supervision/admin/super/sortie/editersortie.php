<<?php
include("../../../fonctions.php");
if(!verif_session_super_users()){
    header("location:../../../super.php");
    }
    if(isset($_GET['id_sort'])){
        $id_sortie = $_GET['id_sort'];
       $query = "SELECT * FROM sortie WHERE id_sortie = '".$id_sortie."'";
       $res = mysqli_query($conn, $query);
       $fetch = mysqli_fetch_array($res);
       /*echo "<pre>";
        die(var_dump($fetch));*/
    }
    
    if(isset($_POST['btn_update'])){
        //die(var_dump($_POST));

    $id_sortie = $_POST["id_sortie"];
    $nom_machine = $_POST["nom_machine"];
    $nom_sort1 = $_POST["nom_sort1"];
    $choix_sort1 = $_POST["choix_sort1"];
    $nom_sort2 = $_POST["nom_sort2"];
    $choix_sort2 = $_POST["choix_sort2"];
    $nom_sort3 = $_POST["nom_sort3"];
    $choix_sort3 = $_POST["choix_sort3"];
    $nom_sort4 = $_POST["nom_sort4"];
    $choix_sort4 = $_POST["choix_sort4"];
    $nom_sort5 = $_POST["nom_sort5"];
    $choix_sort5 = $_POST["choix_sort5"];
    $nom_sort6 = $_POST["nom_sort6"];
    $choix_sort6 = $_POST["choix_sort6"];

update_sortie($conn,$id_sortie,$_SESSION["id"],$nom_machine,$nom_sort1,$choix_sort1,$nom_sort2,$choix_sort2,$nom_sort3,$choix_sort3,$nom_sort4,$choix_sort4,$nom_sort5,$choix_sort5,$nom_sort6,$choix_sort6);
header("location:../affichesortie.php");
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
                    <div class="card-header bg-success text-white">Editer entr&eacute;es / sorties numériques</div>
                    <div class="card-body">
                        <form action="" method="POST">
                           <table align="center">
                            <input type="hidden" class="form-control" name="id_sortie" placeholder="Id" value="<?= $fetch['id_sortie']; ?>"><br>
                            <input type="text" class="form-control" name="nom_machine" placeholder="Nom machine" value="<?= $fetch['nom_machine']; ?>"><br>
                            <tr><td>
                            <input type="text" class="form-control" name="nom_sort1" placeholder="Nom sortie1" value="<?= $fetch['nom_sort1']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort1" placeholder="Choix sortie1" value="<?= $fetch['choix_sort1']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_sort2" placeholder="Nom sortie2" value="<?= $fetch['nom_sort2']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort2" placeholder="Choix sortie2" value="<?= $fetch['choix_sort2']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_sort3" placeholder="Nom sortie3" value="<?= $fetch['nom_sort3']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort3" placeholder="Choix sortie3" value="<?= $fetch['choix_sort3']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_sort4" placeholder="Nom sortie4" value="<?= $fetch['nom_sort4']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort4" placeholder="Choix sortie4" value="<?= $fetch['choix_sort4']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_sort5" placeholder="Nom sortie5" value="<?= $fetch['nom_sort5']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort5" placeholder="Choix sortie5" value="<?= $fetch['choix_sort5']; ?>"><br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_sort6" placeholder="Nom sortie6" value="<?= $fetch['nom_sort6']; ?>"><br>
                            </td><td>
                            <input type="text" class="form-control" name="choix_sort6" placeholder="Choix sortie6" value="<?= $fetch['choix_sort6']; ?>"><br>
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