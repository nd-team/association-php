<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Loader;
use think\Session;
use think\Config;
use think\Request;

class Index extends AdminBase
{
	private $user_table;
	function __construct()
	{
		parent::__construct();
		$this->user_table=Db::table('ike_admin');
	}

	//------------------------获取磁盘信息------------------------//
		/**

		* 字节格式化 把字节数格式为B K M G T P E Z Y 描述的大小

		* @param int $size 大小

		* @param int $dec 显示类型

		* @return int

		*/

		public	function byte_format($size,$dec=2)

		{

			$a = array("B", "KB", "MB", "GB", "TB", "PB","EB","ZB","YB");

			$pos = 0;

			while ($size >= 1024)   

			{

				$size /= 1024;

				$pos++;

			}

			return round($size,$dec)." ".$a[$pos];

		}

		 

		/**

			* 取得单个磁盘信息

			* @param $letter

			* @return array

			*/

		public function get_disk_space($letter)

		{

			//获取磁盘信息

			$diskct = 0;

			$disk = array();

			/*if(@disk_total_space($key)!=NULL) *为防止影响服务器，不检查软驱

			{

			 $diskct=1;

			 $disk["A"]=round((@disk_free_space($key)/(1024*1024*1024)),2)."G / ".round((@disk_total_space($key)/(1024*1024*1024)),2).'G';

			}*/

			$diskz = 0; //磁盘总容量

			$diskk = 0; //磁盘剩余容量

			

			$is_disk = $letter.':';
			if(@disk_total_space($is_disk)!=NULL)

			{

			 $diskct++;

			 $disk[$letter][0] =$this-> byte_format(@disk_free_space($is_disk));

			 $disk[$letter][1] =$this-> byte_format(@disk_total_space($is_disk));

			 $disk[$letter][2] = round(((@disk_free_space($is_disk)/(1024*1024*1024))/(@disk_total_space($is_disk)/(1024*1024*1024)))*100,2).'%';

			 $diskk+=$this->byte_format(@disk_free_space($is_disk));

			 $diskz+=$this->byte_format(@disk_total_space($is_disk));

			}

			return $disk;

		}

 

		/**

			* 取得磁盘使用情况

			* @return var

			*/

		public function get_spec_disk($type='all')

		{

			$disk = array();

			

			switch ($type)

			{

			 case 'system':

				//strrev(array_pop(explode(':',strrev(getenv_info('SystemRoot')))));//取得系统盘符

				$disk = $this->get_disk_space(strrev(array_pop(explode(':',strrev(getenv('SystemRoot'))))));

				break;

			 case 'all':

				foreach (range('b','z') as $letter)

				{

				 $disk = array_merge($disk,$this->get_disk_space($letter));

				}

				break;

			 default:

				$disk = $this->get_disk_space($type);

				break;

			}

			

			return $disk;

		}
	//---------------------获取磁盘信息结束------------------------------//
    public function index()
    {
		if(@$this->get_spec_disk()){
			//获取磁盘大小
			$this->assign('disk',$this->get_spec_disk());
		}
		//$a=PHP_OS;
		//var_dump(round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M');  // linux
		//var_dump(get_spec_disk());exit;
		//获取管理员个人用户信息
		$adminModel = Loader::model('LoginUser');		
		$admininfo=$adminModel->admininfo();
		
		//echo Db::getLastSql();exit;
		//获取日志
		$loginlog=Db::table('ike_loginlog')->order('id_log desc')->select();
		//获取管理员用户总人数
		$admin_count=Db::table('ike_admin')->count();
		//获取会员用户总人数
		$count=Db::table('ike_user')->count();
		//获取昨日新增会员用户
		$yesdata_count=Db::table('ike_user')->where('gen_time','between',date('Y-m-d 00:00:00',strtotime('-1 day')).','.date('Y-m-d 23:59:59',strtotime('-1 day')))->count();
		//var_dump($count);exit;
		//echo Db::getLastSql();exit;
		
		//获取会员性别男 人数和百分比
		$user_sex_m=array();
		$user_sex_m['m']=Db::table('ike_user')->where('sex',1)->count();
		$user_sex_m['m_percent']=round(($user_sex_m['m']/$count)*100,2);
		//获取会员性别女人数和百分比
		$user_sex_g=array();
		$user_sex_g['g']=Db::table('ike_user')->where('sex',2)->count();
		$user_sex_g['g_percent']=round(($user_sex_g['g']/$count)*100,2);
		//获取会员性别未知人数和百分比
		$user_sex_u=array();
		$user_sex_u['u']=Db::table('ike_user')->where('sex',0)->count();
		$user_sex_u['u_percent']=round(($user_sex_u['u']/$count)*100,2);
		$log_size = 0;
        $log_file_cnt = 0;
        foreach (list_file(LOG_PATH) as $f) {
            if ($f ['isDir']) {
                foreach (list_file($f ['pathname'] . '/', '*.log') as $ff) {
                    if ($ff ['isFile']) {
                        $log_size += $ff ['size'];
                        $log_file_cnt++;
                    }
                }
            }
        }
		$this->assign('log_size',$log_size);
		$this->assign('log_file_cnt',$log_file_cnt);
		$this->assign('user_sex_m',$user_sex_m);
		$this->assign('loginlog',$loginlog);
		$this->assign('user_sex_g',$user_sex_g);
		$this->assign('user_sex_u',$user_sex_u);
		$this->assign('admininfo',$admininfo);
		$this->assign('count',$count);
		$this->assign('admin_count',$admin_count);
		$this->assign('yesdata_count',$yesdata_count);
		return $this->fetch();
    }
	
	
	public function maintain()
	{
		$action=Request::instance()->get('action','','htmlspecialchars'); 
		switch($action){
			case 'trace_on' :    //打开 Trace调试	
				$data = array('app_Trace' =>  true);
				$res=sys_config_setbyarr($data);
				if($res === false){
					$this->error('打开Trace失败','Index/index');
				}else{
					$this->success('已打开Trace','Index/index');
				}
                break;
			case 'trace_off' :   //关闭 Trace调试	
				$data = array('app_Trace'=>false);
				$res=sys_config_setbyarr($data);
				if($res === false){
					$this->error('关闭Trace失败','Index/index');
				}else{
					$this->success('已关闭Trace','Index/index');
				}
                break;
			case 'download_log' :
			case 'view_log':   //查看日志
				$logs = array();
				$list=list_file(LOG_PATH);
				rsort($list);
                foreach ($list as $f) {
                    if ($f ['isDir']) {
						$file=list_file($f ['pathname'] . '/', '*.log');
						rsort($file);
                        foreach ($file as $ff) {
                            if ($ff ['isFile']) {
                                $spliter = '========================================================================';
                                $logs [] = $spliter . '  ' . $f ['filename'] . '/' . $ff ['filename'] . '  ' . $spliter . "\n\n" . file_get_contents($ff ['pathname']);
                            }
                        }
                    }
                }
                if ('download_log' == $action) {
                    force_download_content('log_' . date('Ymd_His') . '.log', join("\n\n\n\n", $logs));
                } else {
					//var_dump($logs);exit;
				//	foreach($logs as $v)
				//	{
						 echo '<pre>' . htmlspecialchars(join("\n\n\n\n", $logs)) . '</pre>';
				//	}
                   
                }
                break;
			case 'clear_log' :
				remove_dir(LOG_PATH);
				$this->success ('清除日志成功');                
                break;	
		} 
	}
	
	
}





