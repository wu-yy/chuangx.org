// JavaScript Document
function on_cc_player_init(vid, objectId ){
		var config = {};
		config.rightmenu_enable = 0;
		
	config.on_player_seek = "custom_seek";
	config.on_player_fullscreen = "custom_fullscreen";
		
		config.player_plugins = {
			Subtitle : {
				url : window.url, 
				size : 20, 
				color : 0xFFFFFF,
				surroundColor : 0x3c3c3c,
				bottom : 0.05, 
				autoScale: false,
				font : "微软雅黑", 
				code : "utf-8",
				//bgColor :0x000000,
				//bgAplha :0.5, 
				//allowFullScreen: true
			}
		};
		var player = getSWF(objectId);
		player.setConfig(config);
	}
	function getSWF(objectId) { 
	if (window.document[ objectId ]) {
	    return window.document[ objectId ];
	} else if (navigator.appName.indexOf("Microsoft") == -1) {
	    if (document.embeds && document.embeds[ objectId ]) {
	    	return document.embeds[ objectId ];
	    }
	} else {
		return document.getElementById( objectId );
	}
}

	//	功能：创建播放器flash，需传递所需参数，具体参数请参考api文档
/*function vo(a)
{	
	var swfobj=new SWFObject('http://union.bokecc.com/flash/player.swf', 'playerswf', '810', '500', '8');
	swfobj.addVariable( "videoid" , a);	//	spark_videoid,视频所拥有的 api id
	swfobj.addVariable( "mode" , "api");	//	mode, 注意：必须填写，否则无法播放
	swfobj.addVariable( "autostart" , "false");	//	开始自动播放，true/false
	swfobj.addVariable( "jscontrol" , "true");	//	开启js控制播放器，true/false
	swfobj.addParam('allowFullscreen','true');
	swfobj.addParam('allowScriptAccess','always');
	swfobj.addParam('wmode','transparent');
	swfobj.write('player');
}*/

//	-------------------
//	调用者：flash
//	功能：播放器加载完毕时所调用函数
//	时间：2010-12-22
//	说明：用户可以加入相应逻辑
//	-------------------
	function on_spark_player_ready() {
		
		var div1=document.getElementById("loading");	
		
		div1.style.display="none";
	}
	
//	-------------------
//	调用者：flash
//	功能：播放器开始播放时所调用函数
//	时间：2010-12-22
//	说明：用户可以加入相应逻辑
//	-------------------
	function on_spark_player_start() {
		var id=window.xxx;
		log_url2('course_id='+id+'   act:player_start','lecBrowser_player');
	
	}
	
//	-------------------
//	调用者：flash
//	功能：播放器暂停时所调用函数
//	时间：2010-12-22
//	说明：用户可以加入相应逻辑
//	-------------------
	function on_spark_player_pause() {
		var id=window.xxx;
		log_url2('course_id='+id+'   act:player_pause','lecBrowser_player');
	}
	function custom_seek(from,to){
		var id=window.xxx;
		log_url2('course_id='+id+'   act:player_seek from:'+from+'to:'+to,'lecBrowser_player');
	}
	function custom_fullscreen(flag)
	{
		if(flag==1)
		{
			var id=window.xxx;
			log_url2('course_id='+id+'   act:player_fullscreen action:open','lecBrowser_player');	
		}
		else
		{
			var id=window.xxx;
			log_url2('course_id='+id+'   act:player_fullscreen action:close','lecBrowser_player');		
		}
	}
//	-------------------
//	调用者：flash
//	功能：播放器暂停后，继续播放时所调用函数
//	时间：2010-12-22
//	说明：用户可以加入相应逻辑
//	-------------------
	function on_spark_player_resume() {
		var id=window.xxx;
		log_url2('course_id='+id+'   act:player_resume','lecBrowser_player');
	}
	
//	-------------------
//	调用者：flash
//	功能：播放器播放停止时所调用函数
//	时间：2010-12-22
//	说明：用户可以加入相应逻辑
//	-------------------
	function on_spark_player_stop() {
		var id=window.xxx;
		log_url2('course_id='+id+'   act:player_stop','lecBrowser_player');
	}

	function player_play() { //	调用播放器开始播放函数
		document.getElementById("playerswf").spark_player_start();
	}
	function player_pause() { //	调用播放器暂停函数
		document.getElementById("playerswf").spark_player_pause();
	}
	function player_resume() { //	调用播放器恢复播放函数
		document.getElementById("playerswf").spark_player_resume();
	}
