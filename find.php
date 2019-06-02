<?php

    $bDetail = false; //отобразить детальную информацию
	$bFind = false; //Результат поиска в поле FIND
	$arResult = array(); //массив данных результата поиска
	$find_str = "";
	$connect=mysqli_connect('localhost','root','') or die(mysqli_error($connect));
	mysqli_select_db($connect,"phisics_db");
	
	if(isset($_POST["action"]))
	{
		if( $_POST["action"]== "detail")
			$bDetail = true;
	}
	if(isset($_POST["query"]))
	{
			$find_str =  htmlentities(trim($_POST["query"]));
	}
	if(isset($_POST["search"]) && strlen($find_str))
	{
		//$text= " мамалу мыла раму мама рубикон мама"; 
	

		//поиск в таблице статей
		$sql = "SELECT id,header,about FROM articles";
		$query=mysqli_query($connect,$sql);
		$iMatches = 0; //количество найденных соответствий
		 while($data=mysqli_fetch_array($query))
		 {
			 $res_h = preg_match_all( "/" .$find_str ."/",$data["header"]);
			 $res_body = preg_match_all( "/" .$find_str ."/",$data["about"]);
			 if($res_h || $res_body)
			 {
				 
				 array_push($arResult,
				     array(
				         "COUNT" => intval($res_h) + intval($res_body),
						 "ID" => $data["id"],
						 "HEADER" => $data["header"],
						 "TYPE"	 =>"articles"					 
				 ));
			 }
			
		 }
		 
		  //echo "<pre>"; print_r($arResult);echo "</pre>";
		//поиск в таблице тестов 
		$sql = "SELECT id,about,header FROM tests";
		$query=mysqli_query($connect,$sql);
		$iMatches = 0; //количество найденных соответствий
		 while($data=mysqli_fetch_array($query))
		 {
			 $res_body = preg_match_all( "/" .$find_str ."/",$data["about"]);
			 if($res_body)
			 {
				 array_push($arResult,
				     array(
				         "COUNT" => intval($res_body),
						 "ID" => $data["id"],
						 "HEADER" => $data["header"],
						 "TYPE"	 =>"tests"					 
				 ));
			 }
			
		 }	
		
		$bFind = true;
	}
?>
<html>
<head>
<title>Поиск по сайту</title>
<style>
body{
	font-family:Verdana; font-size:10pt;
}
.b-search-wrap, .b-search-result{
	width:700px;
	margin: 0 auto;
}
.b-search__input {
    border: 2px solid #315efb;
    display: block;
    height: 44px;
    left: 0;
    margin: 0;
    padding: 0 0 0 15px;
    position: absolute;
    text-align: left;
    top: 0;
    width: 100%;
    z-index: 2;
}
.b-search__input {
    border: 2px solid #315efb;
    display: block;
    height: 44px;
    left: 0;
    margin: 0;
    padding: 0 0 0 15px;
    position: absolute;
    text-align: left;
    top: 0;
    width: 100%;
    z-index: 2;
}
.b-search__button-label {
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.b-search__text {
    background: #fff none repeat scroll 0 0;
    height: 44px;
}
.b-search, .b-search__text {
    padding: 0;
    position: relative;
}
.b-search__button{
    background: #315efb none repeat scroll 0 0;
    border: 2px solid #315efb;
    box-shadow: none;
    color: #fff;

    float: right;
    height: 44px;
    line-height: 40px;
    margin: 0;
    padding: 0;
    position: relative;
    transition: all 0.2s ease 0s;
    width: 113px;
    z-index: 2;
}
button{
	 background: #315efb none repeat scroll 0 0;
    border: 2px solid #315efb;
    box-shadow: none;
    color: #fff;
	position: relative;
}
.b-search__button:hover{ background: blue; }

button, html input[type="button"], input[type="reset"], input[type="submit"] {
    cursor: pointer;
}
button, select {
    text-transform: none;
}
button {
    overflow: visible;
	margin: 10 0 0 -10;
}
input, optgroup, select, textarea {
    color: inherit;
    font: inherit;
    margin: 0;
}
table{
	border:1px solid #315efb;
	width:100%;
	padding: 3px;
	margin:5px 0 0 0;
	border-collapse:collapse;
}
tr{
	border: 1px solid #315efb;
}
td{
	text-align:center;

	border: 1px solid #315efb;
}
th{
	background: pink;
}
</style>
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
<a href="paragraph.php">К темам</a>
<?
if($bDetail)
{
	$ID = 0;
	$TYPE = "";
	if(isset($_POST["id"]))
		$ID = intval($_POST["id"]);
	$TYPE =  $_POST["type"];
	$title = "";
	$body = "";
   if($ID)
   {
		$sql = "SELECT id,header,about FROM " . $TYPE." WHERE ID = " . $ID;
		$query=mysqli_query($connect,$sql);
		$data=mysqli_fetch_array($query);
		$title = str_replace($find_str,"<span style=\"background-color:yellow\">" . $find_str . "</span>", $data["header"]);
		$body = str_replace($find_str,"<span style=\"background-color:yellow\">" . $find_str . "</span>", $data["about"]);
		$url = "card.php";
		if($TYPE == "tests")
			$url = "variants.php";
		
		$title = "<a href=" . $url."?id=" . $data["id"].">" . $title."</a>";
   }

?>
<div class = "b-search-result">
    <P><a href = "find.php">Новый поиск</a></P>
	<strong>Заголовок:</strong> <?=$title?><BR><HR>
	<P>
	  <?=$body?>
	</P>
</div>

<?}else{?>
<div class = "b-search-wrap">
<h2>Поиск по сайту</h2>
	<div class="b-search__text js-suggest">
	<form method = "post">
	<input type = "hidden" name = "search">
	<input id="search_query" class="b-search__input suggest__input" type="text" maxlength="200" autocomplete="off" name="query">
	<button class="b-search__button" data-cerber-head="search" data-tesla-goal="search">
	<span class="b-search__button-label">Найти</span>
	</button>
	</form>
	</div>
<?
if($bFind)
{
    if(count($arResult))
	{
?>	
	<table>
	  <tr>
	    <th>Имя</th><th>Тип</th><th width ="10%">Найдено соответствий</th><th width ="15%"></th>
	  </tr>
   <?
      foreach($arResult as $item)
	  {
   ?>	  
	   <tr>
	    <td><?=$item["HEADER"]?></td><td><?=$item["TYPE"]?></td><td><?=$item["COUNT"]?></td>
		<td>
		<form method = "post">
		  <input type = "hidden" name = "query" value ="<?=$find_str?>"/>
		  <input type = "hidden" name = "id" value ="<?=$item["ID"]?>"/>
		  <input type = "hidden" name = "action" value ="detail"/>
		  <input type = "hidden" name = "type" value ="<?=$item["TYPE"]?>"/>
		  <button>показать</button>
		 </form>
		</td>
	  </tr>
	  <?}?>
	</table>
<?
	}
	else
		echo "соответствий не найдено";
}?>	
</div>
<?}?>
