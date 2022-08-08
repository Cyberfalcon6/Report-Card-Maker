<?php
session_start();
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
if(!(isset($_POST['l0'])))
{
    header("refresh:0,index.php?comment=<i style='color:red'>Name can't be blank!</i>");

}
else {
if(isset($_POST['level']))
{
    $table = $_POST['table'];
    $exam_table = (substr($table,0,(strlen($table)-3))).("_exam").(substr($table,(strlen($table)-3),3));
    $rank_table = (substr($table,0,(strlen($table)-3))).("_rank").(substr($table,(strlen($table)-3),3));
    $total_table = (substr($table,0,(strlen($table)-3))).("_total").(substr($table,(strlen($table)-3),3));
    $level = $_POST['level'];
    if($level=='alevel')
    {
        $exam_table = (substr($table,0,(strlen($table)-3))).("_exam").(substr($table,(strlen($table)-3),3));
        $rank_table = (substr($table,0,(strlen($table)-3))).("_rank").(substr($table,(strlen($table)-3),3));
        $total_table = (substr($table,0,(strlen($table)-3))).("_total").(substr($table,(strlen($table)-3),3));
        $category = ""; 
        $counter = 0;
        $abbr = $_POST['abbr'];
        $category_in_matrix = mysqli_query($conn,"SELECT category FROM combinations WHERE abbr='$abbr'");
        foreach($category_in_matrix as $cat)
        {
            foreach($cat as $c)
            {
                if($counter==0)
                {
                    $category = $c;
                    $counter++;
                }
            }
        } 
        if(!(strcasecmp($category,"Humanities")))
        {
            $l0 = sanitize($_POST['l0']);
        $l1 = sanitize($_POST['l1']);
        $l2 = sanitize($_POST['l2']);
        $l3 = sanitize($_POST['l3']);
        $l4 = sanitize($_POST['l4']);
        $l5 = sanitize($_POST['l5']);
        $l6 = sanitize($_POST['l6']);
        $l7 = sanitize($_POST['l7']);
        $l8 = sanitize($_POST['l8']);
        $l9 = sanitize($_POST['l9']);
        $total =  intval($l0) + intval($l1) + intval($l2) + intval($l3) + intval($l4) + intval($l5) + intval($l6) + intval($l7) + intval($l8) + intval($l9); 
        
        
        $results = mysqli_query($conn,"SELECT first_lesson,second_lesson,third_lesson FROM combinations WHERE abbr='$abbr'");
        $ress = mysqli_fetch_row($results); 
        try{
            $fname = substr($l0,0,strlen($l0)-strpos($l0," "));
            $sname = substr($l0,strpos($l0," "),strlen($l0)-strpos($l0," ")-1);    
        mysqli_query($conn, "INSERT INTO $table VALUES('$l0','$l1','$l2','$l3','$l4','$l5','$l6','$l7','$l8','$l9','$total')");
        mysqli_query($conn, "INSERT INTO `students`(`First Name`,`Second Name`,`class`) VALUES('$fname','$sname','$table')");
        mysqli_query($conn,"INSERT INTO $exam_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $total_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $rank_table(`Names`) VALUES('$l0')");
        echo "Student $l0 Added Successfully!";
    }
    catch(Exception $e)
    {
        echo "Student Already Exists!";
    }
        }
    else
        { 
        $l0 = sanitize($_POST['l0']);
        $l1 = sanitize($_POST['l1']);
        $l2 = sanitize($_POST['l2']);
        $l3 = sanitize($_POST['l3']);
        $l4 = sanitize($_POST['l4']);
        $l5 = sanitize($_POST['l5']);
        $l6 = sanitize($_POST['l6']);
        $l7 = sanitize($_POST['l7']);
        $l8 = sanitize($_POST['l8']);
        $total =  intval($l0) + intval($l1) + intval($l2) + intval($l3) + intval($l4) + intval($l5) + intval($l6) + intval($l7) + intval($l8); 
        
        $abbr = $_POST['abbr'];
        $results = mysqli_query($conn,"SELECT first_lesson,second_lesson,third_lesson FROM combinations WHERE abbr='$abbr'");
        $ress = mysqli_fetch_row($results); 
    try{
        mysqli_query($conn, "INSERT INTO $table VALUES('$l0','$l1','$l2','$l3','$l4','$l5','$l6','$l7','$l8','$total')");
        mysqli_query($conn,"INSERT INTO $exam_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $total_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $rank_table(`Names`) VALUES('$l0')");
        $fname = substr($l0,0,strlen($l0)-strpos($l0," "));
        $sname = substr($l0,strpos($l0," "),strlen($l0)-strpos($l0," ")-1);
        mysqli_query($conn, "INSERT INTO `students`(`First Name`,`Second Name`,`class`) VALUES('$fname','$sname','$table')");
        echo "Student $l0 Added Successfully!";
    }
    catch(Exception $e)
    {
        echo $e;
        echo "Student Already Exists!";
    }
}}
else {
    $exam_table = $table.("_exam");
    $rank_table = $table.("_rank");
    $total_table = $table.("_total");
        $l0 = sanitize($_POST['l0']);
        $l1 = $_POST['l1'];
        $l2 = $_POST['l2'];
        $l3 = $_POST['l3'];
        $l4 = $_POST['l4'];
        $l5 = $_POST['l5'];
        $l6 = $_POST['l6'];
        $l7 = $_POST['l7'];
        $l8 = $_POST['l8'];
        $l9 = $_POST['l9'];
        $l10 = $_POST['l10'];
        $l11 = $_POST['l11'];
        $l12 = $_POST['l12'];
        $l13 = $_POST['l13'];
        $l14 = $_POST['l14'];
        $l15 = $_POST['l15'];
        $total = intval($l0 )+ intval($l1 )+ intval($l2 )+ intval($l3 )+ intval($l4 )+ intval($l5 )+ intval($l6 )+ intval($l7 )+ intval($l8 )+ intval($l9 )+ intval($l10) + intval($l11) + intval($l12) + intval($l13) + intval($l14) + intval($l15);
  
        try{
            $fname = substr($l0,0,strlen($l0)-strpos($l0," "));
            $sname = substr($l0,strpos($l0," "),strlen($l0)-strpos($l0," ")-1);
        mysqli_query($conn, "INSERT INTO $table VALUES('$l0','$l1','$l2','$l3','$l4','$l5','$l6','$l7','$l8','$l9','$l10','$l11','$l12','$l13','$l14','$l15','$total')");
        mysqli_query($conn, "INSERT INTO `students`(`First Name`,`Second Name`,`class`) VALUES('$fname','$sname','$table')");
        mysqli_query($conn,"INSERT INTO $exam_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $total_table(`Names`) VALUES('$l0')");
        mysqli_query($conn,"INSERT INTO $rank_table(`Names`) VALUES('$l0')");
        echo "Student $l0 Added Successfully!";
    }
    catch(Exception $e)
    {
        echo $e;
        echo "Student $l0 Already Exists!";
    }}
    header("refresh:0,index.php");
}

}
?>