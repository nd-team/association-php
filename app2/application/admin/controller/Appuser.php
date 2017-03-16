<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Appusers;

class Appuser extends AdminBase
{
	public $AppuserModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->AppuserModel=new Appusers;
	}
	public function index()
	{
		$AllUser=$this->AppuserModel->get_alluser();
		$AllUsers=json_decode($AllUser['all'],true);
		
		foreach($AllUsers['data'] as $k=>$v){
			if($v['status']==1)
			{
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
	public function other_info()
	{
		if (Request::instance()->isAjax())
		{
			$where['tu_id']=$_POST['userid'];
			$datas['collect']=Db::table('ike_product_collect')
								->where($where)
								->count();
			$datas['group']=Db::table('ike_group_user')
								->where($where)
								->count();
			$datas['friends']=Db::table('ike_friends_user')
								->where($where)
								->count();
			$datas['recommend']=Db::table('ike_recommend_content')
								->where($where)
								->count();
			$more_info=array();
			$more_info=Db::table('ike_more_userinfo')
								->where($where)
								->field('QQ,favour,constellation,bloodType')
								->select();
			if($more_info){
				$more_info=reset($more_info);
				if(empty($more_info['QQ'])){
					$more_info['QQ']='无';
				}
				if(empty($more_info['favour'])){
					$more_info['favour']='无';
				}
				if(empty($more_info['constellation'])){
					$more_info['constellation']='无';
				}
				if(empty($more_info['bloodType'])){
					$more_info['bloodType']='无';
				}
			}else{
				$more_info['QQ']='无';
				$more_info['favour']='无';
				$more_info['constellation']='无';
				$more_info['bloodType']='无';
			}
			$datas['more_info']=$more_info;
			return $datas;
		}
	}
	public function app_status()
	{
		if (Request::instance()->isAjax())
		{
			$event = controller('appapi/App');
			
			$where['tu_id']=$_POST['id'];
			$userinfo=Db::table('ike_user')
						->where($where)
						->select();
			if($_POST['status']==1)
			{
				$update['status']=0;
				$data='error';
				$st=$event->disable($userinfo[0]['tu_id']);
				if($st['code']==200)
				{
					$result=Db::table('ike_user')
							->where($where)
							->update($update);
				}else{
					$this->error($data);
				}
				
			}else{
				$update['status']=1;
				$data='ok';
				$st=$event->unDisable($userinfo[0]['tu_id']);
				if($st['code']==200)
				{
					$result=Db::table('ike_user')
							->where($where)
							->update($update);
				}else{
					$this->error($data);
				}
			}
			
			if($result)
			{
				$this->success($data);
			}else{
				$this->error($data);
			}
		}
	}
	public function edit(){
		if(!empty($_GET['id'])){
			$where['tu_id']=$_GET['id'];
			$result=Db::table('ike_user')
						->where($where)
						->select();
			$result=reset($result);
			$this->assign('result',$result);
			return $this->fetch();
		}
		if(!empty($_POST)){
			$event = controller('appapi/App');
			if(!isset($_POST['status'])){
				$_POST['status']='0';
				$st=$event->disable($_POST['tu_id']);				
				if($st['code']!=200)
				{
					$this->error('修改失败', '/admin/appuser/index');
				}
			}else{
				$st=$event->unDisable($_POST['tu_id']);	
				if($st['code']!=200)
				{
					$this->error('修改失败', '/admin/appuser/index');
				}
			}
			$tu_id=$_POST['tu_id'];
			unset($_POST['tu_id']);
			$result=Db::table('ike_user')
					->where('tu_id',$tu_id)
					->update($_POST);
			if($result){
				$this->success('修改成功', '/admin/appuser/index');
			}else{
				$this->error('修改失败/提交数据一样', '/admin/appuser/index');
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