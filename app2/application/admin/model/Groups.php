<?php
namespace app\admin\model;

use think\Model;
use think\Db;
use think\Session;
use think\Config;
use think\Loader;
use think\Cache;

class Groups extends Model
{
	//获取权限列表
	public function get_admintype(){
		$groups=Db::table('ike_admintype')
					->select();
		//$groups=reset($groups);
		return $groups;
	}
	
	//获取所以菜单栏
	public function get_menus(){
		//获取主菜单
			$where['pid']=0;
			$menus['main']=Db::table('ike_auth_rule')
							->where($where)
							->order('sort asc')
							->select();
			foreach($menus['main'] as $k=>$v){
				$menus['main'][$k]['child']='';
				$where['pid']=$v['rule_id'];
				$second_urls=Db::table('ike_auth_rule')
									->where($where)
									->column('url','rule_id');
				$to_check_urls=array();
				foreach($second_urls as $k1=>$v1){
					$to_check_urls[]=$k1;
				}
				if(isset($to_check_urls)){
					if(empty($to_check_urls)){
						continue;
					}else{
						$map['rule_id']=array('in',$to_check_urls);
					}
				}
				$map['pid']=$v['rule_id'];
				$menusList=Db::table('ike_auth_rule')
								->where($map)
								->select();
				if(empty($menusList)){
					$menusList='';
				}
				
				$menus['main'][$k]['child']=$menusList;
				if(!empty($menusList)){
					
					foreach($menusList as $k2=>$v2){
						$term['pid']=$v2['rule_id'];
						$m_c_child=Db::table('ike_auth_rule')
									->where($term)
									->column('url','rule_id');

						$to_check_ulr=array();
						foreach($m_c_child as $key=>$value){
								$to_check_ulr[]=$key;
						}
						if(isset($to_check_ulr)){
							if(empty($to_check_ulr)){
								continue;
							}else{
								$c_child['rule_id']=array('in',$to_check_ulr);
							}
						}
						$c_child['pid']=$v2['rule_id'];
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
			return $menus;
			
	}
	 
}
?>