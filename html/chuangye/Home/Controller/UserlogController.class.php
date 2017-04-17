<?php
namespace Home\Controller;

use Think\Controller;

class UserlogController extends Controller {
    
    function index()
    {
        $id=session('id');
        
        if($id !=6379)
        {
            redirect(U('index/index'));
            
            return;
        }
        
        echo session_id();
        
        print_r($_SESSION);
    }
    
    
}
