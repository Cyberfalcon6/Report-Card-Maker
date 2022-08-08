<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time</title>
    <script>
    
    function get_time()
    {
        
        var xhr = new XMLHttpRequest;
        xhr.open("GET","get_time.php",true);
        xhr.send(null);
        xhr.onreadystatechange = function()
        {
                if(this.readyState===4){
                document.getElementById('container').innerHTML = this.responseText;
        }}
    }
    
    </script>
</head>
<body>
    

<?php
if(isset($_POST['username']))
{
    session_start();
    $_SESSION['username'] = $_POST['username'];
    echo session_id();
    echo "<div id='container' onload='get_time()'><button onclick='get_time()'>click me</button></div>";
}
else
{
    echo"
    <form action='time_teller.php' method='post'>
        <input type='text' name='username' id='username' height='50px' placeholder='Username'>
        <input type='submit' value='Login'>
    </form>";
}

?>


</body>
</html>