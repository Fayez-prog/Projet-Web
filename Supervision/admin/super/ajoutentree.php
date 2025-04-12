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
        <div align="center" class="container">
            <div>
                
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                <br><br>
                <div class="card" style="background-color: rgba(245, 245, 245, 0.4);">
                    <div class="card-header bg-success text-white">Ajouter entr&eacute;es / sorties analogiques</div>
                    <div class="card-body">
                        <form action="entr&eacute;e/register.php" method="POST" enctype="multipart/form-data">
                           <table align="center">
                            <input type="text" class="form-control" name="nom_machine" placeholder="Nom machine"><br>
                            <tr><td>
                            <input type="text" class="form-control" name="nom_ent1" placeholder="GPIO"><br>
                            </td><td>
                            <select name="choix_ent1" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent2" placeholder="GPIO"><br>
                            </td><td>
                           <select name="choix_ent2" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent3" placeholder="GPIO"><br>
                            </td><td>
                            <select name="choix_ent3" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent4" placeholder="GPIO"><br>
                            </td><td>
                           <select name="choix_ent4" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent5" placeholder="GPIO"><br>
                            </td><td>
                            <select name="choix_ent5" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr><tr><td>
                            <input type="text" class="form-control" name="nom_ent6" placeholder="GPIO"><br>
                            </td><td>
                            <select name="choix_ent6" id="choix" class="form-control year_select">
                            <?php
                              include "../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT choix From choix");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['choix'] ."'>" .$data['choix'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select> <br>
                            </td></tr></table>
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