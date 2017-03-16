<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Session;
use think\Db;
use think\Request;
use app\admin\model\Appcollects;

class Appcollect extends AdminBase
{
	public $AppCollectModel=null;//保存实例化模型
	public function __construct(){
		parent::__construct();
		$this->AppCollectModel=new Appcollects;
	}
	public function index()
	{
		$AllCollect=$this->AppCollectModel->get_allcollect();
		foreach($AllCollect as $k=>$v)
		{
			if($v['status']==2){
				$AllCollect[$k]['show_status']='等待审核';
			}elseif($v['status']==1)
			{
				$AllCollect[$k]['show_status']='审核通过';
			}else{
				$AllCollect[$k]['show_status']='审核不通过';
			}
			$AllCollect[$k]['content']=mb_substr($v['content'],0,20,'utf-8').'......';
			$AllCollect[$k]['avatar_image']='<img src="'.$v['avatar_image'].'" style="width:40px;height:40px"/>';
		}
		$this->assign('AllCollect',$AllCollect);
		return $this->fetch();
	}
	public function get_collect_info()
	{
		if (Request::instance()->isAjax())
		{
			$collectId=$_POST['collect_id'];
			$result=Db::table('ike_product_collect')
					->where('id',$collectId)
					->select();
			$result=reset($result);
			$userinfo=Db::table('ike_user')
						->where('tu_id',$_POST['tu_id'])
						->select();
			$userinfo=reset($userinfo);
			if($result['status']==2){
				$result['show_status']='等待审核';
			}elseif($result['status']==1)
			{
				$result['show_status']='审核通过';
			}else{
				$result['show_status']='审核不通过';
			}
			$result['nickname']=$userinfo['nickname'];
			$result['address']=$userinfo['address'];
			//$page = $result->render();
			//$result=json_decode($result,true);
			//$result['page']=$page;
			
			if($result){
				$this->success($result);
			}else{
				$this->error();
			}
			
		}
	}
	public function change_stauts()
	{
		if (Request::instance()->isAjax())
		{
			$datas=array();
			if(isset($_POST['reason'])){
				$datas['reason']=$_POST['reason'];
			}
			if($_POST['status']==1){
				$datas['reason']='';
			}
			if($_POST['status']==2){
				$datas['reason']='';
			}
			$datas['status']=$_POST['status'];
			$result=Db::table('ike_product_collect')
					->where('id',$_POST['id'])
					->update($datas);
			if($result)
			{
				return 1;
			}else{
				return 0;
			}
		}
	}
}