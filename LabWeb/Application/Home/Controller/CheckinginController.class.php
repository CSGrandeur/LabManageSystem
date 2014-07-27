<?php
namespace Home\Controller;
use Think\Controller;
class CheckinginController extends Controller {
    public function index()
    {
    	
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