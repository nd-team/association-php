<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Adminusers;

class Adminuser extends AdminBase
{
	public $adminuserModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->adminuserModel=new Adminusers;
	}
	//用户列表
	public function index()
	{
		$AllUser=$this->adminuserModel->get_alluser();
		$AllUsers=json_decode($AllUser['all'],true);
		
		foreach($AllUsers['data'] as $k=>$v){
			if($v['status']==1){
				$AllUsers['data'][$k]['status']='开启';
				$AllUsers['data'][$k]['st']=1;
				$AllUsers['data'][$k]['bt']='btn-yellow';
			}else{
				$AllUsers['data'][$k]['status']='禁止';
				$AllUsers['data'][$k]['st']=0;
				$AllUsers['data'][$k]['bt']='btn-danger';
			}
		}
		$this->assign('AllUser',$AllUsers['data']);
		$this->assign('page', $AllUser['page']);
		return $this->fetch();
	}
	//ajax状态修改
	public function adminuser_status()
	{
		if (Request::instance()->isAjax())
		{
			$where['groupid']=$_POST['id'];
			if($_POST['status']==1)
			{
				$update['status']=0;
				$data='error';
			}else{
				$update['status']=1;
				$data='ok';
			}
			$result=Db::table('ike_admin')
						->where($where)
						->update($update);
			if($result)
			{
				$this->success($data);
			}else{
				$this->error($data);
			}
		}
	}
	//修改
	public function edit(){
		if (Request::instance()->isGet())
		{
			$where['admin_id']=$_GET['id'];
			$rule=Db::table('ike_admintype')
					->field('groupid,type_name')
					->select();
			foreach($rule as $k=>$v)
			{
				if($v['type_name']=='超级管理员'){
					unset($rule[$k]);
				}
			}
			$result=Db::table('ike_admin')
						->where($where)
						->select();
			$result=reset($result);
			//var_dump($rule);exit;
			$this->assign('rule',$rule);
			$this->assign('result',$result);
			return $this->fetch();
		}
			
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			if(empty($_POST['password'])){
				unset($_POST['password']);
			}else{
				$_POST['password']=md5($_POST['password']);
			}
			if(empty($_POST['mobile'])){
				unset($_POST['mobile']);
			}
			$result=Db::table('ike_admin')
					->where('admin_id',$_POST['admin_id'])
					->update($_POST);
			if($result){
				$this->success('修改成功', '/admin/adminuser/index');
			}else{
				$this->error('修改失败');
			}
		}
		
	}
	
	//密码查询
	public function select()
	{
		if (Request::instance()->isAjax())
		{
			$where['password']=md5($_POST['old_password']);
			$result=Db::table('ike_admin')
						->where($where)
						->field('password')
						->select();
			if($result)
			{
				return 1;
			}else{
				return 0;
			}
		}
	}
	//添加用户
	public function add(){
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			$_POST['gen_time']=date('Y-m-d H:i:s',time());
			//var_dump($_POST);EXIT;
			$_POST['password']=md5($_POST['password']);
			$result=Db::table('ike_admin')->insert($_POST);
			if($result){
				$this->success('添加成功', '/admin/adminuser/index');
			}else{
				$this->error('添加失败');
			}
		}else{
			$group_all=Db::table('ike_admintype')
						->field('groupid,type_name')
						->select();
			foreach($group_all as $k=>$v){
				if($v['groupid']==1){
					unset($group_all[$k]);
				}
			}
			$this->assign('group_all',$group_all);
			return $this->fetch();
		}
	}
	//查询用户是否存在
	public function check_user()
	{
		if (Request::instance()->isAjax())
		{
			$where['admin_name']=$_POST['admin_name'];
			$result=Db::table('ike_admin')
					->where($where)
					->select();
			if($result){
				$this->success('用户以存在');
			}else{
				$this->error('可以注册');
			}
		}
	}
	
	//删除用户
	public function del()
	{
		if(Request::instance()->isGet())
		{
			$result=Db::table('ike_admin')
						->delete($_GET['id']);
			if($result){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
	
	
	
	
	
	
}