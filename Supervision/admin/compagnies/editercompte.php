<?php
include("../../fonctions.php");
if(!verif_session_admin()){
header("location:../../admin.php");
}

if(isset($_GET['id_ent'])){
    $id_entreprise = $_GET['id_ent'];
   $query = "SELECT * FROM entreprise WHERE id_entreprise = '".$id_entreprise."'";
   $res = mysqli_query($conn, $query);
   $fetch = mysqli_fetch_array($res);
   /*echo "<pre>";
    die(var_dump($fetch));*/
}

if(isset($_POST['btn_update'])){
    //die(var_dump($_POST));

$id_entreprise = $_POST["id_entreprise"];
$nom_entreprise = $_POST["nom_entreprise"];
$localisation_entreprise = $_POST["localisation_entreprise"];
$email_entreprise = $_POST["email_entreprise"];
$tel_entreprise = $_POST["tel_entreprise"];
$web_entreprise = $_POST["web_entreprise"];

update_entreprise($conn,$id_entreprise,$_SESSION["id"],$nom_entreprise,$localisation_entreprise,$email_entreprise,$tel_entreprise,$web_entreprise);
header("location:../affichecompagnie.php");

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
                    <div class="card-header bg-success text-white">Editer entreprise</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" class="form-control" name="id_entreprise" placeholder="Id" 
                            value="<?= $fetch['id_entreprise']; ?>"><br>
                            <input type="text" class="form-control" name="nom_entreprise" placeholder="Nom" 
                            value="<?= $fetch['nom_entreprise']; ?>"><br>
                            <input type="text" class="form-control" name="localisation_entreprise" placeholder="Localisation" 
                            value="<?= $fetch['localisation_entreprise']; ?>"><br>
                            <input type="text" class="form-control" name="email_entreprise" placeholder="Email" 
                            value="<?= $fetch['email_entreprise']; ?>"><br>
                            <input type="text" class="form-control" name="tel_entreprise" placeholder="Numéro de téléphone" 
                            value="<?= $fetch['tel_entreprise']; ?>"><br>
                            <input type="text" class="form-control" name="web_entreprise" placeholder="Site web" 
                            value="<?= $fetch['web_entreprise']; ?>"><br>
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