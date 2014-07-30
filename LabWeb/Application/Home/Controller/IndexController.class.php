<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
//     	$WRONG_CODE = C('WRONG_CODE');
//     	$WRONG_MSG = C('WRONG_MSG');
//     	$data['wrongcode'] = $WRONG_CODE['totally_right'];
     	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
//        $this->redirect('/home/index/newslist');
        $this->display();
    }
    private function newslist_data()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	$Announcement = M('announcement');
    	$map = array(
    		'announcement.available' => array('neq', 0)
    	);
    	$announcementlist = $Announcement->table('lab_announcement announcement')
						->join('LEFT JOIN lab_user submituser ON submituser.uid = announcement.submitter')
						->join('LEFT JOIN lab_user menduser ON menduser.uid = announcement.mender')
						->field('
								announcement.id id,
								announcement.title title,
								announcement.content content,
								announcement.submittime submittime,
								announcement.updatetime updatetime,
								submituser.uid submituid,
								submituser.name submituname,
								menduser.uid menduid,
								menduser.name menduname
								')
						->where($map)
						->order(array('submittime' => 'desc'))
						->limit(10)
						->select();

    	$data['newslist'] = $announcementlist;
    	$data['listcount'] = count($announcementlist);
    	return $data;
    }
    public function newslist()
    {
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
    	$this->assign($this->newslist_data());
        $this->display();
    }
    //单条通知
    private function news_data()
    {
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	$Announcement = M('announcement');
    	$map = array(
    			'announcement.available' => array('neq', 0),
    			'announcement.id' => intval(I('param.id'))
    	);
    	$announcementinfo = $Announcement->table('lab_announcement announcement')
								    	->join('LEFT JOIN lab_user submituser ON submituser.uid = announcement.submitter')
								    	->join('LEFT JOIN lab_user menduser ON menduser.uid = announcement.mender')
								    	->field('
												announcement.id id,
												announcement.title title,
												announcement.content content,
												announcement.submittime submittime,
												announcement.updatetime updatetime,
												submituser.uid submituid,
												submituser.name submituname,
												menduser.uid menduid,
												menduser.name menduname
												')
	    								->where($map)
	    								->find();
    	if($announcementinfo == null)
    		$data['wrongcode'] = $WRONG_CODE['not_exist'];
    	$data['wrongmsg'] = $WRONG_MSG[$data['wrongcode']];
    	$data['newsinfo'] = $announcementinfo;
    	return $data;
    }
    public function news()
    {
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data = $this->news_data();
    	$this->assign($data);
    	if($data['wrongcode'] != $WRONG_CODE['totally_right'])
    		$this->display('Public:alert');
    	else
        	$this->display();
    }
    //更多通知列表ajax查询
    public function newsmore()
    {
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
    	$WRONG_CODE = C('WRONG_CODE');
    	$WRONG_MSG = C('WRONG_MSG');
    	$data['wrongcode'] = $WRONG_CODE['totally_right'];
    	$this->display();
    	
    }
    public function newsmore_list_ajax()
    {
		$WRONG_CODE = C('WRONG_CODE');
		$WRONG_MSG = C('WRONG_MSG');
		$data['wrongcode'] = $WRONG_CODE['totally_right'];
		if(I('param.draw', $WRONG_CODE['not_exist']) == $WRONG_CODE['not_exist'])
		{
			$data['wrongcode'] = $WRONG_CODE['query_data_invalid'];
		}
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
				default: 
					$d_ordercol = 'submittime'; 
					break;
			}
			$d_orderdir = $reqdata['order'][0]['dir'];
			$d_searchvalue = $reqdata['search']['value'];
			$d_searchregex = $reqdata['search']['regex'];
			$map = array(
					'title' => array('like', '%'.$d_searchvalue.'%'),
					'available' => array('neq', 0)
			);
			$Announcement = M('announcement');
			$announcementlist = $Announcement->where($map)
			->order(array($d_ordercol=>$d_orderdir))
			->limit($d_start, $d_length)
			->select();
			
			if($announcementlist == false) $announcementlist = array();
			for($i = 0; $i < count($announcementlist); $i ++)
			{
				if(strlen($announcementlist[$i]['title']) == 0)
					$announcementlist[$i]['title'] = "#";
				$announcementlist[$i]['title'] = '<div class="limit_header limit_width_700"><a data-pjax href="/home/index/news?id='.$announcementlist[$i]['id'].'">'.$announcementlist[$i]['title'].'</a></div>';
				$announcementlist[$i]['id'] = '<a data-pjax href="/home/index/news?id='.$announcementlist[$i]['id'].'">'.$announcementlist[$i]['id'].'</a>';
									
			}
			$data['data'] = $announcementlist;
			$data['draw'] = $d_draw;
			$data['recordsTotal'] = $Announcement->count();
			$data['recordsFiltered'] = $Announcement->where($map)->count();
		}
		
		$this->ajaxReturn($data);
	}
	public function schoolnews()
	{
    	if(!IsPjax()) layout(true);//判断pjax确定是否加载layout
		$this->display();
	}
}