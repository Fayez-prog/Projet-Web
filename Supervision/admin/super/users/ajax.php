<?php 
include("../../../fonctions.php");
$year = $_POST['year_number'];

$query = "SELECT * FROM resultat WHERE date = '$year'";
$res = mysqli_query($conn, $query);
foreach ($res as $key ) {
	 echo '
            <tr>
                <td align="center">'.$key["courant_bat"].'</td>
                <td align="center">'.$key["courant_pv"].'</td>
                <td align="center">'.$key["courant_ph"].'</td>
                <td align="center">'.$key["tension_bat"].'</td>
                <td align="center">'.$key["tension_pv"].'</td>
                <td align="center">'.$key["tension_ph"].'</td>
            </tr>
            ';
}

?>