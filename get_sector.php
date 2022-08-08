<?php


$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "places");
$district = $_GET['district'];
$results = mysqli_query($conn, "SELECT * FROM `sectors` WHERE `district` = '$district'");
echo "<option>Select your Sector</option>";
foreach($results as $res)
{
    echo "<option value='".$res['name']."'>".$res['name']."</option>";
}

?>