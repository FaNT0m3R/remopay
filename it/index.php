<?php	
	require("header.php"); 
?>

<div class="menu" id="menu">
  <div style="margin:0 auto; width:440px;">
    <a href="sendnum.php"> <div class="menu_item"> Заказать звонок</div></a>
    <a href="writeaut.php"> <div class="menu_item"> Написать нам</div></a>
    <a href="about.php"> <div class="menu_item"> О компании</div> </a>
  </div>
</div>

<div class="container">
  <div class="photos">
    <div id="ph0" class="photo" style="opacity:1.0;"><img src="images/s1.jpg"></div>
    <div id="ph1" class="photo"><img src="images/s3.jpg"></div>
    <div id="ph2" class="photo"><img src="images/s2.jpg"></div>
    <div id="ph3" class="photo"><img src="images/s4.jpg"></div>
  </div>
  <div id="left_arrow" ></div>
  <div id="right_arrow"></div>
  <div class="forcircles">
    <div class="circles" id="ind0" style=" background-color:#FFF;"></div>
    <div class="circles" id="ind1"></div>
    <div class="circles" id="ind2"></div>
    <div class="circles" id="ind3"></div>
  </div>
  <div class="for_fl_left">
    <div class="leftP">
      <h2><?echo($info_table[0]);?> </h2>
	  <p><table style="margin:auto;">
	  <?
	  for($i=0; $i<count($time_table); $i++)
	  {
		echo('<tr><td width="50%">');
		echo($time_table[$i][0]);
		echo('</td><td style="text-align:right; padding-right:10px;">');
		echo($time_table[$i][1]);
		echo('</td></tr>');
	  }
	  ?>
	  </table>
	  
	  </p>
	  <p>
	  <?
      echo($info_table[3]);
	  ?>
	  </p> </div>
    <div class="rightP">
		<a href="https://yandex.ua/maps/?um=constructor%3Af340daaa951de09b0477d80fa34aed3a3fa43135c81c53c79bece56d89f7e036&amp;source=constructorStatic" target="_blank"><img src="https://api-maps.yandex.ru/services/constructor/1.0/static/?um=constructor%3Af340daaa951de09b0477d80fa34aed3a3fa43135c81c53c79bece56d89f7e036&amp;width=300&amp;height=300&amp;lang=ru_UA" alt="" style="border: 0;" /></a>
	</div>
  </div>
  <div id="services">
    <h3 id="services_h">Список услуг</h3>
<?php
foreach($castes_table as $val_cast) 
{
	echo("<h4>".$val_cast[0]."</h4>");
	
	foreach($serv_table as $val) 
	{
		if ($val[1]==$val_cast[1])
		{
			$str = strtok($val[0],"\n");
			while($str!="")
			{
				echo($str."<br>");
				$str = strtok("\n");
			}
			echo("<br>");
		}
	}
	echo("</table>");
}

?>	  
  </div>
  <div id="prices" >
    <h3 id="prices_h">Цены</h3>
    <table>
      <?
	  foreach($cost_table as $val) 
	  {
			echo ("<tr><td>");
			echo ($val[0]);
			echo ("</td><td>");
			if ($val[1] != 0)
			{
				if ($val[1] < 0)
				{
					$val[1] = -$val[1];
					echo('от ');
				}
				echo ($val[1]);
				echo (" руб");
			} else
				echo("бесплатно");
			echo("</td></tr>");
	  }
	  
	  
	  ?>
    </table>
  </div>

  <div id="vk_like" class="vk_Applet"> </div>


<div id="vk_comments"></div>


</div>
<?php
require("footer.php");
?>


<!-------------------------------------------------------> 
<script src="js/timer.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!--<script src="js/jquery-3.0.0.js"></script>-->

<script type="text/javascript">
setInterval("onTimer()",5000);

var bServices=false;
var hServicesMin = "60px";
var hServicesMax = "700px";

var bPrices=false;
var hPricesMin = "60px";
var hPricesMax = "370px";


var posPhoto = 0;

$(document).ready(function(){
	$("#services_h").click(function(){
		if (bServices)
		  $("#services").animate({height: hServicesMin}, 'normal');
	 	else
		  $("#services").animate({height: hServicesMax}, 'normal');
		bServices=!bServices;
		return false;
	});
	
	$("#prices_h").click(function(){
		if (bPrices)
		  $("#prices").animate({height: hPricesMin}, 'normal');
	 	else
		  $("#prices").animate({height: hPricesMax}, 'normal');
		bPrices=!bPrices;
		return false;
	});
	
	
	$("#left_arrow").click(btLeft);
	$("#right_arrow").click(btRight);
	
});


function btLeft(){
		var oldPosPhoto = posPhoto;
		if(posPhoto==0)
			posPhoto=4;
		posPhoto--;
		
		hidePhoto("#ph"+oldPosPhoto,1);
		showPhoto("#ph"+posPhoto,1);
		
		$("#ind"+oldPosPhoto)
		  .css({
		  	backgroundColor:"#666" 
		  })
		  
		$("#ind"+posPhoto)
		  .css({
		  	backgroundColor:"#FFF" 
		  })
	}
	
function btRight(){
		var oldPosPhoto = posPhoto;
		if(posPhoto==3)
			posPhoto=-1;
		posPhoto++;
		
		hidePhoto("#ph"+oldPosPhoto,-1);
		showPhoto("#ph"+posPhoto,-1);
		
		$("#ind"+oldPosPhoto)
		  .css({
		  	backgroundColor:"#666" 
		  })
		  
		$("#ind"+posPhoto)
		  .css({
		  	backgroundColor:"#FFF" 
		  })	
	}

function hidePhoto(idPhoto,direction)  //direction= -1 - left, 1 - right
{
	var x1,x2;
	if (direction==-1)
	{
		x1="0";
		x2="-800px";
	} else
	{
		x1="0";
		x2="800px";
	}

	$(idPhoto).css({left:x1});
	$(idPhoto).animate({opacity:"0.0",left:x2});
}

function showPhoto(idPhoto,direction)
{
	var x1,x2;
	if (direction==-1)
	{
		x1="800px";
		x2="0";
	} else
	{
		x1="-800px";
		x2="0";
	}

	$(idPhoto).css({left:x1});
	$(idPhoto).animate({opacity:"1.0",left:x2});
}
/*****************************************************************************************/
	var menuY = 50;
	var elem = document.body;

	
	window.onscroll = function(){
		var delta = window.pageYOffset || document.documentElement.scrollTop;	
		menuY = delta-50;
		
	  	var widthm = $('#menu').innerWidth();

	  	if (menuY>0)
	  		$('#menu').css({position:"fixed",
		 				top:"0px", 
						left:"0px",
						width: widthm});
	  	else
	  		$('#menu').css({position:"relative"
					});
	}

function onTimer(){	btRight();
}
</script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?139"></script>
<script>
VK.init({apiId: 5869407, onlyWidgets: true});
VK.Widgets.Comments("vk_comments", {limit: 5, width: "800", attach: "*"});

</script>


</body>
</html>