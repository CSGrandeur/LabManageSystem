<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
	public function index()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		
		
		
		$this->display();
	}

	public function adduser()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
	
	
	
		$this->display();
	}
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
    	return $data;
    }
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
    public function changeinfo_ajax()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data = $this->changeinfo_data();
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
    	if(session('?lab_admin') == null)
    		$data['wrongcode'] = $WRONG_CODE['admin_not'];
    	else if(I('param.uid', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
    		$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
    	else
    	{
    		$User = M('user');
    		$param = I('param.');
    		$userinfo = $User->where('uid='.$param['uid'])->find();
    		if($userinfo == null)
    			$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
    		else
    		{
    			$Userdetail = M('userdetail');
    			$userdetail = $Userdetail->where('uid='.$param['uid'])->find();
    			$flag = true;
    			if($userdetail == null)
    			{
    				$flag = false;
    				$userdetail['uid'] = trim($param['uid']);
    				$userdetail = array();
    			}
    			$userdetail['name'] = trim($param['name']);
    			$userdetail['sex'] = trim($param['sex']);
    			$userdetail['degree'] = trim($param['degree']);
    			$userdetail['institute'] = trim($param['institute']);
    			$userdetail['major'] = trim($param['major']);
    			$userdetail['grade'] = trim($param['grade']);
    			$userdetail['birthday'] = trim($param['birthday']);
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
    			$res;
    			if($flag) $res = $Userdetail->save($userdetail);
    			else $res = $Userdetail->add($userdetail);
    			if($res == false) $data['wrongcode'] = $WRONG_CODE['sql_error'];
    		}	
    	}
        
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
        $this->ajaxReturn($data);
    }
	public function manageuser()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsPjax()) layout('Layout/adminlayout');//判断pjax确定是否加载layout
		$this->display();
	}
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
				'userdetail.sex' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.phone' => array('like', '%'.$d_searchvalue.'%'),
				'userdetail.email' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.degree' => array('like', '%'.$d_searchvalue.'%'),
// 				'userdetail.grade' => array('like', '%'.$d_searchvalue.'%'),
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
			file_put_contents("loog.txt",print_r(I('post.'),true));
			$fp = fopen("loog.txt", "a+");
			fwrite ($fp, $User->_sql());
			fwrite ($fp, "\n");
			fclose($fp);
		$data['draw'] = $d_draw;
		$data['recordsTotal'] = $User->count();
		$data['recordsFiltered'] = count($data['data']);
		
		$this->ajaxReturn($data);
	}
}