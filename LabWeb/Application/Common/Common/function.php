<?php 
/************************************************************/
//密码加密
/************************************************************/
//生成加密密码
function MkPasswd($raw_passwd)
{
	return md5($raw_passwd);
}
/************************************************************/
//用户名、密码、email格式校验
/************************************************************/
//密码格式验证
function TestPasswd($raw_passwd)
{
	$WRONG_CODE = C('WRONG_CODE');
	if(strlen($raw_passwd) > 20)
		return $WRONG_CODE['passwd_toolong'];
	if(strlen($raw_passwd) < 6)
		return $WRONG_CODE['passwd_tooshort'];
	return $WRONG_CODE['totally_right'];
}
//用户名格式验证
function TestUserID($username)
{
	$WRONG_CODE = C('WRONG_CODE');
	if(strlen($username) > 20)
		return $WRONG_CODE['userid_toolong'];
	if(strlen($username) < 3)
		return $WRONG_CODE['userid_tooshort'];
	$pattern = "/^[0-9A-Za-z_]+$/i";
	if(!preg_match( $pattern, $username))
		return $WRONG_CODE['userid_invalid'];
	return $WRONG_CODE['totally_right'];
}
//email格式验证
function TestEmail($email)
{
	$WRONG_CODE = C('WRONG_CODE');
	if(strlen($email) > 50)
		return $WRONG_CODE['email_toolong'];
	$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	if(!preg_match( $pattern, $email))
		return $WRONG_CODE['email_invalid'];
	return $WRONG_CODE['totally_right'];
}
/************************************************************/
//身份证校验
/************************************************************/
function validation_filter_id_card($id_card)
{
	$WRONG_CODE = C('WRONG_CODE');
	if(strlen($id_card) == 18)
	{
		return idcard_checksum18($id_card);
	}
	elseif((strlen($id_card) == 15))
	{
		$id_card = idcard_15to18($id_card);
		return idcard_checksum18($id_card);
	}
	else
	{
		return $WRONG_CODE['ic_invalid'];
	}
}
// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base)
{
	$WRONG_CODE = C('WRONG_CODE');
	if(strlen($idcard_base) != 17)
	{
		return $WRONG_CODE['ic_invalid'];
	}
	//加权因子
	$factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
	//校验码对应值
	$verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
	$checksum = 0;
	for ($i = 0; $i < strlen($idcard_base); $i++)
	{
		$checksum += substr($idcard_base, $i, 1) * $factor[$i];
	}
	$mod = $checksum % 11;
	$verify_number = $verify_number_list[$mod];
	return $verify_number;
}
// 将15位身份证升级到18位
function idcard_15to18($idcard)
{
	$WRONG_CODE = C('WRONG_CODE');
	if (strlen($idcard) != 15)
	{
		return $WRONG_CODE['ic_invalid'];
	}
	else
	{
		// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
		if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== $WRONG_CODE['ic_invalid'])
		{
			$idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
		}
		else
		{
			$idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
		}
	}
	$idcard = $idcard . idcard_verify_number($idcard);
	return $idcard;
}
// 18位身份证校验码有效性检查
function idcard_checksum18($idcard)
{
	$WRONG_CODE = C('WRONG_CODE');
	if (strlen($idcard) != 18)
	{
		return $WRONG_CODE['ic_invalid'];
	}
	$idcard_base = substr($idcard, 0, 17);
	if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1)))
	{
		return $WRONG_CODE['ic_invalid'];
	}
	else
	{
		return $WRONG_CODE['totally_right'];
	}
}
/************************************************************/
//pjax判断
/************************************************************/
function IsPjax()
{
	return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'] === 'true';
}
/************************************************************/
//admin判断
/************************************************************/
function IsAdmin()
{
	return session('?lab_admin') && session('lab_admin') == true;
}
/************************************************************/
//信息统计完整查看权限判断
/************************************************************/
function IsWatcher()
{
	return IsAdmin() || session('?info_watcher') && session('info_watcher') == true;
}
function StrToStar($str)
{
	return preg_replace("/./", "*", $str); 
}
/************************************************************/
//登录判断
/************************************************************/
function IsLoggedin()
{
	return session('?lab_uid') ? true : false;
}
/************************************************************/
//识别编码并转utf-8
/************************************************************/
function char2utf8($data){
	if( !empty($data) )
	{
		$fileType = mb_detect_encoding($data , array('UTF8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'UTF-8'){
			$data = mb_convert_encoding($data ,'UTF-8' , "auto");
		}
	}
	return $data;
}
/************************************************************/
//unicode转utf8
/************************************************************/
function unicode2utf8($str){
	if(!$str) return $str;
	$decode = json_decode($str);
	if($decode) return $decode;
	$str = '["' . $str . '"]';
	$decode = json_decode($str);
	if(count($decode) == 1){
		return $decode[0];
	}
	return $str;
}
function unicode_decode($name)
{
	//转换编码，将Unicode编码转换成可以浏览的utf-8编码
	$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
	preg_match_all($pattern, $name, $matches);
	if (!empty($matches))
	{
		$name = '';
		for ($j = 0; $j < count($matches[0]); $j++)
		{
			$str = $matches[0][$j];
			if (strpos($str, '\\u') === 0)
			{
				$code = base_convert(substr($str, 2, 2), 16, 10);
				$code2 = base_convert(substr($str, 4), 16, 10);
				$c = chr($code).chr($code2);
				$c = iconv('UCS-2', 'UTF-8', $c);
				$name .= $c;
			}
			else
			{
				$name .= $str;
			}
		}
	}
	return $name;
}
/************************************************************/
//将base64加密过的json字符串转换为php关联数组返回
/************************************************************/
function base64_json_decode($str)
{
	$jsonstr = base64_decode($str);
	$jsonstr = strtr($jsonstr, "\t", ' ');
	if($jsonstr != false)
	{
		for($i = strlen($jsonstr) - 1; $i >= 0; $i --)
			if($jsonstr[$i] == '\\') $jsonstr[$i] = '/';
		$jsondata = json_decode(stripslashes($jsonstr), true);
		return $jsondata;
	}
	return false;
}
/************************************************************/
//数据库操作通用函数
/************************************************************/
//在某个table的一个field(列)查询为某个item的条目是否存在，如果consider_del，则del条目为true的也视为不存在
function ItemExists($item, $field, $table, $consider_del)
{
	$WRONG_CODE = C('WRONG_CODE');
	$map[$field] = $item;
	if($consider_del) $map['del'] = 0;
	if(M($table)->where($map)->field($field)->find() != null)
		return $WRONG_CODE['yes_exist'];
	else 
		return $WRONG_CODE['not_exist'];
}
function ContentMatch($item1, $item2, $field1, $field2, $table, $consider_del)
{
	$WRONG_CODE = C('WRONG_CODE');
	$map[$field1] = $item1;
	if($consider_del) $map['del'] = 0;
	$content = M($table)->where($map)->field($field2)->find();
	if($content == null)
		return $WRONG_CODE['userid_notexist'];
	else if($content[$field2] != $item2)
		return $WRONG_CODE['content_wrongmatch'];
	return $WRONG_CODE['totally_right'];
}
function ContentFind($item1, $field1, $field2, $table, $consider_del)
{
	$WRONG_CODE = C('WRONG_CODE');
	$map[$field1] = $item1;
	if($consider_del) $map['del'] = 0;
	$content = M($table)->where($map)->field($field2)->find();
	if($content == null)
		return "#";
	return $content[$field2];
}
//得到用户完整信息
function GetUserinfo($uid)
{
	$STR_LIST = C('STR_LIST');
	$map = array(
		'user.uid' => $uid
	);
	$User = M('user');
	$userinfo = $User->table('lab_user user')
					->join('LEFT JOIN lab_userdetail userdetail ON userdetail.uid = user.uid')
					->field('
							user.uid uid,
							user.name name,
							user.kind kind,
							user.graduate graduate,
							userdetail.sex sex,
							userdetail.phone phone,
							userdetail.email email,
							userdetail.degree degree,
							userdetail.grade grade,
							userdetail.birthday birthday,
							userdetail.idcard idcard,
							userdetail.nation nation,
							userdetail.political political,
							userdetail.institute institute,
							userdetail.major major,
							userdetail.supervisor supervisor,
							userdetail.teacher teacher,
							userdetail.supervisorid supervisorid,
							userdetail.teacherid teacherid
							')
					->where($map)
					->find();
	if($userinfo == null)
		return null;
	else
	{
		$userinfo['graduate'] = $STR_LIST[$userinfo['graduate']];
		$userinfo['kind'] = $STR_LIST[$userinfo['kind']];
		$userinfo['degree'] = $STR_LIST[$userinfo['degree']];
		$userinfo['sex'] = $STR_LIST[$userinfo['sex']];
		return $userinfo;
	}
}
/************************************************************/
//中英混合字符串长度
/************************************************************/
function strLength($str)
{
    return (strlen($str) + mb_strlen($str,'UTF8')) >> 1;
}
