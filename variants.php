<?php
session_start();
//error_reporting(E_ALL);
if($_SESSION["Name"]==NULL)
{
    header('Location: /index.php');
}
$id = 0;
$header = "";
$about = "";
$DB=NULL;

	if($_GET["id"])
	   $id = intval($_GET["id"]);
$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
mysqli_select_db($connect,"phisics_db");
  //save
  
  if ($_SESSION["Pref"]!=$DB) {

  
if(isset($_POST["save"]))
{
      $header = mysqli_real_escape_string($connect,$_POST["header"]);
	  $about = mysqli_real_escape_string($connect,$_POST["about"]);
	  $answer = mysqli_real_escape_string($connect,trim($_POST["answer"]));
	  $resh = mysqli_real_escape_string($connect,trim($_POST["resh"]));
	  //$vel = mysqli_real_escape_string($connect,trim($_POST["vel"]));
	  if($id)
			$sql = "UPDATE tests SET header = '" . $header ."', about = '" . $about ."', answer = '". $answer."', resh = '". $resh."' WHERE id = " . $id;
	  else
            $sql = "INSERT INTO tests (header,about,answer,resh) VALUES('$header','$about','$answer','$resh')";
			
	mysqli_query($connect,$sql);
	header( 'Location: /tests.php');	
}	   
}
$caption = "добавить";	   
if($id>0)
{	  
 		$sql = "SELECT id,header,answer,resh, about FROM tests WHERE id= " . $id ;
		//echo $sql;
		$query=mysqli_query($connect,$sql);
		$user_data=mysqli_fetch_array($query);
		if(isset($user_data["id"]))
		{
		   $header = $user_data["header"];
		   $about = $user_data["about"];
		   $answer=$user_data["answer"];
		   $resh=$user_data["resh"];
           //$vel=$user_data["vel"];
		   
		$caption = "Сохранить";
		   
		}
}



?>
<html>
<body>
<head>   
<script src="/ckeditor/ckeditor.js"></script>
 <script type="text/javascript" src="/MathJax-master/MathJax.js">


MathJax.Hub.Config({
    extensions: ["tex2jax.js","TeX/noErrors.js"],
	jax: ["input/TeX","output/HTML-CSS"],
	tex2jax: {inlineMath: [['$','$'],["\\(","\\)"]]},
	"HTML-CSS": {availableFonts:["TeX"]}
  });

</script>
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
<table >


<form method="post" action="variants.php?id=<?=$id?>">
<?if( $_SESSION["Pref"]!=$DB){?>

<tr><td><h1>Заголовок</h1><input type="text" name="header" value = "<?=$header?>"/><br></br></td>
<?} else {?>

<td><h2><?=$header?></h2> </td><?
}?>
</tr>

<?if( $_SESSION["Pref"]!=$DB){?>
<tr><td><h2>Условие</h2><P><textarea cols ="40" rows = "20"  name = "about"><?=$about?></textarea></P></td><?
} else {?>

<td><h2>Условие</h2><P><?=$about?></td></P><?
}?>
<?if( $_SESSION["Pref"]!=$DB){?>

<td><h2>Решение</h2><P><textarea  cols ="40" rows = "20"  name = "resh" ><?=$resh?></textarea></td><?
}?>

<?
if (isset ($_POST['reshenie'])){?>

<td><h2>Решение</h2> <P><?=$resh?></td><?
}
?>
</tr>
<?if( $_SESSION["Pref"]!=$DB){?>

<tr><td><h5>ответ</h5><P><textarea cols ="30" rows = "2"  name = "answer"><?=$answer?></textarea></td></P><?
}?>


</tr>
<?if( $_SESSION["Pref"]==$DB){?>

<tr><td><h5>ответ</h5><P><textarea   cols ="3" rows = "2"  name = "askedanswer"></textarea></td></P><?
}?></tr>



<?if( $_SESSION["Pref"]!=$DB){?>
	<tr><td><input type="submit" name="save" value="<?=$caption?>" /></td>
<?}?>
<tr>
<tr>
        <?if( $_SESSION["Pref"]==$DB){?><td><input class="bot1"  type="submit" name="check" value="проверить"/><td><?
}?>    



    <?if( $_SESSION["Pref"]==$DB){?>
        <td><input class="bot1"  type="submit" name="reshenie" value="показать решение"/></td><<?
} ?>
    </tr>

<a href=tests.php><<Назад</a>

<?php 

if (isset ($_POST['check']))  {

 if (($_POST['askedanswer']==$answer)){
 
 ?> <script>  alert  ( '<?echo ("Поздравляем вы решили задачу верно");?>' ) </script> <?
}
else {
?> <script> alert ('<?echo ("К сожалению ответ не верен");?>') </script>
<?
}


 }






?>	


</table>

</form>
<script>
CKEDITOR.replace("about");
CKEDITOR.replace("resh");


</script>
</body>
</html>
