<?php


$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "places");
$sector = $_GET['sector'];
$results = mysqli_query($conn, "SELECT * FROM `cells` WHERE `sector` = '$sector'");
echo "<option>Select your Sector</option>";
foreach($results as $res)
{
    echo "<option value='".$res['name']."'>".$res['name']."</option>";
}

?>