<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;
use app\admin\model\Groups;

class Group extends AdminBase
{
	public $GroupModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->GroupModel=new Groups;
	}
	//权限列表
	public function index(){
		$groups=$this->GroupModel->get_admintype();
		foreach($groups as $k=>$v){
			if($v['status']==1){
				$groups[$k]['status']='开启';
				$groups[$k]['st']=1;
				$groups[$k]['bt']='btn-yellow';
			}else{
				$groups[$k]['status']='禁止';
				$groups[$k]['st']=0;
				$groups[$k]['bt']='btn-danger';
			}
		}
		$this->assign('groups',$groups);
		return $this->fetch();
	}
	//ajax修改状态
	public function group_status()
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
			$result=Db::table('ike_admintype')
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
	//规则
	public function access(){
		if(!empty($_GET['id'])){
			$where['groupid']=$_GET['id'];
			$result=Db::table('ike_admintype')
						->where($where)
						->select();
			
			$result=reset($result);
			//var_dump($result['rules']);exit;
			/*$ids=array();
			foreach($result as $g){
				$ids=array_merge($ids,explode(',',trim($g['rules'],',')));
			}
			$ids=array_unique($ids);//移除数组中重复的值*/
			/*
			foreach($result as $k=>$v){
				//echo $result['status'];exit;
				if($result['status']==1){
					$result['status']='开启';
				}else{
					$result['status']='禁止';
				}
			}*/
			$menus=$this->GroupModel->get_menus();
			//var_dump($result);exit;
			
			$this->assign('menus',$menus['main']);
			$this->assign('result',$result);
			return $this->fetch();
		}
		if(!empty($_POST)){
			$groups=$_POST;
			$rules='';
			foreach($groups['rules'] as $k=>$v){
				$rules.=$v.',';
			}
			$where['groupid']=$_POST['groupid'];
			$where['rules']=$rules;
			$result=Db::table('ike_admintype')
						->update($where);
			if($result){
				$this->success('修改成功', '/admin/group/index');
			}else{
				$this->success('修改失败', '/admin/group/index');
			}
		}
		
	}
	//规则修改
	public function edit(){
		if(!empty($_GET['id'])){
			$where['groupid']=$_GET['id'];
			$result=Db::table('ike_admintype')
						->where($where)
						->select();
			$result=reset($result);
			$this->assign('result',$result);
			return $this->fetch();
		}
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			$result=Db::table('ike_admintype')
						->update($_POST);
			//echo Db::getLastSql();exit;
			if($result){
				$this->success('修改成功', '/admin/group/index');
			}else{
				$this->success('修改失败', '/admin/group/index');
			}
			
		}
		
	}
	//规则添加
	public function add(){
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			
			$rules='';
			foreach($_POST['rules'] as $k=>$v){
				$rules.=$v.',';
			}
			$data['type_name']=$_POST['type_name'];
			$data['status']=$_POST['status'];
			$data['rules']=$rules;
			$result=Db::table('ike_admintype')
						->insert($data);
			if($result){
				$this->success('修改成功', '/admin/group/index');
			}else{
				$this->success('修改失败', '/admin/group/index');
			}
		}else{
			$menus=$this->GroupModel->get_menus();
			//var_dump($result);exit;
			
			$this->assign('menus',$menus['main']);
			return $this->fetch();
		}
		
	}
	//规则删除
	public function del()
	{
		if (Request::instance()->isGet())
		{
			$where['groupid']=$_GET['id'];
			$result=Db::table('ike_admintype')
						->where($where)
						->delete();
			if($result){
				$this->success('删除成功', '/admin/group/index');
			}else{
				$this->success('删除失败', '/admin/group/index');
			}
		}
	}
}