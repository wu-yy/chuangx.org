<?php
namespace Admin\Controller;
use Think\Controller;

class SendmessageController extends CommonController {
    protected $appid;
    protected $secrect;
    protected $accessToken;
    
    function  _initialize()
    {
        $this->appid = C('phone_appid');
        $this->secrect = C('phone_weixin_secret');
        $this->accessToken = $this->getToken(C('phone_appid'), C('phone_weixin_secret'));
    }
    
    /**
     * 发送post请求
     * @param string $url
     * @param string $param
     * @return bool|mixed
     */
    function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch); //运行curl
        curl_close($ch);
        return $data;
    }
    
    protected function getToken($appid, $appsecret)
    {
        if (S($appid)) {
            $access_token = S($appid);
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
            $token = $this->request_get($url);
            $token = json_decode(stripslashes($token));
            $arr = json_decode(json_encode($token), true);
            $access_token = $arr['access_token'];
            S($appid, $access_token, 720);
        }
        return $access_token;
    }
    
    /**
     * 发送get请求
     * @param string $url
     * @return bool|mixed
     */
    function request_get($url = '')
    {
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    
    
    public function doSend($data,$user_openid,$template_id,$url='')
    {
    
    
    
         
        $template = array(
            'touser' => $user_openid,
            'template_id' => $template_id,
            'url' => $url,
            'topcolor' => "#7b68ee",
            'data' => $data
        );
    
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->accessToken;
        $dataRes = $this->request_post($url,urldecode($json_template));
        if ($dataRes['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    
    
    }
    
    
    function ch_json_encode($data) {
         
        function ch_urlencode($data) {
            if (is_array($data) || is_object($data)) {
                foreach ($data as $k => $v) {
                    if (is_scalar($v)) {
                        if (is_array($data)) {
                            $data[$k] = urlencode($v);
                        } else if (is_object($data)) {
                            $data->$k = urlencode($v);
                        }
                    } else if (is_array($data)) {
                        $data[$k] = ch_urlencode($v); //递归调用该函数
                    } else if (is_object($data)) {
                        $data->$k = ch_urlencode($v);
                    }
                }
            }
            return $data;
        }
         
        $ret = ch_urlencode($data);
        $ret = json_encode($ret);
        return urldecode($ret);
    }

    function weixin_mood($phone_openid,$mood_type,$send_type,$time='',$type='',$number='',$amount='',$url='')
    {
        if($send_type==1)
        {
            if(empty($phone_openid))
            {
                return false;
            }
            if($mood_type=='weixin_jifen')
            {
                if($type==0)
                {
                    $type='注册赠送积分';
                    $creditChange='到账';
                    $creditName='账户积分';
                }
                if($type==1)
                {
                    $type='购买课程消费积分';
                    $creditChange='花费';
                    $creditName='账户积分';
                }
                if($type==2)
                {
                    $type='完结课程反积分';
                    $creditChange='到账';
                    $creditName='账户积分';
                }
                if($type==3)
                {
                    $type='积分码充值积分';
                    $creditChange='到账';
                    $creditName='账户积分';
                }
                if($type==4)
                {
                    $type='加入群组赠送积分';
                    $creditChange='到账';
                    $creditName='账户积分';
                }
                if($type==5)
                {
                    $type='微信支付充值积分';
                    $creditChange='到账';
                    $creditName='账户积分';
                }
                if($type==6)
                {
                    $type='购买会员消费积分';
                    $creditChange='花费';
                    $creditName='账户积分';
                }
                $data=array(
                    'first'=>array('value'=>urlencode("您有新的积分信息，详情如下")),
                    'account'=>array('value'=>urlencode($user_list['nikename'])),
                    'time'=>array('value'=>urlencode($time)),
                    'type'=>array('value'=>urlencode($type)),
                    'creditChange'=>array('value'=>urlencode($creditChange)),
                    'number'=>array('value'=>urlencode($number)),
                    'creditName'=>array('value'=>urlencode($creditName)),
                    'amount'=>array('value'=>urlencode($amount)),
                    'remark'=>array('value'=>urlencode('您可以点击下方菜单-我的账户，随时查询账户余额')),
                );
                $template_id=C('weixin_jifen_mood');
            }
            if($mood_type=='weixin_user_change')
            {
                $data=array(
                    'first'=>array('value'=>urlencode("恭喜你成功升级为钻石会员"),'color'=>""),
                    'account'=>array('value'=>urlencode($user_list['nikename']),'color'=>''),
                    'time'=>array('value'=>urlencode($time),'color'=>''),
                    'type'=>array('value'=>urlencode($type),'color'=>''),
                    'remark'=>array('value'=>urlencode('恭喜你升级为钻石会员，点击查看会员特权'),'color'=>''),
                );
                $template_id=C('weixin_user_change_mood');
            }
            if($mood_type=='weixin_zhibo')
            {
                $data=array(
                    'first'=>array('value'=>urlencode($time),'color'=>""),
                    'keyword1'=>array('value'=>urlencode($type),'color'=>''),
                    'keyword2'=>array('value'=>urlencode($number),'color'=>''),
                    'remark'=>array('value'=>urlencode($amount),'color'=>''),
                );
                $template_id=C('weixin_zhibo_mood');
            }
        }
        if($send_type==1)
        {
    
            $re=$this->doSend($data, $phone_openid, $template_id,$url);
            
            if($re)
            {
                return 1;
            }
            else 
            {
                return 0;   
            }
        }
    
    
    }
}