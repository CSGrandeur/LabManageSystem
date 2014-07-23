<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
	public function index()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		
		
		$this->display();
	}
	//添加用户
	public function adduser()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		$this->display();
	}
	//添加用户逻辑处理
	public function adduser_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.adduser', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$ADDUSER_ITEM = C('ADDUSER_ITEM');
			$addusertext = I('param.adduser');
			$adduserlist = preg_split("/[\\r\\n]{1,2}/", $addusertext);
			$add_cnt = 0;
			$update_cnt = 0;
			$fail_cnt = 0;
			$useradd_i = 0;
			foreach($adduserlist as $singleusertext)
			{
				if(strlen(trim($singleusertext)) == 0) continue;
				$singleuserinfo = preg_split("/[$\\t]/i", $singleusertext);
				$userinfo[$useradd_i] = array();
				for($i = 0; $i < count($singleuserinfo) && $i < count($ADDUSER_ITEM); $i ++)
					$userinfo[$useradd_i][$ADDUSER_ITEM[$i]] = trim($singleuserinfo[$i]);
				$userinfo[$useradd_i]['graduate'] = 0;
				if(count($singleuserinfo) < 2 || 
					TestUserID($userinfo[$useradd_i]['uid']) != $WRONG_CODE['totally_right'] ||
					strlen($userinfo[$useradd_i]['name']) > 25 ||
					$userinfo[$useradd_i]['passwd'] != null && $userinfo[$useradd_i]['passwd'] != "" && 
					TestPasswd($userinfo[$useradd_i]['uid']) != $WRONG_CODE['totally_right'])
					$fail_cnt ++;	
				else 
				{
					if($userinfo[$useradd_i]['passwd'] == null)
						$userinfo[$useradd_i]['passwd'] = $userinfo[$useradd_i]['uid'];
					if($userinfo[$useradd_i]['kind'] != null)
						$userinfo[$useradd_i]['kind'] = intval($userinfo[$useradd_i]['kind']);
					else 
						$userinfo[$useradd_i]['kind'] = 41;//41是学生，参考/Common/Conf/ConstVal.php
					$userinfo[$useradd_i]['passwd'] = MkPasswd($userinfo[$useradd_i]['passwd']);
					$useradd_i ++;
				}
			}
			if($useradd_i > 0)
			{
				$User = M('user');
				for($i = 0; $i < $useradd_i; $i ++)
				{
					$existuser = $User->where("uid='%s'", $userinfo[$i]['uid'])->find();
					$ret = true;
					if($existuser == null)
					{
						$ret = $User->add($userinfo[$i]);
						$add_cnt ++;
					}
					else
					{
						$User->where("uid='%s'", $userinfo[$i]['uid'])->save($userinfo[$i]);
						$update_cnt ++;
					}
					if($ret == false)
						$fail_cnt ++;
				}
			}
			$data['add_cnt'] = $add_cnt;
			$data['update_cnt'] = $update_cnt;
			$data['fail_cnt'] = $fail_cnt;
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//更改用户信息前的信息获取
	private function changeinfo_data()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		if(I('param.uid', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			$uid = trim(I('param.uid'));
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
			else///有错误，#
			{
				//如果已存在对应老师，则提示其id
				if(strlen($userinfo['supervisorid']) == 0 && strlen($userinfo['supervisor']) != 0 && $userinfo['supervisorid'] != "#")
				{
					$userinfo['supervisorid'] = ContentFind($userinfo['supervisor'], 'name', 'uid', 'user', false);
				}
//						file_put_contents("loog.txt", print_r($User->_sql(), true));
//	 						$fp = fopen("loog.txt", "a+");
//	 						fwrite ($fp, $userinfo);
//	 						fwrite ($fp, "\n");
//	 						fclose($fp);
				if(strlen($userinfo['teacherid']) == 0 && strlen($userinfo['teacher']) != 0 && $userinfo['teacherid'] != "#")
				{
					$userinfo['teacherid'] = ContentFind($userinfo['teacher'], 'name', 'uid', 'user', false);
				}
				$data['userinfo'] = $userinfo;
			}
			$data['strlist'] = C('STR_LIST');
		}
		else 
		{
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		return $data;
	}
	//更改用户信息页
	public function changeinfo()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data = $this->changeinfo_data();
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	//更改用户信息逻辑处理
	public function changeinfo_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$User = M('user');
			$param = I('param.');
			$userinfo = $User->where('uid='.$param['uid'])->field('passwd', true)->find();
			if($userinfo == null)
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			else
			{
				$userinfo['name'] = trim($param['name']);
				$userinfo['kind'] = intval(trim($param['kind']));
				$userinfo['graduate'] = intval(trim($param['graduate']));
				$res = $User->save($userinfo);
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
				$userdetail['birthday'] = date("Y-m-d", trim($param['birthday']));
				$userdetail['phone'] = trim($param['phone']);
				$userdetail['email'] = trim($param['email']);
				$userdetail['nation'] = trim($param['nation']);
				$userdetail['political'] = trim($param['political']);
				$userdetail['supervisor'] = trim($param['supervisor']);
				$userdetail['supervisorid'] = trim($param['supervisorid']);
				$userdetail['idcard'] = trim($param['idcard']);
				$userdetail['teacher'] = trim($param['teacher']);
				$userdetail['teacherid'] = trim($param['teacherid']);
				if(strlen($userdetail['supervisorid']) != 0)
				{
					if(ContentMatch($userdetail['supervisorid'], $userdetail['supervisor'], 'uid', 'name', 'user', false) != $WRONG_CODE['totally_right'])
						$data['wrongcode'] = $WRONG_CODE['content_wrongmatch'];
					else 
						$userdetail['supervisorid'] = ContentFind($userdetail['supervisor'], 'name', 'uid', 'user', false);
				}
				if(strlen($userdetail['teacherid']) != 0)
				{
					if(ContentMatch($userdetail['teacherid'], $userdetail['teacher'], 'uid', 'name', 'user', false) != $WRONG_CODE['totally_right'])
						$data['wrongcode'] = $WRONG_CODE['content_wrongmatch'];
					else
						$userdetail['teacherid'] = ContentFind($userdetail['teacher'], 'name', 'uid', 'user', false);
				}
				if($data['wrongcode'] == $WRONG_CODE['totally_right'])
				{
					if($flag) $res = $res || $Userdetail->save($userdetail);
					else $res = $res || $Userdetail->add($userdetail);
	
					if($res == false) $data['wrongcode'] = $WRONG_CODE['sql_notupdate'];
				}
			}	
		}
		
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//用户管理页
	public function manageuser()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$this->display();
	}
	//用户列表数据json
	public function user_list_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'uid'; break;
				case 1: $d_ordercol = 'name'; break;
				case 2: $d_ordercol = 'sex'; break;
				case 3: $d_ordercol = 'grade'; break;
				case 4: $d_ordercol = 'degree'; break;
				case 5: $d_ordercol = 'supervisor'; break;
				case 6: $d_ordercol = 'teacher'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
				'user.uid' => array('like', '%'.$d_searchvalue.'%'),
				'user.name' => array('like', '%'.$d_searchvalue.'%'),
