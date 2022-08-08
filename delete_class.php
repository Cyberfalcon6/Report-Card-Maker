<?php
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn,"temp");
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
if(isset($_POST['cls']))
{
    $table = $_POST['cls'];
    
    if(substr($table,0,6)=="senior")
    {
        $exam_table = $table."_exam";
        $rank_table = $table."_rank";
        $maximum_table = $table."_maximum";
        $total_table = $table."_total";
        mysqli_query($conn,"DROP TABLE `$table`,`$exam_table`,`$rank_table`,`$total_table`,`$maximum_table`");
        mysqli_query($conn,"DELETE FROM `classes` WHERE class_name='$table'");
        mysqli_query($conn,"DELETE FROM `classes` WHERE class_name='$exam_table'");
        mysqli_query($conn,"DELETE FROM `classes` WHERE class_name='$rank_table'");
        mysqli_query($conn,"DELETE FROM `classes` WHERE class_name='$maximum_table'");
    }
    else {
        $table = str_replace(" ","",$table);
        $combination = substr($table,(strlen($table)-3),3);
        $cls = substr($table,0,(strlen($table)-3));
        $exam_table = (substr($table,0,(strlen($table)-3))).("_exam").(substr($table,(strlen($table)-3),3));
        $exam = (substr($table,0,(strlen($table)-3))).("_exam");
        $rank_table = (substr($table,0,(strlen($table)-3))).("_rank").(substr($table,(strlen($table)-3),3));
        $rank = (substr($table,0,(strlen($table)-3))).("_rank");
        $total_table = (substr($table,0,(strlen($table)-3))).("_total").(substr($table,(strlen($table)-3),3));
        $maximum_table = (substr($table,0,(strlen($table)-3))).("_maximum").(substr($table,(strlen($table)-3),3));
        $maximum = (substr($table,0,(strlen($table)-3))).("_maximum");
       mysqli_query($conn,"DROP TABLE `$table`,`$exam_table`,`$rank_table`,`$total_table`,`$maximum_table`");
       mysqli_query($conn,"DELETE FROM `classes`  WHERE class_name='$exam' AND combination='$combination'");
       mysqli_query($conn,"DELETE FROM `classes`  WHERE class_name='$cls' AND combination='$combination'");
       mysqli_query($conn,"DELETE FROM `classes`  WHERE class_name='$rank' AND combination='$combination'");
       mysqli_query($conn,"DELETE FROM `classes`  WHERE class_name='$maximum' AND combination='$combination'");
      header("refresh:0,index.php");
    }
    

}

?>