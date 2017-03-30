<?php
namespace app\appapi\model;

use \think\Model;
use think\Db;

class User extends Model
{
	//会员注册
	public function register(array $data)
	{	
		$datas=array();
		$datas['tu_id']=trim($data['mobile']);
		$datas['token']=$data['token'];		
		$datas['nickname']=trim($data['nickname']);
		$datas['password']=md5($data['password']);
		$datas['mobile']=trim($data['mobile']);
		$datas['gen_time']=date('Y-m-d :H:i:s',time());
		$result=Db::table('ike_user')
					->insert($datas);
		if($result){				
			return 1;			
		}else{
			return 0;
		}	
	}
	
	//查询会员个人信息
	
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
	
	//登录用户
	public function login(array $data)
	{
		$where['tu_id']=trim($data['mobile']);
		$result=Db::view('user','*')
					->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		@$result=reset($result);
		if(empty($result) || $result['status']==0 || $result['password'] !== md5($data['password'])){
			if(empty($result)){
				return 0;//账号不存在
			}elseif($result['status']==0){
				return 1000;//账号禁止登录
			}elseif($result['password'] !== md5($data['password'])){
				return 1001;//密码错误
			}
		}
		unset($result['password']);
		return $result;
	}
	
	//查询好友
	public function addfriends($tu_id)
	{
		if(empty($tu_id)){
			return 0;
		}
		$where['tu_id']=$tu_id;			
		$result=Db::view('user','*')
					->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		$result=reset($result);
		if($result){
			return $result;
		}else{
			return 100;
		}	
	}
	
