// JavaScript Document
function open_mulu()
{
	if($("#mulu").css("display")=='none')
	{
		$("#mulu").css("display",'block');	
	}
	else
	{
		$("#mulu").css("display",'none');	
	}
	document.getElementById('daixiugai').style.color='#FFF';
}
var d;
function zhangjie(id)
{	
	if(window.d==id)
	{
		for(var i=0;i<document.getElementsByName(id).length;i++)
		{
			var div=document.getElementsByName(id)[i];
			
			div.style.display="none"; 
			
			div.style.background="#ecf0f5";
			
			window.d='';
		}	
		document.getElementById(id+"_img").src=window.public+'image/k_xia.png';
		
		return;
	}
	if(window.d)
	{
		var old_id=window.d;
		for(var i=0;i<document.getElementsByName(old_id).length;i++)
		{
			var div=document.getElementsByName(old_id)[i];
			
			div.style.display="none"; 
			
			div.style.background="#ecf0f5";
			
		}	
		document.getElementById(old_id+"_img").src=window.public+'image/k_xia.png';
	}
	for(var i=0;i<document.getElementsByName(id).length;i++)
	{
		var div=document.getElementsByName(id)[i];
		
		div.style.display="block"; 
		
		div.style.background="#ecf0f5";
	}
	
	document.getElementById(id+"_img").src=window.public+'image/k_shang.png';
	
	window.d=id;
	
	zhangjie_log(id);
}


var im;
function iframepage(a,b)
{	
	//alert(window.im);
	if(window.im)
	{
		document.getElementById('li'+window.im).style.background="";
	}
	window.im=b;
	document.getElementById("external-frame").src=a;
	document.getElementById('li'+b).style.background="#f1f1f1";
	
	
}


var u_zhangjie_id;
function get_xiaojie(zhangjie_id)
{
	window.im='';
	$("#mulu").css("display",'none');
	if(window.u_zhangjie_id)
	{
		var div=document.getElementById(window.u_zhangjie_id);
	
		div.style.backgroundColor="";
	}
	
	var div=document.getElementById(zhangjie_id);
	
	div.style.backgroundColor="#9198ab";
	
	window.u_zhangjie_id=zhangjie_id;
	$.ajax({
            url:window.url+'p_xiaojie',
            async:false, 
			type:'post',
			data:{'id':zhangjie_id},            
            success:function(data) {
					var str="";
					var data = eval('('+data+')');
					var a=0;
					for(var x in data)
						{
									var type = data[x]['type'];
									var b = data[x]['id'];
									if(x==0)
									{
										var cc_tt=b;
									}
									if(type==0)
									{
										var str=str+"<a href='javascript:;' onClick='iframepage(\""+window.url+"phone_voidplay/id/"+b+"\","+b+");'> <li id='li"+b+"'><image src='"+window.public+"image/sp.png'/></li></a>";
									}
									else
									{
										var str=str+"<a href='javascript:;' onClick='iframepage(\""+window.url+"phone_voidplay/id/"+b+"\","+b+");'> <li id='li"+b+"'><image src='"+window.public+"image/wb_an.png'/></li></a>";
	
									}
									a=a+1;
						}
					var nu=a*177;
					document.getElementById('k_jie').style.width=nu;
					document.getElementById('k_jie').innerHTML=str;
					iframepage(window.url+"phone_voidplay/id/"+cc_tt,cc_tt);
				}
				}
			   );	
		xiaojie_log(zhangjie_id);
			
		
		
		//iframepage(window.url+"phone_voidplay/id/"+phone_voidplay_id,phone_voidplay_id);  
}
function zhangjie_log(id)
{
	//var ur="{:U('Course/zhangjie_log')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"zhangjie_log?zhangjie_id="+id, obj,
			function(data,status)
				{
				}
			   );
}
function xiaojie_log(id)
{
	//var ur="{:U('Course/xiaojie_log')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"xiaojie_log?xiaojie_id="+id, obj,
			function(data,status)
				{
				}
			   );
	course_look_add1(id);			   
}
function course_look_add1(id)
{
	//var ur="{:U('Course/course_look_add1')}";
	var obj = {};
		obj.key = "value";
		$.post(window.url+"course_look_add1?xiaojie_id="+id, obj,
			function(data,status)
				{
					
				}
			   );
}

