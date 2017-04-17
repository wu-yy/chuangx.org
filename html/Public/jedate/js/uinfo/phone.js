// JavaScript Document 

var yanzhengma;

var cn;

var b=true;

var isUser;

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
			
			var code=yzm(y_name);
			
			if(code==0)
			{
				document.getElementById("username").innerHTML = '发送失败未知错误';
						
				var t=setTimeout("clearusername()",2000);	
				
				return;
			}
			else
			{
				if(code==1)	
				{
					document.getElementById("username").innerHTML = '发送成功';
						
					var t=setTimeout("clearusername()",2000);	
					
					window.yanzhengma='ok';	
				}
				else
				{
					document.getElementById("username").innerHTML = '发送失败未知错误';
						
					var t=setTimeout("clearusername()",2000);	
					
					return;
				}
			}
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
					
					window.b=false;
					
					return false;
				}
				else
				{
					
					document.getElementById("send").innerHTML = '获取验证码';
						
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
function huoqu()
{
	if(!window.b)
	{
		document.getElementById("username").innerHTML ='已发送验证码，请注意查收';
		
		var t=setTimeout("clearusername()",2000);
		
		return false;	
	}
	var name = document.getElementById("index_user").value;
	
	if(!(name))
	{
		document.getElementById("username").innerHTML = "手机号不能为空！！";
		var t=setTimeout("clearusername()",2000);
		return;
	}

		var phone=/^1[3|4|5|8][0-9]\d{8}$/;
		
		var p=phone.test(name);
		
		if(p)
		{
					window.isUser='tel';
					checkName(name);		
		}
		else
		{
			document.getElementById("username").innerHTML = "请输入正确的手机号或验证码！！";
			var t=setTimeout("clearusername()",2000);
			return;
		}
	
}

function time_add()
{
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	var day = date.getDate();
	var hour = date.getHours();
	var minute = date.getMinutes();	
	
	var t=year+month+day+hour+minute;	
	alert(t);
}
	
