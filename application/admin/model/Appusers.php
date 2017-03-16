<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;

class Appusers extends Model
{
	//获取所有用户
	public function get_alluser(){
		$all=Db::view('ike_user','*')
				->order('gen_time desc')
				->paginate(7);
		$page = $all->render();
		$datas=array();
		$datas['all']=$all;
		$datas['page']=$page;
		return $datas;
	}
	 
}
?>