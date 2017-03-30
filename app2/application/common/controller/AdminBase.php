<?php
namespace app\common\controller;
use think\Controller;
use think\Request;//验证validate内容
use think\Url;
use think\Db;
use think\Session;
use think\Config;
use think\View;
use think\Loader;

class AdminBase extends Controller
{
	protected $request;
	function __construct()
	{
		parent::__construct();
		/*
		$this->request = Request::instance();
		$this->module_name = Request::instance()->module();//获取当前模板名
		//echo Config::get('USER_AUTH_KEY').'id';
		//var_dump(Session::get(Config::get('USER_AUTH_KEY').'.0.id','login'));exit;
		//var_dump($this->module_name);exit;
		//var_dump(Session::get('verify_time'));exit;
		if($this->module_name=='index'){
			$this->checkAccess();
		}else{
			$this->goLogin();
		}
		*/
		//获取个人用户信息
		$adminModel = Loader::model('LoginUser');		
		$admininfo=$adminModel->admininfo();
		//面包屑
		@$crumbs=$this->before_menus();
		$this->assign('crumbs',$crumbs);
		$this->assign('admininfo',$admininfo);
		//var_dump($this->getMenus());exit;
		$this->assign('__MENUS__',$this->getMenus());

	}
	
	
	/*
     * 表格导入
	 * @author rainfer <81818832@qq.com>
     */
	public function excel_runimport(){
		import("Org.Util.PHPExcel");
		$PHPExcel=new \PHPExcel();
		import("Org.Util.PHPExcel.Reader.Excel5");

		if (! empty ( $_FILES ['file_stu'] ['name'] )){
			$tmp_file = $_FILES ['file_stu'] ['tmp_name'];
			$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
			$file_type = $file_types [count ( $file_types ) - 1];
			/*判别是不是.xls文件，判别是不是excel文件*/
			if (strtolower ( $file_type ) != "xls"){
				$this->error ( '不是Excel文件，重新上传',U('excel_import'),0);
			}
			/*设置上传路径*/
			$savePath = './public/excel/';
			/*以时间来命名上传的文件*/
			$str = time ( 'Ymdhis' );
			$file_name = $str . "." . $file_type;

			if (! copy ( $tmp_file, $savePath . $file_name )){
				$this->error ('上传失败',U('excel_import'),0);
			}

			$res = $this->read ( $savePath . $file_name );
			if (!$res){
				$this->error ('数据处理失败',U('excel_import'),0);
			}
			//spl_autoload_register ( array ('Think', 'autoload' ) );
			foreach ( $res as $k => $v ){
				if ($k != 1){
					$data ['news_title'] = $v[1];
					$data ['news_titleshort'] = $v[2];
					$data ['news_columnid'] = $v[3];
					$data ['news_columnviceid'] = $v[4];
					$data ['news_key'] = $v[5];
					$data ['news_tag'] = $v[6];
					$data ['news_auto'] = $v[7];
					$data ['news_source'] = $v[8];
					$data ['news_content'] = $v[9];
					$data ['news_scontent'] = $v[10];
					$data ['news_hits'] = $v[11];
					$data ['news_img'] = $v[12];
					$data ['news_time'] = $v[13];
					$data ['news_flag'] = $v[14];
					$data ['news_zaddress'] = $v[15];
					$data ['news_back'] = $v[16];
					$data ['news_open'] = $v[17];
					$data ['news_lvtype'] = $v[18];

					$result = M ('news')->add ($data);
					if (!$result){
						$this->error ('导入数据库失败',U('excel_import'),0);
					}
				}
			}
			$this->success ('导入数据库成功',U('excel_import'),1);
		}
	}
	
