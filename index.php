<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php session_start(); if(isset($_SESSION['username'])){echo $_SESSION['username'];}else{echo "Marks";}?></title>
    <link rel='stylesheet' href='style.css'>
    <script src='js.js'></script>
    <script>
       function annoy()
       {
           alert("Bye");
       }
      document.onscroll = function()
      {
          if(scrollY>10)
          {
            document.getElementById('titl').style = "top: 11%;left: 0%;font-size: medium;transition: .5s ease-in-out;position: fixed;";
          }
          else
          {
            document.getElementById('titl').style = "top: 10%;left: 40%;font-size: xx-large;transform: rotate(0deg);transition: .5s ease-in-out;position: fixed;";
          }
      }

    </script>
    <style>
        #crea
        {
            position: absolute;
            top: 0%;
            left: -5%;
            width: 5%;
            transition: .5s;
        }
    </style>
</head>
<body onunload="annoy()" onload='setup();test1();comment_remover();expand()'>
<div id="container"></div>
<input type="checkbox" name="expanded" id="expanded" hidden>
<nav></nav>
<?php

$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
$table = [];
$ind = 0;
$combinations = [];
if(isset($_SESSION['username'],$_SESSION['password']))
{
    if(isset($_GET['comment']))
    {
        echo "<div id='comment'>".$_GET['comment']."</div>";
    }
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $class = mysqli_query($conn, "SELECT class_name,combination FROM classes WHERE teacher='$username'"); //this is selecting classes of the current user 
    
    foreach($class as $row)
    {
         $table[$ind] = $row['class_name'];
         $combinations[$ind] = $row['combination'];
         $ind=$ind+1;
    }
    $combinations_indexer = 0;
    

}
else
{
    header("refresh:0,login.php?error=Login First");
}



?>
<div id="controls">
<div id="menu">
<?php   echo "<img src='images/".$_SESSION['photo']."' id='prof' width='20%' style='position: absolute;top: 5%;left: 50%;border: 1px solid white;border-radius: 360px;transition 4s;' alt=>";
echo "<ul>";
    
    if(isset($_SESSION['username'],$_SESSION['password']))
    {
        echo "<div id='user'><h1>$username</h1></div>";
        if($table>0)
    {
    foreach($table as $cal){
    echo "<li id='$combinations_indexer+500' onclick='get_table(this.id)' style='visibility: hidden' name='line' ><i >$cal </i><i>$combinations[$combinations_indexer]</i></li>";
    $combinations_indexer++;
}



}
        
echo "
<li><i><a href='make a class.php'> <label>Add A class</label> </a></i></li> 
<li> <a href='logout.php'><label>Logout</label></a></li>
";
    }
    else
    {
        echo "<i><li ><a href='login.php'><img src='login.jpg' width='25px'  > <label>Login</label></a></li></i>";
    }
?>
</ul>
</div>
</div>
<input type="checkbox" name="" id="shaker" hidden>
<img src="cross.jpg" id='menu_button' onclick='expand()' width='40px' >
<input type='checkbox' hidden  id='editable'>
<div id="reserved"></div>
 <a id="refresh" href="index.php?comment=Student Added Successfully!" hidden></a> 
 <a id="refresh2" href="index.php?comment=Student Deleted SuccessFully!" hidden></a>
 <div id='report_maker' hidden>
     <form action="report.php" method="post" autocomplete="off"> 
        <input type="hidden" name="class" id="classs">
        <input type="text" name="name" oninput="get_suggestions()" id="rbox" style="width: 23vw;background-color: white;border-radius: 10px;border: 1px solid rgb(211, 15, 80);" name="" placeholder="Student for whom you want to make report" id="">
        <input type="checkbox" hidden required id="rcheck">
        <i id="make" onclick="make_report()" style=" background-color: teal;border-radius: 10px;width: min-content;"><img src="book.png" style="display: inline;" id="book" width="60px" alt=""> </i>
    </form><div id="suggestions"></div></div>
 
<form action="delete_class.php" method="post"><div id="delete_class_pane"><img src="bin.png" alt="Delete" onclick="show_tbox()" id="bin"><input type="text" name="cls" id="tbox" placeholder="Class to delete" required hidden><button style="background: none;border: none;" hidden id="su" onclick="submit()"><img src="delete.png" width="30px" alt=""></button><input type="checkbox" style="background-color: aqua;color: black;" name="" hidden id="tbox_check"> </div></form>
<form action="whole_class.php" method="post"><input type="text" hidden id='se' name='class'><img src="link.png" hidden alt="" id='cl' onclick='s()'></form>
    </body>
</html>