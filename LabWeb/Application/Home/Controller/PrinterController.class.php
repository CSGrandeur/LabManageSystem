<?php
namespace Home\Controller;
use Think\Controller;
class PrinterController extends Controller {
	function receive_return()
	{//返回非0，表示允许打印。只有准确判断纸张数超出规定时候返回0，禁止打印。
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		 
		if(I('param.info', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			$info = base64_json_decode(I('param.info'));//函数在Common/function.php中
			if(array_key_exists("uid", $info))
			{
				$info['infohash'] = md5(I('param.info'));
				$Printrecord = M('printrecord');
				$printrecordinfo = $Printrecord->where('infohash='.$info['infohash'])->find();
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
					$Printrecord->add($printrecord_add);
					
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
}