<?php
namespace Home\Controller;
use Think\Controller;
/**
* 漫道科技短信功能
*/
class SmsMandaoController extends Controller {
    
    function _initialize()
    {
        red301();
    }
    
	public function index()
	{	
		$this->sendSms(18511358319, 123456);
	}
	
	public function sendSms($mobile,$content) {
		$url = C('MDSMSCONFIG.URL').'/mt';
		$content = iconv("UTF-8","GB2312", $content."【拓悦科技】");
	    $argv = array(
			"sn"  => C('MDSMSCONFIG.SN'),
			"pwd" => strtoupper(Md5(C('MDSMSCONFIG.SN').C('MDSMSCONFIG.PASSWORD'))),
			"mobile"=>$mobile,
			"content"=>$content,
			"ext"=>"",
			"stime"=>"",
			"rrid"=>"success"
		);
		$flag = 0;
		//构造要post的字符串
		$params='';
		foreach ($argv as $key=>$value) {
			if ($flag!=0) {
				$params .= "&";
				$flag = 1;
			}
			$params.= $key."="; $params.=urlencode($value);
			$flag = 1;
		}
		$length = strlen($params);
		//构造post请求的头 
		$header = array("POST /webservice.asmx/mt HTTP/1.1"); 
		$header .= "Host:sdk.entinfo.cn\r\n"; 
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
		$header .= "Content-Length: ".$length."\r\n"; 
		$header .= "Connection: Close\r\n\r\n"; 
		// //添加post的字符串 

		$ch = curl_init(); //初始化curl
		curl_setopt($ch, CURLOPT_URL, $url);//设置链接
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头
		curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);//POST数据
		/* LOG::write($params); */
		$line = curl_exec($ch);//接收返回信息
		if(curl_errno($ch)){//出错则显示错误信息
		    print curl_error($ch);
		}
		curl_close($ch); //关闭curl链接
		
		$line=str_replace("<string xmlns=\"http://tempuri.org/\">","",$line);
		$line=str_replace("</string>","",$line);
		$line=preg_replace('/<[^>]*?>/','',$line);
		$line=trim($line);
		if(strtolower($line) == 'success') {
			return true;
		}
		// echo $line;
		return $line;

	}
}
?>