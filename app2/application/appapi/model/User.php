<?php
namespace app\appapi\model;

use \think\Model;
use think\Db;

class User extends Model
{
	//查询会员个人信息
	/*
	**$tu_id   用户id（电话号码）
	**
	**/
	public function userinfo($tu_id)
	{
		$where['tu_id']=$tu_id;
		$result = Db::view('user')
					->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		$result=reset($result);
		return $result;
	}
	
	//检查会员是否存在	
	/*
	**$tu_id  用户id（电话号码）
	**
	**/
	public function check_user($tu_id)
	{
		$where['tu_id']=$tu_id;
		$result = Db::table('ike_user')
						->where($where)
						->select();
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	
	//会员注册
	public function register(array $data)
	{	
		$datas=array();
		$datas['tu_id']=trim($data['mobile']);
		$datas['userid']=trim($data['recommendId']);
		$datas['token']=$data['token'];		
		$datas['nickname']=trim($data['nickname']);
		$datas['password']=md5($data['password']);
		$datas['mobile']=trim($data['mobile']);
		$datas['gen_time']=date('Y-m-d H:i:s',time());
		$result=Db::table('ike_user')
					->insert($datas);
		if($result){	
			Db::table('ike_recommend_content')
			->where('tu_id',$data['mobile'])
			->update(['status'=>1]);
			return 1;			
		}else{
			return 0;
		}	
	}
	//获取所有用户信息
	/*
	 *$user  获取所需字段
	 *
	 **/
	public function all_user_field($user='*')
	{
		$result=Db::table('ike_user')
					->field($user)
					->select();
		$datas=array();
		foreach($result as $k=>$v)
		{
			$datas[$k]=$v['tu_id'];
		}
		return $datas;
	}
	
	//检查注册用户是否推荐信息一致
	/*
	**$mobile  推荐电话号码
	**$userid  推荐码
	**
	**/
	public function check_recommend($mobile,$recommendId)
	{
		$where['mobile']=$mobile;
		$where['recommendId']=$recommendId;
		$result=Db::table('ike_recommend_content')
				->where($where)
				->select();
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//推荐用户注册
	public function friendsRecommend(array $data)
	{
		if(!is_numeric($data['userId']))
		{
			return 0;
		}
		$where['tu_id']=$data['userId'];
		$userinfo=Db::table('ike_user')
					->where($where)
					->select();
		if($userinfo)
		{
			$userinfo=reset($userinfo);
			$check['mobile']=$data['mobile'];
			$checkRecommendsUsers=Db::table('ike_recommend_content')
							->field('mobile')
							->where($check)
							->select();
			if($checkRecommendsUsers)
			{
				return 'error';
			}

				$datas=array();
				//真实姓名
				if(empty($data['fullName']))
				{
					return 0;
				}else{
					$datas['fullName']=$data['fullName'];
				}
				//电话
				if(empty($data['mobile']))
				{
					return 0;
				}else{
					$datas['mobile']=$data['mobile'];
				}
				
				//性别
				if(empty($data['sex']))
				{
					return 0;
				}else{
					$datas['sex']=$data['sex'];
				}
				
				
				//爱好
				if(empty($data['hobby']))
				{
					return 0;
				}else{
					$datas['hobby']=$data['hobby'];
				}
				//地址
				if(empty($data['address']))
				{
					return 0;
				}else{
					$address=json_decode($data['address'],true);
					if(count($address)!=4){
						return 0;
					}
					$in_address['tu_id']=$data['mobile'];
					$in_address['first_stage']=$address[0];
					$in_address['second_stage']=$address[1];
					$in_address['third_stage']=$address[2];
					$in_address['address']=$address[3];
					$insertAddress=Db::table('ike_recommend_address')
									->insert($in_address);
					if($insertAddress)
					{
						$datas['address_id']=Db::getLastInsID();
					}else{
						return 0;
					}
				}
				
				//信誉分
				if(empty($data['creditScore']))
				{
					return 0;
				}else{
					$datas['creditScore']=$data['creditScore'];
				}
				//两者关系
				if(!empty($data['relationship']))
				{
					$relationship['relationship']=$data['relationship'];
					$relationship['tu_id']=$data['userId'];
					$relationship['friend_id']=$data['mobile'];
				}else{
					return 0;
				}
				//生日
				if(!empty($data['birthday']))
				{
					$datas['birthday']=$data['birthday'];
				}
				
				//籍贯（选填）
				if(!empty($data['homeplace']))
				{
					$datas['homeplace']=$data['homeplace'];
				}
				//性格（选填）
				if(!empty($data['character']))
				{
					$datas['character']=$data['character'];
				}
				//毕业学校（选填）
				if(!empty($data['finishSchool']))
				{
					$datas['finishSchool']=$data['finishSchool'];
				}
				//公司（选填）
				if(!empty($data['company']))
				{
					$datas['company']=$data['company'];
				}
				//父亲姓名（选填）
				if(!empty($data['fatherName']))
				{
					$datas['fatherName']=$data['fatherName'];
				}
				//母亲姓名（选填）
				if(!empty($data['motherName']))
				{
					$datas['motherName']=$data['motherName'];
				}
				//婚姻状况（选填）
				if(isset($data['marriage']))
				{
					if($data['marriage']!="")
					{
						if($data['marriage']==1)
						{
							$datas['marriage']=1;
							//对方配偶姓名（选填）
							if(!empty($data['spouseName']))
							{
								$datas['spouseName']=$data['spouseName'];
							}
							//子女姓名（选填）
							if(!empty($data['childrenName']))
							{
								$datas['childrenName']=$data['childrenName'];
							}
							//子女就读学校（选填）
							if(!empty($data['childrenSchool']))
							{
								$datas['childrenSchool']=$data['childrenSchool'];
							}
						}else{
							$datas['marriage']=0;
						}
					}
				}
				
				$datas['tu_id']=$data['mobile'];
				$datas['userId']=$data['userId'];
				$datas['recommendId']=$userinfo['userid'].rand(1,9).rand(1,9).rand(1,9);
				$datas['status']=0;
				Db::table('ike_friends_relationship')
					->insert($relationship);
				$result=Db::table('ike_recommend_content')
						->insert($datas);
				if($result)
				{
					return array('recommendId'=>$datas['recommendId']);
				}else{
					return 0;
				}			
		}else{
			
			return 0;
		}
	}
	
	//获取当前用户推荐列表（已推荐）
	public function allRecommendsUsers(array $data)
	{
		$where['userId']=$data['userId'];
		$result=Db::table('ike_recommend_content')
				->where($where)
				->select();
		if($result){
			$datas=array();
			foreach($result as $k=>$v)
			{
				$datas[$k]['fullName']=$v['fullName'];
				$datas[$k]['mobile']=$v['mobile'];
				$datas[$k]['recommendId']=$v['recommendId'];
			}
			return $datas;
		}else{
			return 0;
		}
	}
	
	//个人信息查看(推荐信息）
	public function selectRecommendInfo(array $data)
	{
		$where['tu_id']=$data['userId'];
		$result=Db::table('ike_recommend_content')
				->where($where)
				->select();
		if($result)
		{
			$result=reset($result);
			$datas['status']=$result['status'];
			$datas['fullName']=$result['fullName'];
			$datas['mobile']=$result['mobile'];
			$datas['sex']=$result['sex'];
			$datas['hobby']=$result['hobby'];
			if(!empty($result['address_id']))
			{
				$address=Db::table('ike_recommend_address')
						->where('address_id',$result['address_id'])
						->select();
				if($address)
				{
					$address=reset($address);
					$addressInfo['firstStage']=$address['first_stage'];
					$addressInfo['secondStage']=$address['second_stage'];
					$addressInfo['thirdStage']=$address['third_stage'];
					$addressInfo['address']=$address['address'];
					$datas['address']=$addressInfo;
				}else{
					$datas['address']='';
				}
			}else{
				$datas['address']='';
			}
			$datas['birthday']=$result['birthday'];
			$datas['homeplace']=$result['homeplace'];
			$datas['finishSchool']=$result['finishSchool'];
			//$datas['degree']=$result['degree'];
			$datas['company']=$result['company'];
			$datas['position']=$result['position'];
			
			return $datas;
		}else{
			return 0;
		}
	}
	
	//修改个人信息(推荐信息）
	public function editRecommendInfo(array $data)
	{
		$recommend=Db::table('ike_recommend_content')
					->where('tu_id',$data['userId'])
					->select();
		if($recommend)
		{
			$recommend=reset($recommend);
			//--公共信息--
			//生日
			if(!empty($data['birthday']))
			{
				$datas['birthday']=$data['birthday'];
			}else{
				return 0;
			}
			//籍贯
			if(!empty($data['homeplace']))
			{
				$datas['homeplace']=$data['homeplace'];
			}else{
				$datas['motherName']='';
			}
			//毕业学校
			if(!empty($data['finishSchool']))
			{
				$datas['finishSchool']=$data['finishSchool'];
			}else{
				$datas['motherName']='';
			}
			//学历
			if(!empty($data['degree']))
			{
				$datas['degree']=$data['degree'];
			}else{
				$datas['degree']='';
			}
			//公司
			if(!empty($data['company']))
			{
				$datas['company']=$data['company'];
			}else{
				$datas['motherName']='';
			}
			
			//公司职位
			if(!empty($data['company']))
			{
				$datas['company']=$data['company'];
			}else{
				$datas['motherName']='';
			}
			
			//邮箱
			if(!empty($data['email']))
			{
				$datas['email']=$data['email'];
			}else{
				$datas['motherName']='';
			}
			
			
			//QQ
			if(!empty($data['QQ']))
			{
				$datas['QQ']=$data['QQ'];
			}else{
				$datas['motherName']='';
			}
			
			
			//微信
			if(!empty($data['wechat']))
			{
				$datas['wechat']=$data['wechat'];
			}else{
				$datas['motherName']='';
			}
			
			//父亲姓名
			if(!empty($data['fatherName']))
			{
				$datas['fatherName']=$data['fatherName'];
			}else{
				$datas['motherName']='';
			}
			
			
			//母亲姓名
			if(!empty($data['motherName']))
			{
				$datas['motherName']=$data['motherName'];
			}else{
				$datas['motherName']='';
			}
			
			
			//婚姻状况
			if(!empty($data['marriage']))
			{
				$datas['marriage']=$data['marriage'];
				//配偶姓名
				if(!empty($data['spouseName']))
				{
					$datas['spouseName']=$data['spouseName'];
				}else{
					$datas['spouseName']='';
				}
				//子女姓名
				if(!empty($data['childrenName']))
				{
					$datas['childrenName']=$data['childrenName'];
				}else{
					$datas['childrenName']='';
				}
				//子女就读学校
				if(!empty($data['childrenSchool']))
				{
					$datas['childrenSchool']=$data['childrenSchool'];
				}else{
					$datas['childrenSchool']='';
				}
			}else{
				$datas['marriage']='';
				$datas['spouseName']='';
				$datas['childrenName']='';
				$datas['childrenSchool']='';
			}
			//------公共信息结束-----
			if($recommend['status']==1)
			{
				//真实姓名
				if(!empty($data['fullName']))//必传
				{
					$datas['fullName']=$data['fullName'];
				}else{
					return 0;
				}
				//真实姓名公开和不公开（0不公开1公开）
				if($data['SfullName']==1)
				{
					$datas['SfullName']=1;
				}else{
					$datas['SfullName']=0;
				}
				//电话
				if(!empty($data['mobile']))//必传
				{
					$datas['mobile']=$data['mobile'];
				}else{
					return 0;
				}
				//性别
				if(!empty($data['sex']))//必传
				{
					$datas['sex']=$data['sex'];
				}else{
					return 0;
				}
				//爱好
				if(!empty($data['hobby']))//必传
				{
					$datas['hobby']=$data['hobby'];
				}else{
					
					return 0;
				}
				//地址
				if(!empty($data['address']))
				{
					$address=json_decode($data['address'],true);
					if(count($address)!=4){
						return 0;
					}
					$in_address['tu_id']=$data['userId'];
					$in_address['first_stage']=$address[0];
					$in_address['second_stage']=$address[1];
					$in_address['third_stage']=$address[2];
					$in_address['address']=$address[3];
					
					$insertAddress=Db::table('ike_recommend_address')
									->where('address_id',$recommend['address_id'])
									->update($in_address);
				}else{
					return 0;
				}
				
				$datas['status']=2;
				$result=Db::table('ike_recommend_content')
						->where('tu_id',$data['userId'])
						->update($datas);
				if($result)
				{
					return 200;
				}else{
					return 0;
				}
				
			}elseif($recommend['status']==2){
				$result=Db::table('ike_recommend_content')
						->where('tu_id',$data['userId'])
						->update($datas);
				if($result)
				{
					return 200;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	//登录用户
	public function login(array $data)
	{
		$where['tu_id']=trim($data['mobile']);
		$result=Db::view('user','*')
					->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		if(empty($result)){
			return 0;
		}
		@$result=reset($result);
		$recommend=Db::table('ike_recommend_content')
					->where('tu_id',$data['mobile'])
					->select();
		if(!empty($recommend)){
			$recommend=reset($recommend);
			$result['recommendUserId']=$recommend['userId'];
		}else{
			$result['recommendUserId']='';
		}		
		$claimUser=Db::table('ike_friends_claim')
					->where('tu_id',$data['mobile'])
					->select();
		if(!empty($claimUser)){
			$claimUser=reset($claimUser);
			$result['claimUserId']=$claimUser['claimUserId'];
		}else{
			$result['claimUserId']='';
		}
		if(empty($result) || $result['status']==0 || $result['password'] !== md5($data['password'])){
			if(empty($result)){
				return 0;//账号不存在
			}elseif($result['status']==0){
				return 1000;//账号禁止登录
			}elseif($result['password'] !== md5($data['password'])){
				return 1001;//密码错误
			}
		}
		// var_dump($result);exit;
		unset($result['password']);
		return $result;
	}
	
	//查询好友
	/*
	**$tu_id  用户id（电话号码）
	**
	**/
	public function lookupUser($tu_id)
	{
		$where['tu_id']=$tu_id;			

		$result=Db::view('user','*')
					->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		//echo Db::getLastSql();exit;
		@$result=reset($result);
		if($result){
			return $result;
		}else{
			return 0;
		}	
	}
	
	//添加好友--发送请求
	public function addfriendRequest(array $data)
	{
		$datas=array();
		$datas['tu_id']=trim($data['userId']);
		$datas['f_tu_id']=trim($data['friendUserid']);
		$datas['nickname']=$data['nickname'];
		if(!empty($data['addFriendMessage'])){
			$datas['note']=$data['addFriendMessage'];
		}	
		$datas['addtime']=date('Y-m-d H:i:s',time());
		$datas['status']=3;
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['friendUserid'];
		//查询好友是否存在
		$friend_id=Db::table('ike_friends_user')
					   ->where($where)
					   ->select();
		//echo Db::getLastSql();exit;
		if($friend_id){
			return 11; //好友存在
		}else{
			$request['tu_id']=$data['userId'];
			$request['f_tu_id']=$data['friendUserid'];
			$rs=Db::table('ike_add_friends_request')
					->where($request)
					->select();
			$rs=reset($rs);
			if($rs){
				$set['status']=3;
				$set['note']=$data['addFriendMessage'];
				$set['addtime']=date('Y-m-d H:i:s',time());
				$result=Db::table('ike_add_friends_request')
							->where('id',$rs['id'])
							->update($set);
			}else{
				$result=Db::table('ike_add_friends_request')
					->insert($datas);
			}
			
			if($result){
				return 200;  //好友申请成功
			}else{
				return 100;	 //好友申请失败
			}
		}
		
		
	}
	
	//获取申请添加用户(未读)
	public function allUnreadFriends(array $data)
	{
		$where['f_tu_id']=$data['userId'];
		$where['status']=3;
		$result=Db::table('ike_add_friends_request')
					->where($where)
					->field('tu_id')
					->select();
		foreach($result as $k=>$v)
		{
			//$result[$k]['userId']=$v['tu_id'];
			$userinfo=Db::view('user','tu_id,nickname')
						->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
						->where('tu_id',$v['tu_id'])
						->select();
			if(!$userinfo)
			{
				continue;
			}else{
				
				$userinfo=reset($userinfo);
				$result[$k]['userId']=$userinfo['tu_id'];
				$result[$k]['nickname']=$userinfo['nickname'];
				$result[$k]['avatarImage']=$userinfo['avatar_image'];
			}
			
			unset($result[$k]['tu_id']);
		}
		return $result;
	}
	
	//获取申请添加用户(all)
	public function allAddfriendRequest(array $data)
	{
		$where['f_tu_id']=trim($data['userId']);
		$all_user=Db::table('ike_add_friends_request')
					   ->where($where)
					   ->select();
		if($all_user)
		{
			foreach($all_user as $k=>$v){
				$result=Db::view('user','*')
							->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
							->where('tu_id',$v['tu_id'])
							->select();
				
				$all_user[$k]['avatar_image']=$result[0]['avatar_image'];
				$all_user[$k]['mobile']=$result[0]['mobile'];
				$all_user[$k]['email']=$result[0]['email'];
			}
			//echo Db::getLastSql();exit;
			if($all_user){
				return $all_user;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
		
	}
	
	//确认添加好友
	public function confirmFriend(array $data)
	{
		if($data['status']==1)
		{
			$where_f['tu_id']=trim($data['userId']);
				$frends=Db::table('ike_friends_user')
							->where($where_f)
							->select();
				$f_tu_id=array();
				foreach($frends as $key=>$value){
					$f_tu_id[]=$value['friend_id'];
				}
				//var_dump($f_tu_id);exit;
				$check=in_array($data['friendUserId'],$f_tu_id);
				if(!$check){
					$datas=[
						['tu_id'=>$data['userId'],'friend_id'=>$data['friendUserId'],'addtime'=>date('Y-m-d H:i:s',time())],
						['tu_id'=>$data['friendUserId'],'friend_id'=>$data['userId'],'addtime'=>date('Y-m-d H:i:s',time())],
					];
					$result=Db::table('ike_friends_user')
							->insertAll($datas);
					if($result){
						//$data['userid']  当前用户
						//$data['friendUserId  '] 添加用户
						$where['tu_id']=$data['friendUserId'];
						$where['f_tu_id']=$data['userId'];
						$where['status']=3;
						$user=Db::table('ike_add_friends_request')
								   ->where($where)
								   ->select();
						//echo Db::getLastSql();exit;
						if($user){
							$set['status']=1;
							$where1['tu_id']=$data['userId'];
							$where1['f_tu_id']=$data['friendUserId'];
							$user1=Db::table('ike_add_friends_request')
								   ->where($where1)
								   ->select();
							if($user1){
								Db::table('ike_add_friends_request')
								->where('tu_id',$data['friendUserId'])
								->update($set);
							}
							Db::table('ike_add_friends_request')
								->where('tu_id',$data['friendUserId'])
								->update($set);
						}
						return 200;
					}else{
						return 101;
					}
				}else{
					return 101;
				}
		}else{
			return 0;
		}
		
		
	}
	
	//删除好友
	public function deleteUser(array $data)
	{
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['friendUserid'];
		$result=Db::table('ike_friends_user')
					->where($where)
					->select();
		if($result)
		{
			$result=reset($result);
			$del=Db::table('ike_friends_user')
						->where($where)
						->delete();
			$where_del['tu_id']=$result['friend_id'];
			$where_del['friend_id']=$result['tu_id'];
			$del=Db::table('ike_friends_user')
						->where($where_del)
						->delete();
			if($del){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	//好友列表
	public function friends(array $data){
		$where['tu_id']=trim($data['userId']);
		$result=Db::table('ike_friends_user')
					   ->where($where)
					   ->select();
					   
		//echo Db::getLastSql();
		//var_dump($result);exit;
		if($result){
			$datas=array();
			foreach($result as $k=>$v){
				$result=Db::view('user','tu_id,nickname,mobile,email')
							->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
							->where('tu_id',$v['friend_id'])
							->select();
				$result=reset($result);
				$result['displayname']=$v['displayname'];
				$datas[$k]=$result;
			}
			//echo Db::getLastSql();exit;
			return $datas;
		}else{
			return 0;
		}
	}
	
	//随机6位群号
	public function group_no(){
			$num=array(1,2,3,4,5,6,7,8,9,0);
			$rand=array_rand($num,6);
			$rand_num='';
			foreach($rand as $k=>$v){
				$rand_num.=$v;
			}
			$group_f=rand(1,9);
			$group_no=$group_f.$rand_num;
			
			return $group_no;
	}
	//查询群号是否存在
	public function check_group_no()
	{
		$group_no=$this->group_no();
		$where['group_number']=$group_no;
		$result=Db::table('ike_group_name')
					   ->where($where)
					   ->select();
		if(!$result){
			return $group_no;
		}
	}
	//创建群组
	/*
	**$data      群信息
	**$group_no  群主id
	**$group_users    群成员
	**
	**/
	public function createGroup(array $data,$group_no,$group_users,$hobby='')
	{
		if($hobby)
		{
			$datas['hobby_id']=$hobby;
		}
		$datas['group_number']=$group_no;
		$datas['group_name']=$data['groupName'];
		$datas['tu_id']=$data['userId'];
		$datas['avatar_id']=$data['avatar_id'];
		$datas['addtime']=date('Y-m-d H:i:s',time());
		$group=Db::table('ike_group_name')
					->insert($datas);
		$group_id=Db::table('ike_group_name')->getLastInsID();
		if($group){
			$groups=array();
			$groups['group_id']=$group_id;
			foreach($group_users as $k=>$v){
				$userinfo=$this->userinfo($v);
				$groups['tu_id']=$v;
				$groups['nickname']=$userinfo['nickname'];
				if($v==$data['userId'])
				{
					$groups['status']=2;
				}
				$result=Db::table('ike_group_user')
					->insert($groups);
			}
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	//添加群管理员
	public function vicePrincipal(array $data)
	{
		$checkGroupName=$this->group_no_info($data['groupId']);
		if(!$checkGroupName)
		{
			return 0;
		}
		$where['tu_id']=$data['userId'];
		$where['group_id']=$checkGroupName['group_id'];
		$checkGroupUser=Db::table('ike_group_name')
						->where($where)
						->select();
		if(!$checkGroupUser)
		{
			return 0;
		}
		$wh_user['tu_id']=$data['groupUserId'];
		$wh_user['group_id']=$checkGroupName['group_id'];
		$checkUser=Db::table('ike_group_user')
					->where($where)
					->select();
		if(!$checkUser)
		{
			
			return 0;
		}
		$checkUser=reset($checkUser);
		if($checkUser['status']==1)
		{
			return 101;
		}
		$checkAdmin=Db::table('ike_group_user')
					->where('status','=','1')
					->where('group_id',$checkGroupName['group_id'])
					->select();
		if(count($checkAdmin)==1)
		{
			return 102;
		}
		$result=Db::table('ike_group_user')
				->where($wh_user)
				->update(['status'=>1]);
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
	}
	
	//用户所在群（all）
	public function groupData(array $data)
	{
		$where['tu_id']=$data['userId'];
		$groups=Db::table('ike_group_user')
					->where($where)
					->field('group_id,status')
					->select();
		if(!$groups){
			return 0;
		}
		$datas=array();
		foreach($groups as $k=>$v){
			$group_info=Db::view('group_name','group_name,group_number,tu_id')
					->view('avatar','avatar_image','group_name.avatar_id=avatar.avatar_id')
					->where('group_id',$v['group_id'])
					->select();
			if(!$group_info)
			{
				continue;
			}
			$group_info=reset($group_info);
			$group_info['role']=$v['status'];
			$datas[$k]=$group_info;
			
		}
		$result=array();
		foreach($datas as $k=>$v)
		{
			$result[$k]['role']=$v['role'];
			if($v['tu_id']==$data['userId'])
			{
				$result[$k]['role']=2;
			}		
			$result[$k]['groupId']=$v['group_number'];
			$result[$k]['groupName']=$v['group_name'];
			$result[$k]['groupPortraitUri']=$v['avatar_image'];
		}
		return $result;
		
	}
	
	//群组信息
	public function groupInfo(array $data)
	{
		$where['group_number']=$data['groupId'];
		$result=Db::table('ike_group_name')
					->where($where)
					->select();
		
		if($result){
			$result=reset($result);
			if($result['tu_id']==$data['userId']){
				$result['role']=2;
			}
			$checkWhere['tu_id']=$data['userId'];
			$checkWhere['group_id']=$result['group_id'];
			$checkUser=Db::table('ike_group_user')
						->where($checkWhere)
						->select();
			if($checkUser)
			{
				$checkUser=reset($checkUser);
				if($checkUser['status']==1)
				{
					$result['role']==1;
				}else{
					$result['role']==0;
				}
			}else{
				return 0;
			}
			$avatar_image=Db::table('ike_avatar')
					->where('avatar_id',$result['avatar_id'])
					->field('avatar_image')
					->select();
			$result['avatar_image']=$avatar_image[0]['avatar_image'];
			return $result;
		}else{
			return 0;
		}
		
	}
	
	//群成员
	public function groupMember(array $data)
	{
		$where['group_number']=$data['groupId'];
		$result=Db::table('ike_group_name')
					->where($where)
					->select();
		if($result)
		{
			$result=reset($result);
			$group_users=Db::table('ike_group_user')
					->where('group_id',$result['group_id'])
					->select();
			foreach($group_users as $k=>$v)
			{
				$role=$v['status'];
				if($v['tu_id']==$result['tu_id']){
					$role=2;
				}
				$group_users[$k]['role']=$role;
				$user_info=Db::table('ike_user')
							  ->where('tu_id',$v['tu_id'])
							  ->select();
				$user_info=reset($user_info);
				$avatar_img=Db::table('ike_avatar')
							  ->where('avatar_id',$user_info['avatar_id'])
							  ->select();
				$avatar_img=reset($avatar_img);
				$group_users[$k]['userId']=$user_info['tu_id'];
				$group_users[$k]['userName']=$v['nickname'];
				$group_users[$k]['mobile']=$user_info['mobile'];
				$group_users[$k]['userPortraitUri']=$avatar_img['avatar_image'];
				unset($group_users[$k]['member_id']);
				unset($group_users[$k]['group_id']);				
				unset($group_users[$k]['tu_id']);				
			}
			return $group_users;
		}else{
			return 0;
		}
	}
	
	//修改群信息
	public function changeGroupName(array $data)
	{
		$where['group_number']=$data['groupId'];
		if(!empty($data['groupName']))
		{
			$datas['group_name']=$data['groupName'];
		} 
		if(!empty($data['avatar_id']))
		{
			$datas['avatar_id']=$data['avatar_id'];
		}
		$result=Db::table('ike_group_name')
					->where($where)
					->update($datas);
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	
	//修改个人群昵称
	public function changeUserName(array $data)
	{
		$group_info=$this->group_no_info($data['groupId']);
		$where_user['group_id']=$group_info['group_id'];
		$where_user['tu_id']=$data['userId'];
		$group_uesr=Db::table('ike_group_user')
					->where($where_user)
					->select();
		$group_uesr=reset($group_uesr);
		$update_user['nickname']=trim($data['groupName']);
		$update_rs=Db::table('ike_group_user')
					->where('member_id',$group_uesr['member_id'])
					->update($update_user);
		if($update_rs)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//获取群信息
	/*
	**$groupId      群id
	**
	**/
	public function group_no_info($groupId)
	{
		$where['group_number']=$groupId;
		$result=Db::table('ike_group_name')
					->where($where)
					->select();
		$result=reset($result);
		return $result;
	}
	
	//拉人进群
	/*
	**$group_users      群成员
	**$groupId          群id
	**$userid           用户id      
	**
	**/
	public function GroupPullUser($group_users,$groupId,$userid)
	{
		$check_group_user['tu_id']=$userid;
		$check_group_user['group_id']=$groupId;
		$group_user=Db::table('ike_group_user')
					->where($check_group_user)
					->select();
		if(!$group_uesr)
		{
			return 0;
		}
		
		if($group_user[0]['status'])
		{
			$users=array();
			$result='';
			foreach($group_users as $k=>$v)
			{
				$where['tu_id']=$v;
				$where['group_id']=$groupId;
				$check_user=Db::table('ike_group_user')
								->where($where)
								->select();
				if(empty($check_user))
				{
					//记录
					$datas['group_id']=$groupId;
					$datas['tu_id']=$v;
					$datas['type']=5;
					$datas['content']='管理员拉人';
					$datas['addtime']=date('Y-m-d H:i:s',time());
					$datas['status']=1;
					Db::table('ike_group_sys_msg')
						->insert($datas);
						
					//拉人
					$users[$k]=$v;
					$userinfo=$this->userinfo($v);//用户信息
					$groups_users['tu_id']=$v;
					$groups_users['nickname']=$userinfo['nickname'];
					$groups_users['group_id']=$groupId;
					Db::table('ike_group_user')
							->insert($groups_users);
				}
			}	

				return $users;

			
		}else{
			$where['tu_id']=$userid;
			$where['group_id']=$groupId;
			$check_user=Db::table('ike_group_user')
						->where($where)
						->select();
			if($check_user)
			{
				foreach($group_users as $k=>$v)
				{
					$where['tu_id']=$v;
					$check_users=Db::table('ike_group_user')
									->where($where)
									->select();
					if(!empty($check_users))
					{
						continue;
					}else{
						//记录
						$where_check['tu_id']=$v;
						$where_check['pull_user']=$userid;
						$check_msg=Db::table('ike_group_sys_msg')
									->where($where_check)
									->select();
						if($check_msg){
							continue;
						}else{
							$datas['group_id']=$groupId;
							$datas['tu_id']=$v;
							$datas['pull_user']=$userid;
							$datas['type']=5;
							$datas['content']='群成员拉人';
							$datas['addtime']=date('Y-m-d H:i:s',time());
							$datas['status']=0;
							$result=Db::table('ike_group_sys_msg')
									->insert($datas);
						}					
					}
				}
				return 1;
			}else{
				return 0;
			}		
		}
		
	}
	
	
	//群主审核加人人员列表
	/*
	**$groupId          群id
	**$userid           用户id      
	**
	**/
	public function groupAuditingAllUser($groupId,$userId)
	{
		$where['group_id']=$groupId;
		//$where['tu_id']=$userId;
		$check_group_master=Db::table('ike_group_name')
							->where($where)
							->select();
		if(!$check_group_master)
		{
			return 0;
		}
		$where['tu_id']=$userId;
		$checkGroupMain=Db::table('ike_group_user')
						->where($where)
						->where('status','>','0')
						->select();
			
		//echo Db::getLastSql();exit;
		if($checkGroupMain)
		{
			$where_msg['group_id']=$groupId;
			$where_msg['type']=5;
			$where_msg['status']=0;
			$all_apply=Db::table('ike_group_sys_msg')
						->where($where_msg)
						->select();
			$datas=array();
			//var_dump($all_apply);exit;
			foreach($all_apply as $k=>$v)
			{
				$userinfo=$this->userinfo($v['tu_id']);
				if(!$userinfo){
					continue;
				}
				$pull_user=$this->userinfo($v['pull_user']);
				if(!$pull_user){
					continue;
				}
				$whereUser['tu_id']=$v['tu_id'];
				$whereUser['group_id']=$v['group_id'];
				$checkGroupUser=Db::table('ike_group_user')
								->where($whereUser)
								->select();
				if($checkGroupUser)
				{
					continue;
				}
				if($userinfo)
				{
					$datas[$k]['userId']=$userinfo['tu_id'];
					$datas[$k]['nickname']=$userinfo['nickname'];
					$datas[$k]['userPortraitUrl']=$userinfo['avatar_image'];
					$datas[$k]['pullUserid']=$pull_user['tu_id'];
					$datas[$k]['pullNickname']=$pull_user['nickname'];
				}else{
					continue;
				}
			}
			return $datas;
			//echo Db::getLastSql();exit;
		}else{
			return 0;
		}
	}
	//群主审核加人人员（是否同意）
	/*
	**$group_users      群成员
	**$groupId          群id
	**$userid           用户id      
	**$status           
	**/
	public function groupAuditingUsers($groupId,$group_user,$userId,$status)
	{
		$where['group_id']=$groupId;
		$where['tu_id']=$group_user;
		$check_group_master=Db::table('ike_group_user')
							->where($where)
							->where('status','>','0')
							->select();
		if($check_group_master){
			$userinfo=$this->userinfo($userId);
			if($userinfo){
				switch($status){
						case 1:	
							$where_check_group_user['tu_id']=$userId;
							$where_check_group_user['group_id']=$groupId;
							$g_user=Db::table('ike_group_user')
									->where($where_check_group_user)
									->select();
							if($g_user){
								$updatas['status']=1;
								$updatas['addtime']=date('Y-m-d H:i:s',time());
								$where_msg['group_id']=$groupId;
								$where_msg['tu_id']=$userId;
								Db::table('ike_group_sys_msg')
										->where($where_msg)
										->update($updatas);
								return 100;
							}else{
								$datas['tu_id']=$userinfo['tu_id'];
								$datas['group_id']=$groupId;
								$datas['nickname']=$userinfo['nickname'];
								$result=Db::table('ike_group_user')
										->insert($datas);
								if($result){
									$updatas['status']=1;
									$updatas['addtime']=date('Y-m-d H:i:s',time());
									$where_msg['group_id']=$groupId;
									$where_msg['tu_id']=$userId;
									Db::table('ike_group_sys_msg')
											->where($where_msg)
											->update($updatas);
									return 100;
								}else{
									return 0;
								}
							}							
							break;
						case 2:
							$updatas['status']=1;
							$updatas['addtime']=date('Y-m-d H:i:s',time());
							$where_msg['group_id']=$groupId;
							$where_msg['tu_id']=$userId;
							$result=Db::table('ike_group_sys_msg')
									->where($where_msg)
									->update($updatas);
							if($result){
								return 200;
							}else{
								return 0;
							}
							break;
				}
			}else{				
				return 0;
			}
		}else{
			return 0;
		}

		
	}
	//退群/解散群
	
	public function dissolutionGroup(array $data)
	{
		$group_info=$this->group_no_info($data['groupId']);
		if($group_info['tu_id']==$data['groupUser'])
		{
			$result=Db::table('ike_group_name')->delete($group_info['group_id']);
			$result=Db::table('ike_group_user')
			           ->where('group_id',$group_info['group_id'])
					   ->delete();
			if($result)
			{
				$datas['group_id']=$group_info['group_id'];
				$datas['tu_id']=$data['groupUser'];
				$datas['type']=6;
				$datas['content']='解散群';
				$datas['addtime']=date('Y-m-d H:i:s',time());
				$datas['status']=1;
				Db::table('ike_group_sys_msg')
					->insert($datas);
				return 200; //解散群
			}else{
				return 0;
			}
		}else{
			$where['group_id']=$group_info['group_id'];
			$where['tu_id']=$data['groupUser'];
			$result=Db::table('ike_group_user')
						->where($where)
						->delete();
			if($result)
			{
				$datas['group_id']=$group_info['group_id'];
				$datas['tu_id']=$data['groupUser'];
				$datas['type']=3;
				$datas['content']='退群';
				$datas['addtime']=date('Y-m-d H:i:s',time());
				$datas['status']=1;
				Db::table('ike_group_sys_msg')
					->insert($datas);
				return 100;   //退群
			}else{
				return 0;
			}

		}
	}
	
	//修改好友名片
	public function editFriendName(array $data)
	{
		$update['displayname']=trim($data['displayname']);
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['friendUserid'];
		$result=Db::table('ike_friends_user')
					->where($where)
					->update($update);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
		
	}
	//修改个人信息
	public function editUserInfo(array $data,$avatar_id)
	{
		if(!empty($data['nickname'])){
			$update['nickname']=trim($data['nickname']);
		}
		if(trim($data['sex'])!=""){
			$update['sex']=trim($data['sex']);
		}
		if(!empty($data['email'])){
			$update['email']=trim($data['email']);
		}
		if(!empty($data['mobile'])){
			$update['mobile']=trim($data['mobile']);
		}
		if(!empty($data['address'])){
			$update['address']=trim($data['address']);
		}
		if(!empty($data['birthdate'])){
			$update['birth_date']=$data['birthDate'];
		}
		if(!empty($data['age'])){
			$update['age']=trim($data['age']);
		}
		if(!empty($avatar_id)){
			$update['avatar_id']=$avatar_id;
		}	
		//var_dump($update);exit;
		$result=Db::table('ike_user')
					->where('tu_id',$data['userId'])
					->update($update);
		//echo Db::getLastSql();exit;
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//创建群活动
	public function foundActives(array $data)
	{
		$group_info=$this->group_no_info($data['groupId']);
		if(!$group_info)
		{
			return 0;
		}
		$where['group_id']=$group_info['group_id'];
		$where['tu_id']=$data['userId'];
		$group=Db::table('ike_group_user')
					->where($where)
					->select();
		if(!$group)
		{
			return 0;
		}
		$group=reset($group);
		if(!$group['status'])
		{
			return 0;
		}
		$datas['actives_title']=$data['activesTitle'];
		$datas['avatar_id']=$data['avatar_id'];
		$datas['actives_content']=$data['activesContent'];
		if(trim($data['activesLimit'])!=""){
			$datas['actives_limit']=$data['activesLimit'];
		}

		$datas['actives_start']=$data['activesStart'];
		$datas['actives_end']=$data['activesEnd'];
		$datas['actives_address']=$data['activesAddress'];
		$datas['tu_id']=$data['userId'];
		$datas['group_id']=$group['group_id'];
		$result=Db::table('ike_actives')
					->insert($datas);
		$actives_id=Db::table('ike_actives')
						->getLastInsID();
		$join['tu_id']=$data['userId'];
		$join['actives_id']=$actives_id;
		Db::table('ike_actives_join')
					->insert($join);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
		
	}
	
	//加入群活动
	public function joinActives(array $data)
	{
		$where['actives_id']=$data['activesId'];
		$actives=Db::table('ike_actives')
					->where($where)
					->select();
		$checkJoin=Db::table('ike_actives_join')
					->where($where)
					->select();
		if($checkJoin)
		{
			return 104;//活动已加入
		}
		$actives=reset($actives);
		$count_num=Db::table('ike_actives_join')
					->where($where)
					->count('actives_id');		
		$group_users=Db::table('ike_group_user')
						->where('group_id',$actives['group_id'])
						->select();
		$users=array();
		foreach($group_users as $k=>$v)
		{
			$users[$k]=$v;
		}
		if(!in_array($data['userId'],$users))
		{
			return 100;//非法操作
		}
		$actives_start=strtotime($actives['actives_start']);
		$actives_end=strtotime($actives['actives_end']);
		
		if($actives_start>time())
		{
			return 101;//活动还未开始
		}
		if($actives_end<time())
		{
			return 102;//活动结束
		}
		if($actives['actives_limit']>0)
		{
			if($count_num=$actives['actives_limit'])
			{
				return 103;//活动人数已满
			}
		}
		$datas['actives_id']=$data['activesId'];
		$datas['tu_id']=$data['userId'];
		$result=Db::table('ike_actives_join')
					->insert($datas);
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
		
		
	}
	
	//群活动列表
	public function listActives(array $data)
	{
		$where['group_number']=$data['groupId'];
		$groupInfo=Db::table('ike_group_name')
					->where($where)
					->select();
		if(!$groupInfo){
			return 0;
		}
		$groupInfo=reset($groupInfo);
		$actives=Db::view('actives','*')
					->view('avatar','avatar_image','actives.avatar_id=avatar.avatar_id')
					->where('group_id',$groupInfo['group_id'])
					->select();
		if(!empty($actives))
		{
			$datas=array();
			foreach($actives as $k=>$v)
			{
				$datas[$k]['activesId']=$v['actives_id'];
				$datas[$k]['activesTitle']=$v['actives_title'];
				$datas[$k]['activesImage']=$v['avatar_image'];
				$datas[$k]['activesLimit']=$v['actives_limit'];
				$datas[$k]['activesStart']=$v['actives_start'];
				$datas[$k]['activesEnd']=$v['actives_end'];
				$datas[$k]['activesAddress']=$v['actives_address'];
				$datas[$k]['activesContent']=$v['actives_content'];
			}
			return $datas;
		}else{
			return 0;
		}
		
	}
	
	//活动详情
	public function infoActives(array $data)
	{
		$where['actives_id']=$data['activesId'];
		$activesInfo=Db::view('actives','*')
					->view('avatar','avatar_image','actives.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		if($activesInfo)
		{
			$activesInfo=reset($activesInfo);
			$user=Db::table('ike_actives_join')
					->where('actives_id',$activesInfo['actives_id'])
					->select();
			$datas=array();
			foreach($user as $k=>$v)
			{
				$userinfo=Db::view('user','tu_id,nickname,sex')
							->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
							->where('tu_id',$v['tu_id'])
							->select();
				
				$userinfo=reset($userinfo);
				$datas[$k]['userId']=$userinfo['tu_id'];
				$datas[$k]['nickname']=$userinfo['nickname'];
				$datas[$k]['sex']=$userinfo['sex'];
				$datas[$k]['avatarImage']=$userinfo['avatar_image'];
			}
			/*
			$datas['actives']['actives_title']=$activesInfo['actives_title'];
			$datas['actives']['actives_content']=$activesInfo['actives_content'];
			$datas['actives']['actives_limit']=$activesInfo['actives_limit'];
			$datas['actives']['actives_start']=$activesInfo['actives_start'];
			$datas['actives']['actives_end']=$activesInfo['actives_end'];
			$datas['actives']['actives_address']=$activesInfo['actives_address'];
			$datas['actives']['actives_image']=$activesInfo['avatar_image'];
			*/
			return $datas;
		}else{
			return 0;
		}
	}
	
	//群主踢人
	/**
	*$group_id    群id
	*$found_user  创建者
	*$group_user  群主
	*$users       踢人用户
	*/
	public function kickGroupUser($group_id,$found_user,$group_user,$users)
	{
		$where['tu_id']=$group_user;
		$where['group_id']=$group_id;
		$checkGroupUser=Db::table('ike_group_user')
						->where($where)
						->where('status','>','0')
						->select();
		if($checkGroupUser)
		{
			foreach($users as $k=>$v)
			{
				$del['tu_id']=$v;
				$del['group_id']=$group_id;
				$result=Db::table('ike_group_user')
					->where($del)
					->delete();
			}
			if($result)
			{
				//记录
				$datas['group_id']=$group_id;
				$datas['type']=4;
				$datas['content']='群管理员踢人';
				$datas['addtime']=date('Y-m-d H:i:s',time());
				$datas['status']=1;
				foreach($users as $k=>$v)
				{
					$datas['tu_id']=$v;
					Db::table('ike_group_sys_msg')
						->insert($datas);
				}		
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	//群 推荐好友（拉人进群）
	/**
	*$groupId  群id
	*$userId  用户id
	*$users   推荐好友
	*/
	public function recommendUser($groupId,$userId,$users)
	{
		
		$where['tu_id']=$userId;
		$where['group_id']=$groupId;
		$checkUser=Db::table('ike_group_name')
					->where($where)
					->select();
		if($checkUser)
		{
			$datas['group_id']=$groupId;
			$datas['pull_user']=$userId;
			$datas['type']=5;
			$datas['content']='群主拉人';
			$datas['addtime']=date('Y-m-d H:i:s',time());
			$datas['status']=1;
			$userinfo=array();
			$result=array();
			foreach($users as $k=>$v)
			{
				$check_group['group_id']=$groupId;
				$check_group['tu_id']=$v;
				$checkUser=Db::table('ike_group_user')
							->where($where)
							->select();
				if($checkUser)
				{
					continue;
				}
				$datas['tu_id']=$v;
				$userinfo=$this->userInfo($v);
				$insert['group_id']=$groupId;
				$insert['tu_id']=$userinfo['tu_id'];
				$insert['nickname']=$userinfo['nickname'];
				$result=Db::table('ike_group_user')
							->insert($insert);
				if(!$result)
				{
					continue;
				}
				Db::table('ike_group_sys_msg')
						->insert($datas);
			}
			if($result)
			{
				return 1;
			}else{
				return 0;
			}
		}else{
			$datas['group_id']=$groupId;
			$datas['pull_user']=$userId;
			$datas['type']=5;
			$datas['content']='群员邀请,用户:'.$userId;
			$datas['addtime']=date('Y-m-d H:i:s',time());
			$datas['status']=0;
			foreach($users as $k=>$v)
			{
				$datas['tu_id']=$v;
				$result=Db::table('ike_group_sys_msg')
						->insert($datas);
			}
			if($result)
			{
				return 1;
			}else{
				return 0;
			}
		}
		
		
	}
	
	//群主审核群成员
	public function checkJoinUser(array $data,$groupId)
	{
		if(trim($data['status'])!=""){
			$status=$data['status'];
		}
		$check_where['tu_id']=$data['group_userId'];
		$check_where['group_number']=$data['groupId'];
		$checkGroupUser=Db::table('ike_group_name')
						->where($check_where)
						->select();
		if(!$checkGroupUser)
		{
			return 0;
		}
		$where['group_id']=$groupId;
		$where['tu_id']=$data['userId'];
		$where['status']=0;
		$msgs=Db::table('ike_group_sys_msg')
				->where($where)
				->select();
		$updates['status']=1;
		if(!empty($msgs)){			
			switch($status){
				case 0:						
					$updates['content']='拒绝加入';
					$updates['addtime']=date('Y-m-d H:i:s',time());
					$result=Db::table('ike_group_sys_msg')
								->where($where)
								->update($updates);
					if($result){
						return 100;
					}else{
						return 0;
					}
					break;
				case 1:
					$updates['content']='同意加入';
					$updates['addtime']=date('Y-m-d H:i:s',time());
					Db::table('ike_group_sys_msg')
								->where($where)
								->update($updates);
					$userInfo=$this->userInfo($data['userId']);
					$insert['group_id']=$groupId;
					$insert['tu_id']=$userInfo['tu_id'];
					$insert['nickname']=$userInfo['nickname'];
					$result=Db::table('ike_group_user')
							->insert($insert);
					if($result){
						return 200;
					}else{
						return 0;
					}
					break;
				case 2:
					$updates['content']='已忽略';
					$updates['addtime']=date('Y-m-d H:i:s',time());
					$result=Db::table('ike_group_sys_msg')
								->where($where)
								->update($updates);
					if($result){
						return 300;
					}else{
						return 0;
					}
					break;
			}
		}else{
			return 0;
		}		
	}
	//申请加入群信息（所在群）
	public function groupApplyUser($groupId,$userId)
	{
		$groupInfo=Db::table('ike_group_name')
					->where('group_number',$groupId)
					->select();
		if(!$groupInfo)
		{
			return 0;
		}
		$checkWhere['tu_id']=$userId;
		$checkWhere['group_number']=$groupId;
		$checkUser=Db::table('ike_group_name')
					->where($checkWhere)
					->select();
		if(!$checkUser){
			return 0;
		}
		$groupInfo=reset($groupInfo);
		$where['group_id']=$groupInfo['group_id'];
		$where['type']=5;
		$where['status']=0;
		$result=Db::table('ike_group_sys_msg')
					->where($where)
					->select();
		if($result){
			$apply=array();
			foreach($result as $k=>$v)
			{
				$users=$this->userinfo($v['tu_id']);
				if(!$users){
					continue;
				}
				$apply[$k]['userId']=$v['tu_id'];
				$apply[$k]['nickname']=$users['nickname'];
				$apply[$k]['avatarImage']=$users['avatar_image'];
				$apply[$k]['content']=$v['content'];
				$apply[$k]['addtime']=$v['addtime'];
				
			}
			return $apply;
		}else{
			return 0;
		}	
	}
	//申请加入群信息（所有群）
	public function allGroupApplyUser($userId)
	{

		$checkWhere['tu_id']=$userId;
		$groups=Db::table('ike_group_name')
					->where($checkWhere)
					->select();
		if(!$checkUser){
			return 0;
		}
		$apply=array();
		foreach($groups as $k=>$v)
		{
			$where['group_id']=$v['group_id'];
			$where['type']=5;
			$where['status']=0;
			$apply=Db::table('ike_group_sys_msg')
					->where($where)
					->select();
			
		}
		$groupInfo=reset($groupInfo);
		$where['group_id']=$groupInfo['group_id'];
		$where['type']=5;
		$where['status']=0;
		$result=Db::table('ike_group_sys_msg')
					->where($where)
					->select();
		if($result){
			$apply=array();
			foreach($result as $k=>$v)
			{
				$users=$this->userinfo($v['tu_id']);
				if(!$users){
					continue;
				}
				$apply[$k]['userId']=$v['tu_id'];
				$apply[$k]['nickname']=$users['nickname'];
				$apply[$k]['avatarImage']=$users['avatar_image'];
				$apply[$k]['content']=$v['content'];
				$apply[$k]['addtime']=$v['addtime'];
				
			}
			return $apply;
		}else{
			return 0;
		}	
	}
	//投票主题创建
	public function foundVote(array $data)
	{
		$groupInfo=$this->group_no_info($data['groupId']);
		if(!$groupInfo)
		{
			return 0;
		}
		$where['tu_id']=$data['userId'];
		$where['group_id']=$groupInfo['group_id'];
		$checkAdmin=Db::table('ike_group_user')
					->where($where)
					->where('status','>','0')
					->select();
		if(!$checkAdmin)
		{
			return 0;
		}
			$datas=array();
			$datas['vote_title']=$data['voteTitle'];
			$datas['add_time']=date('Y-m-d H:i:s',time());
			$datas['end_time']=$data['endTime'];
			$datas['tu_id']=$data['userId'];
			$datas['group_id']=$groupInfo['group_id'];
			$datas['mode']=$data['mode'];
			$vote=Db::table('ike_vote_theme')
					->insert($datas);
			$vote_id = Db::getLastInsID();
			if($vote_id){
				$option=json_decode($data['voteOption'],true);
				$options['vote_id']=$vote_id;
				$option_rs=array();
				foreach($option as $k=>$v)
				{
					$options['vote_content']=$v;
					$vote_option=Db::table('ike_vote_option')
									->insert($options);
					$option_id = Db::name('ike_vote_option')->getLastInsID();
					$option_rs[$option_id]=$v;
				}
				if($vote_option)
				{

					return 200;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
	}
	
	//投票主题列表
	public function voteList(array $data)
	{
		$where['group_number']=$data['groupId'];
		$result=Db::view('vote_theme','vote_id,vote_title,add_time,end_time')
				//->view('vote_option','item_id,vote_content','vote_theme.vote_id=vote_option.vote_id')
				->view('group_name','group_id','vote_theme.group_id=group_name.group_id')
				->where($where)
				->select();
		if($result)
		{
			
			$datas=array();
			foreach($result as $k=>$v)
			{
				unset($result[$k]['group_id']);
				$end_time=strtotime($v['end_time']);
				if($end_time>time())
				{
					$datas[$k]['status']=1;
				}else{
					$datas[$k]['status']=0;
				}
				$datas[$k]['voteId']=$v['vote_id'];
				$datas[$k]['voteTitle']=$v['vote_title'];
				$datas[$k]['addTime']=$v['add_time'];
				$datas[$k]['endTime']=$v['end_time'];
			}
			return $datas;
		}else{
			return 0;
		}
		//echo Db::getLastSql();exit;
		
	}
	
	//投票主题详情
	public function voteDetails(array $data)
	{
		
		$groupInfo=$this->group_no_info($data['groupId']);
		if(!$groupInfo)
		{
			return 0;
		}
		$where['group_id']=$groupInfo['group_id'];
		$where['vote_id']=$data['voteId'];
		$result=Db::view('vote_theme','vote_id,vote_title,add_time,end_time,tu_id,mode')
				->view('group_name','group_id','vote_theme.group_id=group_name.group_id')
				->where($where)
				->select();
		if($result){
			$result=reset($result);
			$check_where['vote_id']=$data['voteId'];
			$check_where['tu_id']=$data['userId'];
			$check_vote_collect=Db::table('ike_vote_collect')
								->where($check_where)
								->select();
			$result['joinUsers']=array();
			if($check_vote_collect)
			{
				$all_joinUser=Db::table('ike_vote_collect')
								->where('vote_id',$data['voteId'])
								->select();
				if($all_joinUser){
					$join_info=array();
					foreach($all_joinUser as $k=>$v)
					{
						$userinfo=Db::view('user','tu_id,nickname')
									->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
									->where('tu_id',$v['tu_id'])
									->select();
						$userinfo=reset($userinfo);
						$join_info[$k]['userId']=$userinfo['tu_id'];
						$join_info[$k]['nickname']=$userinfo['nickname'];
						$join_info[$k]['avatarImage']=$userinfo['avatar_image'];
						$join_info[$k]['select']=explode(',',substr($v['item_id'],0,-1));
					}
					$result['joinUsers']=$join_info;
				}else{
					$result['joinUsers']='';
				}
			}else{
				$result['joinUsers']='';
			}
			$end_time=strtotime($result['end_time']);
			if($end_time>time()){
				$result['status']=1;
			}else{
				$result['status']=0;
			}
			$result['createUser']=$result['tu_id'];
			unset($result['group_id']);
			unset($result['tu_id']);
			$options=Db::table('ike_vote_option')
						->where('vote_id',$result['vote_id'])
						->select();
			
			if(empty($options))
			{
				return 0;
			}
			foreach($options as $key=>$value)
			{
				$result['option'][$key]=array('id'=>$value['item_id'],'content'=>$value['vote_content']);
			}
			$result['voteId']=$result['vote_id'];
			unset($result['vote_id']);
			$result['voteTitle']=$result['vote_title'];
			unset($result['vote_title']);
			$result['addTime']=$result['add_time'];
			unset($result['add_time']);
			$result['endTime']=$result['end_time'];
			unset($result['end_time']);
			return $result;
		}else{
			return 0;
		}
	
	}
	
	//投票选择
	public function voteCollect(array $data)
	{
		$where['vote_id']=$data['voteId'];
		$where['group_number']=$data['groupId'];
		$result=Db::view('vote_theme','vote_id,mode,end_time')
				->view('group_name','group_id','vote_theme.group_id=group_name.group_id')
				->where($where)
				->select();
		//echo Db::getLastSql();exit;
		//var_dump($result);exit;
		if($result)
		{
			$result=reset($result);
			$end_time=strtotime($result['end_time']);
			if($end_time>time())
			{
				$item_id=json_decode($data['voteOption'],true);
				$item_ids='';
				foreach($item_id as $k=>$v)
				{
					$item_ids.=$v.',';
				}
				$it=explode(',',trim($item_ids,','));
				$check_option=Db::table('ike_vote_option')
								->where('vote_id',$data['voteId'])
								->field('item_id')
								->select();
				$options=array();
				foreach($check_option as $c=>$o)
				{
					$options[$c]=$o['item_id'];
				}
				foreach($it as $k1=>$v1){
					$check_op=in_array($v1,$options);
				}
				if(!$check_op)
				{
					return 0;
				}
				$check_where['vote_id']=$data['voteId'];
				$check_where['tu_id']=$data['userId'];
				$check=Db::table('ike_vote_collect')
						->where($check_where)
						->select();
				if($check)
				{
					return 102;
				}
				
				$datas=array();
				$datas['vote_id']=$result['vote_id'];
				$datas['tu_id']=$data['userId'];
				$datas['item_id']=$item_ids;
				if($result['mode']==1)
				{
					$rs=Db::table('ike_vote_collect')
						->insert($datas);
					if($rs){
						return 200;
					}else{
						return 0;
					}
				}else{
					$count=count(explode(',',trim($item_ids,',')));
					if($count>1)
					{
						return 0;
					}
					$rs=Db::table('ike_vote_collect')
							->insert($datas);
					if($rs){
						return 200;
					}else{
						return 0;
					}
				}
			}else{
				return 101;
			}
			
			
		}else{
			return 103;
		}
	}
	
	//获取所以认领用户列表
	public function allFriendsClaim(array $data,$field='*')
	{
		$check_claim=Db::table('ike_friends_claim')
						->where('claimUserId',$data['userId'])
						->field('tu_id')
						->select();
		$friends=array();
		if($data['status']==1)
		{
			if($check_claim)
			{
				foreach($check_claim as $k=>$v)
				{
					$userInfo=$this->userinfo($v['tu_id']);
					if(!$userInfo)
					{
						continue;
					}
					$all_recommend=Db::table('ike_recommend_content')
								->where('tu_id',$v['tu_id'])
								->select();
					if(!$all_recommend)
					{
						continue;
					}	
					if($all_recommend[0]['SfullName']==1)
					{
						$friends[$k]['fullName']=$v['fullName'];//真实姓名
					}else{
						$friends[$k]['fullName']=null;//真实姓名
					}
					
					$friends[$k]['nickname']=$userInfo['nickname'];
					$friends[$k]['numberId']=$userInfo['userid'];//会员id2
					$friends[$k]['userPortraitUrl']=$userInfo['avatar_image'];//用户头像
					//unset($friends[$k]['mobile']);
				}
				return $friends;
			}else{
				return 0;
			}
		}else{
			$where=array();
			$where[]=$data['userId'];
			if($check_claim)
			{
				$where[]=$check_claim[0]['tu_id'];
			}
			$all_recommend=Db::table('ike_recommend_content')
					->where('tu_id','not in',$where)
					->where('status','2')
					->select();
			if($all_recommend){
				foreach($all_recommend as $k=>$v)
				{
					$friends[$k]['recommendId']=$v['id'];//推荐表id
					if($v['SfullName']==1)
					{
						$friends[$k]['fullName']=$v['fullName'];//真实姓名
					}else{
						$friends[$k]['fullName']=null;//真实姓名
					}
					$userInfo=$this->userinfo($v['tu_id']);
					$friends[$k]['nickname']=$userInfo['nickname'];
					$friends[$k]['numberId']=$userInfo['userid'];//会员id2
					$friends[$k]['userPortraitUrl']=$userInfo['avatar_image'];//用户头像
					$friends[$k]['userId']=$v['userId'];//推荐用户id
				}
				return $friends;
			}else{
				return 0;
			}
		}
		
	} 

	//认领用户
	public function claimUser(array $data)
	{
		
		$checkwhere['claimUserId']=$data['claimUserId'];
		$checkClaimUser=Db::table('ike_friends_claim')
						->where($checkwhere)
						->select();
		if($checkClaimUser)
		{
			return 100;
		}
		$msgWhere['tu_id']=$data['userId'];
		$msgWhere['claimUserId']=$data['claimUserId'];
		$cleckClimMsg=Db::table('ike_claim_msg')
						->where($msgWhere)
						->select();
		if($cleckClimMsg)
		{
			return 101;
		}
		$check_user=Db::table('ike_user')
					->where('tu_id',$data['claimUserId'])
					->select();
		if(!$check_user)
		{
			return 0;
		}
		//真实姓名
		if(empty($data['fullName']))
		{
			return 0;
		}
		//电话
		if(empty($data['mobile']))
		{
			return 0;
		}
		//性别
		if(empty($data['sex']))
		{
			return 0;
		}
		//爱好
		if(empty($data['hobby']))
		{
			return 0;
		}
		//地址
		if(empty($data['address']))
		{
			return 0;
		}
		//信誉分
		if(empty($data['creditScore']))
		{
			return 0;
		}
		//两者关系
		if(empty($data['relationship']))
		{
			return 0;
		}
		$address=json_decode($data['address'],true);		
		if(count($address)!=3)
		{
			return 0;
		}
		$recommendUser=Db::table('ike_recommend_content')
				->where('tu_id',$data['claimUserId'])
				->select();
		if(!$recommendUser)
		{
			return 0;
		}
		//87178291200   3628800
		$recommendUser=reset($recommendUser);
		//生日
		if($recommendUser['birthday'])
		{
			$selWhere['birthday']=$data['birthday'];
		}
		//籍贯
		if($recommendUser['homeplace'])
		{
			$selWhere['homeplace']=$data['homeplace'];
		}
		//毕业学校
		if($recommendUser['finishSchool'])
		{
			$selWhere['finishSchool']=$data['finishSchool'];
		}
		//学历
		if($recommendUser['degree'])
		{
			$selWhere['degree']=$data['degree'];
		}
		//公司
		if($recommendUser['company'])
		{
			$selWhere['company']=$data['company'];
		}
		//职位
		if($recommendUser['position'])
		{
			$selWhere['position']=$data['position'];
		}
		//邮箱
		if($recommendUser['email'])
		{
			$selWhere['email']=$data['email'];
		}
		//QQ
		if($recommendUser['QQ'])
		{
			$selWhere['QQ']=$data['QQ'];
		}
		//微信
		if($recommendUser['wechat'])
		{
			$selWhere['wechat']=$data['wechat'];
		}
		$where['fullName']=$data['fullName'];
		$where['mobile']=$data['mobile'];
		$where['sex']=$data['sex'];
		$where['hobby']=$data['hobby'];
		$where['first_stage']=$address[0];
		$where['second_stage']=$address[1];
		$where['third_stage']=$address[2];
		/*var_dump(array_rand($where,5));exit;
		$a[]=$this->unique_array($where,5);
		var_dump($a);
		exit;*/
		$recommendUserInfo=Db::view('recommend_content','*')
							->view('recommend_address','*','recommend_content.address_id=recommend_address.address_id')
							->where('recommend_content.tu_id',$data['claimUserId'])
							->select();
		$recommendUserInfo=reset($recommendUserInfo);
		//var_dump($recommendUserInfo);exit;
		if(count($selWhere)>=5)
		{
			$where=array_merge($where,$selWhere);
			$matching=array_intersect_assoc($where,$recommendUserInfo);
			$num=count($matching);
			if($num>=10)
			{
				$insert['tu_id']=$data['userId'];
				$insert['claimUserId']=$data['claimUserId'];
				$insert['relationship']=$data['relationship'];
				$insert['creditScore']=$data['creditScore'];
				$insert['claim_time']=date('Y-m-d H:i:s',time());
				$insert['status']=1;
				Db::table('ike_claim_msg')
				  ->insert($insert);
				$clInsert['tu_id']=$data['userId'];
				$clInsert['claimUserId']=$data['claimUserId'];
				$clInsert['creditScore']=$data['creditScore'];
				$clInsert['claim_time']=date('Y-m-d H:i:s',time());
				$result=Db::table('ike_friends_claim')
						->insert($clInsert);
				if($result)
				{
					return 200;
				}else{
					return 0;
				}
			}elseif($num>=5 && $num<10){
				$insert['tu_id']=$data['userId'];
				$insert['claimUserId']=$data['claimUserId'];
				$insert['relationship']=$data['relationship'];
				$insert['creditScore']=$data['creditScore'];
				$insert['claim_time']=date('Y-m-d H:i:s',time());
				$insert['status']=0;
				$result=Db::table('ike_claim_msg')
						->insert($insert);
				if($result)
				{
					return 200;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
			
		}else{
			$insert['tu_id']=$data['userId'];
			$insert['claimUserId']=$data['claimUserId'];
			$insert['relationship']=$data['relationship'];
			$insert['creditScore']=$data['creditScore'];
			$insert['claim_time']=date('Y-m-d H:i:s',time());
			$insert['status']=0;
			$result=Db::table('ike_claim_msg')
					->insert($insert);
			if($result)
			{
				return 200;
			}else{
				return 0;
			}
		}
	}
	
	//显示需确认认领用户（问题正确未达到10个）
	public function allClaimConfirm(array $data)
	{
		$checkUser=Db::table('ike_user')
						->where('tu_id',$data['userId'])
						->select();
		if(!$checkUser)
		{
			return 0;
		}
		$confirmClaim=Db::table('ike_friends_claim')
						->where('claimUserId',$data['userId'])
						->select();
		if($confirmClaim)
		{
			return 0;
		}
		$where['claimUserId']=$data['userId'];
		$where['status']=0;
		$claimUser=Db::table('ike_claim_msg')
					->where($where)
					->select();
		$datas=array();
		foreach($claimUser as $k=>$v)
		{
			$userinfo=$this->userInfo($v['tu_id']);
			if(!$userinfo)
			{
				continue;
			}
			$datas[$k]['userId']=$userinfo['tu_id'];
			$datas[$k]['nickname']=$userinfo['nickname'];
			$datas[$k]['userPortraitUrl']=$userinfo['avatar_image'];
			//$datas[$k]['userId']=$userinfo['tu_id'];
		}
		return $datas;
		//var_dump($claimUser);exit;
	}
	
	//认领用户确认（问题正确未达到10个）
	public function claimConfirm(array $data)
	{
		$isset=isset($data['status']);
		if(!$isset)
		{
			return 0;
		}
		$confirmClaim=Db::table('ike_friends_claim')
						->where('claimUserId',$data['userId'])
						->select();
		if($confirmClaim)
		{
			return 0;
		}
		$checkUser=$this->userinfo($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		$checkClaimUser=$this->userinfo($data['claimUserId']);
		if(!$checkClaimUser)
		{
			return 0;
		}
		$where['tu_id']=$data['claimUserId'];
		$where['claimUserId']=$data['userId'];
		$checkMsg=Db::table('ike_claim_msg')
					->where($where)
					->select();
		if(!$checkMsg)
		{
			return 0;
		}
		if($data['status']==1)
		{
			$checkMsg=reset($checkMsg);		
			Db::table('ike_claim_msg')
			  ->where($where)
			  ->update(['status'=>1]);
			$insert['tu_id']=$data['claimUserId'];
			$insert['claimUserId']=$data['userId'];
			//$insert['relationship']=$checkMsg['relationship'];
			$insert['creditScore']=$checkMsg['creditScore'];
			$insert['claim_time']=date('Y-m-d H:i:s',time());
			$result=Db::table('ike_friends_claim')
					->insert($insert);
			if($result)
			{
				return 200;
			}else{
				return 0;
			}
		}else{
			$result=Db::table('ike_claim_msg')
					  ->where($where)
					  ->update(['status'=>1]);
			if($result)
			{
				return 200;
			}else{
				return 0;
			}
		}

	}
	
	//关系网图谱（直接关系）
	public function directNexusChart(array $data)
	{
		$datas=array();
		//查询当前用户是否有推荐用户
		$recommender=Db::table('ike_recommend_content')
					->where('userId',$data['userId'])
					->select();
		$datas['recommender']=array();
		if($recommender)
		{
			foreach($recommender as $k=>$v)
			{
				$userinfo=$this->userinfo($v['tu_id']);
				if(!$userinfo)
				{
					continue;
				}
				$users[$k]['userId']=$userinfo['tu_id'];
				$users[$k]['nickname']=$userinfo['nickname'];
				$users[$k]['userPortraitUrl']=$userinfo['avatar_image'];
				//$datas['recommender'][$k]['userId']=$userinfo['tu_id'];
				//$datas['recommender'][$k]['nickname']=$userinfo['nickname'];
				//$datas['recommender'][$k]['userPortraitUrl']=$userinfo['avatar_image'];
			}
			$datas['recommender']=array_values($users);
		}
		//查询当前用户的推荐人
		$beRecommender=Db::table('ike_recommend_content')
						->where('tu_id',$data['userId'])
						->select();
		$datas['beRecommender']='';
		if($beRecommender)
		{
			$beRecommender=reset($beRecommender);
			$userinfo=$this->userinfo($beRecommender['userId']);
			if($userinfo)
			{
				$datas['beRecommender']['userId']=$userinfo['tu_id'];
				$datas['beRecommender']['nickname']=$userinfo['nickname'];
				$datas['beRecommender']['userPortraitUrl']=$userinfo['avatar_image'];
			}
			
		}
		//查询认领列表
		$claimUser=Db::table('ike_friends_claim')
					->where('claimUserId',$data['userId'])
					->select();
		$datas['claimUser']=array();
		if($claimUser)
		{
			foreach($claimUser as $k=>$v)
			{
				$userinfo=$this->userinfo($v['tu_id']);
				if(!$userinfo)
				{
					continue;
				}
				$datas['claimUser'][$k]['userId']=$userinfo['tu_id'];
				$datas['claimUser'][$k]['nickname']=$userinfo['nickname'];
				$datas['claimUser'][$k]['userPortraitUrl']=$userinfo['avatar_image'];
			}
		}
		//查询被认领者
		$wasClaimed=Db::table('ike_friends_claim')
					->where('tu_id',$data['userId'])
					->select();
		$datas['wasClaimed']='';
		if($wasClaimed)
		{
			$wasClaimed=reset($wasClaimed);
			$userinfo=$this->userinfo($wasClaimed['claimUserId']);
			if($userinfo)
			{
				$datas['wasClaimed']['userId']=$userinfo['tu_id'];
				$datas['wasClaimed']['nickname']=$userinfo['nickname'];
				$datas['wasClaimed']['userPortraitUrl']=$userinfo['avatar_image'];
			}
			
		}
		return $datas;
	}
	/*
	//关系网图谱(间接关系)
	public function indirect_nexus_chart(array $data)
	{
		$a=array();
		$where['tu_id']=$data['userId'];
		$where['mobile']=$data['friend_userid'];
		//查询当前用户是否为推荐用户
		$current=Db::table('ike_recommend_content')
					->where('mobile',$data['userId'])
					->select();
		//查询对方用户是否为推荐用户
		$other=Db::table('ike_recommend_content')
				->where('mobile',$data['friend_userid'])
				->select();
		$check_us=Db::table('ike_user')
					->where('tu_id',$data['friend_userid'])
					->select();
		if($current==null&&$other==null&&$check_us){  //A系统用户  B为系统用户
			return '同事';
		}
		if(!$check_us){
			return '未知';
		}
		if($current==null&&$other)  //A系统用户  B为推荐用户
		{
			
			$nexus=Db::table('ike_recommend_content')
					->where($where)
					->select();
			//echo Db::getLastSql();exit;
			if($nexus){    //两者为推荐关系
				$nexus=reset($nexus);
				$where1['tu_id']=$nexus['mobile'];
				$where1['claim_user']=$nexus['tu_id'];
				$nexus1=Db::table('ike_friends_claim')
						->where($where1)
						->select();
				if($nexus1){    //认领
					return $nexus['tu_id'].'—>推荐、认领—>'.$nexus['mobile'];
				}else{
					return $nexus['tu_id'].'—>推荐—>'.$nexus['mobile'];
				}			
			}else{       //两者不为推荐关系
				$where2['tu_id']=$data['friend_userid'];
				$where2['claim_user']=$data['userId'];
				$nexus2=Db::table('ike_friends_claim')
						->where($where2)
						->select();
				if($nexus2){   //两者为直接认领关系
					return $data['tu_id'].'——>认领——>'.$data['friend_userid'];
				}else{         //两者不为直接认领关系
					$where3['tu_id']=$data['userId'];
					$recommends=Db::table('ike_recommend_content')
								->where($where3)
								->select();
					if($recommends){  //A所有推荐用户
					//var_dump($recommends);exit;
						foreach($recommends as $k=>$v){
							$where4['claim_user']=$v['mobile'];
							//$where4['tu_id']=$data['friend_userid'];
							$claims=Db::table('ike_friends_claim')
									->where($where4)
									->select();
									//var_dump($claims);exit;
							//echo Db::getLastSql();exit;
							if($claims){  //推荐用户下所有认领用户
								foreach($claims as $k1=>$v1 ){
									$where5['claim_user']=$v1['claim_user'];
									$where5['tu_id']=$data['friend_userid'];
									$claims1=Db::table('ike_friends_claim')
											->where($where5)
											->select();
									//echo Db::getLastSql();exit;
									if($claims1){
										$a= $data['userId'].'—>推荐—>'.$v1['claim_user'].'—>认领—>'.$data['friend_userid'];
									}
								}
							}
						}
						if(empty($a)){
							return '平台关系';
						}else{
							return $a;
						}
					}else{
						return '平台关系';
					}
				}
			}
		}
	}*/
	//信誉值统计
	public function reputationStatistics($userId)
	{
		$where['userId']=$userId;
		//信誉总分
		$creditScore=0;
		//认领信誉分
		$friendsClaim=Db::table('ike_friends_claim')
						->where('claimUserId',$userId)
						->field('creditScore')
						->select();
		if($friendsClaim)
		{
			$friendsClaim=reset($friendsClaim);
			$creditScore+=$friendsClaim['creditScore'];
		}
		//推荐信誉分
		$recommendContent=Db::table('ike_recommend_content')
						->where('tu_id',$userId)
						->field('creditScore')
						->select();
		if($recommendContent)
		{
			$recommendContent=reset($recommendContent);
			$creditScore+=$recommendContent['creditScore'];
		}
		return $creditScore;
	}
	//贡献统计总分
	public function contributionScore($userId)
	{
		$contributionScore=0;
		//认领成功获取5个贡献值
		$contributionClaim=Db::table('ike_friends_claim')
						->where('tu_id',$userId)
						->select();
		$num=count($contributionClaim);
		$contributionScore+=$num*5;
		return $contributionScore;
	}
	//查看更多个人详情信息
	public function selectMoreUserInfo(array $data)
	{
		$result=Db::table('ike_more_userinfo')
				->where('tu_id',$data['userId'])
				->select();
		$datas=array();
		//信誉总分
		$datas['creditScore']=$this->reputationStatistics($data['userId']);
		//贡献总分
		$datas['contributionScore']=$this->contributionScore($data['userId']);
		if($result)
		{
			$result=reset($result);
			$datas['fullName']=json_decode($result['fullName'],true);
			$datas['QQ']=json_decode($result['QQ'],true);
			$datas['favour']=json_decode($result['favour'],true);
			$datas['finishSchool']=json_decode($result['finishSchool'],true);
			$datas['constellation']=json_decode($result['constellation'],true);
			$datas['bloodType']=json_decode($result['bloodType'],true);
			$datas['marriage']=json_decode($result['marriage'],true);
			$datas['company']=json_decode($result['company'],true);
			$datas['position']=json_decode($result['position'],true);
		}else{
			$datas['fullName']=null;
			$datas['QQ']=null;
			$datas['favour']=null;
			$datas['finishSchool']=null;
			$datas['constellation']=null;
			$datas['bloodType']=null;
			$datas['marriage']=null;
			$datas['company']=null;
			$datas['position']=null;			
		}
		return $datas;
	}
	//更多个人详情信息（设置个人信息）
	public function editMoreUserInfo(array $data)
	{
		$checkUser=$this->userinfo($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		//真实姓名
		if($data['SfullName']==1)
		{
			$fullName['status']=1;
		}else{
			$fullName['status']=0;
		}
		$fullName['name']=$data['fullName'];

		//QQ
		if($data['SQQ']==1)
		{
			$QQ['status']=1;
		}else{
			$QQ['status']=0;
		}
		$QQ['name']=$data['QQ'];
		//爱好
		if($data['Sfavour']==1)
		{
			$favour['status']=1;
		}else{
			$favour['status']=0;
		}
		$favour['name']=$data['favour'];
		//毕业学校
		if($data['SfinishSchool']==1)
		{
			$finishSchool['status']=1;
		}else{
			$finishSchool['status']=0;
		}
		$finishSchool['name']=$data['finishSchool'];
		//星座
		if($data['Sconstellation']==1)
		{
			$constellation['status']=1;
		}else{
			$constellation['status']=0;
		}
		$constellation['name']=$data['constellation'];
		//血型
		if($data['SbloodType']==1)
		{
			$bloodType['status']=1;
		}else{
			$bloodType['status']=0;
		}
		$bloodType['name']=$data['bloodType'];
		//婚姻状况
		if($data['Smarriage']==1)
		{
			$marriage['status']=1;
		}else{
			$marriage['status']=0;
		}
		if($data['marriage']==1)
		{
			$marriage['name']=1;
		}else{
			$marriage['name']=0;
		}
		//公司
		if($data['Scompany']==1)
		{
			$company['status']=1;
		}else{
			$company['status']=0;
		}
		$company['name']=$data['company'];
		//公司
		if($data['Sposition']==1)
		{
			$position['status']=1;
		}else{
			$position['status']=0;
		}
		$position['name']=$data['position'];
		$datas=array();
		$datas['tu_id']=$data['userId'];
		$datas['fullName']=json_encode($fullName);;
		$datas['QQ']=json_encode($QQ);
		$datas['favour']=json_encode($favour);
		$datas['finishSchool']=json_encode($finishSchool);
		$datas['constellation']=json_encode($constellation);
		$datas['bloodType']=json_encode($bloodType);
		$datas['marriage']=json_encode($marriage);
		$datas['company']=json_encode($company);
		$datas['position']=json_encode($position);
		$checkMoreInfo=Db::table('ike_more_userinfo')
						->where('tu_id',$data['userId'])
						->select();
		//var_dump(json_decode($checkMoreInfo[0]['constellation'],true));exit;
		if($checkMoreInfo)
		{
			$result=Db::table('ike_more_userinfo')
					->where('tu_id',$data['userId'])
					->update($datas);
		}else{
			$result=Db::table('ike_more_userinfo')
					->insert($datas);
		}
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
	}
	//查看对方信息
	public function selectUserInfo(array $data)
	{
		$userInfo=$this->userinfo($data['userId']);
		if(!$userInfo)
		{
			return 0;
		}
		$datas=array();
		if($data['status']==1)
		{
			$datas['userId']=$userInfo['tu_id'];
			$datas['numberId']=$userInfo['userid'];
			$datas['nickname']=$userInfo['nickname'];
			$datas['userPortraitUrl']=$userInfo['avatar_image'];
			$datas['sex']=$userInfo['sex'];
			$datas['mobile']=$userInfo['mobile'];
			$datas['address']=$userInfo['address'];
			$datas['birthday']=$userInfo['birth_date'];
			$datas['email']=$userInfo['email'];
			$datas['age']=$userInfo['age'];
		}else{
			$moreUserInfo=Db::table('ike_more_userinfo')
							->where('tu_id',$data['userId'])
							->select();
			if($moreUserInfo)
			{
				$moreUserInfo=reset($moreUserInfo);
				$fullName=json_decode($moreUserInfo['fullName'],true);
				if($fullName['status']==1)
				{
					$datas['fullName']=$fullName['name'];
				}
				$QQ=json_decode($moreUserInfo['QQ'],true);
				if($QQ['status']==1)
				{
					$datas['QQ']=$QQ['name'];
				}
				$favour=json_decode($moreUserInfo['favour'],true);
				if($favour['status']==1)
				{
					$datas['favour']=$favour['name'];
				}
				$finishSchool=json_decode($moreUserInfo['finishSchool'],true);
				if($finishSchool['status']==1)
				{
					$datas['finishSchool']=$finishSchool['name'];
				}
				$constellation=json_decode($moreUserInfo['constellation'],true);
				if($constellation['status']==1)
				{
					$datas['constellation']=$constellation['name'];
				}
				$bloodType=json_decode($moreUserInfo['bloodType'],true);
				if($bloodType['status']==1)
				{
					$datas['bloodType']=$bloodType['name'];
				}
				$marriage=json_decode($moreUserInfo['marriage'],true);
				if($marriage['status']==1)
				{
					$datas['marriage']=$marriage['name'];
				}
				$company=json_decode($moreUserInfo['company'],true);
				
				if($company['status']==1)
				{
					$datas['company']=$company['name'];
				}
				$position=json_decode($moreUserInfo['position'],true);
				if($position['status']==1)
				{
					$datas['position']=$position['name'];
				}
				return $datas;
			}else{
				return 0;
			}
		}
		
		return $datas;
	}
	
	//产品众筹
	public function productCollect(array $data)
	{
		//产品众筹 ：众筹内容、众筹时间、众筹人员
		//内容content
		//进展Progress
		//回报Return
		//风险risk		
		if(empty($data['userName']))
		{
			return 0;
		}
		if(empty($data['mobile']))
		{
			return 0;
		}
		if(empty($data['title']))
		{
			return 0;
		}
		if(empty($data['capital']))
		{
			return 0;
		}
		if(empty($data['content']))
		{
			return 0;
		}
		if(empty($data['days']))
		{
			return 0;
		}
		$datas=array();
		$datas['tu_id']=$data['userId'];
		$datas['userName']=$data['userName'];
		$datas['mobile']=$data['mobile'];
		$datas['title']=$data['title'];
		$datas['capital']=$data['capital'];
		$datas['content']=$data['content'];
		$datas['avatar_id']=$data['avatar_id'];
		$datas['days']=$data['days'];
		$result=Db::table('ike_product_collect')
				->insert($datas);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
		
	}
	
	//干货分享
	public function share(array $data)
	{
		$checkUser=$this->check_user($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		if(empty($data['shareContent']))
		{
			return 0;
		}
		if(empty($data['arctitle']))
		{
			return 0;
		}
		if(empty($data['typeId']))
		{
			return 0;
		}
		$datas['tu_id']=$data['userId'];
		$datas['arctitle']=$data['arctitle'];
		$datas['share_content']=$data['shareContent'];
		$datas['type_id']=$data['typeId'];
		$datas['senddate']=date('Y-m-d H:i:s',time());
		$result=Db::table('ike_share')
				->insert($datas);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//干货分享评论
	public function shareComment(array $data)
	{
		$where['share_id']=$data['shareId'];
		$where['is_show']=1;
		$checkShare=Db::table('ike_share')
					->where($where)
					->select();
		if(!$checkShare)
		{
			return 0;
		}
		$checkUser=$this->check_user($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		$where_c['share_id']=$data['shareId'];
		$where_c['tu_id']=$data['userId'];
		$checkComment=Db::table('ike_share_comment')
						->where($where_c)
						->select();
		if($checkComment)
		{
			return 100;
		}
					
		$datas['share_id']=$data['shareId'];
		$datas['tu_id']=$data['userId'];
		$datas['content']=$data['content'];
		$datas['comment_time']=date('Y-m-d H:i:s',time());
		$result=Db::table('ike_share_comment')
				->insert($datas);
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
	}
	
	//获取干货分享所有评论
	public function allShareComment(array $data)
	{
		$where['share_id']=$data['shareId'];
		$where['is_show']=1;
		$checkShare=Db::table('ike_share')
					->where($where)
					->select();
		if(!$checkShare)
		{
			return 0;
		}
		$where_c['share_id']=$data['shareId'];
		$all_comment=Db::table('ike_share_comment')
						->where($where_c)
						->select();
		if($all_comment)
		{
			$datas=array();
			foreach($all_comment as $k=>$v)
			{
				$userinfo=$this->userinfo($v['tu_id']);
				$datas[$k]['userId']=$v['tu_id'];
				$datas[$k]['nickname']=$userinfo['nickname'];
				$datas[$k]['avatarImage']=$userinfo['avatar_image'];
				$datas[$k]['content']=$v['content'];
				$datas[$k]['commentTime']=$v['comment_time'];
			}
			return $datas;
		}else{
			return 0;
		}
	}
	
	//干货分享点赞
	public function sharePraise(array $data)
	{
		$where['share_id']=$data['shareId'];
		$where['is_show']=1;
		$checkShare=Db::table('ike_share')
					->where($where)
					->select();
		if(!$checkShare)
		{
			return 0;
		}
		$checkUser=$this->check_user($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		if($_POST['praise']==1)
		{
			$datas['praise']=1;
		}else{
			$datas['praise']=0;
		}
		$where_c['share_id']=$data['shareId'];
		$where_c['tu_id']=$data['userId'];
		$checkPraise=Db::table('ike_share_praise')
					->where($where_c)
					->select();
		if($checkPraise)
		{
			return 100;
		}
		$datas['share_id']=$data['shareId'];
		$datas['tu_id']=$data['userId'];
		$datas['praise_time']=date('Y-m-d H:i:s');
		$result=Db::table('ike_share_praise')
				->insert($datas);
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
	}
	
	//干货分享举报
	public function shareReport(array $data)
	{
		$checkUser=$this->userinfo($data['userId']);
		if(!$checkUser)
		{
			return 0;
		}
		$where['share_id']=$data['shareId'];
		$where['is_show']=1;
		$checkShare=Db::table('ike_share')
					->where($where)
					->select();
		if(!$checkShare)
		{
			return 0;
		}
		$where_c['tu_id']=$data['userId'];
		$where_c['share_id']=$data['shareId'];
		$checkReport=Db::table('ike_share_report')
					->where($where_c)
					->select();
		if($checkReport)
		{
			return 100;
		}
		$datas['tu_id']=$data['userId'];
		$datas['share_id']=$data['shareId'];
		$datas['report_id']=$data['reportId'];
		$datas['report_time']=date('Y-m-d H:i:s',time());
		if(!empty($data['reportContent']))
		{
			$datas['report_content']=$data['reportContent'];
		}
		$result=Db::table('ike_share_report')
				->insert($datas);
		if($result)
		{
			return 200;
		}else{
			return 0;
		}
	}
	
	//创建群公告
	public function groupNotice(array $data)
	{
		$group_info=$this->group_no_info($data['groupId']);
		if(!$group_info)
		{
			return 0;
		}
		$where['tu_id']=$data['userId'];
		$where['group_id']=$group_info['group_id'];
		$checkAdmin=Db::table('ike_group_user')
					->where($where)
					->select();
		if(!$checkAdmin)
		{
			return 0;
		}
		if(!$checkAdmin[0]['status'])
		{
			return 0;
		}
		$datas['tu_id']=$data['userId'];
		$datas['group_id']=$group_info['group_id'];
		$datas['nitece_content']=$data['niteceContent'];
		$datas['addtime']=date('Y-m-d H:i:s',time());
		$result=Db::table('ike_group_notice')
				->insert($datas);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	//查看当前群公告
	public function queryGroupNotice(array $data)
	{
		$group_info=$this->group_no_info($data['groupId']);
		$where['group_id']=$group_info['group_id'];
		$datas=array();
		if($data['show']==1)
		{
			$result=Db::table('ike_group_notice')
					->where($where)
					->whereTime('addtime','<=',date('Y-m-d H:i:s',time()))
					->order('addtime desc')
					->limit(1)
					->select();
			if(!$result)
			{
				return 0;
			}
			$result=reset($result);
			$userinfo=Db::table('ike_group_user')
						->where('tu_id',$result['tu_id'])
						->select();
			if(!$userinfo){
				return 0;
			}
			$userinfo=reset($userinfo);
			$datas[0]['nickname']=$userinfo['nickname'];
			$datas[0]['addtime']=$result['addtime'];
			$datas[0]['niteceContent']=$result['nitece_content'];
		}else{
			$result=Db::table('ike_group_notice')
					->where($where)
					->whereTime('addtime','<=',date('Y-m-d H:i:s',time()))
					->order('addtime desc')
					->select();
			if(!$result)
			{
				return 0;
			}
			foreach($result as $k=>$v)
			{
				$userinfo=Db::table('ike_group_user')
						->where('tu_id',$v['tu_id'])
						->select();
				$userinfo=reset($userinfo);
				$datas[$k]['nickname']=$userinfo['nickname'];
				$datas[$k]['addtime']=$v['addtime'];
				$datas[$k]['niteceContent']=$v['nitece_content'];
			}
		}
		return $datas;
				
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