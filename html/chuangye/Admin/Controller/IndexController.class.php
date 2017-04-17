<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    //显示菜单项
        $menu  = array();
        /* isset($_SESSION['menu'.$_SESSION['uid']]) */
        if($a==112323 ) {
            //如果已经缓存，直接读取缓存
            $menu   =   $_SESSION['menu'.$_SESSION['uid']];
        }else {
           // 读取数据库模块列表生成菜单项
            $node    =   M("nodes");
            $where['status']=1;
			$where['parentid']=0;
            $list = $node -> where($where) -> field('id,nodename,url,class') -> order('ordernum asc')->select();
           
             //var_dump($list);
            if(session('issys') == 1) {
                $menu = $list;
                $this->assign('url','Picture/index');
            } else {
                //节点数组
                $ru=M('role_user')->where(array('user_id'=>session('uid')))->field('role_id')->find();
                $menu=M("role_node rn")->join("nodes n ON n.id=rn.node_id")->where(array("rn.role_id"=>$ru["role_id"]))->field('n.nodename,n.id,n.url,n.class')->order("n.ordernum asc")->select();
               
                $arr= explode('/', $menu[0]['url']);
                
                if(count($arr)>1)
                {
                    $url=$menu[0]['url'];
                }
                else 
                {
                    $url=$menu[0]['url'].'/index';
                }
                $this->assign('url',$url);
               
            }
            
            
			foreach( $menu as $k=>$v) {
                  $menu[$k]['nlist']=M("nodes")->where(array('parentid'=>$v['id'],'status'=>1))->order("ordernum asc")->select();
                }
              $_SESSION['menu'.$_SESSION['uid']] =   $menu;
        }

    	  $this->assign('menu',$menu);
         $Username=$_SESSION['username'];


    	$this->assign('username',$Username);
    	
    	
        $this->display();
    }
}