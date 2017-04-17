// JavaScript Document
function open_login()
{
	var nav_list=document.getElementById("nav_list").style.display;
	
	if(nav_list=='none')
	{
		document.getElementById("nav_list").style.display='block';
		document.getElementById("zhezhao").style.display='block';		
	}
	else
	{
		document.getElementById("nav_list").style.display='none';
		document.getElementById("zhezhao").style.display='none';		
	}
	
}
function close_login()
{
	document.getElementById("nav_list").style.display='none';	
}
function url_jump(url_index)
{
		
		var url_jump=window.location.href;
		$.post(window.url_weixin, {'url':url_jump},
			function(data,status)
				{
					
					window.location.href=url_index; 
				}
			   );	
}
function userout()
{	

		var obj = {};
		obj.key = "value";
		$.post(window.url_userout, obj,
			function(data,status)
				{
					if(data==1)
					{
						window.location.reload();
					}
					else
					{
						alert('未知错误');
					}
				}
			   );
}
