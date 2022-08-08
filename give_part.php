<?php
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['table'],$_POST['name']))
{
    $name = sanitize($_POST['name']);
    $table = sanitize($_POST['table']);
    $results = mysqli_query($conn, "SELECT Names FROM $table WHERE Names LIKE '%$name%'");
    foreach($results as $row)
    {
        foreach($row as $item)
        {
            echo "<li onclick='fil(this.innerHTML)' id='the_search'>$item </li><br>";
        }
    }

}

?>