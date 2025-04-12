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
          <li><a href="ajoutentree.php">Ajouter</a></li>
          <li><a href="afficheentre.php">Consulter</a></li>
          <li><a href="fichier.php">Retour</a></li>
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
                        <h2>Liste des entr&eacute;es / sorties analogiques</h2>
                    </center>
                    <div class="table-repsonsive">
                        <table class="table table-bordered" style="color:white">
                            <tr>
                                <td align="center">Nom machine</td>
                                <td align="center">Nom port1</td>
                                <td align="center">Choix port1</td>
                                <td align="center">Nom port2</td>
                                <td align="center">Choix port2</td>
                                <td align="center">Nom port3</td>
                                <td align="center">Choix port3</td>
                                <td align="center">Nom port4</td>
                                <td align="center">Choix port4</td>
                                <td align="center">Nom port5</td>
                                <td align="center">Choix port5</td>
                                <td align="center">Nom port6</td>
                                <td align="center">Choix port6</td>
                                <td align="center">Modifier les informations</td>
                            </tr>
                             <?php
                                foreach(listEntreeAjouter($conn,$_SESSION["id"]) as $nom){
                                    $det = compteentreeparid($conn,$nom["id_entre"]);
                                    echo '
                                    <tr>
                                        <td align="center">'.$det["nom_machine"].'</td>
                                        <td align="center">'.$det["nom_ent1"].'</td>
                                        <td align="center">'.$det["choix_ent1"].'</td>
                                        <td align="center">'.$det["nom_ent2"].'</td>
                                        <td align="center">'.$det["choix_ent2"].'</td>
                                        <td align="center">'.$det["nom_ent3"].'</td>
                                        <td align="center">'.$det["choix_ent3"].'</td>
                                        <td align="center">'.$det["nom_ent4"].'</td>
                                        <td align="center">'.$det["choix_ent4"].'</td>
                                        <td align="center">'.$det["nom_ent5"].'</td>
                                        <td align="center">'.$det["choix_ent5"].'</td>
                                        <td align="center">'.$det["nom_ent6"].'</td>
                                        <td align="center">'.$det["choix_ent6"].'</td>
                                        <td align="center">
                                             <a href="entr&eacute;e/editerentre.php?id_ent='.$det["id_entre"].'"  class="btn-get-started">Editer</a>
                                             <a href="entr&eacute;e/supprimerentre.php?id_ent='.$det["id_entre"].'" " class="btn-get-started">Supprimer</a>
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