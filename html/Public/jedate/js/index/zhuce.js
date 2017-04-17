// JavaScript Document

var yanzhengma;

var cn;

var b=true;

var isUser;
function login(e)
{
	e.cancelBubble = true;
				
	log_url1(e,'submit_login','public_loginAndRegister');
	
	var name = document.getElementById("login_name").value;
	
	var pw = document.getElementById("user_name").value;
	
	var url='__APP__/Home/Index/checkuser';
	
	
	
	if(!(name))
	{
		document.getElementById("pwuser").innerHTML = "用户名不能为空！！";
		return;
	}
	
	if(!(pw))
	{
		document.getElementById("pwuser").innerHTML = "请输入密码！！";
		return;
	}
	
	var pa=/^(?!^\\d+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{8,}/;
	
	var p=pa.test(pw);
	
	if(!(p))
	{
		document.getElementById("pwuser").innerHTML = "密码不能少于8位";
		return;	
	}
	
	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	
	var b=myreg.test(name);

	if(b)
	{
		document.getElementById("pwuser").innerHTML = "";	
		window.isUser='mail';
		checkNamezhuce(name,pw,isUser,url);
	}
	else
	{
		var phone=/^1[3|4|5|8][0-9]\d{8}$/;
		
		var p=phone.test(name);
		
		if(p)
		{
			document.getElementById("pwuser").innerHTML = "";	
			window.isUser='tel';
			checkNamezhuce(name,pw,isUser,url);
		}
		else
		{
			document.getElementById("pwuser").innerHTML = "请输入正确的手机号或邮箱号！！";	
			return;
		}
	}
	
}
function sends()
{
	var y_name = document.getElementById("index_user").value;
	
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
				var name = document.getElementById("index_user").value;
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
		document.getElementById("username").innerHTML ='已发送验证码，请注意查收';
		
		var t=setTimeout("clearusername()",2000);
		
		return false;
	}

}
function clearusername()
{
	document.getElementById("username").innerHTML ='';
}
function huoqu(e)
{
	e.cancelBubble = true;
				
	log_url1(e,'Verification_code','public_loginAndRegister');
	
	var name = document.getElementById("index_user").value;
	
	if(!(name))
	{
		document.getElementById("username").innerHTML = "用户名不能为空！！";
		var t=setTimeout("clearusername()",2000);
		return;
	}
	var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	
	var b=myreg.test(name);

	if(b)
	{
		window.isUser='mail';
		checkName(name);
	}
	else
	{
		var phone=/^1[3|4|5|8][0-9]\d{8}$/;
		
		var p=phone.test(name);
		
		if(p)
		{
					window.isUser='tel';
					
					checkName(name);		
		}
		else
		{
			document.getElementById("username").innerHTML = "请输入正确的手机号或邮箱地址！！";
			var t=setTimeout("clearusername()",2000);
			return;
		}
	}
}

function user(e)
{
	log_url1(e,'submit_register','public_loginAndRegister');	
		
	var pw = document.getElementById("pw").value;
	
	var yzm = document.getElementById("yzm").value;
	
	if(!(pw))
	{
		document.getElementById("username").innerHTML = "请输入密码！！";
		return;
	}
	
	var pa=/^(?!^\\d+$)(?!^[a-zA-Z]+$)(?!^[_#@]+$).{8,}/;
	
	var p=pa.test(pw);
	
	if(!(p))
	{
		document.getElementById("username").innerHTML = "密码不能少于8位或纯英文";
		return;	
	}
	else
	{
		if(!(yanzhengma=="ok"))
		{
			document.getElementById("username").innerHTML = "请发送验证码！！";
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
				document.getElementById("username").innerHTML = "请填写验证码！！";
				return;	
			}
		}
	}
	
}





