<?php

$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['class']))
{
    session_start();
    $username = $_SESSION['username'];
    $class = $_POST['class'];
    $_SESSION['current_class'] = $class;
    $id = 100;
    $results = mysqli_query($conn,"DESCRIBE $class ");
    //echo "<div id = 'described'><table border='1'>
    echo "<form action='add_student.php' method='POST'><input type='hidden' style='color: black' id='current_class' name='current_class' value='".$_SESSION['current_class']."'><table id='adder'><tr>";
    foreach($results as $row)
    {
        echo "<td>";
        echo "<input required  id=$id type='text' value=''></td>";
        echo "</td>";
        $id = $id + 1;
    }
   echo "</tr></table><button id='submitter' onclick='subm()' action='submit' style='color: teal;'>Save Student</button></form>";

}

?>