// 				'user.kind' => array('like', '%'.$d_searchvalue.'%'),
//				'userdetail.sex' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.phone' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.email' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.degree' => array('like', '%'.$d_searchvalue.'%'),
 				'userdetail.grade' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.birthday' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.idcard' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.nation' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.political' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.institute' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.major' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.supervisor' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.teacher' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.supervisorid' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.teacherid' => array('like', '%'.$d_searchvalue.'%'),
				'_logic' => 'or'
			);
		}
		$User = M('user');
		$userlist = $User->table('lab_user user')
					->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
					->field('
							user.uid uid, 
							user.name name,
							user.graduate graduate,
							userdetail.sex sex, 
							userdetail.phone phone, 
							userdetail.email email, 
							userdetail.degree degree, 
							userdetail.grade grade, 
							userdetail.supervisor supervisor, 
							userdetail.teacher teacher,
							userdetail.supervisorid supervisorid,
							userdetail.teacherid teacherid
							')
					->where($map)
					->order(array($d_ordercol=>$d_orderdir))
					->limit($d_start, $d_length)
					->select();
		if($userlist == false) $userlist = array();
		for($i = 0; $i < count($userlist); $i ++)
		{
			if($userlist[$i]['graduate'] == 0)
				$userlist[$i]['graduate'] = '<a class="ui tiny blue button" name="'.$userlist[$i]['uid'].'">在校</a>';
			if($userlist[$i]['graduate'] == 0)
				$userlist[$i]['graduate'] = '<a class="ui grey button" name="'.$userlist[$i]['uid'].'">毕业</a>';
			$userlist[$i]['changeinfo'] = '<a data-pjax href="/home/admin/changeinfo?uid='.$userlist[$i]['uid'].'">修改</a>';
			$userlist[$i]['supervisor'] = '<a data-pjax href="/home/user/userinfo?uid='.$userlist[$i]['supervisorid'].'">'.$userlist[$i]['supervisor'].'</a>';
			$userlist[$i]['teacher'] = '<a data-pjax href="/home/user/userinfo?uid='.$userlist[$i]['teacherid'].'">'.$userlist[$i]['teacher'].'</a>';
			$userlist[$i]['uid'] = '<a data-pjax href="/home/user/userinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['uid'].'</a>';
		}
		$data['data'] = $userlist;
		$data['draw'] = $d_draw;
		$data['recordsTotal'] = $User->count();
		$data['recordsFiltered'] = count($data['data']);
		
		$this->ajaxReturn($data);
	}
	//权限管理页
	public function manageprivilege()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$Privilege = M('privilege');
		$data['privilegelist'] = $Privilege->table('lab_privilege privilege')
									->join('LEFT JOIN lab_user user ON user.uid = privilege.uid')
									->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = privilege.uid')
									->field('
											privilege.id id,
											privilege.uid uid,
											user.name name,
											privilege.privi privi,
											user.graduate graduate,
											userdetail.sex sex, 
											userdetail.phone phone, 
											userdetail.email email, 
											userdetail.degree degree, 
											userdetail.grade grade, 
											userdetail.supervisor supervisor, 
											userdetail.teacher teacher,
											userdetail.supervisorid supervisorid,
											userdetail.teacherid teacherid
											')
									->order(array('privilege.kind' => 'asc'))
									->select();
		if($data['privilegelist'] == false) $data['privilegelist'] = array();
		$data['strlist'] = C('STR_LIST');
		$this->assign($data);
		$this->display();
	}
	public function add_privilege_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(session('?lab_super_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else if(ItemExists(trim(I('param.uid')), 'uid', 'user', false) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
		else
		{
			$uid = trim(I('param.uid'));
			$Privilege = M('privilege');
			$privilegeinfo = $Privilege->where("uid='%s'", $uid)->find();
			if($privilegeinfo == null)
			{
				$privilegeinfo = array(
					'uid' => $uid,
					'privi' => 'lab_admin',
					'kind' => 2
				);
				$Privilege->add($privilegeinfo);
			}
			else
				$data['wrongcode'] = $WRONG_CODE['yes_exist'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	public function del_privilege_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(session('?lab_super_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$id = intval(trim(I('param.id')));
			$Privilege = M('privilege');
			$privilegeinfo = $Privilege->where("id=".$id)->find();
			if($privilegeinfo['uid'] == session('lab_uid'))
				$data['wrongcode'] = $WRONG_CODE['admin_wrongdel'];
			else if($privilegeinfo['privi'] == 'lab_super_admin')
				$data['wrongcode'] = $WRONG_CODE['admin_not'];
			else	
				$Privilege->where("id=".$id)->delete();
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
}