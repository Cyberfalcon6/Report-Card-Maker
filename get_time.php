<?php

session_start();
if(isset($_SESSION['username']))
{
    echo $_SESSION['username'];
    echo date("Y_j_H_i",time());
}
else
{
    echo "username not sent!";
}

?>