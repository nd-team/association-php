<?php
namespace app\home\controller;

use think\Controller;
use think\Request;//验证validate内容
use app\home\model\LoginUser;
use think\Url;
use think\Session;
use think\Config;
class Login extends controller
{

	public $AppUserModel=null;//保存实例化模型
	public function __construct(){
		
		$this->AppUserModel=new LoginUser;
	}
    public function index()
    {
		//dump(Cache::get('name')); exit;
		//echo Config::get('USER_AUTH_KEY');exit;
		$user=Session::get('applogin');
		//var_dump($user);exit;
		if(!empty($user)){
			return $this->redirect('home/index');
		}else{
			return view();
		}
		
    }
	
	public function doLogin()//登录请求
	{
		
		$request = Request::instance();//获取请求
		if($request->isAjax()){		//判读ajax
			$data=$request->param();//获取参数
			//var_dump($data['captcha']);exit;
			if(captcha_check($data['captcha'])){//判断验证码
				unset($data['captcha']);
				//var_dump($data);exit;
				$result=$this->validate($data,'admin.login');//控制器验证，验证validate内容
				if(true !== $result){
					return $this->error($result);
				}
				$userRow=$this->AppUserModel->login($data);
				if (empty($userRow)) {
					return $this->error($this->AppUserModel->getError());
				}
				return $this->success('登录成功', Url::build('/home/index/','',''));
			}else{
				return $this->error('验证码失败');
			}
		}
	}
	
	public function logout()
	{
		//Session::delete(Config::get('USER_AUTH_KEY'),'login');
		//Session::delete('menus');
		$this->AppUserModel->logout();
		return $this->success('退出成功', '/home/login');
	}
}
