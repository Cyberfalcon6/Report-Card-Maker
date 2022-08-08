<?php
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
if(isset($_POST['class']))
{
    $class = $_POST['class'];
    $name = $_POST['name'];
    $tracker = 0;
    $results = mysqli_query($conn, "SELECT * FROM $class WHERE Names='$name'");
    foreach($results as $res)
    {
        foreach($res as $r)
        {
            $tracker = $tracker + 1;
        }
    }
    if($tracker>1)
    {
        echo "yes";
    }
    else
    {
        echo "no";
    }
}

?>