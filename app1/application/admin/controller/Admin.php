<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Session;
use think\Config;
use think\Request;

class Admin extends AdminBase
{
	public function index()
	{
		//$user=Session::get(Config::get('USER_AUTH_KEY'),'login');
		//var_dump($user);exit;
		//$view=new View();
		
		return $this->fetch();
		
	}
	public function edit()
	{
		if (Request::instance()->isPost()){
				$file = request()->file('avatar');
				if(!empty($file)){
					// 移动到应用根目录/public/uploads/ 目录下
					$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
					if($info){
						Db::startTrans();
						try{
							//上传路径
							$path['avatar_image']='/public/uploads/'.$info->getSaveName();
							
							//上传头像
							$upfile=Db::table('ike_avatar')
										->insert($path);
										
							//获取上传头像id
							$avatar_id = Db::table('ike_avatar')->getLastInsID();
							if(empty($_POST['password'])){
								unset($_POST['password']);
							}else{
								$_POST['password']=md5($_POST['password']);
							}
							$_POST['avatar_id']=$avatar_id;
							//更新管理员用户信息
							$result=Db::table('ike_admin')
							->where('admin_id',$this->userID())
							->update($_POST);
							// 提交事务
							Db::commit();
						} catch (\Exception $e) {
							// 回滚事务
							Db::rollback();
						}
						if($result){
							$this->success('修改成功');
						}else{
							$this->error('修改失败');
						}
					}else{
						// 上传失败获取错误信息
						return '图片上传失败';
					}
				}else{
					Db::startTrans();
					try{
						if(empty($_POST['password'])){
							unset($_POST['password']);
						}else{
							$_POST['password']=md5($_POST['password']);
						}
						//更新管理员用户信息
						$result=Db::table('ike_admin')
						->where('admin_id',$this->userID())
						->update($_POST);
						// 提交事务
						Db::commit();
					} catch (\Exception $e) {
						// 回滚事务
						Db::rollback();
					}
					if($result){
						$this->success('修改成功');
					}else{
						$this->error('修改失败');
					}
				}
		}
	}
	public function add(){
		echo 1;exit;
	}
}