	protected function _initialize()
	{
		
		//检查登录状态
		$this->checkAccess();
		
		
		//检查访问控制
		$acess=$this->accessControl();
		if($acess==null){
			$model=Request::instance()->module();
			$controller=Request::instance()->controller();		
			$action=Request::instance()->action();
			$rule='/'.$model.'/'.$controller.'/'.$action;
			if(!$this->check_rule($rule)){
				$this->error('请问偷渡，文明上网!');
			}
		}
		$view=new View();
		$v=$this->getMenus();
		//var_dump($v['main']);exit;
	}
	//获取菜单
	final public function getMenus()
	{
		//获取当前模块，控制器，方法
		$model=Request::instance()->module();
		$controller=Request::instance()->controller();		
		$action=Request::instance()->action();
		$rule='/'.$model.'/'.$controller.'/'.$action;
		$rule=strtolower($rule);
		$menus = Session::get('menus');
		if(empty($menus)){
			//获取主菜单
			$where['pid']=0;
			if(!$this->is_admin()){
				$where['status']=1;
			}			
			$menus['main']=Db::table('ike_auth_rule')
							->where($where)
							->order('sort asc')
							->select();
			//$menus['child']=array();//设置子节点
			//当前选中样式
			foreach($menus['main'] as $k=>$v){
				if(strtolower($v['url'])=='/admin/index/index')
				{
					if($rule==strtolower($v['url'])){
						$menus['main'][$k]['class']='active';
					}
					
					continue;
				}
				$menus['main'][$k]['class']='';
				if($rule==strtolower($v['url'])){
					$menus['main'][$k]['class']='';
				}
			}
			
			//获取ulrid
			$userid=$this->userID();
			$groups=$this->getGroups($userid);
			$ids=array();
			foreach($groups as $g){
				$ids=array_merge($ids,explode(',',trim($g['rules'],',')));
			}
			$ids=array_unique($ids);//移除数组中重复的值
			
			if(!$this->is_admin()){
				foreach($menus['main'] as $key=>$value){
					if(!in_array($value['rule_id'],$ids)){
						unset($menus['main'][$key]);
					}
					if(!$this->check_rule($rule)){
						unset($menus['main'][$key]);
					}				
				}
			}
			foreach($menus['main'] as $k=>$v){
				if(strtolower($v['url'])=='/admin/index/index')
				{
					
					continue;
				}
				$menus['main'][$k]['child']='';
				$where['pid']=$v['rule_id'];
				if(!$this->is_admin()){
					$where['status']=1;
				}
				$second_urls=Db::table('ike_auth_rule')
									->where($where)
									->order('sort asc')
									->column('url','rule_id');
				$to_check_urls=array();
				if(!$this->is_admin()){
					//检查子菜单权限
					foreach($second_urls as $key=>$value){
						if(!in_array($key,$ids)){
							unset($second_urls[$key]);
						}
					}
				}
				foreach($second_urls as $key=>$value){
					if($this->is_admin()){
						$to_check_urls[]=$key;
					}
					if($this->check_rule($value)){
						$to_check_urls[]=$key;
					}
				}
				if(isset($to_check_urls)){
					if(empty($to_check_urls)){
						continue;
					}else{
						$map['rule_id']=array('in',$to_check_urls);
					}
				}
				$map['pid']=$v['rule_id'];

				if(!$this->is_admin()){
					$map['status']=1;
				}
				$menusList=Db::table('ike_auth_rule')
								->where($map)
								->order('sort asc')
								->select();
				foreach($menusList as $k1=>$v1){
					$menusList[$k1]['class']='';
					if($rule==strtolower($v1['url'])){
						$menus['main'][$k]['class']='active open';
						$menusList[$k1]['class']='active';
					}
				}
				if(empty($menusList)){
					$menusList='';
				}
				
				$menus['main'][$k]['child']=$menusList;
				if(!empty($menusList)){
					
					foreach($menusList as $k2=>$v2){
						$term['pid']=$v2['rule_id'];
						
						if(!$this->is_admin()){
							$term['status']=1;
							$term['status']=1;
						}
						$m_c_child=Db::table('ike_auth_rule')
									->where($term)
									->column('url','rule_id');
						if(!$this->is_admin()){
							//检查子菜单权限
							foreach($m_c_child as $key=>$value){
								if(!in_array($key,$ids)){
									unset($m_c_child[$key]);
								}
							}
						}
						$to_check_ulr=array();
						foreach($m_c_child as $key=>$value){
							if($this->is_admin()){
								$to_check_ulr[]=$key;
							}
							if($this->check_rule($value)){
								$to_check_ulr[]=$key;
							}
						}
						if(isset($to_check_ulr)){
							if(empty($to_check_ulr)){
								continue;
							}else{
								$c_child['rule_id']=array('in',$to_check_ulr);
							}
						}
						$c_child['pid']=$v2['rule_id'];
						
						if(!$this->is_admin()){
							$c_child['status']=1;
						}
						$menusLists=Db::table('ike_auth_rule')
								->where($c_child)
								->select();
						if(empty($menusList)){
							$menusList='';
						}
						$menus['main'][$k]['child'][$k2]['grandson']=$menusLists;
					}
				}
			}
			Session::set('menus',$menus);
		}else{
			//var_dump($menus['main']);exit;
			foreach($menus['main'] as $k=>$v){
				$menus['main'][$k]['class']='';
				if(strtolower($v['url'])=='/admin/index/index')
				{
					if($rule==strtolower($v['url'])){
						$menus['main'][$k]['class']='active';
					}
					
					continue;
				}
				if($rule==strtolower($v['url'])){
					$menus['main'][$k]['class']='';
				}
				if(!empty($v['child'])){
					foreach($v['child'] as $key=>$value){
						$menus['main'][$k]['child'][$key]['class']='';
						if($rule==strtolower($value['url'])){
							$menus['main'][$k]['class']='active open';
							$menus['main'][$k]['child'][$key]['class']='active';						
						}
						if(!empty($value['grandson'])){
							foreach($value['grandson'] as $k1=>$v1){
								if($rule==strtolower($v1['url'])){
									$menus['main'][$k]['class']='active open';
									$menus['main'][$k]['child'][$key]['class']='active';
								}
							}
							
						}					
					}
					
				}
			
			}
		}
		return $menus;
	}
	//当前面包屑
	public function before_menus()
	{
		//获取当前模块，控制器，方法
		$model=Request::instance()->module();
		$controller=Request::instance()->controller();		
		$action=Request::instance()->action();
		$rule='/'.$model.'/'.$controller.'/'.$action;
		$rule=strtolower($rule);
		$menus=array();
		$result=Db::table('ike_auth_rule')
				->where('url',$rule)
				->select();
		$result=reset($result);
		$menus['own']['title']=$result['title'];
		$menus['own']['url']=$result['url'];
		if($rule!='/admin/index/index')
		{
			$parent=Db::table('ike_auth_rule')
					->where('rule_id',$result['pid'])
					->select();
			$parent=reset($parent);
		}
		
					//proge
		//var_dump($parent);exit;
		if(!empty($parent))
		{
			$progenitor=Db::table('ike_auth_rule')
					->where('rule_id',$parent['pid'])
					->select();
			$menus['parent']['title']=$parent['title'];
			$menus['parent']['url']=$parent['url'];
			$progenitor=reset($progenitor);
			if(!empty($progenitor))
			{
				$menus['progenitor']['title']=$progenitor['title'];
				$menus['progenitor']['url']=$progenitor['url'];
			}	
		}
		$crumbs['one']='';
		$crumbs['one'].='<ul class="breadcrumb">';
		if(!empty($menus['parent'])){
			$crumbs['one'].='	<li>';
			$crumbs['one'].='		<i class="icon-home home-icon"></i>';
			$crumbs['one'].=		$menus['progenitor']['title'];
			$crumbs['one'].='	</li>';		
			$crumbs['one'].='	<li>';
			$crumbs['one'].='<a href="'.$menus['parent']['url'].'">'.$menus['parent']['title'].'</a>';
			$crumbs['one'].='	</li>';
		}
		$crumbs['one'].='		<li class="active">'.$menus['own']['title'].'</li>';
		$crumbs['one'].='</ul>';
		$crumbs['two']='';
		$crumbs['two'].='<div class="page-header">';
		$crumbs['two'].='	<h1>';
		if(!empty($menus['parent'])){
			$crumbs['two'].=		$menus['parent']['title'];
			$crumbs['two'].='		<small>';
			$crumbs['two'].='			<i class="icon-double-angle-right"></i>';
			$crumbs['two'].=				$menus['own']['title'];
			$crumbs['two'].='		</small>';
		}else{
			$crumbs['two'].=				$menus['own']['title'];
		}
		$crumbs['two'].='	</h1>';
		$crumbs['two'].='</div>';
		return $crumbs;	
	}
	
