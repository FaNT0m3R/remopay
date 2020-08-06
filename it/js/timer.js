

setInterval("onTimerSec()",1000);
function onTimerSec()
{
	var now = new Date(); 
	var fopen = new Date(2017, 3, 6, 10, 0,0,0);	//6 апреля
	fopen = fopen - now;
	if (fopen<0) 
	{
		 document.getElementById("timer").style.visibility = "hidden";
		 document.getElementById("timer").style.height = "0px";
	} else
	{
		var h = Math.floor(fopen/1000/60/60);
		fopen -= h*60*60*1000;
		var m = Math.floor(fopen/1000/60);
		fopen -= m*60*1000;
		var s = Math.floor(fopen/1000);
		document.getElementById("rtime").innerHTML = h +":"+ m + ":" + s;
	}
}
