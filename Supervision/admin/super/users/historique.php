<?php
include("../../../fonctions.php");
if(!verif_session_users()){
header("location:../../../users.php");
}
$query = "SELECT * FROM resultat";
$res = mysqli_query($conn, $query);
//$fetch = mysqli_fetch_array($res);
?>
<html>
<head>
        <link href="../../../css/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../../css/style.css">
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
        <a href="../../../index.php">Accueil</a>
      </div>
       <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li><a href="dashboard.php">Temps R&eacute;el</a></li>
          <li><a href="historique.php">Rapport</a></li>
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
                <div><br>
                    <div class="row">
                      <div class="col-md-6">Historiques des résultats</div>
                      <div class="col-md-3">
                        <form action="" method="POST">
                          <select name="year_select" id="year_select" class="form-control year_select">
                            <?php
                              include "../../../base.php";  // Using database connection file here
                              $records = mysqli_query($conn, "SELECT date From resultat");  // Use select query here 

                               while($data = mysqli_fetch_array($records))
                                 {
                                    echo "<option value='". $data['date'] ."'>" .$data['date'] ."</option>";  // displaying data in option menu
                                 }	
                           ?>  
                          </select>
                        </form>
                      </div>
                    </div>
                    <div align="center" class="table-repsonsive">
                        <table class="table table-bordered" style="color:white">
                            <tr>
                                <td align="center">Courant BAT</td>
                                <td align="center">Courant PV</td>
                                <td align="center">Courant</td>
                                <td align="center">Tension Bat</td>
                                <td align="center">Tension PV</td>
                                <td align="center">Tension</td>
                            </tr>
                           <tbody id="count">
                             
                           </tbody>
                        </table>
                     <a href="export.php" class="btn btn-primary">Exporter</a>
                    </div>
                </div>
            </div>
        </div>
<br><br>
         <div class="row">
           <div class="col-md-12"><div id="courant_chart" style="width: auto; height: 300px"></div></div>
       </div>
        </div>
        </section>
        <script src="css/jquery-3.5.1.slim.min.js"></script>
        <script src="css/popper.min.js"></script>
        <script src="css/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
     $('.year_select').on('change', function() {
      // alert( this.value );
          var year_number = this.value;
          //alert(year_number);
          $.ajax({
                url:'ajax.php',
                method: 'post',
                data:{year_number:year_number},
                //dataType: 'json',
                success: function(data){
                      //alert(data);
                     $("#count").html(data);
                                 
                }
          });

});
    </script>
    </body>
</html>                    