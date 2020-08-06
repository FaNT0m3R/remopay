<?php
$access = 0;
$errorP = 0;

$db = mysqli_connect("localhost","u528186815_rempo","ferdi6333HAFF","u528186815_rempo");
if ($db->connect_errno) {
    echo "Ошибка доступа к базе данных";
	exit();
}
if (isset($_COOKIE["login"]))
	$name = $_COOKIE["login"];
else
	$name = $_POST["login"];
	
if (isset($name))
{
	$name = substr($name,0,128);
	$name = correctInput($name);
	
	if (isset($_COOKIE["password"]))
		$pass = $_COOKIE["password"];
	else
		$pass = $_POST["password"];
	$pass = substr($pass,0,128);
	if (isset($pass))
	{
		$pass = correctInput($pass);
		$resl_serv = $db->query("SELECT * FROM users WHERE `name`='".$name."';");
		if ($resl_serv != false)
		{
			if($resl_serv->num_rows != 1)
				$errorP = 1;
			else{
				$serpass = $resl_serv->fetch_array();
				if (($pass != $serpass[2]) or (($name != $serpass[1])))
					$errorP = 2;
				else
				{
					$access=1;
					setcookie("password",$pass,time()+60*60*24*62,"/admin.php");
					setcookie("login"   ,$name,time()+60*60*24*62,"/admin.php");
				}
			}
		}
		else
		{
			$errorP = 3;
		}
	} else
	{
		$errorP = 4;
	}
}

/******************************************************************************************/
/**    ЗАЛОГИНИЛСЯ    *********************************************************************/
/******************************************************************************************/
if ($access==1)
{
	$newdb_info = $_POST["info"]; //time  costs
	if (isset($newdb_info))
	{
		$db->query("DELETE FROM infos;");
		
		$inp = strtok($newdb_info,"#");
		$i = 0;
		while ($inp != "")
		{
			$db->query("INSERT INTO `infos`(`id`,`value`) VALUES ('$i', '$inp');");
			$inp = strtok("#");
			$i++;
			if ($i>10) break; //на всякий случай
		}
		
		
		$db->query("DELETE FROM timelist;");
		$newdb_time = $_POST["time"];
		$inp0 = strtok($newdb_time,"#");
		$inp1 = strtok("#");
		$i = 0;
		while ($inp0 != "")
		{
			$db->query("INSERT INTO `timelist`(`name`,`time`) VALUES ('$inp0', '$inp1');");
			$inp0 = strtok("#");
			$inp1 = strtok("#");
			$i++;
			if ($i>10) break; //на всякий случай
		}
		
		$db->query("DELETE FROM services;");
		$db->query("DELETE FROM castes;");
		$newdb_serv = $_POST["services"];
		$inp0 = strtok($newdb_serv,"#");
		$inp1 = strtok("#");
		$i = 0;
		while ($inp0 != "")
		{
			$db->query("INSERT INTO `castes`(`name`,`id`) VALUES ('$inp0',$i);");
			$db->query("INSERT INTO `services`(`names`,`group`) VALUES ('$inp1', '$i');");
			$inp0 = strtok("#");
			$inp1 = strtok("#");
			$i++;
			if ($i>10) break; //на всякий случай
		}
		
		
		$db->query("DELETE FROM serv_cost;");
		$newdb_costs = $_POST["costs"];
		$inp0 = strtok($newdb_costs,"#");
		$inp1 = strtok("#");
		$i = 0;
		while ($inp0 != "")
		{
			if(substr($inp1,0,5)=="от ") $inp1="-".substr($inp1,5);
			$db->query("INSERT INTO `serv_cost`(`name`,`cost`) VALUES ('$inp0', '$inp1');");
			$inp0 = strtok("#");
			$inp1 = strtok("#");
			$i++;
			if ($i>10) break; //на всякий случай
		}
		$db->close();
		exit();
	}
	
	$error = "";


/******************************************************************************************/
/**    АДМИНСКАЯ СТРАНИЦА    **************************************************************/
/******************************************************************************************/

require("int.php");
	
	if ($error!="")
	{
		$db->close();
		exit();
	}
/*******    ГЕНЕРАЦИЯ СТРАНИЦЫ    ***************************************************************/
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Страница администратора</title>
<link href="css/page2.css" rel="stylesheet" type="text/css">
<style>
#btn_save{
width:100px;
}

