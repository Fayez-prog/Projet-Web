<?php
include("../../../fonctions.php");
if(!verif_session_super_users()){
    header("location:../../../super.php");
    }
    if(isset($_GET['id_dep'])){
        $id_departement = $_GET['id_dep'];
       $query = "SELECT * FROM departement WHERE id_departement = '".$id_departement."'";
       $res = mysqli_query($conn, $query);
       $fetch = mysqli_fetch_array($res);
       /*echo "<pre>";
        die(var_dump($fetch));*/
    }
    
    if(isset($_POST['btn_update'])){
        //die(var_dump($_POST));
    
    $id_departement = $_POST["id_departement"];
    $nom_departement = $_POST["nom_departement"];
    $slot_departement = $_POST["slot_departement"];
    $emplacement_departement = $_POST["emplacement_departement"];

    
    
    update_departement($conn,$id_departement,$_SESSION["id"],$nom_departement,$slot_departement,$emplacement_departement,$nbusers_departement,$nbmachine_departement);
    header("location:../affichedepartement.php");
    
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
                    <div class="card-header bg-success text-white">Editer Les D&eacute;partements</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" class="form-control" name="id_departement" placeholder="Id" value="<?= $fetch['id_departement']; ?>"><br>
                            <input type="text" class="form-control" name="nom_departement" placeholder="Nom" value="<?= $fetch['nom_departement']; ?>"><br>
                            <input type="text" class="form-control" name="slot_departement" placeholder="Slot" value="<?= $fetch['slot_departement']; ?>"><br>
                            <input type="text" class="form-control" name="emplacement_departement" placeholder="Emplacement" value="<?= $fetch['emplacement_departement']; ?>"><br>
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