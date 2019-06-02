<?php
session_start();
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

 $filename = ""; 
if(isset($_POST["save"]))
{

//var_dump($_FILES);

	   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
	   {
		 // Если файл загружен успешно, перемещаем его
		 // из временной директории в конечную
		 $filename = "file/".$_FILES["filename"]["name"];
		 move_uploaded_file($_FILES["filename"]["tmp_name"], $filename);
	   }
      $header = mysqli_real_escape_string($connect,$_POST["header"]);
	  $about = mysqli_real_escape_string($connect,$_POST["about"]);
	  if($id)
			$sql = "UPDATE articles SET header = '" . $header ."', about = '" . $about ."', filename = '" . $filename."' WHERE id = " . $id;
	  else
            $sql = "INSERT INTO articles (header,about) VALUES('$header','$about')";
			
	mysqli_query($connect,$sql);
	header( 'Location: /paragraph.php');	
}	   
}
$caption = "добавить";	   

if($id>0)
{	  
 		$sql = "SELECT id,header, about,filename FROM articles WHERE id= " . $id ;
		//echo $sql;
		$query=mysqli_query($connect,$sql);
		$user_data=mysqli_fetch_array($query);
		if(isset($user_data["id"]))
		{
		   $header = $user_data["header"];
		   $about = $user_data["about"];
		   $filename = $user_data["filename"];

		$caption = "сохранить";
		   
		}
}



?>
<html>
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



</head>
<body>
<table>
<form method="post" action="card.php?id=<?=$id?>"  enctype="multipart/form-data">
<a href="paragraph.php"><<Назад</a>

<?if( $_SESSION["Pref"]!=$DB){?>
<h1>Тема</h1>
<input type="text" name="header" value = "<?=$header?>"/><br></br>
<?} else {?><?
}?>

<?if( $_SESSION["Pref"]!=$DB){?>
<h2>Описание</h2>
<tr>
<P><textarea cols ="80" rows = "40"  name = "about"><?=$about?></textarea></P><?
} else {?><td><P><?=$about?> </textarea></P></td><?
}?>

</tr>








<tr>
<?if( $_SESSION["Pref"]!=$DB){?>
<input type="submit" name="save" value="<?=$caption?>" />
	</tr>
	
<?}?>	

</form>
</table>
<script>      

CKEDITOR.replace("about");
//CKEDITOR.replace( 'about', { toolbar : [ [ 'EqnEditor', 'Bold', 'Italic' ] ] });
</script>
</body>
</html>
