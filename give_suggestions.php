<?php
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['class'],$_POST['short']))
{
    $name = sanitize($_POST['short']);
    $table = sanitize($_POST['class']);
    $results = mysqli_query($conn, "SELECT Names FROM $table WHERE Names LIKE '%$name%'");
    foreach($results as $row)
    {
        foreach($row as $item)
        {
            echo "<li onclick='report(this.innerHTML)' id='the_search'>$item </li><br>";
        }
    }

}

?>