<?php
include("../../../fonctions.php");
if(!verif_session_super_users()){
    header("location:../../../super.php");
    }
    if(isset($_GET['id_mach'])){
        $id_machine = $_GET['id_mach'];
       $query = "SELECT * FROM machine WHERE id_machine = '".$id_machine."'";
       $res = mysqli_query($conn, $query);
       $fetch = mysqli_fetch_array($res);
       /*echo "<pre>";
        die(var_dump($fetch));*/
    }
    
    if(isset($_POST['btn_update'])){
        //die(var_dump($_POST));
    
    $id_machine = $_POST["id_machine"];
    $nom_machine   = $_POST["nom_machine"];
    $type_machine   = $_POST["type_machine"];
    $fournisseur_machine   = $_POST["fournisseur_machine"];

    
    update_machine($conn,$id_machine,$_SESSION["id"],$nom_machine,$type_machine,$fournisseur_machine);
    header("location:../afficheparametre.php");
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
                    <div class="card-header bg-success text-white">Editer machine</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" class="form-control" name="id_machine" placeholder="Id" value="<?= $fetch['id_machine']; ?>"><br>
                            <input type="text" class="form-control" name="nom_machine" placeholder="Nom" value="<?= $fetch['nom_machine']; ?>"><br>
                            <input type="text" class="form-control" name="type_machine" placeholder="Type" value="<?= $fetch['type_machine']; ?>"><br>
                            <input type="text" class="form-control" name="fournisseur_machine" placeholder="Fournisseur" value="<?= $fetch['fournisseur_machine']; ?>"><br>
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