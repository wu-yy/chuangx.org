// JavaScript Document
function password()
{	
	var xinmima = document.getElementById("xinmima").value;
	
	var querenmima = document.getElementById("querenmima").value;
	
	if(!(xinmima))
	{
		document.getElementById("password1").innerHTML = "新密码不能为空！！";
		var t=setTimeout("clearusername()",2000);
		return;
	}
	if(!(querenmima))
	{
		document.getElementById("password2").innerHTML = "确认密码不能为空！！";
		var t=setTimeout("clearusername()",2000);
		return;
	}
		
	var pa=/^(?!^\\d+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{8,}/;
	
	var p=pa.test(xinmima);
	
	if(!(p))
	{
		document.getElementById("password1").innerHTML = "密码不能少于8位或纯英文";
		var t=setTimeout("clearusername()",2000);
		return;	
	}
		var p=pa.test(querenmima);
	
	if(!(p))
	{
		document.getElementById("password2").innerHTML = "密码不能少于8位或纯英文";
		var t=setTimeout("clearusername()",2000);
		return;	
	}
	if(!(xinmima==querenmima))
	{
		document.getElementById("password2").innerHTML = "确认密码须与确认密码相同";
		var t=setTimeout("clearusername()",2000);
		return;	
	}
	insert_pw();
}
function clearusername()
{
	document.getElementById("password1").innerHTML ='';
	document.getElementById("password2").innerHTML ='';
}