	//判断是否登录
	public function checkAccess()
	{
		$uid=$this->key();
		if(is_null($uid)){
			$this->goLogin();
			return false;
		}
		if(empty($uid)){
			$this->goLogin();
			return false;
		}
	}
	//获取登录用户session  id
	public function key()
	{
		$user=Session::get('loginSession','login');

		if(empty($user)){
			$this->goLogin();
		}
		if(is_null($user)){
			$this->goLogin();
			return false;
		}
		$user=reset($user);//数组的内部指针重置到数组中的第一个元素
		return $user;
	}
	//判断是否为超级管理员
	public function is_admin(){
		$user=Session::get('loginSession','login');
		//$userid=$this->userID();
		//var_dump($user['admin_name']);exit;
		if($user['admin_name']==Config::get('SUPERVISOR')){
			return true;
		}else{
			return false;
		}
	}
	//访问控制
	public function accessControl()
	{
		$is_admin=$this->is_admin();
		//var_dump($is_admin);exit;
		if($is_admin==true){
			return true;
		}
		return null;
	}
	//获取用户id
	public function userID()
	{
		$user=Session::get('loginSession','login');
		if(empty($user)){
			$this->goLogin();
			exit(0);
		}
		//var_dump($user]);exit;
		$userID=reset($user);
		return $userID;
		
	}
	//检查权限
	public function check_rule($rule){
		$userid=$this->userID();
		$rules=$this->authList($userid);
		$is_admin=$this->is_admin();
		if($is_admin==true){
			return true;
		}
		if(!empty($rules)&&in_array(strtolower($rule),$rules)){
			return true;
		}
		return false;
	}
	public function authList($uid)
	{
		$groups=$this->getGroups($uid);
		$ids=array();
		foreach($groups as $g){
			$ids=array_merge($ids,explode(',',trim($g['rules'],',')));
		}
		$ids=array_unique($ids);//移除数组中重复的值
		$map=array(
			'rule_id'=>array('in',$ids),
			'status'=>1,
		);
		//读取用户组所有权限规则
		$rules=Db::table('ike_auth_rule')
					->where($map)
					->field('title,url')
					->select();
		//循环规则，判断结果。
		foreach($rules as $rule)
		{
			$authList[]=strtolower($rule['url']);
		}
		Session::set('rules',$authList);
		return $authList;
	}
	//获取权限列表
	public function getGroups($uid)
	{
		static $groups = array();
		if(isset($groups[$uid]))
		{
			return $groups[$uid];
		}
		$user_groups=Db::table('ike_admin a')
						->where(['a.admin_id'=>$uid])
						->field('g.rules')
						->join('ike_admintype g','a.groupid=g.groupid')
						->select();
		$groups[$uid]=$user_groups?:array();
        return $groups[$uid];
						
	}
	//重定向登录页面
	public function goLogin()
	{
		//session::flush();
		//Session::clear();
		Session::delete('menus');
		Session::delete('loginSession','login');
		$redirect='/admin/login/index';
		$this->redirect(Url::build($redirect));
		return false;
	}
}
