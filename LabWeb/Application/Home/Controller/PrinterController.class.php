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
						'month' => date("Y-m-1"),
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
						'month' => date("Y-m-1"),
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
}