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
						'clientIP' => get_client_ip()
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
	public function display_checkingin()
	{
		if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.uid', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		else
		{
			$uid = trim(I('param.uid'));
			if(ItemExists($uid, 'uid', 'name2onlyname', false) == $WRONG_CODE['not_exist'])
			{
				$data['wrongcode'] = $WRONG_CODE['not_exist'];
			}
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
		 
		if(I('param.uid', $WRONG_CODE['not_exist']) != $WRONG_CODE['not_exist'])
		{
			
		}
    }
}