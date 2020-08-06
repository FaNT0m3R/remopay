<?php
$db = mysqli_connect("localhost","u528186815_rempo","ferdi6333HAFF","u528186815_rempo");
	if ($db->connect_errno) {
		echo "Ошибка доступа к базе данных: (".$db->connect_errno.") ".$db->connect_error;
		exit();
	}

require("int.php");
	
if ($error!="")
{
	$db->close($db);
	exit();
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="yandex-verification" content="ab6a638f84c1709c" />
<meta name="Description" content="RemoPay - сервис по ремонту телефонов, смартфонов, планшетов, ноутбуков, компютеров и компьютерной техники.">
<meta name="Keywords" content="RemoPay, Брест, Высокое, ремонт, ремонт телефона, замена экрана, телефон, смартфон, планшет, нетбук, ноутбук, компьютер, принтер, сканер, периферия">
<title><?echo($info_table[1]);?></title>
<link href="css/page2.css" rel="stylesheet" type="text/css">
<? echo('<link rel="shortcut icon" href="'.$info_table[2].'" type="image/png>"')
?>
</head>

<body>
<div class="backgr">
<img src="images/bckg.jpg" width="100%" height="100%">
</div>

<div id="timer"> Мы пока закрыты. <br>
  Откроемся через <b id="rtime">00:00:00</b> или<br>
	 <b>6 апреля</b>.
 </div>
<div class="cont_line">
  <div class="address"><?echo($info_table[6]);?></div>
  <div class="telef">
    <div class=mobo-life-16>+<?echo($info_table[5]);?></div>
    <br>
    <div class=mobo-mts-16>+<?echo($info_table[4]);?></div>
  </div>
</div>