<?php
if(isset($_POST['clas']))
{
    $table = $_POST['clas'];
    $combination = $_POST['combination'];
    $is_maximum = $_POST['is_maximum'];
    $is_rank = $_POST['is_rank'];
    $conn = mysqli_connect("localhost","root","");
    $is_norm = $_POST['is_norm'];
    $title = "";
    if($_POST['level']=='alevel')
    {
        $title = $table." ".$combination;
    }
    else
    {
        $title = $table;
    }
    mysqli_select_db($conn, "temp");
    echo "<h1 id='titl' style='top: 11%;position: fixed;left: 40%;'>$title </h1><div name='container'><div id='crea'></div> ";

    echo "<table  border='1'><div id='table'>";
    if($_POST['level']=='alevel'){ 
        $row_tracker = 0;
        $id = 0;
        $all = $table.$combination; 
        echo "<input type='hidden' value='".$all."' id='table_keeper' disabled>" ;
        $results = mysqli_query($conn,"SELECT * FROM $all WHERE 1");
        $ress = mysqli_query($conn,"SELECT * FROM combinations WHERE abbr='$combination'");
        $category = "";
        $category_in_matrix = mysqli_query($conn, "SELECT category FROM combinations WHERE abbr='$combination'");
        $full_words = mysqli_fetch_row($ress);
        $counter = 0;
        $lengt = 0;
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
        $last_column = "";
        if($is_rank=="true")
        {
            $last_column = "General Rank";
        }
        else
        {
            $last_column = "Total";
        }
    if(!(strcasecmp($category,"Science")))
    {
        $lengt = 9;
        echo "<thead><td>Name</td><td>".$full_words[1]."</td><td>".$full_words[2]."</td><td>".$full_words[3]."</td><td>Entrepreneurship</td><td>General Studies</td><td>Sports</td><td>Religious</td><td>kinyarwanda</td><td>$last_column</td></thead>";
    }
    elseif (!(strcasecmp($category,"Languages"))) {
        $lengt = 9;
        echo "<thead><td>Name</td><td>".$full_words[1]."</td><td>".$full_words[2]."</td><td>".$full_words[3]."</td><td>Entrepreneurship</td><td>General Studies</td><td>Sports</td><td>Religious</td><td>kiswahili</td><td>$last_column</td></thead>";
    }
    else {
        $lengt = 10;
        echo "<thead><td>Name</td><td>".$full_words[1]."</td><td>".$full_words[2]."</td><td>".$full_words[3]."</td><td>Entrepreneurship</td><td>General Studies</td><td>Sports</td><td>Religious</td><td>kinyarwanda</td><td>Sub-Mathematics<td>$last_column</td></thead>";
    }
    foreach($results as $row )
    {
    echo "<tr>";
    $column_tracker = 0;
    foreach($row as $item)
    {
        if($row_tracker==0)
        {
            echo "<td style='min-width: fit-content;'><input type='text' value='"."$item' id='".$id."' style='min-width: fit-content;' disabled></td>";
            $id = $id + 1;
            
        }
        else{
        if($column_tracker==0)
        {
            echo "<td style='min-width: fit-content;'><input type='text' value='"."$item' style='width: 220px;min-width: fit-content'></td>";

        }
        else
        {
                echo "<td style='min-width: fit-content;'><input type='text' value='"."$item' style='min-width: fit-content;' disabled></td>";
        }
            $column_tracker = $column_tracker + 1;
        }
    }
    $row_tracker = $row_tracker + 1;
    echo "</tr>";   
    }
    

    if($is_maximum=="true")
    {
        echo "<div id='configurations'><img src='edit.png' width='4%' height='initial' id='pen_editor' onclick='edit()'><input type='hidden' id='lengt' value=$lengt></div></div></div></div></table><br><br>";
    }
    else
    {
        if($is_rank=="true")
        {
            echo "<div id='configurations' height='10%'><input type='hidden' id='lengt' value=$lengt><img src='images/update.png' width='6%'  id='updater' onclick='update_rank()' ></div></div></table><br><br>";
        }
        else
        {
            if($is_norm == "true")
            {
            echo "<div id='configurations'><img src='add.png' onclick='create_student(this.id)' id='$all' width='4%' height='initial' ><img src='edit.png' width='4%' height='50%' id='pen_editor' onclick='edit()'><div id='db'> <input type='text' placeholder='student to delete ' id='chooser' oninput='get_part()'> <div id='fail'></div><div id='ender'><img src='delete.png' id='".$all."d"."' onclick='delet(this.id)' width='4%' height='50%' ><input type='hidden' id='lengt' value=$lengt></div></div></div></div></table><br><br>";
            }
            else {
                echo "<div id='configurations'><img src='edit.png' width='4%' height='50%' id='pen_editor' onclick='edit()'><input type='hidden' id='lengt' value=$lengt></div></div></table><br><br>";
            }
    }
        
    }
}   
else
{
    $row_tracker = 0;
    $id = 0;
    echo "<input type='hidden' value='".$table."' id='table_keeper' disabled>" ;
    $results = mysqli_query($conn,"SELECT * FROM $table WHERE 1");
    if($is_rank=="true")
    {
        echo "<thead><td>Name</td><td>Mathematics</td><td>Physics</td><td>Chemistry</td><td>Biology</td><td>History</td><td>Geography</td><td>English</td><td>French</td><td>Kiswahili</td><td>farming</td><td>(I.C.T) </td><td>Entrepreneurship</td><td>Sports</td><td>Religious</td><td>kinyarwanda</td><td>(<b>General Rank</b>)</td></thead>";    
    }
    else
    {
    echo "<thead><td>Name</td><td>Mathematics</td><td>Physics</td><td>Chemistry</td><td>Biology</td><td>History</td><td>Geography</td><td>English</td><td>French</td><td>Kiswahili</td><td>farming</td><td>(I.C.T) </td><td>Entrepreneurship</td><td>Sports</td><td>Religious</td><td>kinyarwanda</td><td>(<b>Total</b>)</td></thead>";
    }
    foreach($results as $row )
    {
    echo "<tr>";
    $column_tracker = 0;
    foreach($row as $item)
    {
        
        if($row_tracker==0)
        {
            $id = $id + 1;
        }
        
        if($column_tracker==0)
        {
            echo "<td><input type='text' value='"."$item' style='width: 220px;'></td>";

        }
        else
        {
                echo "<td ><input type='text' value='"."$item' disabled></td>";
        }
            $column_tracker = $column_tracker + 1;
        
        
    }
    $row_tracker = $row_tracker + 1;
    echo "</tr>";
}
if($is_maximum=="true")
{
    echo "<div id='configurations'><img src='edit.png' width='4%' height='50%' id='pen_editor' onclick='edit()'><input type='hidden' id='lengt' value='16'></div></div></div></div></table><br><br>";
}
else
{
    if($is_rank=="true")
        {
            echo "<div id='configurations'><input type='hidden' id='lengt' value='16'><img src='images/update.png' width='6%' id='updater' onclick='update_rank()' ></div></table><br><br>";
        }
        else
        {
            if($is_norm=="true")
            {
                echo "<div id='configurations'><img src='add.png' onclick='create_student(this.id)' id='$table' width='4%' height='50%' ><img src='edit.png' width='4%' height='50%' id='pen_editor' onclick='edit()'><div id='db'> <input type='text' placeholder='student to delete' id='chooser' oninput='get_part()'> <div id='fail'></div><div id='ender'><img src='delete.png' id='".$table."d"."' onclick='delet(this.id)' width='4%' height='50%' ><input type='hidden' id='lengt' value='16'></div></div></div></div></table><br><br>";
            }
            else {
                echo "<div id='configurations'><img src='edit.png' width='4%' height='50%' id='pen_editor' onclick='edit()'><input type='hidden' id='lengt' value='16'></div></div></table><br><br>";
            }
            
        }
}

}
}
?>