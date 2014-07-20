<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
    public function userinfo()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
    	
    	if(I('param.uid', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
    	{
    		$uid = trim(I('param.uid'));
    		$User = M('user');
    		$map = array(
    			'user.uid' => $uid
    		);
    		$data['userinfo'] = $User->table('lab_user user')
						->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
						->field('
								user.uid uid, 
								user.name name, 
								user.kind kind, 
								userdetail.sex sex, 
								userdetail.phone phone, 
								userdetail.email email, 
								userdetail.degree degree, 
								userdetail.grade grade, 
								userdetail.birthday birthday, 
								userdetail.idcard idcard, 
								userdetail.nation nation, 
								userdetail.political political, 
								userdetail.institute institute, 
								userdetail.major major, 
								userdetail.supervisor supervisor, 
								userdetail.teacher teacher, 
								userdetail.supervisorid supervisorid, 
								userdetail.teacherid teacherid
								')
						->where($map)
						->find();
    		if($data['userinfo'] == null)
    		{
    			$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
    		}
    		$data['strlist'] = C('STR_LIST');
    	}
    	else 
    	{
    		$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
    	}
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
//     	$this->ajaxReturn($data);
        $this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
    }
    public function login_function()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	if(I('post.uid', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
    	{
    		$uid = trim(I('post.uid'));
    		$passwd = MkPasswd(trim(I('post.passwd')));
    		$User = M('user');
    		$map = array(
    			'uid' => $uid
    		);
    		$userinfo = $User->where($map)->find();
    		if($userinfo == null)
    			$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
    		else
    		{
    			if($passwd == $userinfo['passwd'])
    			{
    				session('uid', $uid);
    				session('uname', $userinfo['name']);
    				$data['uname'] = $userinfo['name'];
    			}
    			else 
    				$data['wrongcode'] = $WRONG_CODE['passwd_error'];
    		}
    	}
    	else
    		$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
    	$this->ajaxReturn($data);
    }
    public function logout_function()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	if(session('?uid'))
    	{
    		session(null);
    		$data['msg'] = $WRONG_CODE['成功登出'];
    	}
    	else 
    	{
    		$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
    		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
    	}
    	$this->ajaxReturn($data);
    }
    public function whether_loggedin_ajax()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	$data['loggedin'] = false;
    	if(session('?uid'))
    	{
    		$data['loggedin'] = true;
    		$data['uid'] = session('uid');
    		$data['uname'] = session('uname');
    	}
    	$this->ajaxReturn($data);
    }
}