</style>
</head>
<body>

<div class="container" id="cont">
	<form>
		<table id="tinfo">
			<tr>
		<td width="200"> Заговок сайта </td>
		<? echo('<td width="300"><input value="'.$info_table[0].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Название страницы </td>
		<? echo('<td width="300"><input value="'.$info_table[1].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Фавикон </td>
		<? echo('<td width="300"><input value="'.$info_table[2].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Основной текст </td>
		<? echo('<td width="300"><input value="'.$info_table[3].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Телефон MTS </td>
		<? echo('<td width="300"><input value="'.$info_table[4].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Телефон Life :) </td>
		<? echo('<td width="300"><input value="'.$info_table[5].'" /></td>'); ?>
			</tr>
			<tr>
		<td width="200"> Адрес </td>
		<? echo('<td width="300"><input value="'.$info_table[6].'" /></td>'); ?>
			</tr>

		</table>


<?php	/****  РАСПИСАНИЕ  *****/
echo('<table id="tabl_time">');
	
for($i=0; $i<count($time_table); $i++)
{
	echo('<tr><td>');
	echo('<input value="'.$time_table[$i][0].'"/>');
	echo('</td><td>');
	echo('<input value="'.$time_table[$i][1].'"/>');
	echo('</td></tr>');
}
echo('</table>');

echo('<input type="button" value="Добавить" onclick="addLineTime()"/>');
echo('<input type="button" value="Удалить" onclick="removeLineTime()"/><br><br>');

/***   СПИСОК УСЛУГ  ****/
echo('<div id="tabl_services">');
for($i=0; $i<count($castes_table); $i++)
{
	echo('<div><input type="button" value="Удалить" onclick="removeGroupServices(this)">');
	echo('<input value="'.$castes_table[$i][0].'"><br>');
	echo('<textarea rows="12" cols="80">');
	for($j=0; $j<count($serv_table); $j++)
	{
		if ($serv_table[$j][1]==$castes_table[$i][1])
			echo ("\n".$serv_table[$j][0]);
	}
	echo('</textarea></div>');
}
echo('</div>');
echo('<input type="button" value="Добавить" onclick="addGroupServices()"><br><br>');

/***   СПИСОК ЦЕН  ****/
echo('<table id="tabl_cost">');
for($i=0; $i<count($cost_table); $i++)
{
	echo('<tr><td>');
	echo('<input value="'.$cost_table[$i][0].'"/>');
	echo('</td><td>');
	
	echo('<input value="');
	if ($cost_table[$i][1] < 0)
	{
		$cost_table[$i][1] = -$cost_table[$i][1];
		echo('от ');
	} 
	echo($cost_table[$i][1]);
	echo('"/> руб');
	echo('</td></tr>');
}
echo('</table>');
echo('<input type="button" value="Добавить " onclick="addLineCost()"/>');
echo('<input type="button" value="Удалить" onclick="removeLineCost()"/>');
?>
		
		
		<br><br>
		<input type="button" value="Сохранить" id="btn_save" onclick="doSave()"/>
    </form>
</div>

<script>
function it(itm){return document.getElementById(itm)};
function addItem(target,itm){return target.appendChild(document.createElement(itm))}

function addLineTime()
{
	var target = it("tabl_time").lastChild;			//<tr><td><input/></td><td><input/></td></tr>
	if(target==null)
		target = addItem(it("tabl_time"),"tbody");
	var t2 = addItem(target,"tr");
	var t3 = addItem(t2,"td");
	var t4 = addItem(t3,"input");
	var t5 = addItem(t2,"td");
	addItem(t5,"input");
}
function removeLineTime(){
	var target=it("tabl_time").lastChild.lastChild;
	if(target!=null)
		it("tabl_time").lastChild.lastChild.remove();
}

function addGroupServices()
{
	//it("tabl_services").innerHTML+='<div><input type="button" value="Удалить" onclick="removeGroupServices(this)"/><input /><br><textarea rows="12" cols="80"></textarea></div>';
	var target = it("tabl_services");
	var t2 = addItem(target,"div");
	//addItem(t2,'input type="button" value="Удалить" onclick="removeGroupServices(this)"');
	var t3 = t2.appendChild(document.createElement("input"));
	t3.outerHTML='<input type="button" value="Удалить" onclick="removeGroupServices(this)">';
	addItem(t2,"input");
	addItem(t2,"br");
	var t4 = t2.appendChild(document.createElement("textarea"));
	t4.outerHTML='<textarea rows="12" cols="80"></textarea>';
}

function removeGroupServices(p)
{
	p.parentElement.remove();
}

function addLineCost()
{
	var target = it("tabl_cost").lastChild; 	//<tr> <td><input/></td> <td><input/> руб</td> </tr>
	var t2 = addItem(target,"tr");
	var t3 = addItem(t2,"td");
	var t4 = addItem(t3,"input");
	var t5 = addItem(t2,"td");
	addItem(t5,"input");
	t5.appendChild(document.createTextNode(" руб"));
}

function removeLineCost(){
	var target=it("tabl_cost").lastChild.lastChild;
	if (target!=null) target.remove();
}


function createPOST()
{
	var post="info=";
	var table=document.getElementById("tinfo").lastChild;
	for (var i=0; i<table.childNodes.length/2; i++)
		post += table.childNodes[i*2].childNodes[3].lastChild.value + "#";
	
	post+="&time=";
	var table2=document.getElementById("tabl_time").lastChild;
	for (var i=0; i<table2.childNodes.length; i++){
		post += table2.childNodes[i].childNodes[0].lastChild.value + "#";
		post += table2.childNodes[i].childNodes[1].lastChild.value + "#";
	}
	
	post+="&services=";
	var table3=document.getElementById("tabl_services");
	for (var i=0; i<table3.childNodes.length; i++){
		post += table3.childNodes[i].childNodes[1].value+"#"+table3.childNodes[i].childNodes[3].value+"#";
	}
	
	post+="&costs=";
	var table4=document.getElementById("tabl_cost").lastChild;
	for (var i=0; i<table4.childNodes.length; i++){
		post += table4.childNodes[i].childNodes[0].childNodes[0].value+"#";
		post += table4.childNodes[i].childNodes[1].childNodes[0].value+"#";
	}
	
	return post;
}

var req;
function doSave()
{
	req = getXmlHttp();
	req.onreadystatechange = antwort;
	req.open('POST', 'admin.php?info="asd"', true); 
	req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
	req.send(createPOST());
}


function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function antwort()
{
	if (req.readyState == 4) {
		console.log(req.responseText);
		window.location.reload();
	}
}

</script>
<?php
}
else //($access!=0)
{
/*******    СТРАНИЦА ВХОДА    ***************************************************************/

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Вход</title>
<?php
	if ($errorP!=0)
	{
		echo("Ошибка! Не верно указан логин или пароль<br>");
	}
?>
</head>
<body>
<form action="admin.php" method="post" >
	Логин <input name="login"><br>
	Пароль <input name="password" type="password"><br>
	<!--<input type="checkbox" name="notsave"> не сохранять логин на этом компьютере<br>-->
	<input type="submit" value="Войти"/>
</form>

</body>

<?php
} //($access!=0)
$db->close();

function correctInput($inp)
{
	$cinp = $inp;
	$pos = 1;
	while ($pos!=0)
	{
		$pos=strpos($cinp, "'");
		if($pos!=0)
			$cinp[$pos]=" ";
	}
	$pos = 1;
	while ($pos!=0)
	{
		$pos=strpos($cinp, "\"");
		if($pos!=0)
			$cinp[$pos]=" ";
	}
	$pos = 1;
	while ($pos!=0)
	{
		$pos=strpos($cinp, "-");
		if($pos!=0)
			$cinp[$pos]=" ";
	}
	$cinp = htmlspecialchars($cinp);
	return $cinp;
}
?>
	
</body>
</html>