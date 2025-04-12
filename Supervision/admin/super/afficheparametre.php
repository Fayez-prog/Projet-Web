<?php
include("../../fonctions.php");
if(!verif_session_super_users()){
header("location:../../super.php");
}
?>
<html>
<head>
        <link href="../../css/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css">
        <style>
            body{
                color:white;
            }
        </style>
    </head>
    <body>
    <header id="header" class="header-transparent">
    <div class="container">

    <div id="logo" class="pull-left">
        <a href="../../index.php">Accueil</a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="ajoutparametre.php">Ajouter</a></li>
          <li><a href="afficheparametre.php">Consulter</a></li>
          <li><a href="fichier.php">Ajouter Param&egrave;tre</a></li>
          <li><a href="interface.php">Retour</a></li>
          <li><a href="logout.php">D&eacute;connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <br><br><br>
     <section id="hero">
        <div class="container">
        <br><br>
        <div class="card" style="background-color: rgba(12, 12, 10, 1);">
            <div >
                <div>
                    <center>
                        <h2>Liste des machines</h2>
                    </center>
                    <div class="table-repsonsive">
                        <table class="table table-bordered" style="color:white">
                            <tr>
                                <td align="center">Nom </td>
                                <td align="center">Type</td>
                                <td align="center">Fournisseur</td>
                                <td align="center">Modifier les informations</td>
                            </tr>
                             <?php
                                foreach(listMachineAjouter($conn,$_SESSION["id"]) as $nom){
                                    $det = comptemachineparid($conn,$nom["id_machine"]);
                                    echo '
                                    <tr>
                                        <td align="center">'.$det["nom_machine"].'</td>
                                        <td align="center">'.$det["type_machine"].'</td>
                                        <td align="center">'.$det["fournisseur_machine"].'</td>
                                        <td align="center">
                                             <a href="machine/editerparametre.php?id_mach='.$det["id_machine"].'" class="btn-get-started">Editer</a>
                                             <a href="machine/supprimerparametre.php?id_mach='.$det["id_machine"].'" class="btn-get-started">Supprimer</a>
                                        </td>
                                    </tr>
                                    ';
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <script src="css/jquery-3.5.1.slim.min.js"></script>
        <script src="css/popper.min.js"></script>
        <script src="css/bootstrap.min.js"></script>
    </body>
</html>