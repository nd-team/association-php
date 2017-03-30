<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;

class Appgroups extends Model
{
	//获取所有用户
	public function get_allGroup(){
		$all=Db::view('group_name','*')
				->view('avatar','avatar_image','group_name.avatar_id=avatar.avatar_id')
				->select();
		return $all;
	}
	 
}
?>