<?php
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}

$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['name'],$_POST['table']))
{
    $table = $_POST['table'];
    $name = sanitize($_POST['name']);
    $exam_table = substr($_POST['table'],0,(strlen($_POST['table']))-4)."_exam".substr($_POST['table'],strlen($_POST['table'])-4,3);
    $rank_table = substr((($_POST['table'])),0,strlen($_POST['table'])-4)."_rank".substr($_POST['table'],strlen($_POST['table'])-4,3);
   try{
    mysqli_query($conn, "DELETE FROM $table WHERE Names='$name'");
    mysqli_query($conn, "DELETE FROM $exam_table WHERE Names='$name'");
    mysqli_query($conn, "DELETE FROM $rank_table WHERE Names='$name'");
   }
   catch(Exception $e)
   {
       echo "there is no student with the name $name";
   }
}


?> 