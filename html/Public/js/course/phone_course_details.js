// JavaScript Document
function chang(name)
{
	on_change();
	$("#"+name+"_head").attr("class","k_active");
	$("#"+name+"").css("display","block");	
}
function on_change()
{
	$("#xiangqing_head").attr("class","");
	$("#tuijian_head").attr("class","");
	$("#dagang_head").attr("class","");
	$("#series_head").attr("class", "");
	$("#xiangqing").css("display","none");
	$("#tuijian").css("display","none");
	$("#dagang").css("display","none");	
	$("#series").css("display", "none");
}
function goc(e,cid,cost)
{	

	 e.cancelBubble = true;
	 
	//var ur="{:U('Course/shanghuo')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"shanghuo", obj,
			function(data,status)
				{
					
					if(data==0)
					{
						
						url_jump(window.url_login);
						
						//document.getElementById("pwuser").innerHTML ="请登陆后观看视频！";
							
					}
					else
					{
						if(cost>0)
						{
							check_cost(cid,cost);
						}
						else
						{
							guanzhu(cid);	
						}
					}
					//log_url2('follow_course','courseInfo_intro');
				}
			   );
			   
			   
}
function add_user_look(id)
{
		var obj = {};
		obj.key = "value";
		$.post(window.url+"shanghuo", obj,
			function(data,status)
				{
					
					if(data==0)
					{
						
						url_jump(window.url_login);
							
					}
					else
					{
							var ur="{:U('Course/ajax_add_user_look')}";
							$.post(ur, {'xiaojie':id},
								function(data,status)
									{
										window.location.href=window.url+'phone_voidplay/zid/'+id;
									}
								   );
					}
				}
			   );
	
	
		   
}
function check_login(Jump_page)
{
	 
	//var ur="{:U('Course/shanghuo')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"shanghuo", obj,
			function(data,status)
				{
					//alert(data);
					if(data==0)
					{
						//alert(0);
						url_jump(window.url_login);
							
					}
					else
					{
						//alert(1);
						window.location.href=Jump_page;
					}
					
				}
			   );
			   
			   
}
function check_cost(cid,cost)
{
	//var ur="{:U('Course/check_credit_log')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"check_credit_log?cid="+cid, obj,
			function(data,status)
				{
					if(data==1)
					{
						alert(data);	
					}
					else
					{
						if(confirm("您还没有购买本课程，该课程价值"+cost+"积分，是否购买"))
						{	
							jump_url(cid);
						}
					}
				}
				);	
}
function jump_url(cid)
{
	//var ur="{:U('Course/check_credit')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"check_credit?cid="+cid, obj,
			function(data,status)
				{
					if(data==0)
					{
						alert("余额不足");	
					}
					if(data==1)
					{
						alert("购买成功");
						var div = document.getElementById("ke1");
	
						div.style.display="none";
							
						var div1=document.getElementById("ke");
							
						div1.style.display="block";	
					}
					if(data==2)
					{
						alert("购买失败");	
					}
				}
				);
}
function guanzhu(cid)
{
	//var ur="{:U('Course/guanzhu')}";
	var obj = {};
	obj.key = "value";
	$.post(window.url+"guanzhu?cid="+cid, obj,
		function(data,status)
			{
				if(data==0)
				{
					alert('关注失败');	
				}
				else
				{
					if(data=='timeout')
					{
						alert('您所在群组暂无此课');	
					}
					else
					{
						var div = document.getElementById("ke1");
	
						div.style.display="none";
							
						var div1=document.getElementById("ke");
							
						div1.style.display="block";		
					}
								
				}
			}
			);
}
function log_url(e,Jump_page,head)
{
	var url=window.location.href;
	var ur="{:U('Index/log')}";
		var obj = {};
		obj.key = "value";
		$.post(window.url_log, {'head': head,'Jump_page':Jump_page,'url':url},
			function(data,status)
				{
					window.location.href=Jump_page; 
				}
			   );
				   
			   e.cancelBubble = true;
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
function pay_jump()
{
	
	
		
}