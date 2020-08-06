<?php
$admin = "remopay@yandex.ru";
 
if (mail($admin,"Перезвонить на номер",
              "Номер: ".$_POST["number"]."\r\nКомментарий: ".$_POST["comment"]) !=0)
{
	echo "ok";
}
else
	echo "error"; 

?>
