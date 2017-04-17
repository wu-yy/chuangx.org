<?php
namespace Admin\Controller;
use Think\Controller;

class AdinformationController extends CommonController {
    function index()
    {
        $this->display();
    }
    function homepage()
    {
        $banner=M('banner')->where('is_delect != 1')->order('id desc')->select();
        $this->assign('banner',$banner);
        //资讯置顶
        $informationtop=M('informationtop')->where('type=1')->limit(1)->order('id desc')->select();
        $this->assign('informationtop',$informationtop);
        $this->display();
    }
   
    function upload()
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        if(empty($_FILES['photo']) || empty($_POST['title']) || empty($_POST['body']))
        {
            $this->error('所有内容必须填写');
            return;
        }
        
        $nu=$_POST['nu'];
        
        if( !is_numeric($nu))
        {
            $this->error('初始访问必须为整数');
            return;
        }
        
        $photo=$this->getphoto($_FILES['photo']);
        
        $data['img']=$photo;
        $title=str_replace(array(" "), "&nbsp", $_POST['title']);
        $data['title']=$title;
        
        $body=stripslashes($_POST['body']);
        
        $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
        
        $body=str_replace('\'','"',$body);

        $data['body']=$body;
        
        if(empty($_POST['type_value']))
        {
            $data['type']=0;
        }
        else
        {
            $data['type']=$_POST['type_value'];
        }
        
        $data['nu']=$_POST['nu'];
        
        $data['time']=time();
        
        $data['brief']=$_POST['brief'];
        
        $information=M('information');
        
        $list=$information->add($data);
        
