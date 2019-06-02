<?php
$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
mysqli_select_db($connect,"phisics_db");
mysqli_query($connect,"set names utf8");
//echo "<pre>";print_r($_POST);echo"</pre>";
if (isset($_POST{'submit'})){
$username=$_POST["username"];
$login=(trim($_POST["login"]));
$password=(trim($_POST["password"]));
$r_password=(trim($_POST["r_password"]));
$Sername=$_POST["Sername"];
if ($password==$r_password) {
$password=md5($password);
$query=mysqli_query($connect,"INSERT INTO regester(username,login,password,Sername) VALUES ('$username','$login','$password','$Sername')") or die (mysqli_error($connect));
header( 'Location: /login.php');
} 
else{ die('incorect password');
}

}
?>
<html>
<head>      
<title>Регистрация</title>

<link rel="stylesheet" href="login.css"/>
</head>
<body>
<form method="post" action="register.php">
<div id="block1">
<div id="form">
<input type="text" name="username" placeholder="Имя" class="Form" required/><br>
<input type="text" name="Sername" placeholder="Фамилия" class="Form" required/><br>
<input type="text" name="login" placeholder="Логин" class="Form" required/><br>
<input type="password" name="password" placeholder="Пароль" class="Form" required/><br>
<input type="password" name="r_password" placeholder="Повторить пароль" class="Form" required/><br>
<input type="submit" name="submit" value="" class="Reg" />
</div>
</div>
</form>
</body>
</html>