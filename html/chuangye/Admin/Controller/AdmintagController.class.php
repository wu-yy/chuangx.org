<?php
namespace Admin\Controller;

use Think\Controller;

class AdmintagController extends CommonController {

    function admin_tag_index()
    {
        $list=M('admin_tag at')->join('left join admin_tag at1 ON at1.pid=at.id')->where("at.pid=0 and at.name='root' and at1.is_delect=0")->order('at1.code asc')->field('at1.id as id,at1.pid as pid, at1.code as code, at1.name as name')->select();
        
        $this->assign('list',$list);
        
        $this->display();
    }
    function add_yiji_admin_tag($name)
    {
        
        $list=M('admin_tag at')->join('left join admin_tag at1 ON at1.pid=at.id')->where("at.pid=0 and at.name='root'")->order('at1.code desc')->field('at1.id as id,at.id as pid, at1.code as code')->find();
        
        $fidnametag_admin=$this->fidnametag_admin(2324, $list['pid'], $name);
         
        if(!(empty($fidnametag_admin)))
        {
            echo "该标签分类中有相同标签,请重新编写";
            return ;
        }
        
        $add_yiji=M('admin_tag')->data(array('pid'=>$list['pid'],'code'=>$list['code']+100,'name'=>$name,'is_delect'=>0,'time'=>time()))->add();
        
        if(empty($add_yiji))
        {
            echo '添加失败未知错误';
        }
        else
        {
            echo $add_yiji;
        }
    }
    /* 修改标签名称 */
    function saname_admin_tag()
    {
    
        $id=$_GET['id'];
         
        $name=$_GET['name'];
        
        $ftag_admin_tag=$this->ftag_admin_tag(7870, $id);
         
        if(empty($ftag_admin_tag['code']))
        {
            echo "此标签不存在";
            return;
        }
         
        $fidnametag_admin=$this->fidnametag_admin(2324, $ftag_admin_tag['pid'], $name);
         
        if(!(empty($fidnametag_admin)))
        {
            echo "该标签分类中有相同标签,请重新编写";
            return ;
        }
         
        $list=$this->name_admin_tag(7839, $id, $name);
         
        if(empty($list))
        {
            echo "修改失败";
        }
        else
        {
            echo 1;
        }
         
    }
    /*
     * 蔡政
     * 搜索标签
     * 输入标签pid，name 输出标签信息
     *  */
    function fidnametag_admin($key,$pid,$name)
    {
        (!($key==2324)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('admin_tag');
    
        $where['pid']=$pid;
    
        $where['name']=$name;
    
        $list=$tag->where($where)->where("is_delect !=1")->select();
    
        return $list;
    }
    /*
     * 蔡政
     * 搜索标签
     * 输入标签id，输出标签信息
     *  */
    function ftag_admin_tag($key,$id)
    {
        (!($key==7870)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('admin_tag');
    
        $where["id"]=$id;
    
        $list=$tag->where($where)->where("is_delect !=1")->find();
    
        return $list;
    }
    /*
     * 蔡政
     * 修改标签，输入id,name
     *  */
    function name_admin_tag($key,$id,$name)
    {
        (!($key==7839)) && $this->error('禁止访问',U('Index/index'));
    
    
    
        $tag=M('admin_tag');
    
        $where['id']=$id;
    
        $data['name']=$name;
    
        $list=$tag->where($where)->save($data);
    
        if(empty($list))
            return  0;
        else
            return 1;
    
    }
    function detag_admin_tag()
    {
        $id=$_GET['id'];
    
        header("Content-Type:text/html;charset=UTF-8");  // 解决乱码问题
    
        if($id==1)
        {
            echo "此标签不可删除";
    
            return;
        }
    
    
        $ftag_admin_tag=$this->ftag_admin_tag(7870, $id);
    
        if(empty($ftag_admin_tag['code']))
        {
            echo "此标签不存在";
            return;
        }
    
    
    
        $list=$this->deletag_admin_tag(1245, 2398, $ftag_admin_tag['code']);
    
        echo $list;
    }
    /*
     * 蔡政
     * 删除标签
     * 输入id,删除该标签并删除所有子类标签
     *   */
    function deletag_admin_tag($key,$key1,$code)
    {
    
        (!($key==1245)) && $this->error('禁止访问',U('Index/index'));
    
        (!($key1==2398)) && $this->error('禁止访问',U('Index/index'));
    
        $tag=M('admin_tag');
    
        $data['is_delect']=1;
    
        $where_p['code']=array('like',$code."%");
    
        $list=$tag->where($where_p)->save($data);
    
        return $list;
    
    }
    
    function add_course()
    {
        $id=$_GET['id'];
        
        if(empty($id) || is_numeric($id)==false)
        {
            $this->error('参数错误');
            return;
        }
        
        $list1=M('admin_tag')->where(array('id'=>$id))->count();
        
        if(empty($list1))
        {
            $this->error('参数错误');
            return;
        }
        
        $list=M('course_admin_tag cat')->join('left join course c on c.id=cat.cid')->where(array('cat.tid'=>$id,'cat.type'=>1,'cat.is_delect'=>0))->field('c.title,cat.id')->select();
        
        $this->assign('list',$list);
        
        $this->assign('gid',$id);
        
        $this->display();
    }
    function add_course_admintag()
    {
        $id=$_GET['name'];
         
        $gid=$_GET['gid'];
        
        if(empty($id) || is_numeric($id)==false || empty($gid) || is_numeric($gid)==false)
        {
            $arr=array(0,'参数错误');
            echo json_encode($arr);
            return;
        }

        $admin_tag=M('admin_tag')->where(array('id'=>$gid))->find();
        
        if(empty($admin_tag['id']))
        {
            $this->error('参数错误');
            return;
        }
        
        $course=M('course')->where(array('id'=>$id))->find();
         
        if(empty($course['id']))
        {
            $arr=array(0,'输入的课程id有误');
            echo json_encode($arr);
            return;
        }
        
        $count=M('course_admin_tag')->where(array('cid'=>$id,'tid'=>$gid,'type'=>1,'is_delect'=>0))->count();
        
        if(!empty($count))
        {
            $arr=array(0,'输入的课程已存在');
            echo json_encode($arr);
            return;
        }
        else
        {
            $daa_course_group=M('course_admin_tag')->data(array('cid'=>$id,'tid'=>$gid,'code'=>$admin_tag['code'],'type'=>1,'is_delect'=>0))->add();
            
            if(empty($daa_course_group))
            {
                $arr=array(0,'录入失败，未知错误');
                echo json_encode($arr);
                return;
            }
            else
            {
                $arr=array(1,$course['title'],$daa_course_group);
                echo json_encode($arr);
                return;
            }
        }
    }
    function del_course()
    {
        $id=$_GET['id'];
         
        if(checkNumber($id)==0)
        {
            $arr=array(0,'参数错误');
            echo json_encode($arr);
            return;
        }
        
        $list=M('course_admin_tag')->where(array('id'=>$id))->data(array('is_delect'=>1))->save();
        
        if(empty($list))
        {
            $arr=array(0,'未知错误');
            echo json_encode($arr);
            return;
        }
        else
        {
            $arr=array(1);
            echo json_encode($arr);
            return;
        }
    }
    
}