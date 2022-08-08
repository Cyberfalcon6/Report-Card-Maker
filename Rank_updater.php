<?php
function sanitize($x)
{
    $conn = mysqli_connect("localhost","root","");
    return mysqli_real_escape_string($conn, htmlentities(stripslashes($x)));
}
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
session_start();
if(isset($_POST['table']))
{

    $table = sanitize($_POST['table']);
    $normal_table = str_ireplace("_rank","_total",$table);
    $counter = 0;
    $fields = $conn->query("DESCRIBE ".$table);
    $is_first = 0;
    foreach($fields as $row)
    {
        
        if($counter==0)
        {
            $counter = $counter + 1;
            continue;
        }
        else
        {
            $rank = 1;
                
                $st = $row['Field'];
                if($st=="General Rank")
                {
                    $st = "total";
                }
            $results = mysqli_query($conn,"SELECT `Names`,`$st` FROM $normal_table WHERE 1 ORDER BY `$st` DESC");
            foreach($results as $res)
            {
                $st = $row['Field'];
                $nm = $res['Names'];
               echo "$st :  $nm  :   $rank";
               
                mysqli_query($conn,"UPDATE $table SET `$st`=$rank WHERE Names='$nm' ");
                $rank = $rank + 1;
            
            }
            
            $is_first = $is_first + 1;
            
            
        }
    }
}


?>