        if($list)
        {
            $this->success('添加成功',U('Adinformation/index'));

        }
        else 
        {
            
            $this->error('添加失败，未知错误');
        }
    }
    /*
     *
     *  上传资讯图片
     *
     *  */
    function getphoto($photo)
    {
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/information/'; // 设置附件上传根目录
        $upload->saveName  = time().'_'.mt_rand(10,99);
        $upload->autoSub = false;
        // 上传文件
        $info   =   $upload->uploadOne($photo);
        if(!$info) {// 上传错误提示错误信息
            return ;
        }else{// 上传成功
            return  $image='./Uploads/information/'.$info['savename'];
        }
    }
    function table()
    {
        
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        
        $information=M('information');
        
        $list=$information->order('id desc')->select();
        
        $this->assign('list',$list);
        
        $this->display();
    }
    /* 
     * 删除课程
     * 输入课程id，删除课程 
     *  */
    function del($id)
    {
        $information=M('information');
        
        $where['id']=$id;
        
        $data['is_delect']=1;
        
        $list=$information->where($where)->save($data);
        
        echo $list; 
    }
    /*
     * 恢复课程
     * 输入课程id，恢复课程
     *  */
    function sav($id)
    {
        $information=M('information');
    
        $where['id']=$id;
    
        $data['is_delect']=0;
    
        $list=$information->where($where)->save($data);
    
        echo $list;
    }
    function xiugai($id)
    {
        
        $information=M('information');
        
        $where['id']=$id;
        
        $list=$information->where($where)->select();
        
        $list[0]['body']=str_replace(array("\r\n", "\r", "\n"), "<br />", $list[0]['body']);
        
        $list[0]['body']=str_replace('\'','"',$list[0]['body']);
        
        $this->assign('list',$list);
        
        $this->display();
        
    }
    function upload_xiugai()
    {
        
        
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
        if( empty($_POST['title']) || empty($_POST['body']))
        {
            $this->error('所有内容必须填写');
            return;
        }
        if(empty($_POST['id']))
        {
            $this->error('参数错误，请刷新页面');
        }
        $nu=$_POST['nu'];
    
        if( !is_numeric($nu))
        {
            $this->error('初始访问必须为整数');
            return;
        }
        
        $id=$_POST['id'];
        
        $arr_p=$_FILES['photo'];
        
        if(empty($arr_p['error']))
        {
            $photo=$this->getphoto($_FILES['photo']);
            
            $data['img']=$photo;
        }
        
        if(empty($_POST['type_value']))
        {
            $data['type']=0;
        }
        else
        {
            $data['type']=$_POST['type_value'];
        }
        
        $data['mark_bit']=$_POST['youxian'];

        $title=str_replace(array(" "), "&nbsp", $_POST['title']);
        
        $data['title']=$title;
        
        $body=stripslashes($_POST['body']);
        
        $body=str_replace(array("\r\n", "\r", "\n"), "<br />", $body);
        
        $body=str_replace('\'','"',$body);
    
        $data['body']=$body;
    
        $data['nu']=$_POST['nu'];
        
        $data['brief']=$_POST['brief'];
    
        $information=M('information');
        
        $where['id']=$id;
    
        $list=$information->where($where)->save($data);
    
        if($list)
        {
            $this->success('添加成功',U('Adinformation/table'));
    
        }
        else
        {
    
            $this->error('添加失败，未知错误');
        }
    }
    function addbanner()
    {
        $this->display();
    }
    function banner()
    {
    
        $data['name']=I('name');
         
        $data['url']= I('url');
         
        $photo=$_FILES['picurl'] ;
         
        $data['img']= $this->getphoto($photo);
         
        $data['time']=time();
         
        $data['is_delect']=0;
         
        $list=M('banner')->add($data);
         
        if(!empty($list))
            $this->success("添加成功");
        else
            $this->error("添加失败");
         
    }
    function savebanner()
    {
        header("Content-Type:text/html;charset=UTF-8");
        $id=I('id');
    
        if(!empty($_POST['name']))
            $data['name']=I('name');
        if(!empty($_POST['url']))
            $data['url']=I('url');
        if(!empty($_FILES['picurl']['name']))
            $data['img']= $this->getphoto($_FILES['picurl']);
        if(empty($data))
            $this->error('没有更改的内容');
        else
            $list=M('banner')->where("id=$id")->save($data);
        if(empty($list))
            $this->error('修改失败');
        else
            $this->success('修改成功');
    }
    public function editbanner(){
    
        $id=I('id');
    
        $huodong=M('banner')->where("id=$id and is_delect != 1")->order('id desc')->select();
    
        $this->assign('huodong',$huodong);
    
        $this->assign('id',$id);
    
        $this->display();
    }
    public function addinformationtop()
    {
        $this->display();
    }
    function informationtop()
    {
        $informationtop=M('informationtop');
    
        $data['url']=$_POST['url'];
        
        $picurl=$_FILES['picurl'];
        
        $data['img']=$this->getphoto($picurl);
    
        $data['type']=1;

        $list=$informationtop->add($data);
    
        if($list)
        {
            $this->success('新增资讯置顶成功');
        }
        else
        {
            $this->error('新增资讯置顶失败');
        }
    }
    function editinformation()
    {
        $id=I('id');
    
        $informationtop=M('informationtop')->where("id=$id")->limit(1)->order('id desc')->select();
        $this->assign('informationtop',$informationtop);
        $this->assign('id',$id);
        $this->display();
    }
    function edinformation()
    {
        $id=I('id');
        $url=I('url');
        if(empty($url)){$this->error('请填写url地址');}
        $data['url']=$url;
        $informationtop=M('informationtop')->where("id=$id")->save($data);
        if($informationtop)
        {
            $this->success('更改成功');
        }
        else
        {
            $this->error('没有更改内容');
        }
    
    }
    public function delbanner(){
        $id=I("id");
        if(empty($id)){
            $this->error('错误操作');
        }else{
            $data['is_delect']=1;
            $res=M("banner")->where("id=$id")->save($data);
            if($res==true){
                $this->success("删除成功");
            }else{
                $this->error("删除失败");
                	
            }
            	
        }
    }
    function test()
    {
        $this->display();
    }
}