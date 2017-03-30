<?php
namespace app\home\model;

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
		//var_dump($data);exit;
		//dump(Cache::get('login')); exit;
		//Cache::clear();  exit;
		//$stime=microtime(true);
		$map['tu_id'] = htmlspecialchars($data['tu_id']);//htmlspecialchars 大于和小于转化为html实体
		$result = Db::table('ike_user')
						->where($map)
						->select();
		$result=reset($result);

		
		
		
		//$data = \think\Cache::get();
		//var_dump($data);exit;
		//$user = User::get(1);
		//$result=Db::query('select * from ike_User where id=1');
		//echo User::getLastSql();EXIT;
		//var_dump($result);exit;

		if(empty($result) || $result['status']==0 || $result['password'] !== md5($data['password'])){
			if(empty($result)){
				$this->error='账号不存在';

				return false;
			}elseif($result['status']==0){
				$this->error='账号已禁止，请联系管理员';
				return false;

			}elseif($result['password'] !== md5($data['password'])){
				$this->error='密码出错，请重新输入';

				return false;
			}
			
		}
		unset($result['password']);
		Db::table('ike_user')
			 ->where('tu_id',$result['tu_id'])
			 ->update(['login_time'=>date('Y-m-d H:i:s',time()) ,'login_ip'=>$this->getIP,'count'=>$result['count']+1]);

		//$etime=microtime(true);//获取程序执行结束的时间
		//$total=$etime-$stime; 
		//echo "<br />[页面执行时间：".$total." ]秒";
		Session::set('applogin', $result);
		return $result;
	}
	/*退出登录*/
	public function logout()
	{
		$admin_id=Session::get('applogin')['tu_id'];
		Db::table('ike_admin')
			 ->where('admin_id',$admin_id)
			 ->update(['last_login_time'=>date('Y-m-d H:i:s',time())]);
		//Cache::clear(); 
		Session::delete(Config::get('USER_AUTH_KEY'),'login');
		Session::clear();
	}
	//管理员个人用户信息
	public function admininfo()
	{
		$user_id=Session::get('applogin')['tu_id'];
		$userinfo=Db::view('user','*')
					->view('avatar','avatar_image','avatar.avatar_id=user.avatar_id')
					->where('admin_id','=',$user_id)
					->select();
		foreach($userinfo as $k=>$v){
			$userinfo=$userinfo[0];
		}
		return $userinfo;
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