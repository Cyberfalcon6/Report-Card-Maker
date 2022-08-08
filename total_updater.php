<?php

$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
if(isset($_POST['table']))
{

    $table = ($_POST['table']);
    $table = str_replace("_rank","",$table);
    $table = str_replace("_maximum","",$table);
    $table = str_replace("_exam","",$table);
    if(substr($table,0,6)=="senior" || substr($table,0,6)=="SENIOR")
    {
        $exam_table = $table."_exam";
        $total_table = $table."_total";
    }
    else {
        $exam_table = (substr($table,0,(strlen($table)-3))).("_exam").(substr($table,(strlen($table)-3),3));
        $total_table = (substr($table,0,(strlen($table)-3))).("_total").(substr($table,(strlen($table)-3),3));
        
        
    }
    //$combination = substr($normal_table,(strlen($normal_table)-3),3);
    $results = mysqli_query($conn, "SELECT `Names` FROM $total_table");
    $columns = mysqli_query($conn, "DESCRIBE `$total_table`");
    foreach($results as $res)
    {
        $current_name = $res['Names'];
        echo ">>$current_name";
        foreach($columns as $row)
        {
            if($row['Field']!="Names")
            {
                $total_marks = 0;
                $c = $row['Field'];
                $test_marks = mysqli_query($conn, "SELECT `".$row['Field']."` FROM $table WHERE Names='$current_name'");
                foreach($test_marks as $t)
                {
                     $total_marks = $total_marks + $t[$c];
                }
                $exam_marks = mysqli_query($conn, "SELECT `".$row['Field']."` FROM $exam_table WHERE Names='$current_name'");
                foreach($exam_marks as $exa)
                {
                    
                    $total_marks = $total_marks + $exa[$c];
                }
                mysqli_query($conn,"UPDATE `$total_table` SET `$c`='$total_marks' WHERE `Names`='$current_name'");
            }
        }
    }
}


?>