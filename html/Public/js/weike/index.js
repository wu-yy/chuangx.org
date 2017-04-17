// JavaScript Document
var tableid;
function tag(id,a)
{
		if(window.tableid)
		{
			document.getElementById('lab'+window.tableid).style.background='';
			document.getElementById('lab'+window.tableid).style.color='';	
		}
		document.getElementById('lab'+id).style.background='#88a4ff';
		document.getElementById('lab'+id).style.color='#fff';
		window.tableid=id;
		iframepage(a);
		log_url2(a,'lec_tag');
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
if(window.aaa==iframe.height)
{
		ifare();
}
 window.aaa=iframe.height;
}
}   
} 
window.onload = function () {
  iFrameHeight(document.getElementById('external-frame'));
}
function iframepage(a)
{
	document.getElementById("external-frame").src=a;
	
}
