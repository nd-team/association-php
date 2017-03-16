<?php
namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Session;
use think\Config;
use think\Request;
use think\View;
use \think\Url;
use app\home\model\ProductCollect;
class Index extends Controller
{
	public $RongCloud=null;
	public $appKey = 'tdrvipkstdnk5';
	public $appSecret = 'qt6TWUPsWZuWOP';
	public $view=null;
	public $ProductCollectModel=null;//产品众筹实例化
	function __construct()
	{
		$this->ProductCollectModel=new ProductCollect;
		//检查登录状态
		//$this->checkAccess();
		//$this->view=new View();
		//$this->RongCloud = new Api($this->appKey,$this->appSecret);
		//$this->view->assign('appKey',$this->appKey);
		//$this->view->assign('appSecret',$this->appSecret);
		//$this->view->assign('userinfo',$this->admininfo());
		
	}

	//判断是否登录
	public function checkAccess()
	{
		$uid=$this->key();
		if(is_null($uid)){
			$this->goLogin();
			return false;
		}
		if(empty($uid)){
			$this->goLogin();
			return false;
		}
	}
	//获取登录用户session  id
	public function key()
	{
		//var_dump(Session::get('login'));exit;
		$user=Session::get('applogin');

		//var_dump($user);exit;
		if(empty($user)){
			//echo 1;exit;
			$this->goLogin();
			return false;
		}
		if(is_null($user)){
			$this->goLogin();
			return false;
		}
		$user=reset($user);//数组的内部指针重置到数组中的第一个元素
		return $user;
	}
	//判断是否为超级管理员
	public function is_admin(){
		$user=Session::get('applogin');
		//$userid=$this->userID();
		//var_dump($userid);exit;
		if($user['admin_name']==Config::get('SUPERVISOR')){
			return true;
		}else{
			return false;
		}
	}
	//重定向登录页面
	public function goLogin()
	{
		//session::flush();
		//Session::clear();
		Session::delete('applogin');
		$redirect='/home/login/index';
		$this->redirect(Url::build($redirect));
		return false;
	}
	
    public function index()
    {
		$product_collect=$this->ProductCollectModel->all_content();
		var_dump($product_collect);exit;
		//$user=array('13025304562');
		//var_dump($this->RongCloud->messagePrivatePublish('18826238489','13025304562','RC:TxtMsg',"{\"content\":\".....\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0'));
		//var_dump($this->RongCloud->getToken('aaa','bbb','http://www.rongcloud.cn/images/logo.png'));
		return $this->view->fetch();
    }
	
	

	
}





