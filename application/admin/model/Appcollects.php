<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;

class Appcollects extends Model
{
	//获取所有用户
	public function get_allcollect(){
		$all=Db::view('product_collect','*')
				->view('avatar','avatar_image','product_collect.avatar_id=avatar.avatar_id')
				->select();
		return $all;
	}
	 
}
?>