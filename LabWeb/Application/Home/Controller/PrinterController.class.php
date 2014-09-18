<?php
namespace Home\Controller;
use Think\Controller;
class PrinterController extends Controller {
	private function receive_return()
	{//返回非0，表示允许打印。
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.info', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			$info = base64_json_decode(I('param.info'));//函数在Common/function.php中
			if(array_key_exists("uid", $info))//info数组中有uid
			{
				$info['infohash'] = md5(I('param.info'));
				$Printrecord = M('printrecord');
				$map = array(
					'infohash' => $info['infohash']
				);
				$printrecordinfo = $Printrecord->where($map)->find();
				if($printrecordinfo != null)
					return $printrecordinfo['result'];
				else 
				{
					$Printarrange = M('printarrange');
					$arrange = $Printarrange->where('uid='.$info['uid'])->find();
					$paperlimit = $arrange == null ? C('PAPER_LIMIT') : $arrange['paperlimit'];
					//计算本月额外配给纸张数（允许多次配给，求和）
					$Printaddition = M('printaddition');
					$map = array(
						'uid' => $info['uid'],
						'month' => date("Y-m-01"),
						'available' => 1
					);
					$addition = $Printaddition->where($map)->select();
					$additionnum = 0;
					if($addition != null)
					{
						foreach($addition as $addition_item)
							$additionnum += $addition_item['addnum'];
					}
					$paperlimit += $additionnum;
					//计算本月已使用总纸张数
					$Printcount = M('printcount');
					$map = array(
						'uid' => $info['uid'],
						'month' => date("Y-m-01"),
					);
					$papercount = $Printcount->where($map)->find();
					if($papercount == null)
					{
						$papercount = $map + array('papersum' => $info['papernum']);
						$Printcount->add($papercount);
					}
					$alreadyused = $papercount['papersum'];
					
					$printrecord_add = array(
							'uid' => $info['uid'],
							'papernum' => $info['papernum'],
							'jobname' => $info['jobname'],
							'identifier' => $info['identifier'],
							'submittime' => date('Y-m-d H:i:s', strtotime($info['submittime'])),
							'updatetime' => date('Y-m-d H:i:s'),
							'infohash' => $info['infohash']
					);
					$Printrecord = M('printrecord');
					$printrecord_add['result'] = $alreadyused >= $paperlimit ? 0 : 1;
					if(ItemExists($info['uid'], 'uid', 'user', false) == $WRONG_CODE['not_exist'])
						$printrecord_add['result'] = 0;//如果系统不存在该用户，则不允许打印
					
					
					$Printrecord->add($printrecord_add);
					if($printrecord_add['result'] != 0)
						$papercount['papersum'] += intval($info['papernum']);
					$Printcount->save($papercount);
					
					return $printrecord_add['result'];
				}
			}
		}
		return 2;//没有得到正确信号
	}
	public function receive()
	{
		echo $this->receive_return();
	}
	//打印纸使用状况
	public function paperstate()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
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
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$reqdata = I('param.');
			$d_draw = intval($reqdata['draw']);
			$d_start = intval($reqdata['start']);
			$d_length = intval($reqdata['length']);
			$d_month = date("Y-m-01", strtotime(trim($reqdata['month'])));
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
								->group('uid')
								->order(array($d_ordercol=>$d_orderdir))
								->limit($d_start, $d_length)
								->select();
			if($paperstatelist != null && $paperstatelist[0]['uid'] != null)
			{
				for($i = count($paperstatelist) - 1; $i >= 0; $i --)
				{
					$paperstatelist[$i]['paperlimit'] = 
						($paperstatelist[$i]['paperlimit'] ? $paperstatelist[$i]['paperlimit'] : C('PAPER_LIMIT')) + 
						($paperstatelist[$i]['addnum'] ? $paperstatelist[$i]['addnum'] : 0);
					$paperstatelist[$i]['papersum'] = $paperstatelist[$i]['papersum'] ? $paperstatelist[$i]['papersum'] : 0;
					$paperstatelist[$i]['sex'] = $STR_LIST[$paperstatelist[$i]['sex']];
					$paperstatelist[$i]['degree'] = $STR_LIST[$paperstatelist[$i]['degree']];
					$paperstatelist[$i]['name'] = '<a data-pjax href="/home/printer/paperuseinfo?uid='.$paperstatelist[$i]['uid'].'">'.$paperstatelist[$i]['name'].'</a>';
					$paperstatelist[$i]['uid'] = '<a data-pjax href="/home/user/userinfo?uid='.$paperstatelist[$i]['uid'].'">'.$paperstatelist[$i]['uid'].'</a>';	
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
				//							->group('user.uid')
											->count();
			
		}

		$this->ajaxReturn($data);
	}
	

	//个人打印记录
	public function paperuseinfo()
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
			$userinfo = GetUserinfo($uid);
			if($userinfo == null)
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			else 
				$data['userinfo'] = $userinfo;
			$data['uid'] = $uid;
			$data['month'] = date('Y-m');
		}
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
		$this->assign($data);
        if($data['wrongcode'] != $WRONG_CODE['totally_right'])
        	$this->display('Public:alert');
        else
        	$this->display();
	}
	//个人打印记录表数据
	public function paperuseinfo_ajax()
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
			$d_month = date("Y-m-01", strtotime(trim($reqdata['month'])));
			$d_next_month = date("Y-m-01", strtotime("$d_month +1 month"));
			$uid = trim($reqdata['uid']);
			if($d_length > 100) $d_length = 100;
			$d_ordercol = "";
			switch($reqdata['order'][0]['column'])
			{
				case 0: $d_ordercol = 'id'; break;
				case 1: $d_ordercol = 'identifier'; break;
				case 2: $d_ordercol = 'papernum'; break;
				case 3: $d_ordercol = 'jobname'; break;
				case 4: $d_ordercol = 'submittime'; break;
				case 5: $d_ordercol = 'result'; break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'id' => array('like', '%'.$d_searchvalue.'%'),
					'identifier' => array('like', '%'.$d_searchvalue.'%'),
					'_logic' => 'or'
			);
			if(session('lab_uid') == $uid)//登录者是其本人才可以搜索jobname
			{
				$map = array(
						'_complex' => $map,
						'jobname' => array('like', '%'.$d_searchvalue.'%'),
						'_logic' => 'or'
				);
			}
			$map = array(
					'_complex' => $map,
					'uid' => $uid,
					'updatetime' => array('between', "$d_month, $d_next_month")
			);
			$Printrecord = M('printrecord');
			$paperuseinfolist = $Printrecord->where($map)
											->order(array($d_ordercol=>$d_orderdir))
											->limit($d_start, $d_length)
											->select();
			if($paperuseinfolist != null && $paperuseinfolist[0]['id'] != null)
			{
				for($i = count($paperuseinfolist) - 1; $i >= 0; $i --)
				{
					if((session('lab_uid') != $uid && !IsAdmin()) || strlen($paperuseinfolist[$i]['jobname']) <= 0)
						$paperuseinfolist[$i]['jobname'] = '#';
					if($paperuseinfolist[$i]['result'] == 0)
						$paperuseinfolist[$i]['result'] = '否';
					else
						$paperuseinfolist[$i]['result'] = '是';
				}
			}
			else 
				$paperuseinfolist = false;
			$data['data'] = $paperuseinfolist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $Printrecord->count();
			$data['recordsFiltered'] = $Printrecord->where($map)->count();
		}
		$this->ajaxReturn($data);
	}
}