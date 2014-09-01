<?php
namespace Home\Controller;
use Think\Controller;
class WorkController extends Controller {
	public function statistic()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$this->assign($data);
		$this->display();
	}
	public function statistic_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
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
				case 3: $d_ordercol = 'starttime'; break;
				case 4: $d_ordercol = 'endtime'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'statistic.title' => array('like', '%'.$d_searchvalue.'%'),
					'user.name' => array('like', '%'.$d_searchvalue.'%'),
					'_logic' => 'or'
			);
			$map = array(
				'_complex' => $map,
    			'statistic.available' => array('neq', 0)
			);
			$Statistic = M('statistic');
					
			$statisticlist = $Statistic->table('lab_statistic statistic')
									->join('LEFT JOIN lab_user user ON user.uid = statistic.submitter')
									->field('
											user.uid uid,
											user.name name,
											statistic.id id,
											statistic.title title,
											statistic.starttime starttime,
											statistic.endtime endtime
											')
									->where($map)
									->order(array($d_ordercol=>$d_orderdir))
									->limit($d_start, $d_length)
									->select();
			$nowtime = time();
			if($statisticlist != null && $statisticlist[0]['uid'] != null)
			{
				for($i = count($statisticlist) - 1; $i >= 0; $i --)
				{
					if(strlen($statisticlist[$i]['title']) == 0) $statisticlist[$i]['title'] = '#';
					$statisticlist[$i]['name'] = '<a data-pjax href="/home/user/userinfo?uid='.$statisticlist[$i]['uid'].'">'.$statisticlist[$i]['name'].'</a>';
					$statisticlist[$i]['title'] = '<a data-pjax href="/home/work/statisticdo?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['title'].'</a>';
					$starttime = strtotime($statisticlist[$i]['starttime']);
					$endtime= strtotime($statisticlist[$i]['endtime']);
					$statisticlist[$i]['status'] = '<a data-pjax href="/home/work/statisticdo?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['title'].'</a>';
					if($nowtime < $starttime)
						$statisticlist[$i]['status'] = '<a data-pjax href="#" class="ui tiny red button">尚未开始</a>';
					else if($nowtime > $endtime)
						$statisticlist[$i]['status'] = '<a data-pjax href="/home/work/statistic_res?id='.$statisticlist[$i]['id'].'" class="ui tiny grey button">已经结束</a>';
					else
						$statisticlist[$i]['status'] = '<a data-pjax href="/home/work/statistic_res?id='.$statisticlist[$i]['id'].'" class="ui tiny green button">正在进行</a>';
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
	//填表页面
	public function statisticdo()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$id = intval(trim(I('param.id')));
			$map = array(
    			'statistic.id' => $id
			);
			$Statistic = M('statistic');
			$statisticinfo = $Statistic->table('lab_statistic statistic')
									->join('LEFT JOIN lab_user user ON user.uid = statistic.submitter')
									->field('
											user.uid uid,
											user.name name,
											statistic.id id,
											statistic.title title,
											statistic.des des,
											statistic.items items,
											statistic.available available,
											statistic.starttime starttime,
											statistic.endtime endtime,
											statistic.allow_anonymous allow_anonymous
											')
									->where($map)
									->find();
			if($statisticinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
			{
				$nowtime = time();					
				$starttime = strtotime($statisticinfo['starttime']);
				$endtime= strtotime($statisticinfo['endtime']);
				if($statisticinfo['allow_anonymous'] == 0 && !session('?lab_uid')
					|| $statisticinfo['available'] == 0 && !IsAdmin())
					$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				else if($nowtime < $starttime && !IsAdmin())
					$data['wrongcode'] = $WRONG_CODE['too_early'];
				else if($nowtime > $endtime && !IsAdmin())
					$data['wrongcode'] = $WRONG_CODE['too_late'];
				else 
				{
					$data['statisticinfo'] = $statisticinfo;
					$data['items'] = json_decode($statisticinfo['items'], true);
					if($statisticinfo['allow_anonymous'] == 0)//如果仅允许登录用户填写，则获取已填写的信息
					{
						$map = array(
							'uid' => session('lab_uid'),
							'statisticid' => $id
						);
						$Statisticdo = M('statisticdo');
						$statisticdoinfo = $Statisticdo->where($map)->find();
						$data['statisticdoinfo'] = $statisticdoinfo;
						$data['doitems'] = json_decode($statisticdoinfo['items'], true);
					}
				}
			}
		}
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
	}
	//填表信息逻辑处理
	public function statisticdo_ajax()
	{

		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$reqdata = I('param.');
			$id = intval(trim($reqdata['id']));
			
			$Statistic = M('statistic');
			$statisticinfo = $Statistic->where('id='.$id)->field('id, starttime, endtime, available, allow_anonymous')->find();
			$nowtime = time();
			$starttime = strtotime($statisticinfo['starttime']);
			$endtime= strtotime($statisticinfo['endtime']);
			if($statisticinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else if($statisticinfo['allow_anonymous'] == 0 && !session('?lab_uid')
					|| $statisticinfo['available'] == 0 && !IsAdmin())
					$data['wrongcode'] = $WRONG_CODE['user_powerless'];
			else if($nowtime < $starttime && !IsAdmin())
				$data['wrongcode'] = $WRONG_CODE['too_early'];
			else if($nowtime > $endtime && !IsAdmin())
				$data['wrongcode'] = $WRONG_CODE['too_late'];
			else 
			{	
				$Statisticdo = M('statisticdo');
				$addstatisticdolist = $reqdata['item_input'];
				$statisticdo_add = array(
					'statisticid' => $id,
					'uid' => session('lab_uid'),
					'items' => json_encode($addstatisticdolist)
				);
				$map = array(
					'statisticid' => $id,
					'uid' => session('lab_uid')
				);
				if($statisticinfo['allow_anonymous'] == 0 && $Statisticdo->where($map)->find() != null)//不允许匿名提交，则可能要update
				{
					if($Statisticdo->where($map)->save($statisticdo_add) == false)
						$data['wrongcode'] = $WRONG_CODE['sql_notupdate'];
					else 
						$data['wrongcode'] = $WRONG_CODE['update_successful'];
				}
				else 
				{
					if($Statisticdo->add($statisticdo_add) == false)
						$data['wrongcode'] = $WRONG_CODE['sql_error'];
					else
						$data['wrongcode'] = $WRONG_CODE['add_successful'];
				}
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//填表信息结果查询
	public function statistic_res()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$id = intval(trim(I('param.id')));
			$map = array(
    			'statistic.id' => $id
			);
			$Statistic = M('statistic');
			$statisticinfo = $Statistic->table('lab_statistic statistic')
									->join('LEFT JOIN lab_user user ON user.uid = statistic.submitter')
									->field('
											user.uid uid,
											user.name name,
											statistic.id id,
											statistic.title title,
											statistic.des des,
											statistic.items items,
											statistic.available available,
											statistic.starttime starttime,
											statistic.endtime endtime,
											statistic.allow_anonymous allow_anonymous
											')
									->where($map)
									->find();
			if($statisticinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
			{
				$nowtime = time();					
				$starttime = strtotime($statisticinfo['starttime']);
				$endtime= strtotime($statisticinfo['endtime']);
				if($statisticinfo['allow_anonymous'] == 0 && !session('?lab_uid')
					|| $statisticinfo['available'] == 0 && !IsAdmin())
					$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				else 
				{
					$data['statisticinfo'] = $statisticinfo;
					$data['items'] = json_decode($statisticinfo['items'], true);
					$map = array(
						'statisticdo.statisticid' => $id
					);
					$Statisticdo = M('statisticdo');
					$statisticdolist = $Statisticdo->table('lab_statisticdo statisticdo')
									->join('LEFT JOIN lab_user user ON user.uid = statisticdo.uid')
									->where($map)
									->field('
											user.uid uid,
											user.name name,
											statisticdo.id id,
											statisticdo.items items
											')
									->select();
					for($i = count($statisticdolist) - 1; $i >= 0; $i --)
					{
						$statisticdolist[$i]['items'] = json_decode($statisticdolist[$i]['items'], true);
						if($statisticdolist[$i]['name'] == null)
							$statisticdolist[$i]['name'] = "匿名";
						else
							$statisticdolist[$i]['name'] = '<a target="_blank" href="/home/user/userinfo?uid='.$statisticdolist[$i]['uid'].'">'.$statisticdolist[$i]['name'].'</a>';
					}
					$data['statisticdolist'] = $statisticdolist;
				}
			}
		}
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
	}
	//查看报告时间和数量的用户列表
	public function reports()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(session('?lab_uid'))
		{
			$data['uid'] = session('lab_uid');
			$data['loggedin'] = true;
		}
		else
			$data['loggedin'] = false;
		$this->assign($data);
		$this->display();
	}
	public function reports_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
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
				case 3: $d_ordercol = 'latest'; break;
				case 4: $d_ordercol = 'twoweek'; break;
				case 5: $d_ordercol = 'onemonth'; break;
			}
			$d_ordercol = mysql_real_escape_string($d_ordercol);
			$d_orderdir = mysql_real_escape_string($reqdata['order'][0]['dir']);
			$d_searchvalue = mysql_real_escape_string($reqdata['search']['value']);
			$d_searchregex = $reqdata['search']['regex'];
			$User = M('user');
					
			$userlist = $User->query("
									SELECT user.uid uid,user.name name,user.kind kind, latesttable.latest latest, twoweektable.twoweek twoweek, onmonthtable.onemonth onemonth 
									FROM `lab_user` AS user
									LEFT JOIN (SELECT MAX(`submittime`) AS latest, `uid` AS latestuid FROM `lab_report` GROUP BY `uid`) AS latesttable ON user.uid=latestuid
									LEFT JOIN (SELECT COUNT(*) AS twoweek, `uid` AS twoweekuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-2 week"))."' GROUP BY `uid`) AS twoweektable ON user.uid=twoweekuid
									LEFT JOIN (SELECT COUNT(*) AS onemonth, `uid` AS onemonthuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-1 month"))."' GROUP BY `uid`) AS onmonthtable ON user.uid=onemonthuid
									WHERE (  user.uid LIKE '%".$d_searchvalue."%' OR user.name LIKE '%".$d_searchvalue."%' ) AND user.graduate = 61 
									ORDER BY `".$d_ordercol."` ".$d_orderdir."
									LIMIT ".$d_start.",".$d_length."
									");
		file_put_contents("/var/www/loog.txt", print_r("
									SELECT user.uid uid,user.name name,user.kind kind, latesttable.latest latest, twoweektable.twoweek twoweek, onmonthtable.onemonth onemonth 
									FROM `lab_user` AS user
									LEFT JOIN (SELECT MAX(`submittime`) AS latest, `uid` AS latestuid FROM `lab_report` GROUP BY `uid`) AS latesttable ON user.uid=latestuid
									LEFT JOIN (SELECT COUNT(*) AS twoweek, `uid` AS twoweekuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-2 week"))."' GROUP BY `uid`) AS twoweektable ON user.uid=twoweekuid
									LEFT JOIN (SELECT COUNT(*) AS onemonth, `uid` AS onemonthuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-1 month"))."' GROUP BY `uid`) AS onmonthtable ON user.uid=onemonthuid
									WHERE (  user.uid LIKE '%".$d_searchvalue."%' OR user.name LIKE '%".$d_searchvalue."%' ) AND user.graduate = 61 
									ORDER BY `".$d_ordercol."` ".$d_orderdir."
									LIMIT ".$d_start.",".$d_length."
									", true)."\n", FILE_APPEND);
		file_put_contents("/var/www/loog.txt", print_r($User->_sql(), true)."\n", FILE_APPEND);
			if($userlist != null && $userlist[0]['uid'] != null)
			{
				for($i = count($userlist) - 1; $i >= 0; $i --)
				{
					$userlist[$i]['name'] = '<a data-pjax href="/home/work/reportlist?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['name'].'</a>';
					$userlist[$i]['uid'] = '<a data-pjax href="/home/user/userinfo?uid='.$userlist[$i]['uid'].'">'.$userlist[$i]['uid'].'</a>';
					$userlist[$i]['kind'] = $STR_LIST[$userlist[$i]['kind']];
					if($userlist[$i]['twoweek'] > 0) 
						$userlist[$i]['twoweek'] = '<a class="ui red circular label">'.$userlist[$i]['twoweek'].'</a>';
					else
						$userlist[$i]['twoweek'] = 0;
					if($userlist[$i]['onemonth'] > 0) 
						$userlist[$i]['onemonth'] = '<a class="ui red circular label">'.$userlist[$i]['onemonth'].'</a>';
					else
						$userlist[$i]['onemonth'] = 0;;
				}
			}
			else
				$userlist = false;
			$data['data'] = $userlist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $User->count();
			$data['recordsFiltered'] = count($User->query("
											SELECT user.uid uid,user.name name,user.kind kind, latesttable.latest latest, twoweektable.twoweek twoweek, onmonthtable.onemonth onemonth 
											FROM `lab_user` AS user
											LEFT JOIN (SELECT MAX(`submittime`) AS latest, `uid` AS latestuid FROM `lab_report` GROUP BY `uid`) AS latesttable ON user.uid=latestuid
											LEFT JOIN (SELECT COUNT(*) AS twoweek, `uid` AS twoweekuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-2 week"))."' GROUP BY `uid`) AS twoweektable ON user.uid=twoweekuid
											LEFT JOIN (SELECT COUNT(*) AS onemonth, `uid` AS onemonthuid FROM `lab_report` WHERE `submittime` > '".date("Y-m-d H:i:s",strtotime("-1 month"))."' GROUP BY `uid`) AS onmonthtable ON user.uid=onemonthuid
											WHERE (  user.uid LIKE '%".$d_searchvalue."%' OR user.name LIKE '%".$d_searchvalue."%' ) AND user.graduate = 61
											"));	
		}
		
		$this->ajaxReturn($data);
	}
	

	//某用户的报告列表
	public function reportlist()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		$data['uid'] = trim(I('param.uid'));
		if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else 
		{
			$uid = trim(I('param.uid'));
			$userinfo = GetUserinfo($uid);
			if($userinfo == null)
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
			else 
				$data['userinfo'] = $userinfo;
			$data['user_self'] = session('lab_uid') == $uid;
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	public function reportlist_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$reqdata = I('param.');
			$uid = trim($reqdata['uid']);
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'id'; break;
				case 1: $d_ordercol = 'kind'; break;
				case 2: $d_ordercol = 'title'; break;
				case 3: $d_ordercol = 'submittime'; break;
				case 4: $d_ordercol = 'updatetime'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
				'title' => array('like', '%'.$d_searchvalue.'%'),
				'uid' => $uid
			);
			if(session('lab_uid') != $uid && !IsAdmin())//不是管理员，也不是用户本人，则不现实用户自己隐藏的报告
			{
				$map = array(
					'_complex' => $map,
					'available' => array('neq', 0)
				);
			}
			$Report = M('report');
			$reportlist = $Report->where($map)
								->order(array($d_ordercol=>$d_orderdir))
								->limit($d_start, $d_length)
								->select();
			if($reportlist != null && $reportlist[0]['id'] != null)
			{
				for($i = count($reportlist) - 1; $i >= 0; $i --)
				{
					if(strlen($reportlist[$i]['title']) == 0) $reportlist[$i]['title'] = '#';
					$reportlist[$i]['title'] = '<a data-pjax href="/home/work/report?id='.$reportlist[$i]['id'].'">'.$reportlist[$i]['title'].'</a>';
					$reportlist[$i]['kind'] = $STR_LIST[$reportlist[$i]['kind']];
				}
			}
			else
				$reportlist = false;
				$data['data'] = $reportlist;
				$data['draw'] = $d_draw;
				$data['recordsTotal'] = $Report->count();
				$data['recordsFiltered'] = $Report->where($map)->count();
	
		}
		$this->ajaxReturn($data);
	}
	//报告内容及评论
	private function report_data()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$id = intval(trim(I('param.id')));
			$Report = M('report');
			$reportinfo = $Report->where('id='.$id)->find();
			if($reportinfo == null)
			{
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
				return $data;
			}
			if($reportinfo['available'] == 0 && !IsAdmin() && session('lab_uid') != $reportinfo['uid'])
			{
				$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				return $data;
			}
			$data['user_self'] = session('lab_uid') == $reportinfo['uid'];
			$data['reportinfo'] = $reportinfo;
			$userinfo = GetUserinfo($reportinfo['uid']);
			if($userinfo == null)
			{
				$data['wrongcode'] = $WRONG_CODE['userid_notexist'];
				return $data;
			}
			$data['userinfo'] = $userinfo;
			$Report_discuss = M('report_discuss');
			$map = array(
				'reportid' => $id,
			);
			if(!IsAdmin())
			{
				$map = array(
						'_complex' => $map,
						'available' => array('neq', 0)
				);
			}
			$report_discusslist = $Report_discuss->table('lab_report_discuss report_discuss')
												->join('LEFT JOIN lab_user user ON user.uid = report_discuss.uid')
												->field('
														user.uid uid,
														user.name name,
														report_discuss.id id,
														report_discuss.content content,
														report_discuss.submittime submittime,
														report_discuss.available available
														')
												->where($map)
												->order(array('id'=>'desc'))
												->select();
			$data['report_discusslist'] = $report_discusslist;
		}
		$data['loggedin'] = IsLoggedin();
		return $data;
	}
	//报告显示页
	public function report()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data = $this->report_data();
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	//报告是否可见处理逻辑，只有报告提交者本人有权限处理
	public function change_report_available_ajax()
	{

		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Report = M('report');
			$map = array(
				'id' => intval(I('param.id'))
			);
			$reportinfo = $Report->where($map)->field('uid, available')->find();
			if($reportinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else
			{
				if($reportinfo['uid'] != session('lab_uid'))
					$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				else 
				{
					if($reportinfo['available'] == 0)
						$reportinfo['available'] = 1;
					else
						$reportinfo['available'] = 0;
					$data['available'] = $reportinfo['available'];
					if($Report->where($map)->save($reportinfo) == false)
						$data['wrongcode'] = $WRONG_CODE['sql_error'];
				}
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}

	//预填写已有的报告内容方便编辑
	private function report_edit_data()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$STR_LIST = C('STR_LIST');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.id', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$id = intval(trim(I('param.id')));
			$Report = M('report');
			$reportinfo = $Report->where('id='.$id)->find();
			if($reportinfo == null)
			{
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
				return $data;
			}
			if(session('lab_uid') != $reportinfo['uid'])
			{
				$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				return $data;
			}
			$data['user_self'] = session('lab_uid') == $reportinfo['uid'];
			$data['reportinfo'] = $reportinfo;
			$data['strlist'] = $STR_LIST;
		}
		return $data;
	}
	//报告编辑页
	public function report_edit()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data = $this->report_edit_data();
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	public function report_edit_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];

		if(I('param.title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Report = M('report');
			$id = intval(trim(I('param.id')));
			$reportinfo = $Report->where('id='.$id)->find();
			if($reportinfo == null)
			{
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			}
			else if(session('lab_uid') != $reportinfo['uid'])
			{
				$data['wrongcode'] = $WRONG_CODE['user_powerless'];
			}
			else 
			{
				$report_update = array(
					'title' => trim(I('param.title')),
					'kind' => intval(trim(I('param.kind'))),
					'content' => trim(I('param.content')),
					'updatetime' => date('Y-m-d H:i:s')
				);
				if($Report->where('id='.$id)->save($report_update) == false)
					$data['wrongcode'] = $WRONG_CODE['sql_notupdate'];
				else
					$data['wrongcode'] = $WRONG_CODE['update_successful'];
				$data['id'] = $id;
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	
	

	//报告编辑页
	public function report_add()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsLoggedin())
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
		if($data['wrongcode'] != $WRONG_CODE['totally_right'])
			$this->display('Public:alert');
		else
			$this->display();
	}
	public function report_add_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!session('?lab_uid'))
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		else if(I('param.title', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$Report = M('report');
			$report_add = array(
					'uid' => session('lab_uid'),
					'title' => trim(I('param.title')),
					'kind' => intval(trim(I('param.kind'))),
					'content' => trim(I('param.content')),
					'submittime' => date('Y-m-d H:i:s'),
					'updatetime' => date('Y-m-d H:i:s')
			);
			$newid = $Report->add($report_add);
			if($newid == false)
				$data['wrongcode'] = $WRONG_CODE['sql_error'];
			else
			{
				$data['newid'] = $newid;
				$data['wrongcode'] = $WRONG_CODE['add_successful'];
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//添加评论处理逻辑
	public function add_discuss_ajax()
	{
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(!IsLoggedin())
			$data['wrongcode'] = $WRONG_CODE['user_notloggin'];
		else if(I('param.add_discuss_text', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$discuss = trim(I('param.add_discuss_text'));
			$reportid = intval(trim(I('param.reportid')));
			if(strLength($discuss) > 1000)
				$data['wrongcode'] = $WRONG_CODE['content_toolong'];
			else if(strLength($discuss) < 2)
				$data['wrongcode'] = $WRONG_CODE['content_tooshort'];
			else 
			{
				$Report = M('report');
				$reportinfo = $Report->field('available, uid')->where('id='.$reportid)->find();
				if($reportinfo == null)
					$data['wrongcode'] = $WRONG_CODE['not_exist'];
				else if($reportinfo['available'] == 0 && !IsAdmin && session('lab_uid') != $reportinfo['uid'])
					$data['wrongcode'] = $WRONG_CODE['user_powerless'];
				else 
				{
					$discuss_add = array(
						'uid' => session('lab_uid'),
						'content' => $discuss,
						'submittime' => date('Y-m-d H:i:s'),
						'reportid' => $reportid
					);
					$Report_discuss = M('report_discuss');
					$data['discussinfo'] = $discuss_add;
					$newid = $Report_discuss->add($discuss_add);
					if($newid == false)
						$data['wrongcode'] = $WRONG_CODE['sql_notadd'];
					else
					{
						$data['wrongcode'] = $WRONG_CODE['add_successful'];
						$data['discussinfo']['id'] = $newid;
					}
				}
			}
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
	//修改评论的显示状态
	public function change_discuss_available_ajax()
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
			$id = intval(trim(I('param.id')));
			$Report_discuss = M('report_discuss');
			$report_discussinfo = $Report_discuss->field('available')->where('id='.$id)->find();
			if($report_discussinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
			{
				if($report_discussinfo['available'] == 0)
					$report_discussinfo['available'] = 1;
				else 
					$report_discussinfo['available'] = 0;
				$data['available'] = $report_discussinfo['available'];
				if($Report_discuss->where('id='.$id)->save($report_discussinfo) == false)
				{
					$data['wrongcode'] = $WRONG_CODE['sql_error'];
				}
			}	
		}
		$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->ajaxReturn($data);
	}
}