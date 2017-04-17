// JavaScript Document
function check()
{
	
	alert(111);
	
	var nikename = document.getElementById("nikename").value;
	
	var username = document.getElementById("username").value;
	
	var jianjie = document.getElementById("jianjie").value;
	
	if(!(nikename))
	{
		document.getElementById("error").innerHTML = '昵称不能为空！！';
		setTimeout("clearusername()",2000);
		return;	
	}	

	insertuinfo();
}	
	function clearusername()
	{
		document.getElementById("error").innerHTML ='';
		document.getElementById("error1").innerHTML ='';
		document.getElementById("error2").innerHTML ='';
	}
