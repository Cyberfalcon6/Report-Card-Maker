<?php
if(isset($_POST['username'],$_POST['password']))
{
session_start();
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
echo "<a href='print.php'>Click me to tell you who you are</a>";
}
else{
echo "
<form action='test.php' method='post'>
<input type = 'text' name='username' placeholder='enter your username'><br>
<input type= 'password' name='password' placeholder = 'Password'>
<input type= 'submit' value = 'Login'>
</form>

";
}

?>