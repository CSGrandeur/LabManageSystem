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
			//file_put_contents("loog.txt", print_r($Statistic->_sql(), true));
			// 	$fp = fopen("loog.txt", "a+");
			// 	fwrite ($fp, $Userdetail->_sql());
			// 	fwrite ($fp, "\n");
			// 	fclose($fp);
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
			file_put_contents("loog.txt", print_r($Statisticdo->_sql(), true));
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
}