<?php
namespace Home\Controller;
use Think\Controller;
class CheckinginController extends Controller {
	private function receive_return()
	{//返回返回值暂不确定具体意思。客户端目前不需要返回值
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		 
		if(I('param.info', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			$info = base64_json_decode(I('param.info'));//函数在Common/function.php中
			if(array_key_exists("onlyname", $info))
			{
				$Name2onlyname = M('name2onlyname');
				$map = array(
					'onlyname' => $info['onlyname']
				);
				$name2onlynameinfo = $Name2onlyname->where($map)->find();
				if($name2onlynameinfo != null)
				{
					if($name2onlynameinfo['uid'] != null && $name2onlynameinfo['uid'] != '#')
					//已登记用户名，则插入本条计算机数据
					{
						$checkingin_add = array(
							'uid' => $name2onlynameinfo['uid'],
							'cpuload' => $info['cpuload'],
							'memload' => $info['memload'],
							'mousebutton0' => $info['mousebutton0'],
							'mousebutton1' => $info['mousebutton1'],
							'mousemove' => $info['mousemove'],
							'keybutton' => $info['keybutton'],
							'upload' => $info['upload'],
							'download' => $info['download'],
							'appprocessnum' => $info['appprocessnum'],
							'processnum' => $info['processnum'],
							'receivetime' => date('Y-m-d H:i:s')
						);
						$Checkingin = M('checkingin');
						$Checkingin->add($checkingin_add);
						return 1;
					}
					else return 5;
				}
				else 
				{
					$name2onlyname_add = array(
						'onlyname' => $info['onlyname'],
						'clientIP' => get_client_ip()//ThinkPHP获取客户端IP的方法
					);
					$Name2onlyname->add($name2onlyname_add);
					return 2;
					
				}
			}
			return 3;
		}
		return 4;
	}
	public function receive()
	{
		echo $this->receive_return();
	}
	//具体某台计算机运行状况
	public function pcinfo()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('lab_uid'))
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		else if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$uid = trim(I('param.uid'));
			if(ItemExists($uid, 'uid', 'name2onlyname', false) == $WRONG_CODE['not_exist'])
			{
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			}
			else 
			{
				$userinfo = GetUserinfo($uid);
				if($userinfo == null)
					$data['wrongcode'] = $WRONG_CODE['not_exist'];
				else 
					$data['userinfo'] = $userinfo;
			}
			$data['uid'] = $uid;
		}
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
	}
    public function display_charts_ajax()
    {
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('lab_uid'))
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		else if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$type = trim(I('param.type'));
			$uid = trim(I('param.uid'));
			$Checkingin = M('checkingin');
			if($type == 'all')
			{
				$dtend = date('Y-m-d H:i:s');
				$dtstart = date('Y-m-d H:i:s', strtotime('-120 minute'));
				$Checkingin = M('checkingin');
				$map = array(
					'uid' => $uid,
					'receivetime' => array('egt', $dtstart)
				);
				$rows = $Checkingin->where($map)->order(array('id' => 'asc'))->select();
			}
			else
			{
				$map = array(
					'uid' => $uid,
					'receivetime' => array('egt', date('Y-m-d H:i:s', strtotime('-2 minute')))
				);
				$rows = $Checkingin->where($map)
								->order(array('id' => desc))
								->find();
	file_put_contents("loog.txt", print_r($Checkingin->_sql(), true));
			}
			$data['data'] = $rows;
		}
		$this->ajaxReturn($data);
    }
    //成员列表
    public function pcinfolist()
    {
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('?lab_uid'))
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
    }
    public function pcinfolist_ajax()
    {
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('?lab_uid'))
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		else if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = mysql_real_escape_string(intval($reqdata['start']));
			$d_length = mysql_real_escape_string(intval($reqdata['length']));
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'uid'; break;
				case 1: $d_ordercol = 'name'; break;
				case 2: $d_ordercol = 'kind'; break;
				case 3: $d_ordercol = 'cpuload'; break;
				case 4: $d_ordercol = 'mousemove'; break;
				case 5: $d_ordercol = 'keybutton'; break;
			}
			$d_ordercol = mysql_real_escape_string($d_ordercol);
			$d_orderdir = mysql_real_escape_string($reqdata['order'][0]['dir']);
			$d_searchvalue = mysql_real_escape_string($reqdata['search']['value']);
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'user.uid' => array('like', '%'.$d_searchvalue.'%'),
					'user.name' => array('like', '%'.$d_searchvalue.'%'),
					'_logic' => 'or'
			);
			$map = array(
				'_complex' => $map,
    			'user.graduate' => 61,//只查看在校的
			);
			$User = M('user');
					
			$userlist = $User->query("
									SELECT user.uid uid, user.name name, user.kind kind, checkingin.cpuload cpuload, checkingin.mousemove mousemove, checkingin.keybutton keybutton
									FROM `lab_user` AS user
									LEFT JOIN (SELECT `uid` AS checkinginuid, `cpuload`, `mousemove`, `keybutton` FROM `lab_checkingin` WHERE `receivetime` >  '".date("Y-m-d H:i:s",strtotime("-20 minute"))."' ORDER BY `receivetime` desc) AS checkingin ON user.uid=checkingin.checkinginuid
									WHERE (user.uid LIKE '%".$d_searchvalue."%' OR user.name LIKE '%".$d_searchvalue."%' ) AND user.graduate = 61 
									GROUP BY user.uid
									ORDER BY `".$d_ordercol."` ".$d_orderdir."
									LIMIT ".$d_start.",".$d_length."
									");
			if($userlist != null && $userlist[0]['uid'] != null)
			{
				for($i = count($userlist) - 1; $i >= 0; $i --)
				{
					$userlist[$i]['kind'] = $STR_LIST[$userlist[$i]['kind']];
					$userlist[$i]['name'] = '<a data-pjax href="/home/checkingin/pcinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['name'].'</a>';
					$userlist[$i]['uid'] = '<a data-pjax href="/home/user/userinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['uid'].'</a>';
				}
			}
			else
				$userlist = false;
			$data['data'] = $userlist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $User->count();
			$data['recordsFiltered'] = count($User->query("
														SELECT user.uid uid, user.name name, user.kind kind, checkingin.cpuload cpuload, checkingin.mousemove mousemove, checkingin.keybutton keybutton
														FROM `lab_user` AS user
														LEFT JOIN (SELECT `uid` AS checkinginuid, `cpuload`, `mousemove`, `keybutton` FROM `lab_checkingin` WHERE `receivetime` >  '".date("Y-m-d H:i:s",strtotime("-20 minute"))."' ORDER BY `receivetime` desc) AS checkingin ON user.uid=checkingin.checkinginuid
														WHERE (user.uid LIKE '%".$d_searchvalue."%' OR user.name LIKE '%".$d_searchvalue."%' ) AND user.graduate = 61 
														"));
		}
		
		$this->ajaxReturn($data);
	}
}