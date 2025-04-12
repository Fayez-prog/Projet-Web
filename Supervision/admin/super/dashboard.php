<?php
include("../../fonctions.php");
if(!verif_session_super_users()){
header("location:../../super.php");
}

   $query_date = "SELECT  max(created_at) as maxDate from resultat";
   $rrr = mysqli_query($conn, $query_date);
   $res_date = mysqli_fetch_assoc($rrr);
   $min_dt = $res_date['maxDate'];
   //die(var_dump($res_date['maxDate']));

   $query_card = "SELECT * FROM resultat WHERE created_at = '$min_dt';";
   $res_card = mysqli_query($conn, $query_card);
   $fetch = mysqli_fetch_array($res_card);

   $query = "SELECT * FROM resultat";
   $res = mysqli_query($conn, $query);
   //$fetch = mysqli_fetch_array($res);

   $querytt = "SELECT * FROM resultat";
   $resulttt = mysqli_query($conn, $querytt);

?>

<!DOCTYPE HTML>
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
          <li><a href="dashboard.php">Temps R&eacute;el</a></li>
          <li><a href="historique.php">Rapport</a></li>
          <li><a href="page.php">Retour</a></li>
          <li><a href="logout.php">D&eacute;connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <br><br><br>
  <section id="hero" >
     <div class="content container-fluid">
          
          <!-- Page Header -->
          <div class="page-header">
            <div class="row">
              <div class="col-sm-12">
               <br>
                <ul class="breadcrumb" style="background-color: transparent;">
                  <li class="breadcrumb-item active" >Administration</li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /Page Header -->
      <div class="row">


        <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Courant BAT<br><br><?= $fetch['courant_bat']; ?>&nbsp;A</h6>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Courant PV <br><br><?= $fetch['courant_pv']; ?>&nbsp;A</h6>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Courant <br><br><?= $fetch['courant_ph']; ?>&nbsp;A</h6>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Tension Bat <br><br><?= $fetch['tension_bat']; ?>&nbsp; V</h6>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Tension PV <br><br><?= $fetch['tension_pv']; ?>&nbsp;V</h6>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-xl-2 col-sm-6 col-12">
              <div class="card">
                <div class="card-body">
                  <div class="dash-widget-info">
                    <h6 class="text-muted text-center">Tension <br><br><?= $fetch['tension_ph']; ?>&nbsp;V</h6>
                  </div>
                </div>
              </div>
          </div>
          

      </div>

      <!-- Page Header -->
          <div class="page-header">
            <div class="row">
              <div class="col-sm-12">
               <br>
                <ul class="breadcrumb" style="background-color: transparent;">
                  <li class="breadcrumb-item active" >Courbes représentatives</li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /Page Header -->
    <div class="row">
      <div class="col-md-6"><div id="courant_chart" style="width: auto; height: 300px"></div></div>

      <div class="col-md-6"><div id="tension_chart" style="width: auto; height: 300px"></div></div>

    </div><br><br>

    </div>

        </section>
         
        <script src="css/jquery-3.5.1.slim.min.js"></script>
        <script src="css/popper.min.js"></script>
        <script src="css/bootstrap.min.js"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    

        <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChartTension);
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

       //data courant
       var data_courant = new google.visualization.DataTable();
            var data_courant = google.visualization.arrayToDataTable([
                ['Temps', 'Courant BAT','Courant PV','Courant'],
                <?php
                    while($row = mysqli_fetch_assoc($res)){
                        echo "['".$row["time"]."', ".$row["courant_bat"].", ".$row["courant_pv"].", ".$row["courant_ph"]."],";
                    }
                ?>
               ]);
        var options_courant = {
          title: 'Courbe des courants',
          vAxis: {minValue: 0},
          legend: { position: 'bottom' },
          explorer: { 
            actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 5.0},
        };
       var courant_chart = new google.visualization.LineChart(document.getElementById('courant_chart'));
        courant_chart.draw(data_courant, options_courant);
      }

        function drawChartTension() {

           var data_tension = new google.visualization.DataTable();
            var data_tension = google.visualization.arrayToDataTable([
                ['Temps','Tension BAT','Tension PV','Tension'],
                <?php
                    while($row = mysqli_fetch_assoc($resulttt)){
                        echo "['".$row["time"]."', ".$row["tension_bat"].", ".$row["tension_pv"].", ".$row["tension_ph"]."],";
                    }
                ?>
               ]);
          var options_tension = {
          title: 'Courbe des tensions',
          vAxis: {minValue: 0},
          legend: { position: 'bottom' },
          explorer: { 
            actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'horizontal',
            keepInBounds: true,
            maxZoomIn: 5.0},
        };
        var tension_chart = new google.visualization.LineChart(document.getElementById('tension_chart'));
        tension_chart.draw(data_tension, options_tension);
      }

    </script>

       
</body>
</html>           


