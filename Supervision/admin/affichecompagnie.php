<?php
include("../fonctions.php");
if(!verif_session_admin()){
header("location:../admin.php");
}
?>
<html>
<head>
        <link href="../css/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
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
        <a href="../index.php">Accueil</a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="ajoutcompagnie.php">Ajouter</a></li>
          <li><a href="affichecompagnie.php">Consulter</a></li>
          <li><a href="page.php">Retour</a></li>
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
                        <h2>Liste les entreprises</h2>
                    </center>
                    <div class="table-repsonsive">
                        <table class="table table-bordered" style="color:white">
                            <tr>
                                <td align="center">Nom</td>
                                <td align="center">Localisation</td>
                                <td align="center">Email</td>
                                <td align="center">Num&eacute;ro de t&eacute;l&eacute;phone</td>
                                <td align="center">Site web</td>
                                <td align="center">Modifier les informations</td>
                            </tr>

                            <?php
                                
                                
                                foreach(listCompteEntrepriseAjouter($conn,$_SESSION["id"]) as $nom){
                                    $det = compteentrepriseparid($conn,$nom["id_entreprise"]);
                                    echo '
                                    <tr>
                                        <td align="center">'.$det["nom_entreprise"].'</td>
                                        <td align="center">'.$det["localisation_entreprise"].'</td>
                                        <td align="center">'.$det["email_entreprise"].'</td>
                                        <td align="center">'.$det["tel_entreprise"].'</td>
                                        <td align="center">'.$det["web_entreprise"].'</td>
                                        <td align="center">
                                             <a href="compagnies/editercompte.php?id_ent='.$det["id_entreprise"].'" class="btn-get-started">Editer</a>
                                             <a href="compagnies/supprimercompte.php?id_ent='.$det["id_entreprise"].'" class="btn-get-started">Supprimer</a>
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
        </div>
        </section>
        <script src="css/jquery-3.5.1.slim.min.js"></script>
        <script src="css/popper.min.js"></script>
        <script src="css/bootstrap.min.js"></script>
    </body>
</html>