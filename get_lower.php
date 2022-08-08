<?php


$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "places");
$province = $_GET['province'];
$results = mysqli_query($conn, "SELECT * FROM `districts` WHERE `province` = '$province'");
echo "<option>Select your district</option>";
foreach($results as $res)
{
    echo "<option value='".$res['name']."'>".$res['name']."</option>";
}

?>