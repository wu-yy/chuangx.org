// JavaScript Document
function phone_close()
{
		document.getElementById("tag").style.display='none';
		document.getElementById("phone_zhezhao").style.display='none';	
		document.getElementById("img").src=""+window.img+"/xia1.png";	
}
function phone_open()
{
	
	var st=document.getElementById("tag").style.display;	
	
	if(st=='none')
	{
		document.getElementById("tag").style.display='block';
		document.getElementById("phone_zhezhao").style.display='block';	
		//document.getElementById("tag_img").innerHTML="<p>全部微课</p><img src='"+window.img+"/shang.png'/>";
		document.getElementById("img").src=""+window.img+"/shang.png";
	}
	
	if(st=='block')
	{
		document.getElementById("tag").style.display='none';
		document.getElementById("phone_zhezhao").style.display='none';	
		document.getElementById("img").src=""+window.img+"/xia1.png";
	}
}
var tableid;
function tag(id,a,name)
{
	
		if(window.tableid)
		{
			document.getElementById('lab'+window.tableid).style.color='';	
		}
		document.getElementById('lab'+id).style.color='#88a4ff';
		
		document.getElementById("tag_name").innerHTML=name;
		
		window.tableid=id;
		
		iframepage(a);
		
		phone_close();
		
		log_url2(a,'phone_lec_tag');
}
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

function log_url2(Jump_page,head)
{
	var url=window.location.href;
	var ur=window.ur;
		var obj = {};
		obj.key = "value";
		$.post(ur, {'head': head,'Jump_page':Jump_page,'url':url},
			function(data,status)
				{
				}
			   );			   
}