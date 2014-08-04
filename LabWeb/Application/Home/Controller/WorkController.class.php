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
					$statisticlist[$i]['title'] = '<a data-pjax href="/home/work/statistic_res?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['title'].'</a>';
					$starttime = strtotime($statisticlist[$i]['starttime']);
					$endtime= strtotime($statisticlist[$i]['endtime']);
					$statisticlist[$i]['status'] = '<a data-pjax href="/home/work/statisticdo?id='.$statisticlist[$i]['id'].'">'.$statisticlist[$i]['title'].'</a>';
					if($nowtime < $starttime)
						$statisticlist[$i]['status'] = '<a data-pjax href="#" class="ui tiny red button">尚未开始</a>';
					else if($nowtime > $endtime)
						$statisticlist[$i]['status'] = '<a data-pjax href="#" class="ui tiny grey button">已经结束</a>';
					else
						$statisticlist[$i]['status'] = '<a data-pjax href="/home/work/statisticdo?id='.$statisticlist[$i]['id'].'" class="ui tiny green button">正在进行</a>';
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
	public function fingerprint()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$this->display();
	}
	public function pcinfo()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$this->display();
	}
}