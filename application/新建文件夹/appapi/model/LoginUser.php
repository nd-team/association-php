<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;
class LoginUser extends Model
{
    function __construct()
    {
        parent::__construct();
    }
	public function login(array $data)
	{
		//dump(Cache::get('login')); exit;
		//Cache::clear();  exit;
		//$stime=microtime(true);
		$map['admin_name'] = htmlspecialchars($data['admin_name']);//htmlspecialchars 大于和小于转化为html实体
		$result = Db::table('ike_admin')
						->where($map)
						->select();
						
		$where['groupid']=$result[0]['groupid'];
		$group = Db::table('ike_admintype')
						->where($where)
						->select();
		$group=reset($group);
		if($group['status']==0){
			$this->error=$group['type_name'].'组禁止登录';
			return false;
		}
		//$data = \think\Cache::get();
		//var_dump($data);exit;
		//$user = User::get(1);
		//$result=Db::query('select * from ike_User where id=1');
		//echo User::getLastSql();EXIT;
		//var_dump($result);exit;

		if(empty($result) || $result[0]['status']==0 || $result[0]['password'] !== md5($data['password'])){
			if(empty($result)){
				$this->error='账号不存在';
				//登录失败要记录在日志里
				Loader::model('Loginlog')->record(" 账号不存在, admin_name:[{$data['admin_name']}] password:[{$data['password']}] 访问者ip:[{$this->getIP}] address:[{$this->getIPLoc_sina('119.129.211.30')}]",$this->getIPLoc_sina('119.129.211.30'),$this->getIP);
				return false;
			}elseif($result[0]['status']==0){
				$this->error='账号已禁止，请联系管理员';
				//登录失败要记录在日志里
				Loader::model('Loginlog')->record(" 账号已禁止，请联系管理员, 账号名:[{$data['admin_name']}] password:[{$data['password']}] 访问者ip:[{$this->getIP}] address:[{$this->getIPLoc_sina('119.129.211.30')}]",$this->getIPLoc_sina('119.129.211.30'),$this->getIP);
				return false;
			}elseif($result[0]['password'] !== md5($data['password'])){
				$this->error='密码出错，请重新输入';
				//登录失败要记录在日志里
				Loader::model('Loginlog')->record(" 登录失败,密码出错, 账号名:[{$data['admin_name']}] password:[{$data['password']}] 访问者ip:[{$this->getIP}] address:[{$this->getIPLoc_sina('119.129.211.30')}]",$this->getIPLoc_sina('119.129.211.30'),$this->getIP);
				return false;
			}
			
		}
		unset($result[0]['password']);
		Db::table('ike_admin')
			 ->where('admin_id',$result[0]['admin_id'])
			 ->update(['login_time'=>date('Y-m-d H:i:s',time()) ,'login_ip'=>$this->getIP,'count'=>$result[0]['count']+1]);
		Loader::model('Loginlog')->record(" 登录成功, 账号名:[{$data['admin_name']}] 访问者ip:[{$this->getIP}] address:[{$this->getIPLoc_sina('119.129.211.30')}]",$this->getIPLoc_sina('119.129.211.30'),$this->getIP);
		//$etime=microtime(true);//获取程序执行结束的时间
		//$total=$etime-$stime; 
		//echo "<br />[页面执行时间：".$total." ]秒";
		Session::set(Config::get('USER_AUTH_KEY'), $result,'login');
		return $result;
	}
	/*退出登录*/
	public function logout()
	{
		$admin_id=Session::get('loginSession')['admin_id'];
		Db::table('ike_admin')
			 ->where('admin_id',$admin_id)
			 ->update(['last_login_time'=>date('Y-m-d H:i:s',time())]);
		//Cache::clear(); 
		Session::delete('loginSession','login');
	}
	//管理员个人用户信息
	public function admininfo()
	{
		$admin_id=Session::get('loginSession')['admin_id'];
		
		$admininfo=Db::view('admin','*')
					->view('admintype','type_name','admintype.groupid=admin.groupid')
					->view('avatar','avatar_image','avatar.avatar_id=admin.avatar_id')
					->where('admin_id','=',$admin_id)
					->select();
		foreach($admininfo as $k=>$v){
			$admininfo=$admininfo[0];
		}
		return $admininfo;
	}
	//会员用户信息
	public function userinfo()
	{

	}
	function getIP(){
		global $ip;
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = "Unknow IP";
		return $ip;
	}
	function getIPLoc_sina($queryIP){ 

		$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP; 
		$ch = curl_init($url); 

		//curl_setopt($ch,CURLOPT_ENCODING ,'utf8'); 

		curl_setopt($ch, CURLOPT_TIMEOUT, 10); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 

		$location = curl_exec($ch); 

		$location = json_decode($location); 

		curl_close($ch); 

		 

		$loc = ""; 

		if($location===FALSE) return ""; 

		if (empty($location->desc)) { 

			$loc = $location->province.$location->city.$location->district.$location->isp; 

		}else{ 

			$loc = $location->desc; 

		} 

		return $loc; 

	} 
}
?>