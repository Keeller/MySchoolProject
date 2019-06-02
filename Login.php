<?php
session_start();
if(isset($_POST['enter'])) {
$e_login=$_POST['login'];
$e_password=md5($_POST['password']);

$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
mysqli_select_db($connect,"phisics_db");
$sql = "SELECT login, password, username, Sername,preference FROM regester WHERE login= '$e_login'";
//echo $sql;
$query=mysqli_query($connect,$sql);
$user_data=mysqli_fetch_array($query);

$PASSWORD = $user_data['password'];

if($PASSWORD == $e_password){
header( 'Location: /paragraph.php');
$_SESSION["Name"]=$user_data['username'];
$_SESSION["Sname"]=$user_data['Sername'];
$_SESSION["Pref"]=$user_data['preference'];
header( 'Location: /paragraph.php');
}
else
	echo "Wrong password or login";

}
?>



<html>
<head>
<title>Авторизация</title>
<link rel="stylesheet" href="login.css"/>
</head>
<body>
<form method="post" action="">


<div id="block1">
<div id="form">
<input type="text" name="login" placeholder="Логин" class="Form" required/>
   <input type="password" name="password" placeholder="Пароль" class="Form" required/>
        <input type="submit" name="enter"  class="Enter" value="" />
             <a href="register.php">Регистрация</a>
			 </div>
</div>
</form>

</body>
</html>