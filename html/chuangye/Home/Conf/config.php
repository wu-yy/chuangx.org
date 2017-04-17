<?php



// //定义回调URL通用的URL  http://test.chuangx.org/index.php/Home/Index/homepage.html
define('URL_CALLBACK', 'http://test.chuangx.org/index.php/Home/Index/callback/type/');//'http://www.touchdelight.com/cyxy/Home/index/callback/type/');

$file_path="newfile.txt";
$conn=file_get_contents($file_path);
//fclose($file_path);
if(empty($conn) || is_numeric($conn)==FALSE){$conn=500;}

return array(



//        //配置头像地址
//     'headimg'=>'http://localhost/cyxy2016/',


//      //301地址
//     'url301' =>'localhost',

//     'url301_1'=>'www.chuangye.com',

//     //需要重定向的url
//     'redurl'=>'localhost',

//     'redurl_1'=>'chuangye.com',

//     'jump_url'=>'/cyxy2016/Home/Index/sub_url',

    //=======================================================================

//        //配置头像地址
//       'headimg'=>'http://chuangedu.com.cn/',
//     //301地址
//     'url301' =>'www.chuangx.org',
//      //需要重定向的url
//     'redurl'=>'www.chuangx.org',

//     'client_id'=>'63a436769154f8e947b4',

//     'client_secret'=>'d999e59792e71e8cb80f0acc1bbd09e8e8b833f7',

//     'xuetang'=>'http://chuangx.org/home/index/xuetang',

//     'xuetang_uinfo'=>'http://chuangx.org/home/Uinfo/xuetang',

//     'weixin_url'=>"http://chuangx.org/Home/Index/weixin",

//     'uinfo_weixin_url'=>"http://chuangx.org/Home/Uinfo/weixin",

//     'appid'=>"wxb2752728527c79e5",

//     'weixin_secret'=>"336cb781cd2114179c1d0c981accd27d",

//     'phone_weixin_url'=>"http://chuangx.org/Home/Index/phone_weixin",

//     'phone_appid'=>"wxf707a4f6eba13bc2",

//     'phone_weixin_secret'=>'3f532cbbd8ff9cbb3fcf027e1f231d73',

// 	'MCHID'=>'1366514102',

// 	'KEY' => 'lgo3w0gjklaw21wtjksdggljkertogdr',

//     'jump_url'=>'/Home/Index/sub_url',

//     'weixin_jifen_mood'=>'OKCy7MrWpxIK4fKv_VUPfAnX3oTW1hNVs5218BCjSAg',

//     'weixin_user_change_mood'=>'dOUwrGuX0av857qbhdwAGvs8SWR0INFaPUPn9IPm6nw',

//     'weixin_zhibo_mood'=>'lMdz9cPjDTax681ESkNnKnLDqeFctv-ftlASEtC9jWk',

//     'weixinpayurl'=>'http://chuangx.org/Home/Pay/weixin/',



                //配置头像地址
      'headimg'=>'http://test.chuangx.org/',
    //301地址
    'url301' =>'test.chuangx.org',

     //需要重定向的url
    'redurl'=>'test.chuangx.org',

    'client_id'=>'70eeacddd735cb1b4fc3',

    'client_secret'=>'b151caffb7a371e712eb1bf3c78466ec93c6f78a',

    'xuetang'=>'http://test.chuangx.org/index.php/home/index/xuetang',

    'xuetang_uinfo'=>'http://test.chuangx.org/index.php/home/Uinfo/xuetang',

    'weixin_url'=>"http://test.chuangx.org/index.php/Home/Index/weixin",

    'uinfo_weixin_url'=>"http://test.chuangx.org/index.php/Home/Uinfo/weixin",

    'appid'=>"wxc258f069450da25d",

    'weixin_secret'=>"517391390bf64b298e2792cb8b36871d",

    'phone_weixin_url'=>"http://test.chuangx.org/index.php/Home/Index/phone_weixin",

    'phone_appid'=>"wxb15b4968519a05bc",

    'phone_weixin_secret'=>'d09d5d51ee0706f5f54f668cb5867aff',

    'MCHID'=>'1366575002',

    'KEY' => 'jkl342ujskl0gtljksogdlglddfghfui',

    'jump_url'=>'/index.php/Home/Index/sub_url',

    'weixin_jifen_mood'=>'YiELB23HqB798CupqR_wEOsoSny5CS-3OxIwfsmgxlU',

    'weixin_user_change_mood'=>'a6kwZn9PCw6yVQWCIClMs6weNxV1UdQtUdrXdJgTCZI',

    'weixin_zhibo_mood'=>'rdTY083AETirG8O6u0a41Xn8MpCWabuUj5YwxsQ2lR0',

    'weixinpayurl'=>'http://test.chuangx.org/index.php/Home/Pay/weixin/',

        'alipay_config'=>array(
        'partner' =>'2088421425689463',   //这里是你在成功申请支付宝接口后获取到的PID；
        'key'=>'uat8os8raz3cizuytwklvqeol0qbnzbm',//这里是你在成功申请支付宝接口后获取到的Key
        'sign_type'=>strtoupper('MD5'),
        'input_charset'=> strtolower('utf-8'),
        'cacert'=> getcwd().'\\cacert.pem',
        'transport'=> 'http',
    ),
//        'alipay_config'=>array(
//         'partner' =>'2088111930070015',   //这里是你在成功申请支付宝接口后获取到的PID；
//         'key'=>'na219jz00r740j72v6sqsef11rza9i6c',//这里是你在成功申请支付宝接口后获取到的Key
//         'sign_type'=>strtoupper('MD5'),
//         'input_charset'=> strtolower('utf-8'),
//         'cacert'=> getcwd().'\\cacert.pem',
//         'transport'=> 'http',
//     ),
    //以上配置项，是从接口包中alipay.config.php 文件中复制过来，进行配置；

    'alipay'   =>array(
    //这里是卖家的支付宝账号，也就是你申请接口时注册的支付宝账号
        'seller_email'=>'chuangedu@aliyun.com',
        //这里是异步通知页面url，提交到项目的Pay控制器的notifyurl方法；
        'notify_url'=>'http://localhost/cyxy2016/Home/Pay/notifyurl',
        //这里是页面跳转通知url，提交到项目的Pay控制器的returnurl方法；
        'return_url'=>'http://localhost/cyxy2016/Home/Pay/returnurl',
        //支付成功跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参payed（已支付列表）
        'successpage'=>'User/myorder?ordtype=payed',
        //支付失败跳转到的页面，我这里跳转到项目的User控制器，myorder方法，并传参unpay（未支付列表）
        'errorpage'=>'User/myorder?ordtype=unpay',
    ),


	//'配置项'=>'配置值'
	//腾讯QQ登录配置
	'THINK_SDK_QQ' => array(
		'APP_KEY'    => '101272595', //应用注册成功后分配的 APP ID
		'APP_SECRET' => 'f22535e6a5482eb7e6035ed44d6cb8f8', //应用注册成功后分配的KEY
		'CALLBACK'   => 'http://www.touchdelight.com/cyxy/Home/index/callback/type/' . 'qq',
	),
	//腾讯微博配置
	'THINK_SDK_TENCENT' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'tencent',
	),
	//新浪微博配置
	'THINK_SDK_SINA' => array(
		'APP_KEY'    => '3986076000',//'2684312448', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '26cebb748853281c9176955e636d7765',//'03c4c3ad8d9e88a443e8761a711da095', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'sina',
	),
	//网易微博配置
	'THINK_SDK_T163' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 't163',
	),
	//人人网配置
	'THINK_SDK_RENREN' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'renren',
	),
	//360配置
	'THINK_SDK_X360' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'x360',
	),
	//豆瓣配置
	'THINK_SDK_DOUBAN' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'douban',
	),
	//Github配置
	'THINK_SDK_GITHUB' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'github',
	),
	//Google配置
	'THINK_SDK_GOOGLE' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'google',
	),
	//MSN配置
	'THINK_SDK_MSN' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'msn',
	),
	//点点配置
	'THINK_SDK_DIANDIAN' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'diandian',
	),
	//淘宝网配置
	'THINK_SDK_TAOBAO' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'taobao',
	),
	//百度配置
	'THINK_SDK_BAIDU' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'baidu',
	),
	//开心网配置
	'THINK_SDK_KAIXIN' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'kaixin',
	),
	//搜狐微博配置
	'THINK_SDK_SOHU' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => URL_CALLBACK . 'sohu',
	),



    //配置课程主页每页显示数量
    'course_nu' => 10,
    //配置资讯主页每页显示数
    'information_nu' => 6,
    //配置首页课程显示条数
    'index_course_nu' => 8,
    //配置首页最新资讯显示条数
    'information_new_nu' =>6,
    //配置课程详情相关课程数
    'list_course_tag_cid_nu'=>4,
    //配置用户注册后的初始积分
    'initialize_credit'=>$conn,

    'LOG_RECORD'=>true,  // 进行日志记录

    'LOG_LEVEL' => 'onklic,SQL',
    //微课子首页每页显示课程数
    'weike_list' =>8,
    //微课子首页热门数
    'weike_hot' =>5,
    //一人民币兑换积分数
    'pay_jifen' =>1,
    //教师列表显示每页显示条数
    'teacher_list_nu' =>10,

    //购买会员所需积分
    'vipuser'=>299,

    //配置ip注册时间差阈值 单位秒,必须大于该值才可继续登录/注册
    'min_time_delta' => 100
);
