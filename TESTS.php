<?php
session_start();
if($_SESSION["Name"]==NULL)
{
    header("Location /index.php");
}
if(isset($_POST["logout"])) {
unset($_SESSION["Name"]);
unset($_SESSION["Sname"]);
header( 'Location: /login.php');
}
?>
 <font color="red" face="Times New Roman" size="10"><?echo $_SESSION["Name"] . " ". $_SESSION["Sname"];?> </font><br>
 <?if($_SESSION["Pref"]!=$DB)  {?> <font color="red" face="Times New Roman" size="3"  ><i> (Учитель) </i></font> <?} 
 if  ($_SESSION["Pref"]==$DB) {?> <font color="red" face="Times New Roman" size="3"  ><i> (Ученик) </i></font> <?} ?>
<?
$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
mysqli_select_db($connect,"phisics_db");
if(isset($_GET["del"]) and ($_SESSION["Pref"]!=NULL))
{
   $sql = "DELETE FROM tests WHERE id = " . intval($_GET["del"]);
   $query=mysqli_query($connect,$sql);
}


$sql = "SELECT id,about,answer,resh,header FROM  tests ORDER BY id"; 
$query=mysqli_query($connect,$sql);

$DN=NULL
?>


<html> 
<head>
<title> Разделы </title>

<link rel="stylesheet" href="login.css"/>

</head>
 
<body background="/paper.jpg" >
<div class="container">
<header>
<center><img src="/head.png"></center>


</header>
<form method="post" action="">
<div id="button">
<div id="s_panel">
<input type="submit" name="logout" value=""  class="exit">
</div>
</div>
</form>
<center><table border="1", style= "margin-top: 10%;"> 
<tr><th>СОДЕРЖАНИЕ</th><th>-</th></tr>
<?
while($user_data=mysqli_fetch_array($query))
{
?>
	<tr><td><a href="variants.php?id=<?=$user_data["id"]?>"><?=$user_data["header"]?></a></td>
<?if( $_SESSION["Pref"]!=$DN){?>
	<td><button><a href = "tests.php?del=<?=$user_data["id"]?>">Удалить</a></button></td>
	</tr> 
<?}
}
?>
</center>

<?if( $_SESSION["Pref"]!=$DN){?> 
<tr><td><a href="variants.php"><button>Добавить</button></a></td></tr>
<?}?>
<a href="paragraph.php">Темы</a>

</div> 


