// JavaScript Document
function num(a)
{	
	var ur=window.url;
	var obj = {};
		obj.key = "value";
		$.post(ur+"?n="+a, obj,
			function(data,status)
				{
					if(data==1)
					{
						window.location.reload();
					}
					else
					{
						alert('网络繁忙，请稍后再试');	
					}
				}
			   );	   
}
function num1(a)
{	
	var ur=window.url;
	var a=a-1;
	var obj = {};
		obj.key = "value";
		$.post(ur+"?n="+a, obj,
			function(data,status)
				{
					if(data==1)
					{
						window.location.reload();
					}
					else
					{
						alert('网络繁忙，请稍后再试');	
					}
				}
			   );		   
}
function num2(a)
{	
	var ur=window.url;
	var a=a+1;
	var obj = {};
		obj.key = "value";
		$.post(ur+"?n="+a, obj,
			function(data,status)
				{
					if(data==1)
					{
						window.location.reload();
					}
					else
					{
						alert('网络繁忙，请稍后再试');	
					}
				}
			   );	   
}
function log_url(e,Jump_page,head)
{
	var url=window.location.href;
	var ur=window.url1;
		var obj = {};
		obj.key = "value";
		$.post(ur, {'head': head,'Jump_page':Jump_page,'url':url},
			function(data,status)
				{
					window.top.location=Jump_page;
				}
			   );
				   
			   e.cancelBubble = true;
}









