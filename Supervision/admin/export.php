<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
$csv = '';
$csv_nom = 'fichier.csv';
$mysqli = mysqli_connect("sql4.freesqldatabase.com", "sql4425068", "JS6dPCwvgA", "sql4425068");
$result = mysqli_query($mysqli, "SELECT id_resultat, courant_bat, courant_pv, courant_ph, tension_bat, tension_pv, tension_ph, date, time FROM resultat");
$champ = mysqli_num_fields($result);
for($i = 0; $i < $champ; $i++) 
{
  $csv.= mysqli_fetch_field_direct($result, $i)->name.';';
}
$csv.= '
';
while($row = mysqli_fetch_array($result)) 
{
  for($i = 0; $i < $champ; $i++) 
  {
    $csv.= '"'.$row[mysqli_fetch_field_direct($result, $i)->name].'";';
  }
  $csv.= '
  ';
}
header("Content-type: text/x-csv; charset=utf-8");
header("Content-Disposition: attachment; filename=".$csv_nom."");
echo $csv;
mysqli_close($mysqli);
?>