<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;

class Adminusers extends Model
{
	//获取所有用户
	public function get_alluser(){
		$all=Db::view('admin','*')
					->view('admintype','type_name','admintype.groupid=admin.groupid')
					->paginate(10);
		$page = $all->render();
		$datas=array();
		$datas['all']=$all;
		$datas['page']=$page;
		return $datas;
	}
	 
}
?>