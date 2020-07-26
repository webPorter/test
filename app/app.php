<?php
error_reporting(0);
session_start();
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__))."/");
define('ROOT_PATH',str_replace('app/','',BASE_PATH));
define('MSGFILE','app/MSG.txt'); 
define('NUMFILE','app/NUM.txt'); 
define('KEYS','bskdl87'); 
define('LSTR','admin');
date_default_timezone_set('PRC');
function nick($user=''){
$name_tou=array('赵','李','孙','卫','周','陈','蒋','沈','杨','韦','苗','唐','穆','萧','祁','程','凌','甄','甘','冉','常','高','马','熊','刀','胡','张','田','姜','郭','朱','向','闻','莘','翟','谭');

$name_wei=array('琼琼','纤纤','勤勤','琴琴','庆庆','芹芹','茜茜 然然','冉冉','荣荣','嵘嵘','蓉蓉','蕊蕊','锐锐 瑞瑞','睿睿','韧韧','沙沙','莎莎','杉杉','姗姗 珊珊','诗诗','施施','帅帅','双双','倩倩','思思','甜甜','月月','磊磊','零零','西西','峰峰','淡淡','靓靓','浮浮','纹纹','霸霸','落落','离离','湘湘','城城','痕痕','墨墨','龙龙','檬檬','森森','穆穆','赫赫','魅魅','空空','兽兽','海海','执执','酒酒','飞飞','夏夏','舒舒','叶叶','月月','盈盈','鑫鑫','森森','淼淼','磊磊');
if($user==''){
    $t=rand(0,35);
    $w=rand(0,65);
    $name=$name_tou[$t].$name_wei[$w];
    $arr['msg'] = '<span>'.date('Y-m-d H:i').'</span>';
	$arr['type']= 'sys';
	$str = json_encode($arr);
	$arr['msg'] = '<span class="tips-warning">系统消息：<strong>'.$name.'</strong>进入聊天室</span>';
	$arr['type']= 'sys';
	$str = $str."\n".json_encode($arr);
	file_put_contents(ROOT_PATH.MSGFILE, $str."\n" , FILE_APPEND|LOCK_EX);
}else{
  $name = $user;
} 
	$key = uniqid();
    setcookie(KEYS.'_key',$key,time()+3600*24*90,'/');
    setcookie(KEYS.'_name',urlencode($name),time()+3600*24*30,'/');
    return array('name'=>$name,'key'=>$key); //输出生成的昵称
} 

function logmsg($b, $msg = '操作成功！')
{
    if ($b > 0) {
        $arr['result'] = 200;
        $arr['message'] = $msg;
    } else {
        $arr['result'] = 500;
        if (empty($msg)) {
            $arr['message'] = '操作失败！';
        } else {
            $arr['message'] = $msg;
        }
    }
    $arr['id'] = $b;
    echo json_encode($arr);
    exit;
}
 

function get_token(){
  if(empty($_SESSION[KEY.'token'])){
      $token = md5(uniqid(rand(), true));
      $_SESSION[KEY.'token'] = $token;
  }else{
     $token = $_SESSION[KEY.'token'];
  }
  setcookie(md5(KEY.'token'),$token,time()+3600*24,'/');
  return $token;
}

function check_post($arr,$config=array()){
	$now = time();
    $token = $_COOKIE[md5(KEY.'token')];	
	if(empty($token) or $token !=  $_SESSION[KEY . 'token']){
	   return false;
	}	
	return true;
}