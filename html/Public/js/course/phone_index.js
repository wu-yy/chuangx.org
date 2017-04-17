// JavaScript Document

function ifare()
{
	var ifm= document.getElementById("external-frame");   
	var subWeb = document.frames ? document.frames["external-frame"].document : ifm.contentDocument;   
	if(ifm != null && subWeb != null) {
   ifm.height = subWeb.body.scrollHeight;
   ifm.width = subWeb.body.scrollWidth;
}
}

function iFrameHeight(iframe) {   
if (iframe) {
var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
if (iframeWin.document.body) {
iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
ifare();
}
}   
} 
function ifheight () {
  iFrameHeight(document.getElementById('external-frame'));
}

function iframepage(a)
{
	document.getElementById("external-frame").src=a;
	
}

setInterval("ifheight()",1000);
function close_all(id)
{
		if(id!=list_biao2_id)
		{
			document.getElementById("tag"+window.list_biao2_id).style.display='none';
			document.getElementById("img"+window.list_biao2_id).src=""+window.img+"/xia1.png";
		}
		if(id!=list_biao1_id)
		{
			document.getElementById("tag"+window.list_biao1_id).style.display='none';
			document.getElementById("img"+window.list_biao1_id).src=""+window.img+"/xia1.png";	
		}
		if(id!='paixu')
		{
			document.getElementById("tagpaixu").style.display='none';
			document.getElementById("imgpaixu").src=""+window.img+"/xia1.png";	
		}	
		document.getElementById("phone_zhezhao").style.display='none';
}
function phone_open(id)
{
		if(id!=list_biao2_id)
		{
			document.getElementById("tag"+window.list_biao2_id).style.display='none';
			document.getElementById("img"+window.list_biao2_id).src=""+window.img+"/xia1.png";
		}
		if(id!=list_biao1_id)
		{
			document.getElementById("tag"+window.list_biao1_id).style.display='none';
			document.getElementById("img"+window.list_biao1_id).src=""+window.img+"/xia1.png";	
		}
		if(id!='paixu')
		{
			document.getElementById("tagpaixu").style.display='none';
			document.getElementById("imgpaixu").src=""+window.img+"/xia1.png";	
		}
		
		var nav_list=document.getElementById("tag"+id).style.display;

		if(nav_list=='none')
		{
			document.getElementById("tag"+id).style.display='block';
			document.getElementById("phone_zhezhao").style.display='block';	
			document.getElementById("img"+id).src=""+window.img+"/shang.png";
		}
		else
		{
			document.getElementById("tag"+id).style.display='none';	
			document.getElementById("phone_zhezhao").style.display='none';
			document.getElementById("img"+id).src=""+window.img+"/xia1.png";
		}
}
var anser;
function paixu(a,b,c,d)
{

		if(window.anser)
		{
			document.getElementById(window.anser).style.color='';	
		}

		document.getElementById(b).style.color='#88a4ff';
		
		document.getElementById(a+"_name").innerHTML=d;
		
		window.anser=b;
		
		if(b=='renqi')
		{
			sort_renqi();	
		}
		else
		{
			sort_zonghe();	
		}
}

function log_url1(Jump_page,head)
{
	var url=window.location.href;
		var obj = {};
		obj.key = "value";
		$.post(window.lo, {'head': head,'Jump_page':Jump_page,'url':url},
			function(data,status)
				{
				}
			   );			   
}
var biao1_name;
var biao2_name;
function biao1(a,b,c,d)
{	
		log_url1(d,'phone_course_tag');
		document.getElementById('lab'+b).style.color='#88a4ff';
		
		document.getElementById('tag_'+a).innerHTML=d;
		
		var fram=document.getElementById("external-frame").src;	
		
		if(b==window.list_biao1_id)
		{
			detag1();
			if(window.biao1_name)
			{
				document.getElementById(window.biao1_name).style.color='';	
			}
			window.biao1_name='lab'+b;
			return;	
		}
		if(b==window.list_biao2_id)
		{
			detag2();
			if(window.biao2_name)
			{
				document.getElementById(window.biao2_name).style.color='';	
			}
			window.biao2_name='lab'+b;
			return;	
		}
		if(a==window.list_biao1_id)
		{
			if(window.biao1_name)
			{
				document.getElementById(window.biao1_name).style.color='';	
			}
			var obj = {};
			obj.key = "value";
			$.post(window.biao1_ur+'shuaxintag'+"?id="+b, obj,
				function(data,status)
					{
						if(data==1)
						{
							iframepage(fram);
						}
						else
						{
							alert('网络繁忙，请稍后再试');	
						}
					}
				   );	
			window.biao1_name='lab'+b;		   
		}
		if(a==window.list_biao2_id)
		{
			if(window.biao2_name)
			{
				document.getElementById(window.biao2_name).style.color='';	
			}
			var obj = {};
			obj.key = "value";
			$.post(window.biao1_ur+'shuaxintag1'+"?id="+b, obj,
				function(data,status)
					{
						if(data==1)
						{
							iframepage(fram);
						}
						else
						{
							alert('网络繁忙，请稍后再试');	
						}
					}
				   );	
			window.biao2_name='lab'+b;		   
		}
		close_all('id');
}

function sort_zonghe()
{
	
	log_url1('synthesis','course_screen');
	var a=document.getElementById("external-frame").src;
	var obj = {};
		obj.key = "value";
		$.post(window.biao1_ur+'zonghe', obj,
			function(data,status)
				{
					if(data==1)
					{
						iframepage(a);
					}
					else
					{
						alert('网络繁忙，请稍后再试');	
					}
				}
			   );
			   close_all('id');
}
function sort_renqi()
{
	log_url1('popularity','course_screen');
	var a=document.getElementById("external-frame").src;	
	var obj = {};
		obj.key = "value";
		$.post(window.biao1_ur+'renqi', obj,
			function(data,status)
				{
					if(data==1)
					{
						iframepage(a);
					}
					else
					{
						alert('网络繁忙，请稍后再试');	
					}
				}
			   );
			   close_all('id');
}
function detag()
{
	var obj = {};
		obj.key = "value";
		$.post(window.biao1_ur+'detag', obj,
			function(data,status)
				{
					
				}
			   );
	var a=document.getElementById("external-frame").src;
	iframepage(a);
}
function detag1()
{
	var a=document.getElementById("external-frame").src;
	$.ajax({
            url:window.biao1_ur+'detag1',
            async:true, 
			type:'post',          
            success:function(data) {
           		
				iframepage(a);	
             }
		 }); 
	
	
}
function detag2()
{
	var a=document.getElementById("external-frame").src;
	$.ajax({
            url:window.biao1_ur+'detag2',
            async:true, 
			type:'post',          
            success:function(data) {
           		iframepage(a);
					
             }
		 }); 
	
	
}

detag();