	//添加好友--发送请求
	public function addfriend_request(array $data)
	{
		$datas=array();
		$datas['tu_id']=trim($data['userId']);
		$datas['f_tu_id']=trim($data['f_userid']);
		$datas['nickname']=$data['nickname'];
		if(!empty($data['addFriendMessage'])){
			$datas['note']=$data['addFriendMessage'];
		}	
		$datas['addtime']=date('Y-m-d H:i:s',time());
		$datas['status']=3;
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['f_userid'];
		//查询好友是否存在
		$friend_id=Db::table('ike_friends_user')
					   ->where($where)
					   ->select();
		//echo Db::getLastSql();exit;
		if($friend_id){
			return 11; //好友存在
		}else{
			$request['tu_id']=$data['userId'];
			$request['f_tu_id']=$data['f_userid'];
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
	public function all_unread_friends(array $data)
	{
		if(empty($data['userId'])){
			return 0;
		}
		$where['f_tu_id']=$data['userId'];
		$where['status']=3;
		$result=Db::table('ike_add_friends_request')
					->where($where)
					->field('tu_id')
					->select();
		if(empty($result)){
			return 100;
		}
		foreach($result as $k=>$v)
		{
			$result[$k]['userId']=$v['tu_id'];
			unset($result[$k]['tu_id']);
		}
		return $result;
	}
	
	//获取申请添加用户(all)
	public function all_addfriend_request(array $data)
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
				$result=reset($result);
				$all_user[$k]['avatar_image']=$result['avatar_image'];
				$all_user[$k]['mobile']=$result['mobile'];
				$all_user[$k]['email']=$result['email'];
			}
			//echo Db::getLastSql();exit;
			return $all_user;

		}else{
			return 100;
		}
		
	}
	
	//确认添加好友
	public function confirm_friend(array $data)
	{
		switch($data['status']){
			case 0:
				$set['status']=0;
				$result=Db::table('ike_add_friends_request')
					->where('tu_id',trim($data['f_userid']))
					->update($set);
				if($result){
					return 1000;
				}else{
					return 101;
				}
				break;
			case 1:
				$where_f['tu_id']=trim($data['userId']);
				$frends=Db::table('ike_friends_user')
							->where($where_f)
							->select();
				$f_tu_id=array();
				foreach($frends as $key=>$value){
					$f_tu_id[]=$value['friend_id'];
				}
				//var_dump($f_tu_id);exit;
				$check=in_array($data['f_userid'],$f_tu_id);
				if(!$check){
					$userinfo=Db::table('ike_user')
								->where('tu_id',$data['f_userid'])
								->select();
					$f_friends=Db::table('ike_user')
								->where('tu_id',$data['userId'])
								->select();
					if($userinfo){
						$userinfo=reset($userinfo);
						$user_nickname=$userinfo['nickname'];
					}else{
						$user_nickname='';
					}
					if($f_friends){
						$f_friends=reset($f_friends);
						$f_nickname=$f_friends['nickname'];
					}else{
						$f_nickname='';
					}
					$datas=[
						['tu_id'=>$data['userId'],'friend_id'=>$data['f_userid'],'addtime'=>date('Y-m-d H:i:s',time()),'displayname'=>$user_nickname],
						['tu_id'=>$data['f_userid'],'friend_id'=>$data['userId'],'addtime'=>date('Y-m-d H:i:s',time()),'displayname'=>$f_nickname],
					];
					$result=Db::table('ike_friends_user')
							->insertAll($datas);
					if($result){
						//$data['userid']  当前用户
						//$data['f_userid'] 添加用户
						$where['tu_id']=$data['f_userid'];
						$where['f_tu_id']=$data['userId'];
						$where['status']=3;
						$user=Db::table('ike_add_friends_request')
								   ->where($where)
								   ->select();
						//echo Db::getLastSql();exit;
						if($user){
							$set['status']=1;
							$where1['tu_id']=$data['userId'];
							$where1['f_tu_id']=$data['f_userid'];
							$user1=Db::table('ike_add_friends_request')
								   ->where($where1)
								   ->select();
							if($user1){
								Db::table('ike_add_friends_request')
								->where('tu_id',$data['f_userid'])
								->update($set);
							}
							Db::table('ike_add_friends_request')
								->where('tu_id',$data['f_userid'])
								->update($set);
										
							
						}
						
						return 200;
					}else{
						return 101;
					}
				}else{
					return 101;
				}
				
				break;
			case 2:
				$set['status']=2;
				$result=Db::table('ike_add_friends_request')
					->where('tu_id',$data['f_userid'])
					->update($set);
				if($result){
					return 2000;
				}else{
					return 101;
				}
				
				break;
			
		}
		
	}
	
	//删除好友
	public function deleteUser(array $data)
	{
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['f_userid'];
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
		if(empty($data['userId'])){
			return 0;
		}
		$where['tu_id']=trim($data['userId']);
		
		$result=Db::table('ike_friends_user')
					   ->where($where)
					   ->select();
					   
		//echo Db::getLastSql();
		//var_dump($result);exit;
		$datas=array();
		if($result){
			
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
			return 100; //没有好友
		}
	}
	
	
	//随机6位群号
	public function group_no(){
			$num=array(1,2,3,4,5,6,7,8,9,0);
			$rand=array_rand($num,5);
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
		if($result){
			$this->check_group_no();
		}else{
			return $group_no;
		}
	}
	//创建群组
	//$data 	   群信息
	//$group_no    群主id
	//$groups      群成员
	public function create_group(array $data,$group_no,$group_users)
	{
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
				Db::table('ike_group_user')
						->insert($groups);

			}
			
			$groupInfo=Db::view('group_name','tu_id')
					->view('avatar','avatar_image','group_name.avatar_id=avatar.avatar_id')
					->where('group_id',$group_id)
					->select();
			$groupInfo=reset($groupInfo);
			//return 1;
			return $groupInfo['avatar_image'];
		}
	}
	
	//用户所在群（all）
	public function group_data(array $data)
	{
		if(empty($data['userId'])){
			return 0;
		}
		$where['tu_id']=$data['userId'];
		$groups=Db::table('ike_group_user')
					->where($where)
					->field('group_id')
					->select();
		if(empty($groups)){
			return 100;
		}
		$datas=array();
		foreach($groups as $k=>$v){
			$group_info=Db::view('group_name','group_name,group_number,tu_id')
					->view('avatar','avatar_image','group_name.avatar_id=avatar.avatar_id')
					->where('group_id',$v['group_id'])
					->select();
			$group_info=reset($group_info);
			$datas[$k]=$group_info;
			
		}
		$result=array();
		foreach($datas as $k=>$v)
		{
			if($v['tu_id']==$data['userId'])
			{
				$result[$k]['role']=1;
			}else{
				$result[$k]['role']=0;
			}
			$result[$k]['groupId']=$v['group_number'];
			$result[$k]['groupName']=$v['group_name'];
			$result[$k]['groupPortraitUrl']=$v['avatar_image'];
		}
		return $result;
		
	}
	
	//群组信息
	public function group_info(array $data)
	{

		$where['group_number']=$data['groupId'];
		$result=Db::table('ike_group_name')
					->where($where)
					->select();
		if($result){
			$result=reset($result);
			if($result['tu_id']==$data['userId']){
				$result['role']=1;
			}else{
				$result['role']=0;
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
	public function group_member(array $data)
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
				if($v['tu_id']==$result['tu_id']){
					$role=1;
				}else{
					$role=0;
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
				$group_users[$k]['userPortraitUrl']=$avatar_img['avatar_image'];
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
	public function change_groupName(array $data)
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
		$avatar=Db::view('group_name','group_id')
					->view('avatar','avatar_image','group_name.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		$avatar=reset($avatar);
		if($result){
			return $avatar['avatar_image'];
		}else{
			return 0;
		}

	}
	
	//修改个人群昵称
	public function change_userName(array $data)
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
			return 1;
		}
		
		
		
	}
	
	//获取群信息
	
	public function group_no_info($groupId)
	{
		$where['group_number']=$groupId;
		$result=Db::table('ike_group_name')
					->where($where)
					->select();
		$result=reset($result);
		return $result;
	}
	
	//群主拉人
	//$group_users   用户
	//$groupId       群id
	public function GroupPullUser($group_users,$groupId)
	{
		$users=array();
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
				$datas['content']='群主拉人';
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
		if(empty($data['userId'])){
			return 0;
		}
		$update['displayname']=trim($data['displayName']);
		$where['tu_id']=$data['userId'];
		$where['friend_id']=$data['f_userid'];
		$result=Db::table('ike_friends_user')
					->where($where)
					->update($update);
		return 1;
		
	}
	//修改个人信息
	public function editUserInfo(array $data,$avatar_id)
	{
		if(!empty($data['nickname'])){
			$update['nickname']=trim($data['nickname']);
		}
		/*
		if(!empty($data['sex'])){
			$update['sex']=trim($data['sex']);
		}
		*/
		if($data['sex']==2){
			$update['sex']=2;
		}elseif($data['sex']==1){
			$update['sex']=1;
		}else{
			$update['sex']=0;
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
		if(!empty($data['birthDate'])){
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
		$group_info=$this->group_no_info($data['group_id']);
		
		$where['group_id']=$group_info['group_id'];
		$group=Db::table('ike_group_name')
					->where($where)
					->select();
		$group=reset($group);
		if($group['tu_id']==$data['userId']){

			$datas['actives_title']=$data['actives_title'];
			$datas['avatar_id']=$data['avatar_id'];
			$datas['actives_content']=$data['actives_content'];
			if(trim($data['actives_limit'])!=""){
				$datas['actives_limit']=$data['actives_limit'];
			}

			$datas['actives_start']=$data['actives_start'];
			$datas['actives_end']=$data['actives_end'];
			$datas['actives_address']=$data['actives_address'];
			$datas['tu_id']=$data['userId'];
			$datas['group_id']=$data['group_id'];
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
		}else{
			return 0;
		}
		
	}
	
	//加入群活动
	public function joinActives(array $data)
	{
		$where['actives_id']=$data['actives_id'];
		$actives=Db::table('ike_actives')
					->where($where)
					->select();
		$where['tu_id']=$data['userId'];
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
		$group_id=Db::table('ike_group_name')
					->where('group_number',$actives['group_id'])
					->field('group_id')
					->select();
		if($group_id)
		{
			$group_id=reset($group_id);
			$group_users=Db::table('ike_group_user')
						->where('group_id',$group_id['group_id'])
						->select();
		}else{
			return 0;
		}
		$users=array();
		foreach($group_users as $k=>$v)
		{
			$users[$k]=$v['tu_id'];
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
		$datas['actives_id']=$data['actives_id'];
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
		if(empty($data['groupId'])){
			return 0;
		}
		$where['group_id']=$data['groupId'];
		$actives=Db::view('actives','*')
					->view('avatar','avatar_image','actives.avatar_id=avatar.avatar_id')
					->where($where)
					->select();
		if(!empty($actives))
		{
			$datas=array();
			foreach($actives as $k=>$v)
			{
				$datas[$k]['actives_id']=$v['actives_id'];
				$datas[$k]['actives_title']=$v['actives_title'];
				$datas[$k]['actives_image']=$v['avatar_image'];
				$datas[$k]['actives_limit']=$v['actives_limit'];
				$datas[$k]['actives_start']=$v['actives_start'];
				$datas[$k]['actives_end']=$v['actives_end'];
				$datas[$k]['actives_address']=$v['actives_address'];
				$datas[$k]['actives_content']=$v['actives_content'];
				$checkJoin=Db::table('ike_actives_join')
							->where(['actives_id'=>$v['actives_id'],'tu_id'=>$data['userId']])
							->select();
				if($checkJoin)
				{
					$datas[$k]['status']=1;
				}else{
					$datas[$k]['status']=0;
				}
			}
			return $datas;
		}else{
			return 100;
		}
		
	}
	
	//活动详情
	public function infoActives(array $data)
	{
		$where['actives_id']=$data['actives_id'];
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
				$datas[$k]=$userinfo;
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
		if($found_user==$group_user)
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
				$datas['content']='群主踢人';
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
	
	//群 推荐好友
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
	public function check_join_user(array $data,$groupId)
	{
		if(trim($data['status'])!=""){
			$status=$data['status'];
		}
		$check_where['tu_id']=$data['group_userId'];
		$check_where['group_number']=$data['group_id'];
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
	//申请加入群信息(所在群)
	public function group_apply_user($groupId,$userId)
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
					->where('tu_id',$userId)
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
		//var_dump($result);exit;
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
				$apply[$k]['addtime']=$v['addtime'];
				
			}
			return $apply;
		}else{
			return 0;
		}
		
		
	}
	
	//申请加入群信息（所有群）
	public function all_group_apply_user($userId)
	{

		$checkWhere['tu_id']=$userId;
		$groups=Db::table('ike_group_name')
					->where($checkWhere)
					->select();
		if(!$groups){
			return 0;
		}
		$apply=array();
		foreach($groups as $k=>$v)
		{
			$where['group_id']=$v['group_id'];
			$where['type']=5;
			$where['status']=0;
			$users=Db::table('ike_group_sys_msg')
					->where($where)
					->select();
			/*
			if(empty($apply[$k])){
				unset($apply[$k]);
			}*/
			if(!$users)
			{
				continue;
			}
			foreach($users as $k1=>$v1)
			{
				$v1['groupId']=$v['group_number'];
				$v1['groupName']=$v['group_name'];
				$apply[]=$v1;
			}
			
		}
		if(empty($apply))
		{
			return 0;
		}
		foreach($apply as $k=>$v)
		{
			
			$users=$this->userinfo($v['tu_id']);
			if(!$users){
				continue;
			}
			$apply_users[$k]['groupId']=$v['groupId'];
			$apply_users[$k]['groupName']=$v['groupName'];
			$apply_users[$k]['userId']=$v['tu_id'];
			$apply_users[$k]['nickname']=$users['nickname'];
			$apply_users[$k]['avatarImage']=$users['avatar_image'];
			//$apply_users[$key][$k]['content']=$v['content'];
			$apply_users[$k]['addtime']=$v['addtime'];
		}

		return $apply_users;
		
	}
	//投票主题创建
	public function found_vote(array $data)
	{
		$where['group_number']=$data['group_id'];
		$where['tu_id']=$data['userId'];
		$group_user=Db::view('group_name','group_id')
					->view('group_user','tu_id','group_user.group_id=group_name.group_id')			
					->where($where)
					->select();
		if($group_user){
			$datas=array();
			$datas['vote_title']=$data['vote_title'];
			$datas['add_time']=date('Y-m-d H:i:s',time());
			$datas['end_time']=$data['end_time'];
			$datas['tu_id']=$data['userId'];
			$datas['group_id']=$group_user[0]['group_id'];
			$datas['mode']=$data['mode'];
			$vote=Db::table('ike_vote_theme')
					->insert($datas);
			$vote_id = Db::name('ike_vote_theme')->getLastInsID();
			if($vote_id){
				$option=json_decode($data['vote_option'],true);
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
		}else{
			return 0;
		}
	}
	
	//投票主题列表
	public function vote_list(array $data)
	{
		$where['group_number']=$data['group_id'];
		$result=Db::view('vote_theme','vote_id,vote_title,add_time,end_time')
				//->view('vote_option','item_id,vote_content','vote_theme.vote_id=vote_option.vote_id')
				->view('group_name','group_id','vote_theme.group_id=group_name.group_id')
				->where($where)
				->select();
		if($result)
		{
			
			foreach($result as $k=>$v)
			{
				unset($result[$k]['group_id']);
				$end_time=strtotime($v['end_time']);
				if($end_time>time())
				{
					$result[$k]['status']=1;
				}else{
					$result[$k]['status']=0;
				}
			}
			return $result;
		}else{
			return 0;
		}
		//echo Db::getLastSql();exit;
		
	}
	
	//投票主题详情
	public function vote_details(array $data)
	{
		$groupInfo=Db::table('ike_group_name')
					->where('group_number',$data['group_id'])
					->select();
		if(!$groupInfo)
		{
			return 0;
		}
		$groupInfo=reset($groupInfo);
		$where['group_id']=$groupInfo['group_id'];
		$where['vote_id']=$data['vote_id'];
		$result=Db::view('vote_theme','vote_id,vote_title,add_time,end_time,tu_id,mode')
				->view('group_name','group_id','vote_theme.group_id=group_name.group_id')
				->where($where)
				->select();
		
		if($result){
			$result=reset($result);
			$check_where['vote_id']=$data['vote_id'];
			$check_where['tu_id']=$data['userId'];
			$check_vote_collect=Db::table('ike_vote_collect')
								->where($check_where)
								->select();
			$result['joinUsers']=array();
			if($check_vote_collect)
			{
				$all_joinUser=Db::table('ike_vote_collect')
								->where('vote_id',$data['vote_id'])
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
						$join_info[$k]['avatar_image']=$userinfo['avatar_image'];
						
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
			if(!$options)
			{
				return 0;
			}
			foreach($options as $key=>$value)
			{
				$result['option'][$key]=array('id'=>$value['item_id'],'content'=>$value['vote_content']);
			}
			return $result;
		}else{
			return 0;
		}
	
	}
	
	//投票选择
	public function vote_collect(array $data)
	{
		$where['vote_id']=$data['vote_id'];
		$where['group_number']=$data['group_id'];
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
				$item_id=json_decode($data['vote_option'],true);
				$item_ids='';
				foreach($item_id as $k=>$v)
				{
					$item_ids.=$v.',';
				}
				$it=explode(',',trim($item_ids,','));
				$check_option=Db::table('ike_vote_option')
								->where('vote_id',$data['vote_id'])
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
				$check_where['vote_id']=$data['vote_id'];
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
	
	//获取所以认领用户
	public function all_friends_claim(array $data)
	{
		/*$result=Db::view('user','tu_id,nickname,mobile,gen_time')
				->view('avatar','avatar_image','user.avatar_id=avatar.avatar_id')
				->view('problem','problem_title','user.tu_id=problem.tu_id')
				->where("user.tu_id not in('00001','".$data['userId']."')")
				->select();
				*/
		$friends=Db::table('ike_friends_user')
					->where('tu_id',$data['userId'])
					->select();
		foreach($friends as $k=>$v)
		{
			$f_friends=Db::table('ike_friends_user')
						->where('tu_id',$v['friend_id'])
						->select();
		}
		//var_dump($result);exit;
		$check_claim=Db::table('ike_friends_claim')
						->where('claim_user',$data['userId'])
						->field('tu_id')
						->select();
		//var_dump($result);exit;
		if($result){
			if($check_claim)
			{
				foreach($result as $k=>$v)
				{
					$result[$k]['check_claim']=0;
					foreach($check_claim as $k1=>$v1)
					{
						if($v['tu_id']==$v1['tu_id'])
						{
							$result[$k]['check_claim']=1;
						}
						
					}					
				}
				return $result;
			}else{
				foreach($result as $k=>$v)
				{
					$result[$k]['check_claim']=0;
				}
				return $result;
			}
			
		}else{
			return 0;
		}
		
		
	}
	
	//认领用户
	public function claim_user(array $data)
	{
		$where['tu_id']=$data['friends_userId'];
		$where['claim_user']=$data['userId'];
		$chaims=Db::table('ike_friends_claim')
				->where($where)
				->select();
		if($chaims)
		{
			return 100;
		}else{
			if(!empty($data['answer'])){
				$answer_info=Db::view('user','tu_id')
							->view('problem','answer','user.tu_id=problem.tu_id')
							->where('tu_id',$data['friends_userId'])
							->select();
				$answer_info=reset($answer_info);
				if($answer_info['answer']==$data['answer']){
					$datas['tu_id']=$data['friends_userId'];
					$datas['claim_user']=$data['userId'];
					$datas['claim_time']=date('Y-m-d :H:i:s',time());
					
					$result=Db::table('ike_friends_claim')
							->insert($datas);
					if($result){
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
		
	}
	
	//申请加入群(无)
	public function application_group(array $data)
	{
		
	}
	
	
	
	
	
	
	
	
	
	
	
}