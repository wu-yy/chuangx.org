<?php
/**
 * 求时间差（秒）
 */

    function get_seconds($data) {
    	$createtime = strtotime($data);
    	$seconds = time() - $createtime;
    	return $seconds;
    }
    //计算日期相差几个月
    function cmonth($date1,$date2)
    {   
        $data1= explode('-',$date1);
        $data2 =explode('-',$date2);
    
    $year1 = $data1[0];
    $month1 = $data1[1];
    
    $year2 = $data2[0];
    $month2 = $data2[1];
    
        $result = $year1*12 + $month1 - $year2*12 -$month2 +1;
    
        return $result;
    }




    /** 
     * 验证码检查 
     */  
    function check_verify($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
    }  
/* 验证变量是否为数字 */
    function checkNumber($id)
    {
        if(empty($id) || is_numeric($id)==false)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
      
    function sendSms($mobile,$tpl_value,$tpl) {
        $sendUrl = C('JUHECONFIG.URL');
        $smsConf = array(
            "key" => C('JUHECONFIG.APPKEY'), //您申请的APPKEY
            "mobile"    => $mobile,//接受短信的用户手机号码
            'tpl_id'    => $tpl, //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>$tpl_value, //您设置的模板变量，根据实际情况修改
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
    
    
    
    
?>