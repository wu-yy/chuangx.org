<?php
namespace Admin\Controller;
use Think\Controller;

class TagController extends CommonController {
    
    function tag()
    {
    
        $list1=M('tag')->where('pid=0')->find();
    
        $tid=$list1['id'];
    
        $list=M('tag')->where("pid=$tid")->select();
    
        $this->assign('list',$list);
    
        $this->display();
    }
    /*
     * 蔡政
     * 获取标签
     * 输入pid 输出子类标签
     *  */
    function gettag_pid($id)
    {
        $tag=M('tag');
    
        $where['pid']=$id;
    
        $list=$tag->where($where)->where("is_delect != 1")->select();
    
        if(empty($list))
        {
            echo '';
        }
        else
        {
            $list=json_encode($list);
    
            print_r($list);
        }
    
    }
    function saname()
    {
    
        $id=$_GET['id'];
         
        $name=$_GET['name'];
         
        $ftag=$this->ftag(7870, $id);
         
        if(empty($ftag['code']))
        {
            echo "此标签不存在";
            return;
        }
         
        $fidnametag=$this->fidnametag(2324, $ftag['pid'], $name);
         
        if(!(empty($fidnametag)))
        {
            echo "该标签分类中有相同标签,请重新编写";
            return ;
        }
         
        $list=$this->name(7839, $id, $name);
         
        if(empty($list))
        {
            echo "修改失败";
        }
        else
        {
            echo 1;
        }
         
    }
    function detag()
    {
        $id=$_GET['id'];
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        if($id==1 || $id==2)
        {
            echo "此标签不可删除";
    
            return;
        }
    
    
        $ftag=$this->ftag(7870, $id);
    
        if(empty($ftag['code']))
        {
            echo "此标签不存在";
            return;
        }
    
    
    
        $list=$this->deletag(1245, 2398, $ftag['code']);
    
        if(empty($list))
            echo '删除失败，未知错误！！';
        else
            echo '删除成功';
    }
    /*
     * 蔡政
     * 将标签插入标签表中
     * 输入：标签名,父类id(pid)
     *  */
    function addtag()
    {
        (empty($_GET['name']) || empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        $name=$_GET['name'];
    
        $pid=$_GET['pid'];
    
        $ftag=$this->ftag(7870, $pid);
    
        if(!(empty($ftag['is_delect'])))
        {
            echo "您输入的父类已删除";
    
            return;
        }
    
        $fidnametag=$this->fidnametag(2324, $pid, $name);
    
        if(!(empty($fidnametag)))
        {
            echo "该标签分类中有相同标签,请重新编写";
            return ;
        }
    
        $code=$this->appendtagN1(1110,$pid);
    
        $list=$this->adtag(0101,$name,$pid,$code);
    
        if(empty($list))
        {
            echo "添加失败";
            return;
        }
    
        echo $list;
    
    }
    /*
     * 蔡政
     * 搜索标签
     * 输入标签id，输出标签信息
     *  */
    function ftag($key,$id)
    {
        (!($key==7870)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('tag');
    
        $where["id"]=$id;
    
        $list=$tag->where($where)->where("is_delect !=1")->find();
    
        return $list;
    }
    /*
     * 蔡政
     * 搜索标签
     * 输入标签pid，name 输出标签信息
     *  */
    function fidnametag($key,$pid,$name)
    {
        (!($key==2324)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('tag');
    
        $where['pid']=$pid;
    
        $where['name']=$name;
    
        $list=$tag->where($where)->where("is_delect !=1")->select();
    
        return $list;
    }
    /*
     * 蔡政
     * 生成编号
     * 输入父类id（pid），输出编号
     *  */
    function appendtagN1($key,$pid)
    {
        (!($key==1110)) && $this->error('禁止访问',U('Index/index'));
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        (empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
    
        $pid=$_GET['pid'];
    
        $big_tag=$this->big_tag(7770,$pid);
    
        if(!(empty($big_tag['code'])))
        {
            $code=$big_tag['code']+1;
             
        }
        else
        {
    
            $ftag=$this->ftag(7870,$pid);
    
            if(!(empty($ftag['code'])))
            {
                $code=$ftag['code'].'001';
            }
            else
            {
                echo "父类不存在";
    
                return;
            }
        }
    
        return $code;
    
    }
    /*
     * 蔡政
     * 标签插入tag表中
     * 输入 名称（name），父类id（pid）,编码（code）
     * 返回1，插入成功，0插入失败
     *  */
    function adtag($key,$name,$pid,$code)
    {
        (!($key==0101)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('tag');
    
        $data['time']=time();
    
        $data['name']=$name;
    
        $data['pid']=$pid;
    
        $data['code']=$code;
    
        $data['is_delect']=0;
    
        $list=$tag->data($data)->add();
    
        return $list;
    }
    /*
     * 蔡政
     * 搜索标签
     * 输入标签pid 输出最大code值的标签信息
     *  */
    function big_tag($key,$pid)
    {
        (!($key==7770)) && $this->error('禁止访问',U('Index/index'));
    
        (empty($_GET['pid'])) && $this->error('参数错误',U('Index/index'));
    
        $pid=$_GET['pid'];
    
        $tag=M('tag');
    
        $list=$tag->where("pid=$pid")->order('code desc')->find();
    
        return $list;
    }
    /*
     * 蔡政
     * 修改标签，输入id,name
     *  */
    function name($key,$id,$name)
    {
        (!($key==7839)) && $this->error('禁止访问',U('Index/index'));
    
    
    
        $tag=M('tag');
    
        $where['id']=$id;
    
        $data['name']=$name;
    
        $list=$tag->where($where)->save($data);
    
        if(empty($list))
            return  0;
        else
            return 1;
    
    }
    /*
     * 蔡政
     * 删除标签
     * 输入id,删除该标签并删除所有子类标签
     *   */
    function deletag($key,$key1,$code)
    {
    
        (!($key==1245)) && $this->error('禁止访问',U('Index/index'));
    
        (!($key1==2398)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('tag');
    
        $data['is_delect']=1;
    
        $where_p['code']=array('like',$code."%");
    
        $list=$tag->where($where_p)->save($data);
    
        return $list;
    
    }
}