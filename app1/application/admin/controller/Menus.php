<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Menu;

class Menus extends AdminBase
{
	public $MenuModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->MenuModel=new Menu;
	}
	public function index()
	{
		if(!ini_get('output_buffering')){  
			ob_start();  
		} 
		//$file='./runtime/cache/menu';
		//if(!file_exists($file.'/index.html')){
		//	mkdir($file,0777);
		
		$menus=$this->MenuModel->get_menus();
		
		foreach($menus['main'] as $k=>$v){
			if($v['status']==1){
				$menus['main'][$k]['status']='开启';
				$menus['main'][$k]['st']=1;
				$menus['main'][$k]['bt']='btn-yellow';
			}else{
				$menus['main'][$k]['status']='禁止';
				$menus['main'][$k]['st']=0;
				$menus['main'][$k]['bt']='btn-danger';
			}
			if(!empty($v['child'])){
				
				foreach($v['child'] as $key=>$value){
					$menus['main'][$k]['child'][$key]['title']='├─'.$value['title'];
					if($value['status']==1){
						$menus['main'][$k]['child'][$key]['status']='开启';
						$menus['main'][$k]['child'][$key]['st']=1;
						$menus['main'][$k]['child'][$key]['bt']='btn-yellow';
					}else{
						$menus['main'][$k]['child'][$key]['status']='禁止';
						$menus['main'][$k]['child'][$key]['st']=0;
						$menus['main'][$k]['child'][$key]['bt']='btn-danger';
					}
					
					if(!empty($value['grandson'])){
						foreach($value['grandson'] as $k1=>$v1){
							$menus['main'][$k]['child'][$key]['grandson'][$k1]['title']='├─├─'.$v1['title'];
							if($v1['status']==1){
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='开启';
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['st']=1;
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-yellow';
							}else{
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['status']='禁止';
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['st']=0;
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['bt']='btn-danger';
							}
						}						
					}
				}
			}
		}
		$this->assign('menus',$menus['main']);
		
		echo $this->fetch();
		//$content = ob_get_contents(); 
		//file_put_contents($file."/index.html",$content); 
		/*}else{
			echo file_get_contents($file.'/index.html');
		}*/
		
	}
	public function menus_status()
	{
		if (Request::instance()->isAjax())
		{
			$where['rule_id']=$_POST['id'];
			if($_POST['status']==1){
				$update['status']=0;
				$data='error';
			}else{
				$update['status']=1;
				$data='ok';
			}
			$result=Db::table('ike_auth_rule')
					->where($where)
					->select();
			$result=reset($result);
			if($result['pid']==0)
			{
				$son=Db::table('ike_auth_rule')
						->where('pid',$result['rule_id'])
						->select();
				if($son)
				{
					foreach($son as $k1=>$v1)
					{
						Db::table('ike_auth_rule')
							->where('rule_id',$v1['rule_id'])
							->update($update);
						$child=Db::table('ike_auth_rule')
								->where('pid',$v1['rule_id'])
								->select();
						if($child)
						{
							foreach($child as $k=>$v)
							{
								Db::table('ike_auth_rule')
									->where('rule_id',$v['rule_id'])
									->update($update);
							}
							
						}
					}
				}
				$spon_update=Db::table('ike_auth_rule')
					->where($where)
					->update($update);
				//echo Db::getLastSql();exit;
				if($spon_update){
					Session::delete('menus');
					$this->success($data);
				}
			}else{
				$parent=Db::table('ike_auth_rule')
							->where('rule_id',$result['pid'])
							->select();
				$parent=reset($parent);
				if($parent['status']==0){
					$this->error('无法修改,父级菜单已禁止');
				}else{
					$child_all=Db::table('ike_auth_rule')
								->where('pid',$result['rule_id'])
								->select();
					if($child_all){
						foreach($child_all as $k2=>$v2){
							Db::table('ike_auth_rule')
								->where('rule_id',$v2['rule_id'])
								->update($update);
						}
					}
					$update=Db::table('ike_auth_rule')
						->where($where)
						->update($update);
					//echo Db::getLastSql();exit;
					if($update){
						Session::delete('menus');
						$this->success($data);
					}else{
						$this->error('修改失败');
					}
				}
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
			$menus=$this->MenuModel->get_menus();
			foreach($menus['main'] as $k=>$v){
				if(!empty($v['child'])){
					
					foreach($v['child'] as $key=>$value){
						$menus['main'][$k]['child'][$key]['title']='├─'.$value['title'];
						if(!empty($value['grandson'])){
							foreach($value['grandson'] as $k1=>$v1){
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['title']='├─├─'.$v1['title'];
							}						
						}
					}
				}
			}
			$this->assign('menus',$menus['main']);
			$this->assign('result',$result);
			return $this->fetch();
		}
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			$rs=Db::table('ike_auth_rule')
					->where('rule_id',$_POST['rule_id'])
					->select();
			
			$rs=reset($rs);
			if($rs['pid']!=0)
			{
				$sup=Db::table('ike_auth_rule')
					->where('rule_id',$rs['pid'])
					->select();
				$sup=reset($sup);
				if($sup['status']==0){
					$this->success('无法修改,父级菜单已禁止', '/admin/menus/index');
				}
			}
				$rule=Db::table('ike_auth_rule')
						->where('pid',$_POST['rule_id'])
						->select();
				
				$update['status']=$_POST['status'];
				if(!empty($rule)){	
					foreach($rule as $k=>$v){
						Db::table('ike_auth_rule')
								->where('pid',$_POST['rule_id'])
								->update($update);
						//echo Db::getLastSql();exit;	
						$sub=Db::table('ike_auth_rule')
							->where('pid',$v['rule_id'])
							->select();
						if(!empty($sub)){
							foreach($sub as $k1=>$v1){
								Db::table('ike_auth_rule')
									->where('rule_id',$v1['rule_id'])
									->update($update);
							}
						}
					}
				}
				$result=Db::table('ike_auth_rule')
							->update($_POST);
				if($result){
					Session::delete('menus');
					$this->success('修改成功', '/admin/menus/index');
				}else{
					$this->error('修改失败');
				}
			
		}
		
	}
	public function add(){
		if(!empty($_POST)){
			if(!isset($_POST['status'])){
				$_POST['status']='0';
			}
			if(empty($_POST['url']))
			{
				$this->error('url不能为空');
				return false;
			}
			if(empty($_POST['title']))
			{
				$this->error('菜单标题不能为空');
				return false;
			}
			$result=Db::table('ike_auth_rule')->insert($_POST);
			if($result){
				Session::delete('menus');
				$this->success('添加成功', '/admin/menus/index');
			}else{
				$this->error('添加失败');
			}
		}else{
			$menus=$this->MenuModel->get_menus();
			foreach($menus['main'] as $k=>$v){
				if(!empty($v['child'])){
					
					foreach($v['child'] as $key=>$value){
						$menus['main'][$k]['child'][$key]['title']='├─'.$value['title'];
						if(!empty($value['grandson'])){
							foreach($value['grandson'] as $k1=>$v1){
								$menus['main'][$k]['child'][$key]['grandson'][$k1]['title']='├─├─'.$v1['title'];
							}						
						}
					}
				}
			}
			$this->assign('menus',$menus['main']);
			return $this->fetch();
		}
	}
	public function del()
	{
		if (Request::instance()->isGet()) 
		{
			$where['rule_id']=$_GET['id'];
			$result=Db::table('ike_auth_rule')
						->where($where)
						->delete();
			if($result){
				Session::delete('menus');
				$this->success('删除成功','/admin/menus/index');
			}else{
				$this->error('删除失败');
			}
		}
	}
}