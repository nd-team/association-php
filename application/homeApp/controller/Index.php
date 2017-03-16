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

class Index extends Controller
{
	public $RongCloud=null;
	public $appKey = 'tdrvipkstdnk5';
	public $appSecret = 'qt6TWUPsWZuWOP';
	public $view=null;
	function __construct()
	{
		//检查登录状态
		$this->checkAccess();
		$this->view=new View();
		$this->RongCloud = new Api($this->appKey,$this->appSecret);
		$this->view->assign('appKey',$this->appKey);
		$this->view->assign('appSecret',$this->appSecret);
		$this->view->assign('userinfo',$this->admininfo());
		
	}

	//管理员个人用户信息
	public function admininfo()
	{
		$tu_id=Session::get('applogin')['tu_id'];
		$userinfo=Db::view('user','*')
					->view('avatar','avatar_image','avatar.avatar_id=user.avatar_id')
					->where('tu_id','=',$tu_id)
					->select();
		$userinfo=reset($userinfo);
		return $userinfo;
	}
	public function user_info()
	{
		if (Request::instance()->isPost())
		{
			var_dump($_POST);exit;
		}
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
		//$user=array('13025304562');
		//var_dump($this->RongCloud->messagePrivatePublish('18826238489','13025304562','RC:TxtMsg',"{\"content\":\".....\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0'));
		//var_dump($this->RongCloud->getToken('aaa','bbb','http://www.rongcloud.cn/images/logo.png'));
		return $this->view->fetch();
    }
	
	

	
}





