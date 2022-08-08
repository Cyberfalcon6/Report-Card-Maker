<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
<?php 

if(isset($_POST['username'],$_POST['password']))
{

    $conn = mysqli_connect("localhost","root","");
    mysqli_select_db($conn, "temp");
    $username = $_POST['username'];
    $password = $_POST['password'];
    $size = 0;
    $result = mysqli_query($conn," SELECT * FROM usersn WHERE username='$username' AND pasword='$password'");
    foreach($result as $row)
    {
            if(sizeof($row)!=0)
            {
                $size = $size+1;
            }
        $class_id = $row['class'];
    }
    if($size>0)
    {
        session_start();
        foreach($result as $rw)
        {
            $_SESSION['photo'] = $rw['photo'];
        }
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("refresh:0,index.php");
    }
    else
    {
        header("refresh:0,login.php?error=Incorrect Password or username");
    }
}
else
{
echo "
<form action='login.php' method='post' autocomplete='OFF'>
<div id='box'>
    <div id='inp'>
    <div id='inner' class='inner'><i><img src='user.png' width='15vw' ></i>Username</div><input type='text' name='username' id='username' ><br><br><br>
</div>
<div id='inp'>
<div id='inner' class='inner'><i><img src='ic_user_secure.png' width='15vw' ></i>Password</div><input type='password' name='password' id='password' ><br><br><br>
</div>
<input type='submit' value='Login'>
<div>I don't have account <a  id='register' href='register.php'>Register</a></div>
</div>
</form> ";


}
if(isset($_GET['error']))
{
    echo "<div id='error'>".$_GET['error']."</div>";
}
?>
<!--<div id="tit">Login</div>-->
</body>
</html>
