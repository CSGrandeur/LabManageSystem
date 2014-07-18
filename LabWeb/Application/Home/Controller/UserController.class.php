<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function userinfo(){
    	
        $this->display();
    }
    public function whether_loggedin_ajax()
    {
    	$data['valid'] = true;
    	$data['loggedin'] = false;
    	if(session('?uid'))
    	{
    		$data['loggedin'] = true;
    		$data['uid'] = session('uid');
    	}
    	$this->ajaxReturn($data);
    }
}