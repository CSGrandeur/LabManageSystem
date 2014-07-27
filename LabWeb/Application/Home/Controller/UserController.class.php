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
    				session('lab_uid', $uid);
    				session('lab_uname', $userinfo['name']);
    				$Privilege = M('privilege');
    				$privilegelist = $Privilege->where('uid='.$uid)->field('privi')->select();
    				foreach($privilegelist as $privilege)
    					session($privilege['privi'], true);
    				if(session('?lab_super_admin') && session('lab_super_admin') == true)
    					session('lab_admin', true);
    				$data['uid'] = $userinfo['uid'];
    				$data['uname'] = $userinfo['name'];
    				$data['privilege'] = $privilegelist;
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
    	if(session('?lab_uid'))
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
    private function modify_data()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('?lab_uid'))
		{
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		}
		else
		{
			if(session('?lab_admin'))
				$uid = I('param.uid', session('lab_uid'));
			else
				$uid = session('lab_uid');
			$User = M('user');
			$map = array(
				'user.uid' => $uid
			);
			$userinfo = $User->table('lab_user user')
						->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
						->field('
								user.uid uid, 
								user.name name, 
								user.kind kind, 
								user.graduate graduate, 
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
			if($userinfo == null)
			{
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			}
			else
			{
				//如果已存在对应老师，则提示其id
				if(strlen($userinfo['supervisorid']) == 0 && strlen($userinfo['supervisor']) != 0 && $userinfo['supervisorid'] != "#")
				{
					$userinfo['supervisorid'] = ContentFind($userinfo['supervisor'], 'name', 'uid', 'user', false);
				}
				if(strlen($userinfo['teacherid']) == 0 && strlen($userinfo['teacher']) != 0 && $userinfo['teacherid'] != "#")
				{
					$userinfo['teacherid'] = ContentFind($userinfo['teacher'], 'name', 'uid', 'user', false);
				}
				$data['userinfo'] = $userinfo;
			}
			$data['strlist'] = C('STR_LIST');
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		return $data;
	}
	public function modify()
	{
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data = $this->modify_data();
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else 
			$this->display();
	}
	public function modify_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$userinfo = array();
		$userdetail = array();
		$res = true;
		if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		//如果不是管理员，又(没有登录或者登陆者不是要修改的人)，则不能修改
		else if(!session('?lab_admin') && (session('?lab_uid') == null || session('lab_uid') != I('param.uid')))
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else
		{
			$User = M('user');
			$param = I('param.');
			$userinfo = $User->where('uid='.$param['uid'])->find();
			if($userinfo == null)
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			else
			{
				$userinfo['name'] = trim($param['name']);
				$userinfo['kind'] = intval(trim($param['kind']));
				$userinfo['graduate'] = intval(trim($param['graduate']));
				$passwd = trim($param['passwd']);
				$passwd_confirm = trim($param['passwd_confirm']);
				if($passwd != $passwd_confirm)
					$data['wrongcode'] = $WRONG_CODE['passwd_confirmfail'];
				//新密码不为空，且为超级管理员或用户自己
				else if($passwd != null && (session('lab_super_admin') || session('?lab_uid') && session('lab_uid') == I('param.uid')))
					$userinfo['passwd'] = MkPasswd($passwd);
				$Userdetail = M('userdetail');
				$userdetail = $Userdetail->where("uid='%s'", trim($param['uid']))->find();
				$flag = true;
				if($userdetail == null)
				{
					$flag = false;
					$userdetail = array();
					$userdetail['uid'] = trim($param['uid']);
				}
				$userdetail['sex'] = intval(trim($param['sex']));
				$userdetail['degree'] = intval(trim($param['degree']));
				$userdetail['institute'] = intval(trim($param['institute']));
				$userdetail['major'] = intval(trim($param['major']));
				$userdetail['grade'] = trim($param['grade']);
				$userdetail['birthday'] = $param['birthday'];
				$userdetail['phone'] = trim($param['phone']);
				$userdetail['email'] = trim($param['email']);
				$userdetail['nation'] = trim($param['nation']);
				$userdetail['political'] = trim($param['political']);
				$userdetail['supervisor'] = trim($param['supervisor']);
				$userdetail['supervisorid'] = trim($param['supervisorid']);
				$userdetail['idcard'] = trim($param['idcard']);
				$userdetail['teacher'] = trim($param['teacher']);
				$userdetail['teacherid'] = trim($param['teacherid']);
				if(strlen($userdetail['supervisorid']) != 0 && $userdetail['supervisorid'] != "#")
				{
					if(ContentMatch($userdetail['supervisorid'], $userdetail['supervisor'], 'uid', 'name', 'user', false) != $WRONG_CODE['totally_right'])
						$data['wrongcode'] = $WRONG_CODE['content_wrongmatch'];
					else 
						$userdetail['supervisorid'] = ContentFind($userdetail['supervisor'], 'name', 'uid', 'user', false);
				}
				if(strlen($userdetail['teacherid']) != 0 && $userdetail['teacherid'] != "#")
				{
					if(ContentMatch($userdetail['teacherid'], $userdetail['teacher'], 'uid', 'name', 'user', false) != $WRONG_CODE['totally_right'])
						$data['wrongcode'] = $WRONG_CODE['content_wrongmatch'];
					else
						$userdetail['teacherid'] = ContentFind($userdetail['teacher'], 'name', 'uid', 'user', false);
				}
			}	
		}

		if($data['wrongcode'] == $WRONG_CODE['totally_right'])
		{
			$res = $User->save($userinfo);
			if($flag) $res = $res || $Userdetail->save($userdetail);
			else $res = $res || $Userdetail->add($userdetail);
			if($res == false) $data['wrongcode'] = $WRONG_CODE['sql_notupdate'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
    public function whether_loggedin_ajax()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	$data['loggedin'] = false;
    	if(session('?lab_uid'))
    	{
    		$data['loggedin'] = true;
    		$data['uid'] = session('lab_uid');
    		$data['uname'] = session('lab_uname');
    	}
    	$this->ajaxReturn($data);
    }
}