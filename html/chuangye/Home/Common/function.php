<?php
//define('__ROOT__', 'http://chuangye.com/chuangyexueyuan2016/');
/*
 * 发送邮件
 * @param $to string
 * @param $title string
 * @param $content string
 * @return bool
 * */
function sendMail($to, $title, $content) {
    Vendor('PHPMailer.PHPMailerAutoload');
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //发件人邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //163邮箱发件人授权密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->Port       = C("port");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}

function sendSms($mobile,$content) {
    $sendUrl = C('JUHECONFIG.URL');
    $smsConf = array(
        "key" => C('JUHECONFIG.APPKEY'), //您申请的APPKEY
        "mobile"    => $mobile,//接受短信的用户手机号码
        'tpl_id'    => C('JUHECONFIG.tpl_id'), //您申请的短信模板ID，根据实际情况修改
        'tpl_value' =>'#code#='.$content.'&#company#=聚合数据', //您设置的模板变量，根据实际情况修改
    );
   // $flag = 0;
   $contents = juhecurl($sendUrl,$smsConf,1); //请求发送短信
if($contents){
    $result = json_decode($contents,true);
    $error_code = $result['error_code'];
    if($error_code == 0){
        //状态为0，说明短信发送成功
      return true;
    }else{
        //状态非0，说明失败
      return  false;
    }
}else{
    //返回内容异常，以下可根据业务逻辑自行修改
     return  false;
}
}
 
/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
 
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}



 function sendSms1($mobile,$content) {
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
/*
 * 蔡政
 * 20151208
 * 检测用户是否已注册
 * 输入：用户名，
 * 输出：是否已注册标示 1为已注册，0为未注册
 * e.g:输入 username,输出1（标示已注册）
 *  */
function checkName1($name){

	$user=M('user');

	$where_usermail['useremail']=$name;//邮箱

	$list_user_email=$user->where($where_usermail)->count();

	$where_usermobilenum['usermobilenum']=$name;//手机

	$list_user_usermobilenum=$user->where($where_usermobilenum)->count();

	if(empty($list_user_email)&&empty($list_user_usermobilenum))
	{
		return  0;
	}
	else
	{
		return  1;
	}
}
/* 
 * 查询用户user表
 *  
 *  */
function getuser($key)
{
    if($key != 110120119)
    {
        return false;
    }
    
    $user_id=session('id');
    
    if(empty($user_id))
    {
        return false;
    }
    
    $user_list=M('user u')->join('left join uinfo ui on ui.userid=u.id')->where(array('u.id'=>$user_id))->field('u.openid,u.useremail,u.usermobilenum,u.credit,u.loginnu,u.xuetang_id,u.phone_openid,ui.nikename,ui.username')->find();
    
    if(empty($user_list) || is_array($user_list)==false)
    {
        return false;
    }
    else
    {
        return $user_list;
    }
}
/*
 * 蔡政
 * 20151214
 * 查询用户信息
 * 返回用户信息
 *   */
function getuseruinfo($key)
{
    if($key!=6978){return false;}
     
    $uinfo=M('uinfo');
     
    $where['userid']=session('id');
     
    $list=$uinfo->where($where)->find();
     
    return $list;
}
function username()
{
	
	$id=session('id');
	
	if(!empty($id))//判断用户是否登录
	{
		$getuseruinfo=getuseruinfo(6978);
		 
		$name=$getuseruinfo['nikename'];
		 
		if(empty($name))//判断用户名
		{
			$name="用户";
		}
		
	}
	
	return $name;
}
function userimg()
{

    $id=session('id');

    if(!empty($id))//判断用户是否登录
    {
        $getuseruinfo=getuseruinfo(6978);
        	
        $image=$getuseruinfo['image'];
        	
        if(empty($image))
        {
            $image='./Public/image/moren.jpg';
        }

    }

    return $image;
}
/* 
 * 蔡政
 * 更改头像地址
 *  
 *  */
 function sevheardimage($image)
 {
     if(empty($image))
     {
         return;
     }
     else 
     {
         $heardimg=C('headimg');
         
         $str=strpos($image,"http:");
         
         if($str===false)
         {
             $image=$heardimg.$image;
         }
     }
     return $image;
     
 }

 /*
  * 蔡政
  * 搜索下级子类
  * 输入父级id，输出所有下层子类
  *  */
 function sousuo_tag($pid)
 {
     $tag=M('tag');
     
     $where['pid']=$pid;
 
     $list=$tag->where($where)->where('is_delect != 1')->select();
      
     return $list;
 }

/* 计算时间差 */
 
 function time_ad($one)
 {
     header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
 
     $tow = time();//结束时间 时间戳
 
     $cle = $tow - $one; //得出时间戳差值
 
     /* 这个只是提示
      echo floor($cle/60); //得出一共多少分钟
      echo floor($cle/3600); //得出一共多少小时
      echo floor($cle/3600/24); //得出一共多少天
      */
     /*Rming()函数，即舍去法取整*/
     $d = floor($cle/3600/24);
     $h = floor(($cle%(3600*24))/3600);  //%取余
     $m = floor(($cle%(3600*24))%3600/60);
     $s = floor(($cle%(3600*24))%60);
 
     if(empty($d))
     {
         if(empty($h))
         {
             $a="刚刚发布";
         }
         else
         {
             $a=$h."小时前";
         }
     }
     else
     {
        if($d >= 0){
            if($d<30)
            {
                $a=$d."天前";
            }
            else
            {
                $t=$d/30;
                $a=intval($t)."月前";
            }
        }else{
            if(-$d<30)
            {
                $a=-$d."天后";
            }
            else
            {
                $t=-$d/30;
                $a=intval($t)."月后";
            }
        }
     }
 
     return $a;
 
 
 }
 /*
  * 蔡政
  * 精彩课程
  *  */
 function get_nice_course()
 {
     $icn=C('index_course_nu');
 
     header("Content-Type:text/html;charset=UTF-8");  // 解决 POST变量乱码问题
      
     $course=M('course');
      
     $list_nice_course=$course->order('youxianji desc,score desc')->where('is_delect != 1 and type=1 and show_course=0')->page(1,$icn)->select();
 
     $a=0;
     
     foreach ($list_nice_course as $k=>$v)
     {
         $list_nice_course[$a]['nu_add']=$v['course_user_add']+$v['nu'];
     
         $a++;
     }
     
     return $list_nice_course;
 }
 
 function get_nice_zhibo(){
    $icn=C('index_course_nu');
 
     header("Content-Type:text/html;charset=UTF-8");  // 解决 POST变量乱码问题
      
     $course=M('course');
      
     $list_nice_zhibo=$course->order('youxianji desc,score desc')->where('is_delect != 1 and type=3 and show_course=0')->page(1,$icn)->select();
 
     $a=0;
     
     foreach ($list_nice_zhibo as $k=>$v)
     {
         $list_nice_zhibo[$a]['nu_add']=$v['course_user_add']+$v['nu'];
     
         $a++;
     }
     
     return $list_nice_zhibo;
 }


 /**
  * 验证码检查
  */
 function check_verify($code, $id = ""){
     $verify = new \Think\Verify();
     return $verify->check($code, $id);
 }
/*
*wenjing
*检查该ip在$time时刻与上次createtime之间的时间差*/
 function check_create_time($ip, $time){
    $user = M('user');
    $cond['createip'] = $ip;
    $create_list = $user -> where($cond) -> select();
    if(empty($create_list))
        return true;
    foreach ($create_list as $key => $value) {
        if(!empty($value['createtime']) && (($time - $value['createtime']) <= C('min_time_delta')))
            return false;
    }
    return true;
 }

 /*wenjing
 *检查该ip在$time时刻与上次logintime之间的时间差是否大于阈值C('max_time_delta')，即没有同一个ip近期批量注册/登录
 */
 function check_login_time($ip, $time){
    $user = M('user');
    $cond['loginip'] = $ip;
    $login_list = $user -> where($cond) -> select();
    if(empty($login_list))
        return true;
    foreach ($login_list as $key => $value) {
        if(!empty($value['logintime']) && (($time - $value['logintime']) <= C('min_time_delta')))
            return false;
    }
    return true;
 }
 /* 
  *查询用户积分余额
  *  */
 function jifen()
 {
     $id=session('id');
      
     $list=M('user')->where("id=$id")->find();
      
     return $list['credit'];
 }
 /* 
  * 301重定向
  *  */
 function red301()
 {
     return;
     
     $url=get_url();
     
     $host=parse_url($url);
     
     $str=c('url301');
     
     $tmparray = explode($str,$host['host']);
     
     if(count($tmparray)>1)
     {
         return;
     }
     else 
     {
         $redurl=str_replace($host['host'],$str,$url);
         
         redirect($redurl);
         
         return ;
     }
     
     //echo $host['host'];
     
     //echo $url;
     
    /*  $str=c('url301');
     
     $str1=c('url301_1');
     
     $tmparray = explode($str,$url);
     
     $tmparray1 = explode($str1,$url);
     
     if(count($tmparray)>1 || count($tmparray1)>1)
     {
         return;
     }
     else 
     {
         $str1=c('redurl');
         
         $tmparray1 = explode($str1,$url,2);
         
         $redurl=$tmparray1[0].c('url301').$tmparray1[1];
         
         redirect($redurl);
     } */
     
     
 }
 /* 获取url地址 */
 function get_url() {
     $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
     $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
     $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
     $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
     return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
 }
 /* 验证图形验证码 */
 function check_code($pw,$name,$type)
 {
 
     if(check_verify($pw,$id=''))
     {
         return 1;
     }
     else
     {
         return 0;
     }
 
/*      $_SESSION['name']=$name;
     $_SESSION['name1']=$name; */
 }
 /* log信息记录 */
/*  function write_log($biao)
 {
     
     $id=session('id');
     
     $add=M($biao)->data(array('uid'=>$id,'time'=>time()))->add();
     
     return $add;
 } */
 /* log信息记录 */
 function write_log_addid($biao,$addid,$name)
 {
      
     $id=session('id');
      
     $data=array(
         'uid'=>$id,
         'time'=>time(),
         "$name"=>$addid,
     );
     
     $add=M($biao)->data($data)->add();
      
     return $add;
 }
 /* 
  * 查询用户信息
  *  */
 function user_uinfo($key)
 {
     if($key!=9166){echo '参数错误'; return;}
     
     $id=session('id');
     
     $list=M('user')->where(array('id'=>$id))->find();
     
     return $list;
     
 }
 function write_log($name,$related_id)
 {
    if(empty($name)){return;}
    
/*     if(count(explode($name, C('log')))<2){return;} */
    
    $time=date('Ymd');
    
    $id=session(id);
    
    $log=M('log');
    
    if(empty($id))
    {
        $list=$log->where(array('time'=>$time,'name'=>$name,'type'=>0,'related_id'=>$related_id))->field('id,number')->find();
       
        if(empty($list['id']))
        {
            $data=array(
              'name'=>$name,
              'time'=>$time,
              'type'=>0,
              'number'=>1, 
              'related_id'=>$related_id,     
            );

            $log->data($data)->add();
        }
        else 
        {
            $data=array(
                'number'=>$list['number']+1,
            );
            
            $log->where(array('id'=>$list['id']))->save($data);
        }
    }
    else 
    {
        $list=$log->where(array('time'=>$time,'name'=>$name,'type'=>1,'related_id'=>$related_id))->field('id,number')->find();
         
        if(empty($list['id']))
        {
            $data=array(
                'name'=>$name,
                'time'=>$time,
                'type'=>1,
                'number'=>1,
                'related_id'=>$related_id,
            );
        
            $log->data($data)->add();
        }
        else
        {
            $data=array(
                'number'=>$list['number']+1,
            );
        
            $log->where(array('id'=>$list['id']))->save($data);
        }
    }
        
 }
 
 function log_all($name,$related_id)
 {
     if(empty($name)){return;}
     
     $id=session(id);
     
     $log=M('log');
     
     if(empty($id))
     {
         $list=$log->where(array('time'=>'all','name'=>$name,'type'=>0,'related_id'=>$related_id))->field('id,number')->find();

         if(empty($list['id']))
         {
             $data=array(
                 'name'=>$name,
                 'time'=>all,
                 'type'=>0,
                 'number'=>1,
                 'related_id'=>$related_id,
             );
         
             $log->data($data)->add();
         }
         else
         {
             $data=array(
                 
                 'number'=>$list['number']+1,
             );
         
             $log->where(array('id'=>$list['id']))->save($data);
         }
     }
     else 
     {
         $list=$log->where(array('time'=>'all','name'=>$name,'type'=>1,'related_id'=>$related_id))->field('id,number')->find();
          
         if(empty($list['id']))
         {
             $data=array(
                 'name'=>$name,
                 'time'=>'all',
                 'type'=>1,
                 'number'=>1,
                 'related_id'=>$related_id,
             );
         
             $log->data($data)->add();
         }
         else
         {
             $data=array(
                 'number'=>$list['number']+1,
             );
         
             $log->where(array('id'=>$list['id']))->save($data);
         }
     }
 }
 
 function test($key)
 {
     if($key!=9971){return;}
 
     $arr['name']=$_COOKIE['name'];
 
     $arr['pw']=$_COOKIE['pw'];
 
     $arr['is_user']=$_COOKIE['is_user'];
 
     return $arr;
 }
 /*
  * 蔡政
  * 20151208
  * 用户登录
  * 输入：用户名，密码
  * 输出：是否登录验证标示 1验证成功，0为验证失败
  * e.g:输入 username,password输出1（用户登录验证成功）
  *  */
  function miandenglu($key){
      
     if($key != 91100){return;}
      
     $arr=test(9971);
 
     $name=$arr["name"];
 
     $pw=$arr["pw"];
 
     $is_user=$arr['is_user'];
 
     if(empty($name) || empty($pw) || empty($is_user))
     {
        
         return;
     }
     if($is_user=='tel' || $is_user=='mail') 
     { 
         $ch=checkName1($name);
     
         if($ch==0)
         {
             
             return;
         }
     
         $user=M('user');
     
         $where['password']=$pw;
     
         if($is_user=='mail')
         {
             $where['useremail']=$name;
     
         }
         if($is_user=='tel')
         {
             $where['usermobilenum']=$name;
         }
     
         $check=$user->where($where)->find();
     
         if(empty($check))
         {
             return;
         }
         else
         {
     
             $data=array(
                 'logintime'=>time(),
                 'loginip'=>$_SERVER["REMOTE_ADDR"],
                 'loginnu'=>$check['loginnu']+1,
             );
     
             $id=$check["id"];
     
             $user->where("id=$id")->save($data);
     
             session_start();
     
             $_SESSION['id']=$check['id'];
     
            
         }
     }
 }
 function cookie_login()
 {
     $uu=$_SESSION['uu'];
     
     if(empty($uu))
     {
        miandenglu(91100);
     }
     
      $_SESSION['uu']=1223;
 }
 function fenzhan()
 {

     $user_group=M('group1 g')->where(array('g.is_delect'=>0,'g.type'=>1))->order('g.id desc')->select();
      
     return $user_group;
    
 }

 function is_weixin()
 {
     $uu=$_SESSION['uu'];
     
     if(!empty($uu))
     {
         return false;
     }
     
     if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
         
         
         $_SESSION['uu']=1223;
         return true;
 
     }
     else
     {
         return false;
     }
 }
 
 function weixin_login()
 {
     
     if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
         
         return true;
     
     }
     else
     {
         return false;
     }
     
 }

 /**
  * 是否移动端访问访问
  *
  * @return bool
  */
 function isMobile()
 {
     //return true;
     // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
     if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
     {
         return true;
     }
     // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
     if (isset ($_SERVER['HTTP_VIA']))
     {
         // 找不到为flase,否则为true
         return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
     }
     // 脑残法，判断手机发送的客户端标志,兼容性有待提高
     if (isset ($_SERVER['HTTP_USER_AGENT']))
     {
         $clientkeywords = array ('nokia',
             'sony',
             'ericsson',
             'mot',
             'samsung',
             'htc',
             'sgh',
             'lg',
             'sharp',
             'sie-',
             'philips',
             'panasonic',
             'alcatel',
             'lenovo',
             'iphone',
             'ipod',
             'blackberry',
             'meizu',
             'android',
             'netfront',
             'symbian',
             'ucweb',
             'windowsce',
             'palm',
             'operamini',
             'operamobi',
             'openwave',
             'nexusone',
             'cldc',
             'midp',
             'wap',
             'mobile'
         );
         // 从HTTP_USER_AGENT中查找手机浏览器的关键字
         if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
         {
             return true;
         }
     }
     // 协议法，因为有可能不准确，放到最后判断
     if (isset ($_SERVER['HTTP_ACCEPT']))
     {
         // 如果只支持wml并且不支持html那一定是移动设备
         // 如果支持wml和html但是wml在html之前则是移动设备
         if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
         {
             return true;
         }
     }
     return false;
 }
 
 /* 读取后台配置积分 */
 function initialize_credit()
 {
     $file_path="newfile.txt";
     $conn=file_get_contents($file_path);
     fclose($fp);
     if(empty($conn) || is_numeric($conn)==FALSE){$conn=500;}
     
     return $conn;
 }
 function is_ios()
 {
     if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
         return 'ios';
     }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
         return 'Android';
     }else{
         //echo 'systerm is other';
     }
 }
 function NoRand($begin,$end,$limit){
     $rand_array=range($begin,$end);
     shuffle($rand_array);//调用现成的数组随机排列函数
     return array_slice($rand_array,0,$limit);//截取前$limit个
 }
 /*******************************************************************************************/
 //支付宝
 
 //在线交易订单支付处理函数
 //函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
 //返回值：如果订单已经成功支付，返回true，否则返回false；
 function checkorderstatus($ordid){
     $Ord=M('Orderlist');
     $ordstatus=$Ord->where('ordid='.$ordid)->getField('ordstatus');
     if($ordstatus==1){
         return true;
     }else{
         return false;
     }
 }
 //处理订单函数
 //更新订单状态，写入订单支付后返回的数据
 function orderhandle($parameter){
     $ordid=$parameter['out_trade_no'];
     $data['payment_trade_no']      =$parameter['trade_no'];
     $data['payment_trade_status']  =$parameter['trade_status'];
     $data['payment_notify_id']     =$parameter['notify_id'];
     $data['payment_notify_time']   =$parameter['notify_time'];
     $data['payment_buyer_email']   =$parameter['buyer_email'];
     $data['ordstatus']             =1;
     $Ord=M('Orderlist');
     $Ord->where('ordid='.$ordid)->save($data);
 }

 function money($key,$money,$type,$cid='')
 {
     if($key != 10234){ return false;}
 
     if(empty($money) || is_numeric($money)==false){return false;}
 
     $uid=session('id');
 
     if(empty($uid)){return false;}
     
     $user=M('user')->where(array('id'=>$uid))->find();
     
     if(empty($user['id'])){return false;}
     
     $credit=$user['credit']+$money;
     
     if($credit<0)
     {
         return false;
     }
 
     $credit_log=M('credit_log')->data(array('uid'=>$uid,'time'=>time(),'type'=>$type,'spend'=>$money,'cost_id'=>$cid))->add();
 
     if(!empty($credit_log))
     {
 
         $save_user=M('user')->where(array('id'=>$uid))->data(array('credit'=>$credit))->save();
 
         if(!empty($save_user))
         {

             R('Message/weixin_mood',array('weixin_jifen','weixin',date('y年m月d H:i'),$type,$money.'积分',$credit.'积分'));
             
             return $credit_log;
             
         }
         else
         {
             return false;
         }
     }
     else
     {
         return false;
     }
 }
 function order_id($type)
 {
     $id=$_SESSION['id'];

     if(empty($id))
     {
         return false;
     }
     if(empty($type))
     {
         return false;
     }
     
     $count=M('pay_order')->where(array('uid'=>$id))->count();
     
     $arr_english=array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
        
     $rand_keys = array_rand($arr_english, 3);
    
     for($a=0;$a<3;$a++)
     {
         $code=$code.$arr_english[$rand_keys[$a]];
     }

     $order=$type.time().$id.$code.($count+1);
     
     return $order;
 }
 
 function add_order($pay_cost,$name,$type,$tab,$name_id='')
 {
     
     $uid=$_SESSION['id'];

     $money=$pay_cost/C('pay_jifen');
     
     $money=number_format($money, 2, '.', '');
     
     $data_jifen_order=array(
         'name'=>$name,
         'jifen'=>$pay_cost,
         'money'=>$money,
         'name_id'=>$name_id,
         'type'=>1,
         'is_paid'=>0,
         'uid'=>$uid,
     );
     
     $un_id=M('jifen_order')->data($data_jifen_order)->add();

     
     if(empty($un_id))
     {
     
         return false;
         
     }
     else
     {
         $nu=M('pay_order')->count();
         $nu=$nu+1;
         $order_id=order_id($type);
         $data_pay_order=array(
             'order_id'=>$order_id,
             'money'=>$money,
             'time'=>time(),
             'is_delect'=>0,
             'type'=>$type,
             'is_paid'=>0,
             'tab'=>$tab,
             'un_id'=>$un_id,
             'uid'=>$uid,
             'nu'=>time().$nu,
         );
     
         $add_pay_order=M('pay_order')->data($data_pay_order)->add();
     
         if(empty($add_pay_order))
         {
                  
             return false;
         
         }
         else
         {
               return  $add_pay_order;
         }
      }
 }
//生成会员
function addvip($key,$nu)
{
    if($key !=1008611){return false;}
    
    if(empty($nu) || is_numeric($nu)==false){return false;}
    
    $uid=session('id');
    
    if(empty($uid) || is_numeric($uid)==false){return false;}
    
    $list=M('vip')->where(array('user_id'=>$uid))->order('id desc')->find();
    
    if($list['end_time']>time())
    {
        $end_time=$list['end_time']+60*60*24*30*$nu;
    }
    else
    {
        $end_time=time()+60*60*24*30*$nu;
    }
    
    $addvip=M('vip')->data(array('user_id'=>$uid,'time'=>time(),'end_time'=>$end_time))->add();
    
    $arr=array($addvip,$end_time);
    
    return  $arr;
}
//判断用户是否为会员
function is_vip()
{
    $id=session('id');

    if(empty($id) || is_numeric($id)==false )
    {
        return false;
    }

    $list=M('vip')->where(array('user_id'=>$id))->order('id desc')->field('end_time')->find();

    if($list['end_time']>time())
    {
        //return false;
        return $list['end_time'];
    }
    else
    {
        return false;
    }
}
 