<?php
session_start();
if(isset($_SESSION['username']))
{
    echo "<h1>Username: ".$_SESSION['username']."<br>Password: ".$_SESSION['password']."</h1>";
}

?>