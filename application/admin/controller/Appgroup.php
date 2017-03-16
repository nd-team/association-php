<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Appgroups;

class Appgroup extends AdminBase
{
	public $AppGroupModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->AppGroupModel=new Appgroups;
	}
	public function index()
	{
		$AllGroup=$this->AppGroupModel->get_allGroup();
		foreach($AllGroup as $k=>$v)
		{
			$AllGroup[$k]['avatar_image']='<img src="'.$v['avatar_image'].'" style="width:40px;height:40px"/>';
		}
		
		$this->assign('AllGroup',$AllGroup);
		return $this->fetch();
	}
	public function get_group_users()
	{
		if (Request::instance()->isAjax())
		{
			$groupId=$_POST['group_id'];
			$result=Db::view('group_user')
					 ->view('user','tu_id,nickname,mobile','group_user.tu_id=user.tu_id')
					 ->where('group_id',$groupId)
					 ->paginate(30);
			//$page = $result->render();
			$result=json_decode($result,true);
			unset($result['total']);
			unset($result['per_page']);
			unset($result['current_page']);
			//$result['page']=$page;
			//var_dump($result);exit;
			if($result){
				$this->success($result);
			}else{
				$this->error();
			}
			
		}
	}
	public function edit(){
		if(!empty($_GET['id'])){
			$where['rule_id']=$_GET['id'];
			$result=Db::table('ike_auth_rule')
						->where($where)
						->select();
			$result=reset($result);
			//var_dump($result);exit;
			/*
			foreach($result as $k=>$v){
				//echo $result['status'];exit;
				if($result['status']==1){
					$result['status']='开启';
				}else{
					$result['status']='禁止';
				}
			}*/
			$menus=$this->MenuModel->get_menus();
			foreach($menus['main'] as $k=>$v){
				/*	
				if($v['status']==1){
					$menus['main'][$k]['status']='开启';
					$menus['main'][$k]['bt']='btn-yellow';
				}else{
					$menus['main'][$k]['status']='禁止';
					$menus['main'][$k]['bt']='btn-danger';
				}
				*/
				if(!empty($v['child'])){
					
					foreach($v['child'] as $key=>$value){
						//var_dump($value['title']);exit;
						$menus['main'][$k]['child'][$key]['title']='├─'.$value['title'];
						/*
						if($value['status']==1){
							$menus['main'][$k]['child'][$key]['status']='开启';
							$menus['main'][$k]['child'][$key]['bt']='btn-yellow';
						}else{
							$menus['main'][$k]['child'][$key]['status']='禁止';
							$menus['main'][$k]['child'][$key]['bt']='btn-danger';
						}
						*/
						if(!empty($value['grandson'])){
							//var_dump($v['child'][]);exit;
							foreach($value['grandson'] as $k1=>$v1){
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['title']='├─├─'.$v1['title'];
								/*
								if($v1['status']==1){
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='开启';
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-yellow';
								}else{
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='禁止';
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-danger';
								}
								*/
							}						
						}
					}
				}
			}
			//var_dump($result);exit;
			
			$this->assign('menus',$menus['main']);
			$this->assign('result',$result);
			return $this->fetch();
		}
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			$result=Db::table('ike_auth_rule')
						->update($_POST);
			if($result){
				$this->success('修改成功', '/admin/menus/index');
			}else{
				$this->success('修改失败', '/admin/menus/index');
			}
		}
		
	}
	public function add(){
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			$result=Db::table('ike_auth_rule')->insert($_POST);
			if($result){
				$this->success('添加成功', '/admin/menus/index');
			}else{
				$this->success('添加失败', '/admin/menus/index');
			}
		}else{
			$menus=$this->MenuModel->get_menus();
			foreach($menus['main'] as $k=>$v){
				/*	
				if($v['status']==1){
					$menus['main'][$k]['status']='开启';
					$menus['main'][$k]['bt']='btn-yellow';
				}else{
					$menus['main'][$k]['status']='禁止';
					$menus['main'][$k]['bt']='btn-danger';
				}
				*/
				if(!empty($v['child'])){
					
					foreach($v['child'] as $key=>$value){
						//var_dump($value['title']);exit;
						$menus['main'][$k]['child'][$key]['title']='├─'.$value['title'];
						/*
						if($value['status']==1){
							$menus['main'][$k]['child'][$key]['status']='开启';
							$menus['main'][$k]['child'][$key]['bt']='btn-yellow';
						}else{
							$menus['main'][$k]['child'][$key]['status']='禁止';
							$menus['main'][$k]['child'][$key]['bt']='btn-danger';
						}
						*/
						if(!empty($value['grandson'])){
							//var_dump($v['child'][]);exit;
							foreach($value['grandson'] as $k1=>$v1){
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['title']='├─├─'.$v1['title'];
								/*
								if($v1['status']==1){
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='开启';
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-yellow';
								}else{
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='禁止';
									$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-danger';
								}
								*/
							}						
						}
					}
				}
			}
			$this->assign('menus',$menus['main']);
			return $this->fetch();
		}
	}
}