<?php
	
namespace app\appapi\controller;
use think\Request;//验证validate内容
use app\common\controller\RongCloud;
use app\appapi\model\User;
use think\Db;

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
				return json(['code'=>1000]);
			}
			if(!isset($_POST['nickname'])){
				return json(['code'=>1000]);
			}
			if(!isset($_POST['password'])){
				return json(['code'=>1000]);
			}
			$tu_id=trim($_POST['mobile']);
			$nickname=trim($_POST['nickname']);
			$check_user=$this->UserModel->check_user(trim($_POST['mobile']));
			if($check_user==1){
				return json(['code'=>0]);
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
					return json(['code'=>200]);
				}else{
					return json(['code'=>1000]);
				}
			}
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
				$data['nickname']=$result['nickname'];
				$data['token']=$result['token'];
				$data['userPortraitUrl']=$result['avatar_image'];
				$data['sex']=$result['sex'];
				$data['birth_date']=$result['birth_date'];
				$data['age']=$result['age'];
				$data['address']=$result['address'];
				$data['email']=$result['email'];
				$data['mobile']=$result['mobile'];
				return json(['code'=>200,'data'=>$data]);
			}elseif($result==0){
				return json(['code'=>0]);
			}elseif($result==1000){
				return json(['code'=>1000]);
			}elseif($result==1001){
				return json(['code'=>1001]);
			}
			
		}
	}	
	
	//查询好友
	
	public function addfriends()
	{
		//$result=$this->UserModel->addfriends('13025304562');
		//var_dump($result);exit;
		if(!empty($_POST)){
			//$result = $this->RongCloud->push()->broadcastPush(file_get_contents($this->jsonPath.'PushMessage.json'));
			$result=$this->UserModel->addfriends($_POST['userId']);
			if($result){
				$data=array();
				if($result!=100){
					$data['userId']=$result['tu_id'];
					$data['nickname']=$result['nickname'];
					$data['userPortraitUrl']=$result['avatar_image'];
				}				
				return json(['code'=>200,'data'=>$data]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	//添加好友--发送请求
	public function addfriend_request()
	{
		if(!empty($_POST)){
			
			$result=$this->UserModel->addfriend_request($_POST);
			if($result==11){
				return json(['code'=>11]);
			}elseif($result==200){
				//TxtMsg 文本  VcMsg语言
				//发送系统消息
				//$this->RongCloud->message()->PublishSystem($_POST['userid'], $_POST['f_userid'], 'RC:TxtMsg',"{'content':'".$_POST['addFriendMessage']."'}", 'thisisapush');
				$this->RongCloud->message()->PublishSystem($_POST['userId'], $_POST['f_userid'], 'RC:ContactNtf',"
				{\"operation\":\"op1\",\"sourceUserId\":\"".$_POST['userId']."\",\"targetUserId\":\"".$_POST['f_userid']."\",\"message\":\"haha\",\"extra\":\"helloExtra\"}
				
				", 'thisisapush', '{\"pushData\":\"hello\"}', '0', '0');
				return json(['code'=>200]);
			}elseif($result==100){
				return json(['code'=>0]);
			} 
		}
	}
	//获取申请添加用户(未读)
	public function all_unread_friends()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->all_unread_friends($_POST);
			if($result){
				if($result!=100){
					return json(['code'=>200,'data'=>$result]);
				}else{
					$data=array();
					return json(['code'=>200,'data'=>$data]);
				}
				
			}else{
				return json(['code'=>0]);
			}
		}
	}
	//获取申请添加用户(all)
	public function all_addfriend_request()
	{
		if(!empty($_POST)){
			
			$result=$this->UserModel->all_addfriend_request($_POST);
			//var_dump($result)
			if($result){
				$data=array();
				if($result!=100){
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
				}						
				return json(['code'=>200,'data'=>$data]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//确认添加好友
	public function confirm_friend()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->confirm_friend($_POST);
			if($result==200){
				//发送单聊消息
				$this->RongCloud->message()->publishPrivate($_POST['userId'], $_POST['f_userid'], 'RC:TxtMsg',"{'content':'添加好友成功，你们现在可以聊天了'}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0');
				$where['tu_id']=$_POST['f_userid'];
				$data=Db::view('user')
						->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
						->where('tu_id',$_POST['f_userid'])
						->select();
				$data=reset($data);
				$datas['userId']=$data['tu_id'];
				$datas['name']=$data['nickname'];
				$datas['userPortraitUrl']=$data['avatar_image'];
				$datas['displayName']='';
				$datas['mobile']=$data['mobile'];
				$datas['email']=$data['email'];
				return json(['code'=>200,'data'=>$datas]);
			}elseif($result==1000){
				//发送系统消息
				$this->RongCloud->message()->PublishSystem($_POST['userId'], $_POST['f_userid'], 'RC:TxtMsg',"{'content':'对方已拒绝'}", 'thisisapush', '{\"pushData\":\"hello\"}', '0', '0');
				return json(['code'=>1000]);
			}elseif($result==2000){
				return json(['code'=>2000]);
			}elseif($result==101){
				return json(['code'=>0]);
			}
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
				return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//好友列表
	public function friends(){
		if(!empty($_POST)){
			$result=$this->UserModel->friends($_POST);
			if($result){
				$data=array();
				if($result!=100){
					foreach($result as $k=>$v){
						$data[$k]['userId']=$v['tu_id'];
						$data[$k]['name']=$v['nickname'];	
						$data[$k]['userPortraitUrl']=$v['avatar_image'];					
						$data[$k]['mobile']=$v['mobile'];
						$data[$k]['email']=$v['email'];
						$data[$k]['displayName']=$v['displayname'];
					}
				}
				return json(['code'=>200,'data'=>$data]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//添加群组
	public function create_group()
	{
		
		if(!empty($_POST)){
			$check_group_no=$this->UserModel->check_group_no();
			if($check_group_no){
				@$group_users=json_decode($_POST['groupUser'],true);
				if(!$group_users)
				{
					return json(['code'=>0]);
				}
				$group_no=$check_group_no;	
				//创建群
				///$group_users=array('13025304562','18819493903');
				//var_dump($_POST);EXIT;
				$result = $this->RongCloud->group()->create($group_users,$group_no,$_POST['groupName']);
				if($result){
					$file = request()->file('file');
					if(!empty($file)){
							// 移动到应用根目录/public/uploads/ 目录下
						$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
						if($info){
							$path['avatar_image']='/public/uploads/app/'.$info->getSaveName();
							$upfile=Db::table('ike_avatar')
									->insert($path);
							$avatar_id=Db::table('ike_avatar')->getLastInsID();
						}else{
							$avatar_id=1;//1位公共图片
						}
						
					}else{
						$avatar_id=1;//1位公共图片
					}	
					$_POST['avatar_id']=$avatar_id;
					$create_group=$this->UserModel->create_group($_POST,$group_no,$group_users);			
					if($create_group){
						//发送群组消息方法
						$this->RongCloud->message()->publishGroup('00001',$group_no, 'RC:TxtMsg',"{\"content\":\"可以在群聊天了\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '1', '1');
						$datas=array();
						$datas['groupId']=$group_no;
						$datas['avatar_image']=$create_group;
						return json(['code'=>200,'data'=>$datas]);
					}else{
						return json(['code'=>0,'data'=>'创建失败']);
					}
				}else{
					return json(['code'=>0]);
				}
				
			}else{
				$check_group_no=$this->UserModel->check_group_no();
			}
		}
	}
	
	//用户所在群（all）
	public function group_data()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->group_data($_POST);
			//var_dump($result);exit;
			if($result)
			{
				if($result==100){
					$data=array();
					return json(['code'=>200,'data'=>$data]);
				}else{
					return json(['code'=>200,'data'=>$result]);
				}
				
			}else
			{
				return json(['code'=>0]);
			}
		}
	}
	
	//群组信息
	public function group_info()
	{
		if(!empty($_POST)){
			$result=$this->UserModel->group_info($_POST);
			if($result)
			{
				$data['groupId']=$result['group_number'];
				$data['groupName']=$result['group_name'];
				$data['groupPortraitUrl']=$result['avatar_image'];
				$data['role']=$result['role'];
				return json(['code'=>200,'data'=>$data]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//群成员
	public function group_member()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->group_member($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	
	//修改群信息
	public function change_groupName()
	{
		if(!empty($_POST))
		{
			$file = request()->file('file');
			if(!empty($file))
			{
				$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
				if($info){
					$path['avatar_image']='/public/uploads/app/'.$info->getSaveName();
					$upfile=Db::table('ike_avatar')
							->insert($path);
					$avatar_id=Db::table('ike_avatar')->getLastInsID();
				}
			}else{
				$avatar_id='';
			}	
			$_POST['avatar_id']=$avatar_id;
			$result=$this->UserModel->change_groupName($_POST);
			if($result)
			{
				if(!empty($_POST['groupName']))
				{
					// 刷新群组信息方法(融云)
					$this->RongCloud->group()->refresh($_POST['groupId'],$_POST['groupName']);
				} 
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//修改个人群昵称
	public function change_userName()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->change_userName($_POST);
			if($result)
			{
				return json(['code'=>200]);
			}
		}
	}
	
	//群主拉人
	public function GroupPullUser()
	{
		if(!empty($_POST))
		{
			$group_user=json_decode($_POST['groupUser'],true);
			$group_info=$this->UserModel->group_no_info($_POST['groupId']);
			$group_users=$this->UserModel->GroupPullUser($group_user,$group_info['group_id']);
			$result = $this->RongCloud->group()->join($group_users,$_POST['groupId'],$group_info['group_name']);
			if($result)
			{
				return json(['code'=>200]);
			}
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
				return json(['code'=>200]);//解散群
			}elseif($result==100){
				//踢出融云群用户
				$this->RongCloud->group()->quit($_POST['groupUser'],$_POST['groupId']);
				return json(['code'=>100]);//退群
			}else{
				return json(['code'=>0]);
			}
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
				return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//修改个人信息
	public function editUserInfo()
	{
		if(!empty($_POST))
		{
			//$datas=json_decode($_POST['person'],true);
			//var_dump($_FILES);EXIT;
			$file = request()->file('file');
			if(!empty($file))
			{
				$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'app');
				if($info)
				{
					$path['avatar_image']='/public/uploads/app/'.$info->getSaveName();
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
				$user=Db::view('user','tu_id')
						->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
						->where('tu_id',$_POST['userId'])
						->select();
				$user=reset($user);
				if(!empty($_POST['nickname'])){
					if(!empty($avatar_id))
					{
						$path_img=$path['avatar_image'];
					}else{
						$path_img=$user['avatar_image'];
					}
					// 刷新用户信息方法(融云)
					$this->RongCloud->user()->refresh($_POST['userId'],$_POST['nickname'],$path_img);
				}
				$avatar_image['avatar_image']=$user['avatar_image'];
				return json(['code'=>200,'data'=>$avatar_image]);
				//return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
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
					$path['avatar_image']='/public/uploads/app/'.$info->getSaveName();
					$upfile=Db::table('ike_avatar')
							->insert($path);
					$avatar_id=Db::table('ike_avatar')->getLastInsID();
				}
			}else{
				$avatar_id=2;
			}
			$_POST['avatar_id']=$avatar_id;
			$result=$this->UserModel->foundActives($_POST);
			if($result)
			{
				return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
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
				return json(['code'=>200]);
			}elseif($result==100){
				return json(['code'=>100]);
			}elseif($result==101){
				return json(['code'=>101]);
			}elseif($result==102){
				return json(['code'=>102]);
			}elseif($result==103){
				return json(['code'=>103]);
			}elseif($result==104){
				return json(['code'=>104]);
			}else{
				return json(['code'=>0]);
			}
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
				if($result==100){
					$data=array();
					return json(['code'=>200,'data'=>$data]);
				}else{
					return json(['code'=>200,'data'=>$result]);
				}
				
			}else{
				return json(['code'=>0]);
			}
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
				return json(['code'=>200,'data'=>$result]);
			}else{
				return 0;
			}
		}
	}
	
	//群主踢人
	public function kickGroupUser()
	{
		if(!empty($_POST))
		{
			
			$users=json_decode($_POST['users'],true);
			$group_user=$_POST['group_user'];
			$group_info=$this->UserModel->group_no_info($_POST['group_id']);
			$result=$this->UserModel->kickGroupUser($group_info['group_id'],$group_info['tu_id'],$group_user,$users);
			if($result)
			{
				//踢出融云群用户
				$this->RongCloud->group()->quit($users,$group_info['group_id']);
				return json(['code'=>200]); 
			}else{
				return json(['code'=>0]); 
			}
		}
	}
	
	//群推荐好友
	public function recommendUser()
	{
		if(!empty($_POST))
		{
			$users=json_decode($_POST['f_users'],true);
			$group_info=$this->UserModel->group_no_info($_POST['group_id']);
			$userId=$_POST['userId'];
			$result=$this->UserModel->recommendUser($group_info['group_id'],$userId,$users);
			if($result)
			{
				return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//群主审核群成员
	public function check_join_user()
	{
		if(!empty($_POST))
		{
			$group_info=$this->UserModel->group_no_info($_POST['group_id']);
			$result=$this->UserModel->check_join_user($_POST,$group_info['group_id']);
			if($result==100)
			{
				return json(['code'=>1]);
			}elseif($result==200){
				return json(['code'=>2]);
			}elseif($result==300){
				return json(['code'=>3]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//申请加入群信息(所在群)
	public function group_apply_user()
	{
		if(!empty($_POST))
		{
			$userId=$_POST['userId'];
			$groupId=$_POST['group_id'];
			$result=$this->UserModel->group_apply_user($groupId,$userId);
			if($result)
			{
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	//申请加入群信息(所有群)
	public function all_group_apply_user()
	{
		if(!empty($_POST))
		{
			$userId=$_POST['userId'];
			$result=$this->UserModel->all_group_apply_user($userId);
			if($result)
			{
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	//投票主题创建
	public function found_vote()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->found_vote($_POST);
			if($result)
			{
				return json(['code'=>200]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//投票主题列表
	public function vote_list()
	{
		if(!empty($_POST))
		{
			
			$result=$this->UserModel->vote_list($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//投票主题详情
	public function vote_details()
	{
		if(!empty($_POST))
		{
			
			$result=$this->UserModel->vote_details($_POST);
			if($result)
			{
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//投票选择
	public function vote_collect()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->vote_collect($_POST);
			if($result==200)
			{
				return json(['code'=>200]);
			}elseif($result==101){
				return json(['code'=>101]);
			}elseif($result==102){
				return json(['code'=>102]);
			}elseif($result==103){
				return json(['code'=>103]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	/*
	//认领用户列表
	public function all_friends_claim()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->all_friends_claim($_POST);
			if($result){
				return json(['code'=>200,'data'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	//认领用户
	public function claim_user()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->claim_user($_POST);
			if($result==200){
				return json(['code'=>200]);
			}elseif($result==100){
				return json(['code'=>100]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	
	//申请加入群(未)
	public function application_group()
	{
		if(!empty($_POST))
		{
			$result=$this->UserModel->application_group($_POST);
			if($result)
			{
				return json(['code'=>200,'msg'=>$result]);
			}else{
				return json(['code'=>0]);
			}
		}
	}
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
