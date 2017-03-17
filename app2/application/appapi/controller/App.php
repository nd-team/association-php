<?php
	
namespace app\appapi\controller;
use think\Request;//验证validate内容
use app\common\controller\RongCloud;
use app\appapi\model\User;
use think\Db;
use think\Config;

class App 
{
	public $appKey = 'tdrvipkstdnk5';
	public $appSecret = 'qt6TWUPsWZuWOP';
	public $jsonPath = "./application/common/API/jsonsource/";
	public $RongCloud=null;
	public $UserModel=null;//保存实例化模型
	public function __construct(){
		$this->RongCloud = new RongCloud($this->appKey,$this->appSecret);
		$this->UserModel=new User;		
	}
	//禁用用户
	public function disable($tu_id)
	{
		$result = $this->RongCloud->user()->block($tu_id, '100');
		$result=json_decode($result,true);
		return $result;
	}
	//解除用户封禁
	public function unDisable($tu_id)
	{
		$result = $this->RongCloud->user()->unBlock($tu_id);
		$result=json_decode($result,true);
		return $result;
	}
	// 注册
    public function register(){
		if(!empty($_POST)){
			
			if(!isset($_POST['mobile'])){
				return json(['code'=>1000,'data'=>json(''),'msgs'=>'mobile不能为空']);
			}
			if(!isset($_POST['password'])){
				return json(['code'=>1000,'data'=>json(''),'msgs'=>'password不能为空']);
			}
			if(!isset($_POST['recommendId'])){
				return json(['code'=>1000,'data'=>json(''),'msgs'=>'recommendId不能为空']);
			}
			$tu_id=trim($_POST['mobile']);
			$nickname=trim($_POST['nickname']);
			$userid=trim($_POST['recommendId']);
			$check_recommend=$this->UserModel->check_recommend($_POST['mobile'],$_POST['recommendId']);
			if(!$check_recommend){
				return json(['code'=>1000,'data'=>json(''),'msgs'=>'推荐信息不存在']);
				exit();
			}
			//var_dump($check_recommend);exit;
			//检查用户号码是否存在
			$check_user=$this->UserModel->check_user(trim($_POST['mobile']));
			if($check_user==1){
				return json(['code'=>0,'data'=>json(''),'msgs'=>'用户不存在']);
				exit(0);
			}
			$result = $this->RongCloud->user()->getToken($tu_id, $nickname, '/public/effect/assets/avatars/avatar.jpg');
			$result=json_decode($result,true);
			if($result['userId']==$_POST['mobile']){
				$_POST['mobile']=$result['userId'];
				$_POST['token']=$result['token'];
				$adduser=$this->UserModel->register($_POST);
				if($adduser==1){
					//所以用户id
					$users=$this->users($result['userId']);
					//$this->RongCloud->message()->PublishSystem('00001',$users, 'RC:TxtMsg',"{\"content\":\"有新用户注册，可以去认领好友了哦~_~\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '0', '0');
					return json(['code'=>200,'data'=>json(''),'msgs'=>'注册成功']);
				}else{
					return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
				}
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}

	}
	//推荐用户注册
	public function friendsRecommend()
	{
		if(!empty($_POST)){
			$where['tu_id']=$_POST['mobile'];
			$checkUser=Db::table('ike_user')
						->where($where)
						->select();
			if($checkUser)
			{
				return json(['code'=>100,'data'=>json(''),'msgs'=>'用户不存在']);
				exit();
			}
			$result=$this->UserModel->friendsRecommend($_POST);
			if($result)
			{
				if($result=='error'){
					return json(['code'=>300,'data'=>json(''),'msgs'=>'推荐信息不存在']);
				}else{
					return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
				}
				
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//获取当前用户推荐列表（已推荐）
	public function allRecommendsUsers()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->allRecommendsUsers($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//个人信息查看(推荐信息）
	public function selectRecommendInfo()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->selectRecommendInfo($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//修改个人信息(推荐信息）
	public function editRecommendInfo()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->editRecommendInfo($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//所以用户id（排除注册者和系统用户）
	public function users($userid)
	{
		$result=Db::table('ike_user')
				->where("tu_id not in('00001','".$userid."')")
				->field('tu_id')
				->select();
		$users=array();
		foreach($result as $k=>$v)
		{
			$users[$k]=$v['tu_id'];
		}
		return $users;
	}
	//登录
	
	public function login()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->login($_POST);
			if(!empty($result['tu_id'])){
				$data=array();
				$data['userId']=$result['tu_id'];
				$data['numberId']=$result['userid'];
				$data['nickname']=$result['nickname'];
				$data['token']=$result['token'];
				$data['userPortraitUrl']=$result['avatar_image'];
				$data['sex']=$result['sex'];
				$data['mobile']=$result['mobile'];
				$data['address']=$result['address'];
				$data['birthday']=$result['birth_date'];
				$data['email']=$result['email'];
				$data['age']=$result['age'];
				$data['recommendUserId']=$result['recommendUserId'];
				$data['claimUserId']=$result['claimUserId'];
				return json(['code'=>200,'data'=>$data,'msgs'=>'成功']);
			}elseif($result==0){
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}elseif($result==1000){
				return json(['code'=>1000,'data'=>json(''),'msgs'=>'禁止登录']);
			}elseif($result==1001){
				return json(['code'=>1001,'data'=>json(''),'msgs'=>'密码错误']);
			}
			
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}	
	
	//查询好友
	
	public function lookupUser()
	{
		//$result=$this->UserModel->addfriends('13025304562');
		//var_dump($result);exit;
		if(!empty($_POST)){
			//$result = $this->RongCloud->push()->broadcastPush(file_get_contents($this->jsonPath.'PushMessage.json'));
			$result=$this->UserModel->lookupUser($_POST['userId']);
			if($result){
				$data=array();
				$data['userId']=$result['tu_id'];
				$data['nickname']=$result['nickname'];
				$data['userPortraitUrl']=$result['avatar_image'];
				return json(['code'=>200,'data'=>$data,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//添加好友--发送请求
	public function addfriendRequest()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->addfriendRequest($_POST);
			if($result==11){
				return json(['code'=>11,'data'=>json(''),'msgs'=>'好友已存在']);
			}elseif($result==200){
				//TxtMsg 文本  VcMsg语言
				//发送系统消息
				//$this->RongCloud->message()->PublishSystem($_POST['userid'], $_POST['friendUserid'], 'RC:TxtMsg',"{'content':'".$_POST['addFriendMessage']."'}", 'thisisapush');
				$this->RongCloud->message()->PublishSystem($_POST['userId'], $_POST['friendUserid'], 'RC:ContactNtf',"
				{\"operation\":\"op1\",\"sourceUserId\":\"".$_POST['userId']."\",\"targetUserId\":\"".$_POST['friendUserid']."\",\"message\":\"haha\",\"extra\":\"helloExtra\"}
				
				", 'thisisapush', '{\"pushData\":\"hello\"}', '0', '0');
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}elseif($result==100){
				return json(['code'=>0,'data'=>json(''),'msgs'=>'申请失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//获取申请添加用户(未读)
	public function allUnreadFriends()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->allUnreadFriends($_POST);
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有好友申请']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	//获取申请添加用户(all)
	public function allAddfriendRequest()
	{
		if(!empty($_POST)){
			
			$result=$this->UserModel->allAddfriendRequest($_POST);
			//var_dump($result)
			if($result){
				$data=array();
				foreach($result as $k=>$v){
					$data[$k]['userId']=$v['tu_id'];
					$data[$k]['addFriendMessage']=$v['note'];
					$data[$k]['nickname']=$v['nickname'];
					$data[$k]['addtime']=$v['addtime'];
					$data[$k]['userPortraitUrl']=$v['avatar_image'];
					$data[$k]['status']=$v['status'];					
					$data[$k]['mobile']=$v['mobile'];					
					$data[$k]['email']=$v['email'];					
				}		
				return json(['code'=>200,'data'=>$data,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//确认添加好友
	public function confirmFriend()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->confirmFriend($_POST);
			if($result==200){
				//发送单聊消息
				$this->RongCloud->message()->publishPrivate($_POST['userId'], $_POST['friendUserId'], 'RC:TxtMsg',"{'content':'添加好友成功，你们现在可以聊天了'}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0');
				$where['tu_id']=$_POST['friendUserId'];
				$data=Db::view('user')
						->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
						->where('tu_id',$_POST['friendUserId'])
						->select();
				$data=reset($data);
				$datas['userId']=$data['tu_id'];
				$datas['nickname']=$data['nickname'];
				$datas['userPortraitUrl']=$data['avatar_image'];
				$datas['displayName']='';
				$datas['mobile']=$data['mobile'];
				$datas['email']=$data['email'];
				return json(['code'=>200,'data'=>$datas,'msgs'=>'成功']);
			}elseif($result==101){
				return json(['code'=>101,'data'=>json(''),'msgs'=>'已是好友']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//删除好友
	public function deleteUser()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->deleteUser($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'删除失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//好友列表
	public function friends(){
		if(!empty($_POST)){
			$result=$this->UserModel->friends($_POST);
			if($result){
				$data=array();
				foreach($result as $k=>$v){
					$data[$k]['userId']=$v['tu_id'];
					$data[$k]['nickname']=$v['nickname'];	
					$data[$k]['userPortraitUrl']=$v['avatar_image'];					
					$data[$k]['mobile']=$v['mobile'];
					$data[$k]['email']=$v['email'];
					$data[$k]['displayName']=$v['displayname'];
					
				}
				return json(['code'=>200,'data'=>$data,'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有好友']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//添加群组
	public function createGroup()
	{
		if(!empty($_POST)){
			$hobby='';
			if(!empty($_POST['hobbyId']))
			{
				$checkCreditScore=$this->UserModel->reputationStatistics($_POST['userId']);
				if($checkCreditScore<200)
				{
					return json(['code'=>100,'data'=>json(''),'msgs'=>'创建兴趣群信誉值不够']);exit();
				}else{
					$hobby=$_POST['hobbyId'];
				}
				
			}
			$check_group_no=$this->UserModel->check_group_no();
			if($check_group_no){
				$group_users=json_decode($_POST['groupUser'],true);
				$group_no=$check_group_no;	
				//创建群
				$result = $this->RongCloud->group()->create($group_users,$group_no, $_POST['groupName']);
				if($result){					
					$file = request()->file('file');
					if(!empty($file)){
						// 移动到应用根目录/public/uploads/ 目录下
						$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
						if($info){
							$path['avatar_image']='/public/uploads/app/'.$info->getFilename();
							$upfile=Db::table('ike_avatar')
									->insert($path);
							$avatar_id=Db::table('ike_avatar')->getLastInsID();
						}else{
							$avatar_id=1;//1位公共图片
						}
					}else{
						$avatar_id=1;
					}				
					$_POST['avatar_id']=$avatar_id;
					$create_group=$this->UserModel->createGroup($_POST,$group_no,$group_users,$hobby);
					if($create_group){
						$groupId['groupId']=$group_no;
						//发送群组消息方法
							$this->RongCloud->message()->publishGroup('00001',$group_no, 'RC:TxtMsg',"{\"content\":\"可以在群聊天了\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '1', '1');
						return json(['code'=>200,'data'=>$groupId,'msgs'=>'成功']);
					}else{
						return json(['code'=>0,'data'=>json(''),'msgs'=>'创建失败']);
					}
				}else{
					return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
				}
			}else{
				$this->createGroup($_POST);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//添加群管理员
	public function vicePrincipal()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->vicePrincipal($_POST);
			if($result==200)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}elseif($result==101){
				return json(['code'=>101,'data'=>json(''),'msgs'=>'用户已是群管理员']);
			}elseif($result==102){
				return json(['code'=>102,'data'=>json(''),'msgs'=>'副群主已存在']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'添加失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//用户所在群（all）
	public function groupData()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->groupData($_POST);
			if($result)
			{
				
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else
			{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有群']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//群组信息
	public function groupInfo()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->groupInfo($_POST);
			if($result)
			{
				$data['groupId']=$result['group_number'];
				$data['groupName']=$result['group_name'];
				$data['groupPortraitUri']=$result['avatar_image'];
				$data['role']=$result['role'];
				return json(['code'=>200,'data'=>$data,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//群成员
	public function groupMember()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->groupMember($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	
	//修改群信息
	public function changeGroupName()
	{
		if(!empty($_POST))
		{
			
			$checkGroup=$this->UserModel->group_no_info($_POST['groupId']);
			if(!$checkGroup)
			{
				return json(['code'=>0,'data'=>array(),'msgs'=>'群不存在']);
			}
			$where['tu_id']=$_POST['userId'];
			$where['group_id']=$checkGroup['group_id'];
			$check_user=Db::table('ike_group_user')
						->where($where)
						->select();
			if($check_user){
				$check_user=reset($check_user);
				if(!$check_user['status'])
				{
					return json(['code'=>100,'data'=>json(''),'msgs'=>'用户不是群管理']);
				}
				$file = request()->file('file');
				if(!empty($file))
				{
					$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
					if($info){
						$path['avatar_image']='/public/uploads/app/'.$info->getFilename();
						$upfile=Db::table('ike_avatar')
								->insert($path);
						$avatar_id=Db::table('ike_avatar')->getLastInsID();
					}
				}else{
					$avatar_id='';
				}	
				$_POST['avatar_id']=$avatar_id;
				$result=$this->UserModel->changeGroupName($_POST);
				if($result)
				{
					if(!empty($_POST['groupName']))
					{
						// 刷新群组信息方法(融云)
						$this->RongCloud->group()->refresh($_POST['groupId'],$_POST['groupName']);
					} 
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}else{
					return json(['code'=>0,'data'=>json(''),'msgs'=>'修改失败']);
				}
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'用户不存在']);
			}
			
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//修改个人群昵称
	public function changeUserName()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->changeUserName($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'修改失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//拉人进入群
	public function GroupPullUser()
	{
		if(!empty($_POST))
		{
			$group_user=json_decode($_POST['groupUser'],true);
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$group_users=$this->UserModel->GroupPullUser($group_user,$group_info['group_id'],$_POST['userId']);
			if($group_users){
				$result = $this->RongCloud->group()->join($group_users,$_POST['groupId'],$group_info['group_name'],$_POST['userId']);
				if($result)
				{
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	
	//群主审核加人人员列表
	public function groupAuditingAllUser()
	{
		if(!empty($_POST)){
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$result=$this->UserModel->groupAuditingAllUser($group_info['group_id'],$_POST['userId']);
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	//群主审核加人人员（是否同意）
	public function groupAuditingUsers()
	{
		if(!empty($_POST)){
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$result=$this->UserModel->groupAuditingUsers($group_info['group_id'],$_POST['groupUser'],$_POST['userId'],$_POST['status']);
			if($result){
				switch($result){
					case 100:
						return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
						break;
					case 200:
						return json(['code'=>100,'data'=>json(''),'msgs'=>'已拒绝']);
						break;
				}
				exit();
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//退群/解散群
	public function dissolutionGroup()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->dissolutionGroup($_POST);
			if($result==200)
			{
				// 解散群组方法(融云)
				$this->RongCloud->group()->dismiss($_POST['groupUser'],$_POST['groupId']);
				return json(['code'=>200,'data'=>json(''),'msgs'=>'解散群']);//解散群
			}elseif($result==100){
				//踢出融云群用户
				$this->RongCloud->group()->quit($_POST['groupUser'],$_POST['groupId']);
				return json(['code'=>100,'data'=>json(''),'msgs'=>'退出群']);//退群
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//修改好友名片
	public function editFriendName()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->editFriendName($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'修改失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//修改个人信息
	public function editUserInfo()
	{
		if(!empty($_POST))
		{
			//$datas=json_decode($_POST['person'],true);
			$file = request()->file('file');
			if(!empty($file))
			{
				$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
				if($info)
				{
					$path['avatar_image']='/public/uploads/app/'.$info->getFilename();
					$upfile=Db::table('ike_avatar')
							->insert($path);
					$avatar_id=Db::table('ike_avatar')->getLastInsID();
				}
			}else{
				$avatar_id='';
			}
			
			$result=$this->UserModel->editUserInfo($_POST,$avatar_id);
			if($result)
			{
				if(!empty($_POST['nickname'])){
					if(!empty($avatar_id))
					{
						$path_img=$path['avatar_image'];
					}else{
						$img=Db::view('user','*')
								->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
								->where('tu_id',$_POST['userId'])
								->select();
						$path_img=$img[0]['avatar_image'];
					}
					// 刷新用户信息方法(融云)
					$this->RongCloud->user()->refresh($_POST['userId'],$_POST['nickname'],$path_img);
				}
				$user=Db::view('user','tu_id')
						->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
						->where('tu_id',$_POST['userId'])
						->select();
				$user=reset($user);
				$avatar_image['userPortraitUrl']=$user['avatar_image'];
				return json(['code'=>200,'data'=>$avatar_image,'msgs'=>'成功']);
				//return json(['code'=>200]);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'修改失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//创建群活动
	public function foundActives()
	{
		if(!empty($_POST))
		{
			$file = request()->file('file');
			if(!empty($file))
			{
				$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
				if($info)
				{
					$path['avatar_image']='/public/uploads/app/'.$info->getFilename();
					$upfile=Db::table('ike_avatar')
							->insert($path);
					$avatar_id=Db::table('ike_avatar')->getLastInsID();
				}
			}else{
				$avatar_id=2;
			}
			//$datas=$_POST['person'];
			$_POST['avatar_id']=$avatar_id;
			$result=$this->UserModel->foundActives($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'创建失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//加入群活动
	public function joinActives()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->joinActives($_POST);
			if($result==200)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}elseif($result==100){
				return json(['code'=>100,'data'=>json(''),'msgs'=>'非法操作']);
			}elseif($result==101){
				return json(['code'=>101,'data'=>json(''),'msgs'=>'活动还未开始']);
			}elseif($result==102){
				return json(['code'=>102,'data'=>json(''),'msgs'=>'活动结束']);
			}elseif($result==103){
				return json(['code'=>103,'data'=>json(''),'msgs'=>'活动人数已满']);
			}elseif($result==104){
				return json(['code'=>104,'data'=>json(''),'msgs'=>'活动已加入']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'加入失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//群活动列表
	public function listActives()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->listActives($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//活动详情
	public function infoActives()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->infoActives($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//群主踢人
	public function kickGroupUser()
	{
		if(!empty($_POST))
		{
			$users=json_decode($_POST['users'],true);
			$group_user=$_POST['groupUserId'];
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$result=$this->UserModel->kickGroupUser($group_info['group_id'],$group_info['tu_id'],$group_user,$users);
			if($result)
			{
				//踢出融云群用户
				$this->RongCloud->group()->quit($users,$group_info['group_id']);
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']); 
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'踢人失败']); 
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//群推荐好友（邀人入群）
	public function recommendUser()
	{
		if(!empty($_POST))
		{
			$users=json_decode($_POST['friendsUsers'],true);
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$userId=$_POST['userId'];
			$result=$this->UserModel->recommendUser($group_info['group_id'],$userId,$users);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'邀人失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//群主审核群成员
	public function checkJoinUser()
	{
		if(!empty($_POST))
		{
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			if(!$group_info)
			{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
			$result=$this->UserModel->checkJoinUser($_POST,$group_info['group_id']);
			if($result==100)
			{
				return json(['code'=>1,'data'=>json(''),'msgs'=>'拒绝加入']);
			}elseif($result==200){
				return json(['code'=>2,'data'=>json(''),'msgs'=>'同意']);
			}elseif($result==300){
				return json(['code'=>3,'data'=>json(''),'msgs'=>'忽略']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//申请加入群信息(所在群)
	public function groupApplyUser()
	{
		if(!empty($_POST))
		{
			$userId=$_POST['userId'];
			$groupId=$_POST['groupId'];
			$result=$this->UserModel->groupApplyUser($groupId,$userId);
			if($result)
			{
				if($result)
				{
					if($result==100)
					{
						return json(['code'=>200,'data'=>$result,'msgs'=>'没有']);
					}else{
						return json(['code'=>200,'data'=>array(),'msgs'=>'成功']);
					}
				}else{
					return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
				}
				
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}
	}
	//申请加入群信息(所有群)
	public function allGroupApplyUser()
	{
		if(!empty($_POST))
		{
			$userId=$_POST['userId'];
			$result=$this->UserModel->allGroupApplyUser($userId);
			if($result)
			{
				if($result==100)
				{
					return json(['code'=>200,'data'=>$result,'msgs'=>'没有']);
				}else{
					return json(['code'=>200,'data'=>array(),'msgs'=>'成功']);
				}
				
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}
	}
	//投票主题创建
	public function foundVote()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->foundVote($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//投票主题列表
	public function voteList()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->voteList($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//投票主题详情
	public function voteDetails()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->voteDetails($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//投票选择
	public function voteCollect()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->voteCollect($_POST);
			if($result==200)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}elseif($result==101){
				return json(['code'=>101,'data'=>json(''),'msgs'=>'投票时间已结束']);
			}elseif($result==102){
				return json(['code'=>102,'data'=>json(''),'msgs'=>'已投票']);
			}elseif($result==103){
				return json(['code'=>103,'data'=>json(''),'msgs'=>'投票已关闭或已投票已失效']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//兴趣联盟（群）
	public function interestAlliance()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->interestAlliance($_POST);
			if($result){
				return json(['code'=>200,'data'=>json('')]);
			}else{
				return json(['code'=>0,'data'=>json('')]);
			}
		}else{
			return json(['code'=>0,'data'=>json('')]);
		}
	}
	//认领用户列表
	public function allFriendsClaim()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->allFriendsClaim($_POST,'id,fullName,mobile');
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>200,'data'=>array(),'msgs'=>'没有']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	//认领用户
	public function claimUser()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->claimUser($_POST);
			if($result==200){
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}elseif($result==100){
				return json(['code'=>100,'data'=>json(''),'msgs'=>'已认领']);
			}elseif($result==101){
				return json(['code'=>101,'data'=>json(''),'msgs'=>'认领已回答，等待对方审核']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//显示需确认认领用户
	public function allClaimConfirm()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->allClaimConfirm($_POST);
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	//认领用户确认（问题正确未达到10个）
	public function claimConfirm()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->claimConfirm($_POST);
			if($result){
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//关系网图谱（直接关系）
	public function directNexusChart()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->directNexusChart($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	/*
	//关系图谱(间接关系)
	public function indirect_nexus_chart()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->indirect_nexus_chart($_POST);
			if($result)
			{
				return json(['code'=>200,'msg'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	*/
	
	//查看更多个人详情信息
	public function selectMoreUserInfo()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->selectMoreUserInfo($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//更多个人详情信息（设置个人信息）
	public function editMoreUserInfo()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->editMoreUserInfo($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'修改失败']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	//查看对方信息（基本信息）
	public function selectUserInfo()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->selectUserInfo($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//产品众筹
	public function productCollect()
	{
		if(!empty($_POST))
		{
			$checkUser=Db::table('ike_user')
						->where('tu_id',$_POST['userId'])
						->select();
			//echo Db::getLastSql();exit;
			if($checkUser){
				$file = request()->file('file');
				if(!empty($file))
				{
					$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
					if($info){
						$path['avatar_image']='/public/uploads/app/'.$info->getFilename();
						$upfile=Db::table('ike_avatar')
								->insert($path);
						$avatar_id=Db::table('ike_avatar')->getLastInsID();
					}
				}else{
					$avatar_id=3;
				}	
				$_POST['avatar_id']=$avatar_id;
				$result=$this->UserModel->productCollect($_POST);
				if($result)
				{
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}else{
					return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
				}
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
			
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//干货分享
	public function share()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->share($_POST);
			if($result){
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//干货分享评论
	public function shareComment()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->shareComment($_POST);
			if($result){
				if($result==200)
				{
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}elseif($result==100){
					return json(['code'=>100,'data'=>json(''),'msgs'=>'已评论']);
				}
				
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//获取干货分享所有评论
	public function allShareComment()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->allShareComment($_POST);
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//干货分享点赞
	public function sharePraise()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->sharePraise($_POST);
			if($result){
				if($result==200){
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}elseif($result==100){
					return json(['code'=>100,'data'=>json(''),'msgs'=>'已点赞']);
				}
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//干货分享举报
	public function shareReport()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->shareReport($_POST);
			if($result){
				if($result==200){
					return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
				}elseif($result==100){
					return json(['code'=>100,'data'=>json(''),'msgs'=>'已举报']);
				}
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//群公告
	public function groupNotice()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->groupNotice($_POST);
			if($result){
				return json(['code'=>200,'data'=>json(''),'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>json(''),'msgs'=>'未知错误']);
		}
	}
	
	//查看当前群公告
	public function queryGroupNotice()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->queryGroupNotice($_POST);
			if($result){
				return json(['code'=>200,'data'=>$result,'msgs'=>'成功']);
			}else{
				return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
			}
		}else{
			return json(['code'=>0,'data'=>array(),'msgs'=>'未知错误']);
		}
	}
	
	//求助中心
	//public function
	
	//灵感贩卖
	//public function
	
	//公益活动
	//public function
	
	//求助众筹
	//pubulic function
	
	//平台活动
	//public function
	
	//签到有奖
	//public function
	
	//分享膜拜
	//public function
	
	//1元夺宝
	//public function
	
	//我的经验值与贡献值
	//public function
	
	//我要反馈
	//public function
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
