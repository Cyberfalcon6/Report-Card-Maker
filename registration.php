<?php

if(isset($_POST['fname'],$_POST['sname'],$_POST['dob'],$_POST['idno'],$_POST['class'],$_POST['province'],$_POST['district'],$_POST['sector']))
{
    $conn = mysqli_connect("localhost","root","");
    mysqli_select_db($conn,"temp");
    $fname = mysqli_real_escape_string($conn,htmlentities($_POST['fname']));
    $sname = mysqli_real_escape_string($conn,htmlentities($_POST['sname']));
    $dob = mysqli_real_escape_string($conn,htmlentities($_POST['dob']));
    $idno = mysqli_real_escape_string($conn,htmlentities($_POST['idno']));
    $class = mysqli_real_escape_string($conn,htmlentities($_POST['class']));
    if((substr($class,strlen($class)-6,6)=="olevel"))
    {
        $class = substr($class,0,strlen($class)-6);
        $exam_table = $class.("_exam");
        $rank_table = $class.("_rank");
        $total_table = $class.("_total");
    }
    else
    {
    $exam_table = (substr($class,0,(strlen($class)-3))).("_exam").(substr($class,(strlen($class)-3),3));
    $rank_table = (substr($class,0,(strlen($class)-3))).("_rank").(substr($class,(strlen($class)-3),3));
    $total_table = (substr($class,0,(strlen($class)-3))).("_total").(substr($class,(strlen($class)-3),3));
    }
    $province = mysqli_real_escape_string($conn,htmlentities($_POST['province']));
    $district = mysqli_real_escape_string($conn,htmlentities($_POST['district']));
    $sector = mysqli_real_escape_string($conn,htmlentities($_POST['sector']));
    /*echo "<div style='padding: 10px;position: relative;top: 90%;left: 55%;width: 45%;background-color: rgb(0,200,60);color: white;>' Registration Details<br>
    Name: $fname $sname<br>Date Of Birth: $dob <br>Id Number: $idno<br>Class: $class<br>Province: $province<br>District: $district<br>Sector: $sector</div>";*/
    try
    {
        mysqli_query($conn,"INSERT INTO `students`(`First Name`,`Second Name`,`dob`,`class`,`place_of_residence`,`ID NO`) VALUES('$fname','$sname','$dob','$class','$province-$district-$sector','$idno')");
        mysqli_query($conn, "INSERT INTO `$class`(`Names`) VALUES('$fname $sname')");
        mysqli_query($conn,"INSERT INTO `$exam_table`(`Names`) VALUES('$fname $sname')");
        mysqli_query($conn,"INSERT INTO `$total_table`(`Names`) VALUES('$fname $sname')");
        mysqli_query($conn,"INSERT INTO `$rank_table`(`Names`) VALUES('$fname $sname')");
    }
    catch(Exception $e)
    {
        echo $e;
    }
    mysqli_select_db($conn, "payment");
    mysqli_query($conn, "INSERT INTO `$class`(`Names`) VALUES('$fname $sname')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="rstyle.css">
    <script>
        function upd()
        {
            
            var province = document.getElementById('province').value;
            var xhr = new XMLHttpRequest;
            xhr.open("OPEN", "get_lower.php?province=".concat(province),true);
            xhr.send(null);
            xhr.onreadystatechange = function()
            {
                if(this.readyState===4)
                {
                    document.getElementById('district').innerHTML = this.responseText;
                }
            }
        }
        function get_sector()
        {
            var district = document.getElementById('district').value;
            var xhr = new XMLHttpRequest;
            xhr.open("OPEN", "get_sector.php?district=".concat(district),true);
            xhr.send(null);
            xhr.onreadystatechange = function()
            {
                if(this.readyState===4)
                {
                    document.getElementById('sector').innerHTML = this.responseText;
                }
            }
        }
        function get_cell()
        {
            var sector = document.getElementById('sector').value;
            var xhr = new XMLHttpRequest;
            xhr.open("OPEN", "get_cell.php?sector=".concat(sector),true);
            xhr.send(null);
            xhr.onreadystatechange = function()
            {
                if(this.readyState===4)
                {
                    document.getElementById('cell').innerHTML = this.responseText;
                }
            }
        }
    </script>
</head>
<body>
    <div id="leftpanel" style='display: none'><h1>Register As</h1> <br><div id="student-c"><img src="stud.png" alt="" id="stud" width="50%"><label for="">Student</label></div><div id="teacher-c"><br><img src="teacher.png" alt="" id="teacher" width="50%"><label for="teacher">teacher</label></div><br><br><br></div>
    <div id="container">
    <form action="registration.php" method="post" autocomplete="off">
        <br><br><br>
       <input type="text" required name="fname" placeholder="First Name" id=""> <br><br><br>
       <input type="text" required name="sname" placeholder="Second Name" id=""><br><br><br>Birth Date <br>
       <input type="date" name="dob" id="" placeholder="Date Of Birth(ex: 03/11/2022)" required> <br><br><br>
       <input type="text" name="idno" id="" placeholder="Identity Card Number" required> <br><br><br>
       <select name="class" id="sbox" required>
           <option value="" style="color: #999;">Select Class You attend</option>
           <?php
           $conn = mysqli_connect("localhost","root","");
           mysqli_select_db($conn, "temp");
           $results = mysqli_query($conn, "SELECT * FROM `classes` WHERE class_name NOT LIKE '%exam%' AND class_name NOT LIKE '%rank%' AND class_name NOT LIKE '%maximum%';");
           foreach($results as $res)
           {

               echo "<option value='".$res['class_name'].$res['combination']."'>".$res['class_name']."(".$res['combination'].")"."</option>";
           }
           ?>
       </select><br><br><br>
       <select onchange="upd()" name="province" id="province">
        <option value="">Select Your province</option>
        <?php
        $con = mysqli_connect("localhost","root","");
           mysqli_select_db($con, "places");
            $r = mysqli_query($con, "SELECT * FROM `provinces`");
            foreach($r as $res)
            {
              echo "<option value='".$res['name']."'>".$res['name']."</option>";
            }

        ?>
  </select>
  <select onchange="get_sector()" required name="district" id="district">

  </select>
  <select onchange="get_cell()" required name="sector" id="sector">

  </select>
  <select required name="cell" id="cell">

  </select>
  <br><br><br><br><br>

       <input type="submit" value="Signup">

    </form>
    
<div id="studentside"><h1>Student</h1></div>
<div id="teacherside"><h1>Teacher</h1></div>
</div>

</body>
</html>






<?php



?>


