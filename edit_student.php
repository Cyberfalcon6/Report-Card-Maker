<?php


$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn,"temp");
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}

if(isset($_POST['level'],$_POST['tabb']))
{
    $table = $_POST['tabb'];
    $combination = substr($table,(strlen($table)-3),3);
    if($_POST['level']=="alevel")
    {

        $category = ""; 
        $counter = 0;
        $category_in_matrix = mysqli_query($conn,"SELECT category FROM combinations WHERE abbr='$combination'");
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
            $t0 = sanitize($_POST['0t']);
        $t1 = sanitize($_POST['1t']);
        $t2 = sanitize($_POST['2t']);
        $t3 = sanitize($_POST['3t']);
        $t4 = sanitize($_POST['4t']);
        $t5 = sanitize($_POST['5t']);
        $t6 = sanitize($_POST['6t']);
        $t7 = sanitize($_POST['7t']);
        $t8 = sanitize($_POST['8t']);
        $t9 = sanitize($_POST['9t']);
        $total = intval($t0) + intval($t1) + intval($t2) + intval($t3) + intval($t4) + intval($t5) + intval($t6) + intval($t7) + intval($t8) + intval($t9);
        mysqli_query($conn, "DELETE FROM $table WHERE Names='$t0' ");
        mysqli_query($conn, "INSERT INTO $table VALUES('$t0','$t1','$t2','$t3','$t4','$t5','$t6','$t7','$t8','$t9','$total')");
        }
        else
        {
        $t0 = sanitize($_POST['0t']);
        $t1 = sanitize($_POST['1t']);
        $t2 = sanitize($_POST['2t']);
        $t3 = sanitize($_POST['3t']);
        $t4 = sanitize($_POST['4t']);
        $t5 = sanitize($_POST['5t']);
        $t6 = sanitize($_POST['6t']);
        $t7 = sanitize($_POST['7t']);
        $t8 = sanitize($_POST['8t']);
        $total = intval($t0) + intval($t1) + intval($t2) + intval($t3) + intval($t4) + intval($t5) + intval($t6) + intval($t7) + intval($t8);
        try
        {
        mysqli_query($conn, "DELETE FROM $table WHERE Names='$t0' ");
        mysqli_query($conn, "INSERT INTO $table VALUES('$t0','$t1','$t2','$t3','$t4','$t5','$t6','$t7','$t8','$total')");
    }
    catch(Exception $e)
    {
        echo "This student Does not Exist in the class";
    }
}}
    else
    {
        $t0 = sanitize($_POST['0t']);
        $t1 = sanitize($_POST['1t']);
        $t2 = sanitize($_POST['2t']);
        $t3 = sanitize($_POST['3t']);
        $t4 = sanitize($_POST['4t']);
        $t5 = sanitize($_POST['5t']);
        $t6 = sanitize($_POST['6t']);
        $t7 = sanitize($_POST['7t']);
        $t8 = sanitize($_POST['8t']);
        $t9 = sanitize($_POST['9t']);
        $t10 = sanitize($_POST['10t']);
        $t11 = sanitize($_POST['11t']);
        $t12 = sanitize($_POST['12t']);
        $t13 = sanitize($_POST['13t']);
        $t14 = sanitize($_POST['14t']);
        $t15 = sanitize($_POST['15t']);
        $total = intval($t0 )+ intval($t1 )+ intval($t2 )+ intval($t3 )+ intval($t4 )+ intval($t5 )+ intval($t6 )+ intval($t7 )+ intval($t8 )+ intval($t9 )+ intval($t10) + intval($t11) + intval($t12) + intval($t13)+ intval($t14)+ intval($t15); 
        try{
        mysqli_query($conn, "DELETE FROM $table WHERE Names='$t0' ");
        mysqli_query($conn, "INSERT INTO $table VALUES('$t0','$t1','$t2','$t3','$t4','$t5','$t6','$t7','$t8','$t9','$t10','$t11','$t12','$t13','$t14','$t15','$total')");
        }
        catch(Exception $e)
    {
        echo "This student Does not Exist in the class";
    }
    }
}
header("refresh:0,index.php?comment=Data for ".$_POST['0t']." was edited successfully!");
?>