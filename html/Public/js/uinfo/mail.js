// JavaScript Document
function checkmail()
{
	
}

var yanzhengma;

var cn;

var b=true;

var isUser;

function sends()
{
	var y_name = document.getElementById("mail").value;
	
	if(b)
	{
		
		if(isUser=='mail')
		{
			var time = 120;
			
			mail(y_name);
		}
		else
		{
			var time = 60;
			
			yzm(y_name);
		}	
		function timeCountDown()
		{
			if(time==0)
			{
				
				document.getElementById("send").innerHTML = '再次发送验证码';
				
				window.yanzhengma=" ";
					
				clearInterval(timer);
				
				window.b=true;
			}
			else
			{
				var name = document.getElementById("mail").value;
				if(y_name==name)
				{
					document.getElementById("send").innerHTML = time+'S后再次发送';
					
					time--;
					
					window.yanzhengma="ok";
					
					window.b=false;
					
					return false;
				}
				else
				{
					
					document.getElementById("send").innerHTML = '获取验证码';
					
					window.yanzhengma=" ";
						
					clearInterval(timer);
					
					window.b=true;
					
					return false;
				}
			}
		}
		
		var timer = setInterval(timeCountDown,1000);
	}
	else
	{
		document.getElementById("checkmail").innerHTML ='已发送验证码，请注意查收';
		
		var t=setTimeout("clearusername()",2000);
		
		return false;
	}

}
function clearusername()
{
	document.getElementById("checkmail").innerHTML ='';
}
function huoqu()
{
	
	var name=document.getElementById("mail").value;
	
	if(!(name))
	{
		document.getElementById("checkmail").innerHTML = "邮箱不能为空！！";
		
		return false;
	}
	
	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	
	var b=myreg.test(name);

	if(b)
	{
			document.getElementById("checkmail").innerHTML = "";
			window.isUser='mail';
			checkName(name);	
	}
	else
	{
		document.getElementById("checkmail").innerHTML = "请输入正确邮箱地址！！";	
		return false;
	}
		

}

function user()
{
	
	var yzm = document.getElementById("yzm").value;

		if(!(yanzhengma=="ok"))
		{
			document.getElementById("checkmail").innerHTML = "请发送验证码！！";
			return;
		}
		else
		{
			if(yzm)
			{
				check_yzm();		
			}
			else
			{
				document.getElementById("checkmail").innerHTML = "请填写验证码！！";
				return;	
			}
		}
}