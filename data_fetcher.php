<?php

$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['name'],$_POST['table']))
{
    $name = mysqli_real_escape_string($conn, htmlentities($_POST['name']));
    $table = mysqli_real_escape_string($conn, htmlentities($_POST['table']));
    $results = mysqli_query($conn, "SELECT * FROM $table WHERE Names='$name'");
    if(!$results)
    {
        echo 0;
    }
    else
    {foreach($results as $row )
    {
        foreach($row as $item)
        {
            echo " $item";
        }
    }
}
}

?>