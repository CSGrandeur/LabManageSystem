<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
        $this->display();
    }
}