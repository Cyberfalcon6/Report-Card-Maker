<?php
if(isset($_GET['abbr']))
{
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
$abbr = $_GET['abbr'];
$results = mysqli_query($conn,"SELECT first_lesson,second_lesson,third_lesson FROM combinations WHERE abbr LIKE '%$abbr%'");
echo "<ul>";
foreach($results as $row)
{
    echo "<li>";
    foreach($row as $item)
    {
        echo "$item  ";
    }
    echo "</li>";
}
echo "</ul>";
}
?>