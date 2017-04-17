// JavaScript Document

function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
                "SymbianOS", "Windows Phone",
                "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}
if(IsPC())	
		{
			
			
			var swfobj=new SWFObject('http://union.bokecc.com/flash/player.swf', 'playerswf', window.width, window.height, '8');
			swfobj.addVariable( "videoid" , window.a);	//	spark_videoid,视频所拥有的 api id
			swfobj.addVariable( "mode" , "api");	//	mode, 注意：必须填写，否则无法播放
			swfobj.addVariable( "autostart" , "false");	//	开始自动播放，true/false
			swfobj.addVariable( "jscontrol" , "true");	//	开启js控制播放器，true/false
			swfobj.addParam('allowFullscreen','true');
			swfobj.addParam('allowScriptAccess','always');
			swfobj.addParam('wmode','transparent');
			swfobj.write('player');
		}
		else
		{
			document.getElementById( 'player' ).style.display='none';
			document.getElementById( 'loading' ).style.display='none';	
			document.getElementById( 'player1' ).style.display='block';
			
		}
