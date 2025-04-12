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
    </head>
    <body>
    <header id="header" class="header-transparent">
    <div class="container">

    <div id="logo" class="pull-left">
        <a href="../index.php">Accueil</a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="ajoutsuper.php">Ajouter</a></li>
          <li><a href="affichesuper.php">Consulter</a></li>
          <li><a href="page.php">Retour</a></li>
          <li><a href="logout.php">D&eacute;connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <br><br><br>
    <section id="hero">
        <div align="center" class="container">
            <div>
                
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                <br><br>
                <div class="card" style="background-color: rgba(245, 245, 245, 0.4);">
                    <div class="card-header bg-success text-white">Ajouter super utilisateur</div>
                    <div class="card-body">
                        <form action="super/upload.php" method="POST" enctype="multipart/form-data">
                            <input type="text" class="form-control" name="nom_super" placeholder="Nom"><br>
                            <input type="text" class="form-control" name="login_super" placeholder="Identifiant"><br>
                            <input type="text" class="form-control" name="mdp_super" placeholder="Mot de passe"><br>
                            <input type="submit" class="btn btn-primary" value="Enregistrer">
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