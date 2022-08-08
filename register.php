<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="register_style.css">
</head>
<body>
<?php
if(isset($_POST['name'],$_POST['username'],$_POST['password']))
{
    
    $conn = mysqli_connect("localhost","root","");
    mysqli_select_db($conn, "temp");
    $name = $_POST['name'];
    $photo_name = $_FILES['profile']['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $length = strlen($photo_name);
    $extension = substr($photo_name,($length-4),);
    $now = (date("Y_j_H_i",time()));
    $profile_name = $now.$username.$extension;
    move_uploaded_file($_FILES['profile']['tmp_name'],"images/".$profile_name);
    $result = mysqli_query($conn,"INSERT INTO usersn(`username`, `pasword`, `name`,`photo`)  VALUES('$username','$password','$name','$profile_name')");
    header("refresh:5,login.php?username=$username&password=$password");
}

?>

<script>

    function getname()
    {
        var img = String(document.getElementById('profile').value).substr(12,);
        document.getElementById('u').src = "ok.png";
        document.getElementById('choose_photo').innerHTML = img;
        document.getElementById('choose_photo').style = "color: rgb(43, 157, 233);font-weight: light;";
    }
</script>
<form action='register.php' method='post' autocomplete="off" enctype="multipart/form-data">
<div id='box'>
<div id='inp'>
        <b id="choose_photo">Choose your profile picture</b><br>
       <img src="user-192.png" id='u' alt="" onclick="document.getElementById('profile').click();" style='border-radius: 360px;width: 40px;height: 40px;' >
       <input type='file' name='profile' hidden onchange="getname()"  id='profile' ><br><br><br>
</div>
<div id='inp'>
       <input type='text' name='name' id='username' ><div id='inner' class='inner'>Full Name</div><br><br><br>
</div>
    <div id='inp'>
       <input type='text' name='username' id='username' ><div id='inner' class='inner'>Username</div><br><br><br>
</div>
<div id='inp'>
    <input type='password' name='password' id='password' ><div id='inner' class='inner'>Password</div><br><br><br>
</div>
<input type='submit' value='Register'><br><br><br>
<a href='login.php' >Already Have accout? Login</a>
</div>
</form>
</body>
</html>