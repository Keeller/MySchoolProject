<?php
session_start();
if($_SESSION["Name"]==NULL)
{
    header('Location:/index.php');
}
if(isset($_POST["logout"])) {
unset($_SESSION["Name"]);
unset($_SESSION["Sname"]);
header( 'Location: /login.php');
}

?>   <font color="red" face="Times New Roman" size="10">  <? echo $_SESSION["Name"] . " ". $_SESSION["Sname"];?> </font><br>
<?if($_SESSION["Pref"]!=$DB)  {?> <font color="red" face="Times New Roman" size="3"  ><i> (Учитель) </i></font> <?} 
 if  ($_SESSION["Pref"]==$DB) {?> <font color="red" face="Times New Roman" size="3"  ><i> (Ученик) </i></font> <?} ?>
<?
$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
mysqli_select_db($connect,"phisics_db");
 mysqli_query($connect,"set names utf8");
if(isset($_GET["del"]) and ($_SESSION["Pref"]!=NULL))
{
   $sql = "DELETE FROM articles WHERE id = " . intval($_GET["del"]);
   $query=mysqli_query($connect,$sql);
}


$sql = "SELECT id,header,about FROM  articles ORDER BY id"; 
$query=mysqli_query($connect,$sql);

$DN=NULL
?>


<html> 
<head>
<title> Разделы </title>


<link rel="stylesheet" href="login.css"/>
    <style>
        a.bot1{
            background:linear-gradient(to bottom, #FFFFFF, #E6E6E6) #F5F5F5 repeat-x;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3;
            border-radius: 4px;
            border-style: solid;
            border-width: 1px;
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
            color: #333333;
            text-decoration:none;
            display:block;
            font-size: 14px;
            width:120px;
            line-height: 20px;
            margin: 20px auto;
            padding: 4px 12px;
            text-align: center;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
            vertical-align: middle;
            position: relative;
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
            -webkit-transition-property: -webkit-transform;
            transition-property: transform;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0);
        }

        a.bot1:before {
            pointer-events: none;
            position: absolute;
            z-index: -1;
            content: '';
            top: 100%;
            left: 5%;
            height: 10px;
            width: 90%;
            opacity: 0;
            background: -webkit-radial-gradient(center, ellipse, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
            background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
            -webkit-transition-property: -webkit-transform, opacity;
            transition-property: transform, opacity;
        }

        a.bot1:hover {
            -webkit-transform: translateY(-5px);
            -ms-transform: translateY(-5px);
            transform: translateY(-5px);
        }
        a.bot1:hover:before {
            opacity: 1;
            -webkit-transform: translateY(5px);
            -ms-transform: translateY(5px);
            transform: translateY(5px);
        }
    </style>
</head>
 
<body  background="/paper.jpg">

<div class="container">
<header>

<center><img src="/head.png"></center>


</header>
<form method="post" action="">
<div id="button">
<div id="s_panel">
<input type="submit" name="logout" value="" class="exit" >
</div>
</div>

</form>

<center><table border="1", style= "margin-top: 10%;"> 
<tr><th>СОДЕРЖАНИЕ</th><th>-</th></tr>

<?
while($user_data=mysqli_fetch_array($query))
{
?>
	<tr><td><a href="card.php?id=<?=$user_data["id"]?>"><?=$user_data["header"]?></a></td>
<?if( $_SESSION["Pref"]!=$DN){?>
	<td><button class="bot1"><div id="accept"><a href = "paragraph.php?del=<?=$user_data["id"]?>">Удалить</a></div></button></td>
	</tr> 
<?}
}
?>
</center>
<?if( $_SESSION["Pref"]!=$DN){?> 
<tr><td><a href="card.php"><button class="bot1">Добавить</button></a></td></tr>
<?}?>

</table>

<a href="find.php">Поиск по сайту</a><br>

<a href="tests.php">Задачи</a><BR>

<div class="popup-wrapper">
  <input type="checkbox" class="popup-checkbox" id="popupCheckboxOne">
  <div class="popup">
    <div class="popup-content">
      <label for="popupCheckboxOne" class="popup-closer">&#215;</label>
      <p>Все формулы програмируются в соответствии с LaTeX</p>
	  <p></p>
	  

    </div>
  </div>
</div>

<label for="popupCheckboxOne" class="popup-shower">Указание</label>

</div>



</body>








</html>