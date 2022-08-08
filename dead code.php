$results = mysqli_query($conn,"SELECT * FROM $cal WHERE 1");
    echo "<br><br>";
    echo "<input type='hidden' value='"."$username' id='username'><input type='hidden' value='"."$password' id='password'>";
    echo "<div id='container' name='container'><h1>$cal $combinations[$combinations_indexer] </h1>";

    echo "<table border='1'>";
    $id = 0;
    echo "<thead><td>Names</td><td>Paid</td><td>Remaining</td><td>comment</td></thead>";
    foreach($results as $row )
    {
    echo "<tr>";
    foreach($row as $item)
    {
        
        echo "<td><input type='text' id='$id' value='"."$item' ></td>";
        $id=$id+1;
        
    }
    echo "</tr>";
}
echo "</table><img src='cross.jpg' id='student_adder' width='5%'> </div><br><br>";
$combinations_indexer = $combinations_indexer + 1;