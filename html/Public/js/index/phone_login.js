// JavaScript Document
// JavaScript Document

var yanzhengma;

var cn;

var b=true;

var isUser;
function login()
{
				
	//log_url1(e,'submit_login','public_loginAndRegister');
	
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
		document.getElementById("pwuser").innerHTML = "密码不能少于8位或纯英文";
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
			document.getElementById("pwuser").innerHTML = "请输入正确的手机号或验证码！！";	
			return;
		}
	}
	
}
function checkNamezhuce(name,pw,isUser,url){
	
	document.getElementById("pwuser").innerHTML = "";	
	
	var ur="{:U('Index/checkname')}";
	
	var obj = {};
		obj.key = "value";
		$.post(window.url+'checkname?name='+name, obj,
			function(data,status)
				{
					if(data!=0)
					{
						checkuser(url,name,pw,isUser);	
						
						return;
					}
					else
					{
						document.getElementById("pwuser").innerHTML = "该用户未注册！！";
						return;
					}
				}
			   );
}

function checkuser(url,name,pw,isUser)
{
	
	var ur="{:U('Index/checkuser')}";
	var a=window.xz;
	var obj = {};
		obj.key = "value";
		$.post(window.url+"checkuser?name="+name+"&pw="+pw+"&isUser="+isUser+"&xuanzhong="+a, obj,
			function(data,status)
				{
					if(data==1)
						{
							document.getElementById("pwuser").innerHTML = "恭喜，登陆成功";
							ju();
							return;
						}
						else 
						{
							document.getElementById("pwuser").innerHTML = "用户名或密码错误，请核对后重新登陆";
							return;
						}
				}
			   );

}
function ju()
{
	$.post(window.url+"p_url_weixin",
			function(data,status)
				{
					if(data)
					{
						window.location.href=data; 
					}
					else
					{
						window.location.href=window.url;	
					}
				}
			   );	
}
function change_code(){
	//	alert(125485);
	
	$("#codes").attr("src",window.verifyURL+'/'+Math.random());
	//log_url2('image_identifying_code','public_loginAndRegister');
	return false;
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
	
    if(!window.b)
	{
		document.getElementById("username").innerHTML ='已发送验证码，请注意查收';
		
		var t=setTimeout("clearusername()",2000);
		
		return false;	
	}
				
	//log_url1(e,'Verification_code','public_loginAndRegister');
	
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
	//log_url1(e,'submit_register','public_loginAndRegister');	
		
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
function check_yzm()
{	

		//var ur="{:U('Index/check_yzm')}";
		
		var yzm = document.getElementById("yzm").value;
		
		var pw = document.getElementById("pw").value;
		
		var name = document.getElementById("index_user").value;
	
		var obj = {};
		obj.key = "value";
		$.post(window.url+"check_yzm?rank="+yzm, obj,
			function(data,status)
				{
					if(data==1)
					{
						sub_mail(name,pw);
					}
					else
					{
						document.getElementById("username").innerHTML = "验证码错误！！";
					}	
				}
			   );

}
function sub_mail(name,pw)
{
		document.getElementById("username").innerHTML = " ";
		
		//var ur="{:U('Index/sub_user')}";
		
		var obj = {};
		obj.key = "value";
		$.post(window.url+"sub_user?name="+name+"&pw="+pw+"&isUser="+isUser, obj,
			function(data,status)
				{
					if(data!=0)
						{
							document.getElementById("username").innerHTML = "恭喜，注册成功，正在跳转到登录页面";
							
							setTimeout("window.location.href=window.url+'phone_login';",2000);

							return;
						}
						else 
						{
							document.getElementById("username").innerHTML = "网路繁忙,注册失败,请稍候再试";
							return;
						}
				}
			   );
}
var xz="wxz";
function xz1()
{
	var a=window.xz;
	
	if(a=="wxz")
	{
		
		document.getElementById("xz").style.display="block";
		document.getElementById("wxz").style.display="none";
		window.xz="xz";	
	}
	else
	{
		document.getElementById("wxz").style.display="block";
		document.getElementById("xz").style.display="none";
		window.xz="wxz";	
	}	
	
}
function checkName(name){
	
	document.getElementById("username").innerHTML = "";	
	
	//var ur="{:U('Index/checkname')}";
	
	var obj = {};
		obj.key = "value";
		$.post(window.url+"checkname?name="+name, obj,
			function(data,status)
				{
					if(data!=0)
					{
						document.getElementById("username").innerHTML = "该用户已注册！！";
						
						return;
					}
					else
					{
						//checkyzm(name);
						check_g_phone();	
						//alert(111);
					}
				}
			   );
}
function none_code()
{
	document.getElementById("show_code").style.display="none";	
} 
function checkyzm(name)
{
	
		document.getElementById("username").innerHTML = "";
	
		var pw=document.getElementById("picyzm").value;
		
		if(!pw)
		{
			document.getElementById("username").innerHTML = "请填写验证码！！";	
			return;
		}
		var obj = {};
		
		obj.key = "value";
		$.post(window.fc+'?pw='+pw+'&name='+name, obj,
			function(data,status)
				{
					if(data==1)
					{		
							
							sends();
							
							change_code();
							
							return;
					}
					else
					{
						document.getElementById("username").innerHTML = "验证码错误！！";	
						setTimeout("cla()",2000);
						return;
					}
				}
			   );
	
}
function check_g_phone()
{
	var ur=window.url+"check_yzm_sub";
	var name='g_phone';
	$.post(ur, {'name': name,},
		function(data,status)
			{
				if(data==0)
				{
					document.getElementById("show_code").style.display="block";	
					change_code();
				}
				else
				{
					sends();	
				}
			}
		   );		   
}
function checkcode()
{
	var a=document.getElementById("picyzm").value;	
	if(!a)
	{
		document.getElementById("imagecode").innerHTML = "验证码不能为空！！";
		var t=setTimeout("document.getElementById('imagecode').innerHTML='';",2000);
		return;			
	}
	var b='g_phone';	
	var ur="{:U('Uinfo/checkcode')}";

			 var obj = {};
				obj.key = "value";
				$.post(window.fc+"?pw="+a+"&name="+b, obj,
					function(data,status)
					{
						if(data==0)
						{
							document.getElementById("imagecode").innerHTML = "验证码错误！！";
							var t=setTimeout("document.getElementById('imagecode').innerHTML='';",2000);	
							return;
						}
						else
						{
							document.getElementById("imagecode").innerHTML = "验证码正确";
							var t=setTimeout("none_code();sends();",2000);
							return;
						}
					}
					);
}
function mail(name)
{	
		//var ur="{:U('Index/mail')}";
		var obj = {};
		obj.key = "value";
		$.post(window.url+"mail?mail="+name, obj,
			function(data,status)
				{
					alert(data);
					if(data==1)
					{
						document.getElementById("username").innerHTML = "已发送验证码，注意查收";
					}
					else
					{
						document.getElementById("username").innerHTML = "发送失败，请使用手机号注册";
					}	
						
						var t=setTimeout("clearusername()",2000);
				}
			   );

}
function yzm(name)
{	

		//var ur="{:U('Index/yzm')}";
		var obj = {};
		obj.key = "value";
		$.post(window.url+"yzm?name="+name, obj,
			function(data,status)
				{
					
						document.getElementById("username").innerHTML = data;
						
						var t=setTimeout("clearusername()",2000);
				}
			   );

}
function log1(head)
{
	var url1=window.location.href;
	var Jump_page='none';
	//var ur="{:U('Index/log')}";
		var obj = {};
		obj.key = "value";
		$.post(window.url+'log', {'head': head,'Jump_page':Jump_page,'url':url1},
			function(data,status)
				{
					
				}
			   );
}


