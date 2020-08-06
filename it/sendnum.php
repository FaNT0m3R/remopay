<?php 
require("header.php");
$db->close();
?>

<div class="menu" id="menu">
  <div style="margin:0 auto; width:440px;">
    <a href="index.php"> <div class="menu_item"> Главная</div> </a>
    <a href="writeaut.php"> <div class="menu_item"> Написать нам</div></a>
    <a href="about.php"> <div class="menu_item"> О компании</div> </a>

  </div>
</div>
<div class="container">
  <div class="place">
  <h2>Remo Pay </h2>
  <form  autocomplete method ="GET">
	<div style="font-size:large;">
		<img src="images/tel.png" width="69" height="69" style="float:left; margin-right:20px;">
		<p>Укажите свой номер, и мы перезвоним. </p>
		<p>
		  <input type="text" id="number">
		  <input type="button" value="Отправить" onclick="sendt();">
		</p>
	</div>
	<div style="margin-left:89px;">
    <p style="font-size:small;">Можете оставить пожелание, например, в какое время позвонить (или в какое лучше не надо)<br>
      <textarea id="comment" name="comment" cols="63" rows="3"></textarea>
    </p>
	</div>
  </form>
  </div>
</div>

<script src="js/timer.js"></script>
<script>
var AJAXRequest;

function sendt()
{
	var arg = "number="+document.getElementById("number").value+"&comment="+document.getElementById("comment").value;
	SendRequest(arg, "send.php", f_answer);
}

function SendRequest(arg, url, f_answer)
{
	if (window.XMLHttpRequest)
	{
		AJAXRequest = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{ 
		try
		{
			AJAXRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (CatchException)
		{
			AJAXRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
	}
	
	AJAXRequest.onreadystatechange = f_answer;
	AJAXRequest.open("POST" ,url, true);
	AJAXRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
	AJAXRequest.send(arg);
}

function f_answer()
{
	if (AJAXRequest.readyState == 4) {
    	var response = AJAXRequest.responseText;
		if (response=="ok")
			alert("Заявка принята, ждите звонок");
		else
			alert("Произошла ошибка, попробуйте ещё раз");
	}
}
</script>
</body>
</html>