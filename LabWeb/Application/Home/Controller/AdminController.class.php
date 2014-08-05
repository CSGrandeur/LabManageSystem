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
				$userinfo[$useradd_i]['graduate'] = 61;//61为在校。参考ConstVal.php
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
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data = $this->changeinfo_data();
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
			if($userlist[$i]['graduate'] == 61)
				$userlist[$i]['graduate'] = '<a onclick="change_graduate(this)" class="ui tiny blue button change_graduate_button" name="'.$userlist[$i]['uid'].'">在校</a>';
			if($userlist[$i]['graduate'] == 62)
				$userlist[$i]['graduate'] = '<a onclick="change_graduate(this)" class="ui tiny grey button change_graduate_button" name="'.$userlist[$i]['uid'].'">离校</a>';
			$userlist[$i]['name'] = '<a target="_blank" href="/home/admin/changeinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['name'].'</a>';
			$userlist[$i]['supervisor'] = '<a target="_blank" href="/home/user/userinfo?uid='.$userlist[$i]['supervisorid'].'">'.$userlist[$i]['supervisor'].'</a>';
			$userlist[$i]['teacher'] = '<a target="_blank" href="/home/user/userinfo?uid='.$userlist[$i]['teacherid'].'">'.$userlist[$i]['teacher'].'</a>';
			$userlist[$i]['uid'] = '<a target="_blank" href="/home/user/userinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['uid'].'</a>';
		}
		$data['data'] = $userlist;
		$data['draw'] = $d_draw;
		$data['recordsTotal'] = $User->count();
		$data['recordsFiltered'] = count($data['data']);
		
		$this->ajaxReturn($data);
	}
	//修改在校/离校状态
	public function change_graduate_ajax()
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
			$usergraduate = $User->where("uid='%s'", I('param.uid'))->field('graduate')->find();
			if($usergraduate == null)
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			else 
			{
				if($usergraduate['graduate'] == 61)
					$usergraduate['graduate'] = 62;
				else 
					$usergraduate['graduate'] = 61;
				$data['graduate'] = $usergraduate['graduate'];
				if($User->where("uid='%s'", I('param.uid'))->save($usergraduate) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
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
	//添加管理员处理逻辑
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
	//删除管理员处理逻辑
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
	//添加公告
	public function addannouncement()
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
	//添加公告处理逻辑
	public function addannouncement_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(session('?lab_super_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Announcement = M('announcement');
			$announcement_add = array(
				'title' => trim(I('param.title')),
				'content' => trim(I('param.content')),
				'submitter' => session('lab_uid'),
				'mender' => session('lab_uid'),
				'submittime' => date('Y-m-d H:i:s'),
				'updatetime' => date('Y-m-d H:i:s')
			);
			if($Announcement->add($announcement_add) == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//修改公告
	public function editannouncement()
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
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
		{
			$data['wrongcode'] = $WRONG_CODE['not_exist'];
		}
		else
		{
			$Announcement = M('announcement');
			$map = array(
				'id' => intval(I('param.id'))
			);
			$announcementinfo = $Announcement->where($map)->find();
			if($announcementinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
			{
//				$announcementinfo['content'] = htmlspecialchars_decode($announcementinfo['content']);
				$data['announcementinfo'] = $announcementinfo;
			}
				
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	//修改公告处理逻辑
	public function editannouncement_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(session('?lab_super_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Announcement = M('announcement');
			$announcement_update = array(
				'id' => intval(trim(I('param.id'))),
				'title' => trim(I('param.title')),
				'content' => trim(I('param.content')),
				'mender' => session('lab_uid'),
				'updatetime' => date('Y-m-d H:i:s')
			);
			if($Announcement->save($announcement_update) == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//公告列表
	public function announcementlist()
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
	//公告列表数据获取
	public function announcement_list_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
		{
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		}
		else if(!IsAdmin())
		{
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		}
		else 
		{

			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			if($d_length > 100) $d_length = 100;
				
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'id'; break;
				default: $d_ordercol = 'submittime'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'title' => array('like', '%'.$d_searchvalue.'%')
			);
			$Announcement = M('announcement');
			$announcementlist = $Announcement->where($map)
											->order(array($d_ordercol=>$d_orderdir))
											->limit($d_start, $d_length)
											->select();
			
			if($announcementlist == false) $announcementlist = array();
			for($i = 0; $i < count($announcementlist); $i ++)
			{
				if(strlen($announcementlist[$i]['title']) == 0)
					$announcementlist[$i]['title'] = "#";
				if($announcementlist[$i]['available'] == 0)
					$announcementlist[$i]['available'] = '<a onclick="change_available(this)" class="ui tiny grey button" name="'.$announcementlist[$i]['id'].'">隐藏=>显示</a>';
				else
					$announcementlist[$i]['available'] = '<a onclick="change_available(this)" class="ui tiny blue button" name="'.$announcementlist[$i]['id'].'">显示=>隐藏</a>';
				$announcementlist[$i]['title'] = '<div class="limit_header limit_width_550"><a href="/home/admin/editannouncement?id='.$announcementlist[$i]['id'].'">'.$announcementlist[$i]['title'].'</a></div>';
				$announcementlist[$i]['id'] = '<a target="_blank" href="/home/index/news?id='.$announcementlist[$i]['id'].'">'.$announcementlist[$i]['id'].'</a>';
									
			}
			$data['data'] = $announcementlist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $Announcement->count();
			$data['recordsFiltered'] = $Announcement->where($map)->count();
		}
		
		$this->ajaxReturn($data);
	}
	//公告显示状态修改
	public function change_announcementavailable_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Announcement = M('announcement');
			$map = array(
				'id' => intval(I('param.id'))
			);
			$announcement_available = $Announcement->where($map)->field('available')->find();
			if($announcement_available == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else
			{
				if($announcement_available['available'] == 0)
					$announcement_available['available'] = 1;
				else
					$announcement_available['available'] = 0;
				$data['available'] = $announcement_available['available'];
				if($Announcement->where($map)->save($announcement_available) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//打印纸配额列表
	public function paperstate()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$data['month'] = date('Y-m');
		$this->assign($data);
		$this->display();
	}
	//打印纸状况表格数据
	public function paperstate_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
	
		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			$d_month = date("Y-m-1", strtotime(trim($reqdata['month'])));
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'uid'; break;
				case 1: $d_ordercol = 'name'; break;
				case 2: $d_ordercol = 'sex'; break;
				case 3: $d_ordercol = 'grade'; break;
				case 4: $d_ordercol = 'degree'; break;
				case 5: $d_ordercol = 'papersum'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
				'user.uid' => array('like', '%'.$d_searchvalue.'%'),
				'user.name' => array('like', '%'.$d_searchvalue.'%'),
 				'userdetail.grade' => array('like', '%'.$d_searchvalue.'%'),
				'_logic' => 'or'
			);
// 			$map = array(
// 				'_complex' => $map,
// 				'printcount.month' => $d_month,
// 				'printaddition.month' => $d_month,
// 			);
			$User = M('user');
			$paperstatelist = $User->table('lab_user user')
								->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
								->join('LEFT JOIN lab_printcount printcount ON printcount.uid = user.uid AND printcount.month = \''.$d_month.'\'')
								->join('LEFT JOIN lab_printarrange printarrange ON printarrange.uid = user.uid')
								->join('LEFT JOIN lab_printaddition printaddition ON printaddition.uid = user.uid AND printaddition.month = \''.$d_month.'\'')
								->field('
										user.uid uid,
										user.name name,
										userdetail.sex sex,
										userdetail.degree degree,
										userdetail.grade grade,
										printcount.papersum papersum,
										printarrange.paperlimit paperlimit,
										SUM(printaddition.addnum) addnum
										')
								->where($map)
								->order(array($d_ordercol=>$d_orderdir))
								->limit($d_start, $d_length)
								->select();

			if(count($paperstatelist) > 0 && $paperstatelist[0]['uid'] != null)
			{
				for($i = count($paperstatelist) - 1; $i >= 0; $i --)
				{
					$paperstatelist[$i]['paperlimit'] = 
						($paperstatelist[$i]['paperlimit'] ? $paperstatelist[$i]['paperlimit'] : C('PAPER_LIMIT')) + 
						($paperstatelist[$i]['addnum'] ? $paperstatelist[$i]['addnum'] : 0);
					$paperstatelist[$i]['papersum'] = $paperstatelist[$i]['papersum'] ? $paperstatelist[$i]['papersum'] : 0;
					$paperstatelist[$i]['sex'] = $STR_LIST[$paperstatelist[$i]['sex']];
					$paperstatelist[$i]['degree'] = $STR_LIST[$paperstatelist[$i]['degree']];
					$paperstatelist[$i]['paperlimit'] = '
														<a target="_blank" href="/home/admin/managepaper?uid='.$paperstatelist[$i]['uid'].'">
															<button id="addprivilege_submit" class="ui blue labeled icon button">
																<i class="setting icon"></i>'.$paperstatelist[$i]['paperlimit'].'
															</button>
														</a>
														';
				}
			}
			else 
				$paperstatelist = false;
			$data['data'] = $paperstatelist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $User->count();
			$data['recordsFiltered'] = $User->table('lab_user user')
											->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
											->join('LEFT JOIN lab_printcount printcount ON printcount.uid = user.uid')
											->join('LEFT JOIN lab_printarrange printarrange ON printarrange.uid = user.uid')
											->join('LEFT JOIN lab_printaddition printaddition ON printaddition.uid = user.uid')
											->where($map)
											->count();
			
		}
		$this->ajaxReturn($data);
	}
	//打印纸配额操作页
	public function managepaper()
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
		
		if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$uid = trim(I('param.uid'));
			$User = M('user');
			$singleuser = $User->table('lab_user user')
								->join('LEFT JOIN lab_printarrange printarrange ON printarrange.uid = user.uid')
								->field('
										user.uid uid,
										user.name name,
										printarrange.paperlimit paperlimit
										')
								->where("user.uid='%s'", $uid)
								->find();
			if($singleuser == null)
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			else 
			{
				if($singleuser['paperlimit'] == null)
					$singleuser['paperlimit'] = C('PAPER_LIMIT');
				$Printaddition = M('printaddition');
				$map = array(
					'uid' => $uid,
					'month' => date("Y-m-1")
				);
				$paperaddition = $Printaddition->where($map)->field('id, addnum, available')->order(array('id'=>'desc'))->select();
			}
			$data['singleuser'] = $singleuser;
			$data['paperaddition'] = $paperaddition;
			$data['month'] = date("Y-m");
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	//增加打印纸配额逻辑处理
	public function paperadd_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.month', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else if(intval(trim(I('param.addnum'))) <= 0)
			$data['wrongcode'] = $WRONG_CODE['num_toosmall'];
		else
		{
			$Printaddition = M('printaddition');
			$paper_add = array(
				'uid' => trim(I('param.uid')),
				'addnum' => intval(trim(I('param.addnum'))),
				'month' => date("Y-m-1", strtotime(trim(I('param.month'))))
			);
			if($Printaddition->add($paper_add) == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//改变增加的打印纸配额有效性
	public function change_paperadd_available_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Printaddition = M('printaddition');
			$paperaddinfo = $Printaddition->where('id='.intval(I('param.id')))->find();
			if($paperaddinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else
			{
				$paperaddinfo['available'] = !$paperaddinfo['available'];
				$data['available'] = $paperaddinfo['available'];
				if($Printaddition->save($paperaddinfo) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//改变固定打印纸月配额
	public function change_paperlimit_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(session('?lab_admin') == null)
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.paperlimit', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else if(intval(trim(I('param.paperlimit'))) <= 0)
			$data['wrongcode'] = $WRONG_CODE['num_toosmall'];
		else
		{
			$uid = trim(I('param.uid'));
			$paperlimit = intval(trim(I('param.paperlimit')));
			$Printarrange = M('printarrange');
			$paperlimitinfo = $Printarrange->where("uid='%s'", $uid)->find();
			$flag = true;
			if($paperlimitinfo == null)
			{
				$flag = false;
				$paperlimitinfo = array(
					'uid' => $uid
				);
			}
			$paperlimitinfo['paperlimit'] = $paperlimit;
			if($flag)
			{
				if($Printarrange->save($paperlimitinfo) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_notupdate'];
			}
			else 
			{
				if($Printarrange->add($paperlimitinfo) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//统计信息表
	public function statisticlist()
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
	//统计信息表json数据
	public function statisticlist_ajax()
	{
	
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else if(!IsAdmin())
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else
		{
			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'id'; break;
				case 1: $d_ordercol = 'title'; break;
				case 2: $d_ordercol = 'name'; break;
				case 3: $d_ordercol = 'submittime'; break;
				case 4: $d_ordercol = 'starttime'; break;
				case 5: $d_ordercol = 'endtime'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'statistic.title' => array('like', '%'.$d_searchvalue.'%'),
					'user.name' => array('like', '%'.$d_searchvalue.'%'),
					'_logic' => 'or'
			);
			$Statistic = M('statistic');
				
			$statisticlist = $Statistic->table('lab_statistic statistic')
									->join('LEFT JOIN lab_user user ON user.uid = statistic.submitter')
									->field('
											user.uid uid,
											user.name name,
											statistic.id id,
											statistic.title title,
											statistic.submittime submittime,
											statistic.starttime starttime,
											statistic.endtime endtime,
											statistic.available available
											')
									->where($map)
									->order(array($d_ordercol=>$d_orderdir))
									->limit($d_start, $d_length)
									->select();
			if($statisticlist != null && $statisticlist[0]['id'] != null)
			{
				for($i = count($statisticlist) - 1; $i >= 0; $i --)
				{
					if(strlen($statisticlist[$i]['title']) == 0)
						$statisticlist[$i]['title'] = "#";
					if($statisticlist[$i]['available'] == 0)
						$statisticlist[$i]['available'] = '<a onclick="change_statistic_available(this)" class="ui tiny grey button" name="'.$statisticlist[$i]['id'].'">隐藏=>显示</a>';
					else
						$statisticlist[$i]['available'] = '<a onclick="change_statistic_available(this)" class="ui tiny blue button" name="'.$statisticlist[$i]['id'].'">显示=>隐藏</a>';
					$statisticlist[$i]['title'] = '<div class="limit_header"><a target="_blank" href="/home/admin/editstatistic?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['title'].'</a></div>';
					$statisticlist[$i]['id'] = '<a target="_blank" href="/home/work/statistic_res?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['id'].'</a>';
					
					$statisticlist[$i]['name'] = '<a data-pjax href="/home/user/userinfo?uid='.$statisticlist[$i]['uid'].'">'.$statisticlist[$i]['name'].'</a>';
				}
			}
			else
				$statisticlist = false;
			$data['data'] = $statisticlist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $Statistic->count();
			$data['recordsFiltered'] = $Statistic->table('lab_statistic statistic')
			->join('LEFT JOIN lab_user user ON user.uid = statistic.submitter')
			->where($map)
			->count();
		
		}
	
		$this->ajaxReturn($data);
	}
	//更改statistic显示/隐藏状态
	public function change_statistic_available_ajax()
	{

		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		if(!IsAdmin())
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Statistic = M('statistic');
			$map = array(
				'id' => intval(I('param.id'))
			);
			$statistic_available = $Statistic->where($map)->field('available')->find();
			if($statistic_available == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else
			{
				if($statistic_available['available'] == 0)
					$statistic_available['available'] = 1;
				else
					$statistic_available['available'] = 0;
				$data['available'] = $statistic_available['available'];
				if($Statistic->where($map)->save($statistic_available) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//添加信息统计
	public function addstatistic()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['nowtime'] = date('Y-m-d\TH:i:s');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$this->assign($data);
		$this->display();
	}
	//添加信息统计逻辑处理
	public function addstatistic_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsAdmin())
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.statistic_title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Statistic = M('statistic');
			//防止误操作，避免10秒内操作两次
			$map = array(
				'submittime' => array('egt', date('Y-m-d H:i:s',strtotime('-10 second'))),
				'submitter' => session('lab_uid')
			);
			if($Statistic->where($map)->find() != null)
				$data['wrongcode'] = $WRONG_CODE['too_frequently'];
			else 
			{
				$reqdata = I('param.');
				$addstatistictext = $reqdata['statistic_items'];
				$addstatisticlist = preg_split("/[\\r\\n]{1,2}/", $addstatistictext);
				$statistic_add = array(
					'title' => trim($reqdata['statistic_title']),
					'des' => trim($reqdata['content']),
					'items' => json_encode($addstatisticlist),
					'submitter' => session('lab_uid'),
					'submittime' => date('Y-m-d H:i:s'),
					'starttime' => date('Y-m-d H:i:s', strtotime(trim($reqdata['statistic_starttime']))),
					'endtime' => date('Y-m-d H:i:s', strtotime(trim($reqdata['statistic_endtime']))),
					'allow_anonymous' => $reqdata['allow_anonymous'] == 'on'
				);
				if($Statistic->add($statistic_add) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//编辑信息统计
	public function editstatistic()
	{
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		if(!IsAdmin())
		{
			$this->display('Admin:notadmin');
			return;
		}
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['nowtime'] = date('Y-m-d\TH:i:s');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Statistic = M('statistic');
			$statisticinfo = $Statistic->where('id='.intval(trim(I('param.id'))))->find();
			if($statisticinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
			{
				$statisticinfo['starttime'] = date('Y-m-d\TH:i:s', strtotime($statisticinfo['starttime']));
				$statisticinfo['endtime'] = date('Y-m-d\TH:i:s', strtotime($statisticinfo['endtime']));
			}
			if($statisticinfo['submitter'] != session('lab_uid') && !session('lab_super_admin'))//不是提交者也不是超级管理员
				$data['wrongcode'] = $WRONG_CODE['admin_powerless'];
				
			$data['statisticinfo'] = $statisticinfo;
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	//添加信息统计逻辑处理
	public function editstatistic_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsAdmin())
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.statistic_title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Statistic = M('statistic');
			$reqdata = I('param.');
			$statistic_update = array(
				'id' => intval(trim($reqdata['id'])),
				'title' => trim($reqdata['statistic_title']),
				'des' => trim($reqdata['content']),
				'submittime' => date('Y-m-d H:i:s'),
				'starttime' => date('Y-m-d H:i:s', strtotime(trim($reqdata['statistic_starttime']))),
				'endtime' => date('Y-m-d H:i:s', strtotime(trim($reqdata['statistic_endtime']))),
				'allow_anonymous' => $reqdata['allow_anonymous'] == 'on' ? 1 : 0
			);
			if($Statistic->save($statistic_update) == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//删除已统计的单个条目
	public function del_statisticdo_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsAdmin())
			$data['wrongcode'] = $WRONG_CODE['admin_not'];
		else if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Statisticdo = M('statisticdo');
			$map = array(
				'id' => intval(trim(I('param.id')))
			);
			if($Statisticdo->where($map)->delete() == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
			else
				$data['wrongcode'] = $WRONG_CODE['del_successful'];
				
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
}