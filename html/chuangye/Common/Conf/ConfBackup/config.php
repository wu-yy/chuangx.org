<?php

return array(
		//'配置项'=>'配置值'
		
		'APP_USE_NAMESPACE'    => true,
		
	     'URL_MODEL'          => '1', //URL模式  如果你的环境不支持PATHINFO 请设置为3 */ 
	    
		'SESSION_AUTO_START' => true, //是否开启session
		
		'APP_STATUS'=>debug,
    
         'URL_CASE_INSENSITIVE' =>true, 
    
        
		// ===================================================
		// 数据库配置信息
 
/*        'DB_HOST'                   =>  'rds2m5a298pyr6890g6z.mysql.rds.aliyuncs.com',
    
    'DB_NAME'                   =>  'main_rds',
    
    'DB_USER'                   =>  'web_server',
    
    'DB_PWD'                    =>  'web_C2016_Tuspark',  */

    
/*       	'DB_HOST'                   =>  'www.touchdelight.cn',
 		'DB_NAME'                   =>  'cyxy',		
 		'DB_USER'                   =>  'caizheng',	
 		'DB_PWD'                    =>  'touchdelight',   */
          	'DB_HOST'                   =>  '127.0.0.1',
             'DB_NAME'                   =>  'test_rds',
             'DB_USER'                   =>  'root',
             'DB_PWD'                    =>  '',
    /*
      'DB_HOST'                   =>  'rds2m5a298pyr6890g6z.mysql.rds.aliyuncs.com',
    
    'DB_NAME'                   =>  'test_rds',
    
    'DB_USER'                   =>  'tester',
    
    'DB_PWD'                    =>  'test_C2016_Tuspark',
    */
		 
		//显示调试信息
		
		'SHOW_PAGE_TRACE'           =>  0, 
		
		// ===================================================
		// 系统配置

		
		'DB_TYPE'                   =>  'mysql',
		
		'DB_PORT'                   =>  '3306',
		
		'MDSMSCONFIG'=>array(
				'URL'=>'sdk.entinfo.cn:8060/webservice.asmx',
				'SN'=>'SDK-BBX-010-19354',
				'PASSWORD'=>'74@f51c@'
		),
		
	   //聚合接口
	   'JUHECONFIG'=>array(
	       'URL'=>'http://v.juhe.cn/sms/send',
	       'APPKEY'=>'58a40c4dde112c54e7f90d6a09866b60',
	       'tpl_id'=>'8209'
	   ),	
    
    
    
/* 		'DB_PREFIX'                 =>  'zyd1_', */
		
		//=======================================================
		// 配置邮件发送服务器

/*         'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
		
		'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
		
		'MAIL_USERNAME' =>'q1293180812@163.com',//发件人的邮箱名
		
		'MAIL_PASSWORD' =>'lhmdmybnrafmcltc',//163邮箱发件人授权密码
		
		'MAIL_FROM' =>'q1293180812@163.com',//发件人邮箱地址
		
		'MAIL_FROMNAME'=>'创业学院注册验证码',//发件人姓名
		
		'MAIL_CHARSET' =>'utf-8',//设置邮件编码
		
		'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件 */
    
    //=====================================================================
    
        'MAIL_HOST' =>'smtp.chuangedu.com.cn',//smtp服务器的名称
        
        'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
        
        'MAIL_USERNAME' =>'service@chuangedu.com.cn',//发件人的邮箱名
        
        'MAIL_PASSWORD' =>'web$C2016#Tuspark',//163邮箱发件人授权密码
        
        'MAIL_FROM' =>'service@chuangedu.com.cn',//发件人邮箱地址
        
        'MAIL_FROMNAME'=>'创业学院注册验证码',//发件人姓名
        
        'MAIL_CHARSET' =>'utf-8',//设置邮件编码
        
        'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件


       // 'TMPL_EXCEPTION_FILE'=>'./chuangye/Tpl/Public/404.html' // 定义公共错误模板   */
    
    
);